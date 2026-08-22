<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\District;
use App\Models\Agent;
use App\Models\PropertyImage;
use App\Models\PropertyFacility;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    // ==========================================
    // Public Facing Methods (From Stash)
    // ==========================================
    public function index(Request $request): View
    {
        $query = Property::with(['city', 'agent', 'images', 'propertyType', 'category'])
            ->visible();

        // ─── Filters ──────────────────────────────────────────────────────────────
        if ($request->filled('transaction')) {
            $query->where('transaction_type', $request->transaction);
        }

        if ($request->filled('type')) {
            $query->whereHas('propertyType', fn($q) => $q->where('slug', $request->type));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('city')) {
            $query->whereHas('city', fn($q) => $q->where('slug', $request->city));
        }

        if ($request->filled('district')) {
            $query->whereHas('district', fn($q) => $q->where('slug', $request->district));
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) str_replace(['.', ','], ['', '.'], $request->min_price));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) str_replace(['.', ','], ['', '.'], $request->max_price));
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
        }

        if ($request->filled('min_land_area')) {
            $query->where('land_area', '>=', (float) $request->min_land_area);
        }

        if ($request->filled('max_land_area')) {
            $query->where('land_area', '<=', (float) $request->max_land_area);
        }

        // ─── Sorting ──────────────────────────────────────────────────────────────
        // Properti sold/rented selalu di akhir, lalu urut berdasarkan pilihan user
        $sort = $request->sort ?? 'latest';
        $query->orderByRaw("CASE WHEN status IN ('sold','rented') THEN 1 ELSE 0 END ASC");
        match($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'popular'    => $query->orderByDesc('views'),
            default      => $query->latest('published_at'),
        };

        $properties = $query->paginate(12)->withQueryString();

        $categories    = Category::where('is_active', true)->orderBy('sort_order')->get();
        $propertyTypes = PropertyType::where('is_active', true)->orderBy('sort_order')->get();
        $cities        = City::with(['districts' => function($q) {
            $q->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        return view('properties.index', compact('properties', 'categories', 'propertyTypes', 'cities'));
    }

    public function show(string $slug): View
    {
        $property = Property::with([
            'agent', 'category', 'propertyType', 'city', 'district', 'area',
            'images', 'facilities', 'province'
        ])->where('slug', $slug)->visible()->firstOrFail();

        // Increment views
        $property->increment('views');

        // Related properties
        $related = Property::with(['city', 'images'])
            ->visible()
            ->where('id', '!=', $property->id)
            ->where('status', '!=', 'sold')
            ->where(function ($q) use ($property) {
                $q->where('city_id', $property->city_id)
                  ->orWhere('category_id', $property->category_id);
            })
            ->take(4)
            ->get();

        return view('properties.show', compact('property', 'related'));
    }

    public function submitInquiry(Request $request, string $slug): RedirectResponse
    {
        $property = Property::where('slug', $slug)->visible()->firstOrFail();

        // Tidak bisa inquiry ke properti yang sudah sold/rented
        if (in_array($property->status, ['sold', 'rented'])) {
            return back()->with('error', 'Properti ini sudah tidak tersedia untuk inquiry.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'message'  => 'nullable|string|max:1000',
        ]);

        Inquiry::create([
            'property_id' => $property->id,
            'agent_id'    => $property->agent_id,
            'name'        => $validated['name'],
            'email'       => $validated['email'] ?? null,
            'whatsapp'    => $validated['whatsapp'],
            'message'     => $validated['message'] ?? null,
            'subject'     => 'Inquiry: ' . $property->title,
            'status'      => 'new',
            'source'      => 'website',
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Agen kami akan segera menghubungi Anda.');
    }

    // ==========================================
    // Dashboard Admin CRUD Methods
    // ==========================================

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories    = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $propertyTypes = PropertyType::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $cities        = City::where('is_active', true)->orderBy('name')->get();
        $districts     = District::where('is_active', true)->orderBy('name')->get();
        $agents        = Agent::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.create', compact('categories', 'propertyTypes', 'cities', 'districts', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'property_id_code'   => 'nullable|string|max:50',
            'category_id'        => 'nullable|exists:categories,id',
            'property_type_id'   => 'nullable|exists:property_types,id',
            'agent_id'           => 'nullable|exists:agents,id',
            'transaction_type'   => 'required|in:dijual,disewa',
            'price'              => 'nullable|numeric|min:0',
            'price_rent_monthly' => 'nullable|numeric|min:0',
            'price_note'         => 'nullable|string|max:255',
            'land_area'          => 'nullable|numeric|min:0',
            'building_area'      => 'nullable|numeric|min:0',
            'bedrooms'           => 'nullable|integer|min:0',
            'bathrooms'          => 'nullable|integer|min:0',
            'garage'             => 'nullable|integer|min:0',
            'floors'             => 'nullable|integer|min:0',
            'certificate'        => 'nullable|string|max:100',
            'year_built'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'electric_power'     => 'nullable|string|max:50',
            'city_id'            => 'nullable|exists:cities,id',
            'district_id'        => 'nullable|exists:districts,id',
            'address'            => 'required|string|max:500',
            'google_maps_link'   => 'nullable|url|max:2048',
            'short_description'  => 'nullable|string|max:500',
            'description'        => 'nullable|string',
            'status'             => 'required|in:published,draft,pending,featured,sold,rented',
            'is_featured'        => 'nullable|boolean',
            'thumbnail'          => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images.*'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities'         => 'nullable|array',
            'facilities.*'       => 'string|max:100',
        ], [
            'title.required'     => 'Nama properti wajib diisi.',
            'title.max'          => 'Nama properti maksimal 255 karakter.',
            'address.required'   => 'Alamat wajib diisi.',
            'thumbnail.required' => 'Foto utama wajib diunggah.',
            'thumbnail.max'      => 'Ukuran foto utama maksimal 5MB.',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('properties', 'public');

        $slug = Str::slug($validated['title']) . '-' . Str::random(5);
        $code = !empty($validated['property_id_code']) ? $validated['property_id_code'] : 'PROP-' . rand(100, 999);

        $property = Property::create([
            'title'              => $validated['title'],
            'slug'               => $slug,
            'property_id_code'   => $code,
            'category_id'        => $validated['category_id'] ?? null,
            'property_type_id'   => $validated['property_type_id'] ?? null,
            'agent_id'           => $validated['agent_id'] ?? null,
            'city_id'            => $validated['city_id'] ?? null,
            'district_id'        => $validated['district_id'] ?? null,
            'transaction_type'   => $validated['transaction_type'],
            'price'              => $validated['price'] ?? null,
            'price_rent_monthly' => $validated['price_rent_monthly'] ?? null,
            'price_note'         => $validated['price_note'] ?? null,
            'land_area'          => $validated['land_area'] ?? null,
            'building_area'      => $validated['building_area'] ?? null,
            'bedrooms'           => $validated['bedrooms'] ?? null,
            'bathrooms'          => $validated['bathrooms'] ?? null,
            'garage'             => $validated['garage'] ?? null,
            'floors'             => $validated['floors'] ?? null,
            'certificate'        => $validated['certificate'] ?? null,
            'year_built'         => $validated['year_built'] ?? null,
            'electric_power'     => $validated['electric_power'] ?? null,
            'address'            => $validated['address'],
            'google_maps_link'   => $validated['google_maps_link'] ?? null,
            'short_description'  => $validated['short_description'] ?? null,
            'description'        => $validated['description'] ?? null,
            'thumbnail'          => $thumbnailPath,
            'status'             => $validated['status'],
            'is_featured'        => $request->has('is_featured'),
            'published_at'       => $validated['status'] === 'published' ? now() : null,
        ]);

        // Gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $file) {
                $path = $file->store('properties/gallery', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url'   => $path,
                    'alt_text'    => $property->title,
                    'sort_order'  => $idx + 1,
                    'is_primary'  => false,
                ]);
            }
        }

        // Facilities
        if (!empty($validated['facilities'])) {
            foreach ($validated['facilities'] as $facilityName) {
                PropertyFacility::create([
                    'property_id' => $property->id,
                    'name'        => $facilityName,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Properti berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property): View
    {
        $property->load(['images', 'facilities']);

        $categories    = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $propertyTypes = PropertyType::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $cities        = City::where('is_active', true)->orderBy('name')->get();
        $districts     = District::where('is_active', true)->orderBy('name')->get();
        $agents        = Agent::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.edit', compact('property', 'categories', 'propertyTypes', 'cities', 'districts', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'property_id_code'   => 'nullable|string|max:50',
            'category_id'        => 'nullable|exists:categories,id',
            'property_type_id'   => 'nullable|exists:property_types,id',
            'agent_id'           => 'nullable|exists:agents,id',
            'transaction_type'   => 'required|in:dijual,disewa',
            'price'              => 'nullable|numeric|min:0',
            'price_rent_monthly' => 'nullable|numeric|min:0',
            'price_note'         => 'nullable|string|max:255',
            'land_area'          => 'nullable|numeric|min:0',
            'building_area'      => 'nullable|numeric|min:0',
            'bedrooms'           => 'nullable|integer|min:0',
            'bathrooms'          => 'nullable|integer|min:0',
            'garage'             => 'nullable|integer|min:0',
            'floors'             => 'nullable|integer|min:0',
            'certificate'        => 'nullable|string|max:100',
            'year_built'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'electric_power'     => 'nullable|string|max:50',
            'city_id'            => 'nullable|exists:cities,id',
            'district_id'        => 'nullable|exists:districts,id',
            'address'            => 'required|string|max:500',
            'google_maps_link'   => 'nullable|url|max:2048',
            'short_description'  => 'nullable|string|max:500',
            'description'        => 'nullable|string',
            'status'             => 'required|in:published,draft,pending,featured,sold,rented',
            'is_featured'        => 'nullable|boolean',
            'thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images.*'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'facilities'         => 'nullable|array',
            'facilities.*'       => 'string|max:100',
        ], [
            'title.required'   => 'Nama properti wajib diisi.',
            'title.max'        => 'Nama properti maksimal 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'thumbnail.max'    => 'Ukuran foto utama maksimal 5MB.',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($property->thumbnail && !str_starts_with($property->thumbnail, 'http')) {
                Storage::disk('public')->delete($property->thumbnail);
            }
            $property->thumbnail = $request->file('thumbnail')->store('properties', 'public');
        }

        $property->update([
            'title'              => $validated['title'],
            'property_id_code'   => $validated['property_id_code'] ?? $property->property_id_code,
            'category_id'        => $validated['category_id'] ?? null,
            'property_type_id'   => $validated['property_type_id'] ?? null,
            'agent_id'           => $validated['agent_id'] ?? null,
            'city_id'            => $validated['city_id'] ?? null,
            'district_id'        => $validated['district_id'] ?? null,
            'transaction_type'   => $validated['transaction_type'],
            'price'              => $validated['price'] ?? null,
            'price_rent_monthly' => $validated['price_rent_monthly'] ?? null,
            'price_note'         => $validated['price_note'] ?? null,
            'land_area'          => $validated['land_area'] ?? null,
            'building_area'      => $validated['building_area'] ?? null,
            'bedrooms'           => $validated['bedrooms'] ?? null,
            'bathrooms'          => $validated['bathrooms'] ?? null,
            'garage'             => $validated['garage'] ?? null,
            'floors'             => $validated['floors'] ?? null,
            'certificate'        => $validated['certificate'] ?? null,
            'year_built'         => $validated['year_built'] ?? null,
            'electric_power'     => $validated['electric_power'] ?? null,
            'address'            => $validated['address'],
            'google_maps_link'   => $validated['google_maps_link'] ?? null,
            'short_description'  => $validated['short_description'] ?? null,
            'description'        => $validated['description'] ?? null,
            'status'             => $validated['status'],
            'is_featured'        => $request->has('is_featured'),
        ]);

        // Upload additional gallery images
        if ($request->hasFile('gallery_images')) {
            $lastOrder = $property->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery_images') as $idx => $file) {
                $path = $file->store('properties/gallery', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url'   => $path,
                    'alt_text'    => $property->title,
                    'sort_order'  => $lastOrder + $idx + 1,
                    'is_primary'  => false,
                ]);
            }
        }

        // Delete selected gallery images
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            $imagesToDelete = PropertyImage::where('property_id', $property->id)
                ->whereIn('id', $request->delete_images)
                ->get();

            foreach ($imagesToDelete as $img) {
                if ($img->image_url && !str_starts_with($img->image_url, 'http')) {
                    Storage::disk('public')->delete($img->image_url);
                }
                $img->delete();
            }
        }

        // Sync facilities
        $property->facilities()->delete();
        if (!empty($validated['facilities'])) {
            foreach ($validated['facilities'] as $facilityName) {
                PropertyFacility::create([
                    'property_id' => $property->id,
                    'name'        => $facilityName,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Properti berhasil diperbarui!');
    }

    /**
     * Remove individual gallery image.
     */
    public function destroyImage(PropertyImage $image): RedirectResponse
    {
        if ($image->image_url && !str_starts_with($image->image_url, 'http')) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        if ($property->thumbnail && !str_starts_with($property->thumbnail, 'http')) {
            Storage::disk('public')->delete($property->thumbnail);
        }
        foreach ($property->images as $img) {
            if ($img->image_url && !str_starts_with($img->image_url, 'http')) {
                Storage::disk('public')->delete($img->image_url);
            }
        }
        $property->facilities()->delete();
        $property->images()->delete();
        $property->delete();

        return redirect()->route('dashboard')->with('success', 'Properti berhasil dihapus!');
    }
}

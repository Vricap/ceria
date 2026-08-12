<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\District;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    // ==========================================
    // Public Facing Methods (From Stash)
    // ==========================================
    public function index(Request $request): View
    {
        $query = Property::with(['city', 'agent', 'images', 'propertyType', 'category'])
            ->published()
            ->latest('published_at');

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
        $sort = $request->sort ?? 'latest';
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
        ])->where('slug', $slug)->published()->firstOrFail();

        // Increment views
        $property->increment('views');

        // Related properties
        $related = Property::with(['city', 'images'])
            ->published()
            ->where('id', '!=', $property->id)
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
        $property = Property::where('slug', $slug)->published()->firstOrFail();

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
    // Dashboard Admin CRUD Methods (From Upstream)
    // ==========================================

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: BUG. return php file upload error 7 if image size bigger than 800kb
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
        'title.max' => 'Nama terlalu panjang.',
        'address.max' => 'Alamat terlalu panjang.',
        'thumbnail.max' => 'Ukuran gambar terlalu besar.',
        ]);

        $path = $request->file('thumbnail')->store('properties', 'public');

        Property::create([
            'title' => $request->input('title'),
            'address' => $request->input('address'),
            'thumbnail' => $path,
            'slug' => \Illuminate\Support\Str::slug($request->input('title')) . '-' . uniqid(), // Auto generate slug so it doesn't fail
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view("properties.edit", ['property' => $property]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ], [
        'title.max' => 'Nama terlalu panjang.',
        'address.max' => 'Alamat terlalu panjang.',
        ]);

        if($request->file("thumbnail")) {
            $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
            'thumbnail.max' => 'Ukuran gambar terlalu besar.',
            ]);

            if ($property->thumbnail) {
                Storage::disk('public')->delete($property->thumbnail);
            }
        }

        $property->update([
            'title' => $request->input("title"),
            'address' => $request->input("address"),
        ]);

        if ($request->file("thumbnail")) {
            $path = $request->file('thumbnail')->store('properties', 'public');
            $property->update([
                'thumbnail' => $path,
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if ($property->thumbnail) {
            Storage::disk('public')->delete($property->thumbnail);
        }
        $property->delete();

        return redirect()->route('dashboard');
    }
}

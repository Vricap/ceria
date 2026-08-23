<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of property types.
     */
    public function index(Request $request): View
    {
        $query = PropertyType::withCount('properties');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $propertyTypes = $query->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('dashboard.property-types', compact('propertyTypes'));
    }

    /**
     * Store a newly created property type.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:property_types,name',
        ], [
            'name.required' => 'Nama tipe properti wajib diisi.',
            'name.max'      => 'Nama tipe properti maksimal 100 karakter.',
            'name.unique'   => 'Tipe properti dengan nama tersebut sudah ada.',
        ]);

        $slug = Str::slug($validated['name']);
        if (PropertyType::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        PropertyType::create([
            'name'       => $validated['name'],
            'slug'       => $slug,
            'is_active'  => true,
            'sort_order' => (PropertyType::max('sort_order') ?? 0) + 1,
        ]);

        return redirect()->route('dashboard.property-types')->with('success', 'Tipe properti berhasil ditambahkan!');
    }

    /**
     * Update the specified property type.
     */
    public function update(Request $request, PropertyType $propertyType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:property_types,name,' . $propertyType->id,
        ], [
            'name.required' => 'Nama tipe properti wajib diisi.',
            'name.max'      => 'Nama tipe properti maksimal 100 karakter.',
            'name.unique'   => 'Tipe properti dengan nama tersebut sudah ada.',
        ]);

        $propertyType->update([
            'name'      => $validated['name'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.property-types')->with('success', 'Tipe properti berhasil diperbarui!');
    }

    /**
     * Remove the specified property type.
     */
    public function destroy(PropertyType $propertyType): RedirectResponse
    {
        if ($propertyType->properties()->exists()) {
            $count = $propertyType->properties()->count();

            return back()->with('error', "Tipe \"{$propertyType->name}\" tidak dapat dihapus karena masih dipakai oleh {$count} properti.");
        }

        $propertyType->delete();

        return redirect()->route('dashboard.property-types')->with('success', 'Tipe properti berhasil dihapus!');
    }
}

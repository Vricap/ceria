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
    public function index(): View
    {
        $propertyTypes = PropertyType::withCount('properties')
            ->orderBy('sort_order')
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
        'nama.max' => 'Nama terlalu panjang.',
        'alamat.max' => 'Alamat terlalu panjang.',
        'gambar.max' => 'Ukuran gambar terlalu besar.',
        ]);

        $path = $request->file('gambar')->store('properties', 'public');

        Property::create([
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'gambar' => $path,
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $prop = Property::find($property->id);
        return view("properties.show", ['property' => $prop]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ], [
        'nama.max' => 'Nama terlalu panjang.',
        'alamat.max' => 'Alamat terlalu panjang.',
        ]);

        if($request->file("gambar")) {
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
            'gambar.max' => 'Ukuran gambar terlalu besar.',
            ]);

            Storage::disk('public')->delete($property->gambar);
        }

        $property->update([
            'nama' => $request->input("nama"),
            'alamat' => $request->input("alamat"),
        ]);

        if ($request->file("gambar")) {
            $path = $request->file('gambar')->store('properties', 'public');
            $property->update([
                'gambar' => $path,
            ]);
        }

        return redirect()->route('properties.show', $property->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        Storage::disk('public')->delete($property->gambar);
        $property->delete();

        return redirect()->route('dashboard');
    }
}

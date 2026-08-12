<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::create([
                    'nama' => 'Rumah Minimalis Modern',
                    'alamat' => 'Jl. Merdeka No. 12, Bandung',
                    'gambar' => 'properties/rumah-minimalis.jpg',
                ]);

                Property::create([
                    'nama' => 'Villa Asri',
                    'alamat' => 'Jl. Raya Puncak No. 45, Bogor',
                    'gambar' => 'properties/rumah-minimalis.jpg',
                ]);

                Property::create([
                    'nama' => 'Apartemen City View',
                    'alamat' => 'Jl. Sudirman No. 88, Jakarta',
                    'gambar' => 'properties/rumah-minimalis.jpg',
                ]);
    }
}

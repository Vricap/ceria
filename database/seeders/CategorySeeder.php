<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Residential',   'slug' => 'residential',   'icon' => 'fa-house',        'sort_order' => 1],
            ['name' => 'Commercial',    'slug' => 'commercial',    'icon' => 'fa-store',        'sort_order' => 2],
            ['name' => 'Apartment',     'slug' => 'apartment',     'icon' => 'fa-building',     'sort_order' => 3],
            ['name' => 'Land',          'slug' => 'land',          'icon' => 'fa-map',          'sort_order' => 4],
            ['name' => 'Luxury Villa',  'slug' => 'luxury-villa',  'icon' => 'fa-umbrella-beach', 'sort_order' => 5],
            ['name' => 'Office Space',  'slug' => 'office-space',  'icon' => 'fa-briefcase',    'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['is_active' => true]));
        }

        $types = [
            ['name' => 'Rumah',      'slug' => 'rumah',      'icon' => 'fa-house'],
            ['name' => 'Tanah',      'slug' => 'tanah',      'icon' => 'fa-map'],
            ['name' => 'Apartemen',  'slug' => 'apartemen',  'icon' => 'fa-building'],
            ['name' => 'Villa',      'slug' => 'villa',      'icon' => 'fa-umbrella-beach'],
            ['name' => 'Ruko',       'slug' => 'ruko',       'icon' => 'fa-store'],
            ['name' => 'Gudang',     'slug' => 'gudang',     'icon' => 'fa-warehouse'],
            ['name' => 'Kantor',     'slug' => 'kantor',     'icon' => 'fa-briefcase'],
            ['name' => 'Hotel',      'slug' => 'hotel',      'icon' => 'fa-hotel'],
            ['name' => 'Commercial', 'slug' => 'commercial-type', 'icon' => 'fa-city'],
        ];

        foreach ($types as $i => $type) {
            PropertyType::create(array_merge($type, ['is_active' => true, 'sort_order' => $i + 1]));
        }
    }
}

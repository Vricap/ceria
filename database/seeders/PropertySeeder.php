<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyFacility;
use App\Models\Category;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {


        // ─── Agents ────────────────────────────────────────────────────────────────
        $agentsData = [
            ['name' => 'James Anderson',  'title' => 'Senior Property Agent',   'specialization' => 'Residential & Villa', 'phone' => '6281234000001', 'whatsapp' => '6281234000001', 'email' => 'james@djm.id',  'city' => 'Sleman',           'experience_years' => 8,  'rating' => 5],
            ['name' => 'Sophia Martinez', 'title' => 'Property Consultant',     'specialization' => 'Commercial & Office', 'phone' => '6281234000002', 'whatsapp' => '6281234000002', 'email' => 'sophia@djm.id', 'city' => 'Kota Yogyakarta',  'experience_years' => 6,  'rating' => 5],
            ['name' => 'David Lee',       'title' => 'Investment Specialist',   'specialization' => 'Investment & Land',    'phone' => '6281234000003', 'whatsapp' => '6281234000003', 'email' => 'david@djm.id',  'city' => 'Bantul',           'experience_years' => 10, 'rating' => 5],
            ['name' => 'Rina Kurniawati', 'title' => 'Property Agent',          'specialization' => 'Residential',         'phone' => '6281234000004', 'whatsapp' => '6281234000004', 'email' => 'rina@djm.id',   'city' => 'Sleman',           'experience_years' => 4,  'rating' => 4],
            ['name' => 'Bima Pratama',    'title' => 'Senior Property Agent',   'specialization' => 'Apartment & Villa',   'phone' => '6281234000005', 'whatsapp' => '6281234000005', 'email' => 'bima@djm.id',   'city' => 'Kulon Progo',      'experience_years' => 7,  'rating' => 5],
        ];

        $agents = [];
        foreach ($agentsData as $i => $agentData) {
            $agents[] = Agent::create(array_merge($agentData, [
                'slug'      => Str::slug($agentData['name']),
                'is_active' => true,
                'sort_order'=> $i + 1,
                'bio'       => 'Agen properti berpengalaman di ' . $agentData['city'] . ' dengan spesialisasi ' . $agentData['specialization'] . '. Siap membantu Anda menemukan properti impian.',
            ]));
        }

        $sleman = City::where('slug', 'sleman')->first();
        $bantul = City::where('slug', 'bantul')->first();
        $jogja  = City::where('slug', 'kota-yogyakarta')->first();
        $klp    = City::where('slug', 'kulon-progo')->first();

        $catRes  = Category::where('slug', 'residential')->first();
        $catVilla = Category::where('slug', 'luxury-villa')->first();
        $catApt  = Category::where('slug', 'apartment')->first();
        $catLand = Category::where('slug', 'land')->first();
        $catCom  = Category::where('slug', 'commercial')->first();

        $typeRumah   = PropertyType::where('slug', 'rumah')->first();
        $typeVilla   = PropertyType::where('slug', 'villa')->first();
        $typeApt     = PropertyType::where('slug', 'apartemen')->first();
        $typeTanah   = PropertyType::where('slug', 'tanah')->first();
        $typeRuko    = PropertyType::where('slug', 'ruko')->first();

        // ─── Properties ────────────────────────────────────────────────────────────
        $properties = [
            [
                'title'            => 'Rumah Modern Dekat Kampus UGM',
                'slug'             => 'rumah-modern-dekat-kampus-ugm',
                'property_id_code' => 'PROP-001',
                'description'      => 'Rumah modern dengan desain minimalis berlokasi strategis di Depok, Sleman. Sangat dekat dengan Universitas Gadjah Mada, pusat perbelanjaan, dan akses jalan utama Ring Road. Cocok untuk keluarga muda atau investasi kos-kosan.',
                'short_description'=> 'Rumah modern minimalis, dekat kampus UGM, akses mudah ke mana-mana.',
                'transaction_type' => 'dijual',
                'price'            => 2500000000,
                'land_area'        => 180, 'building_area' => 160,
                'bedrooms'         => 4,   'bathrooms' => 3, 'garage' => 1, 'floors' => 2,
                'certificate'      => 'SHM',
                'year_built'       => 2022,
                'electric_power'   => '2200W',
                'address'          => 'Jl. Kaliurang KM 5, Depok, Sleman',
                'latitude'         => -7.7619, 'longitude' => 110.3789,
                'status'           => 'published', 'is_featured' => true,
                'agent_id'         => $agents[0]->id,
                'category_id'      => $catRes?->id,
                'property_type_id' => $typeRumah?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
                'facilities'       => ['Carport', 'Taman', 'CCTV', 'Keamanan 24 Jam', 'Air PDAM', 'Listrik PLN', 'Internet Ready'],
                'images'           => [
                    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
                    'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800&q=80',
                    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Luxury Villa with Private Pool',
                'slug'             => 'luxury-villa-with-private-pool',
                'property_id_code' => 'PROP-002',
                'description'      => 'Villa mewah dengan kolam renang pribadi, pemandangan sawah yang indah, dan interior premium. Cocok untuk hunian eksklusif maupun investasi villa sewa harian di Sleman, Yogyakarta.',
                'short_description'=> 'Villa mewah kolam renang pribadi, view sawah, akses Kaliurang.',
                'transaction_type' => 'dijual',
                'price'            => 9500000000,
                'land_area'        => 500, 'building_area' => 350,
                'bedrooms'         => 4,   'bathrooms' => 4, 'garage' => 2, 'floors' => 1,
                'certificate'      => 'SHM',
                'year_built'       => 2021,
                'electric_power'   => '5500W',
                'address'          => 'Jl. Palagan Tentara Pelajar KM 10, Sleman',
                'latitude'         => -7.7140, 'longitude' => 110.3956,
                'status'           => 'published', 'is_featured' => true,
                'agent_id'         => $agents[2]->id,
                'category_id'      => $catVilla?->id,
                'property_type_id' => $typeVilla?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
                'facilities'       => ['Private Pool', 'Taman Luas', 'Gazebo', 'CCTV', 'Keamanan', 'Air Sumur', 'Solar Panel', 'Smart Home'],
                'images'           => [
                    'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Urban Apartment Pusat Kota',
                'slug'             => 'urban-apartment-pusat-kota',
                'property_id_code' => 'PROP-003',
                'description'      => 'Apartemen modern di pusat Kota Yogyakarta dengan fasilitas lengkap. Lantai 15, view kota yang menakjubkan, dekat Malioboro dan berbagai pusat hiburan.',
                'short_description'=> 'Apartemen modern pusat kota, view Merapi, fasilitas bintang 5.',
                'transaction_type' => 'dijual',
                'price'            => 3200000000,
                'land_area'        => null, 'building_area' => 90,
                'bedrooms'         => 2,   'bathrooms' => 2, 'garage' => 1, 'floors' => 1,
                'certificate'      => 'SHMSRS',
                'year_built'       => 2023,
                'electric_power'   => '2200W',
                'address'          => 'Jl. Malioboro, Kota Yogyakarta',
                'latitude'         => -7.7956, 'longitude' => 110.3695,
                'status'           => 'published', 'is_featured' => true,
                'agent_id'         => $agents[1]->id,
                'category_id'      => $catApt?->id,
                'property_type_id' => $typeApt?->id,
                'city_id'          => $jogja?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80',
                'facilities'       => ['Kolam Renang', 'Gym', 'Security 24 Jam', 'Parkir', 'Lift', 'CCTV', 'Lobby Mewah'],
                'images'           => [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&q=80',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Ocean View House Bantul',
                'slug'             => 'ocean-view-house-bantul',
                'property_id_code' => 'PROP-004',
                'description'      => 'Rumah dengan pemandangan laut lepas yang menakjubkan di kawasan Pantai Parangtritis, Bantul. Desain tropis modern, cocok untuk villa sewa atau hunian pribadi yang tenang.',
                'short_description'=> 'Rumah view pantai, desain tropis, cocok villa sewa di Bantul.',
                'transaction_type' => 'dijual',
                'price'            => 7200000000,
                'land_area'        => 400, 'building_area' => 280,
                'bedrooms'         => 4,   'bathrooms' => 3, 'garage' => 2, 'floors' => 2,
                'certificate'      => 'SHM',
                'year_built'       => 2020,
                'electric_power'   => '3500W',
                'address'          => 'Jl. Parangtritis KM 25, Bantul',
                'latitude'         => -7.9787, 'longitude' => 110.3265,
                'status'           => 'published', 'is_featured' => true,
                'agent_id'         => $agents[2]->id,
                'category_id'      => $catRes?->id,
                'property_type_id' => $typeRumah?->id,
                'city_id'          => $bantul?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80',
                'facilities'       => ['Taman Tropis', 'BBQ Area', 'CCTV', 'Sumur Bor', 'Solar Panel'],
                'images'           => [
                    'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80',
                    'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Ruko Strategis Jl. Kaliurang',
                'slug'             => 'ruko-strategis-jl-kaliurang',
                'property_id_code' => 'PROP-005',
                'description'      => 'Ruko 3 lantai di lokasi paling strategis Jalan Kaliurang, Sleman. Cocok untuk berbagai usaha: restoran, kafe, toko, kantor, dll. Akses mudah, ramai pengunjung.',
                'short_description'=> 'Ruko 3 lantai lokasi prime Jl. Kaliurang, cocok semua usaha.',
                'transaction_type' => 'dijual',
                'price'            => 4800000000,
                'land_area'        => 120, 'building_area' => 360,
                'bedrooms'         => 0,   'bathrooms' => 3, 'garage' => 1, 'floors' => 3,
                'certificate'      => 'SHM',
                'year_built'       => 2019,
                'electric_power'   => '5500W',
                'address'          => 'Jl. Kaliurang KM 12, Ngaglik, Sleman',
                'latitude'         => -7.7319, 'longitude' => 110.3910,
                'status'           => 'published', 'is_featured' => false,
                'agent_id'         => $agents[0]->id,
                'category_id'      => $catCom?->id,
                'property_type_id' => $typeRuko?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80',
                'facilities'       => ['Parkir Luas', 'Listrik 3 Phase', 'Air PDAM', 'Akses 24 Jam'],
                'images'           => [
                    'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Tanah Kavling Siap Bangun Godean',
                'slug'             => 'tanah-kavling-siap-bangun-godean',
                'property_id_code' => 'PROP-006',
                'description'      => 'Tanah kavling siap bangun di lokasi strategis Godean, Sleman. Sudah ada akses jalan, listrik, dan air. Lingkungan perumahan baru yang berkembang pesat.',
                'short_description'=> 'Tanah kavling siap bangun Godean, sudah ada jalan & listrik.',
                'transaction_type' => 'dijual',
                'price'            => 850000000,
                'land_area'        => 150, 'building_area' => null,
                'bedrooms'         => null, 'bathrooms' => null, 'garage' => null, 'floors' => null,
                'certificate'      => 'SHM',
                'year_built'       => null,
                'electric_power'   => null,
                'address'          => 'Godean, Sleman',
                'latitude'         => -7.7814, 'longitude' => 110.2993,
                'status'           => 'published', 'is_featured' => false,
                'agent_id'         => $agents[3]->id,
                'category_id'      => $catLand?->id,
                'property_type_id' => $typeTanah?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                'facilities'       => ['Akses Jalan Aspal', 'Listrik PLN', 'Air Sumur'],
                'images'           => [
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Rumah Cluster Modern Godean',
                'slug'             => 'rumah-cluster-modern-godean',
                'property_id_code' => 'PROP-007',
                'description'      => 'Rumah cluster modern dalam perumahan eksklusif di Godean, Sleman. Desain kontemporer dengan one gate system, taman bermain, dan akses ke berbagai fasilitas umum.',
                'short_description'=> 'Rumah cluster one gate system, desain modern, Godean Sleman.',
                'transaction_type' => 'dijual',
                'price'            => 1750000000,
                'land_area'        => 90, 'building_area' => 80,
                'bedrooms'         => 3,  'bathrooms' => 2, 'garage' => 1, 'floors' => 2,
                'certificate'      => 'SHM',
                'year_built'       => 2024,
                'electric_power'   => '1300W',
                'address'          => 'Perumahan Grand Godean, Sleman',
                'latitude'         => -7.7850, 'longitude' => 110.3050,
                'status'           => 'published', 'is_featured' => false,
                'agent_id'         => $agents[3]->id,
                'category_id'      => $catRes?->id,
                'property_type_id' => $typeRumah?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
                'facilities'       => ['One Gate System', 'Taman Bermain', 'CCTV', 'Keamanan 24 Jam', 'Air PDAM'],
                'images'           => [
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
                    'https://images.unsplash.com/photo-1523217582562-09d0def993a6?w=800&q=80',
                ],
            ],
            [
                'title'            => 'Vila Jogja Bernuansa Tropis Disewakan',
                'slug'             => 'vila-jogja-bernuansa-tropis-disewakan',
                'property_id_code' => 'PROP-008',
                'description'      => 'Vila tropis dengan nuansa Bali di Sleman, Yogyakarta. Tersedia untuk disewa harian/mingguan. Dilengkapi kolam renang, gazebo, dapur lengkap, dan taman hijau yang asri.',
                'short_description'=> 'Vila tropis sewa harian, kolam renang, nuansa Bali di Sleman.',
                'transaction_type' => 'disewa',
                'price'            => null,
                'price_rent_monthly' => 25000000,
                'land_area'        => 350, 'building_area' => 200,
                'bedrooms'         => 3,   'bathrooms' => 3, 'garage' => 1, 'floors' => 1,
                'certificate'      => 'SHM',
                'year_built'       => 2020,
                'electric_power'   => '3500W',
                'address'          => 'Mlati, Sleman',
                'latitude'         => -7.7400, 'longitude' => 110.3600,
                'status'           => 'published', 'is_featured' => false,
                'agent_id'         => $agents[4]->id,
                'category_id'      => $catVilla?->id,
                'property_type_id' => $typeVilla?->id,
                'city_id'          => $sleman?->id,
                'thumbnail'        => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
                'facilities'       => ['Private Pool', 'Gazebo', 'Dapur Lengkap', 'WiFi', 'BBQ Area', 'Taman'],
                'images'           => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80',
                ],
            ],
        ];

        foreach ($properties as $propertyData) {
            $facilities = $propertyData['facilities'] ?? [];
            $images     = $propertyData['images'] ?? [];
            unset($propertyData['facilities'], $propertyData['images']);

            $propertyData['province_id'] = 1; // DI Yogyakarta
            $propertyData['published_at'] = now()->subDays(rand(1, 30));

            $property = Property::create($propertyData);

            foreach ($facilities as $facility) {
                PropertyFacility::create([
                    'property_id' => $property->id,
                    'name'        => $facility,
                    'icon'        => 'fa-check',
                ]);
            }

            foreach ($images as $i => $imageUrl) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url'   => $imageUrl,
                    'alt_text'    => $property->title,
                    'sort_order'  => $i,
                    'is_primary'  => $i === 0,
                ]);
            }
        }
    }
}

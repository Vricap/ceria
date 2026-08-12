<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $province = Province::create([
            'name' => 'DI Yogyakarta',
            'slug' => 'di-yogyakarta',
            'is_active' => true,
        ]);

        $cities = [
            'Kota Yogyakarta' => ['kota-yogyakarta', [
                'Gondokusuman', 'Danurejan', 'Jetis', 'Tegalrejo', 'Umbulharjo',
                'Mergangsan', 'Pakualaman', 'Kraton', 'Mantrijeron', 'Wirobrajan',
                'Ngampilan', 'Gondomanan', 'Gedongtengen', 'Kotagede',
            ]],
            'Sleman' => ['sleman', [
                'Depok', 'Mlati', 'Godean', 'Gamping', 'Sleman', 'Ngaglik',
                'Ngemplak', 'Kalasan', 'Berbah', 'Prambanan', 'Moyudan',
                'Minggir', 'Seyegan', 'Pakem', 'Turi', 'Cangkringan',
                'Tempel', 'Rongkop',
            ]],
            'Bantul' => ['bantul', [
                'Bantul', 'Sewon', 'Kasihan', 'Sedayu', 'Pajangan',
                'Pandak', 'Bambanglipuro', 'Pundong', 'Kretek', 'Sanden',
                'Srandakan', 'Imogiri', 'Dlingo', 'Piyungan', 'Banguntapan',
                'Pleret', 'Jetis', 'Jetis', 'Pundong',
            ]],
            'Kulon Progo' => ['kulon-progo', [
                'Wates', 'Pengasih', 'Temon', 'Panjatan', 'Galur',
                'Lendah', 'Sentolo', 'Nanggulan', 'Girimulyo', 'Samigaluh',
                'Kokap', 'Kalibawang',
            ]],
            'Gunungkidul' => ['gunungkidul', [
                'Wonosari', 'Playen', 'Patuk', 'Piyungan', 'Panggang',
                'Purwosari', 'Saptosari', 'Tepus', 'Tanjungsari', 'Rongkop',
                'Girisubo', 'Semanu', 'Ponjong', 'Karangmojo', 'Semin',
                'Ngawen', 'Gedangsari', 'Nglipar',
            ]],
        ];

        foreach ($cities as $cityName => [$citySlug, $districts]) {
            $city = City::create([
                'province_id' => $province->id,
                'name'        => $cityName,
                'slug'        => $citySlug,
                'is_active'   => true,
            ]);

            $usedSlugs = [];
            foreach (array_unique($districts) as $districtName) {
                $baseSlug = Str::slug($districtName . '-' . $citySlug);
                $slug     = $baseSlug;
                $counter  = 1;
                while (in_array($slug, $usedSlugs)) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $usedSlugs[] = $slug;

                District::create([
                    'city_id'   => $city->id,
                    'name'      => $districtName,
                    'slug'      => $slug,
                    'is_active' => true,
                ]);
            }
        }
    }
}

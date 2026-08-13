<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\Service;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Site Settings ─────────────────────────────────────────────────────────
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'DJM Property',                    'type' => 'text',     'group' => 'general', 'label' => 'Nama Website'],
            ['key' => 'site_tagline',     'value' => 'Your Trusted Property Partner',     'type' => 'text',     'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'site_logo',        'value' => '',                                  'type' => 'image',    'group' => 'general', 'label' => 'Logo'],
            ['key' => 'site_favicon',     'value' => '',                                  'type' => 'image',    'group' => 'general', 'label' => 'Favicon'],
            ['key' => 'site_description', 'value' => 'Platform properti terpercaya di Yogyakarta. Temukan rumah, tanah, villa, dan properti impian Anda.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Deskripsi Website'],

            // Contact
            ['key' => 'contact_address',  'value' => 'Jl. Kaliurang KM 7, Sleman, Yogyakarta',   'type' => 'text',    'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'contact_phone',    'value' => '+62 274 123456',                             'type' => 'text',    'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890',                              'type' => 'text',    'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'contact_email',    'value' => 'info@djmProperty.id',                      'type' => 'text',    'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_hours',    'value' => 'Senin – Jumat: 08.00–17.00 WIB',             'type' => 'text',    'group' => 'contact', 'label' => 'Jam Operasional'],

            // Social
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/djmProperty',  'type' => 'text', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'social_facebook',  'value' => 'https://facebook.com/djmProperty',   'type' => 'text', 'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'social_youtube',   'value' => '',                                      'type' => 'text', 'group' => 'social', 'label' => 'YouTube'],
            ['key' => 'social_tiktok',    'value' => '',                                      'type' => 'text', 'group' => 'social', 'label' => 'TikTok'],

            // SEO
            ['key' => 'seo_title',        'value' => 'DJM Property – Jual Beli Sewa Properti di Yogyakarta', 'type' => 'text',     'group' => 'seo', 'label' => 'SEO Title'],
            ['key' => 'seo_description',  'value' => 'DJM Property adalah platform properti terpercaya di Yogyakarta. Cari rumah, tanah, apartemen, villa, dan investasi properti terbaik.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'SEO Description'],

            // Homepage
            ['key' => 'hero_title',       'value' => 'Find Your Dream Property, Easy & Fast',                        'type' => 'text',     'group' => 'homepage', 'label' => 'Hero Title'],
            ['key' => 'hero_subtitle',    'value' => 'Discover verified properties, luxury homes, and great investment opportunities all in one place.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'Hero Subtitle'],
            ['key' => 'hero_image',       'value' => '',                                                                'type' => 'image',    'group' => 'homepage', 'label' => 'Hero Background'],
            ['key' => 'about_title',      'value' => 'Your Trusted Partner in Property Investment & Management',       'type' => 'text',     'group' => 'homepage', 'label' => 'About Title'],
            ['key' => 'about_description','value' => 'Kami membantu Anda menemukan, membeli, dan mengelola properti dengan proses yang mudah, transparan, dan terpercaya. Bergabunglah dengan ribuan klien yang telah mempercayakan kebutuhan properti mereka kepada kami.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'About Description'],
            ['key' => 'about_image',      'value' => '',                                                                'type' => 'image',    'group' => 'homepage', 'label' => 'About Image'],
            ['key' => 'stat_properties',  'value' => '2000+',  'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Properti'],
            ['key' => 'stat_clients',     'value' => '1500+',  'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Klien'],
            ['key' => 'stat_agents',      'value' => '100+',   'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Agen'],
            ['key' => 'stat_support',     'value' => '24/7',   'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Support'],
            ['key' => 'experience_years', 'value' => '15+',    'type' => 'text', 'group' => 'homepage', 'label' => 'Pengalaman (tahun)'],
            ['key' => 'google_maps_embed','value' => '',       'type' => 'textarea', 'group' => 'contact', 'label' => 'Google Maps Embed URL'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // ─── Services ──────────────────────────────────────────────────────────────
        // Layanan asli DJM (Desty Jaya Mandiri): Perizinan & Konstruksi.
        // Konfirmasi daftar final dengan client sesuai PRD.
        $services = [
            // Kategori: Perizinan
            ['name' => 'PBG / IMB',              'slug' => 'pbg-imb',              'category' => 'perizinan', 'icon' => 'fa-file-signature',      'short_description' => 'Pengurusan Persetujuan Bangunan Gedung (PBG) dan Izin Mendirikan Bangunan (IMB) secara cepat dan resmi.', 'sort_order' => 1],
            ['name' => 'Pengeringan',            'slug' => 'pengeringan',           'category' => 'perizinan', 'icon' => 'fa-water',              'short_description' => 'Jasa pengeringan lahan untuk menyiapkan tanah yang siap dibangun.', 'sort_order' => 2],
            ['name' => 'Pecah Sertifikat',       'slug' => 'pecah-sertifikat',      'category' => 'perizinan', 'icon' => 'fa-file-invoice',       'short_description' => 'Pemecahan sertifikat tanah sesuai kebutuhan legal dan peruntukan lahan.', 'sort_order' => 3],

            // Kategori: Konstruksi
            ['name' => 'Pembangunan',            'slug' => 'pembangunan',           'category' => 'konstruksi', 'icon' => 'fa-building-construction', 'short_description' => 'Jasa pembangunan bangunan dari fondasi hingga selesai oleh tim berpengalaman.', 'sort_order' => 4],
            ['name' => 'Renovasi',               'slug' => 'renovasi',              'category' => 'konstruksi', 'icon' => 'fa-hammer',            'short_description' => 'Renovasi dan perbaikan bangunan untuk meningkatkan kenyamanan dan nilai properti.', 'sort_order' => 5],
            ['name' => 'Jasa Konstruksi',        'slug' => 'jasa-konstruksi',       'category' => 'konstruksi', 'icon' => 'fa-helmet-safety',     'short_description' => 'Layanan konstruksi umum untuk kebutuhan pembangunan Anda.', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], array_merge($service, ['is_active' => true]));
        }

        // Hapus layanan lama yang tidak lagi sesuai daftar layanan asli DJM
        $activeSlugs = collect($services)->pluck('slug')->all();
        Service::whereNotIn('slug', $activeSlugs)->delete();
    }
}

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
        $services = [
            ['name' => 'Buy Property',         'slug' => 'buy-property',         'icon' => 'fa-house-circle-check', 'short_description' => 'Kami membantu Anda menemukan dan membeli properti impian dengan panduan ahli kami.', 'sort_order' => 1],
            ['name' => 'Sell Property',        'slug' => 'sell-property',        'icon' => 'fa-hand-holding-dollar','short_description' => 'Pasarkan properti Anda kepada calon pembeli yang tepat dengan harga terbaik.', 'sort_order' => 2],
            ['name' => 'Rent Property',        'slug' => 'rent-property',        'icon' => 'fa-key',                'short_description' => 'Temukan properti sewa yang sesuai kebutuhan dan anggaran Anda.', 'sort_order' => 3],
            ['name' => 'Property Management',  'slug' => 'property-management',  'icon' => 'fa-gears',              'short_description' => 'Kami mengelola properti Anda agar tetap produktif dan terawat.', 'sort_order' => 4],
            ['name' => 'Property Investment',  'slug' => 'property-investment',  'icon' => 'fa-chart-line',         'short_description' => 'Konsultasi investasi properti untuk portofolio yang menguntungkan.', 'sort_order' => 5],
            ['name' => 'Property Consultation','slug' => 'property-consultation','icon' => 'fa-comments',           'short_description' => 'Konsultasi gratis untuk kebutuhan properti Anda bersama tim ahli kami.', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], array_merge($service, ['is_active' => true]));
        }
    }
}

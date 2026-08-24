<?php

// Konfigurasi SEO global situs.
return [

    // Base URL kanonik produksi.
    // Dipakai oleh sitemap generator agar tidak bergantung pada APP_URL
    // (yang bisa salah saat command dijalankan via cron/CLI).
    'base_url' => env('SEO_BASE_URL', 'https://destyjayamandiri.com'),
];

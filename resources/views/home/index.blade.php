@extends('layouts.app')

@section('title', $settings['seo_title'] ?? 'DJM — Desty Jaya Mandiri | Perizinan, Properti & Konstruksi Yogyakarta')
@section('meta_description', $settings['seo_description'] ?? 'DJM Desty Jaya Mandiri menyediakan layanan perizinan (PBG/IMB), jual beli & sewa properti, serta konstruksi terpercaya di Yogyakarta dan sekitarnya.')

@push('scripts')
<style>
    /* ── Hero ──────────────────────────────────── */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        /* Pull up to cover the body padding-top so no white strip shows */
        margin-top: -76px;
        padding: calc(76px + 120px) 0 120px;
        background-color: var(--color-surface);
        background-image: url('{{ asset("images/desktop.jpg") }}');
        background-size: cover;
        background-position: center;
        margin-bottom: 0;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(31, 22, 17, 0.92) 0%, rgba(82, 56, 40, 0.68) 60%, rgba(148, 110, 75, 0.3) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 10;
        color: white;
        max-width: 650px;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 24px;
        backdrop-filter: blur(4px);
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .hero-subtitle {
        font-size: 1.125rem;
        margin-bottom: 40px;
        opacity: 0.9;
        line-height: 1.7;
    }

    .hero-cta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .hero-cta .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* ── Service Highlight ───────────────────── */
    .service-highlight-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .service-highlight-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: 40px 30px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        transition: all 0.35s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .service-highlight-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-gilded);
    }

    .service-highlight-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--color-champagne);
        color: var(--color-bronze);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }

    .service-highlight-card:hover .service-highlight-icon {
        background: var(--color-gilded);
        color: var(--color-noir);
        transform: scale(1.1) rotate(5deg);
    }

    .service-highlight-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 12px;
    }

    .service-highlight-desc {
        color: var(--color-text-muted);
        line-height: 1.7;
        margin-bottom: 24px;
        flex-grow: 1;
    }

    /* ── Property Card ───────────────────────── */
    .property-card {
        background: white;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        transition: all 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .property-card-image {
        position: relative;
        overflow: hidden;
        height: 210px;
    }

    .property-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .property-card:hover .property-card-image img {
        transform: scale(1.05);
    }

    .property-badges {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        gap: 6px;
    }

    .property-card-content {
        padding: 20px;
    }

    .property-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .property-title a {
        color: var(--color-text-main);
    }

    .property-title a:hover {
        color: var(--color-bronze);
    }

    .property-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--color-bronze);
        margin-bottom: 8px;
    }

    .property-location {
        color: var(--color-text-muted);
        font-size: 0.875rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .property-specs {
        display: flex;
        gap: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--color-border);
    }

    .property-spec {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Portfolio Highlight ─────────────────── */
    .portfolio-grid-home {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .portfolio-card-home {
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        position: relative;
        aspect-ratio: 4/3;
        box-shadow: var(--shadow-sm);
        transition: all 0.35s ease;
    }

    .portfolio-card-home:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .portfolio-card-home img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .portfolio-card-home:hover img {
        transform: scale(1.06);
    }

    .portfolio-card-home-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(31, 22, 17, 0.88) 0%, transparent 55%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
        transition: all 0.3s ease;
    }

    .portfolio-card-home-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 8px;
        align-self: flex-start;
    }

    .portfolio-card-home h3 {
        color: white;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .portfolio-card-home p {
        color: rgba(255,255,255,0.75);
        font-size: 0.8rem;
    }

    /* ── CTA WhatsApp ────────────────────────── */
    .cta-whatsapp-section {
        padding: 60px 0 40px;
    }

    .cta-whatsapp-card {
        background: linear-gradient(135deg, var(--color-noir) 0%, var(--color-espresso) 100%);
        color: var(--color-champagne);
        padding: 60px 20px;
        text-align: center;
        border-radius: var(--border-radius-lg);
        position: relative;
        overflow: hidden;
    }

    .cta-whatsapp-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(212, 165, 105, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .cta-whatsapp-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(212, 165, 105, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .cta-wa-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
        position: relative;
        z-index: 1;
        color: var(--color-champagne);
    }

    .cta-wa-subtitle {
        font-size: 1.1rem;
        opacity: 0.85;
        margin-bottom: 36px;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 1;
    }

    .btn-whatsapp {
        background: var(--color-gilded);
        color: var(--color-noir);
        padding: 16px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        box-shadow: 0 8px 25px rgba(212, 165, 105, 0.45);
    }

    .btn-whatsapp:hover {
        background: var(--color-gilded-dark);
        color: var(--color-noir);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(212, 165, 105, 0.6);
    }

    /* ── About Section ───────────────────────── */
    .about-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-image {
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-features {
        margin-top: 30px;
    }

    .about-feature {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }

    .about-feature-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--color-champagne);
        color: var(--color-bronze);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* ── Responsive ──────────────────────────── */
    @media (max-width: 991px) {
        /* body padding-top stays 76px at this breakpoint */
        .hero-section { margin-top: -76px; padding: calc(76px + 50px) 0 60px; }
        .hero-title { font-size: 2.75rem; }
        .service-highlight-grid { grid-template-columns: 1fr; gap: 20px; }
        .portfolio-grid-home { grid-template-columns: 1fr 1fr; }
        .about-section { grid-template-columns: 1fr; gap: 40px; }
        .cta-wa-title { font-size: 2.25rem; }
    }

    @media (max-width: 767px) {
        /* body padding-top changes to 64px at this breakpoint */
        .hero-section { margin-top: -64px; padding: calc(64px + 40px) 0 50px; }
        .hero-title { font-size: 2rem; }
        .hero-subtitle { font-size: 1rem; margin-bottom: 30px; }
        .hero-content { max-width: 100%; }
        .service-highlight-card { padding: 30px 20px; }
        .portfolio-grid-home { grid-template-columns: 1fr; }
        .cta-wa-title { font-size: 1.75rem; }
        .btn-whatsapp { padding: 14px 30px; font-size: 1rem; }
        .cta-whatsapp-section { padding: 40px 0 30px; }
        .cta-whatsapp-card { padding: 45px 20px; }
    }

    @media (max-width: 480px) {
        .hero-section { margin-top: -64px; padding: calc(64px + 30px) 0 40px; }
        .hero-title { font-size: 1.7rem; }
        .hero-subtitle { font-size: 0.95rem; }
        .hero-cta { flex-direction: column; }
        .hero-cta .btn { text-align: center; }
        .service-highlight-icon { width: 65px; height: 65px; font-size: 1.6rem; }
    }
</style>
@endpush

@section('content')

{{-- ──────────────────────────────────────────────── --}}
{{-- 1. HERO SECTION                                  --}}
{{-- ──────────────────────────────────────────────── --}}
<section class="hero-section" aria-label="Halaman Utama DJM">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-scroll>

            <h1 class="hero-title">{{ $settings['hero_title'] ?? 'Solusi Properti, Perizinan & Konstruksi Terpercaya' }}</h1>
            <p class="hero-subtitle">{{ $settings['hero_subtitle'] ?? 'Membantu memenuhi kebutuhan properti, perizinan, dan konstruksi Anda di Yogyakarta dan sekitarnya.' }}</p>
            <div class="hero-cta">
                <a href="{{ route('services.index') }}" class="btn btn-white" style="padding: 14px 32px; font-weight: 700;">
                    <i class="fa-solid fa-list-check" aria-hidden="true"></i> Lihat Layanan
                </a>
                <a href="{{ route('properties.index') }}" class="btn btn-outline" style="border-color: white; color: white; padding: 14px 32px; font-weight: 700;">
                    <i class="fa-solid fa-building" aria-hidden="true"></i> Lihat Properti
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ──────────────────────────────────────────────── --}}
{{-- 2. SERVICE HIGHLIGHT                             --}}
{{-- ──────────────────────────────────────────────── --}}
<section class="section section-light" aria-labelledby="judul-layanan">
    <div class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 50px;" data-scroll>
            <h2 class="section-title" id="judul-layanan">Layanan Kami</h2>
            <p class="section-subtitle">Tiga bidang utama yang DJM kerjakan untuk memenuhi kebutuhan Anda</p>
        </div>

        <div class="service-highlight-grid">
            {{-- Perizinan --}}
            <div class="service-highlight-card" data-scroll>
                <div class="service-highlight-icon">
                    <i class="fa-solid fa-file-shield" aria-hidden="true"></i>
                </div>
                <h3 class="service-highlight-title">Perizinan</h3>
                <p class="service-highlight-desc">
                    Pengurusan perizinan bangunan dan lahan yang cepat dan terpercaya, meliputi PBG/IMB, pengeringan lahan, dan pecah sertifikat.
                </p>
                <a href="{{ route('services.index') }}" class="btn btn-primary" title="Lihat layanan perizinan DJM">
                    Lihat Detail <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Properti --}}
            <div class="service-highlight-card" data-scroll>
                <div class="service-highlight-icon">
                    <i class="fa-solid fa-house-chimney" aria-hidden="true"></i>
                </div>
                <h3 class="service-highlight-title">Properti</h3>
                <p class="service-highlight-desc">
                    Katalog properti pilihan — rumah, tanah, ruko, dan villa di Yogyakarta. Proses jual beli dan sewa yang mudah, transparan, dan aman.
                </p>
                <a href="{{ route('properties.index') }}" class="btn btn-primary" title="Lihat katalog properti DJM">
                    Lihat Detail <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Konstruksi --}}
            <div class="service-highlight-card" data-scroll>
                <div class="service-highlight-icon">
                    <i class="fa-solid fa-helmet-safety" aria-hidden="true"></i>
                </div>
                <h3 class="service-highlight-title">Konstruksi</h3>
                <p class="service-highlight-desc">
                    Layanan pembangunan dan renovasi bangunan oleh tim berpengalaman — dari desain hingga selesai dengan hasil yang memuaskan.
                </p>
                <a href="{{ route('services.index') }}" class="btn btn-primary" title="Lihat layanan konstruksi DJM">
                    Lihat Detail <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ──────────────────────────────────────────────── --}}
{{-- 3. PROPERTY HIGHLIGHT                            --}}
{{-- ──────────────────────────────────────────────── --}}
<section class="section section-muted" style="background: linear-gradient(135deg, var(--color-champagne) 0%, #FBF4E4 100%);" aria-labelledby="judul-properti">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; gap: 15px;">
            <div data-scroll>
                <h2 class="section-title" id="judul-properti" style="margin-bottom: 5px;">Properti Terbaru</h2>
                <p class="section-subtitle" style="margin: 0;">Pilihan properti unggulan di Yogyakarta</p>
            </div>
            <a href="{{ route('properties.index') }}" style="font-weight: 600; display: flex; align-items: center; gap: 5px; white-space: nowrap;" title="Lihat semua properti DJM">
                Lihat Semua <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        @if($featuredProperties->count() > 0)
            <div class="grid grid-cols-4" style="grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));">
                @foreach($featuredProperties as $property)
                    <article class="property-card" data-scroll>
                        <div class="property-card-image">
                            <div class="property-badges">
                                <span class="badge {{ $property->status_color }}">{{ $property->status_label }}</span>
                                @if($property->is_featured)
                                    <span class="badge badge-featured"><i class="fa-solid fa-star" aria-hidden="true"></i> Unggulan</span>
                                @endif
                            </div>
                            @if($property->status == 'sold')
                                <div class="sold-out-overlay">
                                    <div class="sold-out-stamp">Sold Out</div>
                                </div>
                            @endif
                            <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">
                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="property-card-content">
                            <div style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 5px;">{{ $property->propertyType->name ?? 'Rumah' }}</div>
                            <h3 class="property-title" style="font-size: 1.3rem; margin-bottom: 8px;">
                                <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">{{ Str::limit($property->title, 50) }}</a>
                            </h3>
                            <div class="property-location" style="margin-bottom: 15px; color: var(--color-text-muted);">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $property->location_string }}
                            </div>
                            <div class="property-specs" style="border-top: none; padding-top: 0; margin-top: 0; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px;">
                                @if($property->building_area)
                                    <div class="property-spec" title="Luas Bangunan" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-expand" aria-hidden="true" style="color: var(--color-primary);"></i> 
                                        <span style="color: var(--color-text-muted);">{{ (int)$property->building_area }} Luas Bangunan</span>
                                    </div>
                                @endif
                                @if($property->land_area)
                                    <div class="property-spec" title="Luas Tanah" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-expand" aria-hidden="true" style="color: var(--color-primary);"></i> 
                                        <span style="color: var(--color-text-muted);">{{ (int)$property->land_area }} Luas Tanah</span>
                                    </div>
                                @endif
                                @if($property->bedrooms)
                                    <div class="property-spec" title="Kamar Tidur" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-bed" aria-hidden="true" style="color: var(--color-primary);"></i> 
                                        <span style="color: var(--color-text-muted);">{{ $property->bedrooms }} Kamar Tidur</span>
                                    </div>
                                @endif
                                @if($property->bathrooms)
                                    <div class="property-spec" title="Kamar Mandi" style="display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-shower" aria-hidden="true" style="color: var(--color-primary);"></i> 
                                        <span style="color: var(--color-text-muted);">{{ $property->bathrooms }} Kamar Mandi</span>
                                    </div>
                                @endif
                            </div>
                            <div style="border-top: 1px solid var(--color-border); padding-top: 15px; margin-top: auto;">
                                <div class="property-price" style="color: var(--color-primary); font-size: 1.5rem; margin-bottom: 0; font-weight: bold;">{{ $property->formatted_price }}</div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: var(--color-text-muted);">
                <i class="fa-solid fa-house-circle-xmark" style="font-size: 3rem; color: var(--color-border); display: block; margin-bottom: 20px;"></i>
                <p>Belum ada properti tersedia. Silakan cek kembali nanti.</p>
            </div>
        @endif
    </div>
</section>


{{-- ──────────────────────────────────────────────── --}}
{{-- 4. PORTFOLIO HIGHLIGHT                           --}}
{{-- ──────────────────────────────────────────────── --}}
<section class="section section-light" aria-labelledby="judul-portfolio">
    <div class="container">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; gap: 15px;">
            <div data-scroll>
                <h2 class="section-title" id="judul-portfolio" style="margin-bottom: 5px;">Portfolio Kami</h2>
                <p class="section-subtitle" style="margin: 0;">Proyek yang telah berhasil diselesaikan DJM</p>
            </div>
            <a href="{{ route('portfolio.index') }}" style="font-weight: 600; display: flex; align-items: center; gap: 5px; white-space: nowrap;" title="Lihat semua portfolio DJM">
                Lihat Semua <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="portfolio-grid-home">
            @php
            $portfolioItems = [
                ['title' => 'Pengurusan PBG / IMB', 'cat' => 'Perizinan', 'loc' => 'Sleman', 'img' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&q=80'],
                ['title' => 'Pembangunan Rumah Modern', 'cat' => 'Konstruksi', 'loc' => 'Bantul', 'img' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80'],
                ['title' => 'Penjualan Kavling Strategis', 'cat' => 'Properti', 'loc' => 'Godean', 'img' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80'],
            ];
            @endphp

            @foreach($portfolioItems as $item)
                <div class="portfolio-card-home" data-scroll>
                    <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy">
                    <div class="portfolio-card-home-overlay">
                        <span class="portfolio-card-home-badge">{{ $item['cat'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p><i class="fa-solid fa-location-dot" style="margin-right: 4px;"></i>{{ $item['loc'] }}, Yogyakarta</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;" data-scroll>
            <a href="{{ route('portfolio.index') }}" class="btn btn-primary" style="padding: 14px 36px;" title="Lihat semua portfolio DJM">
                Lihat Semua Portfolio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>


{{-- ──────────────────────────────────────────────── --}}
{{-- 5. CTA WHATSAPP                                  --}}
{{-- ──────────────────────────────────────────────── --}}
<section class="cta-whatsapp-section" aria-label="Hubungi DJM via WhatsApp">
    <div class="container">
        <div class="cta-whatsapp-card" data-scroll>
            <h2 class="cta-wa-title">Siap Membantu Kebutuhan Anda</h2>
            <p class="cta-wa-subtitle">Konsultasikan kebutuhan perizinan, properti, atau konstruksi Anda langsung bersama tim ahli DJM — tanpa biaya awal.</p>
            <a href="https://wa.me/6281234567890?text=Halo%20DJM%2C%20saya%20ingin%20berkonsultasi%20mengenai%20layanan%20DJM."
               target="_blank"
               rel="noopener noreferrer"
               class="btn-whatsapp"
               title="Hubungi DJM via WhatsApp">
                <i class="fa-brands fa-whatsapp" style="font-size: 1.4rem;"></i>
                Konsultasi via WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@extends('layouts.app')

@section('title', $settings['seo_title'] ?? 'DJM Property - Jual Beli Sewa Properti Terpercaya di Yogyakarta')
@section('meta_description', $settings['seo_description'] ?? 'Temukan rumah, apartemen, tanah, dan properti komersial terbaik di Yogyakarta. DJM Property hadir sebagai mitra properti terpercaya Anda sejak 2020.')

@push('scripts')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 120px 0;
        background-color: var(--color-surface);
        background-image: url('{{ asset("images/desktop.jpg") }}');
        background-size: cover;
        background-position: center;
        margin-bottom: 80px;
    }
    
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(33, 84, 161, 0.9), rgba(49, 109, 227, 0.4));
    }

    .hero-content {
        position: relative;
        z-index: 10;
        color: white;
        max-width: 600px;
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
    }

    /* Search Component */
    .search-box {
        background: white;
        padding: 25px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        max-width: 900px;
        margin: -80px auto 80px;
        position: relative;
        z-index: 20;
    }

    .search-tabs {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--color-border);
        padding-bottom: 15px;
    }

    .search-tab {
        background: none;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-text-muted);
        cursor: pointer;
        padding: 5px 10px;
        position: relative;
    }

    .search-tab.active {
        color: var(--color-primary);
    }

    .search-tab.active::after {
        content: '';
        position: absolute;
        bottom: -16px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--color-primary);
    }

    .search-form {
        display: grid;
        grid-template-columns: 2fr 1.5fr 1fr auto;
        gap: 15px;
        align-items: center;
    }
    
    .search-input-group {
        display: flex;
        align-items: center;
        background: var(--color-surface);
        border-radius: var(--border-radius);
        padding: 10px 15px;
        border: 1px solid var(--color-border);
    }

    .search-input-group i {
        color: var(--color-primary);
        margin-right: 10px;
    }

    .search-input-group input, .search-input-group select {
        border: none;
        background: transparent;
        width: 100%;
        font-size: 0.95rem;
        color: var(--color-text-main);
    }

    .search-input-group input:focus, .search-input-group select:focus {
        outline: none;
    }

    /* About Section */
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
    
    .about-feature i {
        color: var(--color-accent);
        font-size: 1.5rem;
        margin-top: 5px;
    }

    /* Stats */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        background: white;
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        margin-top: 40px;
        text-align: center;
    }
    
    .stat-item h3 {
        font-size: 2.5rem;
        color: var(--color-primary);
        margin-bottom: 5px;
    }
    
    .stat-item p {
        color: var(--color-text-muted);
        font-weight: 500;
    }

    /* Category Grid */
    .category-grid {
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
        margin-top: -10px;
    }

    /* Tablet Responsive (max-width: 991px) */
    @media (max-width: 991px) {
        .hero-section {
            padding: 80px 0;
            margin-bottom: 60px;
        }
        .hero-title {
            font-size: 2.75rem;
        }
        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .about-section {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
            padding: 30px;
            gap: 25px;
        }
        .search-box {
            margin: -60px 20px 60px;
            padding: 20px;
        }
        .search-form {
            grid-template-columns: 1fr 1fr;
        }
        .search-tabs {
            gap: 15px;
        }
        .category-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Mobile Responsive (max-width: 767px) */
    @media (max-width: 767px) {
        .hero-section {
            padding: 60px 0;
            margin-bottom: 50px;
            border-radius: 0 0 20px 20px;
        }
        .hero-overlay {
            border-radius: 0 0 20px 20px;
        }
        .hero-title {
            font-size: 2rem;
        }
        .hero-subtitle {
            font-size: 0.95rem;
            margin-bottom: 25px;
        }
        .hero-content {
            max-width: 100%;
        }
        .search-box {
            margin: -40px 16px 40px;
            padding: 18px;
        }
        .search-form {
            grid-template-columns: 1fr;
        }
        .search-tabs {
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-tab {
            font-size: 0.9rem;
        }
        .stats-container {
            grid-template-columns: 1fr 1fr;
            padding: 25px 20px;
            gap: 20px;
        }
        .stat-item h3 {
            font-size: 1.8rem;
        }
        .stat-item p {
            font-size: 0.85rem;
        }
        .about-section {
            gap: 30px;
        }
        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Small Mobile Responsive (max-width: 480px) */
    @media (max-width: 480px) {
        .hero-section {
            padding: 45px 0;
            margin-bottom: 40px;
            border-radius: 0 0 16px 16px;
        }
        .hero-overlay {
            border-radius: 0 0 16px 16px;
        }
        .hero-title {
            font-size: 1.65rem;
            margin-bottom: 15px;
        }
        .hero-subtitle {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .search-box {
            margin: -30px 12px 30px;
            padding: 15px;
        }
        .stats-container {
            grid-template-columns: 1fr;
            padding: 20px 15px;
            gap: 15px;
        }
        .stat-item h3 {
            font-size: 1.5rem;
        }
        .category-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" aria-label="Banner Utama Pencarian Properti">
        <div class="hero-overlay"></div>
        <div class="container hero-content" data-scroll>
            <h1 class="hero-title">{{ $settings['hero_title'] ?? 'Temukan Properti Impian Anda di Yogyakarta' }}</h1>
            <p class="hero-subtitle">{{ $settings['hero_subtitle'] ?? 'Jelajahi ribuan listing rumah, apartemen, dan tanah terpercaya. Proses mudah, transparan, dan didampingi agen profesional.' }}</p>
        </div>
    </section>



    <!-- Browse By Category -->
    <section class="section section-light" aria-labelledby="judul-kategori">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
                <div data-scroll>
                    <h2 class="section-title" id="judul-kategori" style="margin-bottom: 5px;">Kategori Properti di Yogyakarta</h2>
                    <p class="section-subtitle">Temukan properti sesuai kebutuhan dan anggaran Anda</p>
                </div>
            </div>
            
            <div class="grid category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('properties.index', ['category' => $category->slug]) }}" class="category-card" data-scroll title="{{ $category->name }} di Yogyakarta - {{ $category->properties_count }} Properti Tersedia">
                        <div class="category-icon">
                            <i class="fa-solid {{ $category->icon ?? 'fa-house' }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="category-title">{{ $category->name }}</h3>
                        <p class="category-count">{{ $category->properties_count }} Properti</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section section-muted" aria-labelledby="judul-tentang">
        <div class="container about-section">
            <div class="about-image" data-scroll>
                <img src="{{ $settings['about_image'] ?? 'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=800&q=80' }}" alt="Tim agen properti profesional DJM Property Yogyakarta" loading="lazy" width="600" height="450">
            </div>
            <div class="about-content" data-scroll>
                <h2 class="section-title" id="judul-tentang" style="font-size: 2.5rem;">{{ $settings['about_title'] ?? 'Mitra Terpercaya dalam Investasi Properti Yogyakarta' }}</h2>
                <p style="color: var(--color-text-muted); font-size: 1.1rem; margin-bottom: 30px;">
                    {{ $settings['about_description'] ?? 'Kami membantu Anda menemukan, membeli, dan mengelola properti dengan proses yang mudah, transparan, dan terpercaya bersama agen berpengalaman.' }}
                </p>
                
                <div class="about-features">
                    <div class="about-feature">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <div>
                            <h4 style="font-size: 1.1rem; margin-bottom: 5px;">Bimbingan Agen Ahli</h4>
                            <p style="color: var(--color-text-muted);">Didampingi oleh agen properti profesional dan berpengalaman di Yogyakarta.</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <div>
                            <h4 style="font-size: 1.1rem; margin-bottom: 5px;">Proses Transaksi Transparan</h4>
                            <p style="color: var(--color-text-muted);">Proses jual beli dan sewa yang jelas, aman, dan tanpa biaya tersembunyi.</p>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('about.index') }}" class="btn btn-primary" style="margin-top: 20px;" title="Pelajari lebih lanjut tentang DJM Property">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        
        <div class="container">
            <div class="stats-container" aria-label="Statistik pencapaian DJM Property">
                <div class="stat-item" data-scroll>
                    <h3>{{ $stats['total_properties'] }}+</h3>
                    <p>Properti Terdaftar</p>
                </div>
                <div class="stat-item" data-scroll>
                    <h3>{{ $stats['total_clients'] }}</h3>
                    <p>Klien Puas</p>
                </div>
                <div class="stat-item" data-scroll>
                    <h3>{{ $stats['total_agents'] }}+</h3>
                    <p>Agen Profesional</p>
                </div>
                <div class="stat-item" data-scroll>
                    <h3>{{ $stats['support'] }}</h3>
                    <p>Layanan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Properties -->
    <section class="section section-light" aria-labelledby="judul-unggulan">
        <div class="container">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; gap: 15px;">
                <div data-scroll>
                    <h2 class="section-title" id="judul-unggulan" style="margin-bottom: 5px;">Properti Unggulan di Yogyakarta</h2>
                    <p class="section-subtitle" style="margin:0;">Pilihan properti terbaik yang dikurasi khusus untuk Anda</p>
                </div>
                <a href="{{ route('properties.index') }}" style="font-weight: 600; display: flex; align-items: center; gap: 5px; white-space: nowrap;" title="Lihat semua properti di Yogyakarta">
                    Lihat Semua Properti <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            
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
                            <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">
                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }} - {{ $property->location_string }}" loading="lazy">
                            </a>
                        </div>
                        <div class="property-card-content">
                            <h3 class="property-title">
                                <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">{{ Str::limit($property->title, 50) }}</a>
                            </h3>
                            <div class="property-price">{{ $property->formatted_price }}</div>
                            <div class="property-location">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $property->location_string }}
                            </div>
                            <div class="property-specs">
                                @if($property->bedrooms)
                                    <div class="property-spec" title="Kamar Tidur">
                                        <i class="fa-solid fa-bed" aria-hidden="true"></i> {{ $property->bedrooms }} KT
                                    </div>
                                @endif
                                @if($property->bathrooms)
                                    <div class="property-spec" title="Kamar Mandi">
                                        <i class="fa-solid fa-bath" aria-hidden="true"></i> {{ $property->bathrooms }} KM
                                    </div>
                                @endif
                                @if($property->land_area)
                                    <div class="property-spec" title="Luas Tanah">
                                        <i class="fa-solid fa-ruler-combined" aria-hidden="true"></i> {{ $property->land_area }} m&sup2;
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>



@endsection

@extends('layouts.app')

@section('title', 'Portfolio Proyek | DJM Desty Jaya Mandiri')
@section('meta_description', 'Lihat portfolio pekerjaan DJM Desty Jaya Mandiri: perizinan, konstruksi, dan properti yang telah berhasil dikerjakan.')
@section('canonical', url('/portfolio'))

@push('scripts')
<style>
    .portfolio-filter-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 40px;
    }

    .filter-btn {
        padding: 10px 24px;
        border-radius: 50px;
        border: 2px solid var(--color-border);
        background: white;
        color: var(--color-text-muted);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        border-color: var(--color-gilded);
        background: var(--color-gilded);
        color: var(--color-noir);
    }

    .portfolio-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .portfolio-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .portfolio-card-image {
        position: relative;
        overflow: hidden;
        height: 220px;
    }

    .portfolio-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .portfolio-card:hover .portfolio-card-image img {
        transform: scale(1.05);
    }

    .portfolio-category-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: var(--color-champagne);
        color: var(--color-bronze);
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .portfolio-card-body {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .portfolio-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .portfolio-card-meta {
        display: flex;
        gap: 16px;
        color: var(--color-text-muted);
        font-size: 0.875rem;
        margin-bottom: 16px;
    }

    .portfolio-card-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .portfolio-card-desc {
        color: var(--color-text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        flex-grow: 1;
        margin-bottom: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: var(--color-text-muted);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--color-border);
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: var(--color-text-main);
    }

    .cta-portfolio {
        background: linear-gradient(135deg, var(--color-noir) 0%, var(--color-espresso) 100%);
        color: var(--color-champagne);
        padding: 70px 40px;
        text-align: center;
        border-radius: var(--border-radius-lg);
        margin: 60px 0 80px;
    }

    .cta-portfolio h2 {
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--color-champagne);
    }

    .cta-portfolio p {
        font-size: 1.05rem;
        opacity: 0.9;
        max-width: 550px;
        margin: 0 auto 30px;
    }

    @media (max-width: 767px) {
        .portfolio-card-image {
            height: 180px;
        }
        .portfolio-filter-bar {
            gap: 8px;
        }
        .filter-btn {
            padding: 8px 18px;
            font-size: 0.85rem;
        }
        .cta-portfolio {
            padding: 50px 20px;
        }
        .cta-portfolio h2 {
            font-size: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header" style="background: linear-gradient(rgba(251, 244, 228, 0.88), rgba(251, 244, 228, 0.88)), url('{{ asset('images/headermenu/gambar4.jpg') }}') center / cover no-repeat var(--color-champagne);">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Portfolio Kami</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Dokumentasi pekerjaan dan proyek yang telah berhasil diselesaikan DJM — dari perizinan, konstruksi, hingga properti.
            </p>
        </div>
    </div>

    <div class="container">
        {{-- Filter Kategori --}}
        <div class="portfolio-filter-bar" role="group" aria-label="Filter kategori portfolio">
            <button class="filter-btn active" data-filter="semua">Semua</button>
            <button class="filter-btn" data-filter="perizinan">Perizinan</button>
            <button class="filter-btn" data-filter="konstruksi">Konstruksi</button>
            <button class="filter-btn" data-filter="properti">Properti</button>
            <button class="filter-btn" data-filter="lainnya">Lainnya</button>
        </div>

        {{-- Portfolio Grid --}}
        @if($portfolios->count() > 0)
            <div class="grid grid-cols-3" id="portfolio-grid">
                @foreach($portfolios as $portfolio)
                    <article class="portfolio-card" data-category="{{ strtolower($portfolio->category ?? 'lainnya') }}" data-scroll>
                        <div class="portfolio-card-image">
                            <img src="{{ $portfolio->image_url ?? 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80' }}"
                                 alt="{{ $portfolio->title }}" loading="lazy">
                            <span class="portfolio-category-badge">{{ $portfolio->category ?? 'Lainnya' }}</span>
                        </div>
                        <div class="portfolio-card-body">
                            <h2 class="portfolio-card-title">{{ $portfolio->title }}</h2>
                            <div class="portfolio-card-meta">
                                @if($portfolio->location)
                                    <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $portfolio->location }}</span>
                                @endif
                                @if($portfolio->year)
                                    <span><i class="fa-solid fa-calendar" aria-hidden="true"></i> {{ $portfolio->year }}</span>
                                @endif
                            </div>
                            <p class="portfolio-card-desc">{{ Str::limit(strip_tags($portfolio->description ?? ''), 120) }}</p>
                            <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="btn btn-outline" style="align-self: flex-start;">
                                Lihat Detail <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            {{-- Empty state: tampilkan contoh portfolio statis --}}
            <div class="grid grid-cols-3" id="portfolio-grid">
                @php
                $demoPortfolios = [
                    [
                        'title' => 'Pengurusan PBG / IMB Rumah Tinggal',
                        'category' => 'Perizinan',
                        'location' => 'Sleman, Yogyakarta',
                        'year' => '2024',
                        'desc' => 'Pengurusan Persetujuan Bangunan Gedung untuk rumah tinggal 2 lantai seluas 200 m² di kawasan perumahan Sleman.',
                        'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600&q=80',
                        'filter' => 'perizinan',
                    ],
                    [
                        'title' => 'Pembangunan Rumah Minimalis Modern',
                        'category' => 'Konstruksi',
                        'location' => 'Bantul, Yogyakarta',
                        'year' => '2024',
                        'desc' => 'Pembangunan rumah tinggal konsep minimalis modern 3 kamar tidur di atas lahan 180 m² selesai tepat waktu.',
                        'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600&q=80',
                        'filter' => 'konstruksi',
                    ],
                    [
                        'title' => 'Penjualan Kavling Strategis',
                        'category' => 'Properti',
                        'location' => 'Godean, Sleman',
                        'year' => '2024',
                        'desc' => 'Berhasil membantu penjualan kavling tanah strategis dekat jalan utama dengan proses cepat hanya 3 minggu.',
                        'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600&q=80',
                        'filter' => 'properti',
                    ],
                    [
                        'title' => 'Pecah Sertifikat Tanah Warisan',
                        'category' => 'Perizinan',
                        'location' => 'Kulon Progo',
                        'year' => '2023',
                        'desc' => 'Proses pemecahan sertifikat tanah warisan menjadi 4 bidang terpisah berhasil diselesaikan dengan lancar.',
                        'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=600&q=80',
                        'filter' => 'perizinan',
                    ],
                    [
                        'title' => 'Renovasi Ruko 2 Lantai',
                        'category' => 'Konstruksi',
                        'location' => 'Kota Yogyakarta',
                        'year' => '2023',
                        'desc' => 'Renovasi total ruko 2 lantai di pusat kota meliputi struktur, interior, dan fasad dengan hasil memuaskan.',
                        'image' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=80',
                        'filter' => 'konstruksi',
                    ],
                    [
                        'title' => 'Pengurusan Pengeringan Lahan',
                        'category' => 'Perizinan',
                        'location' => 'Seyegan, Sleman',
                        'year' => '2023',
                        'desc' => 'Pengurusan izin pengeringan lahan sawah untuk keperluan pembangunan perumahan seluas 2.500 m².',
                        'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&q=80',
                        'filter' => 'perizinan',
                    ],
                ];
                @endphp

                @foreach($demoPortfolios as $item)
                    <article class="portfolio-card" data-category="{{ $item['filter'] }}" data-scroll>
                        <div class="portfolio-card-image">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                            <span class="portfolio-category-badge">{{ $item['category'] }}</span>
                        </div>
                        <div class="portfolio-card-body">
                            <h2 class="portfolio-card-title">{{ $item['title'] }}</h2>
                            <div class="portfolio-card-meta">
                                <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $item['location'] }}</span>
                                <span><i class="fa-solid fa-calendar" aria-hidden="true"></i> {{ $item['year'] }}</span>
                            </div>
                            <p class="portfolio-card-desc">{{ $item['desc'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        {{-- CTA Section --}}
        <div class="cta-portfolio" data-scroll>
            <h2>Ingin Menggunakan Jasa DJM?</h2>
            <p>Konsultasikan kebutuhan perizinan, konstruksi, atau properti Anda langsung bersama tim ahli kami.</p>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Support\Site::get('contact_whatsapp', '628216726285')) }}?text=Halo%20DJM%2C%20saya%20ingin%20berkonsultasi%20mengenai%20layanan%20DJM."
               target="_blank" rel="noopener noreferrer"
               class="btn btn-white"
               style="padding: 14px 36px; font-size: 1.05rem; display: inline-flex; align-items: center; gap: 10px;">
                <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Filter portfolio
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            document.querySelectorAll('.portfolio-card').forEach(card => {
                if (filter === 'semua' || card.dataset.category === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush

@extends('layouts.app')

@section('title', 'Tentang Kami - DJM Property')
@section('meta_description', 'Pelajari lebih lanjut tentang DJM Property, visi, misi, dan tim profesional di balik layanan properti terpercaya di Yogyakarta.')

@push('scripts')
<style>


    .about-content-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 80px;
    }

    .about-content-section.reverse {
        grid-template-columns: 1fr 1fr;
        direction: rtl;
    }

    .about-content-section.reverse > div {
        direction: ltr;
    }

    .about-image {
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .about-text h2 {
        font-size: 2.25rem;
        color: var(--color-text-main);
        margin-bottom: 20px;
    }

    .about-text p {
        font-size: 1.1rem;
        color: var(--color-text-muted);
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .values-section {
        background: linear-gradient(135deg, var(--color-champagne) 0%, #FBF4E4 100%);
        color: var(--color-noir);
        padding: 80px 0;
        margin-bottom: 80px;
    }

    .value-card {
        background: #FFFFFF;
        padding: 40px 30px;
        border-radius: var(--border-radius-lg);
        text-align: center;
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--color-bronze);
        margin-bottom: 20px;
    }

    .value-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-text-main);
        margin-bottom: 15px;
    }

    @media (max-width: 991px) {
        .about-content-section, .about-content-section.reverse {
            grid-template-columns: 1fr;
            direction: ltr;
            gap: 40px;
        }
        .about-content-section {
            margin-bottom: 60px;
        }
    }

    @media (max-width: 767px) {
        .about-content-section, .about-content-section.reverse {
            gap: 30px;
            margin-bottom: 40px;
        }
        .about-text h2 {
            font-size: 1.75rem;
        }
        .about-text p {
            font-size: 1rem;
        }
        .values-section {
            padding: 50px 0;
            margin-bottom: 50px;
        }
        .value-card {
            padding: 30px 20px;
        }
        .value-icon {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .about-text h2 {
            font-size: 1.45rem;
        }
        .about-text p {
            font-size: 0.95rem;
        }
        .value-card {
            padding: 25px 15px;
        }
        .value-title {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header" style="background: var(--color-champagne);">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Tentang DJM Property</h1>
            <p style="font-size: 1.125rem; color: var(--color-text-muted);">
                Kami adalah platform properti digital terdepan di Yogyakarta yang berdedikasi untuk memberikan pengalaman pencarian dan transaksi properti terbaik.
            </p>
        </div>
    </div>

    <div class="container">
        <!-- Story Section -->
        <div class="about-content-section" data-scroll>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&q=80" alt="DJM Property Office">
            </div>
            <div class="about-text">
                <h2>Cerita Kami</h2>
                <p>
                    Didirikan pada tahun 2020, DJM Property berawal dari visi sederhana: menyederhanakan proses kompleks dalam industri real estate. Kami menyadari bahwa mencari, membeli, atau menjual properti seringkali menjadi proses yang membingungkan dan melelahkan bagi banyak orang.
                </p>
                <p>
                    Dengan menggabungkan teknologi modern dan keahlian lokal yang mendalam, kami membangun platform yang tidak hanya menampilkan listing properti berkualitas, tetapi juga memberikan panduan komprehensif bagi setiap klien kami.
                </p>
            </div>
        </div>

        <!-- Vision Mission -->
        <div class="about-content-section reverse" data-scroll>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80" alt="Tim DJM Property">
            </div>
            <div class="about-text">
                <h2>Visi & Misi</h2>
                <h4 style="font-size: 1.25rem; margin-bottom: 10px; color: var(--color-bronze);">Visi</h4>
                <p>
                    Menjadi ekosistem properti paling terpercaya dan inovatif di Indonesia yang memberdayakan masyarakat dalam membuat keputusan properti yang cerdas.
                </p>
                
                <h4 style="font-size: 1.25rem; margin-top: 20px; margin-bottom: 10px; color: var(--color-bronze);">Misi</h4>
                <ul style="color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.8; padding-left: 20px; margin-bottom: 20px;">
                    <li>Menyediakan platform properti yang mudah digunakan, transparan, dan informatif.</li>
                    <li>Membangun jaringan agen properti yang profesional, beretika, dan berfokus pada klien.</li>
                    <li>Memberikan layanan end-to-end yang mengutamakan kepuasan dan keamanan transaksi.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="values-section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; margin-bottom: 15px;">Nilai-Nilai Kami</h2>
                <p style="font-size: 1.1rem; opacity: 0.9;">Prinsip yang membimbing setiap langkah kami</p>
            </div>
            
            <div class="grid grid-cols-3">
                <div class="value-card" data-scroll>
                    <div class="value-icon"><i class="fa-solid fa-handshake"></i></div>
                    <h3 class="value-title">Integritas</h3>
                    <p style="color: var(--color-text-muted); line-height: 1.6;">Kami menjunjung tinggi kejujuran, transparansi, dan standar etika tertinggi dalam setiap transaksi.</p>
                </div>
                <div class="value-card" data-scroll>
                    <div class="value-icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <h3 class="value-title">Inovasi</h3>
                    <p style="color: var(--color-text-muted); line-height: 1.6;">Terus berinovasi mengembangkan solusi teknologi untuk menyederhanakan pengalaman properti Anda.</p>
                </div>
                <div class="value-card" data-scroll>
                    <div class="value-icon"><i class="fa-solid fa-heart"></i></div>
                    <h3 class="value-title">Fokus Klien</h3>
                    <p style="color: var(--color-text-muted); line-height: 1.6;">Keberhasilan kami diukur dari kepuasan dan pencapaian tujuan properti setiap klien kami.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="container" style="margin-bottom: 80px; text-align: center;" data-scroll>
        <h2 style="font-size: 2rem; margin-bottom: 20px;">Siap Memulai Perjalanan Properti Anda?</h2>
        <p style="color: var(--color-text-muted); font-size: 1.1rem; margin-bottom: 30px;">
            Bergabunglah dengan ribuan klien yang telah mempercayakan kebutuhan properti mereka kepada DJM Property.
        </p>
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <a href="{{ route('properties.index') }}" class="btn btn-primary" style="padding: 12px 30px; font-size: 1.1rem;">Cari Properti</a>
            <a href="{{ route('contact.index') }}" class="btn btn-outline" style="padding: 12px 30px; font-size: 1.1rem;">Hubungi Kami</a>
        </div>
    </div>
@endsection

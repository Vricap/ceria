@extends('layouts.app')

@section('title', 'Layanan - DJM Property')
@section('meta_description', 'Layanan perizinan dan konstruksi dari DJM Desty Jaya Mandiri: PBG/IMB, pengeringan, pecah sertifikat, pembangunan, dan renovasi.')

@php
    $contactWhatsapp = \App\Models\SiteSetting::get('contact_whatsapp', '+62 812 3456 7890');
    $waNumber = preg_replace('/[^0-9]/', '', $contactWhatsapp);
@endphp

@push('scripts')
<style>


    .service-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-gilded);
    }

    .service-image-wrapper {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .service-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-image {
        transform: scale(1.05);
    }

    .service-content {
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .service-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--color-text-main);
    }

    .service-desc {
        color: var(--color-text-muted);
        line-height: 1.6;
        margin-bottom: 25px;
        flex-grow: 1;
    }

    .service-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: auto;
    }

    .btn-whatsapp-outline {
        border: 1px solid #25D366;
        color: #25D366;
        background: transparent;
        padding: 10px 20px;
        border-radius: var(--border-radius-md);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-whatsapp-outline:hover {
        background: #25D366;
        color: white;
    }

    .cta-section {
        background: linear-gradient(135deg, var(--color-noir) 0%, var(--color-espresso) 100%);
        color: var(--color-champagne);
        padding: 60px 0;
        text-align: center;
        border-radius: var(--border-radius-lg);
        margin: 60px 0 80px;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    @media (max-width: 991px) {
        .cta-title {
            font-size: 2.25rem;
        }
    }

    @media (max-width: 767px) {
        .service-content {
            padding: 25px 20px;
        }
        .service-title {
            font-size: 1.35rem;
        }
        .cta-section {
            padding: 45px 20px;
            margin: 40px 0 60px;
        }
        .cta-title {
            font-size: 1.85rem;
        }
    }

    @media (max-width: 480px) {
        .service-content {
            padding: 20px 15px;
        }
        .service-title {
            font-size: 1.25rem;
        }
        .cta-section {
            padding: 35px 20px;
        }
        .cta-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header" style="background: linear-gradient(rgba(251, 244, 228, 0.88), rgba(251, 244, 228, 0.88)), url('{{ asset('images/headermenu/gambar2.jpg') }}') center / cover no-repeat var(--color-champagne);">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Layanan Kami</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Layanan perizinan dan konstruksi dari DJM — Desty Jaya Mandiri untuk memenuhi kebutuhan bangunan, lahan, dan properti Anda di Yogyakarta dan sekitarnya.
            </p>
        </div>
    </div>

    <div class="container">
        @foreach($services as $category => $categoryServices)
            @php
                $categoryName = $categoryServices->first()->category_name;
                $categoryIcon = $category === 'konstruksi' ? 'fa-helmet-safety' : 'fa-file-shield';
            @endphp

            <div style="text-align: center; max-width: 600px; margin: {{ $loop->first ? '0 auto 35px' : '70px auto 35px' }};">
                <i class="fa-solid {{ $categoryIcon }}" style="font-size: 1.6rem; color: var(--color-bronze); margin-bottom: 12px; display: inline-block;"></i>
                <h2 class="section-title" style="font-size: 2rem; margin-bottom: 10px;">{{ $categoryName }}</h2>
                <p style="color: var(--color-text-muted); font-size: 1.05rem;">
                    @if($category === 'perizinan')
                        Kami membantu pengurusan legalitas bangunan dan lahan secara resmi dan tepat waktu.
                    @else
                        Tim konstruksi kami siap mewujudkan bangunan dari perencanaan hingga selesai.
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-3">
                @foreach($categoryServices as $service)
                    <div class="service-card">
                        <div class="service-image-wrapper">
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="service-image" loading="lazy">
                        </div>
                        <div class="service-content">
                            <span style="display: inline-block; background: var(--color-champagne); color: var(--color-bronze); font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; margin-bottom: 14px; align-self: center;">
                                <i class="fa-solid {{ $service->icon }}"></i> {{ $service->category_name }}
                            </span>
                            <h2 class="service-title">{{ $service->name }}</h2>
                            <p class="service-desc">{{ $service->short_description ?? Str::limit(strip_tags($service->description), 150) }}</p>

                            <div class="service-actions">
                                <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline" style="width: 100%;">Pelajari Lebih Lanjut</a>
                                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo DJM, saya ingin berkonsultasi mengenai layanan ' . $service->name . '.') }}" target="_blank" class="btn-whatsapp-outline" style="width: 100%;">
                                    <i class="fa-brands fa-whatsapp"></i> Konsultasi via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="cta-section">
            <h2 class="cta-title">Butuh Bantuan Lebih Lanjut?</h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                Tim DJM siap memberikan konsultasi gratis untuk kebutuhan perizinan dan konstruksi Anda.
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-white" style="padding: 12px 30px; font-size: 1.1rem;">Hubungi Kami Sekarang</a>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Layanan - DJM Property')
@section('meta_description', 'Layanan properti profesional dari DJM Property: Beli, Jual, Sewa, dan Manajemen Properti.')

@push('scripts')
<style>


    .service-card {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        padding: 40px 30px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-primary);
    }

    .service-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--color-surface);
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 25px;
        transition: all 0.3s ease;
    }

    .service-card:hover .service-icon {
        background: var(--color-primary);
        color: white;
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

    .cta-section {
        background-color: var(--color-primary);
        color: white;
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
        .service-card {
            padding: 30px 25px;
        }
        .service-icon {
            width: 70px;
            height: 70px;
            font-size: 1.75rem;
            margin-bottom: 20px;
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
        .service-card {
            padding: 25px 20px;
        }
        .service-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
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
    <div class="page-header">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Layanan Kami</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Solusi properti komprehensif untuk memenuhi setiap kebutuhan Anda. Dari mencari rumah impian hingga mengelola investasi.
            </p>
        </div>
    </div>

    <div class="container">
        <div class="grid grid-cols-3">
            @foreach($services as $service)
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fa-solid {{ $service->icon ?? 'fa-handshake' }}"></i>
                    </div>
                    <h2 class="service-title">{{ $service->title }}</h2>
                    <p class="service-desc">{{ Str::limit(strip_tags($service->description), 150) }}</p>
                    <a href="#" class="btn btn-outline" style="align-self: center;">Pelajari Lebih Lanjut</a>
                </div>
            @endforeach
        </div>

        <div class="cta-section">
            <h2 class="cta-title">Butuh Bantuan Lebih Lanjut?</h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                Tim ahli kami siap memberikan konsultasi gratis untuk setiap kebutuhan properti Anda.
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-white" style="padding: 12px 30px; font-size: 1.1rem;">Hubungi Kami Sekarang</a>
        </div>
    </div>
@endsection

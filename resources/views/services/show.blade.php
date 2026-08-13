@extends('layouts.app')

@section('title', $service->name . ' - DJM Desty Jaya Mandiri')
@section('meta_description', Str::limit(strip_tags($service->short_description ?? $service->description), 160))
@section('og_image', $service->image_url)

@php
    $contactWhatsapp = \App\Models\SiteSetting::get('contact_whatsapp', '+62 812 3456 7890');
    $waNumber = preg_replace('/[^0-9]/', '', $contactWhatsapp);
    $waMessage = 'Halo DJM, saya ingin berkonsultasi mengenai layanan ' . $service->name . '.';
@endphp

@push('scripts')
<style>
    .service-detail-hero {
        background-color: var(--color-surface);
        padding: 60px 0;
        margin-bottom: 60px;
        text-align: center;
        border-bottom: 1px solid var(--color-border);
    }

    .service-detail-badge {
        display: inline-block;
        background: var(--color-champagne);
        color: var(--color-bronze);
        font-size: 0.85rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 18px;
    }

    .service-detail-icon {
        font-size: 2.5rem;
        color: var(--color-bronze);
        margin-bottom: 20px;
    }

    .service-detail-body {
        max-width: 800px;
        margin: 0 auto 80px;
    }

    .service-detail-body h2 {
        font-size: 1.5rem;
        color: var(--color-text-main);
        margin: 45px 0 18px;
        font-weight: 700;
    }

    .service-detail-body h2:first-of-type {
        margin-top: 0;
    }

    .service-detail-body p,
    .service-detail-body li {
        color: var(--color-text-muted);
        line-height: 1.8;
    }

    .service-detail-body ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .service-detail-body ul li {
        position: relative;
        padding-left: 28px;
        margin-bottom: 12px;
    }

    .service-detail-body ul li::before {
        content: "\f058";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        color: var(--color-accent);
        position: absolute;
        left: 0;
        top: 2px;
    }

    .wa-box {
        background: linear-gradient(135deg, var(--color-noir) 0%, var(--color-espresso) 100%);
        color: var(--color-champagne);
        padding: 45px 30px;
        border-radius: var(--border-radius-lg);
        text-align: center;
        margin-bottom: 80px;
    }
</style>
@endpush

@section('content')
    <div class="service-detail-hero">
        <div class="container" style="max-width: 800px;">
            <span class="service-detail-badge"><i class="fa-solid {{ $service->icon }}"></i> {{ $service->category_name }}</span>
            <div class="service-detail-icon"><i class="fa-solid {{ $service->icon }}"></i></div>
            <h1 class="page-title" style="font-size: 2.5rem;">{{ $service->name }}</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem; max-width: 650px; margin: 0 auto;">
                {{ $service->short_description }}
            </p>
        </div>
    </div>

    <div class="container service-detail-body">
        @if($service->description)
            <div class="service-rich">
                {!! $service->description !!}
            </div>
        @else
            <h2>Deskripsi Layanan</h2>
            <p>{{ $service->short_description }}</p>
        @endif

        <div style="background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--border-radius-lg); padding: 28px; margin-top: 45px;">
            <h2 style="margin-top: 0;">Informasi &amp; Konsultasi</h2>
            <p style="margin-bottom: 8px;">Butuh informasi lebih lanjut mengenai layanan <strong>{{ $service->name }}</strong>? Tim DJM siap membantu Anda.</p>
            <p style="margin-bottom: 0;">Konsultasi melalui WhatsApp untuk mendapatkan penjelasan detail, persyaratan, proses, dan estimasi.</p>
        </div>
    </div>

    <div class="container">
        <div class="wa-box">
            <h2 style="font-size: 1.9rem; font-weight: 700; margin-bottom: 15px;">Tertarik dengan {{ $service->name }}?</h2>
            <p style="font-size: 1.05rem; opacity: 0.9; margin-bottom: 28px; max-width: 550px; margin-left: auto; margin-right: auto;">
                Konsultasikan kebutuhan Anda dengan tim DJM — gratis dan tanpa komitmen.
            </p>
            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" target="_blank" rel="noopener noreferrer" class="btn btn-white" style="padding: 14px 34px; font-size: 1.1rem; font-weight: 700;">
                <i class="fa-brands fa-whatsapp"></i> Konsultasikan via WhatsApp
            </a>
        </div>
    </div>

    @if($services->count() > 0)
    <div class="container" style="margin-bottom: 80px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 class="section-title">Layanan Lainnya</h2>
            <p class="section-subtitle">Jelajahi layanan lain dari DJM</p>
        </div>
        <div class="grid grid-cols-3">
            @foreach($services as $other)
                <div class="service-card" style="background: white; border: 1px solid var(--color-border); border-radius: var(--border-radius-lg); padding: 30px 20px; text-align: center; box-shadow: var(--shadow-sm);">
                    <div style="font-size: 2rem; color: var(--color-bronze); margin-bottom: 15px;"><i class="fa-solid {{ $other->icon }}"></i></div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 10px; color: var(--color-text-main);">{{ $other->name }}</h3>
                    <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 20px;">{{ $other->short_description }}</p>
                    <a href="{{ route('services.show', $other->slug) }}" class="btn btn-outline" style="width: 100%;">Lihat Detail</a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection

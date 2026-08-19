@extends('layouts.app')

@section('title', $service->seo_title ?: $service->name . ' | DJM Property')
@section('meta_description', $service->seo_description ?: Str::limit(strip_tags($service->short_description ?? $service->description), 160))
@section('og_image', $service->image_url)

@section('canonical', url('/layanan/' . $service->slug))

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ url('/') }}"
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": "Layanan",
      "item": "{{ route('services.index') }}"
    },
    {
      "@@type": "ListItem",
      "position": 3,
      "name": "{{ $service->name }}"
    }
  ]
}
</script>
@endsection

@php
    $contactWhatsapp = \App\Models\SiteSetting::get('contact_whatsapp', '+62 812 3456 7890');
    $waNumber = preg_replace('/[^0-9]/', '', $contactWhatsapp);
    $waMessage = 'Halo DJM, saya ingin berkonsultasi mengenai layanan ' . $service->name . '.';
@endphp

@push('scripts')
<style>
    /* ═══════════════════════════════════════════════
       HERO — page-header style (match Tentang Kami)
       ═══════════════════════════════════════════════ */
    .svc-hero {
        text-align: center;
    }

    /* ═══════════════════════════════════════════════
       SECTION UTAMA (di dalam container)
       ═══════════════════════════════════════════════ */
    .svc-main {
        padding: 70px 0 0;
    }

    /* ── Highlight Strip ── */
    .svc-highlights-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 70px;
    }

    .svc-hl-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 28px 24px;
        background: white;
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .svc-hl-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow);
        border-color: var(--color-gilded);
    }

    .svc-hl-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        background: var(--color-champagne);
        color: var(--color-bronze);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .svc-hl-card:hover .svc-hl-icon {
        background: var(--color-gilded);
        color: var(--color-noir);
    }

    .svc-hl-text h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 5px;
    }

    .svc-hl-text p {
        font-size: 0.92rem;
        color: var(--color-text-muted);
        line-height: 1.55;
    }

    /* ── Rich Content ── */
    .svc-rich {
        max-width: 800px;
        margin: 0 auto 70px;
    }

    .svc-rich h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin: 55px 0 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--color-champagne);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .svc-rich h2:first-child {
        margin-top: 0;
    }

    .svc-rich h2 .svc-h2-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        background: var(--color-champagne);
        color: var(--color-bronze);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .svc-rich h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-bronze);
        margin: 32px 0 12px;
        padding-left: 16px;
        border-left: 3px solid var(--color-gilded);
    }

    .svc-rich p {
        font-size: 1.05rem;
        color: var(--color-text-muted);
        line-height: 1.8;
        margin-bottom: 16px;
    }

    .svc-rich ul {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }

    .svc-rich ul li {
        position: relative;
        padding: 10px 0 10px 32px;
        font-size: 1rem;
        color: var(--color-text-muted);
        line-height: 1.6;
        border-bottom: 1px solid rgba(234, 223, 203, 0.4);
    }

    .svc-rich ul li:last-child {
        border-bottom: none;
    }

    .svc-rich ul li::before {
        content: "\f058";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        color: var(--color-accent);
        position: absolute;
        left: 2px;
        top: 12px;
        font-size: 0.82rem;
    }

    .svc-rich strong {
        color: var(--color-text-main);
        font-weight: 700;
    }

    /* ═══════════════════════════════════════════════
       CTA WHATSAPP — match homepage style
       ═══════════════════════════════════════════════ */
    .svc-cta-section {
        padding: 0 0 80px;
    }

    .svc-cta-card {
        background: linear-gradient(135deg, var(--color-noir) 0%, var(--color-espresso) 100%);
        color: var(--color-champagne);
        padding: 65px 30px;
        text-align: center;
        border-radius: var(--border-radius-lg);
        position: relative;
        overflow: hidden;
    }

    .svc-cta-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, rgba(212, 165, 105, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .svc-cta-card::after {
        content: '';
        position: absolute;
        bottom: -35%;
        right: 5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(212, 165, 105, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .svc-cta-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.3rem;
        font-weight: 700;
        margin-bottom: 16px;
        line-height: 1.2;
        position: relative;
        z-index: 1;
        color: var(--color-champagne);
    }

    .svc-cta-card p {
        font-size: 1.1rem;
        opacity: 0.85;
        margin-bottom: 32px;
        max-width: 520px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 1;
        line-height: 1.65;
    }

    .svc-cta-card .btn-whatsapp {
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
        box-shadow: 0 8px 25px rgba(212, 165, 105, 0.4);
    }

    .svc-cta-card .btn-whatsapp:hover {
        background: var(--color-gilded-dark);
        color: var(--color-noir);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(212, 165, 105, 0.55);
    }

    /* ═══════════════════════════════════════════════
       LAYANAN LAINNYA
       ═══════════════════════════════════════════════ */
    .svc-other-section {
        padding: 0 0 80px;
    }

    .svc-other-card {
        background: white;
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg);
        padding: 32px 22px;
        text-align: center;
        transition: all 0.35s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
    }

    .svc-other-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-gilded);
    }

    .svc-other-icon {
        width: 64px;
        height: 64px;
        background: var(--color-champagne);
        color: var(--color-bronze);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 18px;
        transition: all 0.3s ease;
    }

    .svc-other-card:hover .svc-other-icon {
        background: var(--color-gilded);
        color: var(--color-noir);
        transform: scale(1.08) rotate(5deg);
    }

    .svc-other-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 10px;
    }

    .svc-other-card p {
        color: var(--color-text-muted);
        font-size: 0.93rem;
        line-height: 1.6;
        margin-bottom: 22px;
        flex-grow: 1;
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════════════ */
    @media (max-width: 991px) {
        .svc-highlights-strip { grid-template-columns: 1fr; gap: 16px; }
        .svc-hl-card { padding: 22px 20px; }
    }

    @media (max-width: 767px) {
        .svc-main { padding: 50px 0 0; }

        .svc-rich { margin-bottom: 50px; }
        .svc-rich h2 { font-size: 1.35rem; margin: 40px 0 16px; }
        .svc-rich h3 { font-size: 1.05rem; }

        .svc-cta-card {
            padding: 45px 24px;
        }
        .svc-cta-card h2 { font-size: 1.7rem; }
        .svc-cta-card .btn-whatsapp { padding: 14px 30px; font-size: 1rem; }
    }

    @media (max-width: 480px) {
        .svc-cta-card h2 { font-size: 1.45rem; }
    }
</style>
@endpush

@section('content')
    {{-- ══════════ HERO ══════════ --}}
    <div class="page-header svc-hero" style="background: linear-gradient(rgba(251, 244, 228, 0.88), rgba(251, 244, 228, 0.88)), url('{{ $service->image_url }}') center / cover no-repeat var(--color-champagne);">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">{{ $service->name }}</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                {{ $service->short_description }}
            </p>
        </div>
    </div>

    {{-- ══════════ MAIN CONTENT ══════════ --}}
    <div class="svc-main">
        <div class="container">

            {{-- Highlight Strip --}}
            <div class="svc-highlights-strip" data-scroll>
                <div class="svc-hl-card">
                    <div class="svc-hl-icon"><i class="fa-solid fa-comments"></i></div>
                    <div class="svc-hl-text">
                        <h3>Konsultasi Gratis</h3>
                        <p>Diskusi kebutuhan tanpa biaya awal.</p>
                    </div>
                </div>
                <div class="svc-hl-card">
                    <div class="svc-hl-icon"><i class="fa-solid fa-file-shield"></i></div>
                    <div class="svc-hl-text">
                        <h3>Dokumen Lengkap</h3>
                        <p>Persiapan semua berkas yang dibutuhkan.</p>
                    </div>
                </div>
                <div class="svc-hl-card">
                    <div class="svc-hl-icon"><i class="fa-solid fa-headset"></i></div>
                    <div class="svc-hl-text">
                        <h3>Pendampingan Penuh</h3>
                        <p>Dari awal hingga proses selesai.</p>
                    </div>
                </div>
            </div>

            {{-- Rich Content --}}
            @if($service->description)
            <div id="detail-layanan" class="svc-rich" data-scroll>
                {!! $service->description !!}
            </div>
            @endif

        </div>
    </div>

    {{-- ══════════ CTA ══════════ --}}
    <div class="svc-cta-section">
        <div class="container">
            <div class="svc-cta-card" data-scroll>
                <h2>Tertarik dengan {{ $service->name }}?</h2>
                <p>Konsultasikan kebutuhan Anda dengan tim DJM — gratis, cepat, dan tanpa komitmen.</p>
                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp" title="Hubungi DJM via WhatsApp">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.3rem;"></i>
                    Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════ LAYANAN LAINNYA ══════════ --}}
    @if($services->count() > 0)
    <div class="svc-other-section">
        <div class="container">
            <div style="text-align: center; margin-bottom: 45px;" data-scroll>
                <h2 class="section-title">Layanan Lainnya</h2>
                <p class="section-subtitle">Jelajahi layanan lain dari DJM</p>
            </div>
            <div class="grid grid-cols-3">
                @foreach($services as $other)
                    <div class="svc-other-card" data-scroll>
                        <div class="svc-other-icon"><i class="fa-solid {{ $other->icon }}"></i></div>
                        <h3>{{ $other->name }}</h3>
                        <p>{{ $other->short_description }}</p>
                        <a href="{{ route('services.show', $other->slug) }}" class="btn btn-outline" style="width: 100%;">Lihat Detail</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection

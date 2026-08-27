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
    $contactWhatsapp = \App\Support\Site::get('contact_whatsapp', '+62 821 6726 285');
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
    .svc-hl-custom {
        display: grid;
        gap: 24px;
        margin-bottom: 24px;
    }

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
       DUAL SECTION — Alur Layanan + Dokumen (2-col)
       ═══════════════════════════════════════════════ */
    .svc-dual-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 80px;
    }

    .svc-dual-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--color-bronze);
        margin-bottom: 8px;
        padding: 6px 14px;
        background: var(--color-champagne);
        border-radius: var(--border-radius-full);
    }

    .svc-dual-label::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--color-gilded);
    }

    .svc-dual-alur h2,
    .svc-dual-dokumen h2 {
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin: 0 0 24px;
        padding-bottom: 14px;
        border-bottom: 2px solid var(--color-champagne);
    }

    .svc-dual-dokumen > p {
        font-size: 0.93rem;
        color: var(--color-text-muted);
        line-height: 1.75;
        margin-bottom: 18px;
    }

    /* ── Timeline ── */
    .svc-alur-list {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
        counter-reset: svc-alur-counter;
    }

    .svc-alur-list::before {
        content: '';
        position: absolute;
        left: 19px;
        top: 22px;
        bottom: 22px;
        width: 2px;
        background: linear-gradient(180deg, var(--color-gilded) 0%, var(--color-champagne) 100%);
        border-radius: 1px;
    }

    .svc-alur-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 0 0 18px 0;
        position: relative;
        list-style: none;
        counter-increment: svc-alur-counter;
    }

    .svc-alur-item:last-child {
        padding-bottom: 0;
    }

    .svc-alur-num {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-gilded) 0%, var(--color-gilded-dark) 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(212, 165, 105, 0.35);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .svc-alur-num::after {
        content: counter(svc-alur-counter);
    }

    .svc-alur-item:hover .svc-alur-num {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(212, 165, 105, 0.45);
    }

    .svc-alur-content {
        flex: 1;
        background: #fff;
        border: 1px solid var(--color-border);
        border-left: 3px solid var(--color-gilded);
        border-radius: 0 var(--border-radius-lg) var(--border-radius-lg) 0;
        padding: 18px 22px;
        box-shadow: var(--shadow-sm);
        font-size: 0.92rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin-top: 0;
        transition: all 0.3s ease;
    }

    .svc-alur-content strong {
        color: var(--color-text-main);
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
        font-size: 0.95rem;
    }

    .svc-alur-item:hover .svc-alur-content {
        box-shadow: var(--shadow-lg);
        border-left-color: var(--color-gilded-dark);
        transform: translateX(4px);
    }

    /* ── Document Cards ── */
    .svc-dok-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .svc-dok-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg);
        padding: 14px 18px;
        box-shadow: var(--shadow-sm);
        list-style: none;
        transition: all 0.3s ease;
    }

    .svc-dok-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--color-champagne) 0%, rgba(212, 165, 105, 0.15) 100%);
        color: var(--color-bronze);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.88rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .svc-dok-text {
        flex: 1;
        font-size: 0.92rem;
        color: var(--color-text-muted);
        line-height: 1.5;
    }

    .svc-dok-item:hover {
        box-shadow: var(--shadow);
        border-color: rgba(212, 165, 105, 0.4);
        transform: translateX(4px);
    }

    .svc-dok-item:hover .svc-dok-icon {
        background: linear-gradient(135deg, var(--color-gilded) 0%, var(--color-gilded-dark) 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(212, 165, 105, 0.3);
    }

    /* ═══════════════════════════════════════════════
       CARDS GRID — 2x2 info cards
       ═══════════════════════════════════════════════ */
    .svc-cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 80px;
    }

    .svc-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg);
        padding: 0;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        align-self: start;
    }

    .svc-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--color-gilded), var(--color-champagne));
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
    }

    .svc-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to top, rgba(249, 240, 214, 0.12) 0%, transparent 100%);
        pointer-events: none;
    }

    .svc-card:hover {
        box-shadow: 0 20px 40px rgba(31, 22, 17, 0.08), 0 8px 16px rgba(31, 22, 17, 0.04);
        border-color: rgba(212, 165, 105, 0.3);
        transform: translateY(-6px);
    }

    /* Accent header zone */
    .svc-card-header {
        padding: 28px 28px 20px;
        position: relative;
        z-index: 1;
        background: linear-gradient(135deg, rgba(249, 240, 214, 0.5) 0%, rgba(212, 165, 105, 0.08) 100%);
    }

    .svc-card-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 18px;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        background: linear-gradient(135deg, var(--color-champagne) 0%, rgba(212, 165, 105, 0.25) 100%);
        color: var(--color-bronze);
    }

    .svc-card-icon-wrap::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 20px;
        opacity: 0;
        transition: opacity 0.4s ease;
        background: radial-gradient(circle, rgba(212, 165, 105, 0.12) 0%, transparent 70%);
    }

    .svc-card:hover .svc-card-icon-wrap {
        transform: scale(1.08);
        background: linear-gradient(135deg, var(--color-gilded) 0%, var(--color-gilded-dark) 100%);
        color: #fff;
        box-shadow: 0 8px 20px rgba(212, 165, 105, 0.3);
    }

    .svc-card:hover .svc-card-icon-wrap::after {
        opacity: 1;
    }

    .svc-card-header h2 {
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin: 0;
        line-height: 1.4;
        border: none;
        padding: 0;
        display: block;
    }

    .svc-card-body {
        padding: 0 28px 28px;
        position: relative;
        z-index: 1;
    }

    .svc-card-body p {
        font-size: 0.9rem;
        color: var(--color-text-muted);
        line-height: 1.75;
        margin-bottom: 14px;
    }

    .svc-card-body strong {
        color: var(--color-text-main);
        font-weight: 700;
    }

    .svc-card-body ul,
    .svc-card-body ol {
        padding-left: 0;
        margin: 0 0 14px;
        list-style: none;
    }

    .svc-card-body ul li {
        position: relative;
        padding: 8px 0 8px 26px;
        font-size: 0.87rem;
        color: var(--color-text-muted);
        line-height: 1.6;
        border-bottom: 1px solid rgba(234, 223, 203, 0.4);
    }

    .svc-card-body ul li:last-child {
        border-bottom: none;
    }

    .svc-card-body ul li::before {
        content: "\f058";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 10px;
        font-size: 0.7rem;
        color: var(--color-gilded);
    }

    .svc-card-body ol {
        counter-reset: svc-card-ol;
    }

    .svc-card-body ol li {
        position: relative;
        padding: 8px 0 8px 34px;
        font-size: 0.87rem;
        color: var(--color-text-muted);
        line-height: 1.6;
        counter-increment: svc-card-ol;
        border-bottom: 1px solid rgba(234, 223, 203, 0.4);
    }

    .svc-card-body ol li:last-child {
        border-bottom: none;
    }

    .svc-card-body ol li::before {
        content: counter(svc-card-ol);
        position: absolute;
        left: 0;
        top: 8px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.68rem;
        font-weight: 700;
        background: var(--color-champagne);
        color: var(--color-bronze);
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
        transition: all 0.35s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .svc-other-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-gilded);
    }

    .svc-other-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .svc-other-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .svc-other-card:hover .svc-other-image img {
        transform: scale(1.05);
    }

    .svc-other-content {
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        text-align: center;
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
        .svc-dual-section { gap: 32px; }
    }

    @media (max-width: 767px) {
        .svc-main { padding: 50px 0 0; }

        .svc-rich { margin-bottom: 50px; }
        .svc-rich h2 { font-size: 1.35rem; margin: 40px 0 16px; }
        .svc-rich h3 { font-size: 1.05rem; }

        .svc-dual-section {
            grid-template-columns: 1fr;
            gap: 36px;
            margin-bottom: 50px;
        }
        .svc-dual-alur h2,
        .svc-dual-dokumen h2 { font-size: 1.3rem; margin-bottom: 16px; }
        .svc-alur-list::before { left: 18px; top: 18px; bottom: 18px; }
        .svc-alur-content { padding: 14px 16px; font-size: 0.9rem; }
        .svc-alur-num { width: 36px; height: 36px; min-width: 36px; font-size: 0.82rem; }
        .svc-dok-item { padding: 12px 14px; }
        .svc-dok-icon { width: 32px; height: 32px; min-width: 32px; font-size: 0.8rem; }
        .svc-dok-text { font-size: 0.88rem; }

        .svc-cards-grid {
            grid-template-columns: 1fr;
            gap: 16px;
            margin-bottom: 50px;
        }
        .svc-card-header { padding: 22px 20px 16px; }
        .svc-card-body { padding: 0 20px 22px; }
        .svc-card-icon-wrap { width: 48px; height: 48px; border-radius: 14px; font-size: 1rem; margin-bottom: 14px; }
        .svc-card-header h2 { font-size: 1.05rem; }

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
            @if(!empty($highlightCards))
            <div class="svc-hl-custom" data-scroll>
                @foreach($highlightCards as $card)
                <div class="svc-hl-card" style="grid-column: 1 / -1;">
                    <div class="svc-hl-icon"><i class="fa-solid {{ $card['icon'] }}"></i></div>
                    <div class="svc-hl-text">
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
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
                @php
                    $desc = $service->description;
                    $alurHtml = null;
                    $dokumenHtml = null;
                    $cardsHtml = null;

                    if (preg_match('/<!-- SVC_ALUR_START -->([\s\S]*?)<!-- SVC_ALUR_END -->/', $desc, $am)) {
                        $alurHtml = preg_replace('/<ul>/', '<ul class="svc-alur-list">', trim($am[1]));
                    }
                    if (preg_match('/<!-- SVC_DOKUMEN_START -->([\s\S]*?)<!-- SVC_DOKUMEN_END -->/', $desc, $dm)) {
                        $dokumenHtml = preg_replace('/<ul>/', '<ul class="svc-dok-list">', trim($dm[1]));
                    }
                    if (preg_match('/<!-- SVC_CARDS_START -->([\s\S]*?)<!-- SVC_CARDS_END -->/', $desc, $cm)) {
                        $cardsRaw = trim($cm[1]);
                        $cardSections = preg_split('/(?=<h2)/', $cardsRaw);
                        $cardSections = array_filter(array_map('trim', $cardSections));
                        $cardsHtml = '<div class="svc-cards-grid">';
                        foreach ($cardSections as $card) {
                            $accent = '';
                            $iconClass = 'fa-solid fa-circle-info';
                            if (preg_match('/<h2\s+data-icon="([^"]+)"\s+data-accent="([^"]+)">/', $card, $m)) {
                                $iconClass = $m[1];
                                $accent = $m[2];
                            } elseif (preg_match('/<h2\s+data-icon="([^"]+)">/', $card, $m)) {
                                $iconClass = $m[1];
                            }
                            $accentAttr = $accent ? ' data-accent="' . $accent . '"' : '';
                            $cleanCard = preg_replace('/<h2[^>]*>/', '<h2>', $card, 1);
                            $cleanCard = preg_replace('/<h2>/', '<h2><span class="svc-card-icon"><i class="' . $iconClass . '"></i></span>', $cleanCard, 1);
                            if (preg_match('/(<h2>[\s\S]*?<\/h2>)([\s\S]*)/', $cleanCard, $parts)) {
                                $headerHtml = '<div class="svc-card-header">' . $parts[1] . '</div>';
                                $bodyContent = trim($parts[2]);
                                $bodyHtml = '<div class="svc-card-body">' . $bodyContent . '</div>';
                                $cleanCard = $headerHtml . $bodyHtml;
                            }
                            $cardsHtml .= '<div class="svc-card"' . $accentAttr . '>' . $cleanCard . '</div>';
                        }
                        $cardsHtml .= '</div>';
                    }
                @endphp

                @if($alurHtml && $dokumenHtml)
                    @php
                        $remaining = $desc;
                        $remaining = preg_replace('/<!-- SVC_CARDS_START -->[\s\S]*?<!-- SVC_CARDS_END -->/', '', $remaining);
                        $remaining = preg_replace('/<!-- SVC_ALUR_START -->[\s\S]*?<!-- SVC_ALUR_END -->/', '', $remaining);
                        $remaining = preg_replace('/<!-- SVC_DOKUMEN_START -->[\s\S]*?<!-- SVC_DOKUMEN_END -->/', '', $remaining);
                        $remaining = trim($remaining);
                    @endphp

                    @if($cardsHtml)
                    <div class="svc-dual-section" data-scroll>
                        <div class="svc-dual-alur">
                            <span class="svc-dual-label">Alur Layanan</span>
                            {!! $alurHtml !!}
                        </div>
                        <div class="svc-dual-dokumen">
                            <span class="svc-dual-label">Dokumen yang Dibutuhkan</span>
                            {!! $dokumenHtml !!}
                        </div>
                    </div>

                        {!! $cardsHtml !!}
                    @endif

                    @if($remaining)
                    <div id="detail-layanan" class="svc-rich" data-scroll>
                        {!! $remaining !!}
                    </div>
                    @endif
                @else
                <div id="detail-layanan" class="svc-rich" data-scroll>
                    {!! $desc !!}
                </div>
                @endif
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
                        <div class="svc-other-image">
                            <img src="{{ $other->image_url }}" alt="{{ $other->name }}" loading="lazy">
                        </div>
                        <div class="svc-other-content">
                            <h3>{{ $other->name }}</h3>
                            <p>{{ $other->short_description }}</p>
                            <a href="{{ route('services.show', $other->slug) }}" class="btn btn-outline" style="width: 100%;">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection

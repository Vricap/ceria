@extends('layouts.app')

@section('title', $property->title . ' - DJM Property')
@section('meta_description', $property->short_description ?: ($property->meta_description ?: 'Detail properti ' . $property->title . ' dari DJM Property.'))

@section('content')
<style>
    .prop-page { margin-top: 40px; margin-bottom: 80px; }

    /* ─── Back to Search ─────────────────────────── */
    .prop-back { display: inline-flex; align-items: center; gap: 8px; color: var(--color-text-muted);
        font-size: 0.95rem; font-weight: 600; margin-bottom: 24px; text-decoration: none; transition: color 0.2s ease; cursor: pointer; }
    .prop-back:hover { color: var(--color-gilded-dark); }
    .prop-back i { color: var(--color-bronze); transition: transform 0.2s ease; }
    .prop-back:hover i { transform: translateX(-3px); }

    /* ─── Gallery ────────────────────────────────── */
    .prop-gallery { display: grid; grid-template-columns: minmax(0, 1fr) 200px; gap: 20px; margin-bottom: 32px; }
    .prop-gallery-main { position: relative; display: block; border-radius: var(--border-radius-lg); overflow: hidden;
        background: var(--color-champagne); cursor: zoom-in; box-shadow: var(--shadow-sm); }
    .prop-gallery-main img { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; }
    .prop-gallery-photo-count { position: absolute; bottom: 16px; left: 16px; background: rgba(31, 22, 17, 0.72); color: #fff;
        padding: 6px 14px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 8px; }

    .prop-gallery-thumbs { display: flex; flex-direction: column; align-items: stretch; justify-content: flex-start; gap: 12px; }
    .prop-thumb { position: relative; border: 2px solid transparent; padding: 0; border-radius: var(--border-radius);
        overflow: hidden; cursor: pointer; background: var(--color-surface); transition: border-color 0.2s ease; }
    .prop-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .prop-thumb.active { border-color: var(--color-gilded); }
    .prop-thumb:hover { border-color: var(--color-bronze); }
    .prop-thumb-more { position: absolute; inset: 0; background: rgba(31, 22, 17, 0.62); color: #fff; display: flex;
        flex-direction: column; align-items: center; justify-content: center; gap: 3px; font-weight: 700; font-size: 1.05rem; line-height: 1.2; }
    .prop-thumb-more small { font-size: 0.7rem; font-weight: 500; opacity: 0.9; }

    .prop-slider-btn { position: absolute; top: 50%; transform: translateY(-50%); z-index: 5; width: 44px; height: 44px;
        border-radius: 50%; border: 1px solid var(--color-border); background: rgba(255, 255, 255, 0.92); color: var(--color-noir);
        display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-sm);
        transition: all 0.2s ease; }
    .prop-slider-btn:hover { background: #fff; color: var(--color-gilded-dark); }
    .prop-slider-prev { left: 16px; }
    .prop-slider-next { right: 16px; }

    /* ─── Property Header ────────────────────────── */
    .prop-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 28px; }
    .prop-title { font-size: 2rem; font-weight: 700; color: var(--color-noir); line-height: 1.25; margin-bottom: 12px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .prop-location { display: flex; align-items: center; gap: 8px; color: var(--color-text-muted); font-size: 1.05rem; }
    .prop-location i { color: var(--color-bronze); }
    .prop-header-side { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
    .prop-icon-btn { width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--color-border); background: #fff;
        color: var(--color-text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.2s ease; }
    .prop-icon-btn:hover { background: var(--color-gilded); color: var(--color-noir); border-color: var(--color-gilded); }

    /* ─── Section ────────────────────────────────── */
    .prop-section { margin-bottom: 48px; }
    .prop-section-title { font-size: 1.5rem; font-weight: 700; color: var(--color-noir); margin-bottom: 18px;
        padding-bottom: 12px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; gap: 10px; }
    .prop-section-title i { color: var(--color-gilded-dark); }

    /* ─── Price & Highlights (satu container) ───── */
    .prop-price-card { background: #fff; border: 1px solid var(--color-border); border-radius: var(--border-radius-lg);
        padding: 28px; margin-bottom: 48px; box-shadow: var(--shadow-sm); }
    .prop-info-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
    .prop-price { font-size: 2rem; font-weight: 800; color: var(--color-bronze); }
    .prop-price-card > .prop-highlights-grid { margin-top: 22px; }

    .prop-detail-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 20px; border-radius: var(--border-radius-full);
        border: 2px solid var(--color-bronze); background: transparent; color: var(--color-bronze); font-weight: 600;
        font-size: 0.9rem; cursor: pointer; transition: all 0.25s ease; flex-shrink: 0; }
    .prop-detail-btn:hover { background: var(--color-bronze); color: #fff; }
    .prop-detail-btn i { transition: transform 0.25s ease; }
    .prop-detail-btn.open i { transform: rotate(180deg); }

    /* ─── Collapsible Detail ─────────────────────── */
    .prop-details-wrap { display: grid; grid-template-rows: 0fr; transition: grid-template-rows 0.3s ease; }
    .prop-details-wrap.open { grid-template-rows: 1fr; }
    .prop-details-inner { overflow: hidden; min-height: 0; }
    .prop-details-divider { border-top: 1px solid var(--color-border); margin-top: 22px; }
    .prop-details-inner .prop-highlights-grid { margin-top: 20px; }

    /* ─── Overview ───────────────────────────────── */
    .prop-overview-text { color: var(--color-text-main); line-height: 1.8; font-size: 1.05rem; white-space: pre-wrap;
        display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
    .prop-overview-text.expanded { display: block; }
    .prop-read-more { margin-top: 12px; background: none; border: none; color: var(--color-bronze); font-weight: 600;
        cursor: pointer; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 6px; padding: 0; }
    .prop-read-more:hover { color: var(--color-gilded-dark); }

    /* ─── Highlights ─────────────────────────────── */
    .prop-highlights-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .prop-highlight-item { display: flex; align-items: center; gap: 16px; padding: 16px; border: 1px solid var(--color-border);
        border-radius: var(--border-radius); background: var(--color-surface); }
    .prop-highlight-item i { width: 46px; height: 46px; border-radius: 12px; background: var(--color-champagne);
        color: var(--color-bronze); display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
    .prop-highlight-label { font-size: 0.8rem; color: var(--color-text-muted); }
    .prop-highlight-value { font-size: 1.05rem; font-weight: 600; color: var(--color-noir); line-height: 1.3; }
    .prop-facilities { margin-top: 20px; padding-top: 20px; border-top: 1px dashed var(--color-border);
        display: flex; flex-wrap: wrap; gap: 10px; }
    .prop-facility-tag { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px;
        background: var(--color-surface); border: 1px solid var(--color-border); color: var(--color-text-main); font-size: 0.88rem; }
    .prop-facility-tag i { color: var(--color-gilded-dark); }

    /* ─── Location & Map ─────────────────────────── */
    .prop-loc-string { display: flex; align-items: center; gap: 8px; color: var(--color-text-main); font-size: 1.1rem;
        font-weight: 600; margin-bottom: 8px; }
    .prop-loc-string i { color: var(--color-bronze); }
    .prop-loc-address { color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 20px; }
    .prop-map { border-radius: var(--border-radius-lg); overflow: hidden; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm); }
    .prop-map iframe { width: 100%; height: 400px; border: 0; display: block; }

    /* ─── WhatsApp CTA ───────────────────────────── */
    .prop-cta { background: linear-gradient(135deg, var(--color-champagne) 0%, #FBF4E4 100%); border: 1px solid var(--color-border);
        border-radius: var(--border-radius-lg); padding: 48px 32px; text-align: center; margin-bottom: 60px; }
    .prop-cta h3 { font-size: 1.6rem; color: var(--color-noir); margin-bottom: 10px; font-weight: 700; }
    .prop-cta p { color: var(--color-text-muted); margin-bottom: 24px; }

    /* ─── Sticky CTA Mobile ──────────────────────── */
    .prop-sticky-cta { display: none; }

    /* ─── Related Properties (compact horizontal) ── */
    .related-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 22px; }
    .related-card { display: flex; background: #fff; border: 1px solid var(--color-border); border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm); overflow: hidden; transition: all 0.3s ease; }
    .related-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
    .related-card-image { position: relative; width: 42%; flex-shrink: 0; overflow: hidden; background: var(--color-surface); }
    .related-img-link { position: absolute; inset: 0; display: block; z-index: 1; }
    .related-img-link img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .related-card:hover .related-img-link img { transform: scale(1.05); }
    .related-badges { position: absolute; top: 10px; left: 10px; display: flex; flex-wrap: wrap; gap: 5px; z-index: 2; }
    .related-badges .badge { font-size: 0.7rem; padding: 4px 10px; border-radius: var(--border-radius-full); }
    .related-card-content { padding: 18px; display: flex; flex-direction: column; flex: 1; min-width: 0; }
    .related-card-title { font-size: 1.02rem; font-weight: 700; line-height: 1.35; margin-bottom: 6px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .related-card-title a { color: var(--color-text-main); }
    .related-card-title a:hover { color: var(--color-bronze); }
    .related-card-location { color: var(--color-text-muted); font-size: 0.82rem; margin-bottom: 12px;
        display: flex; align-items: center; gap: 5px; }
    .related-card-location i { color: var(--color-bronze); flex-shrink: 0; }
    .related-card-specs { display: flex; flex-wrap: wrap; gap: 8px 14px; margin-bottom: 14px; }
    .related-card-spec { display: inline-flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--color-text-muted); }
    .related-card-spec i { color: var(--color-primary); width: 14px; text-align: center; flex-shrink: 0; }
    .related-card-footer { border-top: 1px solid var(--color-border); padding-top: 12px; margin-top: auto;
        display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
    .related-card-price { font-size: 1.2rem; font-weight: 700; color: var(--color-bronze); line-height: 1.2; }
    .related-card-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: var(--border-radius-full);
        background: var(--color-gilded); color: var(--color-noir); font-weight: 600; font-size: 0.82rem;
        transition: all 0.25s ease; white-space: nowrap; }
    .related-card-btn:hover { background: var(--color-gilded-dark); color: var(--color-noir); }

    @media (max-width: 991px) {
        .prop-gallery { grid-template-columns: minmax(0, 1fr) 180px; gap: 16px; }
        .prop-highlights-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 767px) {
        .prop-gallery { grid-template-columns: 1fr; }
        .prop-gallery-thumbs { flex-direction: row; gap: 10px; overflow-x: auto; padding-bottom: 6px; }
        .prop-thumb { min-width: 130px; }
        .prop-header { flex-direction: column; gap: 14px; }
        .prop-title { font-size: 1.6rem; }
        .prop-price { font-size: 1.6rem; }
        .prop-price-card { padding: 22px; }
        .prop-cta { padding: 36px 20px; }
        .prop-map iframe { height: 300px; }

        .prop-sticky-cta { display: flex; position: fixed; bottom: 0; left: 0; right: 0; background: #fff;
            border-top: 1px solid var(--color-border); box-shadow: 0 -4px 20px rgba(31, 22, 17, 0.12);
            padding: 10px 16px; gap: 12px; align-items: center; justify-content: space-between; z-index: 990; }
        .prop-sticky-cta .price { font-weight: 800; color: var(--color-bronze); font-size: 1.05rem; line-height: 1.2; }
        .prop-sticky-cta .status { font-size: 0.72rem; color: var(--color-text-muted); }
        .prop-sticky-cta .btn { padding: 9px 22px; font-size: 0.9rem; }

        .related-grid { grid-template-columns: 1fr; }
        .related-card { flex-direction: column; }
        .related-card-image { width: 100%; height: 210px; }
        .related-img-link { position: static; height: 100%; }
    }
</style>

@php
    $gallerySlides = [];
    $gallerySlides[] = ['src' => $property->thumbnail_url, 'alt' => $property->title];
    foreach ($property->images as $img) {
        if (!collect($gallerySlides)->contains('src', $img->url)) {
            $gallerySlides[] = ['src' => $img->url, 'alt' => $img->alt_text ?: $property->title];
        }
    }
    $totalSlides = count($gallerySlides);

    // Jumlah thumbnail sisi kanan mengikuti aturan jumlah foto.
    $thumbCount = min(max($totalSlides - 1, 0), 3);   // foto 2, 3, 4
    $thumbsToShow = array_slice($gallerySlides, 1, $thumbCount);
    $showOverlay = $totalSlides > 4;                  // slot "+N Foto"
    $overlayCount = $totalSlides - 4;
    $colItems = $thumbCount + ($showOverlay ? 1 : 0);
    $thumbRatio = match ($colItems) {
        1 => '16/12',
        2 => '16/11',
        3 => '16/10',
        default => '16/9',
    };

    $isSold   = $property->status === 'sold';
    $isRented = $property->status === 'rented';
    $isAvailable = !$isSold && !$isRented;

    // Back to Search: pertahankan state pencarian sebelumnya bila datang dari listing.
    $backUrl = route('properties.index');
    $referer = (string) request()->headers->get('referer');
    if ($referer !== '') {
        $refPath = parse_url($referer, PHP_URL_PATH) ?? '';
        if (rtrim($refPath, '/') === rtrim(route('properties.index', [], false), '/')) {
            $backUrl = $referer;
        }
    }

    $mapQuery = trim(($property->address ?? '') . ', ' . $property->location_string);
    $mapQuery = trim($mapQuery, ' ,');
    if ($property->latitude && $property->longitude) {
        $mapSrc = 'https://maps.google.com/maps?q=' . $property->latitude . ',' . $property->longitude . '&z=15&output=embed';
    } elseif ($mapQuery !== '') {
        $mapSrc = 'https://maps.google.com/maps?q=' . urlencode($mapQuery) . '&z=14&output=embed';
    } else {
        $mapSrc = null;
    }

    $highlights = [];
    if ($property->propertyType) $highlights[] = ['icon' => 'fa-house', 'label' => 'Jenis Properti', 'value' => $property->propertyType->name];
    if ($property->building_area) $highlights[] = ['icon' => 'fa-ruler-combined', 'label' => 'Luas Bangunan', 'value' => (int) $property->building_area . ' m²'];
    if ($property->land_area) $highlights[] = ['icon' => 'fa-earth-asia', 'label' => 'Luas Tanah', 'value' => (int) $property->land_area . ' m²'];
    if ($property->bedrooms) $highlights[] = ['icon' => 'fa-bed', 'label' => 'Kamar Tidur', 'value' => $property->bedrooms];
    if ($property->bathrooms) $highlights[] = ['icon' => 'fa-bath', 'label' => 'Kamar Mandi', 'value' => $property->bathrooms];
    if ($property->floors) $highlights[] = ['icon' => 'fa-layer-group', 'label' => 'Jumlah Lantai', 'value' => $property->floors];
    if ($property->year_built) $highlights[] = ['icon' => 'fa-calendar-days', 'label' => 'Tahun Bangunan', 'value' => $property->year_built];
    if ($property->certificate) $highlights[] = ['icon' => 'fa-file-shield', 'label' => 'Sertifikat', 'value' => $property->certificate];
    if ($property->garage) $highlights[] = ['icon' => 'fa-car', 'label' => 'Garasi', 'value' => $property->garage];
    if ($property->electric_power) $highlights[] = ['icon' => 'fa-bolt', 'label' => 'Daya Listrik', 'value' => $property->electric_power];

    $hasMore = count($highlights) > 3 || $property->facilities->count() > 0;

    $whatsappUrl = 'https://wa.me/6281234567890?text=' . $property->whatsapp_message;
@endphp

<div class="container prop-page">

    {{-- Back to Search ───────────────────────────────────────────--}}
    <a href="{{ $backUrl }}" class="prop-back" title="Kembali ke pencarian properti">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Search
    </a>

    {{-- Property Header ──────────────────────────────────────────--}}
    <div class="prop-header">
        <div style="min-width: 0;">
            <h1 class="prop-title">{{ $property->title }}</h1>
            <div class="prop-location">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                <span>{{ $property->location_string ?? $property->address }}</span>
            </div>
        </div>
        <div class="prop-header-side">
            <span class="badge {{ $property->status_color }}" style="font-size: 0.9rem; padding: 8px 16px;">{{ $property->status_label }}</span>
            <button type="button" class="prop-icon-btn" id="propShareBtn" title="Bagikan properti ini" aria-label="Bagikan">
                <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    {{-- Gallery ──────────────────────────────────────────────────--}}
    <div class="prop-gallery">
        <a id="propMainLink" href="{{ $gallerySlides[0]['src'] ?? $property->thumbnail_url }}"
           data-fancybox="prop-gallery" data-caption="{{ $property->title }}" class="prop-gallery-main" title="Klik untuk membuka galeri">
            <img id="propMainImg" src="{{ $gallerySlides[0]['src'] ?? $property->thumbnail_url }}" alt="{{ $property->title }}">
            @if($isSold)
                <div class="sold-out-overlay" style="z-index: 20;">
                    <div class="sold-out-stamp">Sold Out</div>
                </div>
            @endif
            <span class="prop-gallery-photo-count"><i class="fa-regular fa-images" aria-hidden="true"></i> <span id="propCounter">1 / {{ $totalSlides }}</span></span>

            @if($totalSlides > 1)
                <button type="button" class="prop-slider-btn prop-slider-prev" id="propSliderPrev" aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                </button>
                <button type="button" class="prop-slider-btn prop-slider-next" id="propSliderNext" aria-label="Foto berikutnya">
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </button>
            @endif
        </a>

        @if($colItems > 0)
            <div class="prop-gallery-thumbs">
                @foreach($thumbsToShow as $i => $slide)
                    <button type="button"
                            class="prop-thumb @if($i === 0) active @endif"
                            data-thumb-idx="{{ $i + 1 }}"
                            data-src="{{ $slide['src'] }}"
                            data-caption="{{ $slide['alt'] }}"
                            style="aspect-ratio: {{ $thumbRatio }};"
                            aria-label="Lihat foto {{ $i + 2 }}">
                        <img src="{{ $slide['src'] }}" alt="{{ $slide['alt'] }}" loading="lazy">
                    </button>
                @endforeach

                @if($showOverlay)
                    <button type="button"
                            class="prop-thumb"
                            data-thumb-idx="3"
                            id="propMoreThumb"
                            style="aspect-ratio: {{ $thumbRatio }};"
                            aria-label="Lihat semua foto">
                        <img src="{{ $gallerySlides[3]['src'] ?? $gallerySlides[$totalSlides - 1]['src'] }}" alt="" loading="lazy">
                        <span class="prop-thumb-more">
                            +{{ $overlayCount }} Foto
                            <small>Lihat Semua</small>
                        </span>
                    </button>
                @endif
            </div>
        @endif

        {{-- Item lightbox untuk semua foto (anchor tersembunyi) --}}
        @foreach($gallerySlides as $slide)
            <a href="{{ $slide['src'] }}" data-fancybox="prop-gallery" data-caption="{{ $slide['alt'] }}" style="display: none;"></a>
        @endforeach
    </div>

    {{-- Price + Highlights (satu container) ──────────────────────--}}
    <div class="prop-price-card">
        <div class="prop-info-header">
            <div class="prop-price">{{ $property->formatted_price }}</div>
            @if($hasMore)
                <button type="button" class="prop-detail-btn" id="propDetailToggle" aria-expanded="false" aria-controls="property-details">
                    Detail <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </button>
            @endif
        </div>

        @if(count($highlights) > 0)
            <div class="prop-highlights-grid">
                @foreach(array_slice($highlights, 0, 3) as $item)
                    <div class="prop-highlight-item">
                        <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
                        <div>
                            <div class="prop-highlight-label">{{ $item['label'] }}</div>
                            <div class="prop-highlight-value">{{ $item['value'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($hasMore)
            <div class="prop-details-wrap" id="property-details">
                <div class="prop-details-inner">
                    <div class="prop-details-divider"></div>

                    @if(count($highlights) > 3)
                        <div class="prop-highlights-grid">
                            @foreach(array_slice($highlights, 3) as $item)
                                <div class="prop-highlight-item">
                                    <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
                                    <div>
                                        <div class="prop-highlight-label">{{ $item['label'] }}</div>
                                        <div class="prop-highlight-value">{{ $item['value'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($property->facilities->count() > 0)
                        <div class="prop-facilities">
                            @foreach($property->facilities as $facility)
                                <span class="prop-facility-tag"><i class="fa-solid fa-check" aria-hidden="true"></i> {{ $facility->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Overview ─────────────────────────────────────────────────--}}
    @if($property->description)
        <div class="prop-section">
            <h2 class="prop-section-title"><i class="fa-solid fa-align-left" aria-hidden="true"></i> Overview</h2>
            <div class="prop-overview-text" id="propOverviewText">{{ $property->description }}</div>
            <button type="button" class="prop-read-more" id="propOverviewToggle">
                Baca Selengkapnya <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
            </button>
        </div>
    @endif

    {{-- Location & Map ───────────────────────────────────────────--}}
    @if($property->location_string || $property->address || $mapSrc)
        <div class="prop-section">
            <h2 class="prop-section-title"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Lokasi</h2>
            @if($property->location_string)
                <div class="prop-loc-string">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    <span>{{ $property->location_string }}</span>
                </div>
            @endif
            @if($property->address)
                <div class="prop-loc-address"><i class="fa-solid fa-location-arrow" aria-hidden="true"></i> {{ $property->address }}</div>
            @endif
            @if($mapSrc)
                <div class="prop-map">
                    <iframe src="{{ $mapSrc }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi {{ $property->title }}"></iframe>
                </div>
            @endif
        </div>
    @endif

    {{-- WhatsApp CTA ─────────────────────────────────────────────--}}
    <div class="prop-cta">
        @if($isSold)
            <h3>Properti ini sudah terjual.</h3>
            <p>Properti ini sudah tidak tersedia. Temukan properti lain yang cocok untuk Anda.</p>
            <a href="{{ route('properties.index') }}" class="btn btn-primary" style="min-width: 220px;">
                <i class="fa-solid fa-search" aria-hidden="true"></i> Lihat Properti Tersedia
            </a>
        @elseif($isRented)
            <h3>Properti ini sudah disewa.</h3>
            <p>Properti ini sudah tidak tersedia. Temukan properti sewa lainnya.</p>
            <a href="{{ route('properties.index', ['transaction' => 'disewa']) }}" class="btn btn-primary" style="min-width: 220px;">
                <i class="fa-solid fa-search" aria-hidden="true"></i> Cari Properti Sewa Lain
            </a>
        @else
            <h3>Tertarik dengan properti ini?</h3>
            <p>Hubungi kami untuk informasi lebih lanjut atau atur jadwal kunjungan.</p>
            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="min-width: 220px;">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Hubungi via WhatsApp
            </a>
        @endif
    </div>

    {{-- Related Properties ───────────────────────────────────────--}}
    @if($related->count() > 0)
        <div class="prop-section" style="margin-bottom: 0;">
            <h2 class="prop-section-title"><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i> Properti Lainnya</h2>
            <div class="related-grid">
                @foreach($related as $property)
                    <article class="related-card">
                        <div class="related-card-image">
                            <div class="related-badges">
                                <span class="badge {{ $property->status_color }}">{{ $property->status_label }}</span>
                                @if($property->is_featured)
                                    <span class="badge badge-featured"><i class="fa-solid fa-star" aria-hidden="true"></i></span>
                                @endif
                            </div>
                            @if($property->status == 'sold')
                                <div class="sold-out-overlay">
                                    <div class="sold-out-stamp">Sold Out</div>
                                </div>
                            @endif
                            <a href="{{ route('properties.show', $property->slug) }}" class="related-img-link" aria-label="{{ $property->title }}">
                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="related-card-content">
                            <h3 class="related-card-title">
                                <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">{{ $property->title }}</a>
                            </h3>
                            <div class="related-card-location">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $property->location_string }}
                            </div>
                            <div class="related-card-specs">
                                @if($property->building_area)
                                    <span class="related-card-spec" title="Luas Bangunan">
                                        <i class="fa-solid fa-ruler-combined" aria-hidden="true"></i> {{ (int) $property->building_area }} m&sup2;
                                    </span>
                                @endif
                                @if($property->land_area)
                                    <span class="related-card-spec" title="Luas Tanah">
                                        <i class="fa-solid fa-earth-asia" aria-hidden="true"></i> {{ (int) $property->land_area }} m&sup2;
                                    </span>
                                @endif
                                @if($property->bedrooms)
                                    <span class="related-card-spec" title="Kamar Tidur">
                                        <i class="fa-solid fa-bed" aria-hidden="true"></i> {{ $property->bedrooms }} Kamar Tidur
                                    </span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="related-card-spec" title="Kamar Mandi">
                                        <i class="fa-solid fa-shower" aria-hidden="true"></i> {{ $property->bathrooms }} Kamar Mandi
                                    </span>
                                @endif
                            </div>
                            <div class="related-card-footer">
                                <div class="related-card-price">{{ $property->formatted_price }}</div>
                                <a href="{{ route('properties.show', $property->slug) }}" class="related-card-btn">
                                    Detail <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Sticky CTA WhatsApp (mobile, hanya untuk properti tersedia) --}}
@if($isAvailable)
    <div class="prop-sticky-cta">
        <div>
            <div class="price">{{ $property->formatted_price }}</div>
            <div class="status">{{ $property->status_label }}</div>
        </div>
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Hubungi
        </a>
    </div>
@endif

<script>
    (function () {
        var total = {{ $totalSlides }};
        var slides = @json(array_column($gallerySlides, 'src'));
        var current = 0;

        var mainImg = document.getElementById('propMainImg');
        var mainLink = document.getElementById('propMainLink');
        var counter = document.getElementById('propCounter');
        var thumbs = document.querySelectorAll('.prop-thumb');
        var prevBtn = document.getElementById('propSliderPrev');
        var nextBtn = document.getElementById('propSliderNext');
        var moreThumb = document.getElementById('propMoreThumb');

        if (!mainImg || !slides.length) return;

        function go(idx) {
            current = (idx + total) % total;
            mainImg.src = slides[current];
            if (mainLink) {
                mainLink.setAttribute('href', slides[current]);
                mainLink.setAttribute('data-src', slides[current]);
            }
            if (counter) counter.textContent = (current + 1) + ' / ' + total;
            thumbs.forEach(function (t) {
                if (t === moreThumb) return;
                var tIdx = parseInt(t.getAttribute('data-thumb-idx'), 10);
                t.classList.toggle('active', tIdx === current);
            });
        }

        thumbs.forEach(function (t) {
            if (t === moreThumb) return;
            t.addEventListener('click', function () {
                go(parseInt(t.getAttribute('data-thumb-idx'), 10));
            });
        });

        if (prevBtn) prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            go(current - 1);
        });
        if (nextBtn) nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            go(current + 1);
        });

        if (moreThumb) {
            moreThumb.addEventListener('click', function () {
                go(3);
                if (mainLink) mainLink.click();
            });
        }

        // ─── Detail toggle (expand/collapse) ───
        var detailToggle = document.getElementById('propDetailToggle');
        var detailsWrap = document.getElementById('property-details');
        if (detailToggle && detailsWrap) {
            detailToggle.addEventListener('click', function () {
                var open = detailsWrap.classList.toggle('open');
                detailToggle.classList.toggle('open', open);
                detailToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                var icon = detailToggle.querySelector('i');
                if (icon) icon.className = 'fa-solid ' + (open ? 'fa-chevron-up' : 'fa-chevron-down');
            });
        }

        // ─── Overview read more ───
        var ov = document.getElementById('propOverviewText');
        var toggle = document.getElementById('propOverviewToggle');
        if (ov && toggle) {
            var isClamped = ov.scrollHeight > ov.clientHeight;
            if (!isClamped) toggle.style.display = 'none';
            toggle.addEventListener('click', function () {
                var expanded = ov.classList.toggle('expanded');
                toggle.innerHTML = expanded
                    ? 'Tutup <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>'
                    : 'Baca Selengkapnya <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';
            });
        }

        // ─── Share (Web Share API + fallback copy URL) ───
        var shareBtn = document.getElementById('propShareBtn');
        if (shareBtn) {
            shareBtn.addEventListener('click', function () {
                var url = window.location.href;
                var title = @json($property->title);
                if (navigator.share) {
                    navigator.share({ title: title, url: url }).catch(function () {});
                } else if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(function () {
                        shareBtn.title = 'Link tersalin!';
                        setTimeout(function () { shareBtn.title = 'Bagikan properti ini'; }, 2000);
                    }).catch(function () {});
                }
            });
        }
    })();
</script>
@endsection

@extends('layouts.app')

@section('title', $property->title . ' - Ceria Property')

@section('content')
<style>
    .property-slider-viewport { position: relative; overflow: hidden; border-radius: 12px; box-shadow: var(--shadow-md); background: #F3EFE6; }
    .property-slider-track { display: flex; transition: transform 0.45s cubic-bezier(0.25, 0.8, 0.25, 1); }
    .property-slider-slide { min-width: 100%; }
    .property-slider-slide img { width: 100%; max-height: 600px; object-fit: cover; display: block; }
    .property-slider-nav { position: absolute; top: 50%; transform: translateY(-50%); z-index: 5; width: 44px; height: 44px; border-radius: 50%; border: 1px solid var(--color-border); background: rgba(255, 255, 255, 0.92); color: var(--color-noir); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-sm); transition: all 0.2s ease; }
    .property-slider-nav:hover { background: #FFFFFF; color: var(--color-gilded-dark); }
    .property-slider-prev { left: 16px; }
    .property-slider-next { right: 16px; }
    .property-slider-count { position: absolute; right: 16px; bottom: 16px; background: rgba(31, 22, 17, 0.72); color: #FFFFFF; font-size: 0.8rem; font-weight: 600; padding: 6px 12px; border-radius: 999px; }
    .property-slider-dots { display: flex; justify-content: center; gap: 8px; margin-top: 14px; }
    .property-slider-dot { width: 9px; height: 9px; border-radius: 999px; border: none; background: #DCD0B8; cursor: pointer; padding: 0; transition: all 0.2s ease; }
    .property-slider-dot.active { width: 26px; background: var(--color-gilded); }
    .property-slider-thumbs { display: flex; gap: 10px; margin-top: 14px; overflow-x: auto; padding-bottom: 6px; }
    .property-slider-thumb { width: 92px; height: 64px; flex-shrink: 0; border-radius: 10px; overflow: hidden; border: 2px solid transparent; padding: 0; cursor: pointer; background: #F3EFE6; opacity: 0.75; transition: all 0.2s ease; }
    .property-slider-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .property-slider-thumb:hover { opacity: 1; }
    .property-slider-thumb.active { border-color: var(--color-gilded); opacity: 1; }
</style>
<div class="container" style="margin-top: 40px; margin-bottom: 80px;">
    <!-- Breadcrumb or Back Button -->
    <a href="{{ route('properties.index') }}" class="btn btn-outline" style="margin-bottom: 20px; display: inline-block;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Pencarian
    </a>

    <div class="property-detail">
        <h1 class="page-title" style="margin-bottom: 10px;">{{ $property->title }}</h1>
        <div style="color: var(--color-text-muted); margin-bottom: 20px; font-size: 1.1rem;">
            <i class="fa-solid fa-location-dot"></i> {{ $property->location_string ?? $property->address }}
            <br>
            <i class="fa-solid fa-map"></i> {{ $property->address }}
        </div>

        <div style="margin-bottom: 30px;">
            @if(isset($property->status_color) && isset($property->status_label))
                <span class="badge {{ $property->status_color }}" style="font-size: 1rem; padding: 8px 15px;">{{ $property->status_label }}</span>
            @endif
            @if(isset($property->formatted_price))
                <span style="font-size: 1.5rem; font-weight: bold; color: var(--color-bronze); margin-left: 15px;">{{ $property->formatted_price }}</span>
            @endif
        </div>

        {{-- Foto Galeri (Slider) --}}
        @php
            $gallerySlides = [];
            $gallerySlides[] = ['src' => $property->thumbnail_url, 'alt' => $property->title];
            foreach ($property->images as $img) {
                if (!collect($gallerySlides)->contains('src', $img->url)) {
                    $gallerySlides[] = ['src' => $img->url, 'alt' => $img->alt_text ?: $property->title];
                }
            }
            $totalSlides = count($gallerySlides);
        @endphp

        <div class="property-slider" data-slider data-count="{{ $totalSlides }}" style="margin-bottom: 40px;">
            <div class="property-slider-viewport" id="sliderViewport">
                @if($property->status == 'sold')
                    <div class="sold-out-overlay" style="z-index: 20;">
                        <div class="sold-out-stamp" style="font-size: 3rem; padding: 15px 40px; border-width: 6px;">Sold Out</div>
                    </div>
                @endif
                <div class="property-slider-track" id="sliderTrack">
                    @foreach($gallerySlides as $slide)
                        <div class="property-slider-slide">
                            <img src="{{ $slide['src'] }}" alt="{{ $slide['alt'] }}" loading="lazy">
                        </div>
                    @endforeach
                </div>

                @if($totalSlides > 1)
                    <button type="button" class="property-slider-nav property-slider-prev" id="sliderPrev" aria-label="Foto sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="property-slider-nav property-slider-next" id="sliderNext" aria-label="Foto berikutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <div class="property-slider-count" id="sliderCount">1 / {{ $totalSlides }}</div>
                @endif
            </div>

            @if($totalSlides > 1)
                <div class="property-slider-dots" id="sliderDots"></div>
                <div class="property-slider-thumbs" id="sliderThumbs">
                    @foreach($gallerySlides as $i => $slide)
                        <button type="button" class="property-slider-thumb @if($i === 0) active @endif" data-thumb="{{ $i }}" aria-label="Lihat foto {{ $i + 1 }}">
                            <img src="{{ $slide['src'] }}" alt="{{ $slide['alt'] }}" loading="lazy">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div style="display: grid; gap: 30px; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <!-- Left column: Details -->
            <div style="grid-column: span 2;">
                <h3 style="font-size: 1.5rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--color-border);">Spesifikasi Properti</h3>
                
                <div style="display: flex; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
                    @if($property->bedrooms)
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 1.2rem;">
                            <i class="fa-solid fa-bed" style="color: var(--color-bronze);"></i>
                            <div>
                                <div style="font-size: 0.9rem; color: var(--color-text-muted);">Kamar Tidur</div>
                                <strong>{{ $property->bedrooms }}</strong>
                            </div>
                        </div>
                    @endif
                    @if($property->bathrooms)
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 1.2rem;">
                            <i class="fa-solid fa-bath" style="color: var(--color-bronze);"></i>
                            <div>
                                <div style="font-size: 0.9rem; color: var(--color-text-muted);">Kamar Mandi</div>
                                <strong>{{ $property->bathrooms }}</strong>
                            </div>
                        </div>
                    @endif
                    @if($property->land_area)
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 1.2rem;">
                            <i class="fa-solid fa-ruler-combined" style="color: var(--color-bronze);"></i>
                            <div>
                                <div style="font-size: 0.9rem; color: var(--color-text-muted);">Luas Tanah</div>
                                <strong>{{ $property->land_area }} m&sup2;</strong>
                            </div>
                        </div>
                    @endif
                </div>

                <h3 style="font-size: 1.5rem; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--color-border);">Deskripsi</h3>
                <div style="line-height: 1.8; color: var(--color-text-main); font-size: 1.1rem; white-space: pre-wrap;">{{ $property->description ?? 'Belum ada deskripsi untuk properti ini.' }}</div>
            </div>

            <!-- Right column: Inquiry / Contact -->
            <div style="grid-column: span 1;">
                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--color-border); position: sticky; top: 20px;">

                    @if($property->status === 'sold')
                        {{-- SOLD OUT Panel --}}
                        <div style="text-align: center; padding: 10px 0 20px;">
                            <div style="width: 72px; height: 72px; background: #fdecea; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <i class="fa-solid fa-ban" style="font-size: 2rem; color: #c0392b;"></i>
                            </div>
                            <h3 style="font-size: 1.3rem; color: #c0392b; margin-bottom: 8px;">Properti Sudah Terjual</h3>
                            <p style="color: var(--color-text-muted); margin-bottom: 20px; font-size: 0.95rem;">
                                Properti ini sudah tidak tersedia. Temukan properti lain yang serupa di bawah ini.
                            </p>
                            <a href="{{ route('properties.index', ['city' => $property->city?->slug]) }}" class="btn btn-primary" style="display: block; text-align: center; width: 100%; margin-bottom: 10px;">
                                <i class="fa-solid fa-search"></i> Cari Properti Serupa
                            </a>
                            <a href="{{ route('properties.index') }}" class="btn btn-outline" style="display: block; text-align: center; width: 100%;">
                                Lihat Semua Properti
                            </a>
                        </div>

                    @elseif($property->status === 'rented')
                        {{-- RENTED Panel --}}
                        <div style="text-align: center; padding: 10px 0 20px;">
                            <div style="width: 72px; height: 72px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <i class="fa-solid fa-key" style="font-size: 2rem; color: #7f8c8d;"></i>
                            </div>
                            <h3 style="font-size: 1.3rem; color: #7f8c8d; margin-bottom: 8px;">Properti Sudah Disewa</h3>
                            <p style="color: var(--color-text-muted); margin-bottom: 20px; font-size: 0.95rem;">
                                Properti ini sudah tidak tersedia. Temukan properti sewa lainnya.
                            </p>
                            <a href="{{ route('properties.index', ['transaction' => 'disewa']) }}" class="btn btn-primary" style="display: block; text-align: center; width: 100%;">
                                <i class="fa-solid fa-search"></i> Cari Properti Sewa Lain
                            </a>
                        </div>

                    @else
                        {{-- AVAILABLE: Tampilkan kontak normal --}}
                        <h3 style="font-size: 1.3rem; margin-bottom: 20px;">Tertarik dengan properti ini?</h3>
                        <p style="color: var(--color-text-muted); margin-bottom: 20px;">Hubungi kami sekarang juga untuk informasi lebih lanjut atau mengatur jadwal kunjungan.</p>

                        <a href="https://wa.me/6281234567890?text=Halo%20Ceria%20Property,%20saya%20tertarik%20dengan%20properti%20{{ urlencode($property->title) }}" target="_blank" class="btn btn-primary" style="display: block; text-align: center; width: 100%; margin-bottom: 15px;">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var slider = document.querySelector('[data-slider]');
        if (!slider) return;

        var track = document.getElementById('sliderTrack');
        var viewport = document.getElementById('sliderViewport');
        var total = parseInt(slider.getAttribute('data-count'), 10) || 0;
        if (!track || total <= 1) return;

        var current = 0;
        var dotsWrap = document.getElementById('sliderDots');
        var countEl = document.getElementById('sliderCount');
        var thumbs = slider.querySelectorAll('.property-slider-thumb');
        var prevBtn = document.getElementById('sliderPrev');
        var nextBtn = document.getElementById('sliderNext');
        var startX = null;

        function go(idx) {
            current = (idx + total) % total;
            track.style.transform = 'translateX(-' + current * 100 + '%)';
            if (countEl) countEl.textContent = (current + 1) + ' / ' + total;
            if (dotsWrap) {
                dotsWrap.querySelectorAll('.property-slider-dot').forEach(function (d, i) {
                    d.classList.toggle('active', i === current);
                });
            }
            thumbs.forEach(function (t, i) {
                t.classList.toggle('active', i === current);
            });
            var thumb = thumbs[current];
            if (thumb && thumb.scrollIntoView) {
                thumb.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
            }
        }
        function next() { go(current + 1); }
        function prev() { go(current - 1); }

        if (dotsWrap) {
            for (var i = 0; i < total; i++) {
                (function (idx) {
                    var d = document.createElement('button');
                    d.type = 'button';
                    d.className = 'property-slider-dot' + (idx === 0 ? ' active' : '');
                    d.setAttribute('aria-label', 'Lihat foto ' + (idx + 1));
                    d.addEventListener('click', function () { go(idx); });
                    dotsWrap.appendChild(d);
                })(i);
            }
        }

        if (prevBtn) prevBtn.addEventListener('click', prev);
        if (nextBtn) nextBtn.addEventListener('click', next);
        thumbs.forEach(function (t) {
            t.addEventListener('click', function () { go(parseInt(t.getAttribute('data-thumb'), 10)); });
        });

        if (viewport) {
            viewport.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
            viewport.addEventListener('touchend', function (e) {
                if (startX === null) return;
                var dx = e.changedTouches[0].clientX - startX;
                if (Math.abs(dx) > 40) { dx < 0 ? next() : prev(); }
                startX = null;
            }, { passive: true });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') prev();
            if (e.key === 'ArrowRight') next();
        });
    })();
</script>
@endsection

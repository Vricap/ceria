@extends('layouts.app')

@section('title', $property->title . ' - Ceria Property')

@section('content')
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

        <div style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-md);">
            <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}" style="width: 100%; max-height: 600px; object-fit: cover;">
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
                    <h3 style="font-size: 1.3rem; margin-bottom: 20px;">Tertarik dengan properti ini?</h3>
                    <p style="color: var(--color-text-muted); margin-bottom: 20px;">Hubungi kami sekarang juga untuk informasi lebih lanjut atau mengatur jadwal kunjungan.</p>
                    
                    <a href="https://wa.me/6281234567890?text=Halo%20Ceria%20Property,%20saya%20tertarik%20dengan%20properti%20{{ urlencode($property->title) }}" target="_blank" class="btn btn-primary" style="display: block; text-align: center; width: 100%; margin-bottom: 15px;">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

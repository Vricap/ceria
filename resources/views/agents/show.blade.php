@extends('layouts.app')

@section('title', $agent->name . ' - Agen DJM Property')
@section('meta_description', Str::limit(strip_tags($agent->bio), 150))
@section('og_image', $agent->photo_url)

@push('scripts')
<style>
    .agent-profile-header {
        background-color: var(--color-surface);
        padding: 60px 0;
        margin-bottom: 60px;
        border-bottom: 1px solid var(--color-border);
    }

    .agent-profile-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 50px;
        align-items: start;
    }

    .agent-photo-wrapper {
        position: relative;
        text-align: center;
    }

    .agent-photo-wrapper img {
        width: 100%;
        max-width: 300px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: 5px solid white;
    }

    .agent-info h1 {
        font-size: 2.5rem;
        color: var(--color-text-main);
        margin-bottom: 5px;
    }

    .agent-info .title {
        font-size: 1.25rem;
        color: var(--color-bronze);
        font-weight: 600;
        margin-bottom: 20px;
    }

    .agent-meta {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid var(--color-border);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .meta-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-bronze);
        box-shadow: var(--shadow-sm);
    }

    .meta-data label {
        display: block;
        font-size: 0.8rem;
        color: var(--color-text-muted);
    }

    .meta-data span {
        font-weight: 600;
        color: var(--color-text-main);
    }

    .agent-bio {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--color-text-muted);
        margin-bottom: 30px;
    }

    .contact-actions {
        display: flex;
        gap: 15px;
    }

    @media (max-width: 991px) {
        .agent-profile-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .agent-photo-wrapper img {
            max-width: 250px;
        }
        .agent-meta {
            justify-content: center;
            flex-wrap: wrap;
        }
        .contact-actions {
            justify-content: center;
            flex-wrap: wrap;
        }
        .agent-info h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .agent-profile-header {
            padding: 40px 0;
            margin-bottom: 40px;
        }
        .agent-profile-grid {
            gap: 30px;
        }
        .agent-photo-wrapper img {
            max-width: 200px;
        }
        .agent-info h1 {
            font-size: 1.75rem;
        }
        .agent-info .title {
            font-size: 1.1rem;
        }
        .agent-meta {
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }
        .agent-bio {
            font-size: 0.95rem;
        }
        .contact-actions {
            flex-direction: column;
            gap: 10px;
        }
        .contact-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .agent-profile-header {
            padding: 30px 0;
            margin-bottom: 30px;
        }
        .agent-photo-wrapper img {
            max-width: 160px;
        }
        .agent-info h1 {
            font-size: 1.5rem;
        }
        .meta-icon {
            width: 35px;
            height: 35px;
            font-size: 0.85rem;
        }
        .meta-data label {
            font-size: 0.75rem;
        }
        .meta-data span {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Agent Profile Header -->
    <div class="agent-profile-header">
        <div class="container">
            <div class="agent-profile-grid">
                <div class="agent-photo-wrapper">
                    <img src="{{ $agent->photo_url }}" alt="{{ $agent->name }}">
                </div>
                
                <div class="agent-info">
                    <h1>{{ $agent->name }}</h1>
                    <div class="title">{{ $agent->title }}</div>
                    
                    <div class="agent-meta">
                        <div class="meta-item">
                            <div class="meta-icon"><i class="fa-solid fa-house"></i></div>
                            <div class="meta-data">
                                <label>Properti</label>
                                <span>{{ $properties->total() }} Listing</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-icon"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="meta-data">
                                <label>Pengalaman</label>
                                <span>{{ $agent->experience_years }} Tahun</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-icon"><i class="fa-solid fa-star"></i></div>
                            <div class="meta-data">
                                <label>Spesialisasi</label>
                                <span>{{ $agent->specialization }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="agent-bio">
                        {!! nl2br(e($agent->bio)) !!}
                    </div>
                    
                    <div class="contact-actions">
                        @if($agent->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->whatsapp) }}" target="_blank" class="btn btn-primary" style="background-color: #25D366; border-color: #25D366; padding: 12px 25px;">
                                <i class="fa-brands fa-whatsapp" style="margin-right: 8px;"></i> Hubungi via WhatsApp
                            </a>
                        @endif
                        @if($agent->phone)
                            <a href="tel:{{ $agent->phone }}" class="btn btn-outline" style="padding: 12px 25px;">
                                <i class="fa-solid fa-phone" style="margin-right: 8px;"></i> {{ $agent->phone }}
                            </a>
                        @endif
                        @if($agent->email)
                            <a href="mailto:{{ $agent->email }}" class="btn btn-outline" style="padding: 12px 20px;">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent's Properties -->
    <div class="container" style="margin-bottom: 80px;">
        <h2 class="section-title" style="margin-bottom: 30px;">Listing Properti {{ $agent->name }}</h2>
        
        @if($properties->count() > 0)
            <div class="grid grid-cols-3">
                @foreach($properties as $property)
                    <div class="property-card">
                        <div class="property-card-image">
                            <div class="property-badges">
                                <span class="badge {{ $property->status_color }}">{{ $property->status_label }}</span>
                            </div>
                            <a href="{{ route('properties.show', $property->slug) }}">
                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}">
                            </a>
                        </div>
                        <div class="property-card-content">
                            <h3 class="property-title">
                                <a href="{{ route('properties.show', $property->slug) }}">{{ Str::limit($property->title, 50) }}</a>
                            </h3>
                            <div class="property-price">{{ $property->formatted_price }}</div>
                            <div class="property-location">
                                <i class="fa-solid fa-location-dot"></i> {{ $property->location_string }}
                            </div>
                            <div class="property-specs">
                                @if($property->bedrooms)
                                    <div class="property-spec"><i class="fa-solid fa-bed"></i> {{ $property->bedrooms }}</div>
                                @endif
                                @if($property->bathrooms)
                                    <div class="property-spec"><i class="fa-solid fa-bath"></i> {{ $property->bathrooms }}</div>
                                @endif
                                @if($property->land_area)
                                    <div class="property-spec"><i class="fa-solid fa-ruler-combined"></i> {{ $property->land_area }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $properties->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="text-align: center; padding: 40px; background: var(--color-surface); border-radius: var(--border-radius-lg);">
                <p style="color: var(--color-text-muted); font-size: 1.1rem;">Agen ini belum memiliki listing properti yang dipublikasikan.</p>
            </div>
        @endif
    </div>
@endsection

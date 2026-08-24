@php /** @var \App\Models\Property $property */ @endphp
<div class="property-card">
    <div class="property-card-image">
        <div class="property-badges">
            <span class="badge {{ $property->status_color }}">{{ $property->status_label }}</span>
            @if($property->is_featured)
                <span class="badge badge-featured"><i class="fa-solid fa-star"></i></span>
            @endif
        </div>
        @if($property->status == 'sold')
            <div class="sold-out-overlay">
                <div class="sold-out-stamp">Terjual</div>
            </div>
        @elseif($property->status == 'rented')
            <div class="sold-out-overlay">
                <div class="rented-stamp">Tersewa</div>
            </div>
        @endif
        <a href="{{ route('properties.show', $property->slug) }}">
            <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}{{ $property->city ? ' - ' . $property->location_string : '' }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-property.svg') }}';">
        </a>
    </div>
    <div class="property-card-content">
        <div style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 5px;">{{ $property->propertyType->name ?? 'Rumah' }}</div>
        <h3 class="property-title" style="font-size: 1.3rem; margin-bottom: 8px;">
            <a href="{{ route('properties.show', $property->slug) }}" title="{{ $property->title }}">{{ Str::limit($property->title, 50) }}</a>
        </h3>
        <div class="property-location" style="margin-bottom: 15px; color: var(--color-text-muted);">
            <i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $property->location_string }}
        </div>
        <div class="property-specs" style="border-top: none; padding-top: 0; margin-top: 0; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px;">
            @if($property->building_area)
                <div class="property-spec" title="Luas Bangunan" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-expand" aria-hidden="true" style="color: var(--color-primary);"></i>
                    <span style="color: var(--color-text-muted);">{{ (int)$property->building_area }} Luas Bangunan</span>
                </div>
            @endif
            @if($property->land_area)
                <div class="property-spec" title="Luas Tanah" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-expand" aria-hidden="true" style="color: var(--color-primary);"></i>
                    <span style="color: var(--color-text-muted);">{{ (int)$property->land_area }} Luas Tanah</span>
                </div>
            @endif
            @if($property->bedrooms)
                <div class="property-spec" title="Kamar Tidur" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-bed" aria-hidden="true" style="color: var(--color-primary);"></i>
                    <span style="color: var(--color-text-muted);">{{ $property->bedrooms }} Kamar Tidur</span>
                </div>
            @endif
            @if($property->bathrooms)
                <div class="property-spec" title="Kamar Mandi" style="display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-shower" aria-hidden="true" style="color: var(--color-primary);"></i>
                    <span style="color: var(--color-text-muted);">{{ $property->bathrooms }} Kamar Mandi</span>
                </div>
            @endif
        </div>
        <div style="border-top: 1px solid var(--color-border); padding-top: 15px; margin-top: auto;">
            <div class="property-price" style="color: var(--color-primary); font-size: 1.5rem; margin-bottom: 0; font-weight: bold;">{{ $property->formatted_price }}</div>
        </div>
    </div>
</div>

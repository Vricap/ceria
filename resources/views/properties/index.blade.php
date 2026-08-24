@extends('layouts.app')

@php
    // Self-canonical untuk pagination murni; filter dikonsolidasikan ke /properti.
    $queryKeys = array_keys(array_filter(request()->query()));
    $isFiltered = !empty(array_diff($queryKeys, ['page']));
    $listingCanonical = $isFiltered ? url('/properti') : url()->full();
@endphp

@section('title', 'Properti Jogja | Rumah & Tanah Dijual di Yogyakarta | DJM Property')
@section('meta_description', 'Temukan properti Jogja di DJM Property: rumah, tanah, ruko, dan villa dijual maupun disewa di Sleman, Bantul, Kota Yogyakarta, Kulon Progo, dan Gunungkidul. Lihat listing lengkap dan hubungi kami.')
@section('canonical', $listingCanonical)

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
      "name": "Properti"
    }
  ]
}
</script>
@if($properties->count() > 0)
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ItemList",
  "name": "Properti Jogja — Daftar Properti DJM Property",
  "numberOfItems": {{ $properties->count() }},
  "itemListElement": [
    @foreach($properties as $i => $item)
    {
      "@@type": "ListItem",
      "position": {{ $i + 1 }},
      "url": "{{ url('/properti/' . $item->slug) }}",
      "name": "{{ $item->title }}"
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif
@endsection

@push('scripts')
<style>


    .layout-grid {
        display: block;
    }

    .top-filter {
        background: white;
        padding: 25px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        margin-bottom: 30px;
    }

    .top-filter-form {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        align-items: end;
    }

    .filter-group {
        margin-bottom: 0;
    }
    
    .filter-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 10px;
        border-top: 1px solid var(--color-border);
        padding-top: 20px;
    }

    .filter-actions .btn {
        width: auto !important;
        min-width: 150px;
    }

    .filter-label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--color-text-main);
    }

    .filter-toggle {
        display: none;
    }

    @media (max-width: 991px) {
        .filter-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    }

    .sorting-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 15px 20px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
    }

    .pagination-wrapper {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    /* Pagination Styles */
    .custom-pagination {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .pagination-list {
        display: flex;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination-list .page-item {
        list-style: none;
        margin: 0;
    }
    
    .pagination-list .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        height: 42px;
        padding: 0 12px;
        border-radius: var(--border-radius);
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        color: var(--color-text-main);
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-sm);
    }
    
    .pagination-list .page-link:hover {
        background: var(--color-champagne);
        border-color: var(--color-gilded);
        color: var(--color-noir);
        transform: translateY(-1px);
    }
    
    .pagination-list .page-item.active .page-link {
        background: var(--color-gilded);
        color: #FFFFFF;
        border-color: var(--color-gilded);
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(212, 165, 105, 0.35);
    }
    
    .pagination-list .page-item.disabled .page-link {
        background: #F8F6F2;
        color: #BFB5A8;
        border-color: var(--color-border);
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
        pointer-events: none;
    }

    .pagination-list .page-link.dots {
        border: none;
        background: transparent;
        cursor: default;
        min-width: 24px;
        padding: 0;
        box-shadow: none;
        color: var(--color-text-muted);
    }

    @media (max-width: 991px) {
        .top-filter-form {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 767px) {
        .top-filter-form {
            grid-template-columns: 1fr;
        }
        .filter-actions {
            flex-direction: column;
        }
        .filter-actions .btn {
            width: 100% !important;
        }
        .sorting-bar {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
            font-size: 0.9rem;
        }
        .sorting-bar select.form-control {
            width: 100% !important;
        }
        .top-filter {
            padding: 18px;
        }
    }

    @media (max-width: 480px) {
        .top-filter {
            padding: 15px;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header" style="background: linear-gradient(rgba(251, 244, 228, 0.88), rgba(251, 244, 228, 0.88)), url('{{ asset('images/headermenu/gambar3.jpg') }}') center / cover no-repeat var(--color-champagne);">
        <div class="container" style="max-width: 800px;">
            <h1 class="page-title">Cari Properti</h1>
            <p style="color: var(--color-text-muted); font-size: 1.125rem;">
                Temukan rumah impian Anda dari daftar properti terbaik kami
            </p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 80px;">
        <div class="layout-grid">
            
            <!-- Top Filter -->
            <div class="top-filter" x-data="{ 
                expanded: false,
                isDesktop: window.innerWidth > 991,
                selectedCity: '{{ request('city') }}',
                selectedDistrict: '{{ request('district') }}',
                cities: [
                    @foreach($cities as $city)
                    {
                        slug: '{{ $city->slug }}',
                        districts: [
                            @foreach($city->districts as $district)
                            { slug: '{{ $district->slug }}', name: '{{ $district->name }}' },
                            @endforeach
                        ]
                    },
                    @endforeach
                ],
                get availableDistricts() {
                    if (!this.selectedCity) return [];
                    let city = this.cities.find(c => c.slug === this.selectedCity);
                    return city ? city.districts : [];
                }
            }" @resize.window="isDesktop = window.innerWidth > 991">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2rem; color: var(--color-bronze);">Filter Pencarian</h3>
                    <button type="button" class="btn btn-outline filter-toggle" style="padding: 5px 10px;" @click="expanded = !expanded">
                        <i class="fa-solid fa-filter"></i> <span x-text="expanded ? 'Tutup Filter' : 'Tampilkan Filter'"></span>
                    </button>
                </div>
                
                <form action="{{ route('properties.index') }}" method="GET" class="top-filter-form" x-show="expanded || isDesktop">
                    <!-- Preserve sort parameter if exists -->
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    
                    <div class="filter-group">
                        <label class="filter-label">Kata Kunci</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Nama, alamat, dll..." value="{{ request('keyword') }}">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Tipe Transaksi</label>
                        <select name="transaction" class="form-control">
                            <option value="">Semua Transaksi</option>
                            <option value="dijual" {{ request('transaction') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="disewa" {{ request('transaction') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Tipe Properti</label>
                        <select name="type" class="form-control">
                            <option value="">Semua Tipe</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->slug }}" {{ request('type') == $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Lokasi (Kabupaten/Kota)</label>
                        <select name="city" class="form-control" x-model="selectedCity" @change="selectedDistrict = ''">
                            <option value="">Semua Kabupaten/Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->slug }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group" x-show="selectedCity" style="display: none;">
                        <label class="filter-label">Kecamatan</label>
                        <select name="district" class="form-control" x-model="selectedDistrict">
                            <option value="">Semua Kecamatan</option>
                            <template x-for="district in availableDistricts" :key="district.slug">
                                <option :value="district.slug" x-text="district.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        @if(request()->anyFilled(['transaction', 'type', 'city', 'min_price', 'max_price', 'bedrooms', 'keyword']))
                            <a href="{{ route('properties.index') }}" class="btn btn-outline" style="text-align: center;">Reset Filter</a>
                        @endif
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </div>
                </form>
            </div>

            <!-- Main Content -->
            <div>
                <!-- Sorting Bar -->
                <div class="sorting-bar">
                    <div>
                        Menampilkan <strong>{{ $properties->firstItem() ?? 0 }} - {{ $properties->lastItem() ?? 0 }}</strong> dari <strong>{{ $properties->total() }}</strong> properti
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 0.9rem; color: var(--color-text-muted);">Urutkan:</span>
                        <select class="form-control" style="width: auto; padding: 8px 15px; font-size: 0.9rem;" onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                        </select>
                    </div>
                </div>

                <!-- Properties Grid -->
                @if($properties->count() > 0)
                    <div class="grid grid-cols-3">
                        @foreach($properties as $property)
                            @include('properties.partials.card', ['property' => $property])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $properties->links('vendor.pagination.custom') }}
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: var(--border-radius-lg); border: 1px solid var(--color-border);">
                        <i class="fa-solid fa-house-circle-xmark" style="font-size: 4rem; color: var(--color-border); margin-bottom: 20px;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Properti Tidak Ditemukan</h3>
                        <p style="color: var(--color-text-muted); margin-bottom: 20px;">Maaf, tidak ada properti yang sesuai dengan kriteria pencarian Anda.</p>
                        <a href="{{ route('properties.index') }}" class="btn btn-primary">Reset Pencarian</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Cari Properti - DJM Property')

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
    }
    
    /* Pagination Styles */
    .pagination {
        display: flex;
        list-style: none;
        gap: 5px;
    }
    
    .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--border-radius);
        background: white;
        border: 1px solid var(--color-border);
        color: var(--color-text-main);
        font-weight: 500;
    }
    
    .page-item.active .page-link {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }
    
    .page-item.disabled .page-link {
        color: var(--color-text-light);
        background: var(--color-surface);
        cursor: not-allowed;
    }

    @media (max-width: 991px) {
        .top-filter-form {
            grid-template-columns: repeat(2, 1fr);
        }
        .page-title {
            font-size: 1.75rem;
        }
    }
    
    @media (max-width: 767px) {
        .page-header {
            padding: 30px 0;
            margin-bottom: 25px;
        }
        .page-title {
            font-size: 1.5rem;
        }
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
        .page-header {
            padding: 25px 0;
            margin-bottom: 20px;
        }
        .page-title {
            font-size: 1.35rem;
        }
        .top-filter {
            padding: 15px;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
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
            }">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 1.2rem; color: var(--color-primary);">Filter Pencarian</h3>
                    <button type="button" class="btn btn-outline d-lg-none" style="padding: 5px 10px;" @click="expanded = !expanded">
                        <i class="fa-solid fa-filter"></i> <span x-text="expanded ? 'Tutup Filter' : 'Tampilkan Filter'"></span>
                    </button>
                </div>
                
                <form action="{{ route('properties.index') }}" method="GET" class="top-filter-form" x-show="expanded || window.innerWidth > 991">
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

                    <div class="filter-group">
                        <label class="filter-label">Harga (Rp)</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <input type="text" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                            <input type="text" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Kamar Tidur</label>
                        <select name="bedrooms" class="form-control">
                            <option value="">Semua</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                            <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+</option>
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
                            <div class="property-card">
                                <div class="property-card-image">
                                    <div class="property-badges">
                                        <span class="badge {{ $property->status_color }}">{{ $property->status_label }}</span>
                                        @if($property->is_featured)
                                            <span class="badge badge-featured"><i class="fa-solid fa-star"></i></span>
                                        @endif
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
                                            <div class="property-spec" title="Kamar Tidur">
                                                <i class="fa-solid fa-bed"></i> {{ $property->bedrooms }}
                                            </div>
                                        @endif
                                        @if($property->bathrooms)
                                            <div class="property-spec" title="Kamar Mandi">
                                                <i class="fa-solid fa-bath"></i> {{ $property->bathrooms }}
                                            </div>
                                        @endif
                                        @if($property->land_area)
                                            <div class="property-spec" title="Luas Tanah">
                                                <i class="fa-solid fa-ruler-combined"></i> {{ $property->land_area }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $properties->links('pagination::bootstrap-5') }} 
                        {{-- Note: we style bootstrap-5 pagination classes manually in CSS or just use simple custom if preferred. I'll use default since we added base styles --}}
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

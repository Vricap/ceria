@extends('layouts.admin')

@section('title', 'Edit Properti - DJM Admin')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('dashboard.properties') }}" class="mb-3 inline-flex items-center gap-1.5 text-sm font-medium text-[#946E4B] transition hover:text-[#1F1611]">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Properti
        </a>
        <h1 class="text-2xl font-extrabold tracking-tight text-[#1F1611] sm:text-3xl">Edit Properti: {{ $property->title }}</h1>
        <p class="mt-1 text-sm text-[#523828]">Perbarui informasi dan spesifikasi properti.</p>
    </div>

    {{-- Alerts --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-[#F0D9CC] bg-[#FBF0EA] p-4 text-sm text-[#7A3B2E]">
            <div class="mb-1 flex items-center gap-2 font-semibold text-[#A4492F]">
                <i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan pada pengisian form:
            </div>
            <ul class="list-inside list-disc space-y-1 pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 1. INFORMASI UTAMA --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-house-chimney text-[#D4A569]"></i> Informasi Utama
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Judul, kategori, tipe, dan agen penanggung jawab.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Title --}}
                <div class="md:col-span-2">
                    <label for="title" class="field-label">Nama / Judul Properti <span class="text-[#A4492F]">*</span></label>
                    <input type="text" id="title" name="title" required value="{{ old('title', $property->title) }}"
                        placeholder="Contoh: Rumah Minimalis Modern Dekat Kampus UGM" class="field-input">
                    @error('title')
                        <p class="mt-1.5 text-xs text-[#A4492F]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Properti --}}
                <div>
                    <label for="property_id_code" class="field-label">Kode Properti (ID)</label>
                    <input type="text" id="property_id_code" name="property_id_code" value="{{ old('property_id_code', $property->property_id_code) }}"
                        placeholder="Contoh: PROP-001" class="field-input">
                </div>

                {{-- Agen --}}
                <div>
                    <label for="agent_id" class="field-label">Agen Penanggung Jawab</label>
                    <select id="agent_id" name="agent_id" class="field-input">
                        <option value="">-- Pilih Agen --</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('agent_id', $property->agent_id) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->city ?? 'Agen' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="field-label">Kategori Properti</label>
                    <select id="category_id" name="category_id" class="field-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $property->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipe Properti --}}
                <div>
                    <label for="property_type_id" class="field-label">Tipe Properti</label>
                    <select id="property_type_id" name="property_type_id" class="field-input">
                        <option value="">-- Pilih Tipe --</option>
                        @foreach($propertyTypes as $pt)
                            <option value="{{ $pt->id }}" {{ old('property_type_id', $property->property_type_id) == $pt->id ? 'selected' : '' }}>
                                {{ $pt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- 2. TRANSAKSI & HARGA --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-tags text-[#D4A569]"></i> Transaksi & Harga
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Tentukan tipe penawaran (dijual/disewa) dan nominal harga.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                {{-- Tipe Transaksi --}}
                <div>
                    <label for="transaction_type" class="field-label">Jenis Transaksi <span class="text-[#A4492F]">*</span></label>
                    <select id="transaction_type" name="transaction_type" required class="field-input">
                        <option value="dijual" {{ old('transaction_type', $property->transaction_type) == 'dijual' ? 'selected' : '' }}>Dijual</option>
                        <option value="disewa" {{ old('transaction_type', $property->transaction_type) == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    </select>
                </div>

                {{-- Harga Jual / Total --}}
                <div>
                    <label for="price" class="field-label">Harga (Rp)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" step="100000" min="0"
                        placeholder="Contoh: 1500000000" class="field-input">
                </div>

                {{-- Harga Sewa Bulanan --}}
                <div id="price_rent_group">
                    <label for="price_rent_monthly" class="field-label">Harga Sewa / Bulan (Rp)</label>
                    <input type="number" id="price_rent_monthly" name="price_rent_monthly" value="{{ old('price_rent_monthly', $property->price_rent_monthly) }}" step="50000" min="0"
                        placeholder="Contoh: 5000000" class="field-input">
                </div>

                {{-- Catatan Harga --}}
                <div class="md:col-span-3">
                    <label for="price_note" class="field-label">Catatan Harga</label>
                    <input type="text" id="price_note" name="price_note" value="{{ old('price_note', $property->price_note) }}"
                        placeholder="Contoh: Nego, Include SHM & Pajak, Per Bulan, Dll." class="field-input">
                </div>
            </div>
        </div>

        {{-- 3. SPESIFIKASI & DETAIL --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-sliders text-[#D4A569]"></i> Spesifikasi Properti
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Detail fisik bangunan, luas tanah, kamar, dan utilitas.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                {{-- Luas Tanah --}}
                <div>
                    <label for="land_area" class="field-label !mb-1.5 !text-xs">Luas Tanah (m²)</label>
                    <input type="number" id="land_area" name="land_area" value="{{ old('land_area', $property->land_area) }}" step="0.1" min="0" placeholder="120" class="field-input">
                </div>

                {{-- Luas Bangunan --}}
                <div>
                    <label for="building_area" class="field-label !mb-1.5 !text-xs">Luas Bangunan (m²)</label>
                    <input type="number" id="building_area" name="building_area" value="{{ old('building_area', $property->building_area) }}" step="0.1" min="0" placeholder="90" class="field-input">
                </div>

                {{-- Kamar Tidur --}}
                <div>
                    <label for="bedrooms" class="field-label !mb-1.5 !text-xs">Kamar Tidur</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" placeholder="3" class="field-input">
                </div>

                {{-- Kamar Mandi --}}
                <div>
                    <label for="bathrooms" class="field-label !mb-1.5 !text-xs">Kamar Mandi</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" placeholder="2" class="field-input">
                </div>

                {{-- Garasi --}}
                <div>
                    <label for="garage" class="field-label !mb-1.5 !text-xs">Garasi / Carport</label>
                    <input type="number" id="garage" name="garage" value="{{ old('garage', $property->garage) }}" min="0" placeholder="1" class="field-input">
                </div>

                {{-- Lantai --}}
                <div>
                    <label for="floors" class="field-label !mb-1.5 !text-xs">Jumlah Lantai</label>
                    <input type="number" id="floors" name="floors" value="{{ old('floors', $property->floors) }}" min="0" placeholder="2" class="field-input">
                </div>

                {{-- Sertifikat --}}
                <div>
                    <label for="certificate" class="field-label !mb-1.5 !text-xs">Sertifikat</label>
                    <select id="certificate" name="certificate" class="field-input">
                        <option value="">-- Pilih --</option>
                        <option value="SHM" {{ old('certificate', $property->certificate) == 'SHM' ? 'selected' : '' }}>SHM (Sertifikat Hak Milik)</option>
                        <option value="HGB" {{ old('certificate', $property->certificate) == 'HGB' ? 'selected' : '' }}>HGB (Hak Guna Bangunan)</option>
                        <option value="HP" {{ old('certificate', $property->certificate) == 'HP' ? 'selected' : '' }}>HP (Hak Pakai)</option>
                        <option value="Strata Title" {{ old('certificate', $property->certificate) == 'Strata Title' ? 'selected' : '' }}>Strata Title</option>
                        <option value="Lainnya" {{ old('certificate', $property->certificate) == 'Lainnya' ? 'selected' : '' }}>Girik / Lainnya</option>
                    </select>
                </div>

                {{-- Daya Listrik --}}
                <div>
                    <label for="electric_power" class="field-label !mb-1.5 !text-xs">Daya Listrik</label>
                    <input type="text" id="electric_power" name="electric_power" value="{{ old('electric_power', $property->electric_power) }}" placeholder="2200W" class="field-input">
                </div>

                {{-- Tahun Dibangun --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="year_built" class="field-label !mb-1.5 !text-xs">Tahun Dibangun</label>
                    <input type="number" id="year_built" name="year_built" value="{{ old('year_built', $property->year_built) }}" min="1900" max="{{ date('Y') + 1 }}" placeholder="2023" class="field-input">
                </div>
            </div>
        </div>

        {{-- 4. LOKASI PROPERTI --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-location-dot text-[#D4A569]"></i> Lokasi Properti
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Pilih kota, kecamatan, dan alamat lengkap.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Kota --}}
                <div>
                    <label for="city_id" class="field-label">Kota / Kabupaten</label>
                    <select id="city_id" name="city_id" class="field-input">
                        <option value="">-- Pilih Kota/Kabupaten --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $property->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label for="district_id" class="field-label">Kecamatan</label>
                    <select id="district_id" name="district_id" class="field-input">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist->id }}" data-city-id="{{ $dist->city_id }}" {{ old('district_id', $property->district_id) == $dist->id ? 'selected' : '' }}>
                                {{ $dist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label for="address" class="field-label">Alamat Lengkap <span class="text-[#A4492F]">*</span></label>
                    <textarea id="address" name="address" required rows="3"
                        placeholder="Jl. Kaliurang KM 5, Depok, Sleman, DI Yogyakarta" class="field-input resize-none">{{ old('address', $property->address) }}</textarea>
                    @error('address')
                        <p class="mt-1.5 text-xs text-[#A4492F]">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 5. DESKRIPSI --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-align-left text-[#D4A569]"></i> Deskripsi Properti
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Penjelasan rincian properti untuk calon pembeli/penyewa.</p>
            </div>

            <div class="space-y-6">
                {{-- Deskripsi Singkat --}}
                <div>
                    <label for="short_description" class="field-label">Deskripsi Singkat / Ringkasan</label>
                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $property->short_description) }}"
                        placeholder="Contoh: Rumah 2 lantai siap huni, bebas banjir, akses jalan 2 mobil." class="field-input">
                </div>

                {{-- Deskripsi Lengkap --}}
                <div>
                    <label for="description" class="field-label">Deskripsi Lengkap</label>
                    <textarea id="description" name="description" rows="6"
                        placeholder="Tuliskan keunggulan, tata ruang, akses jalan, legalitas, serta kondisi lingkungan sekitar..."
                        class="field-input resize-y">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- 6. MEDIA & FOTO --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-images text-[#D4A569]"></i> Foto & Media Properti
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Foto utama dan galeri pendukung.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Main Thumbnail --}}
                <div>
                    <label class="field-label">Foto Utama Saat Ini</label>
                    <label for="thumbnail" id="thumbnailDropzone"
                        class="group relative flex min-h-[220px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-[#E8DCC8] bg-[#FBF6EC] p-2 text-center transition hover:border-[#D4A569] hover:bg-[#F9F0D6]/40">

                        <div id="thumbnailPreviewContainer" class="absolute inset-0">
                            <img id="thumbnailPreview" src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">
                                <span class="rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-[#1F1611] shadow">Ganti Foto Utama</span>
                            </div>
                        </div>
                    </label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden">
                    @error('thumbnail')
                        <p class="mt-1.5 text-xs text-[#A4492F]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gallery Images --}}
                <div>
                    <label class="field-label">Tambah Foto Galeri</label>
                    <label for="gallery_images"
                        class="group flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#E8DCC8] bg-[#FBF6EC] p-4 text-center transition hover:border-[#D4A569] hover:bg-[#F9F0D6]/40">
                        <div class="space-y-2">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-[#946E4B] shadow-sm group-hover:text-[#B98647]">
                                <i class="fa-solid fa-plus text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-[#523828]">Unggah Galeri Baru</p>
                            <p class="text-xs text-[#946E4B]">Pilih foto tambahan untuk dimasukkan</p>
                            <span id="galleryCount" class="hidden inline-block rounded-full bg-[#F9F0D6] px-3 py-1 text-xs font-semibold text-[#946E4B]">
                                0 Foto Terpilih
                            </span>
                        </div>
                    </label>
                    <input type="file" id="gallery_images" name="gallery_images[]" accept="image/png,image/jpeg,image/jpg,image/webp" multiple class="hidden">
                </div>
            </div>

            {{-- Existing Gallery Thumbnails --}}
            @if($property->images && $property->images->count() > 0)
                <div class="mt-6 border-t border-[#F0E6D2] pt-4">
                    <div class="mb-3 flex items-center justify-between">
                        <h4 class="text-xs font-semibold uppercase text-[#946E4B]">Foto Galeri Saat Ini ({{ $property->images->count() }})</h4>
                        <span class="text-xs text-[#523828]">Klik ikon sampah untuk menandai foto yang akan dihapus saat disimpan</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                        @foreach($property->images as $img)
                            <div id="gallery-card-{{ $img->id }}" class="group relative aspect-square overflow-hidden rounded-xl border border-[#EADFCB] bg-[#F3EFE6] shadow-sm transition">
                                <img src="{{ $img->url }}" alt="{{ $property->title }}" class="h-full w-full object-cover">

                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" id="del_chk_{{ $img->id }}" class="hidden">

                                <div id="delete-overlay-{{ $img->id }}" onclick="toggleDeleteGalleryImage({{ $img->id }})" class="absolute inset-0 z-10 hidden cursor-pointer flex-col items-center justify-center gap-1 bg-[#A4492F]/90 text-white">
                                    <i class="fa-solid fa-trash text-lg"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider">Akan Dihapus</span>
                                    <span class="mt-0.5 text-[9px] underline">Batal Hapus</span>
                                </div>

                                <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/40 opacity-0 transition group-hover:opacity-100">
                                    <button type="button" onclick="toggleDeleteGalleryImage({{ $img->id }})" title="Hapus Foto Ini" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#A4492F] text-white shadow transition hover:bg-[#7A3B2E]">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- 7. FASILITAS PROPERTI --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-list-check text-[#D4A569]"></i> Fasilitas & Fitur
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Centang fasilitas pendukung yang tersedia pada properti ini.</p>
            </div>

            @php
                $popularFacilities = [
                    'AC', 'Kolam Renang', 'Carport', 'Garasi', 'Taman / Garden', 'CCTV',
                    'Keamanan 24 Jam', 'Water Heater', 'Balkon', 'Internet Ready', 'Kitchen Set',
                    'Fully Furnished', 'Unfurnished', 'Line Telepon', 'Akses Jalan Besar',
                    'Dekat Kampus', 'Dekat Rumah Sakit', 'Dekat Akses Toll'
                ];

                $existingFacilityNames = old('facilities', $property->facilities->pluck('name')->toArray() ?? []);
            @endphp

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                @foreach($popularFacilities as $fac)
                    <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-[#EADFCB] p-3 transition hover:bg-[#FBF6EC] has-[:checked]:border-[#D4A569] has-[:checked]:bg-[#F9F0D6]/50">
                        <input type="checkbox" name="facilities[]" value="{{ $fac }}"
                            {{ in_array($fac, $existingFacilityNames) ? 'checked' : '' }}
                            class="h-4 w-4 rounded accent-[#D4A569]">
                        <span class="text-xs font-medium text-[#1F1611]">{{ $fac }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- 8. STATUS & PUBLIKASI --}}
        <div class="card p-6">
            <div class="mb-6 border-b border-[#F0E6D2] pb-4">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#1F1611]">
                    <i class="fa-solid fa-eye text-[#D4A569]"></i> Status & Dipublikasikan
                </h2>
                <p class="mt-0.5 text-xs text-[#523828]">Atur keterlihatan properti pada pencarian publik.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Status --}}
                <div>
                    <label for="status" class="field-label">Status Properti <span class="text-[#A4492F]">*</span></label>
                    <select id="status" name="status" required class="field-input">
                        <option value="published" {{ old('status', $property->status) == 'published' ? 'selected' : '' }}>Dipublikasikan (Published)</option>
                        <option value="draft" {{ old('status', $property->status) == 'draft' ? 'selected' : '' }}>Draft (Disimpan saja)</option>
                        <option value="featured" {{ old('status', $property->status) == 'featured' ? 'selected' : '' }}>Featured (Unggulan)</option>
                        <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>Terjual (Sold)</option>
                        <option value="rented" {{ old('status', $property->status) == 'rented' ? 'selected' : '' }}>Tersewa (Rented)</option>
                    </select>
                </div>

                {{-- Featured Toggle --}}
                <div class="flex items-center pt-6">
                    <label class="flex cursor-pointer items-center gap-3">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}
                            class="h-5 w-5 rounded accent-[#D4A569]">
                        <div>
                            <span class="text-sm font-semibold text-[#1F1611]">Tampilkan di Properti Unggulan (Featured)</span>
                            <p class="text-xs text-[#523828]">Properti akan dimunculkan di section rekomendasi halaman depan.</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('dashboard.properties') }}" class="btn-ghost w-full justify-center sm:w-auto">
                Batal
            </a>
            <button type="submit" class="btn-gilded w-full justify-center sm:w-auto">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Properti
            </button>
        </div>

    </form>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Image Preview
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreview = document.getElementById('thumbnailPreview');

        if (thumbnailInput && thumbnailPreview) {
            thumbnailInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        thumbnailPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // 2. Gallery Images Count
        const galleryInput = document.getElementById('gallery_images');
        const galleryCount = document.getElementById('galleryCount');

        if (galleryInput && galleryCount) {
            galleryInput.addEventListener('change', function () {
                const files = this.files;
                if (files.length > 0) {
                    galleryCount.textContent = files.length + ' Foto Baru Terpilih';
                    galleryCount.classList.remove('hidden');
                } else {
                    galleryCount.classList.add('hidden');
                }
            });
        }

        // 3. Dynamic District Filter by City
        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('district_id');

        function filterDistricts() {
            if (!citySelect || !districtSelect) return;
            const selectedCityId = citySelect.value;
            const options = districtSelect.querySelectorAll('option');

            options.forEach(opt => {
                if (opt.value === "") {
                    opt.style.display = "block";
                    return;
                }
                const cityId = opt.getAttribute('data-city-id');
                if (!selectedCityId || cityId === selectedCityId) {
                    opt.style.display = "block";
                } else {
                    opt.style.display = "none";
                }
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', filterDistricts);
            filterDistricts();
        }
    });

    function toggleDeleteGalleryImage(id) {
        const chk = document.getElementById('del_chk_' + id);
        const overlay = document.getElementById('delete-overlay-' + id);
        const card = document.getElementById('gallery-card-' + id);

        if (chk && overlay) {
            chk.checked = !chk.checked;
            if (chk.checked) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                if (card) card.classList.add('ring-2', 'ring-[#A4492F]');
            } else {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
                if (card) card.classList.remove('ring-2', 'ring-[#A4492F]');
            }
        }
    }
</script>
@endsection

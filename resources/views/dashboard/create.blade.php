<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Properti Baru - Admin Dashboard</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-50 text-gray-800 antialiased">

<div class="min-h-screen pb-12">

    {{-- NAVBAR --}}
    <nav class="border-b border-gray-200 bg-white sticky top-0 z-30">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight text-gray-900">
                    Ceria <span class="text-blue-600">Admin</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                    Dashboard
                </a>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white shadow">
                    A
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6">

        {{-- Navigation & Header --}}
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-900 transition mb-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Dashboard
                </a>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Tambah Properti Baru
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Lengkapi seluruh informasi dan spesifikasi properti dengan benar.
                </p>
            </div>
        </div>

        {{-- Alerts --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-sm">
                <div class="flex items-center gap-2 font-semibold mb-1 text-red-900">
                    <i class="fa-solid fa-circle-exclamation text-red-600"></i> Terjadi kesalahan pada pengisian form:
                </div>
                <ul class="list-disc list-inside space-y-1 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- 1. INFORMASI UTAMA --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-house-chimney text-blue-600"></i> Informasi Utama
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Judul, kategori, tipe, dan agen penanggung jawab.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label for="title" class="mb-2 block text-sm font-medium text-gray-900">
                            Nama / Judul Properti <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" required value="{{ old('title') }}"
                            placeholder="Contoh: Rumah Minimalis Modern Dekat Kampus UGM"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                        @error('title')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kode Properti --}}
                    <div>
                        <label for="property_id_code" class="mb-2 block text-sm font-medium text-gray-900">
                            Kode Properti (ID)
                        </label>
                        <input type="text" id="property_id_code" name="property_id_code" value="{{ old('property_id_code') }}"
                            placeholder="Contoh: PROP-001 (Opsional, dibuat otomatis jika kosong)"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Agen --}}
                    <div>
                        <label for="agent_id" class="mb-2 block text-sm font-medium text-gray-900">
                            Agen Penanggung Jawab
                        </label>
                        <select id="agent_id" name="agent_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih Agen --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }} ({{ $agent->city ?? 'Agen' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-medium text-gray-900">
                            Kategori Properti
                        </label>
                        <select id="category_id" name="category_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipe Properti --}}
                    <div>
                        <label for="property_type_id" class="mb-2 block text-sm font-medium text-gray-900">
                            Tipe Properti
                        </label>
                        <select id="property_type_id" name="property_type_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih Tipe --</option>
                            @foreach($propertyTypes as $pt)
                                <option value="{{ $pt->id }}" {{ old('property_type_id') == $pt->id ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. TRANSAKSI & HARGA --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-tags text-green-600"></i> Transaksi & Harga
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan tipe penawaran (dijual/disewa) dan nominal harga.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    {{-- Tipe Transaksi --}}
                    <div>
                        <label for="transaction_type" class="mb-2 block text-sm font-medium text-gray-900">
                            Jenis Transaksi <span class="text-red-500">*</span>
                        </label>
                        <select id="transaction_type" name="transaction_type" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="dijual" {{ old('transaction_type') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="disewa" {{ old('transaction_type') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        </select>
                    </div>

                    {{-- Harga Jual / Total --}}
                    <div>
                        <label for="price" class="mb-2 block text-sm font-medium text-gray-900">
                            Harga (Rp)
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="100000" min="0"
                            placeholder="Contoh: 1500000000"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Harga Sewa Bulanan --}}
                    <div id="price_rent_group">
                        <label for="price_rent_monthly" class="mb-2 block text-sm font-medium text-gray-900">
                            Harga Sewa / Bulan (Rp)
                        </label>
                        <input type="number" id="price_rent_monthly" name="price_rent_monthly" value="{{ old('price_rent_monthly') }}" step="50000" min="0"
                            placeholder="Contoh: 5000000"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Catatan Harga --}}
                    <div class="md:col-span-3">
                        <label for="price_note" class="mb-2 block text-sm font-medium text-gray-900">
                            Catatan Harga
                        </label>
                        <input type="text" id="price_note" name="price_note" value="{{ old('price_note') }}"
                            placeholder="Contoh: Nego, Include SHM & Pajak, Per Bulan, Dll."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            {{-- 3. SPESIFIKASI & DETAIL --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-purple-600"></i> Spesifikasi Properti
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Detail fisik bangunan, luas tanah, kamar, dan utilitas.</p>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    {{-- Luas Tanah --}}
                    <div>
                        <label for="land_area" class="mb-1.5 block text-xs font-medium text-gray-700">Luas Tanah (m²)</label>
                        <input type="number" id="land_area" name="land_area" value="{{ old('land_area') }}" step="0.1" min="0" placeholder="120"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Luas Bangunan --}}
                    <div>
                        <label for="building_area" class="mb-1.5 block text-xs font-medium text-gray-700">Luas Bangunan (m²)</label>
                        <input type="number" id="building_area" name="building_area" value="{{ old('building_area') }}" step="0.1" min="0" placeholder="90"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Kamar Tidur --}}
                    <div>
                        <label for="bedrooms" class="mb-1.5 block text-xs font-medium text-gray-700">Kamar Tidur</label>
                        <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="3"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Kamar Mandi --}}
                    <div>
                        <label for="bathrooms" class="mb-1.5 block text-xs font-medium text-gray-700">Kamar Mandi</label>
                        <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="2"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Garasi --}}
                    <div>
                        <label for="garage" class="mb-1.5 block text-xs font-medium text-gray-700">Garasi / Carport</label>
                        <input type="number" id="garage" name="garage" value="{{ old('garage') }}" min="0" placeholder="1"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Lantai --}}
                    <div>
                        <label for="floors" class="mb-1.5 block text-xs font-medium text-gray-700">Jumlah Lantai</label>
                        <input type="number" id="floors" name="floors" value="{{ old('floors') }}" min="0" placeholder="2"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Sertifikat --}}
                    <div>
                        <label for="certificate" class="mb-1.5 block text-xs font-medium text-gray-700">Sertifikat</label>
                        <select id="certificate" name="certificate"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="SHM" {{ old('certificate') == 'SHM' ? 'selected' : '' }}>SHM (Sertifikat Hak Milik)</option>
                            <option value="HGB" {{ old('certificate') == 'HGB' ? 'selected' : '' }}>HGB (Hak Guna Bangunan)</option>
                            <option value="HP" {{ old('certificate') == 'HP' ? 'selected' : '' }}>HP (Hak Pakai)</option>
                            <option value="Strata Title" {{ old('certificate') == 'Strata Title' ? 'selected' : '' }}>Strata Title</option>
                            <option value="Lainnya" {{ old('certificate') == 'Lainnya' ? 'selected' : '' }}>Girik / Lainnya</option>
                        </select>
                    </div>

                    {{-- Daya Listrik --}}
                    <div>
                        <label for="electric_power" class="mb-1.5 block text-xs font-medium text-gray-700">Daya Listrik</label>
                        <input type="text" id="electric_power" name="electric_power" value="{{ old('electric_power') }}" placeholder="2200W"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Tahun Dibangun --}}
                    <div class="col-span-2 md:col-span-1">
                        <label for="year_built" class="mb-1.5 block text-xs font-medium text-gray-700">Tahun Dibangun</label>
                        <input type="number" id="year_built" name="year_built" value="{{ old('year_built') }}" min="1900" max="{{ date('Y') + 1 }}" placeholder="2023"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>
                </div>
            </div>

            {{-- 4. LOKASI PROPERTI --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-red-600"></i> Lokasi Properti
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pilih kota, kecamatan, dan alamat lengkap.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Kota --}}
                    <div>
                        <label for="city_id" class="mb-2 block text-sm font-medium text-gray-900">
                            Kota / Kabupaten
                        </label>
                        <select id="city_id" name="city_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kecamatan --}}
                    <div>
                        <label for="district_id" class="mb-2 block text-sm font-medium text-gray-900">
                            Kecamatan
                        </label>
                        <select id="district_id" name="district_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($districts as $dist)
                                <option value="{{ $dist->id }}" data-city-id="{{ $dist->city_id }}" {{ old('district_id') == $dist->id ? 'selected' : '' }}>
                                    {{ $dist->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-medium text-gray-900">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" name="address" required rows="3"
                            placeholder="Jl. Kaliurang KM 5, Depok, Sleman, DI Yogyakarta"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 resize-none">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 5. DESKRIPSI --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-amber-600"></i> Deskripsi Properti
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Penjelasan rincian properti untuk calon pembeli/penyewa.</p>
                </div>

                <div class="space-y-6">
                    {{-- Deskripsi Singkat --}}
                    <div>
                        <label for="short_description" class="mb-2 block text-sm font-medium text-gray-900">
                            Deskripsi Singkat / Ringkasan
                        </label>
                        <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}"
                            placeholder="Contoh: Rumah 2 lantai siap huni, bebas banjir, akses jalan 2 mobil."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>

                    {{-- Deskripsi Lengkap --}}
                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-900">
                            Deskripsi Lengkap
                        </label>
                        <textarea id="description" name="description" rows="6"
                            placeholder="Tuliskan keunggulan, tata ruang, akses jalan, legalitas, serta kondisi lingkungan sekitar..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 resize-y">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 6. MEDIA & FOTO --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-images text-indigo-600"></i> Foto & Media Properti
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Unggah foto utama (*thumbnail*) dan foto-foto galeri pendukung.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Main Thumbnail --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900">
                            Foto Utama (Thumbnail) <span class="text-red-500">*</span>
                        </label>
                        <label for="thumbnail" id="thumbnailDropzone"
                            class="group relative flex min-h-[220px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-4 text-center transition hover:border-blue-500 hover:bg-blue-50/30">
                            
                            <div id="thumbnailPlaceholder" class="space-y-2">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm text-gray-400 group-hover:text-blue-600">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Pilih atau Tarik Foto Utama</p>
                                <p class="text-xs text-gray-500">PNG, JPG, WEBP hingga 5MB</p>
                            </div>

                            <div id="thumbnailPreviewContainer" class="absolute inset-0 hidden">
                                <img id="thumbnailPreview" src="" alt="Thumbnail Preview" class="h-full w-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">
                                    <span class="rounded-lg bg-white px-3 py-1.5 text-xs font-semibold text-gray-800 shadow">Ganti Foto</span>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden" required>
                        @error('thumbnail')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gallery Images --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900">
                            Foto Galeri Tambahan (Multiple)
                        </label>
                        <label for="gallery_images"
                            class="group flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-4 text-center transition hover:border-blue-500 hover:bg-blue-50/30">
                            <div class="space-y-2">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm text-gray-400 group-hover:text-blue-600">
                                    <i class="fa-solid fa-images text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Pilih Foto Galeri</p>
                                <p class="text-xs text-gray-500">Bisa memilih beberapa foto sekaligus</p>
                                <span id="galleryCount" class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 hidden">
                                    0 Foto Terpilih
                                </span>
                            </div>
                        </label>
                        <input type="file" id="gallery_images" name="gallery_images[]" accept="image/png,image/jpeg,image/jpg,image/webp" multiple class="hidden">
                    </div>
                </div>
            </div>

            {{-- 7. FASILITAS PROPERTI --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-emerald-600"></i> Fasilitas & Fitur
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Centang fasilitas pendukung yang tersedia pada properti ini.</p>
                </div>

                @php
                    $popularFacilities = [
                        'AC', 'Kolam Renang', 'Carport', 'Garasi', 'Taman / Garden', 'CCTV',
                        'Keamanan 24 Jam', 'Water Heater', 'Balkon', 'Internet Ready', 'Kitchen Set',
                        'Fully Furnished', 'Unfurnished', 'Line Telepon', 'Akses Jalan Besar',
                        'Dekat Kampus', 'Dekat Rumah Sakit', 'Dekat Akses Toll'
                    ];
                @endphp

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                    @foreach($popularFacilities as $fac)
                        <label class="flex items-center gap-2.5 rounded-lg border border-gray-200 p-3 cursor-pointer transition hover:bg-gray-50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/40">
                            <input type="checkbox" name="facilities[]" value="{{ $fac }}"
                                {{ is_array(old('facilities')) && in_array($fac, old('facilities')) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-xs font-medium text-gray-800">{{ $fac }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 8. STATUS & PUBLIKASI --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-eye text-teal-600"></i> Status & Dipublikasikan
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Atur keterlihatan properti pada pencarian publik.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Status --}}
                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-gray-900">
                            Status Properti <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-1 focus:ring-blue-600 bg-white">
                            <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Dipublikasikan (Published)</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Disimpan saja)</option>
                            <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured (Unggulan)</option>
                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Terjual (Sold)</option>
                            <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Tersewa (Rented)</option>
                        </select>
                    </div>

                    {{-- Featured Toggle --}}
                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="text-sm font-semibold text-gray-900">Tampilkan di Properti Unggulan (Featured)</span>
                                <p class="text-xs text-gray-500">Properti akan dimunculkan di section rekomendasi halaman depan.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100 sm:w-auto">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-gray-800 sm:w-auto">
                    <i class="fa-solid fa-check"></i> Simpan Properti Baru
                </button>
            </div>

        </form>

    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Image Preview
        const thumbnailInput = document.getElementById('thumbnail');
        const thumbnailPreview = document.getElementById('thumbnailPreview');
        const thumbnailPreviewContainer = document.getElementById('thumbnailPreviewContainer');
        const thumbnailPlaceholder = document.getElementById('thumbnailPlaceholder');

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        thumbnailPreview.src = e.target.result;
                        thumbnailPlaceholder.classList.add('hidden');
                        thumbnailPreviewContainer.classList.remove('hidden');
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
                    galleryCount.textContent = files.length + ' Foto Terpilih';
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
            filterDistricts(); // Initial run
        }
    });
</script>

</body>
</html>

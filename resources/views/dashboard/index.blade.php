@extends('layouts.admin')

@section('title', 'Dashboard - DJM Admin')

@section('content')

    {{-- Header --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#1F1611] sm:text-3xl">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-[#523828]">
                Selamat datang kembali, Admin.
            </p>
        </div>
        <!-- <a href="{{ route('properties.create') }}" class="btn-gilded">
            <i class="fa-solid fa-plus"></i>
            Tambah Properti
        </a> -->
    </div>

    {{-- Stat Cards --}}
    @php
        $total     = $properties->count();
        $available = $properties->whereIn('status', ['published', 'featured'])->count();
        $sold      = $properties->where('status', 'sold')->count();
        $featured  = $properties->where('is_featured', true)->count();
        $recent    = $properties->take(5);
    @endphp

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-[#946E4B]">Total Properti</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-house-chimney"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-[#1F1611]">{{ $total }}</p>
            <p class="mt-1 text-xs text-[#523828]">Seluruh data properti</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-[#946E4B]">Tersedia</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-[#1F1611]">{{ $available }}</p>
            <p class="mt-1 text-xs text-[#523828]">Published &amp; Featured</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-[#946E4B]">Terjual</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-handshake"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-[#1F1611]">{{ $sold }}</p>
            <p class="mt-1 text-xs text-[#523828]">Status Sold</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-[#946E4B]">Unggulan</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-star"></i>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-[#1F1611]">{{ $featured }}</p>
            <p class="mt-1 text-xs text-[#523828]">Tampil di rekomendasi</p>
        </div>
    </div>

    {{-- Daftar Properti Terbaru --}}
    <div class="card overflow-hidden">
        <div class="card-head">
            <div>
                <h3 class="text-base font-bold text-[#1F1611]">Daftar Properti</h3>
                <p class="mt-0.5 text-xs text-[#523828]">Properti terbaru yang masuk ke sistem.</p>
            </div>
            <a href="{{ route('dashboard.properties') }}" class="btn-ghost !py-2.5">
                Lihat Semua
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
 
        {{-- Filter Bar --}}
        <div class="border-b border-[#F0E6D2] bg-[#FBF6EC]/40 px-6 py-4">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col gap-4 lg:flex-row lg:items-end">
                <div class="grid flex-1 grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4">
                    {{-- Pencarian Kata Kunci --}}
                    <div>
                        <label for="search" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#946E4B]">Cari Properti</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-[#946E4B]">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Judul, Kode ID, Alamat..." 
                                class="field-input w-full !pl-9 !py-1.5 text-xs" />
                        </div>
                    </div>

                    {{-- Tipe Properti --}}
                    <div>
                        <label for="type" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#946E4B]">Tipe Properti</label>
                        <select name="type" id="type" class="field-input w-full !py-1.5 text-xs">
                            <option value="">Semua Tipe</option>
                            @foreach($propertyTypes as $pt)
                                <option value="{{ $pt->id }}" {{ request('type') == $pt->id ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipe Transaksi --}}
                    <div>
                        <label for="transaction" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#946E4B]">Transaksi</label>
                        <select name="transaction" id="transaction" class="field-input w-full !py-1.5 text-xs">
                            <option value="">Semua</option>
                            <option value="dijual" {{ request('transaction') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="disewa" {{ request('transaction') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#946E4B]">Status</label>
                        <select name="status" id="status" class="field-input w-full !py-1.5 text-xs">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                            <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn-gilded !px-4 !py-2 text-xs">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    @if($isFiltered)
                        <a href="{{ route('dashboard') }}" class="rounded-lg border border-[#EADFCB] bg-white px-4 py-2 text-center text-xs font-medium text-[#523828] transition hover:bg-[#F9F0D6]">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
 
         <div class="overflow-x-auto">
             <table class="w-full text-left text-sm">
                 <thead class="border-b border-[#F0E6D2] bg-[#FBF6EC] text-xs uppercase tracking-wider text-[#946E4B]">
                     <tr>
                         <th class="px-6 py-4 font-bold">Foto</th>
                         <th class="px-6 py-4 font-bold">Properti</th>
                         <th class="px-6 py-4 font-bold">Harga</th>
                         <th class="px-6 py-4 font-bold">Status</th>
                         <th class="px-6 py-4 text-right font-bold">Aksi</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y divide-[#F0E6D2]">
                     @forelse($tableProperties as $property)
                    <tr class="transition hover:bg-[#FBF6EC]/60">
                        <td class="px-6 py-4">
                            <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                                class="h-12 w-16 rounded-lg border border-[#EADFCB] object-cover shadow-sm">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#1F1611]">{{ $property->title }}</div>
                            <div class="mt-0.5 text-xs text-[#523828]">{{ Str::limit($property->address, 40) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-[#1F1611]">{{ $property->formatted_price }}</div>
                            <span class="mt-0.5 inline-block rounded-full bg-[#F9F0D6] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-[#946E4B]">
                                {{ ucfirst($property->transaction_type ?? 'dijual') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($property->status) {
                                    'featured' => 'bg-[#F9F0D6] text-[#523828]',
                                    'sold'     => 'bg-[#F5E1D4] text-[#7A3B2E]',
                                    'rented'   => 'bg-[#F0E2BC] text-[#6B4A33]',
                                    'draft'    => 'bg-[#F3EFE6] text-[#8A7B63]',
                                    default    => 'bg-[#F9F0D6] text-[#523828]',
                                };
                            @endphp
                            <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge }}">
                                {{ ucfirst($property->status ?? 'published') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('properties.show', $property->slug) }}" target="_blank"
                                    class="rounded-lg border border-[#EADFCB] px-3 py-1.5 text-xs font-medium text-[#523828] transition hover:bg-[#F9F0D6] hover:text-[#1F1611]"
                                    title="Lihat Website">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <!-- <a href="{{ route('properties.edit', $property) }}"
                                    class="rounded-lg border border-[#EADFCB] px-3 py-1.5 text-xs font-medium text-[#946E4B] transition hover:bg-[#F9F0D6]">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a> -->
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-14 text-center">
                            <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#F9F0D6] text-[#946E4B]">
                                <i class="fa-solid fa-house-circle-xmark text-xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-[#1F1611]">Belum ada properti</p>
                            <p class="mt-1 text-xs text-[#523828]">Mulai dengan menambahkan properti pertama Anda.</p>
                            <a href="{{ route('properties.create') }}" class="btn-gilded mt-4 !py-2.5 !text-sm">
                                <i class="fa-solid fa-plus"></i> Tambah Properti
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

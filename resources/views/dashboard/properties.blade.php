@extends('layouts.admin')

@section('title', 'Properti - DJM Admin')

@section('content')

    {{-- Header --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#1F1611] sm:text-3xl">
                Properti
            </h1>
            <p class="mt-1 text-sm text-[#523828]">Kelola seluruh data properti DJM.</p>
        </div>
        <a href="{{ route('properties.create') }}" class="btn-gilded">
            <i class="fa-solid fa-plus"></i>
            Tambah Properti
        </a>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="card-head">
            <div>
                <h3 class="text-base font-bold text-[#1F1611]">Daftar Properti ({{ count($properties) }})</h3>
                <p class="mt-0.5 text-xs text-[#523828]">Seluruh properti yang terdaftar di platform DJM.</p>
            </div>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#F0E6D2] bg-[#FBF6EC] text-xs uppercase tracking-wider text-[#946E4B]">
                    <tr>
                        <th class="px-6 py-4 font-bold">Foto</th>
                        <th class="px-6 py-4 font-bold">Properti</th>
                        <th class="px-6 py-4 font-bold">Lokasi</th>
                        <th class="px-6 py-4 font-bold">Harga</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 text-right font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D2]">
                    @forelse($properties as $property)
                    <tr class="transition hover:bg-[#FBF6EC]/60">
                        <td class="px-6 py-4">
                            <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                                class="h-14 w-20 rounded-lg border border-[#EADFCB] object-cover shadow-sm">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#1F1611]">{{ $property->title }}</div>
                            <div class="mt-0.5 text-xs text-[#523828]">
                                <span class="rounded bg-[#F3EFE6] px-1.5 py-0.5 font-mono text-[#6B4A33]">{{ $property->property_id_code ?? ('ID-' . $property->id) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[#523828]">
                            <div class="text-xs">{{ Str::limit($property->address, 40) }}</div>
                            <div class="mt-0.5 text-xs font-semibold text-[#946E4B]">
                                {{ $property->city?->name ?? '-' }}
                            </div>
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
                            @if($property->is_featured)
                                <span class="ml-1 text-xs text-[#D4A569]" title="Featured Property">
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('properties.show', $property->slug) }}" target="_blank"
                                    class="rounded-lg border border-[#EADFCB] px-3 py-1.5 text-xs font-medium text-[#523828] transition hover:bg-[#F9F0D6] hover:text-[#1F1611]"
                                    title="Lihat Website">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('properties.edit', $property) }}"
                                    class="rounded-lg border border-[#EADFCB] px-3 py-1.5 text-xs font-medium text-[#946E4B] transition hover:bg-[#F9F0D6]">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('properties.destroy', $property) }}" method="POST"
                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti {{ addslashes($property->title) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg border border-[#F0D9CC] bg-[#FBF0EA] px-3 py-1.5 text-xs font-medium text-[#A4492F] transition hover:bg-[#F5E1D4]"
                                        title="Hapus Properti">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-14 text-center">
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

        {{-- MOBILE CARDS --}}
        <div class="divide-y divide-[#F0E6D2] md:hidden">
            @forelse($properties as $property)
            <div class="p-4">
                <div class="flex gap-4">
                    <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                        class="h-20 w-24 shrink-0 rounded-lg border border-[#EADFCB] object-cover shadow-sm">
                    <div class="min-w-0 flex-1">
                        <h4 class="line-clamp-1 text-sm font-semibold text-[#1F1611]">{{ $property->title }}</h4>
                        <p class="mt-0.5 text-xs text-[#523828]">
                            {{ $property->formatted_price }} • <span class="capitalize">{{ $property->transaction_type }}</span>
                        </p>
                        <p class="mt-1 line-clamp-1 text-xs text-[#523828]">
                            <i class="fa-solid fa-location-dot text-[#946E4B]"></i> {{ $property->address }}
                        </p>
                        @php
                            $badgeM = match($property->status) {
                                'featured' => 'bg-[#F9F0D6] text-[#523828]',
                                'sold'     => 'bg-[#F5E1D4] text-[#7A3B2E]',
                                'rented'   => 'bg-[#F0E2BC] text-[#6B4A33]',
                                'draft'    => 'bg-[#F3EFE6] text-[#8A7B63]',
                                default    => 'bg-[#F9F0D6] text-[#523828]',
                            };
                        @endphp
                        <span class="mt-2 inline-block rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeM }}">
                            {{ ucfirst($property->status ?? 'published') }}
                        </span>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('properties.edit', $property) }}"
                        class="flex-1 rounded-lg border border-[#EADFCB] px-3 py-2 text-center text-xs font-medium text-[#946E4B] transition hover:bg-[#F9F0D6]">
                        Edit
                    </a>
                    <form action="{{ route('properties.destroy', $property) }}" method="POST"
                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full rounded-lg bg-[#FBF0EA] px-3 py-2 text-xs font-medium text-[#A4492F] transition hover:bg-[#F5E1D4]">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-house-circle-xmark text-xl"></i>
                </div>
                <p class="text-sm font-semibold text-[#1F1611]">Belum ada properti</p>
            </div>
            @endforelse
        </div>
    </div>

@endsection

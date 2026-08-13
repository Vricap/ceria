<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Properti - DJM Admin</title>

    {{-- Tailwind CSS & FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800 antialiased min-h-screen">

    <div class="min-h-screen pb-12">

        {{-- Navbar --}}
        <nav class="border-b border-gray-200 bg-white sticky top-0 z-30">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight text-gray-900">
                        DJM <span class="text-blue-600">Admin</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website
                    </a>
                    <span class="text-sm text-gray-500">
                        Dashboard
                    </span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white shadow">
                        A
                    </div>
                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="mx-auto max-w-7xl px-6 py-8">

            {{-- Flash Alert --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            {{-- Header --}}
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Dashboard Properti
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Kelola seluruh daftar properti yang tersedia dalam sistem.
                    </p>
                </div>

                {{-- Tombol Tambah Properti --}}
                <a
                    href="{{ route('properties.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow transition hover:bg-gray-800 cursor-pointer"
                >
                    <i class="fa-solid fa-plus"></i>
                    Tambah Properti Baru
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Total Properti
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900">
                        {{ count($properties) }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Dipublikasikan
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-green-600">
                        {{ $properties->where('status', 'published')->count() + $properties->where('status', 'featured')->count() }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Properti Unggulan
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-amber-500">
                        {{ $properties->where('is_featured', true)->count() }}
                    </p>
                </div>
            </div>

            {{-- Table List --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-5">
                    <h3 class="font-semibold text-gray-900">
                        Daftar Properti ({{ count($properties) }})
                    </h3>
                    <p class="mt-0.5 text-xs text-gray-500">
                        Seluruh properti yang saat ini terdaftar di platform Ceria Property.
                    </p>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Foto</th>
                                <th class="px-6 py-4 font-semibold">Properti</th>
                                <th class="px-6 py-4 font-semibold">Kategori / Tipe</th>
                                <th class="px-6 py-4 font-semibold">Harga & Transaksi</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($properties as $property)
                            <tr class="transition hover:bg-gray-50/80">
                                {{-- Foto --}}
                                <td class="px-6 py-4">
                                    <img
                                        src="{{ $property->thumbnail_url }}"
                                        alt="{{ $property->title }}"
                                        class="h-14 w-20 rounded-lg object-cover shadow-sm border border-gray-200"
                                    >
                                </td>

                                {{-- Properti Title & ID --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">
                                        {{ $property->title }}
                                    </div>
                                    <div class="mt-0.5 text-xs text-gray-500 flex items-center gap-2">
                                        <span class="font-mono bg-gray-100 px-1.5 py-0.5 rounded text-gray-600">{{ $property->property_id_code ?? ('ID-' . $property->id) }}</span>
                                        <span>• {{ Str::limit($property->address, 35) }}</span>
                                    </div>
                                </td>

                                {{-- Kategori / Tipe --}}
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="text-xs font-semibold text-gray-900">
                                        {{ $property->category?->name ?? 'Umum' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $property->propertyType?->name ?? '-' }}
                                    </div>
                                </td>

                                {{-- Harga & Transaksi --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">
                                        {{ $property->formatted_price }}
                                    </div>
                                    <span class="inline-block mt-0.5 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider {{ $property->transaction_type == 'disewa' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($property->transaction_type ?? 'dijual') }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match($property->status) {
                                            'published' => 'bg-green-100 text-green-800',
                                            'featured'  => 'bg-purple-100 text-purple-800',
                                            'sold'      => 'bg-red-100 text-red-800',
                                            'rented'    => 'bg-amber-100 text-amber-800',
                                            default     => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">
                                        {{ ucfirst($property->status ?? 'published') }}
                                    </span>
                                    @if($property->is_featured)
                                        <span class="ml-1 text-xs text-amber-500" title="Featured Property">
                                            <i class="fa-solid fa-star"></i>
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a
                                            href="{{ route('properties.show', $property->slug) }}"
                                            target="_blank"
                                            class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
                                            title="Lihat Tampilan Website"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('properties.edit', $property) }}"
                                            class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-blue-600 transition hover:bg-blue-50"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <form
                                            action="{{ route('properties.destroy', $property) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti {{ addslashes($property->title) }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-100"
                                            >
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Belum ada properti yang ditambahkan. Silakan klik tombol "Tambah Properti Baru".
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE CARDS --}}
                <div class="divide-y divide-gray-100 md:hidden">
                    @forelse($properties as $property)
                    <div class="p-4">
                        <div class="flex gap-4">
                            <img
                                src="{{ $property->thumbnail_url }}"
                                alt="{{ $property->title }}"
                                class="h-20 w-24 shrink-0 rounded-lg object-cover shadow-sm border border-gray-200"
                            >
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-semibold text-gray-900 text-sm line-clamp-1">
                                        {{ $property->title }}
                                    </h4>
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $property->formatted_price }} • <span class="capitalize">{{ $property->transaction_type }}</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i> {{ $property->address }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a
                                href="{{ route('properties.edit', $property) }}"
                                class="flex-1 text-center rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-blue-600 transition hover:bg-blue-50"
                            >
                                Edit
                            </a>
                            <form
                                action="{{ route('properties.destroy', $property) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti ini?')"
                                class="flex-1"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="w-full rounded-lg bg-red-50 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-100"
                                >
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-sm text-gray-500">
                        Belum ada properti.
                    </div>
                    @endforelse
                </div>

            </div>
        </main>
    </div>

</body>
</html>

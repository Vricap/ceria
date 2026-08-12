{{-- resources/views/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Properti</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen">

        {{-- Navbar --}}
        <nav class="border-b border-gray-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        Ceria
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">
                        Dashboard
                    </span>

                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                        A
                    </div>
                </div>

            </div>
        </nav>


        {{-- Main Content --}}
        <main class="mx-auto max-w-7xl px-6 py-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Dashboard Properti
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Kelola daftar properti yang tersedia.
                    </p>
                </div>

                {{-- Tombol tambah --}}
                <a
                    type="button"
                    href="{{ route('properties.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700 cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Tambah Properti
                </a>

            </div>


            {{-- Summary --}}
            <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Properti
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ count($properties) }}
                    </p>
                </div>

                <!--<div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Properti Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        10
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Properti Tidak Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        2
                    </p>
                </div>-->

            </div>


            {{-- Table --}}
            {{-- =========================
                PROPERTY LIST
            ========================== --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                {{-- Section Header --}}
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6">

                    <h3 class="font-semibold text-gray-900">
                        Daftar Properti
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Daftar properti yang telah ditambahkan.
                    </p>

                </div>


                {{-- ==================================
                    DESKTOP TABLE
                =================================== --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full text-left text-sm">

                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>

                                <th class="px-6 py-4 font-semibold">
                                    ID
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Properti
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Alamat
                                </th>

                                <th class="px-6 py-4 font-semibold">
                                    Gambar
                                </th>

                                <th class="px-6 py-4 text-right font-semibold">
                                    Aksi
                                </th>

                            </tr>
                        </thead>


                        <tbody class="divide-y divide-gray-100">
                            @foreach($properties as $property)

                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $loop->index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $property->title }}
                                    </div>

                                    <!--<div class="mt-1 text-xs text-gray-500">
                                        Rumah
                                    </div>-->
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $property->address }}
                                </td>

                                <td class="px-6 py-4">

                                    <img
                                        src="{{ $property->thumbnail_url }}"
                                        alt="{{ $property->title }}"
                                        class="h-16 w-24 rounded-lg object-cover"
                                    >

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('properties.edit', $property) }}"
                                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('properties.destroy', $property) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>


                {{-- ==================================
                    MOBILE CARDS
                =================================== --}}
                <div class="divide-y divide-gray-100 md:hidden">

                @foreach($properties as $property)

                    <div class="p-4">

                        <div class="flex gap-4">

                            <img
                                src="{{ $property->thumbnail_url }}"
                                alt="{{ $property->title }}"
                                class="h-24 w-28 shrink-0 rounded-lg object-cover"
                            >

                            <div class="min-w-0 flex-1">

                                <div class="mb-1 flex items-start justify-between gap-2">

                                    <h4 class="font-semibold text-gray-900">
                                        {{ $property->title }}
                                    </h4>

                                    <span class="shrink-0 text-xs font-medium text-gray-400">
                                        {{ $loop->index + 1 }}
                                    </span>

                                </div>

                                <!--<p class="mb-2 text-xs text-gray-500">
                                    Rumah
                                </p>-->

                                <div class="flex items-start gap-1.5 text-sm text-gray-600">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mt-0.5 h-4 w-4 shrink-0 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>

                                    <span>
                                        {{ $property->address }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="mt-4 flex gap-2">

                            <button
                                type="button"
                                class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                            >
                                Edit
                            </button>

                            <form
                                action="{{ route('properties.destroy', $property) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus properti ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="flex-1 rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100"
                                >
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>
                    @endforeach
                </div>


                {{-- Pagination --}}
                <!--<div class="flex flex-col gap-4 border-t border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                    <p class="text-center text-sm text-gray-500 sm:text-left">
                        Menampilkan 1–4 dari 12 properti
                    </p>

                    <div class="flex justify-center gap-1 sm:justify-end">

                        <button
                            type="button"
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400"
                            disabled
                        >
                            <span class="hidden sm:inline">Sebelumnya</span>
                            <span class="sm:hidden">‹</span>
                        </button>

                        <button
                            type="button"
                            class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                        >
                            1
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        >
                            2
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        >
                            3
                        </button>

                        <button
                            type="button"
                            class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50"
                        >
                            <span class="hidden sm:inline">Berikutnya</span>
                            <span class="sm:hidden">›</span>
                        </button>

                    </div>

                </div>-->

            </div>

        </main>

    </div>

</body>
</html>

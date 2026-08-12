{{-- resources/views/properties/create.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Properti</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

<div class="min-h-screen">

    {{-- =========================
        NAVBAR
    ========================== --}}
    <nav class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6">

            <div>
                <h1 class="text-xl font-bold text-gray-900">
                    PropertiKu
                </h1>
            </div>

            <div class="flex items-center gap-3">

                <span class="hidden text-sm text-gray-500 sm:block">
                    Dashboard
                </span>

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                    A
                </div>

            </div>

        </div>
    </nav>


    {{-- =========================
        MAIN
    ========================== --}}
    <main class="mx-auto max-w-3xl px-4 py-6 sm:px-6 sm:py-10">

        {{-- Back --}}
        <div class="mb-6">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Kembali ke Dashboard

            </a>

        </div>


        {{-- Page Header --}}
        <div class="mb-6">

            <h2 class="text-2xl font-bold text-gray-900">
                Tambah Properti
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Tambahkan properti baru ke dalam daftar properti.
            </p>

        </div>


        {{-- =========================
            FORM
        ========================== --}}
        <form
            action="{{ route('properties.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
        >

            {{-- CSRF --}}
            @csrf


            {{-- Form Content --}}
            <div class="space-y-6 p-5 sm:p-6">


                {{-- =========================
                    NAMA PROPERTI
                ========================== --}}
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Nama Properti
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="nama"
                        required
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Rumah Minimalis Modern"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                    >

                    @error('nama')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =========================
                    ALAMAT
                ========================== --}}
                <div>

                    <label
                        for="address"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Alamat
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="address"
                        name="alamat"
                        required
                        rows="4"
                        placeholder="Masukkan alamat lengkap properti"
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                    >{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =========================
                    GAMBAR
                ========================== --}}
                <div>
                    <label
                        for="image"
                        class="mb-2 block text-sm font-medium text-gray-900"
                    >
                        Gambar Properti
                        <span class="text-red-500">*</span>
                    </label>

                    {{-- Image Upload / Preview --}}
                    <label
                        for="image"
                        id="imageUploadArea"
                        class="group relative flex min-h-[260px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-white text-center transition hover:border-gray-500 hover:bg-gray-50"
                    >

                        {{-- Default Upload Content --}}
                        <div id="uploadPlaceholder">

                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 transition group-hover:bg-gray-200">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2v12a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>

                            <p class="text-sm font-medium text-gray-700">
                                Klik untuk memilih gambar
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                PNG, JPG atau JPEG maksimal 2MB
                            </p>

                        </div>


                        {{-- Image Preview --}}
                        <div
                            id="imagePreviewContainer"
                            class="absolute inset-0 hidden"
                        >

                            <img
                                id="imagePreview"
                                src=""
                                alt="Preview gambar properti"
                                class="h-full w-full object-cover"
                            >

                            {{-- Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">

                                <div class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-800 shadow-sm">
                                    Ganti gambar
                                </div>

                            </div>

                        </div>

                    </label>


                    {{-- File Input --}}
                    <input
                        type="file"
                        id="image"
                        name="gambar"
                        accept="image/png,image/jpeg,image/jpg"
                        class="hidden"
                    >


                    @error('gambar')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- =========================
                FORM FOOTER
            ========================== --}}
            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:justify-end sm:p-6">

                {{-- Cancel --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 sm:w-auto"
                >
                    Batal
                </a>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-700 sm:w-auto"
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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Simpan Properti

                </button>

            </div>

        </form>

    </main>

</div>

<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        // Pastikan file adalah gambar
        if (!file.type.startsWith('image/')) {
            return;
        }

        // Preview gambar
        const reader = new FileReader();

        reader.onload = function (event) {
            imagePreview.src = event.target.result;

            uploadPlaceholder.classList.add('hidden');
            imagePreviewContainer.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    });
</script>

</body>
</html>

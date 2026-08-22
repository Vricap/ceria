@extends('layouts.admin')

@section('title', 'Tipe Properti - DJM Admin')

@section('content')

    {{-- Header --}}
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#1F1611] sm:text-3xl">
                Tipe Properti
            </h1>
            <p class="mt-1 text-sm text-[#523828]">Kelola daftar tipe properti yang tersedia di platform DJM.</p>
        </div>
    </div>

    {{-- Form Tambah --}}
    <div class="card mb-6">
        <div class="card-head">
            <div>
                <h3 class="text-base font-bold text-[#1F1611]">Tambah Tipe Baru</h3>
                <p class="mt-0.5 text-xs text-[#523828]">Tipe baru otomatis aktif dan langsung bisa dipakai pada data properti.</p>
            </div>
        </div>
        <form action="{{ route('property-types.store') }}" method="POST"
            class="flex flex-col gap-3 px-6 pb-6 pt-4 sm:flex-row">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" required maxlength="100"
                placeholder="Contoh: Kios, Townhouse, Apartemen Serviced..."
                class="field-input flex-1" />
            <button type="submit" class="btn-gilded shrink-0">
                <i class="fa-solid fa-plus"></i>
                Tambah
            </button>
        </form>
    </div>

    {{-- Daftar Tipe --}}
    <div class="card overflow-hidden">
        <div class="card-head">
            <div>
                <h3 class="text-base font-bold text-[#1F1611]">Daftar Tipe Properti ({{ count($propertyTypes) }})</h3>
                <p class="mt-0.5 text-xs text-[#523828]">Tidak dapat dihapus — gunakan status Nonaktif untuk menyembunyikan tipe dari pencarian.</p>
            </div>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[#F0E6D2] bg-[#FBF6EC] text-xs uppercase tracking-wider text-[#946E4B]">
                    <tr>
                        <th class="px-6 py-4 font-bold">Nama Tipe</th>
                        <th class="px-6 py-4 font-bold">Jumlah Properti</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 text-right font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0E6D2]">
                    @forelse($propertyTypes as $type)
                    <tr class="transition hover:bg-[#FBF6EC]/60">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#1F1611]">{{ $type->name }}</div>
                            <div class="mt-0.5 text-xs text-[#523828]">
                                <span class="rounded bg-[#F3EFE6] px-1.5 py-0.5 font-mono text-[#6B4A33]">{{ $type->slug }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F3EFE6] px-2.5 py-1 text-xs font-semibold text-[#523828]">
                                <i class="fa-solid fa-building text-[10px] text-[#946E4B]"></i>
                                {{ $type->properties_count }} properti
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($type->is_active)
                                <span class="inline-block rounded-full bg-[#F9F0D6] px-2.5 py-1 text-xs font-semibold text-[#523828]">
                                    <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i>Aktif
                                </span>
                            @else
                                <span class="inline-block rounded-full bg-[#F3EFE6] px-2.5 py-1 text-xs font-semibold text-[#8A7B63]">
                                    <i class="fa-solid fa-circle-xmark mr-1 text-[10px]"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button"
                                onclick="openEditDialog(this)"
                                data-action="{{ route('property-types.update', $type) }}"
                                data-name="{{ $type->name }}"
                                data-slug="{{ $type->slug }}"
                                data-active="{{ $type->is_active ? '1' : '0' }}"
                                class="rounded-lg border border-[#EADFCB] px-3 py-1.5 text-xs font-medium text-[#946E4B] transition hover:bg-[#F9F0D6]"
                                title="Edit Tipe">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-14 text-center">
                            <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#F9F0D6] text-[#946E4B]">
                                <i class="fa-solid fa-layer-group text-xl"></i>
                            </div>
                            <p class="text-sm font-semibold text-[#1F1611]">Belum ada tipe properti</p>
                            <p class="mt-1 text-xs text-[#523828]">Tambahkan tipe pertama melalui form di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="divide-y divide-[#F0E6D2] md:hidden">
            @forelse($propertyTypes as $type)
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-semibold text-[#1F1611]">{{ $type->name }}</h4>
                        <p class="mt-0.5 text-xs text-[#523828]">
                            <span class="rounded bg-[#F3EFE6] px-1.5 py-0.5 font-mono text-[#6B4A33]">{{ $type->slug }}</span>
                        </p>
                        <p class="mt-1.5 text-xs text-[#523828]">
                            <i class="fa-solid fa-building text-[#946E4B]"></i> {{ $type->properties_count }} properti
                        </p>
                        <span class="mt-2 inline-block rounded-full px-2.5 py-1 text-xs font-semibold {{ $type->is_active ? 'bg-[#F9F0D6] text-[#523828]' : 'bg-[#F3EFE6] text-[#8A7B63]' }}">
                            {{ $type->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <button type="button"
                        onclick="openEditDialog(this)"
                        data-action="{{ route('property-types.update', $type) }}"
                        data-name="{{ $type->name }}"
                        data-slug="{{ $type->slug }}"
                        data-active="{{ $type->is_active ? '1' : '0' }}"
                        class="flex-1 rounded-lg border border-[#EADFCB] px-3 py-2 text-center text-xs font-medium text-[#946E4B] transition hover:bg-[#F9F0D6]">
                        Edit
                    </button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-[#F9F0D6] text-[#946E4B]">
                    <i class="fa-solid fa-layer-group text-xl"></i>
                </div>
                <p class="text-sm font-semibold text-[#1F1611]">Belum ada tipe properti</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Dialog Edit --}}
    <dialog id="edit-dialog" class="w-[calc(100%-2rem)] max-w-md rounded-2xl border border-[#EADFCB] bg-white p-0 shadow-2xl backdrop:bg-black/40">
        <form method="POST" id="edit-form" class="p-6" onsubmit="return true;">
            @csrf
            @method('PUT')
            <h3 class="text-lg font-bold text-[#1F1611]">
                <i class="fa-solid fa-pen-to-square mr-2 text-[#946E4B]"></i>Edit Tipe Properti
            </h3>
            <p class="mt-0.5 mb-4 text-xs text-[#523828]">
                Slug: <span id="edit-slug" class="rounded bg-[#F3EFE6] px-1.5 py-0.5 font-mono text-[#6B4A33]"></span> (tidak berubah)
            </p>

            <label for="edit-name" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#946E4B]">Nama Tipe</label>
            <input type="text" name="name" id="edit-name" required maxlength="100" class="field-input" />

            <label class="mt-3 flex cursor-pointer items-center gap-2.5 rounded-lg border border-[#EADFCB] bg-[#FBF6EC] px-3 py-2.5 text-sm font-semibold text-[#1F1611]">
                <input type="checkbox" name="is_active" id="edit-active" class="h-4 w-4 accent-[#946E4B]" />
                Tipe aktif (tampil di filter pencarian)
            </label>

            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('edit-dialog').close()"
                    class="rounded-lg border border-[#EADFCB] px-4 py-2 text-sm font-medium text-[#523828] transition hover:bg-[#F9F0D6]">
                    Batal
                </button>
                <button type="submit" class="btn-gilded !py-2 !text-sm">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </form>
    </dialog>

    <script>
        function openEditDialog(btn) {
            const form = document.getElementById('edit-form');
            form.action = btn.dataset.action;
            document.getElementById('edit-name').value = btn.dataset.name;
            document.getElementById('edit-active').checked = btn.dataset.active === '1';
            document.getElementById('edit-slug').textContent = btn.dataset.slug;
            document.getElementById('edit-dialog').showModal();
        }
    </script>

@endsection

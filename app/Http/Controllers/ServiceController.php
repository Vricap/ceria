<?php

namespace App\Http\Controllers;

use App\Support\ServiceItem;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = ServiceItem::all()->groupBy('category');

        return view('services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = ServiceItem::find($slug);

        abort_if($service === null, 404);

        $services = ServiceItem::all()
            ->reject(fn (ServiceItem $item) => $item->slug === $slug)
            ->values();

        $highlightCards = null;

        if ($service->slug === 'pengeringan') {
            $highlightCards = [
                [
                    'icon' => 'fa-water',
                    'title' => 'Apa itu Pengeringan?',
                    'text' => 'Kami melayani pengurusan perizinan Pengeringan Lahan/Tanah berupa Izin Penggunaan Pemanfaatan Tanah (IPPT) yang dikeluarkan oleh Badan Pertanahan Nasional (BPN) dan terdapat di dalam izin prinsip. IPPT berfungsi untuk merubah status tanah dari tanah sawah/tegalan menjadi tanah pekarangan sebagai lahan untuk pembangunan rumah tinggal.',
                ],
            ];
        }

        if ($service->slug === 'pecah-sertifikat') {
            $highlightCards = [
                [
                    'icon' => 'fa-file-invoice',
                    'title' => 'Apa itu Pecah Sertifikat?',
                    'text' => 'Kami melayani pengurusan Pemecahan Sertifikat Tanah. Proses ini diperlukan untuk berbagai hal seperti ketika ingin menjual sebagian bidang tanah atau saat pembagian warisan. Memecah sertifikat tanah akan menghindarkan dari sengketa yang mungkin terjadi di kemudian hari.',
                ],
            ];
        }

        if ($service->slug === 'pbg-imb') {
            $gambarSections = [
                [
                    'title' => 'Gambar IMB/PBG',
                    'items' => [
                        'Denah Siteplan &amp; Situasi',
                        'Denah Rencana Tata Ruang',
                        'Gambar Tampak',
                        'Gambar Potongan A, B, C,..dst',
                        'Rencana Pondasi-Sloof &amp; Detail',
                        'Rencana Kolom &amp; Detail',
                        'Rencana Balok-Plat Lantai &amp; Detail',
                        'Rencana Atap &amp; Detail',
                        'Jaringan Sanitasi',
                        'Jaringan Listrik',
                        'Tambahan : Dok. Perhitungan Struktur',
                    ],
                ],
                [
                    'title' => 'Gambar ARSITEKTUR',
                    'items' => [
                        'Layout Plan (denah situasi bangunan)',
                        'Layout Landscape',
                        'Denah Rencana Tata Ruang',
                        'Gambar Tampak',
                        'Potongan A, B, C,..dst',
                        'Denah Rencana Pola Lantai',
                        'Denah Rencana Plafond',
                        'Denah Rencana Atap',
                        'Denah Rencana Pintu-Jendela',
                        'Detail Rangka Plafond',
                        'Detail Rangka Atap',
                        'Detail Kusen Pintu Jendela',
                    ],
                ],
                [
                    'title' => 'Gambar STRUKTUR',
                    'items' => [
                        'Rencana Pondasi Footplat/Cakarayam',
                        'Rencana Pondasi Menerus/Batukali',
                        'Rencana Sloof',
                        'Rencana Kolom Struktur dan Kolom Praktis',
                        'Rencana RingBalok, Balok Gantung/Latei',
                        'Rencana Pelat Lantai',
                        'Rencana Pelat Atap',
                        'Detail Pondasi dan Sloof',
                        'Detail Kolom dan Balok',
                        'Detail Penulangan/Pembesian Plat',
                        'Detail Rangka Atap',
                    ],
                ],
                [
                    'title' => 'Gambar ME / UTILITAS',
                    'items' => [
                        'Rencana Listrik (Saklar &amp; Stop Kontak)',
                        'Rencana Titik Lampu',
                        'Rencana Titik AC',
                        'Rencana Sanitair (Air Bersih)',
                        'Rencana Distribusi Air Panas &amp; Dingin',
                        'Rencana Sanitasi Air Kotor dan Air Bekas',
                        'Rencana Pembuangan Air Hujan',
                        'Detail Sumur Resapan',
                        'Detail Septictank',
                        'Detail Penutup Saluran Air Drainase',
                    ],
                ],
            ];

            return view('services.show-pbg-imb', compact('service', 'services', 'gambarSections'));
        }

        return view('services.show', compact('service', 'services', 'highlightCards'));
    }
}

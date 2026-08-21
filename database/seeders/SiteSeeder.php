<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\Service;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Site Settings ─────────────────────────────────────────────────────────
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'DJM Property',                    'type' => 'text',     'group' => 'general', 'label' => 'Nama Website'],
            ['key' => 'site_tagline',     'value' => 'Mitra Properti Terpercaya Anda',          'type' => 'text',     'group' => 'general', 'label' => 'Tagline'],
            ['key' => 'site_logo',        'value' => '',                                  'type' => 'image',    'group' => 'general', 'label' => 'Logo'],
            ['key' => 'site_favicon',     'value' => '',                                  'type' => 'image',    'group' => 'general', 'label' => 'Favicon'],
            ['key' => 'site_description', 'value' => 'Platform properti terpercaya di Yogyakarta. Temukan rumah, tanah, villa, dan properti impian Anda.', 'type' => 'textarea', 'group' => 'general', 'label' => 'Deskripsi Website'],

            // Contact
            ['key' => 'contact_address',  'value' => 'Jl. Kaliurang KM 7, Sleman, Yogyakarta',   'type' => 'text',    'group' => 'contact', 'label' => 'Alamat'],
            ['key' => 'contact_phone',    'value' => '+62 274 123456',                             'type' => 'text',    'group' => 'contact', 'label' => 'Telepon'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890',                              'type' => 'text',    'group' => 'contact', 'label' => 'WhatsApp'],
            ['key' => 'contact_email',    'value' => 'info@djmProperty.id',                      'type' => 'text',    'group' => 'contact', 'label' => 'Email'],
            ['key' => 'contact_hours',    'value' => 'Senin – Jumat: 08.00–17.00 WIB',             'type' => 'text',    'group' => 'contact', 'label' => 'Jam Operasional'],

            // Social
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/djmProperty',  'type' => 'text', 'group' => 'social', 'label' => 'Instagram'],
            ['key' => 'social_facebook',  'value' => 'https://facebook.com/djmProperty',   'type' => 'text', 'group' => 'social', 'label' => 'Facebook'],
            ['key' => 'social_youtube',   'value' => '',                                      'type' => 'text', 'group' => 'social', 'label' => 'YouTube'],
            ['key' => 'social_tiktok',    'value' => '',                                      'type' => 'text', 'group' => 'social', 'label' => 'TikTok'],

            // SEO
            ['key' => 'seo_title',        'value' => 'DJM Property – Solusi Properti & Konstruksi di Yogyakarta', 'type' => 'text',     'group' => 'seo', 'label' => 'SEO Title'],
            ['key' => 'seo_description',  'value' => 'DJM Property menyediakan informasi dan layanan properti, konstruksi, serta jasa pendukung kebutuhan properti di Yogyakarta. Temukan properti dan solusi properti yang sesuai dengan kebutuhan Anda.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'SEO Description'],

            // Homepage
            ['key' => 'hero_title',       'value' => 'Temukan Properti Impian Anda, Mudah & Cepat',   'type' => 'text',     'group' => 'homepage', 'label' => 'Hero Title'],
            ['key' => 'hero_subtitle',    'value' => 'Temukan properti terverifikasi, rumah mewah, dan peluang investasi terbaik dalam satu tempat.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'Hero Subtitle'],
            ['key' => 'hero_image',       'value' => '',                                                                'type' => 'image',    'group' => 'homepage', 'label' => 'Hero Background'],
            ['key' => 'about_title',      'value' => 'Mitra Terpercaya dalam Investasi & Pengelolaan Properti',       'type' => 'text',     'group' => 'homepage', 'label' => 'About Title'],
            ['key' => 'about_description','value' => 'Kami membantu Anda menemukan, membeli, dan mengelola properti dengan proses yang mudah, transparan, dan terpercaya. Bergabunglah dengan ribuan klien yang telah mempercayakan kebutuhan properti mereka kepada kami.', 'type' => 'textarea', 'group' => 'homepage', 'label' => 'About Description'],
            ['key' => 'about_image',      'value' => '',                                                                'type' => 'image',    'group' => 'homepage', 'label' => 'About Image'],
            ['key' => 'stat_properties',  'value' => '2000+',  'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Properti'],
            ['key' => 'stat_clients',     'value' => '1500+',  'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Klien'],
            ['key' => 'stat_agents',      'value' => '100+',   'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Agen'],
            ['key' => 'stat_support',     'value' => '24/7',   'type' => 'text', 'group' => 'homepage', 'label' => 'Stat: Support'],
            ['key' => 'experience_years', 'value' => '15+',    'type' => 'text', 'group' => 'homepage', 'label' => 'Pengalaman (tahun)'],
            ['key' => 'google_maps_embed','value' => '',       'type' => 'textarea', 'group' => 'contact', 'label' => 'Google Maps Embed URL'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // ─── Services ──────────────────────────────────────────────────────────────
        // Layanan asli DJM (Desty Jaya Mandiri): Perizinan & Konstruksi.
        $services = [
            // ── Kategori: Perizinan ──────────────────────────────────────────────

            // PBG / IMB
            [
                'name' => 'PBG / IMB',
                'slug' => 'pbg-imb',
                'category' => 'perizinan',
                'icon' => 'fa-file-signature',
                'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&h=600&fit=crop&q=80',
                'short_description' => 'Pengurusan Persetujuan Bangunan Gedung (PBG) dan Izin Mendirikan Bangunan (IMB) secara cepat dan resmi.',
                'seo_title' => 'Jasa Pengurusan PBG / IMB Yogyakarta | DJM Property',
                'seo_description' => 'DJM membantu pengurusan PBG dan IMB di Yogyakarta. Penyusunan gambar teknis, dokumen administrasi, hingga pendampingan pengajuan.',
                'description' => <<<'HTML'
<!-- SVC_CARDS_START -->
<h2 data-icon="fa-solid fa-triangle-exclamation" data-accent="kendala">Kendala yang Sering Dihadapi</h2>
<p>Beberapa kendala yang umum dihadapi dalam pengurusan PBG antara lain:</p>
<ul>
<li>Bingung dengan persyaratan pengurusan PBG.</li>
<li>Tidak memiliki tenaga teknis untuk menyiapkan gambar bangunan.</li>
<li>Kesulitan mempersiapkan dokumen teknis dan administrasi.</li>
<li>Tidak memahami alur pengajuan melalui sistem yang berlaku.</li>
<li>Tidak memiliki waktu untuk mengurus proses administrasi.</li>
<li>Mendapat permintaan perbaikan atau revisi dokumen.</li>
<li>Tidak yakin apakah rencana bangunan telah sesuai ketentuan yang berlaku.</li>
</ul>
<p><strong>DJM membantu Anda mempersiapkan kebutuhan tersebut secara lebih praktis dan terarah.</strong></p>

<h2 data-icon="fa-solid fa-clipboard-check" data-accent="persyaratan">Persyaratan IMB / PBG</h2>
<p>Untuk mengurus IMB / PBG, bangunan Anda harus:</p>
<ul>
<li>Memiliki peruntukan lahan sesuai RTRW/RDTR.</li>
<li>Memenuhi ketentuan KDB, KLB, dan Garis Sempadan.</li>
<li>Tidak berada di kawasan konservasi atau jalur hijau.</li>
</ul>

<h2 data-icon="fa-solid fa-award" data-accent="manfaat">Manfaat Kepemilikan Surat IMB / PBG</h2>
<p>Adapun beberapa manfaat dari IMB adalah sebagai berikut ini:</p>
<ol>
<li>Memastikan pembangunan berstatus legal. Pemerintah telah mewajibkan setiap orang yang akan, sedang atau pun telah membangun rumah, kantor dan bangunan lainnya untuk segera mengurus dokumen izin mendirikan bangunan.</li>
<li>Terdata keberadaan rencana bangunan gedung. Rencana tata ruang membagi beberapa wilayah menjadi zona hijau (pertanian/resapan air), kuning (pemukiman), merah (komersil), dll.</li>
<li>Sebagai syarat wajib bagi perijinan lainnya. Legalitas ini juga dibutuhkan jika properti Anda gunakan untuk kegiatan usaha, jual beli rumah, jaminan maupun kegiatan lain yang mensyaratkan bangunan sudah mendapatkan persetujuan IMB.</li>
<li>Meningkatkan nilai jual dari suatu bangunan. Karena konsumen merasa aman dan nyaman tanpa harus mempertanyakan apakah bangunannya resmi/tidak, atau khawatir akan adanya penggusuran.</li>
<li>Jaminan keamanan dan keselamatan. Memastikan penyelenggaraan bangunan gedung tersebut memenuhi standar yang menjamin keselamatan, kenyamanan, kesehatan dan kemudahan bagi penggunanya.</li>
</ol>

<h2 data-icon="fa-solid fa-handshake" data-accent="djm">Kenapa Menggunakan Jasa DJM?</h2>
<ul>
<li>Konsultasi kebutuhan sebelum proses dimulai.</li>
<li>Membantu mempersiapkan dokumen teknis.</li>
<li>Proses lebih terarah dan sistematis.</li>
<li>Mengurangi risiko kesalahan dalam persiapan dokumen.</li>
<li>Cocok untuk pemilik rumah, bangunan usaha, maupun properti lainnya.</li>
<li>Pendampingan disesuaikan dengan kondisi dan kebutuhan bangunan.</li>
</ul>
<!-- SVC_CARDS_END -->

<!-- SVC_ALUR_START -->
<h2>Alur Layanan</h2>
<ul>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Konsultasi &amp; Analisis Awal</strong> — Konsultasikan bangunan Anda. Kami cek kelayakan lahan &amp; dokumen. Kami pastikan lahan Anda sesuai peruntukan &amp; zona tata ruang.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Penyusunan Gambar &amp; Dokumen Teknis</strong> — Tim arsitek &amp; struktur kami siapkan semua berkas sesuai standar dinas. Mulai dari site plan, denah, tampak, potongan, hingga rencana teknis lainnya (termasuk dokumen perhitungan struktur).</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pengurusan Lewat OSS/SIMBG</strong> — Kami daftarkan permohonan Anda dan lakukan komunikasi aktif, hingga diverifikasi oleh dinas terkait.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Verifikasi Dinas &amp; Revisi Jika Diperlukan</strong> — Kami bantu komunikasi dengan Dinas Cipta Karya/PUPR dan update progres Anda. Jika ada catatan dari dinas, kami bantu revisi &amp; klarifikasi sampai lolos.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pembayaran Retribusi</strong> — Pembayaran retribusi resmi berdasarkan SKRD (Surat Ketetapan Retribusi Daerah) yang diterbitkan dinas terkait. SKRD PBG sebagai dasar pembayaran resmi untuk layanan penerbitan PBG.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Penerbitan PBG Resmi</strong> — Setelah pembayaran retribusi resmi melalui SKRD, PBG disetujui dan Anda akan menerima berkas IMB/PBG resmi.</div></li>
</ul>
<!-- SVC_ALUR_END -->

<!-- SVC_DOKUMEN_START -->
<h2>Dokumen yang Umumnya Dibutuhkan</h2>
<p>Persyaratan dapat berbeda sesuai kondisi bangunan dan lokasi. Beberapa dokumen yang umumnya perlu dipersiapkan antara lain:</p>
<ul>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-id-card"></i></span><span class="svc-dok-text">KTP Pemilik Bangunan</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-contract"></i></span><span class="svc-dok-text">Sertifikat Tanah SHM / HGB</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-signature"></i></span><span class="svc-dok-text">Surat Kuasa (jika dikuasakan)</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span><span class="svc-dok-text">SPPT PBB Tahun Terakhir</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-people-roof"></i></span><span class="svc-dok-text">Surat Persetujuan Tetangga (jika diperlukan)</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-laptop-file"></i></span><span class="svc-dok-text">Formulir OSS / SIMBG yang telah diisi</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-drafting-compass"></i></span><span class="svc-dok-text">Gambar Rencana Arsitektur, Struktur, MEP</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-building"></i></span><span class="svc-dok-text">Dokumen Perhitungan Struktur (bertingkat)</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-mountain"></i></span><span class="svc-dok-text">Data Hasil Uji Sondir Tanah (3 lantai ke atas)</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-circle-check"></i></span><span class="svc-dok-text">Dokumen Teknis Lain Untuk Bangunan/Lokasi Khusus</span></li>
</ul>
<p><strong>Belum lengkap? Tidak perlu bingung. Konsultasikan kondisi bangunan Anda kepada kami terlebih dahulu.</strong></p>
<!-- SVC_DOKUMEN_END -->
HTML,
                'sort_order' => 1,
            ],

            // Pengeringan Lahan
            [
                'name' => 'Pengeringan',
                'slug' => 'pengeringan',
                'category' => 'perizinan',
                'icon' => 'fa-water',
                'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&h=600&fit=crop&q=80',
                'short_description' => 'Jasa pengeringan lahan untuk menyiapkan tanah yang siap dibangun.',
                'seo_title' => 'Jasa Pengeringan Lahan Yogyakarta | DJM Property',
                'seo_description' => 'DJM membantu pengurusan administrasi pengeringan lahan di Yogyakarta. Konsultasi, persiapan dokumen, hingga pendampingan proses.',
                'description' => <<<'HTML'
<h2>Kapan Anda Membutuhkan Layanan Ini?</h2>
<p>Layanan pengeringan dapat menjadi bagian dari proses yang perlu diperhatikan ketika:</p>
<ul>
<li>Tanah memiliki status atau peruntukan yang perlu disesuaikan.</li>
<li>Lahan akan digunakan untuk kebutuhan pembangunan.</li>
<li>Terdapat kebutuhan administrasi terkait perubahan penggunaan lahan.</li>
<li>Anda belum memahami dokumen dan tahapan yang harus dipersiapkan.</li>
<li>Anda ingin memastikan proses dilakukan melalui prosedur yang sesuai.</li>
</ul>

<h2>Apa yang DJM Bantu?</h2>

<h3>Konsultasi Kondisi Lahan</h3>
<p>Kami membantu memahami kondisi awal tanah dan kebutuhan proses berdasarkan informasi serta dokumen yang Anda miliki.</p>

<h3>Pemeriksaan Dokumen</h3>
<p>Membantu mengidentifikasi dokumen yang diperlukan dan mengevaluasi kelengkapan administrasi.</p>

<h3>Persiapan Administrasi</h3>
<p>Membantu mempersiapkan dokumen yang diperlukan untuk mendukung proses pengurusan.</p>

<h3>Pendampingan Proses</h3>
<p>Memberikan arahan dan pendampingan dalam proses administrasi sesuai kebutuhan dan kewenangan instansi terkait.</p>

<!-- SVC_ALUR_START -->
<h2>Alur Layanan</h2>
<ul>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Konsultasi</strong> — Sampaikan kondisi dan tujuan penggunaan lahan Anda.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pemeriksaan Dokumen</strong> — Dokumen dan informasi lahan diperiksa untuk mengetahui kebutuhan proses.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Persiapan Administrasi</strong> — Dokumen yang diperlukan dipersiapkan sesuai kondisi lahan.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Proses Pengurusan</strong> — Proses administrasi dilakukan sesuai prosedur yang berlaku.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Penyelesaian</strong> — DJM membantu memantau proses hingga tahapan layanan selesai.</div></li>
</ul>
<!-- SVC_ALUR_END -->

<!-- SVC_DOKUMEN_START -->
<h2>Dokumen yang Perlu Dipersiapkan</h2>
<p>Dokumen dapat berbeda tergantung kondisi dan lokasi tanah. Dokumen yang mungkin diperlukan antara lain:</p>
<ul>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-id-card"></i></span><span class="svc-dok-text">Identitas pemilik</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-contract"></i></span><span class="svc-dok-text">Sertifikat atau dokumen kepemilikan tanah</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span><span class="svc-dok-text">Dokumen PBB</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-map-location-dot"></i></span><span class="svc-dok-text">Data lokasi dan luas tanah</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-circle-check"></i></span><span class="svc-dok-text">Dokumen pendukung lainnya sesuai kebutuhan</span></li>
</ul>
<p><strong>Belum tahu apakah tanah Anda dapat diproses? Konsultasikan terlebih dahulu dengan DJM.</strong></p>
<!-- SVC_DOKUMEN_END -->
HTML,
                'sort_order' => 2,
            ],

            // Pecah Sertifikat
            [
                'name' => 'Pecah Sertifikat',
                'slug' => 'pecah-sertifikat',
                'category' => 'perizinan',
                'icon' => 'fa-file-invoice',
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&h=600&fit=crop&q=80',
                'short_description' => 'Pemecahan sertifikat tanah sesuai kebutuhan legal dan peruntukan lahan.',
                'seo_title' => 'Jasa Pemecahan Sertifikat Tanah Yogyakarta | DJM Property',
                'seo_description' => 'DJM membantu pemecahan sertifikat tanah di Yogyakarta. Konsultasi, persiapan dokumen, pengukuran, hingga pendampingan proses.',
                'description' => <<<'HTML'
<h2>Kapan Pemecahan Sertifikat Dibutuhkan?</h2>
<p>Pemecahan sertifikat dapat dibutuhkan untuk berbagai keperluan, seperti:</p>
<ul>
<li>Membagi tanah menjadi beberapa bidang.</li>
<li>Pembagian tanah untuk keluarga atau ahli waris.</li>
<li>Persiapan penjualan sebagian bidang tanah.</li>
<li>Pembagian lahan untuk kebutuhan pembangunan.</li>
<li>Penataan kepemilikan beberapa bidang tanah.</li>
</ul>

<h2>Layanan yang Kami Bantu</h2>

<h3>Konsultasi Awal</h3>
<p>Kami memahami kebutuhan pemecahan dan kondisi bidang tanah Anda.</p>

<h3>Pemeriksaan Dokumen</h3>
<p>Dokumen kepemilikan dan dokumen pendukung diperiksa untuk mengetahui kelengkapan administrasi.</p>

<h3>Persiapan Data dan Dokumen</h3>
<p>Membantu mempersiapkan kebutuhan administrasi dan data yang diperlukan untuk proses pemecahan.</p>

<h3>Pendampingan Proses</h3>
<p>Memberikan arahan dan pendampingan selama proses administrasi sesuai prosedur yang berlaku.</p>

<h3>Pengukuran dan Penataan Bidang</h3>
<p>Apabila diperlukan, proses pengukuran dan penataan bidang disesuaikan dengan kebutuhan serta ketentuan yang berlaku.</p>

<!-- SVC_ALUR_START -->
<h2>Alur Layanan</h2>
<ul>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Konsultasi</strong> — Jelaskan kebutuhan pemecahan sertifikat dan kondisi tanah Anda.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pemeriksaan Sertifikat</strong> — Kami membantu mengecek dokumen dan informasi bidang tanah.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Persiapan Dokumen</strong> — Dokumen administrasi dan data pendukung dipersiapkan.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pengukuran / Proses Teknis</strong> — Apabila diperlukan, dilakukan proses teknis sesuai ketentuan.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Pengurusan Administrasi</strong> — Proses dilanjutkan sesuai prosedur dan instansi yang berwenang.</div></li>
<li class="svc-alur-item"><span class="svc-alur-num"></span><div class="svc-alur-content"><strong>Penyelesaian</strong> — Proses pemecahan dilanjutkan hingga tahapan penyelesaian sesuai ketentuan.</div></li>
</ul>
<!-- SVC_ALUR_END -->

<!-- SVC_DOKUMEN_START -->
<h2>Dokumen yang Umumnya Dibutuhkan</h2>
<p>Persyaratan dapat berbeda sesuai kondisi tanah. Beberapa dokumen yang umumnya diperlukan antara lain:</p>
<ul>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-id-card"></i></span><span class="svc-dok-text">KTP pemilik</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-contract"></i></span><span class="svc-dok-text">Sertifikat tanah</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span><span class="svc-dok-text">SPPT PBB</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-folder-open"></i></span><span class="svc-dok-text">Dokumen pendukung kepemilikan</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-signature"></i></span><span class="svc-dok-text">Surat kuasa apabila dikuasakan</span></li>
<li class="svc-dok-item"><span class="svc-dok-icon"><i class="fa-solid fa-file-circle-check"></i></span><span class="svc-dok-text">Dokumen atau data pendukung lainnya sesuai kebutuhan</span></li>
</ul>
<p><strong>Tidak yakin sertifikat Anda bisa dipecah? Sampaikan kondisi tanah dan kebutuhan Anda kepada DJM. Kami membantu menjelaskan tahapan dan dokumen yang perlu dipersiapkan.</strong></p>
<!-- SVC_DOKUMEN_END -->
HTML,
                'sort_order' => 3,
            ],

            // ── Kategori: Konstruksi ─────────────────────────────────────────────

            ['name' => 'Pembangunan',            'slug' => 'pembangunan',           'category' => 'konstruksi', 'icon' => 'fa-building-construction', 'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop&q=80', 'short_description' => 'Jasa pembangunan bangunan dari fondasi hingga selesai oleh tim berpengalaman.', 'sort_order' => 4],
            ['name' => 'Renovasi',               'slug' => 'renovasi',              'category' => 'konstruksi', 'icon' => 'fa-hammer',            'image' => 'https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?w=800&h=600&fit=crop&q=80', 'short_description' => 'Renovasi dan perbaikan bangunan untuk meningkatkan kenyamanan dan nilai properti.', 'sort_order' => 5],
            ['name' => 'Jasa Konstruksi',        'slug' => 'jasa-konstruksi',       'category' => 'konstruksi', 'icon' => 'fa-helmet-safety',     'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&h=600&fit=crop&q=80', 'short_description' => 'Layanan konstruksi umum untuk kebutuhan pembangunan Anda.', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], array_merge($service, ['is_active' => true]));
        }

        // Hapus layanan lama yang tidak lagi sesuai daftar layanan asli DJM
        $activeSlugs = collect($services)->pluck('slug')->all();
        Service::whereNotIn('slug', $activeSlugs)->delete();
    }
}

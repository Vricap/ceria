# PRD — Website DJM (Desty Jaya Mandiri)

**Versi:** 1.1  
**Platform:** Web Responsive  
**Nama Produk:** DJM — Desty Jaya Mandiri  
**Jenis:** Company Profile, Digital Catalog & Lead Generation  
**Target Area:** Yogyakarta dan sekitarnya  
**Teknologi:** Laravel 12 + Blade + Tailwind CSS + SQLite

---

# 1. Product Overview

DJM (Desty Jaya Mandiri) adalah perusahaan yang menyediakan layanan dalam bidang:

1. Perizinan
2. Property
3. Konstruksi

Website DJM berfungsi sebagai **company profile dan katalog digital** untuk memperkenalkan perusahaan, menampilkan layanan, menampilkan property yang tersedia, menampilkan portfolio, dan mengarahkan calon pelanggan untuk melakukan konsultasi melalui WhatsApp.

Website **tidak melakukan transaksi jual beli atau sewa property secara langsung**.

Seluruh komunikasi, negosiasi, konsultasi, dan transaksi dilakukan di luar website, terutama melalui WhatsApp.

### Model Bisnis Website

```text
Pengunjung
    ↓
Website DJM
    ↓
Melihat Layanan / Property / Portfolio
    ↓
Melihat Detail
    ↓
Tertarik
    ↓
Hubungi DJM via WhatsApp
    ↓
Konsultasi / Negosiasi
    ↓
Transaksi di luar Website
```

---

# 2. Tujuan Produk

## 2.1 Business Goals

1. Meningkatkan kredibilitas DJM secara digital.
2. Memperkenalkan layanan perizinan dan konstruksi.
3. Menampilkan katalog property yang dijual atau disewakan.
4. Menampilkan portfolio pekerjaan DJM.
5. Menghasilkan calon pelanggan melalui WhatsApp.
6. Memudahkan admin memperbarui informasi website.
7. Meningkatkan visibilitas DJM di search engine.

## 2.2 User Goals

Pengunjung harus dapat:

```text
Explore
   ↓
Find Service / Property
   ↓
View Detail
   ↓
Contact DJM
```

Proses harus sederhana dan tidak membutuhkan login.

---

# 3. Target User

## 3.1 Calon Pelanggan Perizinan

Pengguna yang membutuhkan layanan:

- PBG / IMB
- Pengeringan
- Pecah Sertifikat
- Layanan perizinan lain sesuai layanan resmi DJM

## 3.2 Calon Pembeli / Penyewa Property

Pengguna yang mencari:

- Rumah
- Tanah
- Ruko
- Villa
- Property lain yang ditawarkan DJM

## 3.3 Calon Pelanggan Konstruksi

Pengguna yang membutuhkan:

- Pembangunan
- Renovasi
- Jasa konstruksi
- Layanan konstruksi lain sesuai layanan resmi DJM

## 3.4 Admin DJM

Admin bertugas mengelola:

- Property
- Layanan
- Portfolio
- Kategori
- Informasi perusahaan
- Informasi kontak
- Konten website

---

# 4. Konsep Utama Website

Website memiliki tiga jenis konten utama.

## 4.1 Services

Menjawab pertanyaan:

> **"DJM dapat membantu apa?"**

Contoh:

```text
Layanan
├── Perizinan
│   ├── PBG / IMB
│   ├── Pengeringan
│   └── Pecah Sertifikat
│
└── Konstruksi
    ├── Pembangunan
    ├── Renovasi
    └── Layanan lainnya
```

## 4.2 Property

Menjawab pertanyaan:

> **"Property apa yang tersedia?"**

Property merupakan **katalog**, bukan transaksi online.

```text
Property
├── Semua
├── Dijual
└── Disewakan
```

## 4.3 Portfolio

Menjawab pertanyaan:

> **"Apa yang sudah pernah dikerjakan DJM?"**

Portfolio dapat berisi pekerjaan:

- Perizinan
- Konstruksi
- Property
- Pekerjaan lainnya

---

# 5. Scope Sistem

## 5.1 Public Website

```text
HOME
│
├── TENTANG KAMI
│
├── LAYANAN
│   ├── Perizinan
│   │   ├── PBG / IMB
│   │   ├── Pengeringan
│   │   └── Pecah Sertifikat
│   │
│   └── Konstruksi
│       ├── Pembangunan
│       ├── Renovasi
│       └── ...
│
├── PROPERTY
│   ├── Semua
│   ├── Dijual
│   └── Disewakan
│
├── PORTFOLIO
│
└── KONTAK
```

## 5.2 Admin Panel

```text
ADMIN
│
├── Login
│
├── Dashboard
│
├── Property
│
├── Services
│
├── Portfolio
│
├── Categories
│
└── Settings
```

---

# 6. Homepage

Homepage menjadi halaman utama untuk memperkenalkan DJM dan mengarahkan pengguna menuju layanan, property, dan kontak.

## 6.1 Navbar

Menu utama:

```text
Logo DJM

Home
Tentang Kami
Layanan
Property
Portfolio
Kontak

[WhatsApp]
```

Navbar wajib responsive.

## 6.2 Hero Section

Menampilkan:

- Headline
- Subheadline
- Background/hero image
- CTA

Contoh:

> **Solusi Properti, Perizinan & Konstruksi Terpercaya**

> Membantu memenuhi kebutuhan properti, perizinan, dan konstruksi Anda.

CTA:

```text
[Lihat Layanan]
[Lihat Property]
```

CTA dapat diarahkan ke WhatsApp jika konteksnya membutuhkan konsultasi.

## 6.3 Service Highlight

Menampilkan tiga bidang utama:

```text
Perizinan
Property
Konstruksi
```

Masing-masing memiliki tombol untuk melihat detail.

## 6.4 Property Highlight

Menampilkan beberapa property terbaru/unggulan.

Contoh:

```text
Property Terbaru

[Property 1] [Property 2] [Property 3]

[Lihat Semua Property]
```

## 6.5 Portfolio Highlight

Menampilkan beberapa portfolio terbaru.

## 6.6 CTA WhatsApp

Bagian khusus untuk mengarahkan calon pelanggan menghubungi DJM.

---

# 7. Tentang Kami

URL:

```text
/about
```

Menampilkan:

- Profil DJM
- Visi dan misi jika tersedia
- Nilai/keunggulan perusahaan
- Pengalaman
- Area layanan
- Informasi pendukung lainnya

Konten faktual harus diberikan atau disetujui oleh client.

---

# 8. Services / Layanan

URL:

```text
/services
```

Services merupakan layanan yang benar-benar dikerjakan oleh DJM.

## 8.1 Kategori Perizinan

Contoh berdasarkan brief client:

- PBG / IMB
- Pengeringan
- Pecah Sertifikat

Setiap service memiliki:

- Gambar
- Nama layanan
- Deskripsi singkat
- Tombol detail
- CTA WhatsApp

## 8.2 Kategori Konstruksi

Daftar final harus dikonfirmasi kepada client.

Contoh:

- Pembangunan
- Renovasi
- Jasa konstruksi
- Layanan lainnya

**Developer tidak boleh menganggap semua contoh tersebut sebagai layanan resmi sebelum disetujui client.**

---

# 9. Service Detail

URL:

```text
/services/{category}/{slug}
```

Contoh:

```text
/services/perizinan/pbg-imb
/services/perizinan/pengeringan
/services/perizinan/pecah-sertifikat
/services/konstruksi/pembangunan
```

Menampilkan:

- Hero image
- Nama layanan
- Deskripsi
- Ruang lingkup layanan
- Persyaratan jika tersedia
- Proses layanan jika tersedia
- Informasi tambahan
- CTA WhatsApp

### CTA

```text
[Konsultasikan via WhatsApp]
```

Contoh pesan otomatis:

> Halo DJM, saya ingin berkonsultasi mengenai layanan PBG / IMB.

---

# 10. Property

URL:

```text
/property
```

Property merupakan **katalog digital**.

Website hanya menampilkan informasi property dan menghubungkan calon pelanggan dengan DJM.

### Tidak ada:

- Checkout
- Keranjang
- Pembayaran
- Booking payment
- Transaksi online

## 10.1 Kategori Property

Minimal:

```text
Dijual
Disewakan
```

Jenis property dapat mencakup:

- Rumah
- Tanah
- Ruko
- Villa
- Apartemen
- Lainnya

Jenis final disesuaikan dengan data DJM.

---

# 11. Property Listing

Halaman:

```text
/property
```

Setiap property card menampilkan:

```text
Foto
Status
Judul
Lokasi
Harga
Jenis Property
Luas Tanah
Luas Bangunan
```

Contoh:

```text
┌──────────────────────────────┐
│            FOTO              │
│                              │
│ DIJUAL                       │
│ Rumah Minimalis Sleman       │
│ Sleman, Yogyakarta            │
│ Rp750.000.000                │
│ LT 120 m² · LB 90 m²         │
│                              │
│ [Lihat Detail]               │
└──────────────────────────────┘
```

---

# 12. Property Filter

Filter dibuat sederhana agar sesuai dengan kebutuhan MVP.

### Filter Status

```text
Semua
Dijual
Disewakan
```

### Filter Jenis

```text
Rumah
Tanah
Ruko
Villa
Apartemen
Lainnya
```

### Filter Harga

- Harga minimum
- Harga maksimum

### Filter Lokasi

- Kota/Kabupaten
- Kecamatan jika data tersedia

Tidak diperlukan filter kompleks pada MVP kecuali jumlah property nantinya berkembang secara signifikan.

---

# 13. Property Detail

URL:

```text
/property/{slug}
```

Contoh:

```text
/property/rumah-minimalis-sleman
```

Menampilkan:

- Gallery
- Foto utama
- Judul
- Harga
- Status
- Lokasi
- Jenis property
- Luas tanah
- Luas bangunan
- Kamar tidur jika tersedia
- Kamar mandi jika tersedia
- Fasilitas
- Deskripsi
- Informasi tambahan

## CTA Utama

```text
[💬 Tanyakan via WhatsApp]
```

Ketika diklik, WhatsApp membuka chat dengan pesan otomatis.

Contoh:

> Halo DJM, saya tertarik dengan property **Rumah Minimalis Sleman** dengan harga Rp750.000.000. Saya ingin mendapatkan informasi lebih lanjut.

---

# 14. Alur Property

```text
Pengunjung
    ↓
Property
    ↓
Filter / Cari
    ↓
Pilih Property
    ↓
Detail Property
    ↓
Tanyakan via WhatsApp
    ↓
Chat dengan DJM
    ↓
Negosiasi / Konsultasi
    ↓
Transaksi di luar Website
```

### Status Property

Admin dapat menggunakan:

```text
Draft
Published
Sold
Rented
Archived
```

Alur:

```text
Draft
  ↓
Published
  ↓
Ada calon pembeli/penyewa
  ↓
Komunikasi melalui WhatsApp
  ↓
Transaksi di luar website
  ↓
Admin mengubah status
  ↓
Sold / Rented
```

---

# 15. Portfolio

URL:

```text
/portfolio
```

Portfolio merupakan dokumentasi pekerjaan atau proyek yang pernah dilakukan DJM.

Kategori:

- Perizinan
- Konstruksi
- Property
- Lainnya

Portfolio card:

```text
Foto
Judul
Kategori
Lokasi
Tahun
```

Detail:

```text
/portfolio/{slug}
```

Menampilkan:

- Gallery
- Judul
- Kategori
- Lokasi
- Tahun
- Deskripsi
- Informasi pekerjaan

---

# 16. Contact

URL:

```text
/contact
```

Menampilkan:

- Alamat
- WhatsApp
- Nomor telepon
- Email
- Jam operasional
- Google Maps
- Social media

Data kontak menggunakan placeholder sampai client memberikan data final.

---

# 17. WhatsApp Integration

WhatsApp merupakan **kanal konversi utama** website.

Implementasi MVP menggunakan link WhatsApp:

```text
https://wa.me/{nomor}
```

Tidak menggunakan WhatsApp Business API pada MVP.

## WhatsApp CTA ditempatkan pada:

- Navbar
- Homepage
- Service Detail
- Property Detail
- Contact
- Portfolio jika relevan

### Property-specific message

Pesan dapat dibuat otomatis berdasarkan property:

```text
Halo DJM, saya tertarik dengan property:
[Nama Property]

Harga:
[Harga]

Saya ingin mendapatkan informasi lebih lanjut.
```

### Service-specific message

```text
Halo DJM, saya ingin berkonsultasi mengenai:
[Nama Layanan]
```

---

# 18. Admin Authentication

Public user:

> **Tidak perlu login.**

Pengunjung dapat melihat seluruh informasi tanpa membuat akun.

Admin:

```text
/admin/login
```

Setelah login:

```text
/admin
```

Admin login digunakan untuk mengelola konten website.

---

# 19. Admin Dashboard

Dashboard menampilkan ringkasan:

```text
Total Property
Property Aktif
Property Terjual
Property Disewakan
Total Services
Total Portfolio
```

Dashboard tidak membutuhkan analytics kompleks pada MVP.

---

# 20. Property Management

Admin dapat:

- Melihat property
- Menambah property
- Mengedit property
- Menghapus property
- Upload banyak foto
- Menentukan foto utama
- Mengatur harga
- Mengatur status
- Mengatur tipe transaksi
- Mengatur lokasi
- Menentukan property unggulan
- Publish/unpublish

### Property Form

Minimal:

```text
Judul
Slug
Kategori
Status Transaksi
Jenis Property
Harga
Lokasi
Deskripsi
Luas Tanah
Luas Bangunan
Kamar Tidur
Kamar Mandi
Fasilitas
Status Publikasi
Featured
Gallery
```

Field yang tidak relevan boleh kosong.

---

# 21. Service Management

Admin dapat:

- Tambah service
- Edit service
- Hapus service
- Upload gambar
- Mengatur kategori
- Mengatur deskripsi
- Mengatur slug
- Publish/unpublish

Kategori utama:

```text
Perizinan
Konstruksi
```

Property tidak dimasukkan sebagai service karena memiliki katalog dan alur pengelolaan sendiri.

---

# 22. Portfolio Management

Admin dapat:

- Tambah portfolio
- Edit portfolio
- Hapus portfolio
- Upload beberapa foto
- Mengatur kategori
- Mengatur lokasi
- Mengatur tahun
- Publish/unpublish

---

# 23. Category Management

Admin dapat mengelola kategori jika dibutuhkan.

Contoh:

```text
Service Category
├── Perizinan
└── Konstruksi

Property Category
├── Rumah
├── Tanah
├── Ruko
└── Lainnya

Property Transaction
├── Dijual
└── Disewakan

Portfolio Category
├── Perizinan
├── Konstruksi
└── Property
```

---

# 24. Website Settings

Admin dapat mengubah:

```text
Nama perusahaan
Logo
Favicon
WhatsApp
Nomor telepon
Email
Alamat
Google Maps
Instagram
Facebook
Jam operasional
```

Tujuannya agar informasi kontak tidak perlu diubah melalui source code.

---

# 25. Database

Database menggunakan:

> **SQLite**

### Tabel utama

```text
users
service_categories
services
property_categories
properties
property_images
portfolio_categories
portfolios
portfolio_images
settings
```

### Properties

```text
id
property_category_id
title
slug
description
price
transaction_type
property_type
location
land_area
building_area
bedrooms
bathrooms
facilities
status
featured
published_at
created_at
updated_at
```

### Property Images

```text
id
property_id
image
alt_text
sort_order
is_primary
created_at
updated_at
```

### Services

```text
id
service_category_id
title
slug
short_description
description
image
status
published_at
created_at
updated_at
```

### Portfolios

```text
id
portfolio_category_id
title
slug
description
location
year
status
published_at
created_at
updated_at
```

---

# 26. SEO

SEO dasar wajib diterapkan.

Setiap halaman penting memiliki:

```text
Title
Meta Description
Slug
Open Graph Image
Canonical URL
Alt Text
```

Contoh property:

```text
/property/rumah-minimalis-sleman
```

Contoh service:

```text
/services/perizinan/pbg-imb
```

SEO advanced campaign bukan bagian dari MVP.

---

# 27. Design System

## 27.1 Design Direction

Karakter visual:

- Soft
- Modern
- Professional
- Trustworthy
- Clean
- Tidak terlalu ramai

## 27.2 Font

Rekomendasi:

**Plus Jakarta Sans**

Alternatif:

**Inter**

## 27.3 Color

Arah warna:

```text
Primary
Soft Blue / Blue Gray

Secondary
Warm Beige

Background
Off White

Text
Dark Gray

Accent
Soft Green / Blue
```

Palet final ditentukan pada tahap UI/UX.

---

# 28. Logo

Logo:

> **DJM — Desty Jaya Mandiri**

Deliverables:

- Logo utama
- Versi horizontal
- Versi icon jika diperlukan
- Warna utama
- File digital untuk website

Jumlah revisi mengikuti kesepakatan proyek.

---

# 29. Content Management

Konten yang dikelola:

- Homepage
- About
- Services
- Property
- Portfolio
- Contact

Konten faktual harus berasal dari atau disetujui client.

Developer/designer dapat membuat draft copy, tetapi tidak boleh mengarang klaim mengenai:

- Legalitas
- Pengalaman
- Jumlah proyek
- Sertifikasi
- Keahlian
- Alamat
- Kontak
- Layanan resmi

---

# 30. Security

Minimal:

- Admin authentication
- Password hashing
- Authorization
- CSRF protection
- Request validation
- Upload validation
- File type validation
- File size validation
- SQL injection prevention
- XSS protection
- HTTPS pada production

---

# 31. Technology Stack

## Backend

**Laravel 12**

## Frontend

**Blade + Tailwind CSS**

## Database

**SQLite**

## Development Environment

**Laragon**

## Production

Hosting/server client sesuai spesifikasi yang disepakati.

## Storage

Local/server storage untuk MVP.

## Communication

**WhatsApp Link / wa.me** sebagai kanal utama inquiry.

## Architecture

Server-rendered application menggunakan Laravel Blade.

Tidak menggunakan frontend framework terpisah seperti React, Vue, atau Next.js.

# 32. MVP — Wajib

## Public Website

- [x] Home
- [x] About
- [x] Services
- [x] Service Detail
- [x] Property Listing
- [x] Property Filter Dasar
- [x] Property Detail
- [x] Portfolio
- [x] Portfolio Detail
- [x] Contact
- [x] WhatsApp CTA
- [x] Responsive Design
- [x] Basic SEO

## Admin

- [x] Admin Login
- [x] Dashboard
- [x] Property CRUD
- [x] Property Image Management
- [x] Service CRUD
- [x] Portfolio CRUD
- [x] Category Management
- [x] Website Settings

---

# 33. Tidak Termasuk MVP

Fitur berikut tidak termasuk dalam scope awal:

- [ ] Customer login
- [ ] Customer registration
- [ ] Checkout
- [ ] Payment gateway
- [ ] Booking online
- [ ] Transaksi jual beli online
- [ ] Transaksi sewa online
- [ ] Keranjang
- [ ] Favorite property
- [ ] Compare property
- [ ] Agent dashboard
- [ ] Owner dashboard
- [ ] Marketplace multi-vendor
- [ ] CRM kompleks
- [ ] WhatsApp Business API
- [ ] Email automation
- [ ] Mobile application
- [ ] Integrasi sistem pemerintah
- [ ] Integrasi pihak ketiga berbayar
- [ ] Advanced analytics
- [ ] Advanced SEO campaign
- [ ] Pembuatan konten tanpa batas
- [ ] Revisi desain tanpa batas
- [ ] Maintenance tanpa batas

---

# 34. Future Development

Jika kebutuhan bisnis berkembang, sistem dapat dikembangkan.

## Phase 2

- Blog
- Inquiry management
- Customer database
- Analytics
- Favorite property
- Compare property
- Advanced SEO
- Lead management

## Phase 3

Jika DJM ingin menjadi marketplace:

```text
Owner
 ↓
Submit Property
 ↓
Admin Verification
 ↓
Published
 ↓
Visitor
 ↓
Inquiry
 ↓
Follow Up
```

Fitur marketplace dan transaksi online harus menjadi proyek/phase terpisah.

---

# 35. Acceptance Criteria

## Website

Pengunjung dapat membuka website tanpa login dan melihat informasi DJM.

## Services

Pengunjung dapat:

```text
Services
 ↓
Kategori
 ↓
Service Detail
 ↓
WhatsApp
```

## Property

Pengunjung dapat:

```text
Property
 ↓
Filter
 ↓
Property Detail
 ↓
WhatsApp
```

Tidak ada transaksi atau pembayaran di website.

## Property Status

Admin dapat mengubah status property:

```text
Draft
Published
Sold
Rented
Archived
```

## Admin Property

Admin dapat:

```text
Create
 ↓
Upload Image
 ↓
Input Information
 ↓
Publish
 ↓
Property tampil di website
```

## Portfolio

Admin dapat membuat portfolio dan menampilkannya di website.

## Contact

Admin dapat memperbarui informasi kontak tanpa mengubah source code.

## Responsive

Website dapat digunakan dengan baik pada:

- Desktop
- Laptop
- Tablet
- Mobile

---

# 36. User Flow

```text
                         HOME
                           │
          ┌────────────────┼────────────────┐
          ↓                ↓                ↓
       LAYANAN          PROPERTY         PORTFOLIO
          │                │                │
          ↓                ↓                ↓
   SERVICE DETAIL    PROPERTY DETAIL   PORTFOLIO DETAIL
          │                │
          └────────────────┤
                           ↓
                      WHATSAPP DJM
                           ↓
                    Konsultasi / Inquiry
                           ↓
                  Negosiasi / Transaksi
                           ↓
                    DI LUAR WEBSITE
```

---

# 37. Admin Flow

```text
/admin/login
      ↓
  Dashboard
      │
 ┌────┼──────────┬──────────┐
 ↓    ↓          ↓          ↓
Property Service Portfolio Settings
 ↓
CRUD
 ↓
Publish
 ↓
Public Website
```

---

# 38. Scope Boundary

Untuk mencegah scope creep, prinsip berikut berlaku:

1. Website bukan marketplace.
2. Tidak ada transaksi online.
3. WhatsApp menjadi kanal utama inquiry.
4. Public user tidak membutuhkan akun.
5. Admin menjadi satu-satunya pihak yang mengubah konten website.
6. Property hanya berfungsi sebagai katalog.
7. Layanan hanya menampilkan jasa yang benar-benar disetujui client.
8. Portfolio hanya menampilkan pekerjaan yang disetujui client.
9. Fitur tambahan di luar MVP harus melalui kesepakatan dan estimasi ulang.
10. Integrasi eksternal berbayar tidak termasuk kecuali disepakati.

---

# 39. Project Positioning

Website DJM diposisikan sebagai:

> **Company Profile + Digital Catalog + Lead Generation Website**

untuk bidang:

> **Perizinan + Property + Konstruksi**

Fungsi utama website:

```text
INFORMASI
   ↓
KATALOG
   ↓
DETAIL
   ↓
INTEREST
   ↓
WHATSAPP
   ↓
KONSULTASI
   ↓
TRANSAKSI DI LUAR WEBSITE
```

Website tidak berfungsi sebagai platform transaksi online.

---

# 40. Prioritas Pengembangan

Prioritas proyek:

### P0 — Critical

- Homepage
- Services
- Property Catalog
- Property Detail
- WhatsApp
- Admin Login
- Admin Property CRUD
- Admin Service CRUD
- Responsive Design

### P1 — Important

- About
- Portfolio
- Contact
- Property Filter
- Website Settings
- Basic SEO

### P2 — Optional / Future

- Blog
- Analytics
- Inquiry management
- Favorite
- Compare
- Advanced SEO
- Marketplace features
- Customer account
- Transaction system

---

# 41. Final Product Definition

Pada versi MVP, DJM adalah:

> **Website company profile dan katalog digital yang membantu calon pelanggan menemukan layanan perizinan dan konstruksi serta melihat property yang dijual atau disewakan, kemudian menghubungkan mereka dengan DJM melalui WhatsApp.**

Tidak ada proses pembelian, pembayaran, atau transaksi langsung di dalam website.

**Alur utama produk:**

```text
VISITOR
   ↓
DISCOVER DJM
   ↓
VIEW SERVICES / PROPERTY
   ↓
VIEW DETAIL
   ↓
CONTACT VIA WHATSAPP
   ↓
CONSULTATION
   ↓
NEGOTIATION
   ↓
TRANSACTION OUTSIDE WEBSITE
```

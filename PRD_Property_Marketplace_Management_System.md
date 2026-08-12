# PRD — Property Marketplace & Management System

**Versi:** 1.0  
**Platform:** Web Responsive  
**Target:** Indonesia, tahap awal Yogyakarta  
**Tipe:** Property Listing & Real Estate Management Platform

---

## 1. Product Overview

Sistem merupakan platform digital properti yang memungkinkan pengguna untuk:

- mencari properti berdasarkan lokasi, kategori, harga, dan tipe;
- melihat detail properti;
- melihat foto/video properti;
- menghubungi agen/pengelola;
- mengajukan minat terhadap properti;
- melihat artikel/informasi properti;
- menemukan properti berdasarkan kota/area;
- mengakses layanan properti.

Di sisi internal, administrator dapat mengelola:

- data properti;
- kategori properti;
- lokasi;
- agen;
- pemilik/developer;
- inquiry dari calon pembeli;
- artikel;
- layanan;
- konten homepage.

---

## 2. Tujuan Produk

### Business Goals

1. Menjadi media pemasaran properti secara digital.
2. Mempermudah calon pembeli menemukan properti.
3. Meningkatkan jumlah inquiry/leads.
4. Menampilkan informasi properti secara profesional.
5. Memusatkan pengelolaan listing properti dalam satu sistem.
6. Meningkatkan visibilitas properti melalui SEO.

### User Goals

Pengguna dapat melakukan:

> **Search → Filter → Explore → View Detail → Contact Agent**

dengan sesedikit mungkin langkah.

---

## 3. Target User

### 3.1 Visitor / Buyer

Pengunjung yang ingin:

- membeli rumah;
- membeli tanah;
- menyewa properti;
- mencari apartemen;
- mencari properti komersial;
- mencari investasi properti.

### 3.2 Property Agent

Agen yang:

- memasukkan listing;
- mengelola listing;
- menerima inquiry;
- mengelola profil.

### 3.3 Property Owner / Developer

Pemilik/developer yang ingin memasarkan properti.

### 3.4 Administrator

Pengelola seluruh platform.

---

## 4. Struktur Sistem

```text
PUBLIC WEBSITE
│
├── Home
├── Properties
│   ├── Property Listing
│   ├── Search
│   ├── Filter
│   └── Property Detail
│
├── Categories
│   ├── Residential
│   ├── Commercial
│   ├── Apartment
│   ├── Land
│   ├── Luxury Villa
│   └── Office
│
├── Locations
│   ├── City
│   └── Area
│
├── Agents
│   └── Agent Detail
│
├── Services
├── Blog
├── About
└── Contact

ADMIN PANEL
│
├── Dashboard
├── Properties
├── Categories
├── Locations
├── Agents
├── Users
├── Leads / Inquiry
├── Blog
├── Services
├── Homepage
├── Media
└── Settings
```

---

# 5. Homepage

Homepage mengikuti struktur desain referensi.

## 5.1 Header

Menu:

- Home
- About
- Properties
- Services
- Pages
- Blog

CTA:

**Get in Touch**

Header harus:

- responsive;
- sticky saat scroll;
- memiliki mobile navigation;
- logo dapat dikonfigurasi melalui admin.

---

## 5.2 Hero Section

Headline:

> **Find Your Dream Property, Easy & Fast**

Subtitle:

> Discover verified properties, luxury homes, and great investment opportunities all in one place.

### Search Component

Input:

- Location
- Property Type
- Purpose
- Keyword

Property Type:

- Residential
- Commercial
- Apartment
- Land
- Villa
- Office

Purpose:

- Buy
- Rent

Button:

**Search**

Contoh URL hasil pencarian:

```text
/search?location=sleman&type=residential&purpose=buy
```

---

# 6. Browse by Category

Kategori awal:

| Category | Contoh |
|---|---|
| Residential | Rumah |
| Commercial | Ruko / Commercial |
| Apartment | Apartemen |
| Land | Tanah |
| Luxury Villa | Villa |
| Office Space | Kantor |

Setiap kategori memiliki:

- icon;
- nama;
- jumlah listing;
- link menuju listing.

---

# 7. About / Company Introduction

Section:

> **Your Trusted Partner in Property Investment & Management**

Konten:

- deskripsi perusahaan;
- pengalaman;
- keunggulan;
- jumlah property;
- jumlah client;
- jumlah agent.

CTA:

**Explore More**

---

# 8. Featured Properties

Menampilkan properti pilihan.

Property card minimal berisi:

- thumbnail;
- status;
- title;
- lokasi;
- harga;
- tipe;
- luas tanah;
- luas bangunan;
- kamar tidur;
- kamar mandi.

Contoh:

```text
[IMAGE]

For Sale

Modern Family Home

Rp 2.500.000.000

Sleman, Yogyakarta

4 Beds · 3 Baths · 180 m²
```

CTA:

**View Property**

---

# 9. Property Listing Page

URL:

```text
/properti
```

### Layout

```text
FILTER                    PROPERTY
────────────────────────────────────

Location                  Property Card
Property Type             Property Card
Purpose                   Property Card
Price                     Property Card
Bedrooms                  Property Card
Bathrooms                 Property Card
Land Area                 Property Card
Building Area             Property Card

[Apply Filter]
```

### Sorting

- Terbaru
- Harga Terendah
- Harga Tertinggi
- Paling Populer

### Pagination

```text
Previous 1 2 3 4 5 Next
```

---

# 10. Filter Properti

## Location

- Province
- City
- District
- Area

Tahap awal:

```text
DI Yogyakarta
├── Kota Yogyakarta
├── Sleman
├── Bantul
├── Kulon Progo
└── Gunungkidul
```

## Property Type

- Rumah
- Tanah
- Apartemen
- Villa
- Ruko
- Gudang
- Kantor
- Hotel
- Commercial

## Transaction

- Dijual
- Disewa

## Price

- Min Price
- Max Price

## Property Size

- Land Area
- Building Area

## Bedrooms

- 1+
- 2+
- 3+
- 4+
- 5+

---

# 11. Property Detail

URL:

```text
/properti/{slug}
```

Contoh:

```text
/properti/rumah-modern-sleman-dekat-kampus
```

## Gallery

- Main image
- Multiple photos
- Fullscreen gallery

Opsional:

- Video
- Virtual tour

## Property Information

```text
Property Title
Price
Location
Property Type
Transaction Type
Property ID
```

## Specification

```text
Land Area
Building Area
Bedrooms
Bathrooms
Garage
Floors
Certificate
Year Built
```

---

# 12. Property Description

Menampilkan deskripsi lengkap properti.

Contoh:

> Rumah modern dengan lokasi strategis di Sleman, dekat kampus, pusat perbelanjaan, dan akses jalan utama.

---

# 13. Facilities

Contoh:

- Carport
- Garden
- Swimming Pool
- Security
- CCTV
- Electricity
- Water
- Internet

---

# 14. Location

Property detail memiliki:

- alamat;
- district;
- city;
- province;
- Google Maps;
- latitude;
- longitude.

> Untuk privasi pemilik, alamat lengkap tidak harus selalu ditampilkan secara publik.

---

# 15. Agent Information

Pada property detail:

```text
[PHOTO]

Agent Name
Property Agent

★★★★★

[WhatsApp]
[Contact Agent]
```

Informasi:

- nama;
- foto;
- jabatan;
- nomor kontak;
- WhatsApp;
- email;
- jumlah listing.

---

# 16. Inquiry / Lead System

User dapat mengirim:

```text
Nama
Email
No. WhatsApp
Property
Message
```

Button:

**Send Inquiry**

Admin/agent menerima:

```text
New Inquiry

Name:
Email:
WhatsApp:
Property:
Message:
Date:
Status:
```

Status:

- New
- Contacted
- Follow Up
- Qualified
- Closed
- Cancelled

---

# 17. WhatsApp Integration

Setelah inquiry, tersedia:

**Contact via WhatsApp**

Contoh pesan otomatis:

```text
Halo, saya tertarik dengan properti
Rumah Modern Sleman.

Saya ingin mendapatkan informasi
lebih lanjut mengenai properti tersebut.
```

Nomor WhatsApp berasal dari data agent/admin.

---

# 18. Explore Properties by City

Menampilkan properti berdasarkan kota/area:

```text
Yogyakarta
Sleman
Bantul
Kulon Progo
Gunungkidul
```

Setiap lokasi memiliki:

- cover image;
- jumlah property;
- link listing.

Contoh:

```text
Properties in Sleman
128 Properties
```

---

# 19. Agents

URL:

```text
/agen
```

Menampilkan:

- nama;
- foto;
- spesialisasi;
- lokasi;
- total listing;
- contact.

Agent detail:

```text
/agen/{slug}
```

Menampilkan semua properti milik agent tersebut.

---

# 20. Services

Layanan:

### Buy Property

Membantu menemukan dan membeli properti.

### Sell Property

Membantu pemilik memasarkan properti.

### Rent Property

Membantu pencarian properti sewa.

### Property Management

Pengelolaan properti.

### Property Investment

Konsultasi investasi properti.

### Property Consultation

Konsultasi kebutuhan properti.

---

# 21. Blog / News

URL:

```text
/blog
```

Kategori:

- Property Tips
- Investment
- Market News
- Legal
- Buying Guide
- Selling Guide
- Yogyakarta Property

Detail:

```text
/blog/{slug}
```

Data:

```text
Title
Slug
Thumbnail
Content
Category
Author
Published Date
SEO Title
SEO Description
```

---

# 22. SEO Requirements

Setiap property harus memiliki:

```text
Title
Slug
Meta Title
Meta Description
Canonical URL
OG Image
Structured Data
```

Contoh:

```text
https://domain.com/properti/rumah-modern-sleman
```

## SEO Landing Pages

Sistem sebaiknya mendukung:

```text
/properti/dijual/yogyakarta
/properti/dijual/sleman
/properti/dijual/bantul
/properti/disewa/yogyakarta
/properti/tanah/sleman
/properti/rumah/sleman
```

SEO tidak hanya bergantung pada domain. Struktur halaman dan kualitas konten listing harus menjadi prioritas.

---

# 23. Structured Data

Property detail menggunakan schema yang relevan, seperti:

- `RealEstateListing`;
- `Residence`;
- `BreadcrumbList`;
- `Article` untuk blog;
- `Organization`;
- `LocalBusiness`.

Tujuannya membantu search engine memahami struktur informasi website.

---

# 24. Admin Dashboard

Dashboard menampilkan:

```text
Total Properties       1,248
Active Listings          982
Agents                    35
New Leads                 128
```

Data tambahan:

- Property Views;
- Leads;
- Latest Properties;
- Latest Inquiries.

---

# 25. Property Management

Admin dapat:

- Create property;
- Read property;
- Update property;
- Delete property;
- Publish property;
- Save as draft;
- Archive property;
- Feature property.

---

# 26. Property Database

Minimal struktur:

```text
properties
├── id
├── title
├── slug
├── description
├── price
├── transaction_type
├── property_type_id
├── location_id
├── land_area
├── building_area
├── bedrooms
├── bathrooms
├── floors
├── certificate
├── year_built
├── latitude
├── longitude
├── status
├── agent_id
├── featured
├── published_at
├── created_at
└── updated_at
```

---

# 27. Property Images

```text
property_images
├── id
├── property_id
├── image_url
├── alt_text
├── sort_order
├── is_primary
└── created_at
```

Admin dapat:

- upload multiple images;
- menentukan cover;
- mengubah urutan;
- menghapus gambar.

---

# 28. User Roles

## Super Admin

Full access.

## Admin

Mengelola konten dan properti.

## Agent

Mengelola listing miliknya dan melihat inquiry terkait.

## Editor

Mengelola artikel.

## Visitor

Mengakses website publik dan mengirim inquiry.

---

# 29. Admin Permission

| Module | Super Admin | Admin | Agent | Editor |
|---|---:|---:|---:|---:|
| Properties | ✅ | ✅ | Own | ❌ |
| Agents | ✅ | ✅ | ❌ | ❌ |
| Users | ✅ | ❌ | ❌ | ❌ |
| Leads | ✅ | ✅ | Own | ❌ |
| Blog | ✅ | ✅ | ❌ | ✅ |
| Services | ✅ | ✅ | ❌ | ❌ |
| Homepage | ✅ | ✅ | ❌ | ❌ |
| Settings | ✅ | ❌ | ❌ | ❌ |

---

# 30. Homepage CMS

Homepage tidak boleh sepenuhnya hardcoded.

Admin dapat mengubah:

## Hero

- title;
- subtitle;
- background;
- CTA.

## Featured Property

Admin memilih property yang ditampilkan.

## Category

Admin dapat mengubah kategori.

## City

Admin memilih lokasi yang ditampilkan.

## Testimonials

CRUD testimonial.

## Blog

Memilih artikel yang tampil di homepage.

---

# 31. Testimonial

Data:

```text
Name
Photo
Position
Testimonial
Rating
Status
```

Homepage menampilkan carousel testimonial.

---

# 32. Contact

Contact page:

```text
Company Address
Phone
WhatsApp
Email
Office Hours
Google Maps
Social Media
```

Contact form:

```text
Name
Email
Phone
Subject
Message
```

---

# 33. Mobile Responsive

Website wajib mendukung:

- Desktop;
- Laptop;
- Tablet;
- Mobile.

Breakpoints:

```text
Desktop > 1200px
Tablet 768–1199px
Mobile < 768px
```

Pada mobile:

- hamburger menu;
- search menjadi vertical;
- property card menjadi satu kolom;
- sticky WhatsApp/contact button;
- gallery swipeable.

---

# 34. Performance

Target:

- image WebP/AVIF;
- lazy loading;
- responsive images;
- compression;
- caching;
- pagination;
- optimized database query.

Target awal:

**Google Lighthouse Performance ≥ 85**

---

# 35. Security

Minimal:

- authentication;
- authorization;
- password hashing;
- CSRF protection;
- XSS protection;
- SQL injection prevention;
- upload validation;
- file type validation;
- rate limiting;
- admin audit log;
- HTTPS.

---

# 36. Recommended Tech Stack

## Frontend

**Next.js**

Alasan:

- SEO;
- SSR/SSG;
- routing;
- image optimization;
- performa.

## Backend

**Laravel**

Cocok untuk:

- CRUD;
- authentication;
- CMS;
- admin;
- REST API.

Arsitektur:

```text
Next.js
    │
    │ REST API
    ▼
Laravel API
    │
    ▼
MySQL
```

## Storage

- Cloudflare R2;
- Amazon S3;
- S3-compatible storage.

## Maps

- Google Maps atau Mapbox.

## Authentication

- Laravel Sanctum / token-based authentication.

---

# 37. MVP — Wajib Dibangun

Jika waktu dan budget terbatas, jangan langsung membangun marketplace lengkap.

## Public Website

- Home;
- Property Listing;
- Search;
- Filter;
- Property Detail;
- Category;
- Location;
- Agent;
- Contact;
- Blog.

## Admin

- Login;
- Dashboard;
- Property CRUD;
- Category CRUD;
- Location CRUD;
- Agent CRUD;
- Inquiry;
- Blog CRUD;
- Homepage CMS.

## Integration

- WhatsApp;
- Google Maps;
- SEO;
- Image upload.

---

# 38. Phase 2

Setelah MVP berjalan:

- user registration;
- favorite property;
- compare property;
- property recommendation;
- saved search;
- email notification;
- WhatsApp notification;
- advanced analytics;
- agent dashboard;
- owner dashboard;
- property verification;
- property status tracking.

---

# 39. Phase 3

Untuk marketplace properti yang lebih besar:

```text
Owner
   ↓
Submit Property
   ↓
Admin Verification
   ↓
Agent Assignment
   ↓
Published
   ↓
Visitor
   ↓
Inquiry
   ↓
Agent Follow-up
   ↓
Deal
```

Fitur lanjutan:

- CRM;
- lead scoring;
- subscription agent;
- premium listing;
- featured listing berbayar;
- payment gateway;
- booking;
- digital document;
- commission tracking.

---

# 40. Property Status

Gunakan status:

```text
Draft
Pending Verification
Published
Featured
Sold
Rented
Expired
Archived
Rejected
```

Jangan hanya menggunakan `active/inactive`, karena status detail akan berguna ketika jumlah listing meningkat.

---

# 41. Acceptance Criteria

## Property

> Admin membuat property → upload foto → menentukan lokasi → memilih agent → publish → property muncul di website.

## Search

> User memasukkan lokasi + tipe + harga → sistem menampilkan property yang sesuai.

## Detail

> User membuka property → dapat melihat informasi, foto, lokasi, agent, dan menghubungi agent.

## Inquiry

> User mengirim inquiry → inquiry masuk ke dashboard → agent dapat mengubah statusnya.

## SEO

> Setiap property memiliki URL unik, metadata, canonical, sitemap, dan dapat di-index search engine.

## CMS

> Admin mengubah featured property → homepage otomatis berubah tanpa perubahan kode.

---

# 42. User Flow

```text
                  HOME
                    │
          ┌─────────┴─────────┐
          │                   │
       SEARCH             BROWSE
          │                   │
          └─────────┬─────────┘
                    ↓
             PROPERTY LIST
                    │
                    ↓
             PROPERTY DETAIL
                    │
          ┌─────────┴─────────┐
          ↓                   ↓
     CONTACT AGENT         WHATSAPP
          │
          ↓
        LEAD
          │
          ↓
       AGENT/ADMIN
```

---

# 43. Recommended URL Structure

Hindari:

```text
/property?id=123
```

Gunakan:

```text
/properti
/properti/rumah
/properti/tanah
/properti/dijual
/properti/disewa
/properti/dijual/sleman
/properti/dijual/bantul
/properti/rumah-dijual-sleman
```

Property detail:

```text
/properti/rumah-modern-sleman-dekat-kampus
```

Blog:

```text
/blog/tips-membeli-rumah-pertama
```

Agent:

```text
/agen/nama-agent
```

---

# 44. Development Priority

## P0 — Fondasi

1. Database
2. Authentication
3. Admin
4. Property CRUD
5. Image management
6. Location
7. Agent

## P1 — Public Platform

8. Homepage
9. Property listing
10. Search
11. Filter
12. Property detail
13. Agent detail
14. Contact/Inquiry
15. WhatsApp

## P2 — Growth

16. Blog
17. SEO
18. Sitemap
19. Schema
20. Analytics
21. Performance optimization

## P3 — Advanced

22. Favorites
23. Compare
24. User account
25. CRM
26. Premium listing
27. Payment
28. Recommendation

---

# 45. Kesimpulan

Desain referensi merupakan **front-end presentation layer**, sedangkan sistem sebenarnya membutuhkan:

- Property Listing;
- Search & Filter;
- Location;
- Agent;
- Inquiry/Lead;
- Admin CMS;
- SEO;
- Property Status;
- Image Management;
- WhatsApp;
- Google Maps.

Untuk MVP, fokus pada:

> **Property Listing + Admin CMS + Search/Filter + Property Detail + Inquiry + SEO**

Fitur seperti payment, favorite, CRM, subscription, dan marketplace penuh dapat dikembangkan setelah MVP memiliki traffic dan jumlah listing yang cukup.

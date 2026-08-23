<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DJM Property – Solusi Properti & Konstruksi di Yogyakarta')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logodjm1.png') }}">
    <meta name="description" content="@yield('meta_description', 'DJM Property menyediakan informasi dan layanan properti, konstruksi, serta jasa pendukung kebutuhan properti di Yogyakarta. Temukan properti dan solusi properti yang sesuai dengan kebutuhan Anda.')">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'DJM Property')">
    <meta property="og:description" content="@yield('meta_description', 'Platform properti terpercaya di Yogyakarta.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logodjm.png'))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DJM Property">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'DJM Property')">
    <meta name="twitter:description" content="@yield('meta_description', 'Platform properti terpercaya di Yogyakarta.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logodjm.png'))">

    {{-- Schema.org JSON-LD --}}
    @yield('schema')

    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "name": "DJM Property",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ route('properties.index') }}?keyword={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

    @php
        $orgName = \App\Support\Site::get('company_name', 'Desty Jaya Mandiri');
        $orgAddress = \App\Support\Site::get('contact_address', 'Jl. Kaliurang KM 7, Sleman, Yogyakarta');
        $orgPhone = \App\Support\Site::get('contact_phone', '+62 274 123456');
        $orgEmail = \App\Support\Site::get('contact_email', 'info@djmproperty.id');
    @endphp
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $orgName }}",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/logodjm.png') }}",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "{{ $orgAddress }}",
        "addressCountry": "ID"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "{{ $orgPhone }}",
        "contactType": "customer service",
        "availableLanguage": "Indonesian"
      },
      "email": "{{ $orgEmail }}"
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Locomotive Scroll CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css">

    <style>
        /* Locomotive Reveal Animations */
        html.has-scroll-init [data-scroll] {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        html.has-scroll-init [data-scroll].is-reveal {
            opacity: 1;
            transform: translateY(0);
        }

        body {
            padding-top: 0;
        }

        /* Base header styles */
        .site-header {
            background-color: var(--color-white);
            color: var(--color-noir);
            padding: 15px 0;
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--color-border);
            transition: background-color 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .site-header.header-transparent {
            background-color: transparent;
            box-shadow: none;
            border-bottom-color: transparent;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-noir);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo:hover {
            color: var(--color-gilded-dark);
        }

        .logo-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 56px;
            width: auto;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .logo-img--primary {
            opacity: 1;
        }

        .logo-img--secondary {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 1;
            pointer-events: none;
        }

        .site-header.is-scrolled .logo-img--primary {
            opacity: 1;
        }

        .site-header.is-scrolled .logo-img--secondary {
            opacity: 0;
        }

        .site-header.is-scrolled .main-nav .nav-link {
            color: var(--color-espresso);
        }

        .main-nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-link {
            color: var(--color-espresso);
            font-weight: 600;
            font-size: 0.95rem;
        }

        @if(request()->routeIs('home'))
            .nav-link {
                font-weight: 600;
                font-size: 0.95rem;
                color: var(--color-white);
            }
        @endif

        .nav-link:hover {
            color: var(--color-gilded-dark);
        }

        .nav-link.active {
            color: var(--color-gilded-dark);
        }

        .site-header.is-scrolled .main-nav .nav-link:hover {
            color: var(--color-gilded);
        }
        .site-header.is-scrolled .main-nav .nav-link.active {
            color: var(--color-gilded);
        }

        /* ── Dropdown Layanan ───────────────────── */
        .nav-dropdown {
            position: relative;
        }
        .nav-dropdown-toggle .fa-chevron-down {
            font-size: 0.62rem;
            margin-left: 4px;
            transition: transform 0.2s ease;
        }
        .nav-dropdown:hover .nav-dropdown-toggle .fa-chevron-down,
        .nav-dropdown:focus-within .nav-dropdown-toggle .fa-chevron-down {
            transform: rotate(180deg);
        }
        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 18px);
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            min-width: 270px;
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 10px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            z-index: 1100;
        }
        /* jembatan hover agar menu tidak hilang saat kursor melewati celah */
        .nav-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            height: 20px;
        }
        .nav-dropdown:hover .nav-dropdown-menu,
        .nav-dropdown:focus-within .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        .nav-dropdown-label {
            padding: 10px 12px 5px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--color-gilded-dark);
        }
        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 10px;
            color: var(--color-espresso);
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.15s ease;
        }
        .nav-dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--color-gilded-dark);
        }
        .nav-dropdown-item:hover {
            background: #F9F0D6;
            color: var(--color-noir);
        }
        /* ── Mega Dropdown Properti (Kota → Kecamatan) ── */
        [x-cloak] { display: none !important; }
        .nav-mega {
            width: 480px;
            max-width: calc(100vw - 32px);
            padding: 16px;
        }
        .nav-mega-body {
            display: flex;
            gap: 14px;
        }
        .nav-mega-cities {
            width: 40%;
            min-width: 150px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav-mega-city {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            min-height: 48px;
            padding: 8px 14px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: var(--color-gilded-dark);
            font-family: inherit;
            font-weight: 600;
            font-size: 0.88rem;
            text-align: left;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .nav-mega-city:hover {
            background: #FBF6EC;
        }
        .nav-mega-city.is-active {
            background: #F9F0D6;
            color: var(--color-noir);
        }
        .nav-mega-arrow {
            margin-left: auto;
            font-size: 0.62rem;
            color: #946E4B;
            transition: transform 0.15s ease;
        }
        .nav-mega-city:hover .nav-mega-arrow,
        .nav-mega-city.is-active .nav-mega-arrow {
            transform: translateX(3px);
        }
        .nav-mega-right {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }
        .nav-mega-heading {
            padding: 10px 12px;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--color-gilded-dark);
        }
        .nav-mega-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
            max-height: 250px;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding-right: 4px;
            scrollbar-width: thin;
            scrollbar-color: #D4A569 #F3EFE6;
        }
        .nav-mega-list::-webkit-scrollbar {
            width: 5px;
        }
        .nav-mega-list::-webkit-scrollbar-thumb {
            background: #D4A569;
            border-radius: 999px;
        }
        .nav-mega-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 11px;
            font-size: 0.95rem;
            color: var(--color-espresso);
            transition: background 0.15s ease;
        }
        .nav-mega-item i {
            width: 18px;
            text-align: center;
            font-size: 0.8rem;
            color: var(--color-gilded-dark);
        }
        .nav-mega-item:hover {
            background: #FBF6EC;
        }
        .nav-mega-item.is-current {
            background: #F9F0D6;
        }
        .nav-mega-footer {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid var(--color-border);
        }
        .nav-mega-all {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-gilded-dark);
            transition: background 0.15s ease;
        }
        .nav-mega-all:hover {
            background: #F9F0D6;
            color: var(--color-noir);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .mobile-menu-btn {
            display: none;
            position: relative;
            width: 42px;
            height: 42px;
            background: none;
            border: 0;
            color: var(--color-noir);
            font-size: 1.5rem;
            cursor: pointer;
            border-radius: 10px;
        }
        .mobile-menu-btn:focus-visible {
            outline: 2px solid var(--color-gilded-dark);
            outline-offset: 2px;
        }
        .mobile-menu-btn .mm-icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.25s ease, transform 0.3s ease;
        }
        .mobile-menu-btn .mm-icon--close {
            opacity: 0;
            transform: rotate(-90deg) scale(0.5);
        }
        .mobile-menu-btn.is-open .mm-icon--bars {
            opacity: 0;
            transform: rotate(90deg) scale(0.5);
        }
        .mobile-menu-btn.is-open .mm-icon--close {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        /* ── Mobile Menu Panel ───────────────────── */
        .mobile-menu {
            background: white;
            color: var(--color-text-main);
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            box-shadow: var(--shadow);
            padding: 14px 20px 22px;
            max-height: calc(100vh - 76px);
            max-height: calc(100dvh - 76px);
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
        }
        .mm-list {
            display: flex;
            flex-direction: column;
        }
        a.mm-link,
        a.mm-toggle,
        button.mm-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
            padding: 12px 2px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 500;
            color: var(--color-text-main);
            text-align: left;
            text-decoration: none;
        }
        a.mm-link { justify-content: flex-start; }
        button.mm-toggle { background: none; border: 0; cursor: pointer; }
        a.mm-link:hover,
        a.mm-toggle:hover,
        button.mm-toggle:hover { color: var(--color-gilded-dark); }
        button.mm-toggle:focus-visible {
            outline: 2px solid var(--color-gilded-dark);
            outline-offset: 2px;
            border-radius: 8px;
        }

        /* Icon + / − (morphing halus) */
        .mm-plus {
            position: relative;
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            color: var(--color-gilded-dark);
        }
        .mm-plus::before,
        .mm-plus::after {
            content: '';
            position: absolute;
            background: currentColor;
            border-radius: 2px;
            transition: transform 0.25s ease;
        }
        .mm-plus::before { left: 0; right: 0; top: 50%; height: 2px; margin-top: -1px; }
        .mm-plus::after  { top: 0; bottom: 0; left: 50%; width: 2px; margin-left: -1px; }
        .mm-plus.is-open::after { transform: scaleY(0); }

        /* Panel & indentasi submenu */
        .mm-panel { min-width: 0; }
        .mm-sub {
            margin: 2px 0 10px 12px;
            padding-left: 14px;
            border-left: 2px solid var(--color-border);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .mm-toggle--sub {
            padding: 10px 2px;
            font-size: 0.93rem;
            font-weight: 600;
        }
        .mm-city {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--color-gilded-dark);
        }
        .mm-leaf {
            display: flex;
            align-items: center;
            padding: 9px 2px;
            font-size: 0.92rem;
            color: var(--color-text-main);
            text-decoration: none;
        }
        .mm-leaf:hover { color: var(--color-bronze); }
        .mm-see-all {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
            padding: 11px 12px;
            border-radius: 10px;
            background: #F9F0D6;
            color: var(--color-gilded-dark);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .mm-see-all:hover {
            background: #F3E4BC;
            color: var(--color-noir);
        }

        /* Footer */
        .site-footer {
            background-color: var(--color-noir);
            color: var(--color-champagne);
            padding: 60px 0 30px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-champagne);
            margin-bottom: 15px;
            display: block;
        }

        .footer-text {
            color: rgba(249, 240, 214, 0.7);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .footer-heading {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--color-champagne);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(249, 240, 214, 0.7);
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: var(--color-gilded);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: rgba(249, 240, 214, 0.1);
            color: var(--color-champagne);
            border-radius: 50%;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background-color: var(--color-gilded);
            color: var(--color-noir);
            transform: translateY(-3px);
        }

        .contact-info li {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            color: rgba(249, 240, 214, 0.7);
            font-size: 0.95rem;
        }

        .contact-info i {
            color: var(--color-gilded);
            margin-top: 4px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(249, 240, 214, 0.12);
            padding-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: rgba(249, 240, 214, 0.55);
        }

        /* Sticky footer: pastikan footer selalu di bawah, termasuk halaman konten pendek */
        #scroll-wrapper {
            display: flex;
            flex-direction: column;
            padding-top: 76px;
            min-height: 100vh;
        }

        #scroll-wrapper main {
            flex: 1 0 auto;
        }

        #scroll-wrapper .site-footer {
            flex-shrink: 0;
        }

        /* Page Header (Global for pages like About, Services, Contact, Properties, Agents) */
        .page-header {
            background-color: var(--color-surface);
            padding: 60px 0;
            margin-bottom: 60px;
            text-align: center;
        }

        .page-title {
            font-size: 3rem;
            color: var(--color-noir);
            margin-bottom: 15px;
        }

        /* Mobile Menu */
        @media (max-width: 991px) {
            .main-nav {
                display: none;
            }
            .mobile-menu-btn {
                display: block;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
            .header-actions .btn-outline,
            .header-actions .btn-primary {
                display: none;
            }
            .page-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 767px) {
            body {
                padding-top: 0;
            }
            #scroll-wrapper {
                padding-top: 64px;
                min-height: 100vh;
            }
            .site-header {
                padding: 12px 0;
            }
            .logo {
                font-size: 1.25rem;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .site-footer {
                padding: 40px 0 25px;
                margin-top: 40px;
            }
            .page-header {
                padding: 40px 0;
                margin-bottom: 40px;
            }
            .page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 1.15rem;
                gap: 8px;
            }
            .logo i {
                font-size: 1.1rem;
            }
            .mobile-menu-btn {
                font-size: 1.3rem;
            }
            .page-header {
                padding: 30px 0;
                margin-bottom: 30px;
            }
            .page-title {
                font-size: 1.65rem;
            }
            .floating-wa {
                width: 50px;
                height: 50px;
                font-size: 30px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Floating WhatsApp */
        .floating-wa {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 9999;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .floating-wa:hover {
            transform: scale(1.1);
            background-color: #1EBE5D;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="site-header"
        @if(request()->routeIs('home'))
            :class="{ 'header-transparent': !isScrolled && !mobileMenuOpen, 'is-scrolled': isScrolled }"
        @endif
        x-data="{
            mobileMenuOpen: false,
            openLayanan: false,
            openKategori: {},
            openProperti: false,
            openCities: {},
            isScrolled: false,
            init() {
                const handleScroll = (y) => {
                    this.isScrolled = y > 20;
                };
                window.headerHandleScroll = handleScroll;
                window.addEventListener('scroll', () => handleScroll(window.scrollY));
                handleScroll(window.scrollY);
            },
            toggleMenu() {
                this.mobileMenuOpen ? this.closeAll() : this.mobileMenuOpen = true;
            },
            toggleLayanan() {
                this.openLayanan = !this.openLayanan;
                if (!this.openLayanan) this.openKategori = {};
            },
            toggleProperti() {
                this.openProperti = !this.openProperti;
                if (!this.openProperti) this.openCities = {};
            },
            closeAll() {
                this.mobileMenuOpen = false;
                this.openLayanan = false;
                this.openKategori = {};
                this.openProperti = false;
                this.openCities = {};
            }
        }">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo" title="DJM — Desty Jaya Mandiri">
                <div class="logo-container">
                    <img src="{{ asset('images/logodjm.png') }}" alt="DJM — Desty Jaya Mandiri" class="logo-img logo-img--primary">
                    @if(request()->routeIs('home'))
                        <img src="{{ asset('images/logodjm2.png') }}" alt="DJM — Desty Jaya Mandiri" class="logo-img logo-img--secondary">
                    @endif
                </div>
            </a>

            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('about.index') }}" class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">Tentang Kami</a>

                @php $navServices = \App\Support\ServiceItem::all()->groupBy('category'); @endphp
                <div class="nav-dropdown">
                    <a href="{{ route('services.index') }}" class="nav-link nav-dropdown-toggle {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        Layanan<i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <div class="nav-dropdown-menu">
                        @foreach($navServices as $category => $items)
                            <div class="nav-dropdown-label">{{ \App\Support\ServiceItem::CATEGORIES[$category] ?? ucfirst($category) }}</div>
                            @foreach($items as $svc)
                                <a href="{{ route('services.show', $svc->slug) }}" class="nav-dropdown-item">
                                    {{ $svc->name }}
                                </a>
                            @endforeach
                        @endforeach
                        <div style="border-top: 1px solid var(--color-border); margin-top: 8px; padding-top: 8px;">
                            <a href="{{ route('services.index') }}" class="nav-dropdown-item" style="justify-content: center; color: var(--color-gilded-dark);">
                                Lihat Semua Layanan <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @php
                    $navCities = \App\Models\City::with(['districts' => fn ($q) => $q->where('is_active', true)->orderBy('name')])
                        ->where('is_active', true)->orderBy('name')->get();
                    // Struktur data dipisah dari tampilan — nanti tinggal diganti fetch API tanpa ubah UI.
                    $navRegionData = $navCities->map(fn ($city) => [
                        'name'      => $city->name,
                        'slug'      => $city->slug,
                        'districts' => $city->districts->map(fn ($d) => ['name' => $d->name, 'slug' => $d->slug])->values()->all(),
                    ])->values()->all();
                @endphp
                <div class="nav-dropdown"
                    x-data="{
                        regions: {{ json_encode($navRegionData) }},
                        active: 0,
                        path: '{{ url('properti') }}',
                        curCity: {{ json_encode(request('city')) }},
                        curDistrict: {{ json_encode(request('district')) }}
                    }">
                    <a href="{{ route('properties.index') }}" class="nav-link nav-dropdown-toggle {{ request()->routeIs('properties.*') ? 'active' : '' }}"
                        @mouseenter="active = 0" @focus="active = 0">
                        Properti<i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <div class="nav-dropdown-menu nav-mega">
                        @if(count($navRegionData))
                            <div class="nav-mega-body">
                                {{-- KOLOM KIRI: daftar kota/kabupaten --}}
                                <div class="nav-mega-cities">
                                    @foreach($navRegionData as $i => $region)
                                        <button type="button"
                                            class="nav-mega-city"
                                            :class="active === {{ $i }} ? 'is-active' : ''"
                                            @mouseenter="active = {{ $i }}"
                                            @focus="active = {{ $i }}"
                                            @click="active = {{ $i }}">
                                            <span>{{ $region['name'] }}</span>
                                            <i class="fa-solid fa-chevron-right nav-mega-arrow"></i>
                                        </button>
                                    @endforeach
                                </div>
                                {{-- KOLOM KANAN: kecamatan milik kota aktif --}}
                                <div class="nav-mega-right">
                                    <h4 class="nav-mega-heading" x-text="'Kecamatan di ' + regions[active].name">Kecamatan di {{ $navRegionData[0]['name'] }}</h4>
                                    <div class="nav-mega-list">
                                        <template x-for="d in regions[active].districts" :key="regions[active].slug + '-' + d.slug">
                                            <a :href="path + '?city=' + regions[active].slug + '&amp;district=' + d.slug"
                                                class="nav-mega-item"
                                                :class="(curCity === regions[active].slug && curDistrict === d.slug) ? 'is-current' : ''">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span x-text="d.name">{{ $navRegionData[0]['districts'][0]['name'] ?? '' }}</span>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div style="padding: 16px; font-size: 0.9rem; color: var(--color-espresso);">Belum ada wilayah.</div>
                        @endif
                        <div class="nav-mega-footer">
                            <a href="{{ route('properties.index') }}" class="nav-mega-all">
                                Lihat Semua Properti <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('portfolio.index') }}" class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portfolio</a>
            </nav>

            <div class="header-actions">
                <a href="{{ route('contact.index') }}" class="btn btn-primary" style="color: var(--color-noir);">Hubungi Kami</a>
                <button type="button"
                    class="mobile-menu-btn"
                    :class="mobileMenuOpen ? 'is-open' : ''"
                    @click="toggleMenu()"
                    @keydown.escape.window="closeAll()"
                    aria-label="Buka / tutup menu navigasi"
                    aria-controls="mobile-menu"
                    :aria-expanded="mobileMenuOpen">
                    <i class="fa-solid fa-bars mm-icon mm-icon--bars" aria-hidden="true"></i>
                    <i class="fa-solid fa-xmark mm-icon mm-icon--close" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Alpine.js) -->
        <div id="mobile-menu"
             class="mobile-menu"
             x-show="mobileMenuOpen"
             @click.away="closeAll()"
             x-transition.opacity.duration.200ms
             style="display: none;">
            <nav class="mm-list" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="mm-link">Beranda</a>
                <a href="{{ route('about.index') }}" class="mm-link">Tentang Kami</a>

                {{-- ── LAYANAN: accordion 2 level ── --}}
                <div>
                    <button type="button"
                        class="mm-toggle"
                        @click="toggleLayanan()"
                        :aria-expanded="openLayanan"
                        aria-controls="mobile-menu-layanan">
                        <span>Layanan</span>
                        <span class="mm-plus" :class="openLayanan ? 'is-open' : ''" aria-hidden="true"></span>
                    </button>

                    <div id="mobile-menu-layanan" class="mm-panel" x-show="openLayanan" x-transition.opacity.duration.200ms x-cloak>
                        <div class="mm-sub">
                            @foreach(\App\Support\ServiceItem::CATEGORIES as $catKey => $catLabel)
                                @if($navServices->has($catKey))
                                    <div>
                                        <button type="button"
                                            class="mm-toggle mm-toggle--sub"
                                            @click="openKategori['{{ $catKey }}'] = !openKategori['{{ $catKey }}']"
                                            :aria-expanded="openKategori['{{ $catKey }}'] ? 'true' : 'false'"
                                            aria-controls="mobile-menu-kategori-{{ $catKey }}">
                                            <span>{{ $catLabel }}</span>
                                            <span class="mm-plus" :class="openKategori['{{ $catKey }}'] ? 'is-open' : ''" aria-hidden="true"></span>
                                        </button>
                                        <div id="mobile-menu-kategori-{{ $catKey }}" class="mm-panel" x-show="openKategori['{{ $catKey }}']" x-transition.opacity.duration.200ms x-cloak>
                                            <div class="mm-sub">
                                                @foreach($navServices[$catKey] as $svc)
                                                    <a href="{{ route('services.show', $svc->slug) }}" class="mm-leaf">{{ $svc->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <a href="{{ route('services.index') }}" class="mm-see-all">
                                Lihat Semua Layanan <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ── PROPERTI: accordion 2 level (kota → kecamatan) ── --}}
                <div>
                    <button type="button"
                        class="mm-toggle"
                        @click="toggleProperti()"
                        :aria-expanded="openProperti"
                        aria-controls="mobile-menu-properti">
                        <span>Properti</span>
                        <span class="mm-plus" :class="openProperti ? 'is-open' : ''" aria-hidden="true"></span>
                    </button>

                    <div id="mobile-menu-properti" class="mm-panel" x-show="openProperti" x-transition.opacity.duration.200ms x-cloak>
                        <div class="mm-sub">
                            @foreach($navRegionData as $region)
                                <div>
                                    @if(count($region['districts']))
                                        <button type="button"
                                            class="mm-toggle mm-toggle--sub mm-city"
                                            @click="openCities['{{ $region['slug'] }}'] = !openCities['{{ $region['slug'] }}']"
                                            :aria-expanded="openCities['{{ $region['slug'] }}'] ? 'true' : 'false'"
                                            aria-controls="mobile-menu-wilayah-{{ $region['slug'] }}">
                                            <span>{{ $region['name'] }}</span>
                                            <span class="mm-plus" :class="openCities['{{ $region['slug'] }}'] ? 'is-open' : ''" aria-hidden="true"></span>
                                        </button>
                                        <div id="mobile-menu-wilayah-{{ $region['slug'] }}" class="mm-panel" x-show="openCities['{{ $region['slug'] }}']" x-transition.opacity.duration.200ms x-cloak>
                                            <div class="mm-sub">
                                                @foreach($region['districts'] as $district)
                                                    <a href="{{ url('properti') }}?city={{ $region['slug'] }}&amp;district={{ $district['slug'] }}" class="mm-leaf">Kecamatan {{ $district['name'] }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('properti') }}?city={{ $region['slug'] }}" class="mm-toggle mm-toggle--sub mm-city">
                                            <span>{{ $region['name'] }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                            <a href="{{ route('properties.index') }}" class="mm-see-all">
                                Lihat Semua Properti <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('portfolio.index') }}" class="mm-link">Portfolio</a>
                <a href="{{ route('contact.index') }}" class="mm-link" style="color: var(--color-bronze); font-weight: 600;">Hubungi Kami</a>
            </nav>
        </div>
    </header>

    <!-- Locomotive Scroll Container -->
    <div data-scroll-container id="scroll-wrapper">
        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-widget">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ asset('images/logodjm2.png') }}" alt="DJM — Desty Jaya Mandiri" class="logo-img">
                    </a>
                    <p class="footer-text">
                        Desty Jaya Mandiri — perusahaan terpercaya di bidang perizinan, properti, dan konstruksi di Yogyakarta dan sekitarnya.
                    </p>
                    <div class="social-links">
                        <a href="#" title="Facebook DJM"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" title="Instagram DJM"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/6281234567890" target="_blank" title="WhatsApp DJM"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="footer-widget">
                    <h4 class="footer-heading">Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('about.index') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('services.index') }}">Layanan</a></li>
                        <li><a href="{{ route('properties.index') }}">Properti</a></li>
                        <li><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h4 class="footer-heading">Layanan Kami</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('services.show', 'pbg-imb') }}">Perizinan (PBG/IMB)</a></li>
                        <li><a href="{{ route('services.show', 'pengeringan') }}">Pengeringan Lahan</a></li>
                        <li><a href="{{ route('services.show', 'pecah-sertifikat') }}">Pecah Sertifikat</a></li>
                        <li><a href="{{ route('services.show', 'pembangunan') }}">Konstruksi & Renovasi</a></li>
                        <li><a href="{{ route('properties.index') }}">Beli & Sewa Properti</a></li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h4 class="footer-heading">Hubungi Kami</h4>
                    <ul class="contact-info" style="list-style: none;">
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Jl. Kaliurang KM 7, Sleman, Yogyakarta</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <span>+62 274 123456</span>
                        </li>
                        <li>
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <span>info@djmproperty.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} DJM — Desty Jaya Mandiri. Hak Cipta Dilindungi.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('contact.index') }}" style="color: rgba(255,255,255,0.6);">Kontak</a>
                    <a href="{{ route('about.index') }}" style="color: rgba(255,255,255,0.6);">Tentang Kami</a>
                </div>
            </div>
        </div>
    </footer>
    </div> <!-- End Locomotive Scroll Container -->

    <!-- Floating WhatsApp Button -->
    @hasSection('hide_wa_floating')
    @else
    <a href="https://wa.me/6281234567890" class="floating-wa" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    @endif

    <!-- Locomotive Scroll JS -->
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scroll = new LocomotiveScroll({
                el: document.querySelector('#scroll-wrapper'),
                smooth: true,
                multiplier: 1,
                class: 'is-reveal'
            });

            scroll.on('scroll', function(args) {
                if (window.headerHandleScroll && args && args.scroll) {
                    window.headerHandleScroll(args.scroll.y);
                }
            });

            // Update Locomotive Scroll if images loaded
            window.addEventListener('load', function() {
                scroll.update();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

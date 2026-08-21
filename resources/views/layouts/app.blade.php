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

        .logo-img {
            height: 56px;
            width: auto;
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

        .nav-link:hover {
            color: var(--color-gilded-dark);
        }

        .nav-link.active {
            color: var(--color-gilded-dark);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--color-noir);
            font-size: 1.5rem;
            cursor: pointer;
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
    <header class="site-header" x-data="{ mobileMenuOpen: false }">
        <div class="container header-inner">
            <a href="{{ route('home') }}" class="logo" title="DJM — Desty Jaya Mandiri">
                <img src="{{ asset('images/logodjm.png') }}" alt="DJM — Desty Jaya Mandiri" class="logo-img">
            </a>
            
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('about.index') }}" class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Layanan</a>
                <a href="{{ route('properties.index') }}" class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}">Properti</a>
                <a href="{{ route('portfolio.index') }}" class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portfolio</a>
            </nav>

            <div class="header-actions">
                <a href="{{ route('contact.index') }}" class="btn btn-primary" style="color: var(--color-noir);">Hubungi Kami</a>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Alpine.js) -->
        <div x-show="mobileMenuOpen" 
             @click.away="mobileMenuOpen = false"
             x-transition
             style="display: none; background: white; color: var(--color-text-main); position: absolute; top: 100%; left: 0; right: 0; box-shadow: var(--shadow); padding: 20px;">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <a href="{{ route('home') }}" style="color: var(--color-text-main); font-weight: 500;">Beranda</a>
                <a href="{{ route('about.index') }}" style="color: var(--color-text-main); font-weight: 500;">Tentang Kami</a>
                <a href="{{ route('services.index') }}" style="color: var(--color-text-main); font-weight: 500;">Layanan</a>
                <a href="{{ route('properties.index') }}" style="color: var(--color-text-main); font-weight: 500;">Properti</a>
                <a href="{{ route('portfolio.index') }}" style="color: var(--color-text-main); font-weight: 500;">Portfolio</a>
                <a href="{{ route('contact.index') }}" style="color: var(--color-bronze); font-weight: 600;">Hubungi Kami</a>
            </div>
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

            // Update Locomotive Scroll if images loaded
            window.addEventListener('load', function() {
                scroll.update();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>

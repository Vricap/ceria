<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DJM Property - Your Trusted Property Partner')</title>
    <meta name="description" content="@yield('meta_description', 'DJM Property adalah platform properti terpercaya di Yogyakarta.')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'DJM Property')">
    <meta property="og:description" content="@yield('meta_description', 'Platform properti terpercaya di Yogyakarta.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:type" content="website">

    <!-- Schema.org JSON-LD -->
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
            padding-top: 76px;
        }

        /* Base header styles */
        .site-header {
            background-color: var(--color-primary);
            color: white;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }
        
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo:hover {
            color: var(--color-secondary);
        }

        .main-nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
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
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Footer */
        .site-footer {
            background-color: var(--color-primary-dark);
            color: white;
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
            color: white;
            margin-bottom: 15px;
            display: block;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .footer-heading {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: white;
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
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background-color: var(--color-accent);
            transform: translateY(-3px);
        }

        .contact-info li {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }
        
        .contact-info i {
            color: var(--color-accent);
            margin-top: 4px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
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
            color: var(--color-primary);
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
            .header-actions .btn-outline {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
            .page-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 767px) {
            body {
                padding-top: 64px;
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
            .header-actions .btn-outline {
                display: none;
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
            <a href="{{ route('home') }}" class="logo">
                <i class="fa-solid fa-house-chimney"></i> DJM Property
            </a>
            
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('about.index') }}" class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ route('properties.index') }}" class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}">Properti</a>
                <a href="{{ route('agents.index') }}" class="nav-link {{ request()->routeIs('agents.*') ? 'active' : '' }}">Agen</a>
                <a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Layanan</a>
            </nav>

            <div class="header-actions">
                <a href="{{ route('contact.index') }}" class="btn btn-outline" style="border-color: white; color: white;">Hubungi Kami</a>
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
                <a href="{{ route('properties.index') }}" style="color: var(--color-text-main); font-weight: 500;">Properti</a>
                <a href="{{ route('agents.index') }}" style="color: var(--color-text-main); font-weight: 500;">Agen</a>
                <a href="{{ route('services.index') }}" style="color: var(--color-text-main); font-weight: 500;">Layanan</a>
                <a href="{{ route('contact.index') }}" style="color: var(--color-primary); font-weight: 600;">Hubungi Kami</a>
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
                        <i class="fa-solid fa-house-chimney"></i> DJM Property
                    </a>
                    <p class="footer-text">
                        Platform properti terpercaya di Yogyakarta. Kami membantu Anda menemukan, membeli, dan mengelola properti dengan proses yang mudah dan transparan.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-widget">
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('about.index') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('properties.index') }}">Cari Properti</a></li>
                        <li><a href="{{ route('agents.index') }}">Daftar Agen</a></li>
                    </ul>
                </div>

                <div class="footer-widget">
                    <h4 class="footer-heading">Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('services.index') }}">Beli Properti</a></li>
                        <li><a href="{{ route('services.index') }}">Jual Properti</a></li>
                        <li><a href="{{ route('services.index') }}">Sewa Properti</a></li>
                        <li><a href="{{ route('services.index') }}">Manajemen Properti</a></li>
                        <li><a href="{{ route('services.index') }}">Konsultasi</a></li>
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
                <p>&copy; {{ date('Y') }} DJM Property. All rights reserved.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="color: rgba(255,255,255,0.6);">Privacy Policy</a>
                    <a href="#" style="color: rgba(255,255,255,0.6);">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    </div> <!-- End Locomotive Scroll Container -->

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" class="floating-wa" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DJM Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logodjm1.png') }}">

    {{-- Font & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind CSS (CDN) dengan design system DJM --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        gilded: { DEFAULT: '#D4A569', dark: '#B98647', light: '#E6C48D' },
                        bronze: { DEFAULT: '#946E4B', dark: '#7A5938', light: '#B08A63' },
                        champagne: { DEFAULT: '#F9F0D6', dark: '#F0E2BC', light: '#FBF4E4' },
                        espresso: { DEFAULT: '#523828', light: '#6B4A33' },
                        noir: { DEFAULT: '#1F1611' },
                        warmline: '#EADFCB',
                        warmbg: '#FBF6EC',
                    },
                    boxShadow: {
                        warm: '0 1px 2px 0 rgba(31,22,17,0.05), 0 4px 10px -2px rgba(31,22,17,0.08)',
                        warmlg: '0 10px 25px -5px rgba(31,22,17,0.14)',
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #FBF6EC;
            color: #1F1611;
        }

        /* ── Sidebar ───────────────────────────── */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: #FFFFFF;
            border-right: 1px solid #EADFCB;
            z-index: 50;
            display: flex;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.25s ease;
        }
        .admin-sidebar.open {
            transform: translateX(0);
        }
        @media (min-width: 1024px) {
            .admin-sidebar {
                transform: none;
            }
            .admin-main {
                margin-left: 250px;
            }
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(31, 22, 17, 0.45);
            z-index: 40;
            display: none;
        }
        .sidebar-overlay.show {
            display: block;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: #523828;
            font-weight: 600;
            font-size: 0.925rem;
            transition: all 0.18s ease;
            margin-bottom: 4px;
        }
        .sidebar-link i {
            width: 20px;
            text-align: center;
            color: #946E4B;
            transition: color 0.18s ease;
        }
        .sidebar-link:hover {
            background: #F9F0D6;
            color: #1F1611;
        }
        .sidebar-link.active {
            background: #F9F0D6;
            color: #1F1611;
        }
        .sidebar-link.active i {
            color: #946E4B;
        }

        /* ── Topbar ────────────────────────────── */
        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: #FFFFFF;
            border-bottom: 1px solid #EADFCB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 62px;
        }

        /* ── Cards ─────────────────────────────── */
        .card {
            background: #FFFFFF;
            border: 1px solid #EADFCB;
            border-radius: 18px;
            box-shadow: 0 1px 2px 0 rgba(31,22,17,0.05), 0 4px 10px -2px rgba(31,22,17,0.08);
        }
        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 20px 24px;
            border-bottom: 1px solid #F0E6D2;
        }

        .stat-card {
            background: #FFFFFF;
            border: 1px solid #EADFCB;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 1px 2px 0 rgba(31,22,17,0.05), 0 4px 10px -2px rgba(31,22,17,0.08);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 10px 25px -5px rgba(31,22,17,0.14);
            transform: translateY(-2px);
        }

        /* ── Buttons ───────────────────────────── */
        .btn-gilded {
            background: #D4A569;
            color: #1F1611;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px -3px rgba(212, 165, 105, 0.55);
        }
        .btn-gilded:hover {
            background: #B98647;
        }
        .btn-ghost {
            background: #FFFFFF;
            border: 1px solid #EADFCB;
            color: #523828;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .btn-ghost:hover {
            background: #F9F0D6;
            color: #1F1611;
        }

        /* ── Flash ─────────────────────────────── */
        .flash-success {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #F9F0D6;
            border: 1px solid #EADFCB;
            color: #523828;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .flash-success i:first-child {
            color: #946E4B;
        }
        .flash-error {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #FBF0EA;
            border: 1px solid #F0D9CC;
            color: #A4492F;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .flash-error i:first-child {
            color: #A4492F;
        }

        /* ── Form controls ─────────────────────── */
        .field-input {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #E8DCC8;
            background: #FFFFFF;
            padding: 10px 14px;
            font-size: 0.9rem;
            color: #1F1611;
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }
        .field-input:focus {
            border-color: #D4A569;
            box-shadow: 0 0 0 3px rgba(212, 165, 105, 0.22);
        }
        .field-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1F1611;
            margin-bottom: 7px;
        }
    </style>
</head>

<body class="antialiased">

    {{-- SIDEBAR --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Menu Admin">

        {{-- Logo --}}
        <div class="px-6 pt-6 pb-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3" title="DJM — Desty Jaya Mandiri">
                <img src="{{ asset('images/logodjm.png') }}" alt="DJM" class="h-10 w-auto object-contain">
            </a>
            <p class="mt-1.5 text-xs font-semibold uppercase tracking-wider text-[#946E4B]">Admin Panel</p>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 overflow-y-auto px-4 pt-2">
            <div class="px-2 pb-2 text-[11px] font-bold uppercase tracking-widest text-[#9C8C77]">Main</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-columns"></i>
                Dashboard
            </a>
            <a href="{{ route('dashboard.properties') }}" class="sidebar-link {{ request()->routeIs('dashboard.properties') || request()->routeIs('properties.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i>
                Properti
            </a>
            <a href="{{ route('dashboard.property-types') }}" class="sidebar-link {{ request()->routeIs('dashboard.property-types') || request()->routeIs('property-types.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i>
                Tipe Properti
            </a>
            <div class="px-2 pt-4 pb-2 text-[11px] font-bold uppercase tracking-widest text-[#9C8C77]">Akun</div>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link text-red-700 hover:bg-red-50 hover:text-red-900 transition-colors">
                <i class="fa-solid fa-right-from-bracket text-red-700"></i>
                Keluar
            </a>
        </nav>

        {{-- Footer profile --}}
        <div class="border-t border-[#EADFCB] p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1F1611] text-sm font-bold text-[#F9F0D6] shadow">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-bold text-[#1F1611]">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="truncate text-xs text-[#523828]">{{ ucfirst(auth()->user()->role ?? 'Administrator') }}</div>
                </div>
            </div>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="admin-main flex min-h-screen flex-col">

        {{-- Topbar --}}
        <header class="admin-topbar">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="flex h-9 w-9 items-center justify-center rounded-lg text-[#523828] hover:bg-[#F9F0D6] lg:hidden" aria-label="Buka menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <span class="text-sm font-bold text-[#1F1611] lg:hidden">DJM Admin</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-semibold text-[#946E4B] transition hover:text-[#1F1611]">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span class="hidden sm:inline"> Lihat Website</span>
                </a>
                
                {{-- Logout Form & Trigger --}}
                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
                    @csrf
                </form>
                <!-- <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="text-xs font-semibold text-red-600 transition hover:text-red-800" title="Keluar">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="hidden sm:inline"> Keluar</span>
                </a> -->

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#D4A569] text-xs font-bold text-[#1F1611] shadow" title="{{ auth()->user()->name ?? 'Admin' }}">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Main --}}
        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            @if(session('success'))
                <div class="flash-success mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-[#523828] hover:text-[#1F1611]" aria-label="Tutup">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="flash-error mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="hover:text-[#7A3B2E]" aria-label="Tutup">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('show');
        }
        function closeSidebar() {
            document.getElementById('adminSidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('show');
        }
    </script>

    @yield('scripts')

</body>
</html>

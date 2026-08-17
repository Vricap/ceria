<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — DJM</title>
    <meta name="description" content="Halaman login administrator DJM (Desty Jaya Mandiri) Property.">
    <link rel="icon" type="image/png" href="{{ asset('images/logodjm1.png') }}">
    
    {{-- Fonts & Icons --}}
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
                        warm: '0 4px 6px -1px rgba(31, 22, 17, 0.08), 0 2px 4px -1px rgba(31, 22, 17, 0.05)',
                        warmlg: '0 10px 25px -5px rgba(31, 22, 17, 0.12), 0 8px 10px -6px rgba(31, 22, 17, 0.08)',
                        premium: '0 20px 40px -15px rgba(82, 56, 40, 0.15)',
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #FBF6EC 0%, #F9F0D6 100%);
            position: relative;
            overflow: hidden;
        }

        /* Ambient glowing circles for background */
        .ambient-glow-1 {
            position: absolute;
            top: -20%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 165, 105, 0.15) 0%, rgba(251, 246, 236, 0) 70%);
            z-index: 0;
            filter: blur(40px);
            pointer-events: none;
        }
        
        .ambient-glow-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(148, 110, 75, 0.12) 0%, rgba(251, 246, 236, 0) 70%);
            z-index: 0;
            filter: blur(40px);
            pointer-events: none;
        }

        /* Keyframe animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center p-4 antialiased">
    
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="z-10 w-full max-w-md animate-fade-in-up">
        
        {{-- Card --}}
        <div class="overflow-hidden rounded-2xl border border-warmline bg-white/80 p-8 shadow-premium backdrop-blur-md sm:p-10">
            
            {{-- Header/Logo --}}
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-block transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('images/logodjm.png') }}" alt="DJM Logo — Desty Jaya Mandiri" class="mx-auto h-16 w-auto object-contain">
                </a>
                <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-noir">Admin Portal</h1>
                <p class="mt-1 text-sm font-semibold text-bronze uppercase tracking-wider">Desty Jaya Mandiri</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <i class="fa-solid fa-circle-xmark text-red-600"></i>
                        Gagal Masuk
                    </div>
                    <ul class="list-inside list-disc pl-1 space-y-1 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-xs font-bold text-noir uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-bronze/60">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="block w-full rounded-xl border border-warmline bg-white py-3 pl-10 pr-4 text-sm text-noir placeholder:text-bronze/40 outline-none transition-all duration-200 focus:border-gilded focus:ring-4 focus:ring-gilded/20"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-noir uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-bronze/60">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full rounded-xl border border-warmline bg-white py-3 pl-10 pr-10 text-sm text-noir placeholder:text-bronze/40 outline-none transition-all duration-200 focus:border-gilded focus:ring-4 focus:ring-gilded/20"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-bronze/50 hover:text-noir transition-colors">
                            <i class="fa-solid fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center select-none cursor-pointer">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-warmline text-gilded focus:ring-gilded/20 accent-[#D4A569]">
                        <span class="ml-2 text-xs font-semibold text-espresso">Ingat Perangkat Ini</span>
                    </label>
                </div>

                <button type="submit" 
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-gilded py-3.5 text-sm font-bold text-noir shadow-md transition-all duration-200 hover:bg-gilded-dark hover:-translate-y-0.5 active:translate-y-0">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk ke Dashboard
                </button>
            </form>
            
            {{-- Return Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bronze transition-colors hover:text-noir">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
        
        {{-- Footer --}}
        <p class="mt-6 text-center text-xs font-medium text-bronze/70">
            &copy; {{ date('Y') }} DJM — Desty Jaya Mandiri. Hak Cipta Dilindungi.
        </p>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

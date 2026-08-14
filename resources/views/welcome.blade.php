<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BU E-Logbook') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bp-bg {
            background-image:
                linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px),
                linear-gradient(160deg, #1E2A78 0%, #12587A 55%, #0EA5B7 100%);
            background-size: 32px 32px, 32px 32px, 100% 100%;
        }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="bp-bg min-h-screen flex flex-col">

        {{-- Top nav --}}
        <nav class="flex items-center justify-between px-6 sm:px-10 py-6">
            <div class="flex items-center gap-2 text-white font-display font-semibold text-lg">
                <svg width="28" height="28" viewBox="0 0 64 64" fill="none">
                    <rect x="10" y="6" width="44" height="52" rx="2" stroke="#FFFFFF" stroke-width="2"/>
                    <path d="M18 18h28M18 26h28M18 34h18" stroke="#FF9F1C" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="20" cy="44" r="2.5" fill="#FF9F1C"/>
                    <path d="M26 44h20" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
                </svg>
                BU E-Logbook
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-md hover:brightness-105 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-white font-medium hover:text-[#FFC46B] transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-md hover:brightness-105 transition">
                        Register
                    </a>
                @endauth
            </div>
        </nav>

        {{-- Hero --}}
        <div class="flex-1 flex flex-col items-center justify-center text-center px-6 py-16">
            <img src="{{ asset('images/logo.svg') }}" alt="BU E-Logbook" class="h-24 w-24 mb-4">
            <div class="inline-flex items-center gap-2 text-[#FFC46B] font-mono text-sm tracking-widest uppercase mb-6">
                Busitema University · Faculty of Engineering
            </div>

            <h1 class="font-display text-4xl sm:text-5xl font-bold text-white leading-tight mb-4 max-w-2xl">
                Your Internship Logbook, Digitized
            </h1>
            <p class="text-white/95 text-lg leading-relaxed max-w-xl font-medium mb-8">
                Record daily activities, get supervisor sign-off, and track your engineering internship
                progress from anywhere — no more paper logbooks.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-8 py-3 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-lg hover:shadow-xl hover:brightness-105 active:scale-[0.98] transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-8 py-3 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-lg hover:shadow-xl hover:brightness-105 active:scale-[0.98] transition">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-3 rounded-md font-semibold text-white border-2 border-white/70 hover:bg-white/10 transition">
                        Log In
                    </a>
                @endauth
            </div>
        </div>

        {{-- Feature cards --}}
        <div class="px-6 pb-16">
            <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF9F1C" stroke-width="2" class="mb-3">
                        <path d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-white font-display font-semibold text-lg mb-1">Daily Digital Reports</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Log operations, tools used, and challenges faced for every day of your internship.
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF9F1C" stroke-width="2" class="mb-3">
                        <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-white font-display font-semibold text-lg mb-1">Supervisor Review</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Company and university supervisors review and approve reports directly online.
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-6">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF9F1C" stroke-width="2" class="mb-3">
                        <path d="M3 3v18h18M18 17V9M13 17V5M8 17v-3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-white font-display font-semibold text-lg mb-1">Faculty-Wide Tracking</h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Admins track progress across all 10 engineering departments in one dashboard.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center font-mono text-xs text-white/60 tracking-wide pb-6">
            LOG.SYS / v1.0 — Faculty of Engineering
        </div>
    </div>
</body>
</html>
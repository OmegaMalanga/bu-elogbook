<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BU E-Logbook') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bp-bg {
            background: linear-gradient(160deg, #1E2A78 0%, #12587A 55%, #0EA5B7 100%);
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
    <div class="bp-bg min-h-screen flex flex-col items-center justify-center px-6 py-12">

        {{-- Centered branding --}}
        <div class="flex flex-col items-center text-center mb-8">
            <div class="inline-flex items-center gap-2 text-[#FFC46B] font-mono text-sm tracking-widest uppercase mb-6">
                Busitema University · Faculty of Engineering
            </div>

            {{-- Signature schematic icon --}}
            <svg width="56" height="56" viewBox="0 0 64 64" fill="none" class="mb-4">
                <rect x="10" y="6" width="44" height="52" rx="2" stroke="#FFFFFF" stroke-width="1.5"/>
                <path d="M18 18h28M18 26h28M18 34h18" stroke="#FF9F1C" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="20" cy="44" r="2" fill="#FF9F1C"/>
                <path d="M26 44h20" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round"/>
            </svg>

            <h1 class="font-display text-4xl font-bold text-white leading-tight mb-3">
                BU E-Logbook
            </h1>
            <p class="text-white/95 text-base leading-relaxed max-w-md font-medium">
                The digital internship logbook for Busitema Engineering students — daily reports,
                supervisor review, and progress tracking in one place.
            </p>
        </div>

        {{-- Login form card --}}
        <div class="w-full max-w-sm">
            <div class="bg-white border border-slate-200 rounded-lg shadow-2xl p-8">
                {{ $slot }}
            </div>
        </div>

        <div class="font-mono text-xs text-white/70 tracking-wide mt-8">
            LOG.SYS / v1.0 — Faculty of Engineering
        </div>
    </div>
</body>
</html>
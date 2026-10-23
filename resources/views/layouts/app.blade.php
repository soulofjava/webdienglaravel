<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteSettings = $settings ?? \App\Models\SiteSetting::getSettings($activeTheme ?? null);
        $favUrl = $siteSettings->favicon_url ?: '/favicon.png';
        $favAsset = (str_starts_with($favUrl, 'http://') || str_starts_with($favUrl, 'https://')) ? $favUrl : asset(ltrim($favUrl, '/'));
    @endphp

    @php
        $defaultTitle = request()->is('admin*') 
            ? 'Panel Pengelola' 
            : ($siteSettings->seo_title ?: ($siteSettings->site_name . ' — ' . ($siteSettings->site_tagline ?: 'Biro Wisata Dataran Tinggi Dieng')));
    @endphp

    <title>@yield('title', $defaultTitle)</title>
    
    <!-- Meta SEO Dasar -->
    <meta name="description" content="@yield('meta_description', ($siteSettings->seo_description ?: 'Biro perjalanan wisata resmi Dataran Tinggi Dieng. Nikmati keindahan Golden Sunrise Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, dan Jeep Safari.'))">
    <meta name="keywords" content="{{ $siteSettings->seo_keywords ?: 'paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir' }}">
    <meta name="author" content="soulofjava labs — {{ $siteSettings->site_name }}">
    <link rel="author" href="https://soulofjava.github.io/myportofolio/">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph (Facebook, WhatsApp, Telegram, LinkedIn) -->
    @php
        $rawOgImage = $siteSettings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop';
        // Pastikan URL OG Image selalu menggunakan absolute URL domain yang sedang diakses (mencegah redirect antar domain)
        if (str_starts_with($rawOgImage, '/')) {
            $defaultOgImage = url($rawOgImage);
        } else {
            $parsedOg = parse_url($rawOgImage);
            if (isset($parsedOg['path']) && str_starts_with($parsedOg['path'], '/media/')) {
                $defaultOgImage = url($parsedOg['path'] . (isset($parsedOg['query']) ? '?' . $parsedOg['query'] : ''));
            } else {
                $defaultOgImage = $rawOgImage;
            }
        }
    @endphp
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteSettings->site_name }}">
    <meta property="og:title" content="@yield('title', ($siteSettings->seo_title ?: $siteSettings->site_name))">
    <meta property="og:description" content="@yield('meta_description', ($siteSettings->seo_description ?: $siteSettings->site_tagline))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($siteSettings->seo_title ?: $siteSettings->site_name))">
    <meta name="twitter:description" content="@yield('meta_description', ($siteSettings->seo_description ?: $siteSettings->site_tagline))">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Schema.org JSON-LD Structured Data Slot -->
    @yield('schema_json')

    <!-- Favicon Dinamis -->
    <link rel="icon" type="image/png" href="{{ $favAsset }}">
    <link rel="shortcut icon" href="{{ $favAsset }}">
    <link rel="apple-touch-icon" href="{{ $favAsset }}">

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;900&family=Playfair+Display:ital,wght@0,500;0,700;0,900;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Production Compiled Vite Assets (Super Fast, No Runtime Compiler) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons (Deferred for non-blocking page render) -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: #F4F7FB;
            color: #1A202C;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .glass-panel {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05) !important;
        }

        /* Shimmering Skeleton Loader Animations */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 1.6s infinite linear;
        }
        .skeleton-shimmer {
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.02) 25%, rgba(0, 0, 0, 0.06) 50%, rgba(0, 0, 0, 0.02) 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.8s infinite ease-in-out;
        }
        @keyframes shimmerPulse {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Custom Flatpickr tiket.com Modern Theme */
        .flatpickr-calendar {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 20px 40px -15px rgba(0, 100, 210, 0.15), 0 0 1px 1px rgba(0, 0, 0, 0.05) !important;
            border-radius: 1rem !important;
            padding: 10px !important;
            color: #1A202C !important;
        }
        .flatpickr-calendar .flatpickr-month {
            background: transparent !important;
            color: #1A202C !important;
            fill: #0064D2 !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: #0064D2 !important;
            font-weight: 700 !important;
        }
        .flatpickr-weekdays {
            border-bottom: 1px solid #F1F5F9 !important;
            margin-bottom: 4px !important;
        }
        span.flatpickr-weekday {
            color: #64748B !important;
            font-weight: 600 !important;
        }
        .flatpickr-day {
            color: #334155 !important;
            border-radius: 0.65rem !important;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #0064D2 !important;
            border-color: #0064D2 !important;
            color: #FFFFFF !important;
            font-weight: 800 !important;
            border-radius: 0.65rem !important;
        }
        .flatpickr-day:hover {
            background: #E8F3FF !important;
            color: #0064D2 !important;
            border-radius: 0.65rem !important;
        }
        .flatpickr-day.today {
            border-color: #FEDD00 !important;
            background: #FFFBEB !important;
            color: #B45309 !important;
            font-weight: 700 !important;
        }
        .flatpickr-day.disabled, .flatpickr-day.disabled:hover {
            color: #CBD5E1 !important;
        }

        /* Modern tiket.com Clean Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F4F7FB;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0064D2;
        }
    </style>

    <!-- Flatpickr CSS (Modern Clean Light Theme) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    </noscript>
    @stack('styles')
</head>
<body class="bg-[#F4F7FB] text-[#1A202C] font-sans antialiased selection:bg-[#0064D2]/20 selection:text-[#0064D2] min-h-screen">
    <!-- Sticky Impersonation Alert Banner (Khusus saat Superadmin Login As) -->
    @if(session()->has('impersonator_id'))
        @php
            $impersonator = \App\Models\User::find(session('impersonator_id'));
            $currentUser = Auth::user();
        @endphp
        <aside aria-label="Notifikasi Mode Impersonasi" class="bg-gradient-to-r from-[#003B7E] via-[#0051A8] to-[#0064D2] text-white px-4 py-2.5 shadow-md border-b border-blue-300/30 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <span class="relative flex h-3 w-3 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FEDD00] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-[#FEDD00]"></span>
                    </span>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-black uppercase tracking-wider bg-[#FEDD00] px-2 py-0.5 rounded text-[10px] text-slate-900 shadow-sm">
                            MODE IMPERSONATE
                        </span>
                        <span class="text-blue-100">Login Sebagai:</span>
                        <span class="font-extrabold text-white bg-white/15 px-2 py-0.5 rounded border border-white/20">
                            {{ $currentUser?->name }} ({{ $currentUser?->email }})
                        </span>
                        @if($impersonator)
                            <span class="text-blue-200 text-[11px] hidden md:inline">
                                &bull; Superadmin Asli: <strong class="text-[#FEDD00] font-semibold">{{ $impersonator->name }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <form action="{{ route('admin.users.leave-impersonate') }}" method="POST" class="m-0 p-0 shrink-0 w-full sm:w-auto flex justify-center">
                    @csrf
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-1.5 rounded-xl bg-[#FEDD00] hover:bg-[#F5D300] text-slate-900 font-extrabold text-xs uppercase tracking-wider transition-all shadow-md shadow-amber-500/20 hover:scale-105 cursor-pointer"
                        title="Keluar dari akun staf ini dan kembali ke akun Superadmin"
                    >
                        <i data-lucide="arrow-left-circle" class="w-4 h-4 text-slate-900"></i>
                        <span>Kembali ke Superadmin</span>
                    </button>
                </form>
            </div>
        </aside>
    @endif

    @if (isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif

    <!-- Global Spotlight Search Modal -->
    @include('components.spotlight-search')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>

    <!-- Flatpickr JS & Locale Indonesia -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <!-- Auto-Logout Inactivity Guard (Modal & Timer Pelindung Akun) -->
    <x-inactivity-guard />

    @stack('scripts')
</body>
</html>
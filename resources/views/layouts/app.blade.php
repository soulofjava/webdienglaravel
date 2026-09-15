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

    <title>@yield('title', ($siteSettings->seo_title ?: ($siteSettings->site_name . ' — ' . ($siteSettings->site_tagline ?: 'Biro Wisata Dataran Tinggi Dieng'))))</title>
    
    <!-- Meta SEO Dasar -->
    <meta name="description" content="@yield('meta_description', ($siteSettings->seo_description ?: 'Biro perjalanan wisata resmi Dataran Tinggi Dieng. Nikmati keindahan Golden Sunrise Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, dan Jeep Safari.'))">
    <meta name="keywords" content="{{ $siteSettings->seo_keywords ?: 'paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir' }}">
    <meta name="author" content="Isa Maulana — {{ $siteSettings->site_name }}">
    <link rel="author" href="https://soulofjava.github.io/myportofolio/">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph (Facebook, WhatsApp, Telegram, LinkedIn) -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteSettings->site_name }}">
    <meta property="og:title" content="@yield('title', ($siteSettings->seo_title ?: $siteSettings->site_name))">
    <meta property="og:description" content="@yield('meta_description', ($siteSettings->seo_description ?: $siteSettings->site_tagline))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', ($siteSettings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($siteSettings->seo_title ?: $siteSettings->site_name))">
    <meta name="twitter:description" content="@yield('meta_description', ($siteSettings->seo_description ?: $siteSettings->site_tagline))">
    <meta name="twitter:image" content="@yield('og_image', ($siteSettings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop'))">

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

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            background-color: #07090e;
            color: #f1f5f9;
            overflow-x: hidden;
        }

        .glass-panel {
            background: rgba(12, 17, 29, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
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
            background: linear-gradient(90deg, rgba(255,255,255,0.02) 25%, rgba(255,255,255,0.09) 50%, rgba(255,255,255,0.02) 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.8s infinite ease-in-out;
        }
        @keyframes shimmerPulse {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Custom Flatpickr Dieng Dark Theme */
        .flatpickr-calendar {
            background: #0d1322 !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
            border-radius: 1.25rem !important;
            padding: 8px !important;
        }
        .flatpickr-calendar .flatpickr-month {
            background: transparent !important;
            color: #f8fafc !important;
            fill: #f59e0b !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: #fbbf24 !important;
            font-weight: 700 !important;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #f59e0b !important;
            border-color: #f59e0b !important;
            color: #090d16 !important;
            font-weight: 800 !important;
            border-radius: 0.75rem !important;
        }
        .flatpickr-day:hover {
            background: rgba(245, 158, 11, 0.25) !important;
            border-radius: 0.75rem !important;
        }
        .flatpickr-day.today {
            border-color: #f59e0b !important;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #07090e;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d97706;
        }
    </style>

    <!-- Flatpickr CSS (Dark theme) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    @stack('styles')
</head>
<body class="antialiased selection:bg-amber-500/30 selection:text-amber-200">
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

    @stack('scripts')
</body>
</html>

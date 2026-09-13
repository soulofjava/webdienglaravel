<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteSettings = \App\Models\SiteSetting::getSettings();
    @endphp

    <title>{{ $siteSettings->seo_title ?? ($siteSettings->site_name . ' — Biro Wisata Dataran Tinggi Dieng') }}</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="{{ $siteSettings->seo_description ?? 'Biro perjalanan wisata resmi Dataran Tinggi Dieng. Nikmati keindahan Golden Sunrise Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, dan Jeep Safari.' }}">
    <meta name="keywords" content="{{ $siteSettings->seo_keywords ?? 'paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir' }}">
    <meta name="author" content="{{ $siteSettings->site_name }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $siteSettings->seo_title ?? $siteSettings->site_name }}">
    <meta property="og:description" content="{{ $siteSettings->seo_description ?? $siteSettings->site_tagline }}">
    <meta property="og:image" content="{{ $siteSettings->og_image_url ?? 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon Dinamis -->
    <link rel="icon" href="{{ $siteSettings->favicon_url ?: asset('favicon.ico') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;900&family=Playfair+Display:ital,wght@0,500;0,700;0,900;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN dengan Custom Theme -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                        cinzel: ['"Cinzel"', 'serif'],
                    },
                    colors: {
                        dieng: {
                            dark: '#07090e',
                            card: '#0c111d',
                            border: 'rgba(255, 255, 255, 0.08)',
                            gold: '#fbbf24',
                            emerald: '#10b981',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>

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
</head>
<body class="antialiased selection:bg-amber-500/30 selection:text-amber-200">
    @if (isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

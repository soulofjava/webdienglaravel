@extends('layouts.app')

@section('schema_json')
@php
    $homeSchemaData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '/#website',
                'url' => url('/'),
                'name' => $settings->site_name,
                'description' => $settings->site_tagline,
                'inLanguage' => 'id-ID',
            ],
            [
                '@type' => 'TravelAgency',
                '@id' => url('/') . '/#agency',
                'name' => $settings->site_name,
                'url' => url('/'),
                'logo' => $settings->favicon_url ?: asset('favicon.ico'),
                'image' => $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
                'description' => $settings->seo_description ?: $settings->site_tagline,
                'telephone' => $settings->phone_number,
                'priceRange' => 'Rp 325.000 - Rp 1.500.000',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $settings->address,
                    'addressLocality' => 'Wonosobo',
                    'addressRegion' => 'Jawa Tengah',
                    'postalCode' => '56354',
                    'addressCountry' => 'ID',
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => -7.2056,
                    'longitude' => 109.9078,
                ],
                'areaServed' => [
                    '@type' => 'AdministrativeArea',
                    'name' => 'Dataran Tinggi Dieng',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($homeSchemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
<main class="relative min-h-screen bg-[#07090e] text-slate-100 overflow-hidden">

    <!-- 1. FLOATING ATMOSPHERIC NAVIGATION -->
    <header id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div id="navContainer" class="max-w-7xl mx-auto rounded-2xl transition-all duration-500 bg-black/30 backdrop-blur-md py-4 px-5 sm:px-8 border border-white/5">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-tiketdieng-transparent.png') }}?v=2" alt="{{ $settings->site_name }}" class="h-8 sm:h-9 w-auto object-contain brightness-110 drop-shadow">
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-300">
                    <a href="#scrollytelling" class="hover:text-amber-400 transition-colors">Jelajah Cerita</a>
                    <a href="#paket" class="hover:text-amber-400 transition-colors">Paket Wisata</a>
                    <a href="#dokumentasi" class="hover:text-amber-400 transition-colors">Dokumentasi</a>
                    <a href="#profil" class="hover:text-amber-400 transition-colors">Tentang Kami</a>
                    <a href="#kalkulator" class="hover:text-amber-400 transition-colors">Kalkulator Biaya</a>
                </nav>

                <!-- Right Section: Search & CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Tombol Spotlight Search Desktop -->
                    <button 
                        type="button"
                        onclick="window.openSpotlightSearch()"
                        class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/40 text-xs text-slate-300 hover:text-white transition-all group cursor-pointer"
                        title="Pencarian Cepat Paket Wisata (Ctrl+K)"
                    >
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                        <span class="text-[11px] text-slate-400 group-hover:text-slate-200">Cari paket...</span>
                        <kbd class="inline-flex items-center px-1.5 py-0.5 text-[9px] font-mono text-slate-400 bg-white/5 rounded border border-white/10">⌘K</kbd>
                    </button>

                    <!-- CTA Button -->
                    <a href="#kalkulator" class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <span>Pesan Tiket</span>
                    </a>
                </div>

                <!-- Mobile Actions (Search & Hamburger) -->
                <div class="flex items-center gap-2 md:hidden">
                    <button 
                        type="button" 
                        onclick="window.openSpotlightSearch()"
                        class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-200 hover:text-amber-400 hover:bg-white/10 transition-colors"
                        aria-label="Cari Paket"
                    >
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                    <button id="mobileMenuBtn" class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-200 hover:bg-white/10 transition-colors" aria-label="Buka Menu">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div id="mobileMenu" class="hidden md:hidden pt-4 pb-2 border-t border-white/10 mt-3 flex flex-col gap-3">
                <button type="button" onclick="window.openSpotlightSearch(); document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2 text-sm py-1.5 text-slate-300 hover:text-amber-400 text-left">
                    <i data-lucide="search" class="w-4 h-4 text-amber-400"></i>
                    <span>Cari Paket & Destinasi (Pencarian Cepat)</span>
                </button>
                <a href="#scrollytelling" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Jelajah Cerita Dieng</a>
                <a href="#paket" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Paket Wisata All-Inclusive</a>
                <a href="#dokumentasi" class="text-sm py-1.5 text-slate-300 hover:text-cyan-400 flex items-center gap-2">
                    <i data-lucide="camera" class="w-4 h-4 text-cyan-400"></i>
                    <span>Jasa Dokumentasi & Drone (Lotus Creative)</span>
                </a>
                <a href="#profil" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Tentang Kami & Visi Misi</a>
                <a href="#kalkulator" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Kalkulator Reservasi</a>
                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="w-full text-center block px-4 py-2.5 rounded-xl text-xs font-bold text-black bg-amber-400">
                        Chat WhatsApp Resmi
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. HERO PARALLAX SINEMATIK: GOLDEN DAWN SIKUNIR -->
    <section class="relative min-h-[110vh] w-full overflow-hidden bg-gradient-to-b from-[#060911] via-[#0d1527] to-[#07090e] flex items-center justify-center pt-20">
        <!-- Sky Atmosphere Glow -->
        <div class="absolute inset-0 z-0 opacity-40 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(245,158,11,0.25),rgba(255,255,255,0))]"></div>

        <!-- Rising Golden Sun (Sikunir Dawn) -->
        <div class="absolute top-[18%] left-1/2 -translate-x-1/2 w-72 h-72 sm:w-96 sm:h-96 rounded-full bg-gradient-to-t from-amber-500 via-orange-400 to-yellow-200 blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute top-[28%] left-1/2 -translate-x-1/2 w-40 h-40 sm:w-56 sm:h-56 rounded-full bg-gradient-to-b from-amber-100 via-amber-300 to-orange-500 shadow-[0_0_90px_rgba(245,158,11,0.7)] pointer-events-none flex items-center justify-center opacity-90 animate-pulse-slow"></div>

        <!-- Siluet Gunung Sindoro & Sumbing -->
        <div class="absolute bottom-0 left-0 right-0 h-[60%] pointer-events-none opacity-40">
            <svg viewBox="0 0 1440 600" fill="none" class="w-full h-full object-cover" preserveAspectRatio="none">
                <path d="M0 600L180 320L340 440L600 160L820 400L1080 220L1260 380L1440 300V600H0Z" fill="url(#mountainGradBack)" />
                <defs>
                    <linearGradient id="mountainGradBack" x1="720" y1="160" x2="720" y2="600" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#283553" />
                        <stop offset="1" stop-color="#080c16" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Siluet Puncak Dekat Bukit Sikunir & Prau -->
        <div class="absolute bottom-0 left-0 right-0 h-[48%] pointer-events-none">
            <svg viewBox="0 0 1440 500" fill="none" class="w-full h-full object-cover opacity-80" preserveAspectRatio="none">
                <path d="M0 500L220 280L420 380L700 210L940 360L1200 190L1440 340V500H0Z" fill="url(#mountainGradMid)" />
                <defs>
                    <linearGradient id="mountainGradMid" x1="720" y1="190" x2="720" y2="500" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#1a253a" />
                        <stop offset="1" stop-color="#07090e" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Kabut Mengambang -->
        <div class="absolute bottom-0 left-0 right-0 h-80 pointer-events-none">
            <div class="w-full h-full bg-gradient-to-t from-[#07090e] via-[#0b1424]/70 to-transparent blur-xl"></div>
        </div>

        <!-- Editorial Hero Content -->
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <!-- Top Badges: Badan Usaha Resmi, HPI License & Live Dieng Atmosphere -->
            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3.5 mb-6">
                <!-- Badge Badan Usaha Resmi PT. GOTRIP ASIA TRAVELINDO -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold tracking-wider uppercase shadow-lg shadow-amber-500/10">
                    <i data-lucide="building-2" class="w-4 h-4 text-amber-400"></i>
                    <span>{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</span>
                    <span class="text-[10px] text-slate-400 border-l border-white/15 pl-2 font-normal hidden sm:inline capitalize">Akomodasi & Transportasi Wisata</span>
                </div>

                <!-- Badge Resmi HPI -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-xs font-semibold tracking-wider uppercase shadow-lg shadow-emerald-500/10">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>{{ $settings->hpi_badge ?? 'Biro Wisata Resmi Berizin HPI' }}</span>
                </div>

                <!-- Live Weather Dieng Atmospheric Pill -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full glass-panel border border-sky-400/25 bg-sky-950/20 text-slate-200 text-xs shadow-lg shadow-sky-500/5 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <i data-lucide="cloud-sun" class="w-4 h-4 text-sky-400"></i>
                    <span class="text-slate-300">
                        Live Dieng: <strong class="text-white font-bold tracking-tight" id="diengTemp">18°C</strong> • <span id="diengCondition" class="text-sky-300 font-medium">Cerah Sejuk</span>
                    </span>
                    <span class="hidden sm:inline text-[10px] text-slate-400 border-l border-white/10 pl-2">2.093 mdpl</span>
                </div>
            </div>

            <!-- Title Sinematik -->
            <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-[1.1] max-w-4xl drop-shadow-2xl">
                Menyaksikan Mahakarya <br />
                <span class="bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-500 bg-clip-text text-transparent">
                    Fajar Emas di Atas Awan
                </span>
            </h1>

            <p class="mt-6 text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl font-light leading-relaxed drop-shadow">
                Jelajahi keajaiban vulkanik purba, samudra awan Sikunir 2.463 mdpl, telaga warna berkilau, dan petualangan jip offroad dengan standar kenyamanan VIP.
            </p>

            <!-- Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center gap-4">
                <a href="#kalkulator" class="w-full sm:w-auto px-8 py-4 rounded-full text-xs sm:text-sm font-bold tracking-wider uppercase text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-xl shadow-amber-500/30 hover:scale-105 flex items-center justify-center gap-2.5">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Rencanakan Perjalanan</span>
                </a>
                <a href="#scrollytelling" class="w-full sm:w-auto px-8 py-4 rounded-full text-xs sm:text-sm font-semibold tracking-wider text-white glass-panel hover:bg-white/10 transition-all duration-300 border border-white/20 flex items-center justify-center gap-2">
                    <i data-lucide="compass" class="w-4 h-4 text-amber-400"></i>
                    <span>Eksplorasi Cerita</span>
                </a>
            </div>

            <!-- Mini Trust Badges -->
            <div class="mt-14 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8 pt-8 border-t border-white/10 text-slate-400 text-xs">
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="mountain" class="w-4 h-4 text-amber-400"></i>
                    <span>Ketinggian 2.000+ mdpl</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="sun" class="w-4 h-4 text-amber-400"></i>
                    <span>Golden Sunrise Sikunir</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                    <span>Pemandu Berlisensi HPI</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="map-pin" class="w-4 h-4 text-amber-400"></i>
                    <span>Armada Antar-Jemput VIP</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SCROLLYTELLING: CERITA SINEMATIK 5 BABAK DIAENG -->
    <section id="scrollytelling" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Jelajah Cerita Magis</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-black text-white mt-2 mb-4">
                5 Babak Keajaiban Dataran Tinggi Para Dewa
            </h2>
            <p class="text-xs sm:text-sm text-slate-400">
                Setiap sudut Dieng menyimpan rahasia geologi purba dan spiritualitas yang memikat hati.
            </p>
        </div>

        <div class="space-y-24">
            <!-- Babak 1: Sikunir -->
            <div id="sikunir" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 border border-amber-500/30 text-amber-300">
                        <i data-lucide="sunrise" class="w-4 h-4 text-amber-400"></i>
                        <span>BAB 01 • 2.463 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Matahari Pertama di Puncak Sikunir</h3>
                    <p class="text-xs text-amber-300 italic">“Ketika fajar menyingsing di Sikunir, samudra awan di bawah Anda menjelma emas murni.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Dari bibir puncak Bukit Sikunir di Desa Sembungan (desa tertinggi di Pulau Jawa), Anda akan menyaksikan fajar keemasan perlahan menembus lautan awan dengan latar belakang siluet megah delapan puncak gunung legendaris Jawa Tengah.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Pendakian santai 30–40 menit dengan anak tangga rapi</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Panorama 360° Gunung Sindoro, Sumbing, Merbabu, Merapi</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Hangatnya teh purwaceng khas desa tertinggi</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=75" alt="Sikunir Sunrise" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>

            <!-- Babak 2: Kawah Sikidang -->
            <div id="sikidang" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10 order-2 lg:order-1">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=75" alt="Kawah Sikidang" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                <div class="lg:col-span-6 space-y-5 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/10 border border-yellow-500/30 text-yellow-300">
                        <i data-lucide="flame" class="w-4 h-4 text-yellow-400"></i>
                        <span>BAB 02 • 2.050 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Napas Hangat Sang Hyang di Kawah Sikidang</h3>
                    <p class="text-xs text-yellow-300 italic">“Di sini, Anda dapat mendengar gemuruh magma bumi yang hidup dan kepulan uap belerang.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Dinamakan 'Sikidang' karena letak kawah utamanya yang kerap berpindah tempat menyerupai lompatan kijang. Berjalan di atas jembatan kayu estetik sepanjang satu kilometer membelah kepulan kabut sulfur putih menghadirkan lanskap megah layaknya dataran purba.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Jembatan kayu ikonik yang membelah tanah vulkanik</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Pengalaman merebus telur di dalam kawah alami</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Wahana ATV & spot foto eksotis di dataran belerang</li>
                    </ul>
                </div>
            </div>

            <!-- Babak 3: Telaga Warna & Pengilon -->
            <div id="telagawarna" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 border border-emerald-500/30 text-emerald-300">
                        <i data-lucide="droplets" class="w-4 h-4 text-emerald-400"></i>
                        <span>BAB 03 • 2.000 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Simfoni Zamrud di Telaga Warna & Pengilon</h3>
                    <p class="text-xs text-emerald-300 italic">“Dua danau berdampingan dengan warna air toska berkilau dan cermin jernih alami.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Kandungan mineral sulfur yang tinggi membiaskan spektrum warna hijau toska, toska pekat, hingga keemasan saat terkena sinar matahari. Dikelilingi rimbunnya hutan cemara gunung dan gua-gua pertapaan bersejarah.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Panorama dua danau dari Batu Pandang Ratapan Angin</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Gua Semar, Gua Jaran, dan Gua Sumur penuh sejarah mistis</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Jalur trekking rindang di bawah kanopi cemara gunung</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=75" alt="Telaga Warna" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>

            <!-- Babak 4: Kompleks Candi Arjuna -->
            <div id="candi-arjuna" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10 order-2 lg:order-1">
                    <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=75" alt="Candi Arjuna" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                <div class="lg:col-span-6 space-y-5 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-purple-500/10 border border-purple-500/30 text-purple-300">
                        <i data-lucide="landmark" class="w-4 h-4 text-purple-400"></i>
                        <span>BAB 04 • 2.093 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Jejak Peradaban Suci di Lembah Arjuna</h3>
                    <p class="text-xs text-purple-300 italic">“Percandian Hindu tertua di Jawa dari abad ke-7 yang berdiri kokoh berpagar kabut.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Lima mahakarya batu candi (Arjuna, Semar, Srikandi, Puntadewa, dan Sembadra) menjadi saksi bisu ritual sakral pemotongan rambut gimbal anak-anak Dieng dalam tradisi Dieng Culture Festival.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Fenomena kristal es 'Embun Upas' saat musim dingin (Juli–Agustus)</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Arsitektur batu andesit purba dengan relief relief Dewa Siwa</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Padang rumput hijau menyejukkan di pelataran percandian</li>
                    </ul>
                </div>
            </div>

            <!-- Babak 5: Safari Jip 4x4 -->
            <div id="jeep" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 border border-rose-500/30 text-rose-300">
                        <i data-lucide="compass" class="w-4 h-4 text-rose-400"></i>
                        <span>BAB 05 • ADRENALIN 4X4</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Safari Jip 4x4 Melintasi Hutan & Savana</h3>
                    <p class="text-xs text-rose-300 italic">“Rasakan denyut petualangan melewati jalur bebatuan, kebun teh, hingga danau tersembunyi.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Armada Jeep 4x4 tangguh siap membawa Anda ke destinasi yang tak terjangkau kendaraan biasa: Telaga Dringo (Ranu Kumbolo-nya Jawa Tengah), perkebunan teh Bedakah, dan Savana Lembah Pangonan.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Unit Jeep 4x4 berspesifikasi offroad dengan driver terlatih</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Rute fleksibel (Short, Medium, & Long Safari Trip)</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Sesi pemotretan estetik di atas kap mesin berlatar pegunungan</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=75" alt="Safari Jip 4x4" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PAKET WISATA UNGGULAN ALL-INCLUSIVE -->
    <section id="paket" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Pilihan Paket Wisata Resmi</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-4">Pilihan Paket Wisata Dieng</h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Seluruh program bersifat fleksibel (private tour). Tarif tertera adalah estimasi dasar <span class="text-amber-400 font-medium">mulai dari</span>; ketersediaan kamar homestay, tanggal keberangkatan, dan penyesuaian rute dilayani langsung oleh tim kami via WhatsApp.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($packages as $pkg)
                <div class="glass-panel p-6 rounded-3xl border {{ $pkg->is_popular ? 'border-2 border-amber-400/80 shadow-2xl shadow-amber-500/10' : 'border-white/10' }} flex flex-col justify-between hover:border-amber-400/60 transition-all duration-300 relative group">
                    @if ($pkg->is_popular || $pkg->badge)
                        <div class="absolute -top-3.5 left-6 px-3 py-0.5 rounded-full text-[10px] font-black uppercase {{ $pkg->is_popular ? 'bg-amber-400 text-slate-950' : 'bg-emerald-400 text-slate-950' }} shadow-md">
                            {{ $pkg->badge ?: 'PALING DIMINATI ★' }}
                        </div>
                    @endif

                    <div>
                        <!-- Thumbnail Cover with Skeleton Loader -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10] mb-4 border border-white/5 bg-slate-900 skeleton-shimmer">
                            <img
                                src="{{ $pkg->image_url }}"
                                alt="{{ $pkg->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 opacity-0"
                                loading="lazy"
                                decoding="async"
                                onload="this.classList.remove('opacity-0'); this.parentElement.classList.remove('skeleton-shimmer');"
                            />
                            <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] text-amber-300 font-semibold border border-white/10">
                                {{ $pkg->duration }}
                            </div>
                        </div>

                        <span class="text-[10px] font-bold text-amber-400 tracking-wider uppercase block">
                            {{ $pkg->category }}
                        </span>
                        <h3 class="font-bold text-lg text-white mt-1 group-hover:text-amber-300 transition-colors line-clamp-1">
                            <a href="{{ route('package.detail', $pkg->slug) }}">
                                {{ $pkg->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                            {{ $pkg->summary }}
                        </p>

                        <!-- Estimasi Tarif Mulai Dari -->
                        <div class="my-4 pt-3 border-t border-white/10">
                            <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider block">Mulai Dari</span>
                            <div class="text-2xl font-extrabold text-amber-400">
                                {{ $pkg->formatted_price }}
                                <span class="text-xs text-slate-400 font-normal">/ pax</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block mt-0.5">{{ $pkg->price_note }} • Konfirmasi homestay via WA</span>
                        </div>

                        <!-- Highlight Destinasi / Rute -->
                        @if (!empty($pkg->itinerary_options) && count($pkg->itinerary_options) > 0)
                            <div class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                <div class="text-[10px] font-semibold text-slate-400 uppercase">Pilihan Rute & Destinasi:</div>
                                @foreach (array_slice($pkg->itinerary_options, 0, 2) as $opt)
                                    <div class="flex items-start gap-1.5 text-[11px] text-slate-300">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                                        <span class="line-clamp-1 font-medium">{{ $opt['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif (!empty($pkg->inclusions) && count($pkg->inclusions) > 0)
                            <ul class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                @foreach (array_slice($pkg->inclusions, 0, 3) as $inc)
                                    <li class="flex items-center gap-1.5 text-[11px]">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 flex-shrink-0"></i>
                                        <span class="line-clamp-1">{{ $inc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a
                            href="{{ route('package.detail', $pkg->slug) }}"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-white bg-white/10 hover:bg-white/20 border border-white/10 transition-colors flex items-center justify-center gap-1"
                        >
                            <span>Detail Rute</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>

                        <a
                            href="#kalkulator"
                            onclick="selectPackageInCalculator('{{ $pkg->slug }}')"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-400 transition-all flex items-center justify-center gap-1"
                        >
                            <span>Hitung / Tanya WA</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 glass-panel rounded-3xl border border-white/10 text-slate-400 text-sm">
                    Belum ada paket wisata aktif. Silakan tambahkan melalui panel pengelola admin.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. STANDAR LAYANAN VIP (WHY US) -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Mengapa Memilih {{ $settings->site_name }}?</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-4">Standar Layanan Wisata Kelas VIP</h2>
            <p class="text-xs sm:text-sm text-slate-400">Kami mendefinisikan kembali kenyamanan berwisata di Dieng dengan keaslian narasi lokal dan fasilitas prima.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. LIVE VIDEO CALL INSPECTION (FITUR UNGGULAN KLIEN) -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-amber-500/30 bg-amber-500/5 hover:border-amber-500/50 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center mb-5 text-amber-400">
                    <i data-lucide="video" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 text-[10px] font-bold uppercase tracking-wider mb-2">Transparansi 100%</div>
                <h3 class="font-bold text-base text-white mb-2">Cek Penginapan via Video Call</h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">Satu-satunya biro wisata yang memberikan fasilitas pemilihan transportasi dan akomodasi langsung via Live Video Call ke lokasi sebelum Anda memutuskan booking.</p>
            </div>

            <!-- 2. LEGALITAS RESMI PT GOTRIP ASIA -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center mb-5 text-emerald-400">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 text-[10px] font-bold uppercase tracking-wider mb-2">Legalitas Hukum NIB</div>
                <h3 class="font-bold text-base text-white mb-2">PT. GOTRIP ASIA TRAVELINDO</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Berbadan hukum resmi terdaftar dengan izin NIB dan rekening operasional perusahaan BNI Cabang Wonosobo. Bebas dari penipuan travel bodong.</p>
            </div>

            <!-- 3. CREW ASLI LOKAL BERLISENSI HPI -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center mb-5 text-purple-400">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-purple-500/20 text-purple-300 text-[10px] font-bold uppercase tracking-wider mb-2">Lisensi Resmi HPI</div>
                <h3 class="font-bold text-base text-white mb-2">Pemandu Lokal Berpengalaman</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Seluruh tim adalah putra daerah Dieng berlisensi resmi HPI yang ramah, memahami sudut foto terbaik, serta menguasai sejarah geologi purba candi Dieng.</p>
            </div>

            <!-- 4. VENDOR ARMADA RESMI (JEEP & SHUTTLE) -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-sky-500/10 flex items-center justify-center mb-5 text-sky-400">
                    <i data-lucide="car" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 text-[10px] font-bold uppercase tracking-wider mb-2">Vendor Langsung</div>
                <h3 class="font-bold text-base text-white mb-2">Armada Jeep & Shuttle 15 Seat</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Vendor langsung unit Jeep 4x4 (Feroza/Katana) dan Shuttle Bis Wisata kapasitas 15 penumpang ber-AC. Tanpa perantara calo dengan tarif resmi 2026.</p>
            </div>

            <!-- 5. KONSULTASI ITINERARY BEBAS SAMPAI JADI -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center mb-5 text-orange-400">
                    <i data-lucide="map" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-orange-500/20 text-orange-300 text-[10px] font-bold uppercase tracking-wider mb-2">Custom Itinerary</div>
                <h3 class="font-bold text-base text-white mb-2">Penyusunan Rute Fleksibel</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Layanan konsultasi gratis untuk menyusun jadwal perjalanan, menghitung simulasi anggaran rombongan, dan memilih destinasi terbaik sesuai minat Anda.</p>
            </div>

            <!-- 6. DOKUMENTASI PRO & DRONE 4K -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center mb-5 text-rose-400">
                    <i data-lucide="camera" class="w-6 h-6"></i>
                </div>
                <div class="inline-block px-2 py-0.5 rounded bg-rose-500/20 text-rose-300 text-[10px] font-bold uppercase tracking-wider mb-2">Dokumentasi Estetik</div>
                <h3 class="font-bold text-base text-white mb-2">Kamera Mirrorless & Drone 4K</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Tersedia layanan fotografer dan pilot drone profesional. Hasil foto yang di-grading estetik dan video cinematic reels yang siap posting di media sosial.</p>
            </div>
        </div>
    </section>

    <!-- 6. PROFIL PERUSAHAAN, VISI & MISI (COMPANY PROFILE & DEDICATION) -->
    <section id="profil" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold tracking-widest text-amber-400 uppercase bg-amber-500/10 border border-amber-500/20 mb-3">
                <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                <span>TENTANG KAMI & DEDIKASI KAMI</span>
            </div>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">Visi & Komitmen Perjalanan Dieng</h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                Mengenal lebih dekat dedikasi {{ $settings->site_name }} di bawah legalitas resmi <strong class="text-slate-200">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong> dalam menghadirkan pengalaman berwisata aman, transparan, dan berkesan di Dataran Tinggi Dieng.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Kolom Kiri: Profil & Sejarah Singkat (7 Kolom di Desktop) -->
            <div class="lg:col-span-7 glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between relative overflow-hidden group hover:border-white/20 transition-all duration-300">
                <!-- Ambient Glow Dekorasi -->
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-6 relative z-10">
                    <!-- Badges Header -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-amber-500/15 text-amber-300 border border-amber-500/30 flex items-center gap-1.5">
                            <i data-lucide="history" class="w-3.5 h-3.5"></i>
                            <span>Berdiri Sejak 2022</span>
                        </span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>{{ $settings->legal_nib ?? 'Legalitas NIB Resmi' }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-sky-300 bg-sky-500/10 border border-sky-500/20 flex items-center gap-1.5">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            <span>{{ $settings->hpi_badge ?? 'Vendor Resmi HPI Dieng' }}</span>
                        </span>
                    </div>

                    <!-- Judul Profil -->
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-slate-400 block mb-1">Profil & Sejarah Singkat</span>
                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white tracking-wide">
                            {{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-400/90 font-medium mt-1">
                            Unit Pengelola & Pemasaran Resmi Wisata Dieng
                        </p>
                    </div>

                    <!-- Narasi Tentang Kami & Sejarah (Dinamis dari Database) -->
                    <div class="space-y-4 text-xs sm:text-sm text-slate-300 leading-relaxed">
                        <p class="text-slate-300">
                            {{ $settings->about_us ?? 'Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng yang siap membantu Anda dalam menyusun itinerary eksklusif, menghitung simulasi anggaran transparan, dan merealisasikan liburan impian yang aman dan berkesan di Dataran Tinggi Dieng.' }}
                        </p>
                        <p class="text-slate-400 text-xs sm:text-[13px] border-l-2 border-amber-500/40 pl-4 py-1 italic bg-white/[0.01] rounded-r-xl">
                            {{ $settings->company_history ?? 'Tiket Wisata Dieng berdiri sejak tahun 2022 sebagai anak perusahaan di bawah naungan PT. GOtrip Asia Travelindo Wonosobo guna mempermudah pelayanan menyeluruh wisatawan di Dataran Tinggi Dieng.' }}
                        </p>
                    </div>

                    <!-- Lingkup Layanan Lengkap -->
                    <div class="pt-4 border-t border-white/10">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-3">Layanan & Fasilitas Terpadu:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach([
                                'Akomodasi & Homestay Dieng',
                                'Transportasi Shuttle & Bus',
                                'Sewa Jeep Wisata 4x4',
                                'Pemandu Lokal Berlisensi HPI',
                                'Dokumentasi Kamera & Drone 4K',
                                'Paket Makan & Kuliner Khas',
                                'Outbound & Gathering Perusahaan',
                                'Rafting Serayu & Paralayang'
                            ] as $layanan)
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-white/5 border border-white/10 text-slate-300 hover:border-amber-500/40 hover:text-white transition-colors">
                                    ✓ {{ $layanan }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer Card Lokasi & Rekening -->
                <div class="mt-6 pt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400 relative z-10">
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-rose-400 flex-shrink-0"></i>
                        <span class="line-clamp-1">{{ $settings->address }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>{{ $settings->bank_name ?? 'BNI Wonosobo' }} (Rekening Resmi PT)</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Visi & Misi (5 Kolom di Desktop) -->
            <div class="lg:col-span-5 flex flex-col gap-6 justify-between">
                <!-- Kartu Visi Perusahaan -->
                <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-amber-500/30 bg-gradient-to-br from-amber-500/[0.07] via-white/[0.02] to-transparent relative overflow-hidden group hover:border-amber-500/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 flex-shrink-0 shadow-lg shadow-amber-500/10">
                            <i data-lucide="eye" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-bold tracking-widest text-amber-400 uppercase block">Tujuan Jangka Panjang</span>
                            <h4 class="font-serif text-lg font-bold text-white">Visi Perusahaan</h4>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        "{{ $settings->company_vision ?? 'Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman, transparan, dan terpercaya bagi seluruh wisatawan.' }}"
                    </p>
                </div>

                <!-- Kartu Misi Perusahaan -->
                <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-500/[0.07] via-white/[0.02] to-transparent relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 flex-shrink-0 shadow-lg shadow-emerald-500/10">
                            <i data-lucide="target" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-bold tracking-widest text-emerald-400 uppercase block">Komitmen Layanan</span>
                            <h4 class="font-serif text-lg font-bold text-white">Misi Perusahaan</h4>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        "{{ $settings->company_mission ?? 'Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo Wonosobo, kami berkomitmen untuk meningkatkan kepercayaan klien dan mempermudah dalam merencanakan sampai membantu terealisasinya liburan terbaik Anda ke Dieng.' }}"
                    </p>
                </div>

                <!-- Kartu Garansi & Kemitraan -->
                <div class="glass-panel p-5 rounded-2xl border border-white/10 bg-white/[0.02] flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/15 flex items-center justify-center text-sky-400 flex-shrink-0">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs">
                        <h5 class="font-bold text-white">Jaminan Keamanan & Kenyamanan</h5>
                        <p class="text-slate-400 text-[11px] mt-0.5">Seluruh pemesanan tercatat resmi di sistem kami dan dilindungi garansi operasional PT. GOtrip Asia Travelindo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. JASA DOKUMENTASI SINEMATIK & DRONE 4K (OFFICIAL PARTNER: LOTUS CREATIVE) -->
    <section id="dokumentasi" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20 relative">
        <!-- Glow Dekorasi Khas Lotus Creative (Cyan & Rose) -->
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header Section Dokumentasi -->
        <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Logo Lotus Creative" class="w-14 h-14 sm:w-16 sm:h-16 object-contain rounded-2xl bg-black/50 border border-white/15 p-2 shadow-xl shadow-cyan-500/20 hover:scale-105 transition-transform duration-300">
                <div class="text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] font-bold tracking-widest uppercase bg-gradient-to-r from-cyan-500/20 to-rose-500/20 text-cyan-300 border border-cyan-500/30">
                        <i data-lucide="camera" class="w-3 h-3 text-cyan-400"></i>
                        <span>OFFICIAL PHOTOGRAPHY & DRONE PARTNER</span>
                    </span>
                    <h3 class="font-bold text-sm sm:text-base text-white mt-1">LOTUS CREATIVE</h3>
                    <p class="text-[11px] text-slate-400">Travel Photography & Aerial Videography Dieng</p>
                </div>
            </div>

            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">
                Abadikan Momen Sinematik di Tanah Dieng
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-2xl mx-auto">
                Kolaborasi resmi <strong class="text-white">TiketDieng.com</strong> bersama vendor dokumentasi profesional <strong class="text-cyan-300">Lotus Creative</strong>. Dapatkan potret visual memukau, rekaman udara drone 4K, serta video reels estetik yang siap diunggah ke media sosial Anda.
            </p>

            <!-- Mini Hub Kontak Lotus Creative -->
            <div class="flex flex-wrap items-center justify-center gap-3 mt-6 text-xs text-slate-300">
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span>Studio: Jl. Dieng KM 18 Tieng, Kejajar, Wonosobo</span>
                </div>
                <a href="https://wa.me/628164211196" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 hover:text-white transition-colors">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>WA Studio: 0816-4211-196</span>
                </a>
                <a href="https://www.instagram.com/lotus.creative01?stnk=dG83cjF1NHptaXB3" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-500/10 hover:bg-pink-500/20 border border-pink-500/30 text-pink-300 hover:text-white transition-colors">
                    <i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-400"></i>
                    <span>@lotus.creative01</span>
                </a>
                <a href="https://www.tiktok.com/@lotuscreative_?_r=1&_t=ZS-99iFr2JbCcc" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white transition-colors">
                    <i data-lucide="video" class="w-3.5 h-3.5 text-cyan-400"></i>
                    <span>@lotuscreative_</span>
                </a>
            </div>
        </div>

        <!-- Grid 5 Kartu Paket Dokumentasi Lotus Creative -->
        @if(isset($docPackages) && $docPackages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10 items-stretch mb-16">
                @foreach($docPackages as $doc)
                    <div class="glass-panel rounded-3xl p-6 sm:p-7 border flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden {{ $loop->first ? 'border-cyan-500/40 bg-gradient-to-b from-cyan-500/[0.08] via-white/[0.02] to-transparent lg:col-span-1 shadow-xl shadow-cyan-500/10' : 'border-white/10 hover:border-white/20' }}">
                        
                        @if($loop->first)
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl pointer-events-none"></div>
                        @endif

                        <div class="space-y-4">
                            <!-- Top Tag & Durasi -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $loop->first ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 'bg-white/10 text-amber-300 border border-white/10' }}">
                                    {{ $doc->badge ?? 'Lotus Creative' }}
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                    <span>{{ $doc->duration }}</span>
                                </span>
                            </div>

                            <!-- Judul & Deskripsi Singkat -->
                            <div>
                                <h3 class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                                    {{ $doc->title }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed line-clamp-2">
                                    {{ $doc->summary }}
                                </p>
                            </div>

                            <!-- Harga Resmi Paket -->
                            <div class="p-3.5 rounded-2xl bg-white/[0.03] border border-white/5">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Tarif Layanan Resmi</span>
                                <div class="flex items-baseline gap-1.5 mt-0.5">
                                    <span class="text-2xl sm:text-3xl font-extrabold text-white font-mono">Rp {{ number_format($doc->price, 0, ',', '.') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $doc->price_note ?? '/ sesi' }}</span>
                                </div>
                            </div>

                            <!-- Destinasi Wisata yang Dicakup -->
                            <div>
                                <span class="text-[11px] font-semibold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-cyan-400"></i>
                                    <span>Rute / Objek Wisata:</span>
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @if(is_array($doc->itinerary_options))
                                        @foreach($doc->itinerary_options as $spot)
                                            <span class="px-2 py-0.5 rounded-md bg-white/5 border border-white/10 text-[10px] text-slate-300">
                                                {{ is_array($spot) ? ($spot['destinations'] ?? ($spot['name'] ?? '')) : $spot }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Fasilitas Include Utama -->
                            <div class="pt-3 border-t border-white/10">
                                <span class="text-[11px] font-semibold text-slate-300 uppercase tracking-wider block mb-2">Termasuk (Include):</span>
                                <ul class="space-y-1.5 text-xs text-slate-300">
                                    @if(is_array($doc->inclusions))
                                        @foreach(array_slice($doc->inclusions, 0, 4) as $inc)
                                            <li class="flex items-start gap-2 text-[11px] leading-tight text-slate-300">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5"></i>
                                                <span>{{ is_array($inc) ? ($inc['title'] ?? ($inc['description'] ?? '')) : $inc }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Tombol Pesan via WhatsApp -->
                        <div class="pt-5 mt-4 border-t border-white/10">
                            @php
                                $waMessage = "Halo Lotus Creative & TiketDieng, saya tertarik untuk booking *" . $doc->title . "* dengan tarif Rp " . number_format($doc->price, 0, ',', '.') . ". Mohon informasi ketersediaan jadwal fotografer untuk rencana trip saya.";
                                $waUrl = "https://wa.me/628164211196?text=" . urlencode($waMessage);
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition-all duration-300 {{ $loop->first ? 'text-black bg-gradient-to-r from-cyan-400 to-teal-400 hover:from-cyan-300 hover:to-teal-300 shadow-lg shadow-cyan-500/20' : 'text-white bg-white/10 hover:bg-white/20 border border-white/15' }}">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>Reservasi Jadwal Foto</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- 4 Pilar Keunggulan Lotus Creative -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 relative z-10">
            <div class="text-center max-w-xl mx-auto mb-8">
                <span class="text-[10px] font-bold tracking-widest uppercase text-cyan-400 block mb-1">STANDAR KUALITAS TINGGI</span>
                <h3 class="font-serif text-xl sm:text-2xl font-bold text-white">Mengapa Memilih Dokumentasi Lotus Creative?</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/15 flex items-center justify-center text-cyan-400 mb-3">
                        <i data-lucide="camera" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Kamera Standar Industri</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Penggunaan kamera mirrorless/DSLR modern dengan variasi lensa potret dan pencahayaan flash profesional.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-rose-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center text-rose-400 mb-3">
                        <i data-lucide="video" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Rekaman Udara Drone 4K</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Perspektif aerial dramatis memperlihatkan kemegahan lanskap lautan awan, kawah vulkanik, dan telaga Dieng.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-amber-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center text-amber-400 mb-3">
                        <i data-lucide="film" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Unlimited RAW & Reels</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Seluruh file mentah tanpa batas diserahkan, ditambah bonus video pendek sinematik yang siap posting di TikTok/Instagram.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-emerald-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 mb-3">
                        <i data-lucide="sun" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Pemandu Sudut Fajar</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Fotografer asli Dieng yang memahami titik terbaik matahari terbit dan jam masuknya cahaya keemasan (*golden hour*).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. SMART BOOKING CALCULATOR & SIMULATOR HARGA INTERAKTIF -->
    <section id="kalkulator" class="py-24 sm:py-32 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="relative rounded-3xl p-6 sm:p-10 lg:p-12 glass-panel border border-white/15 shadow-2xl overflow-hidden">
            <!-- Glow background -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                    <i data-lucide="calculator" class="w-3.5 h-3.5"></i>
                    <span>SIMULATOR ESTIMASI AWAL</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl font-black text-white">Simulator Estimasi Biaya Wisata</h2>
                <p class="text-xs sm:text-sm text-slate-400 mt-2">Dapatkan perkiraan awal anggaran perjalanan Anda. Tarif resmi final dan ketersediaan kamar homestay/armada akan dikonfirmasi langsung oleh tim admin kami via WhatsApp.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Form Input Parameter -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Pilihan Paket -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">1. Pilih Paket Wisata (Estimasi Dasar)</label>
                        <select id="calcPkg" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            @foreach ($packages as $pkg)
                                <option
                                    value="{{ $pkg->slug }}"
                                    data-price="{{ $pkg->price }}"
                                    data-jeep="{{ str_contains(strtolower($pkg->category . ' ' . $pkg->title), 'jeep') ? '1' : '0' }}"
                                    data-duration="{{ $pkg->duration }}"
                                    {{ $pkg->is_popular ? 'selected' : '' }}
                                >
                                    {{ $pkg->title }} — Mulai {{ $pkg->formatted_price }} ({{ $pkg->duration }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jumlah Peserta -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-300">2. Jumlah Peserta</label>
                            <span id="paxDisplay" class="text-xs font-bold text-amber-400">4 Orang</span>
                        </div>
                        <input id="calcPax" type="range" min="1" max="25" value="4" aria-label="Jumlah Peserta Wisata" class="w-full accent-amber-400 cursor-pointer">
                        <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                            <span>1 Orang</span>
                            <span>10 Orang (Diskon 10%)</span>
                            <span>25 Orang (Rombongan)</span>
                        </div>
                    </div>

                    <!-- Titik Penjemputan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">3. Lokasi Titik Penjemputan (Meeting Point)</label>
                        <select id="calcMeeting" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            <option value="Wonosobo / Terminal Mendolo" data-surcharge="0" selected>Kota Wonosobo / Terminal Mendolo (Gratis / Standar)</option>
                            <option value="Purwokerto (Stasiun / Terminal)" data-surcharge="50000">Purwokerto — Stasiun / Terminal Bulupitu (+Rp 50.000/org)</option>
                            <option value="Yogyakarta (Stasiun Tugu / Lempuyangan / YIA)" data-surcharge="100000">Yogyakarta — Stasiun Tugu / Lempuyangan / Bandara YIA (+Rp 100.000/org)</option>
                            <option value="Semarang (Stasiun Tawang / Bandara)" data-surcharge="100000">Semarang — Stasiun Tawang / Bandara Ahmad Yani (+Rp 100.000/org)</option>
                        </select>
                    </div>

                    <!-- Rencana Tanggal & Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Tanggal Perjalanan</label>
                            <div class="relative">
                                <input id="calcDate" type="text" placeholder="Pilih tanggal keberangkatan..." readonly class="w-full p-3 pl-3.5 pr-10 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none cursor-pointer placeholder:text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 text-amber-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Nama Pemesan</label>
                            <input id="calcName" type="text" placeholder="Contoh: Bpk. Kurniawan" class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Catatan Tambahan (Opsional)</label>
                        <input id="calcNotes" type="text" placeholder="Permintaan tipe kamar homestay, menu khusus, dsb." class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <!-- Rincian Hasil & Tombol WA -->
                <div class="lg:col-span-5 p-6 rounded-2xl bg-black/40 border border-white/10 space-y-6">
                    <div class="border-b border-white/10 pb-4">
                        <span class="text-xs font-semibold text-amber-400 uppercase tracking-wider block">Estimasi Awal Mulai Dari</span>
                        <div id="totalPriceDisplay" class="text-3xl sm:text-4xl font-black text-amber-400 mt-2 font-mono">Rp 2.780.000</div>
                        <p id="calcNoteText" class="text-xs text-slate-400 mt-1">Perkiraan awal untuk 4 orang peserta</p>
                    </div>

                    <div class="space-y-3 text-xs text-slate-300">
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Paket:</span>
                            <span id="summaryPkgName" class="font-semibold text-white">Golden Sunrise 2D1N</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Peserta:</span>
                            <span id="summaryPax" class="font-semibold text-white">4 Orang</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Titik Jemput:</span>
                            <span id="summaryMeeting" class="font-semibold text-white truncate max-w-[200px]">Wonosobo</span>
                        </div>
                        <div id="discountRow" class="hidden justify-between py-1 border-b border-white/5 text-emerald-400">
                            <span>Diskon Rombongan:</span>
                            <span id="summaryDiscount" class="font-semibold">-</span>
                        </div>
                    </div>

                    <!-- Disclaimer Homestay & Seasonality -->
                    <div class="p-3 rounded-xl bg-white/[0.03] border border-white/10 text-[11px] text-slate-300 leading-relaxed flex items-start gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5"></i>
                        <span>Biaya akhir dapat menyesuaikan ketersediaan tipe kamar homestay (standar/VIP), musim liburan, dan kustomisasi rute Anda.</span>
                    </div>

                    <button id="btnSendWa" class="w-full py-4 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider text-black bg-gradient-to-r from-emerald-400 via-emerald-300 to-emerald-500 hover:from-emerald-300 hover:to-emerald-400 transition-all duration-300 shadow-xl shadow-emerald-500/25 flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Konsultasi & Cek Homestay via WA</span>
                    </button>
                    <p class="text-[11px] text-center text-slate-400">Terhubung langsung dengan Admin Resmi {{ $settings->site_name }} untuk pengecekan slot kamar & tanggal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONI WISATAWAN -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase">Suara Para Penjelajah</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-3">Kisah Nyata dari Atas Awan</h2>
            <p class="text-xs sm:text-sm text-slate-400">Lebih dari 2.500 wisatawan telah mempercayakan liburan mereka bersama {{ $settings->site_name }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Review 1 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Pilihan yang sangat tepat bersama TiketDieng! Momen fajar di Sikunir sangat tepat waktu. Mas Dimas sebagai pemandu sangat ramah dan sabar mengarahkan sudut foto terbaik, serta dokumentasi videonya luar biasa indah!”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Dr. Amanda" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Dr. Amanda Saraswati</h4>
                        <p class="text-[11px] text-slate-400">Jakarta Selatan • <span class="text-amber-300">Paket 2D1N</span></p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Adrenalin kami terpacu saat melintasi jalur off-road perkebunan teh dan Telaga Dringo! Pengemudi jip sangat berpengalaman dan penginapannya sangat bersih dengan air hangat yang lancar.”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Rizky Ramadhan" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Rizky Ramadhan & Rekan</h4>
                        <p class="text-[11px] text-slate-400">Surabaya • <span class="text-amber-300">Safari Jip 4x4</span></p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Dieng is truly magnificent! The team handled our itinerary so smoothly right from pickup at Yogyakarta. Watching the sunrise piercing through the misty peaks was an unforgettable memory.”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=75" alt="Clara & Michael" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Clara & Michael</h4>
                        <p class="text-[11px] text-slate-400">Melbourne, Australia • <span class="text-amber-300">Paket 3D2N</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. VISITOR COUNTER PUBLIK (REALTIME TRANSPARENT STATS) -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6 border-b border-white/10 pb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wide">Statistik Kunjungan Pengunjung</h3>
                        <p class="text-[11px] text-slate-400">Data transparan aktivitas penjelajah TiketDieng.com</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span><strong id="counterOnline">{{ $visitorStats['online'] }}</strong> Penjelajah Online</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Hari Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-amber-400 font-mono mt-1">{{ number_format($visitorStats['today'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Pengunjung unik</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Kemarin</span>
                    <div class="text-xl sm:text-2xl font-bold text-sky-400 font-mono mt-1">{{ number_format($visitorStats['yesterday'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Rekap kemarin</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Minggu Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-emerald-400 font-mono mt-1">{{ number_format($visitorStats['this_week'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">7 hari terakhir</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Bulan Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-purple-400 font-mono mt-1">{{ number_format($visitorStats['this_month'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Bulan aktif</span>
                </div>

                <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Kunjungan</span>
                    <div class="text-xl sm:text-2xl font-bold text-white font-mono mt-1">{{ number_format($visitorStats['total'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Sejak platform rilis</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. FOOTER SINEMATIK & LEGALITAS BIRO PERJALANAN -->
    <footer class="bg-[#04060a] border-t border-white/10 text-slate-400 text-xs pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                <!-- Col 1: Brand & Legalitas -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-tiketdieng-transparent.png') }}?v=2" alt="{{ $settings->site_name }}" class="h-9 w-auto object-contain brightness-110">
                    </div>
                    <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                        {{ $settings->site_tagline }}. Bagian resmi dari <strong class="text-white">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong>. Menghadirkan kemudahan reservasi akomodasi, sewa jeep, shuttle, dokumentasi sinematik, dan outbound profesional di Dieng.
                    </p>
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-amber-300 font-semibold">
                            {{ $settings->legal_nib }}
                        </span>
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-emerald-300 font-semibold">
                            {{ $settings->hpi_badge }}
                        </span>
                    </div>

                    <!-- Rekening Resmi Perusahaan -->
                    <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 space-y-1 mt-3">
                        <div class="text-[10px] uppercase font-bold tracking-wider text-amber-400 flex items-center gap-1.5">
                            <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                            <span>Rekening Resmi Pembayaran:</span>
                        </div>
                        <p class="text-xs font-mono font-bold text-white tracking-wider">BNI: 8166754042</p>
                        <p class="text-[11px] text-slate-400">a.n. PT. GOTRIP ASIA TRAVELINDO (Cab. Wonosobo)</p>
                    </div>

                    <!-- Social Media Links -->
                    <div class="flex items-center gap-3 pt-2 text-slate-400">
                        <a href="https://www.instagram.com/tiketwisatadieng?stkn=MWpxamRlbjkxd3I1Yg==" target="_blank" class="hover:text-pink-400 transition-colors flex items-center gap-1.5 text-xs">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-400"></i>
                            <span>@tiketwisatadieng</span>
                        </a>
                        <span>•</span>
                        <a href="https://tiktok.com/@tiketdieng.com" target="_blank" class="hover:text-cyan-400 transition-colors flex items-center gap-1.5 text-xs">
                            <i data-lucide="video" class="w-4 h-4 text-cyan-400"></i>
                            <span>TikTok</span>
                        </a>
                        <span>•</span>
                        <a href="https://www.facebook.com/share/1Hj4SzNUzH/" target="_blank" class="hover:text-blue-400 transition-colors flex items-center gap-1.5 text-xs">
                            <i data-lucide="facebook" class="w-4 h-4 text-blue-400"></i>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Destinasi Ikonik -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Informasi & Navigasi</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#dokumentasi" class="text-cyan-300 font-semibold hover:text-cyan-400 transition-colors flex items-center gap-1.5"><i data-lucide="camera" class="w-3.5 h-3.5 text-cyan-400"></i><span>Foto & Drone (Lotus Creative)</span></a></li>
                        <li><a href="#profil" class="text-amber-300 font-semibold hover:text-amber-400 transition-colors flex items-center gap-1.5"><i data-lucide="compass" class="w-3.5 h-3.5 text-amber-400"></i><span>Profil & Visi Misi</span></a></li>
                        <li><a href="#paket" class="hover:text-amber-400 transition-colors">Paket Wisata Pilihan</a></li>
                        <li><a href="#sikunir" class="hover:text-amber-400 transition-colors">Golden Sunrise Sikunir</a></li>
                        <li><a href="#sikidang" class="hover:text-amber-400 transition-colors">Kawah Sikidang Purba</a></li>
                        <li><a href="#telagawarna" class="hover:text-amber-400 transition-colors">Telaga Warna & Pengilon</a></li>
                        <li><a href="#candi-arjuna" class="hover:text-amber-400 transition-colors">Kompleks Candi Arjuna</a></li>
                        <li><a href="#kalkulator" class="hover:text-amber-400 transition-colors">Kalkulator Reservasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Produk -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Layanan Vendor</h4>
                    <ul class="space-y-2.5">
                        <li>Dokumentasi & Drone 4K (Lotus Creative)</li>
                        <li>Jeep Wisata Dieng 4x4</li>
                        <li>Shuttle Bus Wisata 15 Seat</li>
                        <li>Reservasi Villa & Homestay</li>
                        <li>Paket Outbound & Gathering</li>
                        <li>Pemandu Wisata Resmi HPI</li>
                    </ul>
                </div>

                <!-- Col 4: Kantor & Kontak -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Kontak Resmi</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5"></i>
                            <span>{{ $settings->address ?? 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span class="text-white font-medium">{{ $settings->phone_number ?? '0816675404' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="message-circle" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="hover:text-amber-400 transition-colors">
                                WhatsApp: {{ $settings->whatsapp_number }}
                            </a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                            <span>{{ $settings->email ?? 'tiket.wisatadieng@gmail.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom credit -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <p>© {{ date('Y') }} {{ $settings->site_name }}. Hak cipta dilindungi undang-undang.</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 text-[11px]">
                    <span>Dikembangkan oleh <a href="https://soulofjava.github.io/myportofolio/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-amber-400 font-medium underline underline-offset-2 decoration-amber-500/30 hover:decoration-amber-400 transition-colors">Isa Maulana</a></span>
                </div>
            </div>
        </div>
    </footer>
</main>
@endsection

@push('scripts')
<script>
    // 1. Scroll Navbar Effect
    const navContainer = document.getElementById('navContainer');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navContainer.classList.add('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.remove('bg-black/30', 'py-4');
        } else {
            navContainer.classList.remove('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.add('bg-black/30', 'py-4');
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // 2. Fetch Live Weather Dieng (Open-Meteo)
    async function initDiengWeather() {
        const cacheKey = 'dieng_weather_cache';
        const cacheTimeKey = 'dieng_weather_time';
        const cacheDuration = 15 * 60 * 1000;

        const tempEl = document.getElementById('diengTemp');
        const condEl = document.getElementById('diengCondition');
        if (!tempEl || !condEl) return;

        try {
            const cached = sessionStorage.getItem(cacheKey);
            const cachedTime = sessionStorage.getItem(cacheTimeKey);
            if (cached && cachedTime && (Date.now() - parseInt(cachedTime)) < cacheDuration) {
                const w = JSON.parse(cached);
                tempEl.innerText = w.temp + '°C';
                condEl.innerText = w.condition;
                return;
            }

            const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-7.2062&longitude=109.9015&current=temperature_2m,relative_humidity_2m,weather_code&timezone=Asia%2FJakarta');
            if (res.ok) {
                const data = await res.json();
                const temp = Math.round(data.current?.temperature_2m ?? 18);
                const code = data.current?.weather_code ?? 0;
                let condition = "Sejuk Berawan";
                if (code === 0) condition = "Cerah Sejuk";
                else if (code <= 2) condition = "Cerah Berawan";
                else if (code <= 3) condition = "Mendung Sejuk";
                else if (code <= 48) condition = "Kabut Dingin";
                else if (code <= 65) condition = "Hujan Dingin";

                tempEl.innerText = temp + '°C';
                condEl.innerText = condition;

                sessionStorage.setItem(cacheKey, JSON.stringify({ temp, condition }));
                sessionStorage.setItem(cacheTimeKey, Date.now().toString());
            }
        } catch (e) {
            // Biarkan fallback
        }
    }
    initDiengWeather();

    // 3. Smart Booking Calculator
    const calcPkg = document.getElementById('calcPkg');
    const calcPax = document.getElementById('calcPax');
    const paxDisplay = document.getElementById('paxDisplay');
    const calcMeeting = document.getElementById('calcMeeting');
    const calcDate = document.getElementById('calcDate');
    const calcName = document.getElementById('calcName');
    const calcNotes = document.getElementById('calcNotes');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const calcNoteText = document.getElementById('calcNoteText');
    const summaryPkgName = document.getElementById('summaryPkgName');
    const summaryPax = document.getElementById('summaryPax');
    const summaryMeeting = document.getElementById('summaryMeeting');
    const discountRow = document.getElementById('discountRow');
    const summaryDiscount = document.getElementById('summaryDiscount');
    const btnSendWa = document.getElementById('btnSendWa');

    // Inisialisasi Flatpickr (Tanggal Perjalanan)
    if (window.flatpickr && calcDate) {
        flatpickr(calcDate, {
            locale: "id",
            minDate: "today",
            dateFormat: "d F Y",
            altInput: false,
            defaultDate: new Date(Date.now() + 86400000), // Default keberangkatan besok
            disableMobile: "true", // Memaksa tema gelap Dieng tampil di semua perangkat
        });
    }

    function calculatePrice() {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const basePrice = parseInt(selectedOption.getAttribute('data-price')) || 0;
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = parseInt(calcPax.value) || 1;
        const meetingOption = calcMeeting.options[calcMeeting.selectedIndex];
        const surcharge = parseInt(meetingOption.getAttribute('data-surcharge')) || 0;

        paxDisplay.innerText = pax + ' Orang';
        summaryPax.innerText = pax + ' Orang';
        summaryPkgName.innerText = selectedOption.text.split('—')[0].trim();
        summaryMeeting.innerText = meetingOption.text.split('(')[0].trim();

        let total = 0;
        if (isJeep) {
            const unitsNeeded = Math.ceil(pax / 4);
            total = (unitsNeeded * basePrice) + (surcharge * pax);
            calcNoteText.innerText = `Membutuhkan ${unitsNeeded} Unit Jeep untuk ${pax} orang`;
            discountRow.classList.add('hidden');
        } else {
            let discountPercent = 0;
            if (pax >= 6 && pax < 10) discountPercent = 0.05;
            if (pax >= 10) discountPercent = 0.1;

            const basePerPax = (basePrice * (1 - discountPercent)) + surcharge;
            total = Math.round(basePerPax * pax);
            calcNoteText.innerText = `Estimasi Rp ${Math.round(basePerPax).toLocaleString('id-ID')}/orang`;

            if (discountPercent > 0) {
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                summaryDiscount.innerText = (discountPercent * 100) + '% Potongan Rombongan';
            } else {
                discountRow.classList.add('hidden');
            }
        }

        totalPriceDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    calcPkg.addEventListener('change', calculatePrice);
    calcPax.addEventListener('input', calculatePrice);
    calcMeeting.addEventListener('change', calculatePrice);
    calculatePrice();

    window.selectPackageInCalculator = function(slug) {
        if (calcPkg) {
            calcPkg.value = slug;
            calculatePrice();
        }
    };

    // 4. Send WhatsApp Handler
    btnSendWa.addEventListener('click', () => {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const pkgTitle = selectedOption.text.split('—')[0].trim();
        const duration = selectedOption.getAttribute('data-duration');
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = calcPax.value;
        const unitsNeeded = Math.ceil(pax / 4);
        const meeting = calcMeeting.options[calcMeeting.selectedIndex].text.split('(')[0].trim();
        const dateVal = calcDate.value ? calcDate.value : "Fleksibel / Menyesuaikan";
        const nameVal = calcName.value ? calcName.value : "Tamu {{ $settings->site_name }}";
        const notesVal = calcNotes.value.trim();
        const total = totalPriceDisplay.innerText;

        const waTarget = "{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}";

        const text = `*HALO ADMIN {{ $settings->site_name }} - KONSULTASI PAKET DIENG*
----------------------------------------
👤 *Nama:* ${nameVal}
📦 *Paket:* ${pkgTitle} (${duration})
👥 *Peserta:* ${pax} Orang ${isJeep ? `(${unitsNeeded} Unit Jeep)` : ""}
📍 *Titik Jemput:* ${meeting}
📅 *Rencana Tanggal:* ${dateVal}
💰 *Estimasi di Web:* Mulai dari ${total}
${notesVal ? `📝 *Catatan / Homestay:* ${notesVal}\n` : ""}----------------------------------------
Saya ingin menanyakan ketersediaan slot armada dan kamar homestay untuk tanggal tersebut. Mohon dibantu informasinya, terima kasih! 🙏`;

        window.open(`https://wa.me/${waTarget}?text=${encodeURIComponent(text)}`, '_blank');
    });
</script>
@endpush

@extends('layouts.app')

@section('title', $package->title . ' — ' . $settings->site_name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($package->summary), 160))
@section('og_image', $package->image_url)
@section('og_type', 'article')

@section('schema_json')
@php
    $touristTripSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'TouristTrip',
        'name' => $package->title,
        'description' => strip_tags($package->summary),
        'image' => $package->image_url,
        'touristType' => ['Families', 'Couples', 'Adventure Seekers', 'Photographers'],
        'offers' => [
            '@type' => 'Offer',
            'price' => (string) $package->price,
            'priceCurrency' => 'IDR',
            'availability' => 'https://schema.org/InStock',
            'url' => url()->current(),
            'validFrom' => '2026-01-01',
            'description' => 'Tarif mulai dari per pax (penyesuaian homestay via WhatsApp)',
        ],
        'provider' => [
            '@type' => 'TravelAgency',
            'name' => $settings->site_name,
            'url' => url('/'),
            'telephone' => $settings->phone_number,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $settings->address,
                'addressLocality' => 'Wonosobo',
                'addressRegion' => 'Jawa Tengah',
                'postalCode' => '56354',
                'addressCountry' => 'ID',
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($touristTripSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
@php
    $cleanWa = preg_replace('/\D/', '', $settings->whatsapp_number ?? '628123456789');
    $strikePrice = 'Rp ' . number_format($package->price * 1.25, 0, ',', '.');
@endphp

<!-- Container Root: Clean Light Theme tiket.com Style -->
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 font-sans antialiased pb-20">

    <!-- 1. Header Navigation Bar (tiket.com Clean White Header) -->
    <header class="sticky top-0 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 py-3.5 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0 focus:outline-none" aria-label="{{ $settings->site_name ?? 'TiketDieng' }}">
                <img 
                    src="{{ asset('images/logo-tiketdieng-blue-text.png') }}" 
                    alt="{{ $settings->site_name ?? 'TiketDieng' }}" 
                    class="h-8 sm:h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                    onerror="this.style.display='none'; var fb = document.getElementById('detailBrandFallback'); if(fb){ fb.classList.remove('hidden'); fb.classList.add('flex'); }"
                >
                <div id="detailBrandFallback" class="hidden items-center gap-1.5 font-sans font-extrabold text-xl tracking-tight text-[#0064D2]">
                    <span>tiket</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FEDD00] shadow-sm inline-block"></span>
                    <span class="text-slate-800">Dieng</span>
                </div>
            </a>

            <!-- Search, Navigation & WhatsApp CTA -->
            <div class="flex items-center gap-2.5 sm:gap-4">
                <!-- Spotlight Search Trigger -->
                <button
                    type="button"
                    onclick="window.openSpotlightSearch()"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200/80 border border-slate-200 text-xs text-slate-600 hover:text-slate-900 transition-all cursor-pointer"
                    title="Pencarian Cepat Paket Wisata (Ctrl+K)"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span class="hidden md:inline text-[11px]">Cari paket...</span>
                    <kbd class="hidden md:inline-flex items-center px-1.5 py-0.5 text-[9px] font-mono text-slate-500 bg-white rounded border border-slate-200">⌘K</kbd>
                </button>

                <a href="{{ route('home') }}#paket" class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-[#0064D2] transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Semua Paket</span>
                </a>

                <a
                    href="https://wa.me/{{ $cleanWa }}?text={{ urlencode("Halo Admin {$settings->site_name}, saya melihat paket '{$package->title}' dan ingin konsultasi ketersediaan tanggal keberangkatan. Mohon dibantu ya!") }}"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051a8] shadow-md shadow-blue-500/20 transition-all active:scale-95"
                >
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                    <span>Tanya CS via WA</span>
                </a>
            </div>
        </div>
    </header>

    <!-- 2. Breadcrumbs -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-2">
        <nav class="flex items-center flex-wrap gap-2 text-xs text-slate-500 font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#0064D2] transition-colors flex items-center gap-1">
                <i data-lucide="home" class="w-3.5 h-3.5"></i>
                <span>Beranda</span>
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <a href="{{ route('home') }}#paket" class="hover:text-[#0064D2] transition-colors">
                Paket Wisata Dieng
            </a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-slate-500">{{ $package->category }}</span>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-300"></i>
            <span class="text-[#0064D2] font-semibold line-clamp-1 max-w-[200px] sm:max-w-xs">{{ $package->title }}</span>
        </nav>
    </div>

    <!-- 3. Main Detail Content Section -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-3 pb-16">
        <!-- Package Header: Title, Category Pills & Badges -->
        <div class="mb-6 space-y-3">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#0064D2] border border-blue-100">
                    {{ $package->category }}
                </span>

                @if ($package->badge)
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase bg-[#FEDD00] text-slate-950 shadow-xs flex items-center gap-1">
                        <i data-lucide="zap" class="w-3.5 h-3.5 fill-slate-950"></i>
                        <span>{{ $package->badge }}</span>
                    </span>
                @endif

                <span class="px-3 py-1 rounded-full text-xs font-medium text-slate-600 bg-white border border-slate-200/80 flex items-center gap-1.5 shadow-xs">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                    <span>{{ $package->duration }}</span>
                </span>

                <!-- Rating Pill with tiket Yellow Star -->
                <div class="px-3 py-1 rounded-full text-xs font-bold text-slate-800 bg-white border border-slate-200/80 flex items-center gap-1 shadow-xs">
                    <svg class="w-3.5 h-3.5 fill-[#FEDD00] text-[#FEDD00]" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>4.9</span>
                    <span class="text-slate-400 font-normal">(500+ Ulasan Terverifikasi)</span>
                </div>
            </div>

            <!-- Main Heading -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $package->title }}
            </h1>

            <!-- Pickup Location and HPI Guide Badge -->
            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-1 text-slate-600">
                    <i data-lucide="map-pin" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Titik Penjemputan: <strong class="text-slate-800">{{ $package->pickup_location ?: 'Kota Wonosobo / Dieng' }}</strong></span>
                </div>
                <span>•</span>
                <div class="flex items-center gap-1 text-emerald-700">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>Pemandu Berlisensi HPI Resmi</span>
                </div>
            </div>
        </div>

        <!-- 4. Image Gallery Grid (tiket.com Signature 3-Item Layout) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-8">
            <!-- Main Hero Image (8 cols) -->
            <div class="md:col-span-8 rounded-2xl overflow-hidden aspect-[16/10] relative shadow-sm border border-slate-200/80 bg-slate-100 group">
                <img
                    src="{{ $package->image_url }}"
                    alt="{{ $package->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700 opacity-0"
                    onload="this.classList.remove('opacity-0');"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-3.5 left-4 text-white text-xs font-semibold flex items-center gap-2">
                    <span class="bg-black/50 backdrop-blur-md px-3 py-1 rounded-full border border-white/20 flex items-center gap-1.5">
                        <i data-lucide="camera" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                        <span>Spot Utama Perjalanan</span>
                    </span>
                </div>
            </div>

            <!-- Secondary Gallery Thumbnails (4 cols) -->
            <div class="md:col-span-4 grid grid-cols-2 md:grid-cols-1 gap-3">
                <!-- Sub Image 1: Sikunir Dawn / Spot Panorama -->
                <div class="rounded-2xl overflow-hidden aspect-[16/10] md:aspect-auto md:h-[calc(50%-6px)] relative shadow-sm border border-slate-200/80 bg-slate-200 group">
                    <img
                        src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop"
                        alt="Golden Sunrise Sikunir Dieng"
                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <span class="absolute bottom-2.5 left-2.5 text-[11px] font-semibold text-white bg-black/40 backdrop-blur-md px-2.5 py-0.5 rounded-md border border-white/10">
                        Golden Sunrise Sikunir
                    </span>
                </div>

                <!-- Sub Image 2: Telaga & Jeep Safari -->
                <div class="rounded-2xl overflow-hidden aspect-[16/10] md:aspect-auto md:h-[calc(50%-6px)] relative shadow-sm border border-slate-200/80 bg-slate-200 group">
                    <img
                        src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=800&auto=format&fit=crop"
                        alt="Kawah Sikidang & Telaga Warna Dieng"
                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <span class="absolute bottom-2.5 left-2.5 text-[11px] font-semibold text-white bg-black/40 backdrop-blur-md px-2.5 py-0.5 rounded-md border border-white/10">
                        Jeep Safari & Panorama
                    </span>
                    <div class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-md text-[#0064D2] text-[10px] font-bold px-2 py-0.5 rounded-full shadow-xs">
                        Lihat 15+ Foto
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Main Grid: Detail Info (Left) + Sticky Booking Sidebar (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Kolom Kiri: Ulasan, Ringkasan, Itinerary & Fasilitas (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Review Highlights Card (tiket.com Social Proof Card) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex flex-col items-center justify-center flex-shrink-0">
                            <span class="text-xl font-black text-[#0064D2] leading-none">4.9</span>
                            <span class="text-[9px] font-bold text-slate-500 mt-0.5">/ 5.0</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-extrabold text-sm text-slate-900">Hebat Sekali</span>
                                <span class="text-[10px] font-bold bg-[#FEDD00] text-slate-950 px-2 py-0.2 rounded-full">Terverifikasi</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Dari 500+ ulasan wisatawan keluarga & instansi</p>
                        </div>
                    </div>

                    <!-- Review Tags Pills -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-[11px] font-medium bg-slate-50 text-slate-700 px-2.5 py-1 rounded-lg border border-slate-200/70">
                            ✨ Pelayanan Ramah
                        </span>
                        <span class="text-[11px] font-medium bg-slate-50 text-slate-700 px-2.5 py-1 rounded-lg border border-slate-200/70">
                            🏠 Homestay Bersih
                        </span>
                        <span class="text-[11px] font-medium bg-slate-50 text-slate-700 px-2.5 py-1 rounded-lg border border-slate-200/70">
                            🚗 Driver Profesional
                        </span>
                    </div>
                </div>

                <!-- Overview Program Box -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs space-y-3">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="book-open" class="w-5 h-5 text-[#0064D2]"></i>
                        <span>Tentang Program Perjalanan Ini</span>
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $package->summary }}
                    </p>

                    <!-- Quick Highlight Badges -->
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap gap-2 text-xs text-slate-600">
                        <div class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/70">
                            <i data-lucide="users" class="w-4 h-4 text-[#0064D2]"></i>
                            <span>Private Tour (Bukan Rombongan Gabungan)</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/70">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#0064D2]"></i>
                            <span>Jadwal Berangkat Bebas Ditentukan</span>
                        </div>
                    </div>
                </div>

                <!-- Itinerary Accordion Tabs (tiket.com Model) -->
                @if (!empty($package->itinerary_options) && count($package->itinerary_options) > 0)
                    <div
                        class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-xs space-y-5"
                        x-data="{ activeRoute: 0 }"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <i data-lucide="compass" class="w-5 h-5 text-[#0064D2]"></i>
                                    <span>Pilihan Rute & Jadwal Itinerary</span>
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Pilih opsi rute kunjungan yang paling sesuai dengan preferensi Anda.
                                </p>
                            </div>

                            <!-- Route Switcher Tabs if multiple -->
                            @if(count($package->itinerary_options) > 1)
                                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl">
                                    @foreach ($package->itinerary_options as $rIdx => $rOpt)
                                        <button
                                            @click="activeRoute = {{ $rIdx }}"
                                            type="button"
                                            class="px-3 py-1 rounded-lg text-xs font-bold transition-all cursor-pointer"
                                            :class="activeRoute === {{ $rIdx }}
                                                ? 'bg-[#0064D2] text-white shadow-xs'
                                                : 'text-slate-600 hover:text-slate-900'"
                                        >
                                            Opsi {{ $rIdx + 1 }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Itinerary Cards Accordion -->
                        <div class="space-y-3.5">
                            @foreach ($package->itinerary_options as $idx => $option)
                                <div
                                    x-show="activeRoute === {{ $idx }}"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5 space-y-3"
                                >
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-7 h-7 rounded-lg bg-[#0064D2] text-white text-xs font-bold flex items-center justify-center">
                                                {{ $idx + 1 }}
                                            </span>
                                            <h3 class="font-bold text-sm sm:text-base text-slate-900">
                                                {{ $option['name'] ?? 'Opsi Rute Kunjungan' }}
                                            </h3>
                                        </div>
                                        <span class="text-[11px] font-semibold text-[#0064D2] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                            Rute Terjadwal
                                        </span>
                                    </div>

                                    @if (!empty($option['destinations']))
                                        <div class="flex items-start gap-2 text-xs text-slate-600 bg-white p-3 rounded-xl border border-slate-200/80">
                                            <i data-lucide="map-pin" class="w-4 h-4 text-[#0064D2] mt-0.5 flex-shrink-0"></i>
                                            <div>
                                                <strong class="text-slate-900 block mb-0.5">Destinasi yang Dikunjungi:</strong>
                                                <span class="text-slate-600 leading-relaxed">{{ $option['destinations'] }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if (!empty($option['description']))
                                        <div class="bg-white p-3.5 rounded-xl border border-slate-200/80 text-xs text-slate-600 leading-relaxed whitespace-pre-line font-sans">
                                            {{ $option['description'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Fasilitas Termasuk & Tidak Termasuk (Include & Exclude) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Fasilitas Termasuk -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100 text-emerald-600">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            <h3 class="font-bold text-slate-900 text-base">Fasilitas Termasuk (Include)</h3>
                        </div>
                        @if (!empty($package->inclusions) && count($package->inclusions) > 0)
                            <ul class="space-y-2.5 text-xs text-slate-600">
                                @foreach ($package->inclusions as $inc)
                                    <li class="flex items-start gap-2.5">
                                        <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                        </span>
                                        <span>{{ $inc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="space-y-2.5 text-xs text-slate-600">
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span>Transportasi Antar-Jemput VIP ber-AC</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span>Penginapan / Homestay Bersih & Nyaman</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span>Tiket Masuk Seluruh Objek Wisata Dieng</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span>Pemandu Wisata Lokal Resmi Berlisensi HPI</span>
                                </li>
                            </ul>
                        @endif
                    </div>

                    <!-- Fasilitas Tidak Termasuk -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100 text-rose-500">
                            <i data-lucide="x-circle" class="w-5 h-5"></i>
                            <h3 class="font-bold text-slate-900 text-base">Tidak Termasuk (Exclude)</h3>
                        </div>
                        @if (!empty($package->exclusions) && count($package->exclusions) > 0)
                            <ul class="space-y-2.5 text-xs text-slate-600">
                                @foreach ($package->exclusions as $exc)
                                    <li class="flex items-start gap-2.5">
                                        <span class="w-4 h-4 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i data-lucide="x" class="w-3 h-3"></i>
                                        </span>
                                        <span>{{ $exc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="space-y-2.5 text-xs text-slate-600">
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="x" class="w-4 h-4 text-rose-400 flex-shrink-0"></i>
                                    <span>Pengeluaran dan belanja pribadi di luar program</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <i data-lucide="x" class="w-4 h-4 text-rose-400 flex-shrink-0"></i>
                                    <span>Tipping sukarela untuk driver / pemandu</span>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Saran & Checklist Persiapan Dieng -->
                @if (!empty($package->preparations) && count($package->preparations) > 0)
                    <div class="bg-amber-50/60 rounded-2xl border border-amber-200/80 p-6 space-y-4">
                        <div class="flex items-center gap-2.5 text-amber-800 pb-3 border-b border-amber-200/60">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center">
                                <i data-lucide="backpack" class="w-4 h-4 text-amber-700"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm sm:text-base">Saran & Checklist Perlengkapan Dieng</h3>
                                <p class="text-[11px] text-amber-800/80">Suhu dataran tinggi Dieng berkisar 8°C - 15°C (bahkan membeku saat embun upas).</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            @foreach ($package->preparations as $prep)
                                <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white border border-amber-200/60 text-xs text-slate-700 shadow-xs">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500 flex-shrink-0"></i>
                                    <span>{{ $prep }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan: Sticky Booking Sidebar Card (tiket.com Model) (4 cols) -->
            <div
                class="lg:col-span-4 sticky top-24 space-y-4"
                x-data="{
                    pax: 2,
                    unitPrice: {{ (int) $package->price }},
                    travelDate: '',
                    pickupCity: '{{ addslashes($package->pickup_location ?: 'Wonosobo') }}',
                    getTotalPrice() {
                        return this.pax * this.unitPrice;
                    },
                    getFormattedTotal() {
                        return 'Rp ' + this.getTotalPrice().toLocaleString('id-ID');
                    },
                    getBookingWhatsAppUrl() {
                        const base = 'https://wa.me/{{ $cleanWa }}?text=';
                        const lines = [
                            'Halo Admin {{ $settings->site_name }}, saya ingin booking paket tour berikut:',
                            '• *Paket:* {{ addslashes($package->title) }}',
                            '• *Jumlah Peserta:* ' + this.pax + ' orang',
                            '• *Estimasi Total:* ' + this.getFormattedTotal(),
                            '• *Tanggal Rencana:* ' + (this.travelDate ? this.travelDate : 'Menyusul / Fleksibel'),
                            '• *Titik Jemput:* ' + this.pickupCity,
                            '',
                            'Mohon informasi ketersediaan kamar homestay dan slot armadanya. Terima kasih! 🙏'
                        ];
                        return base + encodeURIComponent(lines.join('\n'));
                    }
                }"
            >
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-7 space-y-5 text-slate-800">

                    <!-- Promo Strikethrough & Price -->
                    <div class="border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400 line-through">{{ $strikePrice }}</span>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50 border border-rose-100 px-2 py-0.5 rounded-full">
                                Hemat 20%
                            </span>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-3xl sm:text-4xl font-black text-[#0064D2]">
                                {{ $package->formatted_price }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">/ orang</span>
                        </div>
                        <span class="text-xs text-slate-500 mt-1 block">
                            {{ $package->price_note ?: 'Tarif fleksibel private tour all-in' }}
                        </span>
                    </div>

                    <!-- Pax Selector (Interactive Quantity Counter) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                            <span>Jumlah Peserta (Pax):</span>
                            <span class="text-[#0064D2] font-extrabold" x-text="pax + ' Orang'"></span>
                        </label>
                        <div class="flex items-center justify-between bg-slate-50 p-2 rounded-2xl border border-slate-200">
                            <button
                                @click="if (pax > 1) pax--"
                                type="button"
                                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-700 hover:bg-slate-100 active:scale-95 transition-all"
                            >
                                <i data-lucide="minus" class="w-4 h-4"></i>
                            </button>
                            <span class="text-base font-extrabold text-slate-900" x-text="pax + ' Pax'"></span>
                            <button
                                @click="pax++"
                                type="button"
                                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-700 hover:bg-slate-100 active:scale-95 transition-all"
                            >
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Travel Date Picker Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Tanggal Rencana Keberangkatan:</label>
                        <div class="relative">
                            <input
                                type="date"
                                x-model="travelDate"
                                class="w-full text-xs font-semibold rounded-2xl border border-slate-200 bg-slate-50 p-3 pl-10 focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2]"
                            />
                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5 pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Total Calculation Display -->
                    <div class="p-3.5 bg-blue-50/70 rounded-2xl border border-blue-100 space-y-1">
                        <div class="flex items-center justify-between text-xs text-blue-900">
                            <span>Estimasi Total (<span x-text="pax"></span> pax):</span>
                            <span class="text-lg font-extrabold text-[#0064D2]" x-text="getFormattedTotal()"></span>
                        </div>
                        <p class="text-[10px] text-blue-800/80 leading-snug">
                            Termasuk armada, driver, BBM, tiket objek wisata, dan homestay.
                        </p>
                    </div>

                    <!-- Instant Book WhatsApp CTA Button -->
                    <div class="space-y-2.5">
                        <a
                            :href="getBookingWhatsAppUrl()"
                            target="_blank"
                            class="w-full py-4 px-4 rounded-2xl font-extrabold text-xs sm:text-sm text-white bg-[#0064D2] hover:bg-[#0051a8] shadow-lg shadow-blue-500/25 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 text-center"
                        >
                            <i data-lucide="message-circle" class="w-4 h-4 text-[#FEDD00]"></i>
                            <span>Booking Langsung via WhatsApp</span>
                        </a>

                        <a
                            href="{{ route('home') }}#kalkulator"
                            class="w-full py-2.5 px-4 rounded-2xl font-semibold text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 text-center flex items-center justify-center gap-1.5 transition-colors"
                        >
                            <i data-lucide="calculator" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                            <span>Kalkulator Rute Lengkap</span>
                        </a>
                    </div>

                    <!-- Trust Signals (tiket.com style) -->
                    <div class="pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                            <span>Garansi Berangkat & Biro Resmi HPI</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="refresh-cw" class="w-4 h-4 text-emerald-600"></i>
                            <span>Bisa Reschedule Jika Cuaca Ekstrem</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="home" class="w-4 h-4 text-emerald-600"></i>
                            <span>Homestay Terkurasi Bersih & Hangat</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Service Hotline Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs text-xs text-slate-600 space-y-1 text-center">
                    <p class="font-bold text-slate-800">Butuh Paket Rombongan / Instansi?</p>
                    <p class="text-[11px] text-slate-500">Hubungi tim konsultan wisata kami via WhatsApp 24 Jam di <strong>{{ $settings->whatsapp_number }}</strong></p>
                </div>
            </div>
        </div>

        <!-- 6. Rekomendasi Paket Alternatif Lainnya (tiket.com Card Grid) -->
        @if ($otherPackages->count() > 0)
            <div class="mt-16 pt-10 border-t border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-xs font-bold text-[#0064D2] uppercase tracking-wider">Pilihan Alternatif</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mt-0.5">Paket Wisata Populer Lainnya</h2>
                    </div>
                    <a href="{{ route('home') }}#paket" class="text-xs font-bold text-[#0064D2] hover:underline flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($otherPackages as $other)
                        <div class="bg-white rounded-2xl border border-slate-200/80 hover:border-[#0064D2]/50 hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            <div>
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    <img
                                        src="{{ $other->image_url }}"
                                        alt="{{ $other->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500"
                                        loading="lazy"
                                    />
                                    <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-md text-[#0064D2]">
                                        {{ $other->category }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <span class="text-[10px] font-semibold text-slate-500 uppercase">{{ $other->duration }}</span>
                                    <h3 class="font-bold text-sm text-slate-900 mt-0.5 group-hover:text-[#0064D2] transition-colors line-clamp-1">
                                        <a href="{{ route('package.detail', $other->slug) }}">{{ $other->title }}</a>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $other->summary }}</p>
                                </div>
                            </div>
                            <div class="p-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Mulai dari</span>
                                    <span class="text-sm font-extrabold text-[#0064D2]">{{ $other->formatted_price }}</span>
                                </div>
                                <a
                                    href="{{ route('package.detail', $other->slug) }}"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051a8] transition-colors"
                                >
                                    Pilih
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <!-- 7. Light Themed Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-10 px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px]">
            <div>
                <strong class="font-bold text-slate-800 text-xs">{{ $settings->site_name }}</strong> — {{ $settings->site_tagline }}
            </div>
            <div class="flex flex-wrap items-center justify-center gap-2">
                <span>© {{ date('Y') }} Hak Cipta Dilindungi Undang-Undang</span>
                <span>•</span>
                <span>Biro Wisata Resmi Dataran Tinggi Dieng</span>
            </div>
        </div>
    </footer>

    <!-- 8. Sticky Bottom Bar Khusus Mobile Screen (lg:hidden) -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 px-4 shadow-xl flex items-center justify-between gap-3">
        <div>
            <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Mulai Dari</span>
            <div class="text-base font-extrabold text-[#0064D2] leading-tight">
                {{ $package->formatted_price }} <span class="text-[10px] font-normal text-slate-500">/ pax</span>
            </div>
        </div>
        <a
            href="https://wa.me/{{ $cleanWa }}?text={{ urlencode("Halo Admin {$settings->site_name}, saya tertarik dengan paket '{$package->title}' ({$package->formatted_price}/pax). Mohon info slot & ketersediaan tanggalnya ya!") }}"
            target="_blank"
            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-extrabold text-white bg-[#0064D2] shadow-md shadow-blue-500/25 active:scale-95 transition-all"
        >
            <i data-lucide="message-circle" class="w-4 h-4 text-[#FEDD00]"></i>
            <span>Booking WA</span>
        </a>
    </div>

</div>
@endsection

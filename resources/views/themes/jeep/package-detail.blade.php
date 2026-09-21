@extends('layouts.app')

@section('title', $package->title . ' — Ready Jeep Dieng (All In)')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($package->summary), 160))
@section('og_image', $package->image_url ?: asset('images/ready-jeep-dieng-logo.jpeg'))
@section('og_type', 'article')

@push('styles')
<style>
    body {
        background-color: #f8fafc !important;
        color: #0f172a !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>
@endpush

@section('schema_json')
@php
    $touristTripSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'TouristTrip',
        'name' => $package->title,
        'description' => strip_tags($package->summary),
        'image' => $package->image_url ?: asset('images/ready-jeep-dieng-logo.jpeg'),
        'touristType' => ['Adventure Seekers', 'Families', 'Photographers'],
        'offers' => [
            '@type' => 'Offer',
            'price' => (string) $package->price,
            'priceCurrency' => 'IDR',
            'availability' => 'https://schema.org/InStock',
            'url' => url()->current(),
            'validFrom' => '2026-01-01',
            'description' => 'Tarif All-In per 1 unit Jeep 4x4 (kapasitas 4 dewasa)',
        ],
        'provider' => [
            '@type' => 'TravelAgency',
            'name' => 'Ready Jeep Dieng',
            'url' => url('/?theme=jeep'),
            'telephone' => '081325631952',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jl. Dieng Km. 03, Tieng, Kejajar',
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
<main class="min-h-screen bg-[#f8fafc] text-slate-900 flex flex-col font-sans">
    @php
        $jeepWaRaw = $settings->whatsapp_number ?: '081325631952';
        $jeepWaInt = preg_replace('/[^0-9]/', '', $jeepWaRaw);
        if (str_starts_with($jeepWaInt, '0')) {
            $jeepWaInt = '62' . substr($jeepWaInt, 1);
        }
        $waMsg = urlencode("Halo Ready Jeep Dieng, saya tertarik dengan paket '{$package->title}'. Mohon informasi ketersediaan slot unit Jeep 4x4 dan jadwal tripnya. Terima kasih!");
        $waUrl = "https://wa.me/{$jeepWaInt}?text={$waMsg}";
    @endphp

    <!-- Header Navigation (Light Theme) -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/95 border-b border-slate-200/90 px-3.5 sm:px-6 lg:px-8 py-3 sm:py-4 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
            <a href="{{ url('/?theme=jeep') }}" class="flex items-center gap-2 sm:gap-3 group shrink-0 min-w-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-sm shrink-0 overflow-hidden group-hover:border-red-400 transition-colors">
                    <img src="{{ asset('images/ready-jeep-dieng-logo.png') }}" alt="Logo Ready Jeep Dieng" width="40" height="40" class="h-8 sm:h-10 w-auto max-w-full object-contain">
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-1 sm:gap-1.5 leading-tight">
                        <span class="text-sm sm:text-base font-black tracking-wider text-slate-900 uppercase">READY JEEP</span>
                        <span class="text-sm sm:text-base font-black tracking-wider text-red-600 uppercase">DIENG</span>
                    </div>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 font-mono tracking-wider uppercase block font-semibold truncate">OFFICIAL 4X4 ALL-IN</span>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <a href="{{ url('/?theme=jeep#paket-wisata') }}" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-red-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 text-red-600"></i>
                    <span>Kembali</span>
                </a>

                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs font-extrabold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 shadow-md shadow-red-600/20 transition-all hover:scale-105 shrink-0">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    <span class="hidden sm:inline">Tanya Booking (WA)</span>
                    <span class="sm:hidden">Booking</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Detail Content Section -->
    <section class="relative pt-8 pb-20 px-4 sm:px-6 lg:px-8 flex-1">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-semibold">
                <a href="{{ url('/?theme=jeep') }}" class="hover:text-red-600 transition-colors">Beranda Jeep</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                <a href="{{ url('/?theme=jeep#paket-wisata') }}" class="hover:text-red-600 transition-colors">Paket Wisata</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                <span class="text-red-600 line-clamp-1">{{ $package->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Kolom Kiri: Detail & Itinerary -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Badges -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-red-100 text-red-800 border border-red-200">
                            {{ $package->category }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                            <span>PAKET ALL IN</span>
                        </span>
                        @if ($package->badge)
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                                {{ $package->badge }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight">
                        {{ $package->title }}
                    </h1>

                    <!-- Image Cover -->
                    @if ($package->image_url)
                        <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md relative max-h-[420px]">
                            <img src="{{ $package->image_url }}" alt="{{ $package->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-xs text-white">
                                <span class="bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-1.5 font-bold">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-400"></i>
                                    <span>Durasi: {{ $package->duration ?: '06.30 - 11.00 WIB' }}</span>
                                </span>
                                <span class="bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/20 flex items-center gap-1.5 font-bold">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-red-400"></i>
                                    <span>Jemput: {{ $package->pickup_location ?: 'Area Kota Wonosobo' }}</span>
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Summary Card -->
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-red-600"></i>
                            <span>Ringkasan Paket</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                            {{ $package->summary }}
                        </p>
                    </div>

                    <!-- Inclusions & Exclusions Card -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Include -->
                        <div class="p-6 rounded-2xl bg-white border border-emerald-200 shadow-sm space-y-3">
                            <h3 class="text-sm font-black text-emerald-800 flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                                <span>Fasilitas Termasuk (ALL IN)</span>
                            </h3>
                            <ul class="text-xs text-slate-700 space-y-2.5 font-medium">
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> Unit Jeep Feroza / Katana 4x4 (4 Pax)</li>
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> BBM Selama Seluruh Rute Trip</li>
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> Driver Ramah & Berpengalaman</li>
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> Tiket Masuk Objek Wisata (Rp 100k/pax)</li>
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> Bebas Biaya Parkir di Semua Lokasi</li>
                                <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i> Dokumentasi Foto/Video HP oleh Driver</li>
                            </ul>
                        </div>

                        <!-- Exclude -->
                        <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                            <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                                <i data-lucide="x-circle" class="w-4 h-4 text-red-600"></i>
                                <span>Tidak Termasuk (Exclude)</span>
                            </h3>
                            <ul class="text-xs text-slate-600 space-y-2.5 font-medium">
                                <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-red-500 shrink-0"></i> Paket Konsumsi / Makan Pribadi</li>
                                <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-red-500 shrink-0"></i> Tiket Wahana Tambahan / Permainan</li>
                                <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-red-500 shrink-0"></i> Ojek Sikunir PP (Opsional Rp 15k/pax)</li>
                                <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-red-500 shrink-0"></i> Perahu Telaga Menjer (Opsional Rp 20k/pax)</li>
                                <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-red-500 shrink-0"></i> Dokumentasi Kamera Pro / Drone 4K</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Card Harga & Booking CTA (Light Theme) -->
                <div class="lg:col-span-4 sticky top-28 space-y-6">
                    <div class="rounded-3xl bg-white border-2 border-red-200 p-6 sm:p-7 shadow-xl shadow-slate-200/80 space-y-6">
                        <div class="space-y-1 pb-4 border-b border-slate-100">
                            <span class="text-[10px] font-mono font-bold uppercase text-slate-500 block tracking-wider">Tarif Resmi 2026 (All In)</span>
                            <div class="text-3xl font-black text-red-600">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </div>
                            <span class="text-xs text-slate-600 font-bold block">per 1 Mobil Jeep (Kapasitas 4 Orang)</span>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2 text-xs">
                            <div class="flex justify-between text-slate-600">
                                <span>Kapasitas:</span>
                                <strong class="text-slate-900">4 Dewasa + 1 Driver</strong>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Konsep:</span>
                                <strong class="text-emerald-700 font-bold">ALL IN (Termasuk Tiket)</strong>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Titik Jemput:</span>
                                <strong class="text-slate-900">Area Wonosobo Kota</strong>
                            </div>
                        </div>

                        <a href="{{ $waUrl }}" target="_blank" class="w-full py-4 rounded-xl bg-gradient-to-r from-red-600 via-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-extrabold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition-all shadow-lg shadow-red-600/25 hover:scale-[1.02] active:scale-98 cursor-pointer">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Booking via WhatsApp</span>
                        </a>

                        <p class="text-[11px] text-center text-slate-500 font-medium">
                            Narahubung Cepat: <strong class="text-slate-800">{{ $jeepWaRaw }}</strong>
                        </p>
                    </div>

                    <!-- Rekening Resmi -->
                    <div class="rounded-2xl bg-white border border-slate-200 p-5 space-y-2 text-xs shadow-sm">
                        <span class="font-extrabold text-slate-700 uppercase block tracking-wider text-[10px]">Rekening Resmi Pembayaran (DP):</span>
                        <p class="text-slate-900 font-mono font-black text-sm">BNI: 8166754042</p>
                        <p class="text-slate-500 text-[11px] font-semibold">a/n PT. GOTRIP ASIA TRAVELINDO</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-[#0f172a] py-8 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Ready Jeep Dieng &bull; Unit Bisnis PT. GOTRIP ASIA TRAVELINDO</p>
    </footer>
</main>
@endsection

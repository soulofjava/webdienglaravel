@extends('layouts.app')

@section('title', 'Lotus Creative — Jasa Fotografer Wisata Dieng, Cinematic Reels & Drone 4K')
@section('meta_description', 'Studio fotografi dan videografi profesional di Dataran Tinggi Dieng. Abadikan momen Golden Sunrise Sikunir, Candi Arjuna, dan Telaga Warna dengan kamera Full-Frame dan aerial drone 4K.')
@section('og_image', asset('images/lotus-creative-logo.png'))

@push('styles')
<style>
    body {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }
    .lotus-gradient-text {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 45%, #e11d48 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .lotus-blue-gradient {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    }
    .lotus-red-gradient {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
    }
    .crosshair-corner {
        position: relative;
    }
    .crosshair-corner::before,
    .crosshair-corner::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        border-color: rgba(2, 132, 199, 0.4);
        pointer-events: none;
    }
    .crosshair-corner::before {
        top: 6px;
        left: 6px;
        border-top: 2px solid;
        border-left: 2px solid;
    }
    .crosshair-corner::after {
        bottom: 6px;
        right: 6px;
        border-bottom: 2px solid;
        border-right: 2px solid;
    }
</style>
@endpush

@section('schema_json')
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'PhotographyBusiness',
        'name' => 'Lotus Creative — Travel Photography & Drone 4K Dieng',
        'image' => asset('images/lotus-creative-logo.png'),
        'telephone' => $settings->whatsapp_number ?: '+628164211196',
        'email' => $settings->email ?: 'halo@lotuscreative.id',
        'url' => url('/?theme=lotus'),
        'priceRange' => 'Rp 500.000 - Rp 2.500.000',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $settings->address ?: 'Jalan Dieng KM 18 Tieng, Kejajar',
            'addressLocality' => 'Wonosobo',
            'addressRegion' => 'Jawa Tengah',
            'postalCode' => '56354',
            'addressCountry' => 'ID',
        ],
        'parentOrganization' => [
            '@type' => 'Organization',
            'name' => $settings->company_name ?: 'PT. GOTRIP ASIA TRAVELINDO',
            'url' => url('/'),
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
<div class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-rose-500/20 selection:text-rose-600 antialiased relative overflow-x-hidden" x-data="{ activeTab: 'all', beforeAfterSplit: 50 }">
    @php
        $rawWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?: '628164211196');
        if (str_starts_with($rawWa, '0')) {
            $lotusWa = '62' . substr($rawWa, 1);
        } else {
            $lotusWa = $rawWa ?: '628164211196';
        }
    @endphp

    <!-- HEADER / NAVIGATION BAR CERAH ELEGAN -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo & Identity -->
            <a href="{{ url('/?theme=lotus') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-white p-1 shadow-md shadow-slate-200/60 border border-slate-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Logo Lotus Creative" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-base sm:text-lg font-black tracking-wider text-sky-600 font-sans">LOTUS</span>
                        <span class="text-base sm:text-lg font-black tracking-wider text-rose-600 font-sans">CREATIVE</span>
                    </div>
                    <span class="text-[9px] font-mono tracking-widest uppercase text-slate-500 font-semibold block">
                        Travel Photography &bull; Dieng
                    </span>
                </div>
            </a>

            <!-- Navigation Links Desktop -->
            <nav class="hidden lg:flex items-center gap-8 text-xs font-semibold text-slate-600">
                <a href="#galeri" class="hover:text-sky-600 transition-colors">Portofolio Karya</a>
                <a href="#spot-wisata" class="hover:text-sky-600 transition-colors">Spot Foto Dieng</a>
                <a href="#paket-harga" class="hover:text-sky-600 transition-colors">Paket & Tarif</a>
                <a href="#gear-studio" class="hover:text-sky-600 transition-colors">Kamera & Drone</a>
                <a href="#kontak" class="hover:text-sky-600 transition-colors">Kontak Studio</a>
            </nav>

            <!-- Actions Header -->
            <div class="flex items-center gap-3">
                <a href="{{ url('/?theme=tiketdieng') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors" title="Kembali ke Portal Biro Wisata">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Portal TiketDieng</span>
                </a>
                <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20tertarik%20dengan%20jasa%20dokumentasi%20foto%20dan%20video%20di%20Dieng.%20Bisa%20info%20ketersediaan%20jadwal%3F" target="_blank" class="px-4 sm:px-5 py-2.5 rounded-full text-xs font-bold text-white bg-gradient-to-r from-sky-500 via-sky-600 to-rose-600 hover:from-sky-600 hover:to-rose-700 transition-all shadow-md shadow-sky-500/25 flex items-center gap-2">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                    <span>Booking Jadwal</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (EDITORIAL MAGAZINE & CAMERA VIEWFINDER VIBE) -->
    <section class="relative pt-12 pb-20 lg:pt-16 lg:pb-28 overflow-hidden bg-gradient-to-b from-white via-sky-50/30 to-[#f8fafc]">
        <!-- Background Grid Patterns & Soft Glow -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f015_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f015_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 left-10 w-96 h-96 bg-rose-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Sisi Kiri: Editorial Copywriting -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Badge Viewfinder Header -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white border border-sky-200 text-sky-700 text-xs font-semibold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span class="font-mono text-[11px] font-bold text-rose-600 uppercase">● LIVE CAPTURE</span>
                        <span class="text-slate-300">|</span>
                        <span>Official Studio PT. GoTrip Asia Travelindo</span>
                    </div>

                    <!-- Main Title -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.12]">
                        Abadikan Momen <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 via-sky-500 to-rose-600 font-serif italic">Magis Dieng</span>
                        Menjadi Karya Sinematik.
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
                        Bebas canggung, dipandu pose dari awal sampai selesai. Abadikan liburan Anda dengan fotografer lokal ramah, video reels 4K estetik, dan pilot drone bersertifikasi.
                    </p>

                    <!-- Camera Meta Specs Strip (Photography Thematic Element) -->
                    <div class="p-3.5 rounded-2xl bg-white border border-slate-200/90 shadow-sm flex flex-wrap items-center gap-4 text-[11px] font-mono text-slate-600">
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-sky-600">LENS</span>
                            <span>24-70mm ƒ/2.8 GM</span>
                        </div>
                        <span class="text-slate-300">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-rose-600">COLOR</span>
                            <span>Lotus Moody Teal & Tangerine</span>
                        </div>
                        <span class="text-slate-300">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-emerald-600">OUTPUT</span>
                            <span>Full Resolution RAW + Jpeg</span>
                        </div>
                    </div>

                    <!-- Call To Actions -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20cek%20ketersediaan%20fotografer%20di%20Dieng" target="_blank" class="px-7 py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-sky-600 via-sky-500 to-rose-600 hover:from-sky-500 hover:to-rose-500 transition-all shadow-xl shadow-sky-500/20 flex items-center gap-2">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Chat WhatsApp Studio</span>
                        </a>
                        <a href="#paket-harga" class="px-7 py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-all shadow-sm flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-sky-500"></i>
                            <span>Lihat Pilihan Paket</span>
                        </a>
                    </div>

                    <!-- 4 Jaminan Layanan Studio -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-200/80">
                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-900 block">File Hari H</span>
                            <span class="text-[11px] text-slate-500 block">Via Google Drive</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-900 block">Free Retouch</span>
                            <span class="text-[11px] text-slate-500 block">Color grading pro</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-900 block">Video Reels</span>
                            <span class="text-[11px] text-slate-500 block">Siap FYP medsos</span>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-900 block">Pilot Drone</span>
                            <span class="text-[11px] text-slate-500 block">Video aerial 4K</span>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Visual Frame Showcase (Editorial Photography Look) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md">
                        <!-- Frame Utama (Gallery Matting Look) -->
                        <div class="bg-white p-4 rounded-3xl shadow-2xl border border-slate-200/80 transform hover:-rotate-1 transition-transform duration-500 crosshair-corner">
                            <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-slate-100">
                                <img
                                    src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=1000&auto=format&fit=crop"
                                    alt="Dokumentasi Wisata Lotus Creative"
                                    class="w-full h-full object-cover"
                                />
                                <!-- Live Camera Overlay -->
                                <div class="absolute inset-0 p-4 flex flex-col justify-between pointer-events-none text-white font-mono text-[10px]">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2 py-0.5 rounded bg-black/50 backdrop-blur-sm flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            <span>4K HDR</span>
                                        </span>
                                        <span class="px-2 py-0.5 rounded bg-black/50 backdrop-blur-sm">ƒ/1.8 &bull; ISO 100</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-black/40 backdrop-blur-sm p-2 rounded-xl">
                                        <span class="font-sans font-bold">Bukit Sikunir Sunrise Spot</span>
                                        <span class="text-sky-300">Dieng Plateau</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Caption Bawah Frame -->
                            <div class="mt-3 px-1 flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-slate-800">Lotus Signature Tone</div>
                                    <div class="text-[10px] text-slate-500 font-mono">Series: Golden Sunrise Hunter</div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    Sony &bull; Full Frame
                                </span>
                            </div>
                        </div>

                        <!-- Mini Floating Card: Drone View -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-3 rounded-2xl shadow-xl border border-slate-200/80 max-w-[200px] hidden sm:block">
                            <div class="aspect-video rounded-xl overflow-hidden mb-2 relative">
                                <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=400&auto=format&fit=crop" alt="Drone Aerial" class="w-full h-full object-cover">
                                <span class="absolute bottom-1 right-1 text-[8px] bg-black/70 text-white px-1 rounded font-mono">AERIAL 4K</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">Telaga Warna View</span>
                            <span class="text-[9px] text-slate-500 block">DJI Mavic 3 Cinematic Fly</span>
                        </div>

                        <!-- Mini Floating Card: Client Rating -->
                        <div class="absolute -top-6 -right-6 bg-white p-3.5 rounded-2xl shadow-xl border border-slate-200/80 hidden sm:flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold">
                                <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i>
                            </div>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">5.0 / 5.0 Rating</div>
                                <div class="text-[10px] text-slate-500">500+ Trip Wisata Terabadikan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: SPOT-SPOT FOTO TERBAIK DIENG -->
    <section id="spot-wisata" class="py-20 bg-white border-y border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200">
                    Lokasi Pemotretan Favorit
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Spot Foto Terindah Dataran Tinggi Dieng
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Fotografer Lotus Creative menguasai setiap sudut terbaik, jam pencahayaan emas (golden hour), dan spot tersembunyi yang jauh dari kerumunan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Spot 1 -->
                <div class="group rounded-3xl overflow-hidden bg-slate-50 border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=600&auto=format&fit=crop" alt="Puncak Sikunir" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-800">
                            05.00 WIB
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-sky-600 transition-colors">Bukit Sikunir Golden Sunrise</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Matahari terbit keemasan berlatar 8 gunung Jawa Tengah. Momen siluet dan kabut awan yang dramatis.
                        </p>
                    </div>
                </div>

                <!-- Spot 2 -->
                <div class="group rounded-3xl overflow-hidden bg-slate-50 border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=600&auto=format&fit=crop" alt="Telaga Warna & Pengilon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-800">
                            09.00 WIB
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-sky-600 transition-colors">Telaga Warna & Batu Pandang</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Gradasi warna danau vulkanik toska zamrud dari ketinggian tebing Ratapan Angin. Spot wajib drone 4K.
                        </p>
                    </div>
                </div>

                <!-- Spot 3 -->
                <div class="group rounded-3xl overflow-hidden bg-slate-50 border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?q=80&w=600&auto=format&fit=crop" alt="Kompleks Candi Arjuna" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-800">
                            Heritage
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-sky-600 transition-colors">Kompleks Candi Arjuna</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Candi tertua di Pulau Jawa bernuansa mistis berselimut kabut tipis dan taman cemara yang estetik.
                        </p>
                    </div>
                </div>

                <!-- Spot 4 -->
                <div class="group rounded-3xl overflow-hidden bg-slate-50 border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=600&auto=format&fit=crop" alt="Kawah Sikidang" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-800">
                            Geothermal
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-sky-600 transition-colors">Kawah Sikidang & Jembatan Kayu</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Jembatan kayu panjang melayang di atas asap kawah vulkanik aktif. Vibe edgy, modern, dan sangat sinematik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: PILIHAN PAKET DOKUMENTASI & TARIF RESMI -->
    <section id="paket-harga" class="py-20 lg:py-28 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-100 text-sky-700 border border-sky-200">
                    Investasi Memori Liburan
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Pilihan Paket Dokumentasi & Tarif Transparan
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Semua paket sudah termasuk seluruh file mentah original dikirim di hari yang sama via Google Drive, editing color grading, dan pengarah gaya ramah.
                </p>
            </div>

            <!-- Grid Paket Dokumentasi Dinamis dari Database (CRUD /admin/packages) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @forelse ($docPackages as $docPkg)
                    @php
                        $isFeatured = $docPkg->is_popular || $loop->first;
                        $pkgInclusions = is_array($docPkg->inclusions) ? $docPkg->inclusions : json_decode($docPkg->inclusions ?? '[]', true);
                    @endphp
                    <div class="rounded-3xl bg-white {{ $isFeatured ? 'border-2 border-sky-500 shadow-2xl relative overflow-hidden ring-4 ring-sky-500/10' : 'border border-slate-200/90 shadow-lg' }} p-7 sm:p-8 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-xl relative">
                        @if ($isFeatured)
                            <div class="absolute top-0 right-0 bg-gradient-to-l from-sky-500 to-rose-500 text-white text-[10px] font-black uppercase px-4 py-1.5 rounded-bl-2xl tracking-widest shadow-sm">
                                {{ $docPkg->badge ?: 'PALING REKOMENDASI' }}
                            </div>
                        @elseif ($docPkg->badge)
                            <div class="absolute top-0 right-0 bg-slate-900 text-white text-[10px] font-bold uppercase px-3 py-1 rounded-bl-xl tracking-wider">
                                {{ $docPkg->badge }}
                            </div>
                        @endif

                        <div class="space-y-6">
                            <div>
                                <span class="text-xs font-mono font-bold {{ $isFeatured ? 'text-sky-600' : 'text-slate-500' }} uppercase tracking-wider">
                                    PAKET {{ sprintf('%02d', $loop->iteration) }} &bull; {{ $docPkg->duration ?: 'FULL TRIP' }}
                                </span>
                                <h3 class="text-xl font-black text-slate-900 mt-1 leading-snug">
                                    {{ $docPkg->title }}
                                </h3>
                                @if ($docPkg->summary)
                                    <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-3">
                                        {{ $docPkg->summary }}
                                    </p>
                                @endif
                            </div>

                            <div class="py-4 border-y border-slate-100">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-black text-slate-900">
                                        Rp {{ number_format($docPkg->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-slate-500 font-medium">/ {{ $docPkg->price_note ?: 'rombongan' }}</span>
                                </div>
                                <span class="text-[11px] {{ $isFeatured ? 'text-rose-600 font-bold' : 'text-emerald-600 font-semibold' }} block mt-1">
                                    ✓ Unlimited RAW Photos + Cinematic Reels + Google Drive
                                </span>
                            </div>

                            <!-- Fasilitas Inclusions -->
                            @if (!empty($pkgInclusions) && is_array($pkgInclusions))
                                <ul class="space-y-2.5 text-xs text-slate-600">
                                    @foreach (array_slice($pkgInclusions, 0, 5) as $inc)
                                        <li class="flex items-start gap-2.5">
                                            <i data-lucide="check-circle-2" class="w-4 h-4 {{ $isFeatured ? 'text-sky-500' : 'text-emerald-500' }} shrink-0 mt-0.5"></i>
                                            <span class="leading-tight">{{ $inc }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-100 space-y-2.5">
                            <a href="https://wa.me/{{ $lotusWa }}?text={{ urlencode('Halo Lotus Creative, saya ingin reservasi ' . $docPkg->title . ' (Rp ' . number_format($docPkg->price, 0, ',', '.') . '). Mohon info tanggal trip yang tersedia.') }}" target="_blank" class="w-full py-3.5 px-4 rounded-2xl text-xs font-bold uppercase tracking-wider text-white {{ $isFeatured ? 'bg-gradient-to-r from-sky-600 via-sky-500 to-rose-600 hover:from-sky-500 hover:to-rose-500 shadow-lg shadow-sky-500/25' : 'bg-slate-900 hover:bg-slate-800' }} transition-all text-center flex items-center justify-center gap-2">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Booking via WhatsApp</span>
                            </a>
                            <a href="{{ route('package.detail', $docPkg->slug) }}" class="w-full py-2 px-3 rounded-xl text-[11px] font-semibold text-slate-500 hover:text-sky-600 bg-slate-50 hover:bg-sky-50 transition-colors text-center block">
                                Rincian Destinasi & Itinerary &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400">
                        Belum ada paket dokumentasi yang dipublikasikan. Kelola paket melalui Admin Dashboard.
                    </div>
                @endforelse
            </div>

            <!-- Opsi Tambahan: Single Spot & Prewedding Custom -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-3xl bg-white border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                    <div class="space-y-1">
                        <span class="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-sky-100 text-sky-700">Opsi Cepat</span>
                        <h4 class="font-bold text-base text-slate-900">Single Spot Quick Session (1 Lokasi)</h4>
                        <p class="text-xs text-slate-500">Butuh sesi foto kilat 1-2 jam di spot tertentu? Hanya Rp 500.000 all-in.</p>
                    </div>
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%2C%20saya%20ingin%20tanya%20Paket%20Single%20Spot%20(Rp%20500.000)" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 shrink-0 transition-colors">
                        Pesan Single Spot
                    </a>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                    <div class="space-y-1">
                        <span class="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-rose-100 text-rose-700">Prewedding & Konsep</span>
                        <h4 class="font-bold text-base text-slate-900">Sesi Prewedding / Campaign Komersial</h4>
                        <p class="text-xs text-slate-500">Konsep busana adat, gaun elegan, wardrobe & makeup artist lokal terpercaya.</p>
                    </div>
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20konsultasi%20sesi%20Prewedding%20di%20Dieng" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 shrink-0 transition-colors">
                        Konsultasi Konsep
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: GEAR & PERALATAN KAMERA STUDIO -->
    <section id="gear-studio" class="py-20 bg-white border-y border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-5 space-y-5">
                    <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200">
                        Peralatan Berkualitas Tinggi
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Standardisasi Kamera Full-Frame & Drone 4K Profesional
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kami tidak berkompromi soal kualitas visual. Setiap sesi didukung oleh perlengkapan kamera kelas bioskop dan lensa prime terbaik untuk menghasilkan warna yang tajam, bokeh menawan, dan dynamic range luas di cuaca ekstrem Dieng.
                    </p>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="font-bold text-xs text-slate-900 flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-sky-600"></i>
                            <span>Cadangan Alat & Baterai Dingin Ekstrem</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Suhu Dieng bisa mencapai minus derajat di musim kemarau. Tim kami membawa pemanas baterai dan body kamera weather-sealed tahan kabut embun.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">Sony Alpha Mirrorless Full-Frame</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Sensor 33MP+, autofokus mata presisi real-time, warna kulit natural, dan performa low-light luar biasa saat subuh di Sikunir.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold">
                            <i data-lucide="aperture" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">Sony G-Master & Zeiss Lenses</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Lensa bukaan besar ƒ/1.4 - ƒ/2.8 menghasilkan latar belakang bokeh lembut nan estetik yang memisahkan subjek dari keramaian wisata.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <i data-lucide="navigation" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">DJI Drone Aerial 4K UHD</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Pengambilan sudut pandang burung beresolusi 4K dengan profil D-Log untuk menangkap luasnya bentang alam kawah dan perbukitan Dieng.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                            <i data-lucide="video" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900">DJI RS Gimbal & Mic Wireless</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Pergerakan kamera super mulus bebas guncangan untuk kebutuhan cinematic reels Instagram & TikTok tanpa patah-patah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: ALUR PEMESANAN & CARA KERJA (WORKFLOW) -->
    <section class="py-20 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-200 text-slate-700">
                    Sangat Praktis & Mudah
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    4 Langkah Mudah Memiliki Foto Liburan Impian
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-3xl bg-white border border-slate-200 space-y-3 shadow-sm relative">
                    <span class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-mono font-bold text-sm">01</span>
                    <h3 class="font-bold text-base text-slate-900">Pilih Tanggal & Paket</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Hubungi admin WhatsApp kami untuk konfirmasi tanggal liburan dan paket yang paling cocok untuk Anda.</p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 space-y-3 shadow-sm relative">
                    <span class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-mono font-bold text-sm">02</span>
                    <h3 class="font-bold text-base text-slate-900">Temu Fotografer di Dieng</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Fotografer standby menjemput atau bertemu langsung di lobi penginapan / titik kumpul spot wisata Anda.</p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 space-y-3 shadow-sm relative">
                    <span class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center font-mono font-bold text-sm">03</span>
                    <h3 class="font-bold text-base text-slate-900">Sesi Foto Seru & Asyik</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Cukup nikmati momen liburan Anda! Fotografer memandu pose terbaik secara santai dan natural tanpa rasa kaku.</p>
                </div>

                <div class="p-6 rounded-3xl bg-white border border-slate-200 space-y-3 shadow-sm relative">
                    <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-mono font-bold text-sm">04</span>
                    <h3 class="font-bold text-base text-slate-900">Terima Hasil di Hari H</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Semua file foto mentah dikirim hari itu juga via link privat Google Drive. Foto edit pilihan dikirim menyusul.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: KONTAK & STUDIO INFORMASI -->
    <section id="kontak" class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-5 space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Logo Lotus" class="w-12 h-12 object-contain rounded-2xl border border-slate-200 p-1 bg-white shadow-sm">
                        <div>
                            <h3 class="font-black text-lg text-slate-900">LOTUS CREATIVE STUDIO</h3>
                            <p class="text-xs text-slate-500 font-mono">Unit Bisnis {{ $settings->company_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ $settings->about_us ?: 'Lotus Creative adalah studio fotografi & videografi perjalanan berbasis di Wonosobo - Dieng Plateau. Spesialis dokumentasi liburan estetik, video reels, dan drone 4K.' }}
                    </p>

                    <!-- Informasi Rekening Resmi -->
                    <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200 space-y-2">
                        <div class="flex items-center gap-2 text-amber-800 font-bold text-xs">
                            <i data-lucide="credit-card" class="w-4 h-4 text-amber-600"></i>
                            <span>Rekening Resmi Pembayaran / DP</span>
                        </div>
                        <div class="text-xs text-slate-700">
                            <div>Bank: <strong class="text-slate-900">{{ $settings->bank_name ?: 'BNI Cabang Wonosobo' }}</strong></div>
                            <div class="font-mono text-base font-black text-amber-800 tracking-wider mt-0.5">{{ $settings->bank_account_number ?: '8166754042' }}</div>
                            <div class="text-[11px] text-slate-600 uppercase font-semibold">a.n. {{ $settings->bank_account_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Alamat -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                        <div class="flex items-center gap-2 text-sky-600 font-bold text-xs">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            <span>Alamat Studio & Kantor</span>
                        </div>
                        <p class="text-xs text-slate-700 leading-relaxed">
                            {{ $settings->address ?: 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351 / Jalan Dieng KM 18 Tieng, Kejajar' }}
                        </p>
                    </div>

                    <!-- Kontak CS -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                        <div class="flex items-center gap-2 text-emerald-600 font-bold text-xs">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                            <span>Customer Service WhatsApp</span>
                        </div>
                        <p class="text-sm font-bold text-slate-900 font-mono">{{ $settings->phone_number ?: '+62 816-4211-196' }}</p>
                        <p class="text-[10px] text-slate-500">Standby konsultasi jadwal 24 Jam</p>
                    </div>

                    <!-- Email -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-1.5">
                        <div class="flex items-center gap-2 text-rose-600 font-bold text-xs">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span>Email Korespondensi</span>
                        </div>
                        <p class="text-xs text-slate-900 font-mono font-semibold">{{ $settings->email ?: 'halo@lotuscreative.id' }}</p>
                    </div>

                    <!-- Sosial Media -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="flex items-center gap-2 text-rose-500 font-bold text-xs">
                            <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>Instagram Portofolio</span>
                        </div>
                        <a href="{{ $settings->instagram_url ?: 'https://www.instagram.com/lotus.creative01' }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:underline font-mono">
                            <span>{{ $settings->instagram_url ? '@' . basename(rtrim($settings->instagram_url, '/')) : '@lotus.creative01' }}</span>
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER CERAH & BERSIH -->
    <footer class="py-8 bg-slate-100 border-t border-slate-200 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Lotus Creative &bull; Travel Photography & Drone 4K &bull; Seluruh hak cipta dilindungi.</p>
    </footer>

    <!-- FLOATING WHATSAPP BUTTON (CERAH & MENONJOL) -->
    <div class="fixed bottom-6 right-6 z-50">
        <a 
            href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20tertarik%20dengan%20jasa%20fotografer%20wisata%20Dieng" 
            target="_blank" 
            class="flex items-center gap-2.5 px-5 py-3.5 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold text-xs shadow-2xl shadow-emerald-500/40 hover:scale-105 transition-all duration-300"
            title="Chat WhatsApp Studio Lotus Creative"
        >
            <i data-lucide="message-circle" class="w-5 h-5"></i>
            <span class="hidden sm:inline">Booking Fotografer</span>
        </a>
    </div>
</div>
@endsection

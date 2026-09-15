@extends('layouts.app')

@section('title', 'Jasa Dokumentasi Dieng — Lotus Creative Photography & Drone 4K')
@section('meta_description', 'Layanan dokumentasi foto & video profesional di Dataran Tinggi Dieng oleh Lotus Creative. Abadikan momen Golden Sunrise, Kawah Sikidang, Telaga Warna dengan kamera mirrorless & aerial drone 4K.')
@section('og_image', asset('images/lotus-creative-logo.png'))

@section('schema_json')
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => 'Lotus Creative — Travel Photography & Aerial Videography Dieng',
        'image' => asset('images/lotus-creative-logo.png'),
        'telephone' => '+628164211196',
        'email' => 'lotuscreative465@gmail.com',
        'url' => url('/dokumentasi'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jalan Dieng KM 18 Rt 01/02 Tieng, Kejajar',
            'addressLocality' => 'Wonosobo',
            'addressRegion' => 'Jawa Tengah',
            'postalCode' => '56354',
            'addressCountry' => 'ID',
        ],
        'priceRange' => 'Rp 500.000 - Rp 2.500.000',
        'parentOrganization' => [
            '@type' => 'Organization',
            'name' => 'PT. GOTRIP ASIA TRAVELINDO',
            'url' => url('/'),
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
<main class="relative min-h-screen bg-[#06080d] text-slate-100 overflow-hidden font-sans">
    @php
        $lotusWa = preg_replace('/[^0-9]/', '', $settings->whatsapp_number ?: '628164211196');
        if (str_starts_with($lotusWa, '0')) {
            $lotusWa = '62' . substr($lotusWa, 1);
        }
    @endphp

    <!-- FLOATING NAVBAR LOTUS CREATIVE -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div class="max-w-7xl mx-auto rounded-2xl bg-black/40 backdrop-blur-xl py-3 px-5 sm:px-8 border border-white/10 flex items-center justify-between shadow-2xl">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Lotus Creative Logo" class="h-10 sm:h-11 w-auto object-contain rounded-xl bg-black/60 border border-white/10 p-1 group-hover:scale-105 transition-transform duration-300">
                <div>
                    <span class="font-serif font-black text-sm sm:text-base tracking-wider text-white flex items-center gap-1.5">
                        <span>LOTUS CREATIVE</span>
                        <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">PHOTO & DRONE</span>
                    </span>
                    <p class="text-[10px] text-slate-400">Unit Dokumentasi Resmi PT. GoTrip Asia Travelindo</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-medium text-slate-300">
                <a href="#paket" class="hover:text-cyan-400 transition-colors">Pilihan Paket</a>
                <a href="#fasilitas" class="hover:text-cyan-400 transition-colors">Fasilitas Termasuk</a>
                <a href="#kontak" class="hover:text-cyan-400 transition-colors">Kontak & Studio</a>
                <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-300 flex items-center gap-1 font-semibold">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke TiketDieng</span>
                </a>
            </nav>

            <!-- CTA WA Header -->
            <div class="flex items-center gap-2">
                <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20tertarik%20dengan%20layanan%20dokumentasi%20wisata%20Dieng.%20Boleh%20tanya%20ketersediaan%20jadwal%3F" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-white bg-gradient-to-r from-cyan-500 via-cyan-400 to-blue-600 hover:from-cyan-400 hover:to-blue-500 transition-all duration-300 shadow-lg shadow-cyan-500/25 hover:-translate-y-0.5">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Hubungi Studio</span>
                    <span class="sm:hidden">WhatsApp</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO BANNER SECTION -->
    <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-28 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto overflow-hidden">
        <!-- Glow Orbs (Cyan & Crimson Rose) -->
        <div class="absolute -top-10 left-1/4 w-[500px] h-[500px] bg-cyan-500/15 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-[450px] h-[450px] bg-rose-500/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[11px] font-bold tracking-widest uppercase bg-gradient-to-r from-cyan-500/20 via-blue-500/10 to-rose-500/20 text-cyan-300 border border-cyan-500/30">
                    <i data-lucide="camera" class="w-3.5 h-3.5 text-cyan-400"></i>
                    <span>JASA DOKUMENTASI RESMI DATARAN TINGGI DIENG</span>
                </div>

                <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-tight">
                    Abadikan Setiap <span class="bg-gradient-to-r from-cyan-400 via-sky-300 to-rose-400 bg-clip-text text-transparent">Momen Ajaib</span> di Tanah Dieng
                </h1>

                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Jangan biarkan momen berharga Anda di Dieng hanya terlewat di galeri ponsel biasa. Bersama <strong class="text-white font-semibold">Lotus Creative</strong>, nikmati foto visual tajam, video reels sinematik estetik, dan rekaman udara drone 4K berstandar profesional.
                </p>

                <!-- Value Highlights Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-left">
                    <div class="p-3 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
                        <div class="flex items-center gap-2 text-cyan-400 mb-1">
                            <i data-lucide="video" class="w-4 h-4"></i>
                            <span class="text-xs font-bold text-white">Aerial Drone 4K</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Footage lanskap megah dari udara</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
                        <div class="flex items-center gap-2 text-rose-400 mb-1">
                            <i data-lucide="film" class="w-4 h-4"></i>
                            <span class="text-xs font-bold text-white">Reels & TikTok</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Video sinematik siap unggah medsos</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md col-span-2 sm:col-span-1">
                        <div class="flex items-center gap-2 text-amber-400 mb-1">
                            <i data-lucide="hard-drive" class="w-4 h-4"></i>
                            <span class="text-xs font-bold text-white">Unlimited RAW</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Semua file mentah diberikan tanpa batas</p>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#paket" class="px-7 py-3.5 rounded-full text-xs font-bold text-black bg-gradient-to-r from-cyan-400 via-cyan-300 to-sky-400 hover:from-cyan-300 hover:to-sky-300 transition-all duration-300 shadow-xl shadow-cyan-500/30 hover:-translate-y-0.5 flex items-center gap-2">
                        <i data-lucide="list-checks" class="w-4 h-4"></i>
                        <span>Lihat 5 Pilihan Paket</span>
                    </a>
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20tanya%20jadwal%20dan%20konsultasi%20dokumentasi%20foto%20Dieng" target="_blank" class="px-7 py-3.5 rounded-full text-xs font-bold text-slate-200 hover:text-white bg-white/10 hover:bg-white/15 border border-white/15 transition-all duration-300 flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Konsultasi WA: 0816-4211-196</span>
                    </a>
                </div>
            </div>

            <!-- Right Hero Visual Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-3xl overflow-hidden border border-white/15 shadow-2xl shadow-cyan-500/10 group">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1200&auto=format&fit=crop" alt="Dokumentasi Lotus Creative Dieng" class="w-full h-80 sm:h-[420px] object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#06080d] via-[#06080d]/40 to-transparent"></div>

                    <!-- Overlay Badge Info -->
                    <div class="absolute bottom-5 left-5 right-5 p-4 rounded-2xl bg-black/60 backdrop-blur-md border border-white/10">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Lotus Creative" class="w-12 h-12 object-contain rounded-xl bg-black/80 border border-white/15 p-1">
                            <div>
                                <h4 class="font-bold text-sm text-white">LOTUS CREATIVE STUDIO</h4>
                                <p class="text-xs text-cyan-300">Tieng, Kejajar, Wonosobo</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Partner resmi PT. GoTrip Asia Travelindo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: 5 PAKET DOKUMENTASI LENGKAP -->
    <section id="paket" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20 relative">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 mb-3">
                <i data-lucide="tag" class="w-3 h-3 text-cyan-400"></i>
                <span>TARIF TRANSPARAN RESMI</span>
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">
                5 Pilihan Paket Dokumentasi Dieng
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                Pilih paket yang sesuai dengan rute liburan Anda. Tersedia mulai dari sesi fajar Sunrise Only, spot panorama air terjun, hingga paket all-in 13 destinasi dengan drone 4K.
            </p>
        </div>

        <!-- 5 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            
            <!-- PAKET 1: ULTIMATE ALL DIENG SPOTS (FEATURED) -->
            <div class="rounded-3xl p-7 border border-cyan-500/50 bg-gradient-to-b from-cyan-950/30 via-black/40 to-black/60 shadow-2xl shadow-cyan-500/15 flex flex-col justify-between relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 md:col-span-2 lg:col-span-1">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl pointer-events-none"></div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-md">
                            ⭐ PALING LENGKAP + DRONE 4K
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-cyan-400"></i>
                            <span>1 Hari Penuh</span>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-black text-white group-hover:text-cyan-300 transition-colors">
                            Paket 1: Ultimate All Dieng Spots
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Paket dokumentasi terlengkap mencakup 13 spot terindah Dieng dari fajar hingga senja, rekaman udara drone 4K, foto ber-color grading, dan video sinematik.
                        </p>
                    </div>

                    <!-- Price -->
                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-cyan-500/20">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Layanan Resmi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl sm:text-4xl font-black text-cyan-400 font-mono">Rp 2.500.000</span>
                            <span class="text-xs text-slate-400">/ trip lengkap</span>
                        </div>
                    </div>

                    <!-- 13 Destination Spots -->
                    <div>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-cyan-400"></i>
                            <span>13 Objek Wisata yang Didokumentasikan:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach([
                                'Sunrise Sikunir/Pintu Langit', 'Kawah Sikidang', 'Batu Ratapan Angin', 
                                'Telaga Warna', 'Candi Dieng', 'Taman/Pintu Langit', 'Pemandian Air Panas', 
                                'Kebun Teh Panama', 'Telaga Menjer', 'Pandangan Pertama', 'Kahyangan Skyline', 
                                'Air Terjun Sikarim', 'Swiss Van Java'
                            ] as $spot)
                                <span class="px-2.5 py-1 rounded-lg bg-cyan-950/40 border border-cyan-500/30 text-[10px] text-cyan-200 font-medium">
                                    {{ $spot }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Book Button -->
                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20booking%20Paket%201%20Ultimate%20All%20Dieng%20Spots%20(Rp%202.500.000)%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-black bg-gradient-to-r from-cyan-400 to-sky-300 hover:from-cyan-300 hover:to-sky-200 transition-all duration-300 shadow-lg shadow-cyan-500/20 text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Booking Paket 1 via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- PAKET 2: HERITAGE & NATURE -->
            <div class="rounded-3xl p-7 border border-white/10 bg-white/[0.02] hover:border-white/20 shadow-xl flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/10 text-amber-300 border border-white/10">
                            SUNRISE + HERITAGE
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Sesi Wisata Pagi</span>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                            Paket 2: Heritage & Nature
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Kombinasi klasik sunrise Dieng dan peninggalan candi bersejarah serta keindahan dua danau alami Dieng.
                        </p>
                    </div>

                    <!-- Price -->
                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/5">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Layanan Resmi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl font-black text-white font-mono">Rp 1.200.000</span>
                            <span class="text-xs text-slate-400">/ trip</span>
                        </div>
                    </div>

                    <!-- Destinations -->
                    <div>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-cyan-400"></i>
                            <span>5 Objek Wisata:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(['Sunrise Sikunir', 'Kawah Sikidang', 'Komplek Candi (tanpa drone)', 'Telaga Warna', 'Batu Ratapan Angin'] as $spot)
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-[10px] text-slate-300">
                                    {{ $spot }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20booking%20Paket%202%20Heritage%20%26%20Nature%20(Rp%201.200.000)%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/15 border border-white/15 hover:border-cyan-500/40 transition-all duration-300 text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Booking Paket 2 via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- PAKET 3: SCENIC PANORAMIC & WATERFALLS -->
            <div class="rounded-3xl p-7 border border-white/10 bg-white/[0.02] hover:border-white/20 shadow-xl flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/20 text-rose-300 border border-rose-500/30">
                            PANORAMA LEMBAH & AIR TERJUN
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>Sesi Scenic Trip</span>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                            Paket 3: Scenic & Waterfalls
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Rute eksotis jalur Sikarim dan Telaga Menjer dengan pemandangan lembah Swiss Van Java yang memukau.
                        </p>
                    </div>

                    <!-- Price -->
                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/5">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Layanan Resmi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl font-black text-white font-mono">Rp 1.400.000</span>
                            <span class="text-xs text-slate-400">/ trip</span>
                        </div>
                    </div>

                    <!-- Destinations -->
                    <div>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400"></i>
                            <span>5 Objek Wisata:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(['Sunrise Sikunir', 'Air Terjun Sikarim', 'Swiss Van Java', 'Telaga Menjer', 'Pandangan Pertama'] as $spot)
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-[10px] text-slate-300">
                                    {{ $spot }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20booking%20Paket%203%20Scenic%20%26%20Waterfalls%20(Rp%201.400.000)%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/15 border border-white/15 hover:border-cyan-500/40 transition-all duration-300 text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Booking Paket 3 via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- PAKET 4: GOLDEN SUNRISE ONLY -->
            <div class="rounded-3xl p-7 border border-white/10 bg-white/[0.02] hover:border-white/20 shadow-xl flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            KHUSUS SUNRISE FAJAR
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>04.00 – 07.30 WIB</span>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                            Paket 4: Golden Sunrise Only
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Fokus penuh pada dokumentasi momen terbitnya matahari di puncak bukit Dieng dengan pencahayaan golden hour sempurna.
                        </p>
                    </div>

                    <!-- Price -->
                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/5">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Layanan Resmi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl font-black text-white font-mono">Rp 1.000.000</span>
                            <span class="text-xs text-slate-400">/ sesi subuh</span>
                        </div>
                    </div>

                    <!-- Destinations -->
                    <div>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-amber-400"></i>
                            <span>Cakupan Spot:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-3 py-1 rounded-lg bg-amber-500/10 border border-amber-500/30 text-[10px] text-amber-200">
                                Sunrise Only (Bukit Sikunir / Pintu Langit / Spot Pilihan)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20booking%20Paket%204%20Golden%20Sunrise%20Only%20(Rp%201.000.000)%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/15 border border-white/15 hover:border-cyan-500/40 transition-all duration-300 text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Booking Paket 4 via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- PAKET 5: SINGLE SPOT REGULER (NON-SUNRISE) -->
            <div class="rounded-3xl p-7 border border-white/10 bg-white/[0.02] hover:border-white/20 shadow-xl flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            SINGLE SPOT HEMAT
                        </span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                            <span>2 – 3 Jam Sesi</span>
                        </span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                            Paket 5: Single Spot Reguler
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Sesi foto santai pada 1 destinasi wisata pilihan (siang/sore hari) tanpa bangun subuh. Sangat hemat dan fleksibel.
                        </p>
                    </div>

                    <!-- Price -->
                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/5">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Harga Layanan Resmi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl font-black text-white font-mono">Rp 500.000</span>
                            <span class="text-xs text-slate-400">/ spot wisata</span>
                        </div>
                    </div>

                    <!-- Destinations -->
                    <div>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Cakupan Spot:</span>
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-3 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-[10px] text-emerald-200">
                                1 Destinasi Wisata Pilihan (Non-Sunrise)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20booking%20Paket%205%20Single%20Spot%20(Rp%20500.000)%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/15 border border-white/15 hover:border-cyan-500/40 transition-all duration-300 text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                        <span>Booking Paket 5 via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- KONSULTASI CUSTOM TRIP CARD -->
            <div class="rounded-3xl p-7 border border-rose-500/30 bg-gradient-to-br from-rose-950/20 via-black/40 to-black/60 shadow-xl flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-500/20 text-rose-300 border border-rose-500/30">
                            CUSTOM & PREWEDDING
                        </span>
                        <span class="text-xs text-rose-300 font-mono">Bisa Request Rute</span>
                    </div>

                    <div>
                        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white group-hover:text-rose-300 transition-colors">
                            Paket Khusus & Prewedding
                        </h3>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Punya konsep foto prewedding, video profil perusahaan, atau gathering keluarga besar? Tim Lotus Creative siap menyesuaikan rute dan durasi khusus sesuai keinginan Anda.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white/[0.04] border border-white/5">
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-medium">Estimasi Biaya</span>
                        <span class="text-xl font-bold text-rose-400 mt-1 block">Konsultasi Gratis via WA</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 mt-6">
                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20konsultasi%20paket%20dokumentasi%20khusus%2Fprewedding%20di%20Dieng" target="_blank" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-400 hover:to-pink-500 transition-all duration-300 text-center flex items-center justify-center gap-2 shadow-lg shadow-rose-500/20">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        <span>Diskusi Konsep Khusus</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION: FASILITAS INCLUDE & EXCLUDE -->
    <section id="fasilitas" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-cyan-500/10 text-cyan-300 border border-cyan-500/20 mb-3">
                <i data-lucide="check-circle-2" class="w-3 h-3 text-cyan-400"></i>
                <span>KEJELASAN LAYANAN</span>
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">
                Fasilitas Dokumentasi Termasuk & Tidak Termasuk
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                Kami menjunjung tinggi transparansi tanpa biaya tersembunyi. Berikut rincian resmi fasilitas yang Anda dapatkan di setiap sesi trip Lotus Creative.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- FASILITAS INCLUDE -->
            <div class="rounded-3xl p-8 bg-gradient-to-b from-emerald-950/20 via-white/[0.02] to-transparent border border-emerald-500/30 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400">
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Sudah Termasuk (Include)</h3>
                        <p class="text-xs text-emerald-300">Fasilitas utama dokumentasi resmi Lotus Creative</p>
                    </div>
                </div>

                <ul class="space-y-4 text-xs sm:text-sm text-slate-300">
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Tim Profesional Berpengalaman:</strong>
                            <p class="text-xs text-slate-400 mt-0.5">1–2 orang fotografer atau videografer profesional yang hafal angle terbaik dan waktu pencahayaan ideal di Dieng.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Peralatan Standar Industri:</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Penggunaan kamera DSLR/Mirrorless premium, lensa variatif (wide angle & telephoto), serta flash lighting pendukung.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Pengambilan Video Udara (Drone 4K):</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Footage udara aerial sinematik (tersedia di Paket 1 atau opsi paket lengkap ber-drone).</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Seluruh File Mentah (Unlimited RAW/Footage):</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Semua foto dan klip video mentah tanpa batas (unlimited) selama durasi trip akan diberikan kepada Anda.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Hasil Edit & Color Grading Estetik:</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Foto pilihan terbaik yang telah di-grading warnanya serta video berdurasi pendek (cinematic reels/TikTok) yang siap unggah.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="text-white font-semibold">Media Penyimpanan Fleksibel:</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Pengiriman file cepat melalui tautan Google Drive berkecepatan tinggi atau copy langsung via Flashdisk khusus.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- FASILITAS EXCLUDE -->
            <div class="rounded-3xl p-8 bg-gradient-to-b from-rose-950/20 via-white/[0.02] to-transparent border border-rose-500/30 space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/20 border border-rose-500/40 flex items-center justify-center text-rose-400">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Belum Termasuk (Exclude)</h3>
                            <p class="text-xs text-rose-300">Biaya personal yang tidak termasuk di jasa foto</p>
                        </div>
                    </div>

                    <ul class="space-y-4 text-xs sm:text-sm text-slate-300">
                        <li class="flex items-start gap-3">
                            <i data-lucide="x" class="w-4 h-4 text-rose-400 shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="text-white font-semibold">Tiket Masuk Wisata Dieng:</strong>
                                <p class="text-xs text-slate-400 mt-0.5">Tiket retribusi masuk destinasi wisata (dibayar mandiri atau bisa dipaketkan dengan paket tour TiketDieng).</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="x" class="w-4 h-4 text-rose-400 shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="text-white font-semibold">Paket Makan & Konsumsi:</strong>
                                <p class="text-xs text-slate-400 mt-0.5">Makan pagi/siang/malam selama perjalanan trip.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="x" class="w-4 h-4 text-rose-400 shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="text-white font-semibold">Tiket Wahana / Permainan Berbayar:</strong>
                                <p class="text-xs text-slate-400 mt-0.5">Spot wahana berbayar opsional (misal sewa jembatan kaca, flying fox, perahu, jeep, dll).</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Info Box Kolaborasi TiketDieng -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 mt-6">
                    <div class="flex items-start gap-3">
                        <i data-lucide="sparkles" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            <strong class="text-white">Tips Hemat:</strong> Jika Anda memesan paket tur all-inclusive di <a href="{{ route('home') }}" class="text-amber-400 underline">TiketDieng.com</a>, tiket masuk wisata, armada shuttle, dan homestay sudah otomatis tercakup!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: KONTAK STUDIO & INFORMASI PEMBAYARAN RESMI -->
    <section id="kontak" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20">
        <div class="rounded-3xl border border-white/15 bg-gradient-to-b from-slate-900/60 via-black/50 to-black/80 p-8 sm:p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Info Studio & Kontak -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Lotus Creative" class="w-14 h-14 object-contain rounded-2xl bg-black border border-white/15 p-2 shadow-xl">
                        <div>
                            <span class="text-[10px] font-bold text-cyan-300 tracking-widest uppercase block">STUDIO RESMI</span>
                            <h3 class="font-serif text-2xl font-bold text-white">Lotus Creative Dieng</h3>
                            <p class="text-xs text-slate-400">Unit Usaha Resmi PT. GOtrip Asia Travelindo</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-300 pt-2">
                        <!-- Alamat -->
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                            <div class="flex items-center gap-2 text-rose-400 font-bold mb-1">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                <span>Alamat Studio</span>
                            </div>
                            <p class="text-slate-300 font-medium leading-relaxed">
                                {{ $settings->address ?: 'Jalan Dieng KM 18 Rt 01/02 Tieng, Kejajar, Wonosobo, Jawa Tengah 56354' }}
                            </p>
                        </div>

                        <!-- Telepon & WA -->
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                            <div class="flex items-center gap-2 text-emerald-400 font-bold mb-1">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                                <span>Telepon / WhatsApp</span>
                            </div>
                            <p class="text-lg font-bold text-white font-mono">{{ $settings->phone_number ?: '0816-4211-196' }}</p>
                            <p class="text-[11px] text-slate-400">CS Lotus Creative Standby 24 Jam</p>
                        </div>

                        <!-- Email -->
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                            <div class="flex items-center gap-2 text-cyan-400 font-bold mb-1">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                                <span>Email Korespondensi</span>
                            </div>
                            <p class="text-white font-mono">{{ $settings->email ?: 'halo@lotuscreative.id' }}</p>
                        </div>

                        <!-- Rekening Bank -->
                        <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-1">
                            <div class="flex items-center gap-2 text-amber-400 font-bold mb-1">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                                <span>Rekening Pembayaran Resmi</span>
                            </div>
                            <p class="text-xs text-slate-300 font-semibold">{{ $settings->bank_name ?: 'BNI — Cabang Wonosobo' }}</p>
                            <p class="text-base font-black text-amber-300 font-mono tracking-wider">{{ $settings->bank_account_number ?: '8166754042' }}</p>
                            <p class="text-[10px] text-slate-400 uppercase">a.n. {{ $settings->bank_account_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}</p>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <span class="text-xs text-slate-400 font-medium">Ikuti Portofolio:</span>
                        <a href="{{ $settings->instagram_url ?: 'https://www.instagram.com/lotus.creative01?stnk=dG83cjF1NHptaXB3' }}" target="_blank" class="px-3.5 py-1.5 rounded-full bg-pink-500/10 hover:bg-pink-500/20 border border-pink-500/30 text-pink-300 text-xs flex items-center gap-1.5 transition-colors">
                            <i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-400"></i>
                            <span>{{ $settings->instagram_url ? '@' . basename(rtrim($settings->instagram_url, '/')) : '@lotus.creative01' }}</span>
                        </a>
                        <a href="https://www.tiktok.com/@lotuscreative_?_r=1&_t=ZS-99iFr2JbCcc" target="_blank" class="px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-slate-200 text-xs flex items-center gap-1.5 transition-colors">
                            <i data-lucide="video" class="w-3.5 h-3.5 text-cyan-400"></i>
                            <span>@lotuscreative_</span>
                        </a>
                        <a href="https://www.facebook.com/share/1Hj4SzNUzH/" target="_blank" class="px-3.5 py-1.5 rounded-full bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/30 text-blue-300 text-xs flex items-center gap-1.5 transition-colors">
                            <i data-lucide="facebook" class="w-3.5 h-3.5 text-blue-400"></i>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>

                <!-- Call to Action Card -->
                <div class="lg:col-span-5 p-7 rounded-3xl bg-gradient-to-b from-cyan-950/40 to-black/60 border border-cyan-500/30 text-center space-y-5">
                    <div class="w-16 h-16 rounded-2xl bg-cyan-500/20 border border-cyan-500/40 mx-auto flex items-center justify-center text-cyan-300">
                        <i data-lucide="calendar" class="w-8 h-8"></i>
                    </div>

                    <div>
                        <h4 class="font-serif text-xl font-bold text-white">Booking Tanggal Trip Anda</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                            Jadwal fotografer dan pilot drone di akhir pekan (*weekend*) dan musim liburan cepat penuh. Segera amankan tanggal kunjungan Anda hari ini.
                        </p>
                    </div>

                    <a href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20ingin%20cek%20ketersediaan%20jadwal%20dokumentasi%20untuk%20tanggal%3A%20" target="_blank" class="w-full py-3.5 px-6 rounded-2xl text-xs font-black uppercase tracking-wider text-black bg-gradient-to-r from-cyan-400 to-sky-300 hover:from-cyan-300 hover:to-sky-200 transition-all duration-300 shadow-xl shadow-cyan-500/30 flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Chat WhatsApp Studio Sekarang</span>
                    </a>

                    <p class="text-[10px] text-slate-400">
                        🔒 Pembayaran DP aman via rekening resmi PT. GOTRIP ASIA TRAVELINDO
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER LOTUS CREATIVE -->
    <footer class="border-t border-white/10 py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center text-xs text-slate-400 space-y-3">
        <div class="flex items-center justify-center gap-2">
            <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Lotus Creative" class="w-6 h-6 object-contain">
            <span class="font-bold text-white tracking-wider">LOTUS CREATIVE — TRAVEL PHOTOGRAPHY DIENG</span>
        </div>
        <p class="text-[11px] text-slate-400">
            Jalan Dieng KM 18 Rt 01/02 Tieng, Kejajar, Wonosobo 56354 • WhatsApp: 0816-4211-196
        </p>
        <p class="text-[10px] text-slate-400">
            © {{ date('Y') }} PT. GOTRIP ASIA TRAVELINDO. All rights reserved.
        </p>
    </footer>

    <!-- FLOATING WHATSAPP BUTTON KHUSUS LOTUS CREATIVE -->
    <div class="fixed bottom-6 right-6 z-50">
        <a 
            href="https://wa.me/{{ $lotusWa }}?text=Halo%20Lotus%20Creative%2C%20saya%20tertarik%20dengan%20layanan%20dokumentasi%20foto%2Fvideo%20di%20Dieng" 
            target="_blank" 
            class="flex items-center gap-2.5 px-4 py-3 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold text-xs shadow-2xl shadow-emerald-500/40 hover:scale-105 transition-all duration-300 group"
            title="Chat WhatsApp Studio Lotus Creative"
        >
            <i data-lucide="message-circle" class="w-5 h-5 fill-white text-[#25D366]"></i>
            <span class="hidden sm:inline">Tanya Jadwal Lotus Creative</span>
        </a>
    </div>

</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
@endpush

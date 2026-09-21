@extends('layouts.app')

@section('title', 'Ready Jeep Dieng — Sewa Jeep Wisata Offroad 4x4 Dataran Tinggi Dieng (All In)')
@section('meta_description', 'Sewa Jeep Wisata Dieng 4x4 resmi berkonsep ALL IN dari Ready Jeep Dieng. Paket Golden Sunrise Sikunir, Kawah Sikidang, Candi Dieng, Telaga Menjer & Sikarim. Sudah termasuk armada 4x4, BBM, driver, parkir, dan tiket wisata Rp 100k/orang.')
@section('og_image', asset('images/ready-jeep-dieng-logo.jpeg'))

@push('styles')
<style>
    body {
        background-color: #f8fafc !important;
        color: #0f172a !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .jeep-red-gradient {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
    }
    .jeep-light-mesh {
        background-color: #f8fafc;
        background-image: 
            radial-gradient(at 0% 0%, rgba(220, 38, 38, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(220, 38, 38, 0.04) 0px, transparent 50%),
            radial-gradient(rgba(220, 38, 38, 0.05) 1.5px, transparent 1.5px);
        background-size: 100% 100%, 100% 100%, 28px 28px;
    }
    .jeep-card-shadow {
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.06), 0 4px 10px -2px rgba(15, 23, 42, 0.03);
    }
    .jeep-card-hover {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .jeep-card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 35px -8px rgba(220, 38, 38, 0.12), 0 8px 16px -4px rgba(15, 23, 42, 0.06);
    }
</style>
@endpush

@section('schema_json')
@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'TravelAgency',
        'name' => 'Ready Jeep Dieng — Sewa Jeep Wisata 4x4 All In',
        'image' => asset('images/ready-jeep-dieng-logo.jpeg'),
        'telephone' => $settings->whatsapp_number ?: '081325631952',
        'email' => $settings->email ?: 'jeep@tiketdieng.com',
        'url' => url('/?theme=jeep'),
        'priceRange' => 'Rp 700.000 - Rp 1.500.000',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $settings->address ?: 'Jl. Dieng Km. 03, Tieng, Kejajar',
            'addressLocality' => 'Wonosobo',
            'addressRegion' => 'Jawa Tengah',
            'postalCode' => '56354',
            'addressCountry' => 'ID',
        ],
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
@php
    $jeepWaRaw = $settings->whatsapp_number ?: '081325631952';
    $jeepWaInt = preg_replace('/[^0-9]/', '', $jeepWaRaw);
    if (str_starts_with($jeepWaInt, '0')) {
        $jeepWaInt = '62' . substr($jeepWaInt, 1);
    }

    // Filter dinamis paket tour khusus kategori Jeep dari database (Kecuali ID 4 paket umum jika ingin spesifik rute 1-5)
    $jeepPackages = $packages->filter(fn($p) => in_array($p->category, ['Jeep Safari', 'Sunrise Safari', 'Jeep Tour']) && $p->id != 4)
                             ->sortBy('sort_order')
                             ->values();

    $firstPkg = $jeepPackages->first();
    $firstPkgTitle = $firstPkg ? $firstPkg->title : 'Paket Jeep 1: Komplek Candi & Sikidang';
    $firstPkgPrice = $firstPkg ? (int) $firstPkg->price : 850000;
@endphp

<div class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-red-500 selection:text-white antialiased relative overflow-x-hidden jeep-light-mesh"
     x-data="{ 
         activeTab: 'all',
         selectedPackage: '{{ addslashes($firstPkgTitle) }}',
         packagePrice: {{ $firstPkgPrice }},
         tripDate: '',
         paxCount: 4,
         docOption: 'none',
         docPrice: 0,
         includeOjek: false,
         includeBoat: false,
         calcTotal() {
             let base = this.packagePrice;
             let extra = 0;
             if (this.docOption === 'camera') extra += 500000;
             if (this.docOption === 'drone') extra += 750000;
             if (this.docOption === 'bundle') extra += 1000000;
             if (this.includeOjek) extra += (15000 * this.paxCount);
             if (this.includeBoat) extra += (20000 * this.paxCount);
             return base + extra;
         },
         generateWaUrl() {
             let phone = '{{ $jeepWaInt }}';
             let text = `Halo Ready Jeep Dieng, saya ingin booking paket Jeep:\n` +
                        `• Paket: ${this.selectedPackage}\n` +
                        `• Tanggal: ${this.tripDate || 'Menyesuaikan'}\n` +
                        `• Peserta: ${this.paxCount} Orang\n` +
                        `• Dokumentasi Tambahan: ${this.docOption}\n` +
                        `• Termasuk Tiket Wisata Rp 100k/pax: Ya (ALL IN)\n` +
                        `• Estimasi Total: Rp ${new Intl.NumberFormat('id-ID').format(this.calcTotal())}\n\n` +
                        `Mohon info ketersediaan unit dan jadwal. Terima kasih!`;
             return `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
         }
     }">

    <!-- TOP PROMO BANNER ALL-IN -->
    <aside aria-label="Pengumuman Konsep All In" class="bg-gradient-to-r from-red-600 via-red-600 to-red-700 text-white text-xs font-semibold py-2.5 px-4 shadow-sm border-b border-red-700/50">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 truncate">
                <span class="bg-white text-red-700 font-black uppercase text-[10px] tracking-wider px-2 py-0.5 rounded shadow-sm">
                    KONSEP ALL IN
                </span>
                <span class="text-white font-medium hidden sm:inline">
                    Semua Paket Wisata Jeep sudah termasuk Unit 4x4, BBM, Parkir, Driver, Tiket Masuk Objek Wisata Rp 100k/pax & Dokumentasi HP!
                </span>
                <span class="text-white font-medium sm:hidden">
                    Paket All In: BBM, Driver, Parkir & Tiket Wisata Rp 100k/pax!
                </span>
            </div>
            <a href="https://wa.me/{{ $jeepWaInt }}?text=Halo%20Ready%20Jeep%20Dieng%2C%20saya%20mau%20tanya%20paket%20All%20In%20Jeep%20Wisata" target="_blank" class="text-amber-200 hover:text-white font-bold inline-flex items-center gap-1 transition-colors shrink-0">
                <span>Hubungi: {{ $jeepWaRaw }}</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    </aside>

    <!-- HEADER / NAVIGATION BAR READY JEEP DIENG (LIGHT THEME) -->
    <header class="sticky top-0 z-40 backdrop-blur-xl bg-white/95 border-b border-slate-200/90 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo & Identity (Putih Bersih & Tajam) -->
            <a href="{{ url('/?theme=jeep') }}" class="flex items-center gap-3 group shrink-0">
                <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 p-1 flex items-center justify-center shadow-sm shrink-0 overflow-hidden group-hover:border-red-400 transition-colors">
                    <img src="{{ asset('images/ready-jeep-dieng-logo.png') }}" alt="Logo Ready Jeep Dieng" class="h-10 w-auto max-w-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-base sm:text-lg font-black tracking-wider text-slate-900 font-sans uppercase">READY JEEP</span>
                        <span class="text-base sm:text-lg font-black tracking-wider text-red-600 font-sans uppercase">DIENG</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-mono tracking-wider uppercase block font-semibold">
                        Official 4x4 All-In &bull; PT. GoTrip Asia
                    </span>
                </div>
            </a>

            <!-- Navigation Links Desktop -->
            <nav class="hidden lg:flex items-center gap-7 text-xs font-bold text-slate-600">
                <a href="#paket-wisata" class="hover:text-red-600 transition-colors flex items-center gap-1.5">
                    <i data-lucide="compass" class="w-4 h-4 text-red-600"></i>
                    <span>Daftar Paket All In</span>
                </a>
                <a href="#keunggulan" class="hover:text-red-600 transition-colors flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-4 h-4 text-red-600"></i>
                    <span>Fasilitas All-In</span>
                </a>
                <a href="#kalkulator" class="hover:text-red-600 transition-colors flex items-center gap-1.5">
                    <i data-lucide="calculator" class="w-4 h-4 text-red-600"></i>
                    <span>Estimasi Biaya</span>
                </a>
                <a href="#destinasi" class="hover:text-red-600 transition-colors flex items-center gap-1.5">
                    <i data-lucide="map-pin" class="w-4 h-4 text-red-600"></i>
                    <span>Spot Dieng</span>
                </a>
                <a href="#faq" class="hover:text-red-600 transition-colors flex items-center gap-1.5">
                    <i data-lucide="help-circle" class="w-4 h-4 text-red-600"></i>
                    <span>FAQ</span>
                </a>
            </nav>

            <!-- Actions Header -->
            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ $jeepWaInt }}?text=Halo%20Ready%20Jeep%20Dieng%2C%20saya%20ingin%20booking%20Jeep%20Wisata%20All%20In" target="_blank" class="px-4 sm:px-5 py-2.5 rounded-xl text-xs font-extrabold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 via-red-600 to-red-700 hover:from-red-500 hover:to-red-600 transition-all shadow-md shadow-red-600/25 flex items-center gap-2 cursor-pointer hover:scale-105 active:scale-95">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Booking Jeep (WA)</span>
                </a>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (CLEAN SPORTY ADVENTURE) -->
    <section class="relative pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden bg-gradient-to-b from-white via-slate-50 to-[#f8fafc]">
        <!-- Ambient Glowing Lights Halus -->
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-red-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Sisi Kiri: Headline & CTA -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                        <span class="uppercase tracking-wider">UNIT RESMI 4X4 DAIHATSU FEROZA & SUZUKI KATANA</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15]">
                        Taklukkan Puncak Dieng Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-600 to-amber-600">Ready Jeep Dieng</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 max-w-2xl leading-relaxed">
                        Rasakan serunya sensasi off-road menembus kabut dingin pegunungan vulkanik Dieng Plateau. Berburu Golden Sunrise Sikunir, menjelajahi Kawah Sikidang, Candi Arjuna, hingga panorama magis Telaga Menjer dengan sistem tarif <strong class="text-slate-900 font-extrabold underline decoration-red-500 underline-offset-4">100% ALL IN Transparan</strong> tanpa biaya tersembunyi.
                    </p>

                    <!-- Feature Badges (Kartu Putih Halus) -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        <div class="p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-2.5">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-red-600 shrink-0"></i>
                            <span class="text-xs font-bold text-slate-800">Tiket Objek Masuk (Included)</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-2.5">
                            <i data-lucide="users" class="w-5 h-5 text-red-600 shrink-0"></i>
                            <span class="text-xs font-bold text-slate-800">Kapasitas 4 Pax + 1 Driver</span>
                        </div>
                        <div class="p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-sm flex items-center gap-2.5 col-span-2 sm:col-span-1">
                            <i data-lucide="camera" class="w-5 h-5 text-red-600 shrink-0"></i>
                            <span class="text-xs font-bold text-slate-800">Free Foto HP oleh Driver</span>
                        </div>
                    </div>

                    <!-- Call to Action Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <a href="#paket-wisata" class="px-7 py-4 rounded-xl text-xs font-extrabold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 via-red-600 to-red-700 hover:from-red-500 hover:to-red-600 transition-all shadow-lg shadow-red-600/25 flex items-center gap-2 hover:scale-105 active:scale-95">
                            <i data-lucide="compass" class="w-4 h-4"></i>
                            <span>Lihat Pilihan Paket All-In</span>
                        </a>
                        <a href="https://wa.me/{{ $jeepWaInt }}?text=Halo%20Ready%20Jeep%20Dieng%2C%20saya%20mau%20konsultasi%20rute%20dan%20ketersediaan%20armada%20Jeep" target="_blank" class="px-7 py-4 rounded-xl text-xs font-extrabold uppercase tracking-wider text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition-all flex items-center gap-2">
                            <i data-lucide="phone-call" class="w-4 h-4 text-red-600"></i>
                            <span>Konsultasi WA ({{ $jeepWaRaw }})</span>
                        </a>
                    </div>
                </div>

                <!-- Sisi Kanan: Logo Badge & Quick Card (Putih Bersih & Menyatu) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md rounded-3xl bg-white border border-slate-200 p-6 sm:p-8 shadow-xl shadow-slate-200/70 text-center">
                        <!-- Box Logo Putih Menyatu -->
                        <div class="w-44 h-32 mx-auto rounded-2xl bg-white border border-slate-200 p-2 shadow-sm flex items-center justify-center overflow-hidden group">
                            <img src="{{ asset('images/ready-jeep-dieng-logo.png') }}" alt="Logo RD Ready Jeep Dieng" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <div class="mt-6 space-y-2">
                            <span class="inline-block px-3 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-[11px] font-mono font-bold tracking-widest uppercase">
                                JEEP 4X4 OPERATOR RESMI
                            </span>
                            <h2 class="text-2xl font-black text-slate-900 tracking-wide uppercase">READY JEEP DIENG</h2>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                Basecamp Tieng Kejajar Wonosobo & Penjemputan di seluruh Penginapan / Hotel Area Kota Wonosobo & Kawasan Dieng.
                            </p>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3 text-left">
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                                <span class="text-[10px] text-slate-500 font-bold block uppercase">Harga Mulai</span>
                                <span class="text-lg font-black text-red-600">Rp 700.000</span>
                                <span class="text-[9px] text-slate-500 block font-medium">/ 1 Jeep All In (4 Pax)</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                                <span class="text-[10px] text-slate-500 font-bold block uppercase">Rute Sunrise</span>
                                <span class="text-lg font-black text-amber-600">Pukul 03.00</span>
                                <span class="text-[9px] text-slate-500 block font-medium">Dini hari langsung jemput</span>
                            </div>
                        </div>

                        <a href="https://wa.me/{{ $jeepWaInt }}?text=Halo%20Ready%20Jeep%20Dieng%2C%20saya%20ingin%20tanya%20ketersediaan%20slot%20Jeep%20hari%20ini%20atau%20besok" target="_blank" class="mt-6 w-full py-3.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-md shadow-red-600/25 cursor-pointer">
                            <i data-lucide="calendar-check" class="w-4 h-4"></i>
                            <span>Cek Jadwal & Slot Armada</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION KEUNGGULAN & FASILITAS ALL IN -->
    <section id="keunggulan" class="py-20 bg-white border-y border-slate-200/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs font-extrabold uppercase tracking-widest inline-block">
                    KENAPA READY JEEP DIENG?
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Standar Layanan <span class="text-red-600">100% All-In</span> Tanpa Ribet
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm">
                    Kami menghapus seluruh kerepotan wisatawan. Satu harga pasti sudah mengcover segala kebutuhan perjalanan selama tour di Dieng.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-14">
                <!-- Fasilitas 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-red-400 hover:bg-white jeep-card-shadow jeep-card-hover group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="ticket" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mt-4">Tiket Wisata Rp 100k/Pax</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed font-medium">
                        Sudah termasuk tiket masuk komplek Candi Arjuna, Kawah Sikidang, Telaga Warna, atau spot sunrise pilihan. Tidak perlu antre beli tiket lagi.
                    </p>
                </div>

                <!-- Fasilitas 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-red-400 hover:bg-white jeep-card-shadow jeep-card-hover group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="gauge" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mt-4">Armada 4x4 Tangguh</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed font-medium">
                        Unit Daihatsu Feroza & Suzuki Katana dalam kondisi terawat prima, ground clearance tinggi siap menerjang tanjakan curam pegunungan.
                    </p>
                </div>

                <!-- Fasilitas 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-red-400 hover:bg-white jeep-card-shadow jeep-card-hover group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="user-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mt-4">Driver Lokal Berpengalaman</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed font-medium">
                        Dipandu driver asli Dieng yang menguasai jalur ekstrem, ramah, memahami seluk beluk budaya setempat, dan siap mengarahkan spot foto terbaik.
                    </p>
                </div>

                <!-- Fasilitas 4 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/90 hover:border-red-400 hover:bg-white jeep-card-shadow jeep-card-hover group">
                    <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center text-red-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="smartphone" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 mt-4">Gratis Foto & Video HP</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed font-medium">
                        Driver kami terlatih mengambil sudut foto estetik saat rombongan berpose di atas kap mesin jeep atau di depan panorama alam Dieng.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION DAFTAR PAKET JEEP 1-5 & SUNRISE SAFARI (DYNAMIC DARI DATABASE) -->
    <section id="paket-wisata" class="py-20 bg-slate-50/70 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-10 border-b border-slate-200">
                <div class="space-y-2 max-w-2xl">
                    <span class="px-3.5 py-1 rounded-full bg-red-100 border border-red-200 text-red-800 text-xs font-black uppercase tracking-wider inline-block">
                        10 PAKET JEEP WISATA ALL IN
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Pilihan Rute & Paket Wisata <span class="text-red-600">Jeep 4x4</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600">
                        Pilih antara <strong class="text-slate-900 font-bold">Paket Tur 1 Hari (Non-Sunrise)</strong> atau <strong class="text-slate-900 font-bold">Paket Sunrise Safari</strong>. Seluruh paket berbasis All In untuk 1 unit Jeep (kapasitas 4 orang).
                    </p>
                </div>

                <!-- Tab Filter Dinamis -->
                <div class="inline-flex p-1.5 rounded-2xl bg-white border border-slate-200 shadow-sm self-start md:self-auto">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer">
                        Semua ({{ $jeepPackages->count() }})
                    </button>
                    <button @click="activeTab = '1hari'" :class="activeTab === '1hari' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer">
                        Tur 1 Hari
                    </button>
                    <button @click="activeTab = 'sunrise'" :class="activeTab === 'sunrise' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all cursor-pointer">
                        Sunrise Safari
                    </button>
                </div>
            </div>

            <!-- Grid Paket Wisata Dinamis -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @forelse($jeepPackages as $pkg)
                    @php
                        $isSunrise = str_contains(strtolower($pkg->title), 'sunrise') || $pkg->category === 'Sunrise Safari';
                        $tabCategory = $isSunrise ? 'sunrise' : '1hari';
                    @endphp
                    <div x-show="activeTab === 'all' || activeTab === '{{ $tabCategory }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="rounded-3xl bg-white border border-slate-200/90 hover:border-red-500 jeep-card-shadow jeep-card-hover flex flex-col justify-between overflow-hidden relative group">
                        
                        <!-- Badges Header Card -->
                        <div class="p-6 pb-0 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase {{ $isSunrise ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                {{ $isSunrise ? 'SUNRISE SAFARI' : 'TUR JEEP 1 HARI' }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                {{ $pkg->duration ?: '4-7 Jam' }}
                            </span>
                        </div>

                        <!-- Title & Overview -->
                        <div class="p-6 space-y-4 flex-1">
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-red-600 transition-colors leading-snug">
                                {{ $pkg->title }}
                            </h3>
                            
                            <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">
                                {{ strip_tags($pkg->summary) }}
                            </p>

                            <!-- Destinasi Highlight Points -->
                            @if(!empty($pkg->destination_points) && is_array($pkg->destination_points))
                                <div class="pt-2">
                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Rute Objek Wisata:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(array_slice($pkg->destination_points, 0, 5) as $point)
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200/80 text-[11px] text-slate-700 font-semibold flex items-center gap-1">
                                                <i data-lucide="map-pin" class="w-2.5 h-2.5 text-red-600"></i>
                                                {{ $point }}
                                            </span>
                                        @endforeach
                                        @if(count($pkg->destination_points) > 5)
                                            <span class="px-2 py-1 rounded-lg bg-slate-100 text-[11px] text-slate-500 font-bold">
                                                +{{ count($pkg->destination_points) - 5 }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Fasilitas All In Checklist -->
                            <div class="pt-3 border-t border-slate-100 space-y-2">
                                <div class="flex items-center gap-2 text-xs text-slate-700 font-medium">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                    <span>Sudah termasuk Tiket Wisata Rp 100k/pax</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-700 font-medium">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                    <span>Unit Jeep 4x4, BBM & Parkir Wisata</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-700 font-medium">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                                    <span>Driver lokal berpengalaman & guide HP photo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Action Footer -->
                        <div class="p-6 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] text-slate-500 font-bold uppercase block">Harga All-In (4 Pax)</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl sm:text-2xl font-black text-red-600">
                                        Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-[9px] text-slate-500 font-semibold block">/ 1 unit mobil Jeep</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('package.detail', $pkg->slug) }}" class="px-3.5 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 text-xs font-bold transition-all shadow-sm">
                                    Detail
                                </a>
                                <a href="https://wa.me/{{ $jeepWaInt }}?text={{ urlencode('Halo Ready Jeep Dieng, saya ingin booking paket ' . $pkg->title . ' (Tarif Rp ' . number_format($pkg->price, 0, ',', '.') . ' All In). Apakah slot masih ada?') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-wider transition-all shadow-md shadow-red-600/20 flex items-center gap-1.5 cursor-pointer">
                                    <span>Pesan</span>
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        <i data-lucide="alert-circle" class="w-10 h-10 mx-auto text-slate-400 mb-2"></i>
                        <p class="text-sm font-semibold">Belum ada paket Jeep yang dimuat dari database.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION ESTIMASI BIAYA & SIMULATOR BOOKING INTERAKTIF (LIGHT THEME) -->
    <section id="kalkulator" class="py-20 bg-white border-y border-slate-200/80 relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
                <span class="px-3.5 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs font-extrabold uppercase tracking-widest inline-block">
                    KALKULATOR RESERVASI TRANSPARAN
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Hitung Estimasi Biaya <span class="text-red-600">Jeep Tour Anda</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Simulasikan pilihan paket jeep Anda, tanggal trip, serta fasilitas dokumentasi tambahan. Tanpa ada markup harga di lokasi!
                </p>
            </div>

            <!-- Container Form Kalkulator -->
            <div class="rounded-3xl bg-slate-50 border border-slate-200 shadow-xl shadow-slate-200/60 p-6 sm:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Form Input Sisi Kiri -->
                    <div class="space-y-5">
                        <!-- Pilih Paket Wisata -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Pilih Paket Jeep All-In
                            </label>
                            <select x-model="selectedPackage"
                                    @change="
                                        let selectedOption = $event.target.selectedOptions[0];
                                        packagePrice = parseInt(selectedOption.getAttribute('data-price') || 0);
                                    "
                                    class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 text-sm font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 shadow-sm transition-colors">
                                @foreach($jeepPackages as $pkg)
                                    <option value="{{ $pkg->title }}" data-price="{{ (int) $pkg->price }}">
                                        {{ $pkg->title }} (Rp {{ number_format($pkg->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Tour -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Rencana Tanggal Keberangkatan
                            </label>
                            <input type="date" x-model="tripDate" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 text-sm font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 shadow-sm">
                        </div>

                        <!-- Jumlah Peserta -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Jumlah Peserta (<span x-text="paxCount"></span> Orang)
                            </label>
                            <input type="range" min="1" max="4" x-model="paxCount" class="w-full accent-red-600 cursor-pointer">
                            <span class="text-[11px] text-slate-500 mt-1 block font-medium">
                                *Satu unit armada Jeep berkapasitas maksimal 4 penumpang dewasa + 1 driver.
                            </span>
                        </div>

                        <!-- Dokumentasi Tambahan -->
                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-2">
                                Opsi Dokumentasi Tambahan (Opsional)
                            </label>
                            <select x-model="docOption" class="w-full px-4 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 text-sm font-semibold focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 shadow-sm">
                                <option value="none">Gratis Foto HP Driver (Bawaan Paket)</option>
                                <option value="camera">Jasa Fotografer DSLR Pro (+Rp 500.000)</option>
                                <option value="drone">Jasa Pilot Drone 4K Sinematik (+Rp 750.000)</option>
                                <option value="bundle">Full Bundle Kamera Mirrorless + Drone 4K (+Rp 1.000.000)</option>
                            </select>
                        </div>

                        <!-- Fasilitas Tambahan Non-All In -->
                        <div class="space-y-2 pt-2">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700 font-semibold">
                                <input type="checkbox" x-model="includeOjek" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span>Tambah Ojek Motor Sikunir (+Rp 15.000/orang)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700 font-semibold">
                                <input type="checkbox" x-model="includeBoat" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span>Tambah Perahu Telaga Menjer (+Rp 20.000/orang)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ringkasan Sisi Kanan (Total Harga & Booking WA) -->
                    <div class="rounded-2xl bg-gradient-to-br from-red-600 via-red-700 to-slate-900 p-6 sm:p-8 text-white flex flex-col justify-between shadow-xl shadow-red-700/25">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-white/20 pb-4">
                                <span class="text-xs uppercase tracking-wider text-red-200 font-bold">Ringkasan Estimasi</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-white font-mono text-[11px] font-bold">ALL IN</span>
                            </div>

                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between text-slate-200">
                                    <span>Paket Jeep:</span>
                                    <span class="font-bold text-white text-right max-w-[180px] truncate" x-text="selectedPackage"></span>
                                </div>
                                <div class="flex justify-between text-slate-200">
                                    <span>Tarif Dasar (4 Pax):</span>
                                    <span class="font-bold text-white" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(packagePrice)"></span>
                                </div>
                                <div class="flex justify-between text-slate-200" x-show="docOption !== 'none'">
                                    <span>Tambahan Dokumentasi:</span>
                                    <span class="font-bold text-amber-300" x-text="docOption === 'camera' ? '+Rp 500.000' : (docOption === 'drone' ? '+Rp 750.000' : '+Rp 1.000.000')"></span>
                                </div>
                                <div class="flex justify-between text-slate-200" x-show="includeOjek">
                                    <span>Ojek Sikunir:</span>
                                    <span class="font-bold text-amber-300" x-text="'+Rp ' + new Intl.NumberFormat('id-ID').format(15000 * paxCount)"></span>
                                </div>
                                <div class="flex justify-between text-slate-200" x-show="includeBoat">
                                    <span>Perahu Menjer:</span>
                                    <span class="font-bold text-amber-300" x-text="'+Rp ' + new Intl.NumberFormat('id-ID').format(20000 * paxCount)"></span>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-white/20">
                                <span class="text-xs uppercase tracking-wider text-red-200 font-bold block">Total Biaya All In</span>
                                <div class="text-3xl sm:text-4xl font-black text-white mt-1">
                                    Rp <span x-text="new Intl.NumberFormat('id-ID').format(calcTotal())"></span>
                                </div>
                                <span class="text-[11px] text-red-200 block mt-1">
                                    Termasuk BBM, Driver, Parkir & Tiket Wisata Rp 100k/pax
                                </span>
                            </div>
                        </div>

                        <a :href="generateWaUrl()" target="_blank" class="mt-8 w-full py-4 rounded-xl bg-white hover:bg-slate-100 text-red-700 font-black text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 shadow-lg hover:scale-105 active:scale-95 cursor-pointer">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Pesan via WhatsApp Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION SPOT DESTINASI POPULER JEEP (LIGHT THEME) -->
    <section id="destinasi" class="py-20 bg-slate-50/70 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-14">
                <span class="px-3.5 py-1 rounded-full bg-red-100 border border-red-200 text-red-800 text-xs font-black uppercase tracking-widest inline-block">
                    RUTE EKSOTIS 4X4
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Destinasi Unggulan <span class="text-red-600">Jeep Adventure</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Kawasan vulkanik Dieng kaya akan bentang alam spektakuler yang hanya bisa dijangkau maksimal menggunakan armada tangguh 4x4.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Spot 1 -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden jeep-card-shadow jeep-card-hover group">
                    <div class="h-44 bg-slate-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop" alt="Puncak Sikunir Golden Sunrise" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-black/60 text-white font-mono text-[10px] font-bold backdrop-blur-md">
                            2.463 MDPL
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h4 class="text-base font-extrabold text-slate-900">Puncak Sikunir</h4>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Spot berburu Golden Sunrise terbaik di Asia Tenggara dengan latar belakang Gunung Sindoro, Sumbing, Merbabu, dan Merapi.
                        </p>
                    </div>
                </div>

                <!-- Spot 2 -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden jeep-card-shadow jeep-card-hover group">
                    <div class="h-44 bg-slate-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=800&auto=format&fit=crop" alt="Kawah Sikidang Vulkanik" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-black/60 text-white font-mono text-[10px] font-bold backdrop-blur-md">
                            VULKANIK AKTIF
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h4 class="text-base font-extrabold text-slate-900">Kawah Sikidang</h4>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Kawah belerang vulkanik aktif yang dapat didekati langsung melalui jembatan kayu estetik dan spot foto mobil jeep.
                        </p>
                    </div>
                </div>

                <!-- Spot 3 -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden jeep-card-shadow jeep-card-hover group">
                    <div class="h-44 bg-slate-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=800&auto=format&fit=crop" alt="Batu Ratapan Angin & Telaga Warna" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-black/60 text-white font-mono text-[10px] font-bold backdrop-blur-md">
                            VIEW DARI ATAS
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h4 class="text-base font-extrabold text-slate-900">Batu Ratapan Angin</h4>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Dua tebing batu tinggi di atas bukit dengan pemandangan magis gradasi warna hijau toska Telaga Warna dan Telaga Pengilon.
                        </p>
                    </div>
                </div>

                <!-- Spot 4 -->
                <div class="rounded-3xl bg-white border border-slate-200/90 overflow-hidden jeep-card-shadow jeep-card-hover group">
                    <div class="h-44 bg-slate-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop" alt="Telaga Menjer Danau Alami" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-black/60 text-white font-mono text-[10px] font-bold backdrop-blur-md">
                            DANAU VULKANIK
                        </span>
                    </div>
                    <div class="p-5 space-y-2">
                        <h4 class="text-base font-extrabold text-slate-900">Telaga Menjer & Kahyangan</h4>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Danau alami terluas di kaki pegunungan Dieng dengan air tenang dan spot dermaga bambu berlatar tebing hijau berkabut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ (FREQUENTLY ASKED QUESTIONS) -->
    <section id="faq" class="py-20 bg-white border-t border-slate-200/80 relative" x-data="{ openFaq: 1 }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-3 mb-14">
                <span class="px-3.5 py-1 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs font-black uppercase tracking-widest inline-block">
                    PERTANYAAN UMUM
                </span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Frequently Asked <span class="text-red-600">Questions</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    Informasi penting seputar kapasitas unit, titik penjemputan, dan fasilitas all in Ready Jeep Dieng.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="rounded-2xl bg-slate-50 border border-slate-200/90 overflow-hidden shadow-sm transition-all">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full p-5 text-left font-extrabold text-slate-900 flex items-center justify-between gap-4 cursor-pointer hover:text-red-600 transition-colors">
                        <span class="text-sm sm:text-base">Apa saja yang dimaksud dengan sistem tarif "ALL IN"?</span>
                        <i data-lucide="chevron-down" :class="openFaq === 1 ? 'rotate-180 text-red-600' : 'text-slate-400'" class="w-5 h-5 shrink-0 transition-transform"></i>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-5 pb-5 text-xs text-slate-600 leading-relaxed font-medium">
                        Konsep All In Ready Jeep Dieng artinya tarif yang Anda bayarkan sudah mencakup <strong class="text-slate-900 font-bold">sewa armada Jeep 4x4, BBM, biaya parkir di semua objek, jasa driver lokal, tiket masuk objek wisata senilai Rp 100.000/orang</strong>, serta bantuan foto dokumentasi handphone oleh driver kami. Anda tidak akan dikenakan biaya tambahan tiket masuk umum lagi di lokasi.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl bg-slate-50 border border-slate-200/90 overflow-hidden shadow-sm transition-all">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full p-5 text-left font-extrabold text-slate-900 flex items-center justify-between gap-4 cursor-pointer hover:text-red-600 transition-colors">
                        <span class="text-sm sm:text-base">Berapa kapasitas maksimal satu mobil Jeep 4x4?</span>
                        <i data-lucide="chevron-down" :class="openFaq === 2 ? 'rotate-180 text-red-600' : 'text-slate-400'" class="w-5 h-5 shrink-0 transition-transform"></i>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-5 pb-5 text-xs text-slate-600 leading-relaxed font-medium">
                        Demi kenyamanan dan standar keselamatan berkendara di tanjakan curam Dieng, satu unit Jeep (Daihatsu Feroza / Suzuki Katana) diisi oleh <strong class="text-slate-900 font-bold">maksimal 4 orang dewasa</strong> ditambah 1 driver dari kami. Jika rombongan Anda berjumlah 5 orang atau lebih, disarankan memesan 2 unit jeep.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl bg-slate-50 border border-slate-200/90 overflow-hidden shadow-sm transition-all">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full p-5 text-left font-extrabold text-slate-900 flex items-center justify-between gap-4 cursor-pointer hover:text-red-600 transition-colors">
                        <span class="text-sm sm:text-base">Di mana titik temu dan penjemputan Jeep dilakukan?</span>
                        <i data-lucide="chevron-down" :class="openFaq === 3 ? 'rotate-180 text-red-600' : 'text-slate-400'" class="w-5 h-5 shrink-0 transition-transform"></i>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-5 pb-5 text-xs text-slate-600 leading-relaxed font-medium">
                        Titik penjemputan sangat fleksibel: bisa langsung dijemput di homestay/hotel area Dieng, hotel di Kota Wonosobo, atau berkumpul di Basecamp Ready Jeep Dieng (Jl. Dieng Km. 03 Tieng, Kejajar). Khusus paket Sunrise, penjemputan dimulai pukul 03.00 WIB dini hari.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="rounded-2xl bg-slate-50 border border-slate-200/90 overflow-hidden shadow-sm transition-all">
                    <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full p-5 text-left font-extrabold text-slate-900 flex items-center justify-between gap-4 cursor-pointer hover:text-red-600 transition-colors">
                        <span class="text-sm sm:text-base">Bagaimana cara booking dan sistem pembayarannya?</span>
                        <i data-lucide="chevron-down" :class="openFaq === 4 ? 'rotate-180 text-red-600' : 'text-slate-400'" class="w-5 h-5 shrink-0 transition-transform"></i>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="px-5 pb-5 text-xs text-slate-600 leading-relaxed font-medium">
                        Pemesanan dapat dilakukan langsung via WhatsApp resmi Ready Jeep Dieng (<strong class="text-slate-900 font-bold">{{ $jeepWaRaw }}</strong>). Setelah memilih paket dan tanggal, lakukan transfer DP tanda jadi ke rekening resmi perusahaan PT. GOTRIP ASIA TRAVELINDO (BNI: 8166754042). Sisa pelunasan dapat dibayarkan saat hari keberangkatan trip.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER READY JEEP DIENG (DARK CHARCOAL SPORTY ACCENT) -->
    <footer class="bg-[#0f172a] text-slate-400 border-t border-slate-800 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800">
                <!-- Kolom 1: Brand Info -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-300 p-1 flex items-center justify-center shadow-sm shrink-0 overflow-hidden">
                            <img src="{{ asset('images/ready-jeep-dieng-logo.png') }}" alt="Logo RD Footer" class="h-10 w-auto max-w-full object-contain">
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-base font-black tracking-wider text-white uppercase">READY JEEP</span>
                                <span class="text-base font-black tracking-wider text-red-500 uppercase">DIENG</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono tracking-wider uppercase block">
                                Offroad 4x4 All-In Operator
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Operator resmi penyewaan armada Jeep Wisata 4x4 Dataran Tinggi Dieng berbasis All In. Solusi petualangan aman, nyaman, dan transparan untuk seluruh wisatawan.
                    </p>
                    <div class="text-[11px] text-slate-500">
                        <p class="font-semibold text-slate-400">Unit Usaha Resmi:</p>
                        <p>PT. GOTRIP ASIA TRAVELINDO &bull; Wonosobo</p>
                    </div>
                </div>

                <!-- Kolom 2: Navigasi Cepat -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Eksplorasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#paket-wisata" class="hover:text-red-400 transition-colors">Paket Tur 1 Hari</a></li>
                        <li><a href="#paket-wisata" class="hover:text-red-400 transition-colors">Paket Sunrise Safari</a></li>
                        <li><a href="#keunggulan" class="hover:text-red-400 transition-colors">Fasilitas All-In</a></li>
                        <li><a href="#kalkulator" class="hover:text-red-400 transition-colors">Kalkulator Biaya</a></li>
                        <li><a href="#faq" class="hover:text-red-400 transition-colors">Tanya Jawab (FAQ)</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak & Basecamp -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Kontak Basecamp</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li class="flex items-start gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-red-500 shrink-0 mt-0.5"></i>
                            <span>{{ $settings->address ?: 'Jl. Dieng Km. 03, Tieng, Kejajar, Kab. Wonosobo 56354' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="phone" class="w-4 h-4 text-red-500 shrink-0"></i>
                            <span>{{ $settings->phone_number ?: '+62 813-2563-1952' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4 text-red-500 shrink-0"></i>
                            <span>{{ $settings->email ?: 'jeep@tiketdieng.com' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 4: Rekening Resmi Pembayaran -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-xs font-black uppercase tracking-wider text-white">Rekening Resmi (DP)</h4>
                    <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-white">{{ $settings->bank_name ?: 'BANK BNI' }}</span>
                            <span class="text-[10px] text-emerald-400 font-mono font-bold">TERVERIFIKASI</span>
                        </div>
                        <div class="text-base font-mono font-extrabold text-amber-400 tracking-wider">
                            {{ $settings->bank_account_number ?: '8166754042' }}
                        </div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-wider">
                            a.n {{ $settings->bank_account_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Switcher -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Ready Jeep Dieng &bull; PT. GOTRIP ASIA TRAVELINDO. All rights reserved.</p>
                <div class="flex items-center gap-4 text-[11px]">
                    <a href="{{ url('/') }}" class="hover:text-red-400 transition-colors">Portal TiketDieng</a>
                    <span>&bull;</span>
                    <a href="{{ url('/?theme=lotus') }}" class="hover:text-red-400 transition-colors">Lotus Creative (Foto & Drone)</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

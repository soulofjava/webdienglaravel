@extends('layouts.app')

@section('title', 'Jeep Dieng Adventure — Sewa Jeep Wisata Offroad 4x4 Dataran Tinggi Dieng')

@section('content')
<main class="relative min-h-screen bg-[#070d0a] text-slate-100 overflow-hidden font-sans">
    <!-- Background Glow Effects -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-emerald-500/10 blur-[130px] rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[400px] bg-amber-500/5 blur-[120px] rounded-full"></div>
    </div>

    <!-- Header / Navbar Sub-Web Jeep -->
    <header class="sticky top-0 z-40 backdrop-blur-xl bg-[#070d0a]/80 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-slate-950 font-black shadow-lg shadow-emerald-500/20">
                    <i data-lucide="compass" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-base font-extrabold tracking-wider text-white block">JEEP DIENG</span>
                    <span class="text-[10px] text-emerald-400 font-mono tracking-widest uppercase block">4x4 Adventure Official</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ url('/?theme=tiketdieng') }}" class="text-xs text-slate-400 hover:text-white transition-colors hidden sm:flex items-center gap-1.5">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Portal Tiket Dieng</span>
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}?text=Halo%20Admin%20Jeep%20Dieng%2C%20saya%20mau%20tanya%20sewa%20Jeep%20Offroad%20Dieng" target="_blank" class="px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 bg-gradient-to-r from-emerald-400 to-emerald-500 hover:from-emerald-300 hover:to-emerald-400 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-1.5">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Booking Jeep</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-6">
            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
            <span>Unit 4x4 Resmi & Driver Berpengalaman</span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl">
            Jelajahi Negeri di Atas Awan dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300">Jeep Offroad 4x4</span>
        </h1>

        <p class="mt-5 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Nikmati sensasi petualangan menembus kabut dingin Dieng Plateau. Rute sunrise Bukit Sikunir, kawah vulkanik aktif Sikidang, Telaga Dringo, Savana Pangonan, hingga Batu Pandang Ratapan Angin.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-wrap items-center gap-4">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}?text=Halo%20Admin%20Jeep%2C%20saya%20ingin%20info%20paket%20rute%20Jeep%20Dieng" target="_blank" class="px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 bg-emerald-400 hover:bg-emerald-300 transition-all shadow-xl shadow-emerald-500/25 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>Reservasi Tanggal Trip</span>
            </a>
            <a href="{{ url('/') }}" class="px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-all flex items-center gap-2">
                <i data-lucide="globe" class="w-4 h-4"></i>
                <span>Kembali ke Portal Induk</span>
            </a>
        </div>

        <!-- Keunggulan Jeep Grid -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Kapasitas 4 Dewasa</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Setiap unit Jeep 4x4 nyaman diisi hingga 4 orang penumpang dewasa, dilengkapi sabuk pengaman dan driver lokal ramah.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="sun" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Sunrise Hunter Sikunir</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Start jam 03.30 pagi dari penginapan Anda menuju basecamp Bukit Sikunir untuk menyambut Golden Sunrise terindah se-Asia Tenggara.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Termasuk BBM & Driver</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Harga sewa sudah All-in termasuk bahan bakar, jasa sopir profesional, dan penjemputan di seluruh area homestay/hotel Dieng.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Jeep -->
    <footer class="border-t border-white/10 py-8 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Jeep Dieng Adventure &bull; Unit Bisnis {{ $settings->company_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}</p>
    </footer>
</main>
@endsection

@extends('layouts.app')

@section('title', 'Shuttle Dieng — Layanan Transportasi & Antar Jemput Wisata Dieng Plateau')

@section('content')
<main class="relative min-h-screen bg-[#070b12] text-slate-100 overflow-hidden font-sans">
    <!-- Background Glow Effects -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-sky-500/10 blur-[130px] rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-[500px] h-[400px] bg-indigo-500/5 blur-[120px] rounded-full"></div>
    </div>

    <!-- Header / Navbar Sub-Web Shuttle -->
    <header class="sticky top-0 z-40 backdrop-blur-xl bg-[#070b12]/80 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-black shadow-lg shadow-sky-500/20">
                    <i data-lucide="bus" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-base font-extrabold tracking-wider text-white block">SHUTTLE DIENG</span>
                    <span class="text-[10px] text-sky-400 font-mono tracking-widest uppercase block">Microbus & Transport Service</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}?text=Halo%20Admin%20Shuttle%20Dieng%2C%20saya%20mau%20booking%20shuttle%20antar%20jemput" target="_blank" class="px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 bg-gradient-to-r from-sky-400 to-sky-300 hover:from-sky-300 hover:to-sky-200 transition-all shadow-lg shadow-sky-500/20 flex items-center gap-1.5">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Pesan Kursi Shuttle</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-500/30 text-sky-300 text-xs font-semibold uppercase tracking-wider mb-6">
            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
            <span>Armada Mikrobus Ber-AC & Nyaman 15 Seat</span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl">
            Transportasi Aman & Cepat Menuju <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-teal-300 to-blue-400">Dataran Tinggi Dieng</span>
        </h1>

        <p class="mt-5 text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed">
            Layanan shuttle antar-jemput resmi dari Stasiun Purwokerto, Bandara YIA Yogyakarta, Semarang, hingga drop-off langsung ke pintu penginapan Anda di Dieng Plateau tanpa repot berganti kendaraan.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-wrap items-center gap-4">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp_number) }}?text=Halo%20Admin%20Shuttle%20Dieng%2C%20saya%20mau%20tanya%20jadwal%20dan%20rute%20shuttle" target="_blank" class="px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 bg-sky-400 hover:bg-sky-300 transition-all shadow-xl shadow-sky-500/25 flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>Cek Jadwal & Tarif</span>
            </a>
            <a href="{{ url('/') }}" class="px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-all flex items-center gap-2">
                <i data-lucide="globe" class="w-4 h-4"></i>
                <span>Kembali ke Portal Induk</span>
            </a>
        </div>

        <!-- Fitur Shuttle Grid -->
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Door to Door Pick Up</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Penjemputan langsung di lobi stasiun kereta api atau bandara kedatangan dan diantar hingga depan pintu homestay/hotel Anda di Dieng.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                    <i data-lucide="wifi" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Fasilitas Nyaman & AC</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Kabin full AC, reclining seats yang ergonomis, port charger USB tiap baris, dan bagasi koper yang lega untuk rombongan wisata Anda.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/10 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Jadwal Tepat Waktu</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Keberangkatan teratur setiap hari dengan kepastian waktu, dipandu oleh pengemudi berpengalaman yang memahami medan tanjakan pegunungan Dieng.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Shuttle -->
    <footer class="border-t border-white/10 py-8 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Shuttle Dieng &bull; Unit Bisnis {{ $settings->company_name ?: 'PT. GOTRIP ASIA TRAVELINDO' }}</p>
    </footer>
</main>
@endsection

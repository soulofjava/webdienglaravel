@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col font-sans">
    <!-- 1. Floating Atmospheric Navigation -->
    <header class="sticky top-0 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 py-4 bg-[#090d16]/90 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 via-amber-600 to-emerald-700 flex items-center justify-center p-0.5 shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
                    <div class="w-full h-full bg-[#090d16] rounded-[10px] flex items-center justify-center">
                        <i data-lucide="compass" class="w-5 h-5 text-amber-400 group-hover:rotate-45 transition-transform duration-500"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-serif tracking-wider text-lg font-bold bg-gradient-to-r from-amber-200 via-white to-amber-300 bg-clip-text text-transparent">
                            {{ $settings->site_name }}
                        </span>
                        <span class="text-[9px] uppercase font-bold tracking-widest px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            RESMI
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 tracking-wider">{{ $settings->site_tagline }}</p>
                </div>
            </a>

            <!-- Desktop Links & WhatsApp CTA -->
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}#paket" class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Lihat Semua Paket</span>
                </a>

                @php
                    $cleanWa = preg_replace('/\D/', '', $settings->whatsapp_number);
                    $waText = urlencode("Halo Admin {$settings->site_name}, saya ingin konsultasi & reservasi {$package->title} untuk rencana perjalanan saya. Mohon informasi ketersediaan slot.");
                    $waUrl = "https://wa.me/{$cleanWa}?text={$waText}";
                @endphp

                <a
                    href="{{ $waUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-lg shadow-amber-500/20 transition-all hover:scale-105"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Tanya WhatsApp</span>
                </a>
            </div>
        </div>
    </header>

    <!-- 2. Hero Detail Paket Banner Sinematik -->
    <section class="relative pt-12 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden bg-gradient-to-b from-[#090d16] via-[#07090e] to-[#07090e]">
        <!-- Background Ambient Glow -->
        <div class="absolute inset-0 z-0 opacity-25 bg-[radial-gradient(ellipse_70%_70%_at_50%_0%,rgba(245,158,11,0.2),rgba(0,0,0,0))]"></div>

        <div class="max-w-6xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6 font-medium">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <a href="{{ route('home') }}#paket" class="hover:text-amber-400 transition-colors">Paket Wisata</a>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-600"></i>
                <span class="text-amber-400 line-clamp-1">{{ $package->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Kolom Kiri: Info Utama & Cover -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Badges & Kategori -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            Kategori: {{ $package->category }}
                        </span>
                        @if ($package->badge)
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 flex items-center gap-1">
                                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                                <span>{{ $package->badge }}</span>
                            </span>
                        @endif
                        <span class="px-3 py-1 rounded-full text-xs font-medium text-slate-300 bg-white/5 border border-white/10 flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-400"></i>
                            <span>{{ $package->duration }}</span>
                        </span>
                    </div>

                    <!-- Judul Paket -->
                    <h1 class="font-serif text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                        {{ $package->title }}
                    </h1>

                    <!-- Hero Media Box -->
                    <div class="relative rounded-3xl overflow-hidden aspect-[16/9] border border-white/10 shadow-2xl group">
                        <img
                            src="{{ $package->image_url }}"
                            alt="{{ $package->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-xs text-slate-300">
                            <div class="flex items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Titik Jemput: {{ $package->pickup_location }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 text-amber-400 font-bold">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
                                <span>5.0 (Ulasan Terpercaya)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sinopsis Ringkasan -->
                    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 space-y-3">
                        <h2 class="font-serif text-lg font-bold text-white flex items-center gap-2">
                            <i data-lucide="book-open" class="w-5 h-5 text-amber-400"></i>
                            <span>Tentang Program Perjalanan Ini</span>
                        </h2>
                        <p class="text-sm text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ $package->summary }}
                        </p>
                    </div>

                    <!-- 3. PILIHAN RUTE & JADWAL ITINERARY (Gotripasia Model) -->
                    @if (!empty($package->itinerary_options) && count($package->itinerary_options) > 0)
                        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 space-y-6">
                            <div class="border-b border-white/10 pb-4">
                                <div class="flex items-center gap-2 text-amber-400 mb-1">
                                    <i data-lucide="compass" class="w-5 h-5"></i>
                                    <h2 class="font-serif text-lg sm:text-xl font-bold text-white">
                                        Pilihan Rute & Jadwal Itinerary
                                    </h2>
                                </div>
                                <p class="text-xs text-slate-400">
                                    Paket ini memiliki fleksibilitas rute kunjungan. Anda dapat menentukan opsi rute destinasi yang paling sesuai preferensi Anda.
                                </p>
                            </div>

                            <!-- Opsi Rute Cards / Tabs -->
                            <div class="space-y-4">
                                @foreach ($package->itinerary_options as $idx => $option)
                                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5 hover:border-amber-400/40 transition-all">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-2.5">
                                                <span class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-bold font-mono flex items-center justify-center">
                                                    {{ $idx + 1 }}
                                                </span>
                                                <h3 class="font-bold text-sm sm:text-base text-white">
                                                    {{ $option['name'] ?? 'Opsi Rute Kunjungan' }}
                                                </h3>
                                            </div>
                                            <span class="text-[11px] font-semibold text-amber-300/80 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20 self-start sm:self-auto">
                                                Rute Wisata Pilihan
                                            </span>
                                        </div>

                                        @if (!empty($option['destinations']))
                                            <div class="mb-3 flex items-start gap-2 text-xs text-slate-300">
                                                <i data-lucide="pin" class="w-3.5 h-3.5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                                                <div>
                                                    <strong class="text-white">Objek Dikunjungi:</strong>
                                                    <span class="text-slate-300">{{ $option['destinations'] }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($option['description']))
                                            <div class="bg-black/30 p-3.5 rounded-xl border border-white/5 text-xs text-slate-300 leading-relaxed font-sans whitespace-pre-line">
                                                {{ $option['description'] }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 4. FASILITAS TERMASUK & TIDAK TERMASUK -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Include -->
                        <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                            <div class="flex items-center gap-2 text-emerald-400 pb-3 border-b border-white/10">
                                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                <h3 class="font-serif text-base font-bold text-white">Fasilitas Termasuk (Include)</h3>
                            </div>
                            @if (!empty($package->inclusions) && count($package->inclusions) > 0)
                                <ul class="space-y-2.5 text-xs text-slate-300">
                                    @foreach ($package->inclusions as $inc)
                                        <li class="flex items-start gap-2.5">
                                            <i data-lucide="check" class="w-4 h-4 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                            <span>{{ $inc }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-slate-500 italic">Hubungi tim kami untuk detail fasilitas paket.</p>
                            @endif
                        </div>

                        <!-- Exclude -->
                        <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                            <div class="flex items-center gap-2 text-rose-400 pb-3 border-b border-white/10">
                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                                <h3 class="font-serif text-base font-bold text-white">Tidak Termasuk (Exclude)</h3>
                            </div>
                            @if (!empty($package->exclusions) && count($package->exclusions) > 0)
                                <ul class="space-y-2.5 text-xs text-slate-300">
                                    @foreach ($package->exclusions as $exc)
                                        <li class="flex items-start gap-2.5">
                                            <i data-lucide="x" class="w-4 h-4 text-rose-400 mt-0.5 flex-shrink-0"></i>
                                            <span>{{ $exc }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-slate-500 italic">Tidak ada catatan biaya exclude khusus.</p>
                            @endif
                        </div>
                    </div>

                    <!-- 5. CHECKLIST PERSIAPAN WISATA KE DIENG -->
                    @if (!empty($package->preparations) && count($package->preparations) > 0)
                        <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-amber-500/20 bg-amber-500/[0.02] space-y-4">
                            <div class="flex items-center gap-2.5 text-amber-400 pb-3 border-b border-white/10">
                                <div class="w-8 h-8 rounded-xl bg-amber-500/20 flex items-center justify-center">
                                    <i data-lucide="backpack" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="font-serif text-base font-bold text-white">Saran & Checklist Perlengkapan Dieng</h3>
                                    <p class="text-[11px] text-slate-400">Suhu dataran tinggi Dieng rata-rata berkisar 8°C - 15°C (bahkan membeku saat musim dingin).</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($package->preparations as $prep)
                                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/[0.03] border border-white/5 text-xs text-slate-200">
                                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400 flex-shrink-0"></i>
                                        <span>{{ $prep }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Kolom Kanan: Kartu Booking & Reservasi Langsung -->
                <div class="lg:col-span-4 sticky top-24 space-y-6">
                    <div class="glass-panel p-6 sm:p-7 rounded-3xl border-2 border-amber-500/40 shadow-2xl shadow-amber-500/10 space-y-6 bg-gradient-to-b from-[#0e1526] to-[#090d16]">
                        <!-- Label Harga -->
                        <div>
                            <span class="text-xs font-semibold text-slate-400 block mb-1">Estimasi Tarif Program</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="font-serif text-3xl sm:text-4xl font-extrabold text-amber-400">
                                    {{ $package->formatted_price }}
                                </span>
                            </div>
                            <span class="text-xs text-slate-400 mt-1 block">
                                {{ $package->price_note }}
                            </span>
                        </div>

                        <!-- Benefit Singkat -->
                        <div class="space-y-2.5 py-4 border-y border-white/10 text-xs text-slate-300">
                            <div class="flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                                <span>Biro Perjalanan Berizin Resmi & Bergaransi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4 text-emerald-400"></i>
                                <span>Pemandu Wisata Asli Putra Daerah Dieng</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-emerald-400"></i>
                                <span>Jadwal Bebas Tentukan Sendiri (Private Tour)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4 text-emerald-400"></i>
                                <span>Fleksibel Reschedule Jika Cuaca Ekstrem</span>
                            </div>
                        </div>

                        <!-- CTA WhatsApp Booking -->
                        <div class="space-y-3">
                            <a
                                href="{{ $waUrl }}"
                                target="_blank"
                                class="w-full py-3.5 px-4 rounded-2xl font-bold text-xs sm:text-sm text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/25 transition-all duration-300 flex items-center justify-center gap-2 transform hover:-translate-y-0.5"
                            >
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                <span>Reservasi via WhatsApp Resmi</span>
                            </a>

                            <a
                                href="{{ route('home') }}#kalkulator"
                                class="w-full py-3 px-4 rounded-2xl font-semibold text-xs text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors flex items-center justify-center gap-2"
                            >
                                <i data-lucide="calculator" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Hitung Rincian di Kalkulator</span>
                            </a>
                        </div>

                        <!-- Hotline Bantuan -->
                        <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5 text-[11px] text-slate-400 text-center">
                            Butuh rute custom untuk rombongan / instansi kantor? Hubungi WhatsApp resmi kami di
                            <strong class="text-white block mt-1">{{ $settings->whatsapp_number }}</strong>
                        </div>
                    </div>

                    <!-- Kontak Darurat & Jam Operasional -->
                    <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/5 text-xs text-slate-400 space-y-2">
                        <div class="flex items-center gap-2 text-white font-semibold">
                            <i data-lucide="phone-call" class="w-4 h-4 text-amber-400"></i>
                            <span>Layanan Pelanggan 24 Jam</span>
                        </div>
                        <p class="text-[11px] leading-relaxed">
                            Respon cepat setiap hari untuk konsultasi kondisi cuaca Dieng, armada, dan penjemputan bandara/stasiun terdekat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Rekomendasi Paket Lainnya -->
    @if ($otherPackages->count() > 0)
        <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto w-full border-t border-white/10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Pilihan Alternatif</span>
                    <h2 class="font-serif text-xl sm:text-2xl font-bold text-white mt-1">Paket Wisata Terpopuler Lainnya</h2>
                </div>
                <a href="{{ route('home') }}#paket" class="text-xs font-semibold text-amber-400 hover:text-amber-300 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($otherPackages as $other)
                    <div class="glass-panel p-5 rounded-3xl border border-white/10 flex flex-col justify-between hover:border-amber-400/40 transition-all duration-300 group">
                        <div>
                            <div class="relative rounded-2xl overflow-hidden aspect-video mb-4">
                                <img src="{{ $other->image_url }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @if ($other->badge)
                                    <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950">
                                        {{ $other->badge }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $other->duration }}</span>
                            <h3 class="font-bold text-sm text-white mt-1 group-hover:text-amber-300 transition-colors line-clamp-1">
                                {{ $other->title }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $other->summary }}</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Mulai dari</span>
                                <span class="text-sm font-extrabold text-amber-400">{{ $other->formatted_price }}</span>
                            </div>
                            <a
                                href="{{ route('package.detail', $other->slug) }}"
                                class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white/10 hover:bg-amber-400 hover:text-black transition-colors"
                            >
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="mt-auto border-t border-white/10 bg-[#090d16] py-10 px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="font-serif font-bold text-white text-sm">{{ $settings->site_name }}</span> — {{ $settings->site_tagline }}
            </div>
            <div>
                © {{ date('Y') }} {{ $settings->site_name }}. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>
</div>
@endsection

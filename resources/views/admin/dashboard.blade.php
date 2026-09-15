@extends('layouts.app')

@section('title', 'Panel Pengelola — ' . $settings->site_name)

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Pengaturan Identitas Biro, Kontak, Legalitas & SEO" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Notifikasi Sukses / Error -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-red-500/15 border border-red-500/40 text-red-300 text-xs sm:text-sm space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span>Harap periksa kembali isian formulir:</span>
                </div>
                <ul class="list-disc list-inside text-xs pl-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $currentUser = Auth::user();
            $isSuperadmin = $currentUser && $currentUser->hasRole('superadmin');
        @endphp

        <!-- Banner Selamat Datang Berdasarkan Role -->
        @if ($isSuperadmin)
            <div class="relative overflow-hidden rounded-3xl p-6 sm:p-7 border border-amber-500/40 bg-gradient-to-r from-amber-500/15 via-purple-500/10 to-slate-900/80 backdrop-blur-xl shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-950 font-black shadow-lg shadow-amber-500/30 shrink-0">
                            <i data-lucide="crown" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-base sm:text-lg font-bold text-white tracking-tight">Selamat Datang, Super Administrator</h2>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-sm shadow-amber-500/30">Full Access</span>
                            </div>
                            <p class="text-xs text-slate-300 mt-1">
                                Anda memiliki kewenangan penuh: beralih tema multi-site (Tiket Dieng, Lotus Creative, Jeep 4x4, Shuttle), kontrol rekening bank resmi, dan manajemen staf pengelola.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-stretch sm:self-auto shrink-0">
                        <a href="#section-theme-switcher" class="px-3.5 py-2 rounded-xl text-xs font-bold text-amber-300 bg-amber-400/10 border border-amber-400/30 hover:bg-amber-400/20 transition-all flex items-center gap-1.5">
                            <i data-lucide="palette" class="w-4 h-4"></i>
                            <span>Tema Multi-Site</span>
                        </a>
                        <a href="#section-users" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-300 bg-white/5 border border-white/10 hover:bg-white/10 transition-all flex items-center gap-1.5">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            <span>Daftar Pengelola</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="relative overflow-hidden rounded-3xl p-5 sm:p-6 border border-sky-500/30 bg-gradient-to-r from-sky-500/10 via-slate-900/50 to-slate-900/80 backdrop-blur-xl">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-2xl bg-sky-500/20 border border-sky-500/40 flex items-center justify-center text-sky-400 font-bold shrink-0">
                        <i data-lucide="user-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm sm:text-base font-bold text-white tracking-tight">Selamat Datang, {{ $currentUser->name ?? 'Staf Pengelola' }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-sky-500/20 text-sky-300 border border-sky-500/30">Admin Staf</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Panel operasional aktif: Anda dapat mengelola paket wisata, pesanan & konten. Pengaturan tema dan rekening bank resmi dikunci oleh Super Administrator.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ringkasan Statistik Kunjungan Web -->
        <div class="glass-panel p-6 rounded-3xl border border-white/10">
            <div class="flex items-center justify-between mb-4 border-b border-white/10 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-amber-400"></i>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">Ringkasan Lalu Lintas Pengunjung (MySQL)</h3>
                </div>
                <span class="text-[11px] text-slate-400">Tercatat di server lokal tanpa pihak ketiga</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Hari Ini</span>
                    <div class="text-lg sm:text-xl font-bold text-amber-400 font-mono mt-0.5">{{ number_format($statsSummary['today_unique'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Unik hari ini</span>
                </div>
                <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Total Hits Hari Ini</span>
                    <div class="text-lg sm:text-xl font-bold text-sky-400 font-mono mt-0.5">{{ number_format($statsSummary['today_visits'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Permintaan halaman</span>
                </div>
                <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Total Pengunjung Unik</span>
                    <div class="text-lg sm:text-xl font-bold text-emerald-400 font-mono mt-0.5">{{ number_format($statsSummary['total_unique'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Akumulasi unik</span>
                </div>
                <div class="p-3.5 rounded-xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Total Semua Kunjungan</span>
                    <div class="text-lg sm:text-xl font-bold text-purple-400 font-mono mt-0.5">{{ number_format($statsSummary['total_visits'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Sejak instalasi</span>
                </div>
            </div>
        </div>

        <!-- FORMULIR UTAMA PENGATURAN -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8" id="settingsForm">
            @csrf

            <!-- KARTU KHUSUS: PENGATURAN MULTI-SITUS & GANTI TEMA -->
            @if ($isSuperadmin)
                <div id="section-theme-switcher" class="glass-panel p-6 sm:p-8 rounded-3xl border-2 border-amber-500/40 bg-gradient-to-br from-amber-500/10 via-white/[0.02] to-purple-500/10 shadow-2xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-white/10 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-400/20 border border-amber-400/40 flex items-center justify-center text-amber-400 shrink-0">
                                <i data-lucide="layers" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="font-bold text-base text-white">Pengaturan Multi-Situs & Tema Beranda Publik</h2>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950">Superadmin</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Pilih tema tampilan yang aktif untuk rute beranda (<code>/</code>). Di produksi, sistem juga otomatis beralih mengikuti custom domain pengunjung.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-slate-400">Tema Aktif Tersimpan:</span>
                            <span class="px-3 py-1 rounded-xl font-mono font-bold uppercase tracking-wider text-amber-300 bg-amber-400/15 border border-amber-400/40 shadow-sm shadow-amber-500/20">
                                {{ $settings->active_theme ?? 'tiketdieng' }}
                            </span>
                        </div>
                    </div>

                    <!-- Pilihan 4 Tema Sub-Unit Bisnis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- 1. Tiket Dieng (Portal Induk) -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="tiketdieng" {{ old('active_theme', $settings->active_theme ?? 'tiketdieng') === 'tiketdieng' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-white/[0.02] border-white/10 hover:border-amber-400/50 peer-checked:border-amber-400 peer-checked:bg-amber-400/[0.08] peer-checked:shadow-lg peer-checked:shadow-amber-500/15">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold text-xs font-mono">
                                            01
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30">
                                            Portal Induk
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-white group-hover:text-amber-300 transition-colors">Tiket Dieng</h3>
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                        Portal biro perjalanan terlengkap, paket VIP tour, sunrise Sikunir, kawah, dan candi Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-500 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>tiketdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                    <a href="{{ url('/?theme=tiketdieng') }}" target="_blank" class="text-[11px] font-medium text-amber-400 hover:text-amber-300 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-amber-400 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 2. Lotus Creative -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="lotus" {{ old('active_theme', $settings->active_theme ?? 'tiketdieng') === 'lotus' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-white/[0.02] border-white/10 hover:border-purple-400/50 peer-checked:border-purple-400 peer-checked:bg-purple-400/[0.08] peer-checked:shadow-lg peer-checked:shadow-purple-500/15">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-purple-400/20 text-purple-400 flex items-center justify-center font-bold text-xs font-mono">
                                            02
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-purple-400/20 text-purple-300 border border-purple-400/30">
                                            Creative Studio
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-white group-hover:text-purple-300 transition-colors">Lotus Creative</h3>
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                        Layanan dokumentasi foto liburan estetik, video cinematic reels, dan pilot drone 4K Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-500 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>lotuscreative.id</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                    <a href="{{ url('/?theme=lotus') }}" target="_blank" class="text-[11px] font-medium text-purple-400 hover:text-purple-300 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-purple-400 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 3. Jeep Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="jeep" {{ old('active_theme', $settings->active_theme ?? 'tiketdieng') === 'jeep' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-white/[0.02] border-white/10 hover:border-emerald-400/50 peer-checked:border-emerald-400 peer-checked:bg-emerald-400/[0.08] peer-checked:shadow-lg peer-checked:shadow-emerald-500/15">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-emerald-400/20 text-emerald-400 flex items-center justify-center font-bold text-xs font-mono">
                                            03
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                            Adventure 4x4
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-white group-hover:text-emerald-300 transition-colors">Jeep Dieng</h3>
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                        Sewa Jeep wisata offroad 4x4, rute fun trip, sunrise Bukit Sikunir, kawah & telaga Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-500 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>jeepdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                    <a href="{{ url('/?theme=jeep') }}" target="_blank" class="text-[11px] font-medium text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-emerald-400 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 4. Shuttle Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="shuttle" {{ old('active_theme', $settings->active_theme ?? 'tiketdieng') === 'shuttle' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-white/[0.02] border-white/10 hover:border-sky-400/50 peer-checked:border-sky-400 peer-checked:bg-sky-400/[0.08] peer-checked:shadow-lg peer-checked:shadow-sky-500/15">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-sky-400/20 text-sky-400 flex items-center justify-center font-bold text-xs font-mono">
                                            04
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-sky-400/20 text-sky-300 border border-sky-400/30">
                                            Transportasi
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-white group-hover:text-sky-300 transition-colors">Shuttle Dieng</h3>
                                    <p class="text-[11px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                        Armada mikrobus 15 kursi nyaman ber-AC, antar-jemput stasiun/bandara ke Dieng Plateau.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-500 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>shuttledieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                    <a href="{{ url('/?theme=shuttle') }}" target="_blank" class="text-[11px] font-medium text-sky-400 hover:text-sky-300 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-sky-400 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @else
                <div class="glass-panel p-4 rounded-2xl border border-white/10 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="layers" class="w-4 h-4 text-amber-400"></i>
                        <span class="text-xs text-slate-300">Tema Beranda Aktif Saat Ini:</span>
                        <span class="px-2 py-0.5 rounded-lg text-xs font-mono font-bold uppercase tracking-wider text-amber-300 bg-amber-400/10 border border-amber-400/30">
                            {{ $settings->active_theme ?? 'tiketdieng' }}
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-500">Dikelola oleh Super Administrator</span>
                </div>
            @endif

            <!-- Kartu 1: Identitas Platform -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="globe" class="w-5 h-5 text-amber-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">1. Identitas Situs Web</h2>
                        <p class="text-xs text-slate-400">
                            Nama jenama dan slogan yang tampil pada bilah navigasi dan footer
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nama Situs / Jenama
                        </label>
                        <input
                            type="text"
                            name="site_name"
                            id="inputSiteName"
                            value="{{ old('site_name', $settings->site_name) }}"
                            required
                            placeholder="TIKETDIENG.COM"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Slogan / Subjudul
                        </label>
                        <input
                            type="text"
                            name="site_tagline"
                            value="{{ old('site_tagline', $settings->site_tagline) }}"
                            required
                            placeholder="Biro Wisata Dataran Tinggi Dieng"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nama Perusahaan / Badan Hukum Resmi
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name', $settings->company_name) }}"
                            placeholder="PT. GOTRIP ASIA TRAVELINDO"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Ikon Tab Peramban (Favicon)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Mendukung berkas .ico, .png, .svg, .webp
                            </span>
                        </label>

                        <!-- Area Pratinjau & Tombol Unggah Berkas -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/10">
                            <!-- Pratinjau Ikon Aktif -->
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 rounded-xl bg-black/40 border border-white/10 flex items-center justify-center overflow-hidden p-2 flex-shrink-0">
                                    <img
                                        id="faviconPreview"
                                        src="{{ $settings->favicon_url ?: asset('favicon.ico') }}"
                                        alt="Pratinjau Favicon"
                                        class="w-full h-full object-contain"
                                        onerror="this.src='{{ asset('favicon.ico') }}'"
                                    />
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-white">Pratinjau Ikon Tab Aktif</p>
                                    <p class="text-[11px] text-slate-400 truncate max-w-[220px]" id="faviconText">
                                        {{ $settings->favicon_url ?: 'Ikon bawaan aktif' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Pemilih Berkas Ajax -->
                            <div class="sm:ml-auto w-full sm:w-auto">
                                <label class="relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/40 cursor-pointer transition-all">
                                    <i data-lucide="upload" class="w-3.5 h-3.5 text-amber-400"></i>
                                    <span id="faviconBtnText">Unggah Berkas Baru</span>
                                    <input
                                        type="file"
                                        id="fileFavicon"
                                        accept=".ico,.png,.svg,.webp,.jpg,.jpeg"
                                        class="hidden"
                                    />
                                </label>
                            </div>
                        </div>

                        <!-- Input Alternatif URL Langsung -->
                        <div class="mt-3">
                            <input
                                type="text"
                                name="favicon_url"
                                id="inputFaviconUrl"
                                value="{{ old('favicon_url', $settings->favicon_url) }}"
                                placeholder="Atau masukkan tautan URL favicon langsung: /favicon.ico atau https://..."
                                class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none transition-colors"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Profil Perusahaan, Visi & Misi (Resmi Klien) -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="compass" class="w-5 h-5 text-amber-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">2. Profil Perusahaan, Visi & Misi</h2>
                        <p class="text-xs text-slate-400">
                            Narasi resmi biro wisata, sejarah berdiri, tujuan jangka panjang, serta komitmen pelayanan ke wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Tentang Kami (Profil Singkat)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Tampil di beranda & profil biro</span>
                        </label>
                        <textarea
                            name="about_us"
                            rows="3"
                            placeholder="Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng..."
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors leading-relaxed"
                        >{{ old('about_us', $settings->about_us) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-purple-400"></i>
                                <span>Sejarah Singkat & Tahun Berdiri</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Didirikan 2022 di bawah PT. GOtrip Asia</span>
                        </label>
                        <textarea
                            name="company_history"
                            rows="3"
                            placeholder="Tiket Wisata Dieng berdiri sejak tahun 2022 di bawah naungan resmi induk PT. GOtrip Asia Travelindo..."
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-purple-400 focus:outline-none transition-colors leading-relaxed"
                        >{{ old('company_history', $settings->company_history) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="eye" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Visi Perusahaan (Tujuan Jangka Panjang)</span>
                            </label>
                            <textarea
                                name="company_vision"
                                rows="3"
                                placeholder="Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman..."
                                class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-emerald-400 focus:outline-none transition-colors leading-relaxed"
                            >{{ old('company_vision', $settings->company_vision) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="target" class="w-3.5 h-3.5 text-sky-400"></i>
                                <span>Misi Perusahaan & Komitmen Layanan</span>
                            </label>
                            <textarea
                                name="company_mission"
                                rows="3"
                                placeholder="Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo..."
                                class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors leading-relaxed"
                            >{{ old('company_mission', $settings->company_mission) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Kontak & Pemesanan -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5 text-emerald-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">3. Saluran Komunikasi & Reservasi</h2>
                        <p class="text-xs text-slate-400">
                            Nomor WhatsApp dan telepon untuk kalkulator reservasi otomatis
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Nomor WhatsApp Reservasi</span>
                        </label>
                        <input
                            type="text"
                            name="whatsapp_number"
                            value="{{ old('whatsapp_number', $settings->whatsapp_number) }}"
                            required
                            placeholder="62816675404"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-emerald-400 focus:outline-none transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Gunakan awalan angka 62 tanpa spasi atau strip (misal: 62816675404)
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-sky-400"></i>
                            <span>Tampilan Nomor Telepon</span>
                        </label>
                        <input
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $settings->phone_number) }}"
                            required
                            placeholder="+62 816-675-404"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-400"></i>
                            <span>Alamat Email Layanan Resmi</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $settings->email) }}"
                            required
                            placeholder="halo@tiketdieng.com"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors"
                        />
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Alamat & Legalitas -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="map-pin" class="w-5 h-5 text-rose-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">4. Alamat Kantor & Legalitas Usaha</h2>
                        <p class="text-xs text-slate-400">
                            Informasi terpercaya yang membangun kredibilitas bagi calon wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Alamat Lengkap Kantor Operasional
                        </label>
                        <textarea
                            name="address"
                            rows="3"
                            required
                            placeholder="Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo, Jawa Tengah 56354"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-rose-400 focus:outline-none transition-colors resize-none"
                        >{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-amber-400"></i>
                                    <span>Nomor Legalitas NIB / Perizinan Usaha</span>
                                </label>
                                @unless ($isSuperadmin)
                                    <span class="text-[10px] font-semibold text-amber-400/80 flex items-center gap-1">
                                        <i data-lucide="lock" class="w-3 h-3"></i> Superadmin
                                    </span>
                                @endunless
                            </div>
                            <input
                                type="text"
                                name="legal_nib"
                                value="{{ old('legal_nib', $settings->legal_nib) }}"
                                placeholder="Contoh: NIB: 1294801928472"
                                @unless ($isSuperadmin) readonly disabled @endunless
                                class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors @unless($isSuperadmin) opacity-60 bg-white/[0.02] cursor-not-allowed @endunless"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Lencana Asosiasi / Sertifikasi Pemandu</span>
                            </label>
                            <input
                                type="text"
                                name="hpi_badge"
                                value="{{ old('hpi_badge', $settings->hpi_badge) }}"
                                placeholder="Contoh: Anggota Resmi HPI Dieng"
                                class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-emerald-400 focus:outline-none transition-colors"
                            />
                        </div>
                    </div>

                    <!-- Informasi Rekening Bank Perusahaan -->
                    <div class="pt-4 border-t border-white/10">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-1.5">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                                <span>Rekening Resmi Pembayaran / Reservasi</span>
                            </h3>
                            @unless ($isSuperadmin)
                                <span class="text-[10px] font-semibold text-amber-400/90 flex items-center gap-1 bg-amber-400/10 px-2 py-0.5 rounded-md border border-amber-400/20">
                                    <i data-lucide="lock" class="w-3 h-3"></i> Terkunci (Superadmin Only)
                                </span>
                            @endunless
                        </div>

                        @unless ($isSuperadmin)
                            <div class="p-3 mb-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-4 h-4 shrink-0"></i>
                                <span>Rekening pembayaran resmi dilindungi dan hanya dapat diperbarui oleh Super Administrator demi integritas transaksi.</span>
                            </div>
                        @endunless

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Nama Bank & Cabang</label>
                                <input
                                    type="text"
                                    name="bank_name"
                                    value="{{ old('bank_name', $settings->bank_name) }}"
                                    placeholder="BNI Cabang Wonosobo"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none @unless($isSuperadmin) opacity-60 bg-white/[0.02] cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Nomor Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_number"
                                    value="{{ old('bank_account_number', $settings->bank_account_number) }}"
                                    placeholder="8166754042"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs font-mono focus:border-amber-400 focus:outline-none @unless($isSuperadmin) opacity-60 bg-white/[0.02] cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_name"
                                    value="{{ old('bank_account_name', $settings->bank_account_name) }}"
                                    placeholder="PT. GOTRIP ASIA TRAVELINDO"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none @unless($isSuperadmin) opacity-60 bg-white/[0.02] cursor-not-allowed @endunless"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Tautan Media Sosial Resmi -->
                    <div class="pt-4 border-t border-white/10">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3 flex items-center gap-1.5">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                            <span>Akun Media Sosial Resmi</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Instagram URL</label>
                                <input
                                    type="text"
                                    name="instagram_url"
                                    value="{{ old('instagram_url', $settings->instagram_url) }}"
                                    placeholder="https://www.instagram.com/..."
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-sky-400 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">TikTok URL</label>
                                <input
                                    type="text"
                                    name="tiktok_url"
                                    value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                                    placeholder="https://tiktok.com/@..."
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-sky-400 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Facebook URL</label>
                                <input
                                    type="text"
                                    name="facebook_url"
                                    value="{{ old('facebook_url', $settings->facebook_url) }}"
                                    placeholder="https://www.facebook.com/..."
                                    class="w-full p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-sky-400 focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 5: Optimasi SEO & Social Media Share -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="search" class="w-5 h-5 text-sky-400"></i>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-base text-white">5. Optimasi Mesin Pencari & Sosial Media (SEO)</h2>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/30">
                                GOOGLE & MEDSOS
                            </span>
                        </div>
                        <p class="text-xs text-slate-400">
                            Konfigurasi judul Google, deskripsi pencarian, dan gambar kartu berbagi WhatsApp
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- SEO Title -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-sky-400"></i>
                                <span>Judul Penelusuran Google & Tab Browser (Meta Title)</span>
                            </label>
                            <span id="seoTitleCount" class="text-[11px] text-slate-400">
                                {{ strlen($settings->seo_title ?? '') }}/60 karakter ideal
                            </span>
                        </div>
                        <input
                            type="text"
                            name="seo_title"
                            id="inputSeoTitle"
                            value="{{ old('seo_title', $settings->seo_title) }}"
                            placeholder="Otomatis mengikuti: {{ $settings->site_name }} — {{ $settings->site_tagline }}"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">
                            Judul utama pada tab peramban dan pencarian Google. <span class="text-amber-400/90 font-medium">Kosongkan jika ingin selalu otomatis mengikuti Nama Situs & Slogan.</span>
                        </p>
                    </div>

                    <!-- SEO Description -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-300 flex items-center gap-1.5">
                                <span>Deskripsi Penelusuran Google (Meta Description)</span>
                            </label>
                            <span id="seoDescCount" class="text-[11px] text-slate-400">
                                {{ strlen($settings->seo_description ?? '') }}/160 karakter ideal
                            </span>
                        </div>
                        <textarea
                            name="seo_description"
                            id="inputSeoDesc"
                            rows="3"
                            placeholder="Biro perjalanan wisata resmi Dataran Tinggi Dieng..."
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors resize-none"
                        >{{ old('seo_description', $settings->seo_description) }}</textarea>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Rangkuman singkat yang memikat calon pelanggan di bawah tautan Google.
                        </p>
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Target Kata Kunci Penelusuran (Keywords)
                        </label>
                        <input
                            type="text"
                            name="seo_keywords"
                            value="{{ old('seo_keywords', $settings->seo_keywords) }}"
                            placeholder="paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Pisahkan setiap kata kunci menggunakan tanda koma (,).
                        </p>
                    </div>

                    <!-- OG Image Upload & Preview -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="share-2" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Gambar Banner Berbagi Medsos & WhatsApp (OG Image)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Rasio 1.91:1 (ideal 1200x630 px)
                            </span>
                        </label>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-2xl bg-white/[0.03] border border-white/10">
                            <div class="w-28 h-16 rounded-xl bg-black/40 border border-white/10 overflow-hidden flex items-center justify-center flex-shrink-0">
                                <img
                                    id="ogPreview"
                                    src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                    alt="Pratinjau Banner Medsos"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-white">Banner Media Sosial Aktif</p>
                                <p class="text-[11px] text-slate-400 truncate" id="ogText">
                                    {{ $settings->og_image_url ?: 'Banner standar aktif' }}
                                </p>
                            </div>
                            <label class="relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-sky-500/20 hover:bg-sky-500/30 border border-sky-500/40 cursor-pointer transition-all flex-shrink-0">
                                <i data-lucide="upload" class="w-3.5 h-3.5 text-sky-400"></i>
                                <span id="ogBtnText">Unggah Banner Baru</span>
                                <input
                                    type="file"
                                    id="fileOg"
                                    accept="image/*"
                                    class="hidden"
                                />
                            </label>
                        </div>

                        <input
                            type="text"
                            name="og_image_url"
                            id="inputOgUrl"
                            value="{{ old('og_image_url', $settings->og_image_url) }}"
                            placeholder="Atau masukkan tautan URL gambar langsung..."
                            class="w-full mt-3 p-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-sky-400 focus:outline-none transition-colors"
                        />
                    </div>

                    <!-- LIVE VISUAL PREVIEW (SERP & WHATSAPP CARD) -->
                    <div class="pt-4 border-t border-white/10 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300">
                            Pratinjau Tampilan Langsung (Live Visual Preview)
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- SERP Google Preview -->
                            <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/10 space-y-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="search" class="w-3 h-3 text-sky-400"></i>
                                    Pratinjau di Google Search
                                </span>
                                <div class="p-3.5 rounded-xl bg-[#202124] border border-white/5 text-left">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-4 h-4 rounded-full bg-slate-700 flex items-center justify-center text-[9px] text-amber-400">
                                            ▲
                                        </div>
                                        <div class="text-[11px] text-slate-300 truncate">
                                            tiketdieng.com <span class="text-slate-500">› paket-wisata</span>
                                        </div>
                                    </div>
                                    <h4 id="previewGoogleTitle" class="text-sm font-medium text-[#8ab4f8] hover:underline line-clamp-1">
                                        {{ $settings->seo_title ?: $settings->site_name }}
                                    </h4>
                                    <p id="previewGoogleDesc" class="text-xs text-[#bdc1c6] mt-1 line-clamp-2 leading-relaxed">
                                        {{ $settings->seo_description ?: 'Biro perjalanan wisata resmi Dataran Tinggi Dieng dengan layanan VIP...' }}
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp Share Card Preview -->
                            <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/10 space-y-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="share-2" class="w-3 h-3 text-emerald-400"></i>
                                    Pratinjau Kartu Berbagi WhatsApp
                                </span>
                                <div class="rounded-xl bg-[#1f2c34] border border-white/5 overflow-hidden text-left shadow-md">
                                    <div class="h-28 w-full bg-black/40 overflow-hidden">
                                        <img
                                            id="previewWaImage"
                                            src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                            alt="Pratinjau WhatsApp"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div class="p-3 bg-[#111b21]">
                                        <h4 id="previewWaTitle" class="text-xs font-semibold text-slate-100 line-clamp-1">
                                            {{ $settings->seo_title ?: $settings->site_name }}
                                        </h4>
                                        <p id="previewWaDesc" class="text-[11px] text-slate-400 line-clamp-2 mt-0.5">
                                            {{ $settings->seo_description ?: $settings->site_tagline }}
                                        </p>
                                        <span class="text-[10px] text-slate-500 uppercase tracking-wider mt-1 block">
                                            TIKETDIENG.COM
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Simpan & Reset -->
            <div class="p-6 rounded-3xl glass-panel border border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-30 shadow-2xl backdrop-blur-xl">
                <div class="text-xs text-slate-400 text-center sm:text-left">
                    Pastikan seluruh data telah sesuai sebelum menekan simpan. Perubahan langsung terbit seketika ke halaman publik.
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="flex-1 sm:flex-none px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Seluruh Pengaturan</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- KARTU KHUSUS SUPERADMIN: MANAJEMEN AKUN PENGELOLA & ROLE (SPATIE) -->
        @if ($isSuperadmin && isset($users))
            <div id="section-users" class="glass-panel p-6 sm:p-8 rounded-3xl border-2 border-purple-500/30 bg-gradient-to-br from-purple-500/5 via-white/[0.01] to-amber-500/5 shadow-2xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-500/20 border border-purple-500/40 flex items-center justify-center text-purple-400 shrink-0">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-bold text-base text-white">Manajemen Akun Pengelola & Hak Akses (Spatie Role)</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-500 text-white">Superadmin Only</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Daftar akun terautentikasi dan pembagian role hak akses sistem (Superadmin vs Admin Staf).
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-xs text-slate-400 font-mono hidden sm:inline">Total: <strong class="text-white">{{ $users->count() }} Akun</strong></span>
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20 flex items-center gap-1.5">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            <span>Kelola & Tambah Pengelola</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="uppercase tracking-wider text-[10px] text-slate-400 bg-white/[0.03] border-y border-white/5 font-bold">
                            <tr>
                                <th class="py-3 px-4">Pengelola</th>
                                <th class="py-3 px-4">Email Login</th>
                                <th class="py-3 px-4">Role Sistem</th>
                                <th class="py-3 px-4">Hak Akses & Batasan</th>
                                <th class="py-3 px-4 text-right">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($users as $u)
                                @php
                                    $uIsSuper = $u->hasRole('superadmin');
                                @endphp
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs {{ $uIsSuper ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-500/30' : 'bg-sky-500/20 text-sky-300 border border-sky-500/30' }}">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-white flex items-center gap-1.5">
                                                    <span>{{ $u->name }}</span>
                                                    @if (Auth::id() === $u->id)
                                                        <span class="text-[9px] px-1.5 py-0.2 rounded bg-white/10 text-slate-300 font-normal">(Akun Anda)</span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-slate-500">ID #{{ $u->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-300">
                                        {{ $u->email }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/40 shadow-sm shadow-amber-500/20">
                                                <i data-lucide="crown" class="w-3 h-3 text-amber-400"></i>
                                                Superadmin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-semibold uppercase tracking-wider bg-sky-500/15 text-sky-300 border border-sky-500/30">
                                                <i data-lucide="user" class="w-3 h-3 text-sky-400"></i>
                                                Admin Staf
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="text-[11px] text-amber-300/90 font-medium">
                                                Full Control: Multi-Site Themes, NIB & Rekening Bank, Manajemen User & Database.
                                            </span>
                                        @else
                                            <span class="text-[11px] text-slate-400">
                                                Operasional: Kelola Paket Wisata, Voucher, Pesanan & Konten Promosi.
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-400 text-[11px]">
                                        {{ $u->created_at ? $u->created_at->format('d M Y') : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3.5 rounded-2xl bg-white/[0.02] border border-white/5 text-[11px] text-slate-400 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-purple-400 shrink-0"></i>
                        <span>Otorisasi role dikelola secara aman menggunakan pustaka <strong>Spatie Laravel-Permission</strong> pada tingkat middleware dan model database.</span>
                    </div>
                    <span class="text-[10px] font-mono text-slate-500 hidden sm:inline">Role Table: roles & model_has_roles</span>
                </div>
            </div>
        @endif

        <!-- Form Reset Default Terpisah -->
        <div class="pt-4 border-t border-white/10 flex justify-end">
            <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Pengaturan Situs', 'Seluruh konfigurasi kontak, nama perusahaan, dan legalitas akan dikembalikan ke data awal bawaan.') : confirm('Kembalikan ke pengaturan awal bawaan?');">
                @csrf
                <button
                    type="submit"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-white/5 border border-white/10 transition-colors cursor-pointer"
                >
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span>Kembalikan ke Pengaturan Awal</span>
                </button>
            </form>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    // 1. Live Input Count & Live SERP / WhatsApp Sync
    const inputSiteName = document.getElementById('inputSiteName');
    const inputSeoTitle = document.getElementById('inputSeoTitle');
    const inputSeoDesc = document.getElementById('inputSeoDesc');
    const inputOgUrl = document.getElementById('inputOgUrl');

    const seoTitleCount = document.getElementById('seoTitleCount');
    const seoDescCount = document.getElementById('seoDescCount');

    const previewGoogleTitle = document.getElementById('previewGoogleTitle');
    const previewGoogleDesc = document.getElementById('previewGoogleDesc');
    const previewWaTitle = document.getElementById('previewWaTitle');
    const previewWaDesc = document.getElementById('previewWaDesc');
    const previewWaImage = document.getElementById('previewWaImage');
    const ogPreview = document.getElementById('ogPreview');

    const inputTagline = document.querySelector('input[name="site_tagline"]');

    function syncLivePreviews() {
        const activeSiteName = inputSiteName.value.trim() || 'TIKETDIENG.COM';
        const activeTagline = inputTagline?.value.trim() || 'Biro Wisata Dataran Tinggi Dieng';
        inputSeoTitle.placeholder = `Otomatis mengikuti: ${activeSiteName} — ${activeTagline}`;

        const title = inputSeoTitle.value.trim() || `${activeSiteName} — ${activeTagline}`;
        const desc = inputSeoDesc.value.trim() || 'Biro perjalanan wisata resmi Dataran Tinggi Dieng dengan layanan VIP...';
        const ogUrl = inputOgUrl.value.trim() || 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop';

        seoTitleCount.innerText = `${inputSeoTitle.value.length}/60 karakter ideal`;
        seoDescCount.innerText = `${inputSeoDesc.value.length}/160 karakter ideal`;

        previewGoogleTitle.innerText = title;
        previewGoogleDesc.innerText = desc;
        previewWaTitle.innerText = title;
        previewWaDesc.innerText = desc;
        previewWaImage.src = ogUrl;
        ogPreview.src = ogUrl;
    }

    inputSiteName?.addEventListener('input', syncLivePreviews);
    inputTagline?.addEventListener('input', syncLivePreviews);
    inputSeoTitle?.addEventListener('input', syncLivePreviews);
    inputSeoDesc?.addEventListener('input', syncLivePreviews);
    inputOgUrl?.addEventListener('input', syncLivePreviews);

    // 2. Favicon Upload Ajax Handler
    const fileFavicon = document.getElementById('fileFavicon');
    const faviconPreview = document.getElementById('faviconPreview');
    const inputFaviconUrl = document.getElementById('inputFaviconUrl');
    const faviconText = document.getElementById('faviconText');
    const faviconBtnText = document.getElementById('faviconBtnText');

    fileFavicon?.addEventListener('change', async (e) => {
        if (!e.target.files || !e.target.files[0]) return;
        const file = e.target.files[0];

        faviconBtnText.innerText = 'Mengunggah...';
        const formData = new FormData();
        formData.append('favicon', file);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.upload.favicon') }}', {
                method: 'POST',
                body: formData,
            });
            const data = await res.json();
            if (data.success) {
                faviconPreview.src = data.url;
                inputFaviconUrl.value = data.url;
                faviconText.innerText = data.url;
                alert('Favicon berhasil diunggah dan diperbarui!');
            } else {
                alert(data.message || 'Gagal mengunggah favicon.');
            }
        } catch (err) {
            alert('Terjadi kesalahan saat mengunggah berkas.');
        } finally {
            faviconBtnText.innerText = 'Unggah Berkas Baru';
        }
    });

    // 3. OG Image Banner Upload Ajax Handler
    const fileOg = document.getElementById('fileOg');
    const ogBtnText = document.getElementById('ogBtnText');
    const ogText = document.getElementById('ogText');

    fileOg?.addEventListener('change', async (e) => {
        if (!e.target.files || !e.target.files[0]) return;
        const file = e.target.files[0];

        ogBtnText.innerText = 'Mengunggah...';
        const formData = new FormData();
        formData.append('og_image', file);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.upload.og') }}', {
                method: 'POST',
                body: formData,
            });
            const data = await res.json();
            if (data.success) {
                inputOgUrl.value = data.url;
                ogPreview.src = data.url;
                previewWaImage.src = data.url;
                ogText.innerText = data.url;
                alert('Banner media sosial berhasil diunggah!');
            } else {
                alert(data.message || 'Gagal mengunggah banner.');
            }
        } catch (err) {
            alert('Terjadi kesalahan saat mengunggah berkas.');
        } finally {
            ogBtnText.innerText = 'Unggah Banner Baru';
        }
    });
</script>
@endpush

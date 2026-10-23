@extends('layouts.app')

@section('title', 'Partner Extranet & Konfigurasi')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu Tiket Partner -->
    <x-admin-nav :settings="$settings" subtitle="Pengaturan Identitas Biro, Kontak, Legalitas & SEO" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Notifikasi Sukses / Error -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1.5 shadow-xs">
                <div class="font-bold flex items-center gap-2 text-rose-700">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span>Harap periksa kembali isian formulir:</span>
                </div>
                <ul class="list-disc list-inside text-xs pl-2 space-y-0.5 text-rose-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $currentUser = Auth::user();
            $isSuperadmin = $currentUser && $currentUser->hasRole('superadmin');
            
            // Query metric counts
            $totalPackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') ? \App\Models\TourPackage::count() : 0;
            $activePackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') ? \App\Models\TourPackage::where('is_active', true)->count() : 0;
            $totalPickups = \Illuminate\Support\Facades\Schema::hasTable('pickup_locations') ? \App\Models\PickupLocation::count() : 0;
            $totalComcodes = \Illuminate\Support\Facades\Schema::hasTable('comcodes') ? \App\Models\Comcode::count() : 0;
            
            // Recent packages preview
            $recentPackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') 
                ? \App\Models\TourPackage::latest()->take(5)->get() 
                : collect();
        @endphp

        <!-- Banner Selamat Datang Tiket Partner Style -->
        @if ($isSuperadmin)
            <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 bg-gradient-to-r from-[#0064D2] via-[#0051A8] to-blue-800 text-white shadow-xl shadow-blue-900/10">
                <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute top-0 right-1/4 w-32 h-32 bg-[#FEDD00]/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-13 h-13 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shadow-inner shrink-0">
                            <i data-lucide="crown" class="w-7 h-7 text-[#FEDD00]"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-base sm:text-xl font-extrabold text-white tracking-tight">Selamat Datang, Super Administrator</h2>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#FEDD00] text-slate-900 shadow-xs">Full Access</span>
                            </div>
                            <p class="text-xs text-blue-100 mt-1 max-w-2xl leading-relaxed">
                                Kontrol terpusat partner extranet: alihkan tema multi-site (Tiket Dieng, Lotus Creative, Jeep 4x4, Shuttle), rekening resmi biro, dan otorisasi tim pengelola.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 self-stretch sm:self-auto shrink-0">
                        <a href="#section-theme-switcher" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-900 bg-[#FEDD00] hover:bg-[#F5D300] transition-all flex items-center gap-1.5 shadow-sm">
                            <i data-lucide="palette" class="w-4 h-4"></i>
                            <span>Tema Multi-Site</span>
                        </a>
                        <a href="#section-users" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-white/15 hover:bg-white/25 border border-white/20 transition-all flex items-center gap-1.5 backdrop-blur-sm">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            <span>Daftar Tim</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="relative overflow-hidden rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] font-bold shrink-0">
                        <i data-lucide="user-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">Selamat Datang, {{ $currentUser->name ?? 'Staf Mitra' }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#0064D2] border border-blue-200">Admin Staf</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Panel operasional mitra aktif: kelola paket wisata, rute jemput, dan konten profil biro perjalanan Anda.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Prominent Summary Metric Cards (Tiket Partner Extranet Pastel Icons) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Metric 1: Total Paket Wisata -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Paket</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalPackages, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ $activePackages }} paket aktif publik
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                    <i data-lucide="compass" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 2: Total Titik Jemput -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Titik Jemput</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalPickups, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-1 flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-3 h-3 text-amber-500"></i>
                        Stasiun & Bandara
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 3: Pengunjung Hari Ini -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Pengunjung Hari Ini</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($statsSummary['today_unique'], 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-1 flex items-center gap-1">
                        <span class="text-emerald-600 font-bold">{{ number_format($statsSummary['today_visits'], 0, ',', '.') }}</span>
                        hits halaman
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 4: Total Master Kode / Komisi -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Master Kode</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalComcodes, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-purple-600 mt-1 flex items-center gap-1">
                        <i data-lucide="database" class="w-3 h-3 text-purple-500"></i>
                        Kode komisi & kategori
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                    <i data-lucide="ticket" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <!-- Clean Tabular Preview of Recent Packages -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                        <i data-lucide="compass" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Pratinjau Paket Wisata Terbaru</h3>
                        <p class="text-xs text-slate-500">Ringkasan paket tur yang baru saja ditambahkan atau diperbarui</p>
                    </div>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0064D2] hover:text-[#0051A8] hover:underline self-start sm:self-auto">
                    <span>Lihat Semua Paket ({{ $totalPackages }})</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @if($recentPackages->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="uppercase tracking-wider text-[11px] text-slate-400 bg-slate-50/80 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="py-3 px-5">Paket Wisata</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Durasi</th>
                                <th class="py-3 px-4">Tarif Dasar</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($recentPackages as $pkg)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-10 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                                @if($pkg->image_url)
                                                    <img src="{{ $pkg->image_url }}" alt="{{ $pkg->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <i data-lucide="image" class="w-4 h-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1">
                                                    {{ $pkg->title }}
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                                    slug: {{ $pkg->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-600">
                                        {{ $pkg->category ?: 'Standar' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        {{ $pkg->duration ?: '1 Hari' }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($pkg->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-[#0064D2] hover:bg-blue-50 border border-blue-200 transition-colors">
                                            <i data-lucide="edit-3" class="w-3 h-3"></i>
                                            <span>Kelola</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-slate-400 text-xs">
                    Belum ada data paket wisata yang tersimpan.
                </div>
            @endif
        </div>

        <!-- TAB PEMILIH SUB-WEB PENGATURAN (MULTI-SITE SETTINGS) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Pilih Sub-Web Yang Dikonfigurasi:</span>
                        <p class="text-[11px] text-slate-500">Konfigurasi berlaku spesifik untuk unit bisnis yang dipilih di bawah</p>
                    </div>
                </div>
                <div class="text-[11px] text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/80">
                    Profil Aktif: <strong class="text-[#0064D2] font-bold">{{ $supportedSites[$selectedSite]['name'] }}</strong> (<code class="text-slate-500">{{ $supportedSites[$selectedSite]['domain'] }}</code>)
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($supportedSites as $siteKey => $siteInfo)
                    @php
                        $isActiveTab = ($selectedSite === $siteKey);
                    @endphp
                    <a
                        href="{{ route('admin.index', ['site' => $siteKey]) }}"
                        class="p-4 rounded-2xl border transition-all flex flex-col justify-between gap-3 {{ $isActiveTab ? 'bg-blue-50/70 border-2 border-[#0064D2] shadow-sm' : 'bg-slate-50/60 border-slate-200 hover:border-slate-300 hover:bg-slate-100/60' }}"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-md uppercase font-bold {{ $isActiveTab ? 'bg-[#0064D2] text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $siteInfo['badge'] }}
                            </span>
                            @if ($isActiveTab)
                                <span class="w-2.5 h-2.5 rounded-full bg-[#0064D2] ring-4 ring-blue-100"></span>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs sm:text-sm font-extrabold block {{ $isActiveTab ? 'text-[#0064D2]' : 'text-slate-800' }}">
                                {{ $siteInfo['name'] }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-500 block truncate mt-0.5">
                                {{ $siteInfo['domain'] }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- FORMULIR UTAMA PENGATURAN TIKET PARTNER -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8" id="settingsForm">
            @csrf
            <input type="hidden" name="site_key" value="{{ $selectedSite }}" id="inputSiteKey">

            <!-- KARTU KHUSUS: PENGATURAN MULTI-SITUS & GANTI TEMA (SUPERADMIN) -->
            @if ($isSuperadmin)
                <div id="section-theme-switcher" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                                <i data-lucide="palette" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="font-extrabold text-base text-slate-900">Pengaturan Multi-Situs & Tema Beranda Publik</h2>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#FEDD00] text-slate-900">Superadmin</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Pilih tema tampilan yang aktif untuk rute beranda publik (<code>/</code>). Di produksi, sistem otomatis mengikuti custom domain pengunjung.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-slate-500 font-medium">Tema Aktif:</span>
                            <span class="px-3 py-1 rounded-xl font-mono font-bold uppercase tracking-wider text-[#0064D2] bg-blue-50 border border-blue-200 shadow-2xs">
                                {{ $globalSetting->active_theme ?? 'tiketdieng' }}
                            </span>
                        </div>
                    </div>

                    <!-- Pilihan 4 Tema Sub-Unit Bisnis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- 1. Tiket Dieng (Portal Induk) -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="tiketdieng" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'tiketdieng' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-blue-300 peer-checked:border-[#0064D2] peer-checked:bg-blue-50/50 peer-checked:ring-2 peer-checked:ring-blue-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#0064D2] flex items-center justify-center font-bold text-xs font-mono">
                                            01
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-[#0064D2]">
                                            Portal Induk
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-[#0064D2] transition-colors">Tiket Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Portal biro perjalanan terlengkap, paket VIP tour, sunrise Sikunir, kawah, dan candi Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>tiketdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=tiketdieng') }}" target="_blank" class="text-[11px] font-bold text-[#0064D2] hover:text-[#0051A8] flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-[#0064D2] peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 2. Lotus Creative -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="lotus" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'lotus' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-purple-300 peer-checked:border-purple-500 peer-checked:bg-purple-50/50 peer-checked:ring-2 peer-checked:ring-purple-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xs font-mono">
                                            02
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                            Creative Studio
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-purple-700 transition-colors">Lotus Creative</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Layanan dokumentasi foto liburan estetik, video cinematic reels, dan pilot drone 4K Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>lotuscreative.id</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=lotus') }}" target="_blank" class="text-[11px] font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-purple-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 3. Jeep Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="jeep" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'jeep' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:ring-2 peer-checked:ring-emerald-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs font-mono">
                                            03
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                            Adventure 4x4
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-700 transition-colors">Jeep Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Sewa Jeep wisata offroad 4x4, rute fun trip, sunrise Bukit Sikunir, kawah & telaga Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>jeepdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=jeep') }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-emerald-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 4. Shuttle Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="shuttle" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'shuttle' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-sky-300 peer-checked:border-sky-500 peer-checked:bg-sky-50/50 peer-checked:ring-2 peer-checked:ring-sky-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs font-mono">
                                            04
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-sky-100 text-sky-700">
                                            Transportasi
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-sky-700 transition-colors">Shuttle Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Armada mikrobus 15 kursi ber-AC, antar-jemput stasiun/bandara ke Dataran Tinggi Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>shuttledieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=shuttle') }}" target="_blank" class="text-[11px] font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-sky-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="layers" class="w-4 h-4 text-[#0064D2]"></i>
                        <span class="text-xs text-slate-600">Tema Beranda Aktif:</span>
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold uppercase tracking-wider text-[#0064D2] bg-blue-50 border border-blue-200">
                            {{ $globalSetting->active_theme ?? 'tiketdieng' }}
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-400">Dikelola oleh Super Administrator</span>
                </div>
            @endif

            <!-- Kartu 1: Identitas Platform -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">1. Identitas Situs Web</h2>
                        <p class="text-xs text-slate-500">
                            Nama jenama dan slogan yang tampil pada bilah navigasi dan footer
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nama Situs / Jenama
                        </label>
                        <input
                            type="text"
                            name="site_name"
                            id="inputSiteName"
                            value="{{ old('site_name', $settings->site_name) }}"
                            required
                            placeholder="TIKETDIENG.COM"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Slogan / Subjudul
                        </label>
                        <input
                            type="text"
                            name="site_tagline"
                            value="{{ old('site_tagline', $settings->site_tagline) }}"
                            required
                            placeholder="Biro Wisata Dataran Tinggi Dieng"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nama Perusahaan / Badan Hukum Resmi
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name', $settings->company_name) }}"
                            placeholder="PT. GOTRIP ASIA TRAVELINDO"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Ikon Tab Peramban (Favicon)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Mendukung berkas .ico, .png, .svg, .webp
                            </span>
                        </label>

                        <!-- Area Pratinjau & Tombol Unggah Berkas -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <!-- Pratinjau Ikon Aktif -->
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden p-2 shrink-0 shadow-2xs">
                                    <img
                                        id="faviconPreview"
                                        src="{{ $settings->favicon_url ?: asset('favicon.ico') }}"
                                        alt="Pratinjau Favicon"
                                        class="w-full h-full object-contain"
                                        onerror="this.src='{{ asset('favicon.ico') }}'"
                                    />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800">Pratinjau Ikon Tab Aktif</p>
                                    <p class="text-[11px] text-slate-500 truncate" id="faviconText">
                                        {{ $settings->favicon_url ?: 'Ikon bawaan aktif' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Pemilih Berkas Ajax -->
                            <div class="w-full sm:w-auto shrink-0">
                                <label class="w-full sm:w-auto relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 border border-blue-200 cursor-pointer transition-all">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
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
                                class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs transition-colors"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Profil Perusahaan, Visi & Misi -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <i data-lucide="compass" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">2. Profil Perusahaan, Visi & Misi</h2>
                        <p class="text-xs text-slate-500">
                            Narasi resmi biro wisata, sejarah berdiri, tujuan jangka panjang, serta komitmen pelayanan ke wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Tentang Kami (Profil Singkat)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Tampil di beranda & profil biro</span>
                        </label>
                        <textarea
                            name="about_us"
                            rows="3"
                            placeholder="Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                        >{{ old('about_us', $settings->about_us) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-purple-600"></i>
                                <span>Sejarah Singkat & Tahun Berdiri</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Didirikan 2022 di bawah PT. GOtrip Asia</span>
                        </label>
                        <textarea
                            name="company_history"
                            rows="3"
                            placeholder="Tiket Wisata Dieng berdiri sejak tahun 2022 di bawah naungan resmi induk PT. GOtrip Asia Travelindo..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                        >{{ old('company_history', $settings->company_history) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="eye" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Visi Perusahaan (Tujuan Jangka Panjang)</span>
                            </label>
                            <textarea
                                name="company_vision"
                                rows="3"
                                placeholder="Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman..."
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                            >{{ old('company_vision', $settings->company_vision) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="target" class="w-3.5 h-3.5 text-sky-600"></i>
                                <span>Misi Perusahaan & Komitmen Layanan</span>
                            </label>
                            <textarea
                                name="company_mission"
                                rows="3"
                                placeholder="Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo..."
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                            >{{ old('company_mission', $settings->company_mission) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Kontak & Pemesanan -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">3. Saluran Komunikasi & Reservasi</h2>
                        <p class="text-xs text-slate-500">
                            Nomor WhatsApp dan telepon untuk kalkulator reservasi otomatis
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Nomor WhatsApp Reservasi</span>
                        </label>
                        <input
                            type="text"
                            name="whatsapp_number"
                            value="{{ old('whatsapp_number', $settings->whatsapp_number) }}"
                            required
                            placeholder="62816675404"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">
                            Gunakan awalan angka 62 tanpa spasi atau strip (misal: 62816675404)
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-sky-600"></i>
                            <span>Tampilan Nomor Telepon</span>
                        </label>
                        <input
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $settings->phone_number) }}"
                            required
                            placeholder="+62 816-675-404"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                            <span>Alamat Email Layanan Resmi</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $settings->email) }}"
                            required
                            placeholder="halo@tiketdieng.com"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Alamat & Legalitas -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">4. Alamat Kantor & Legalitas Usaha</h2>
                        <p class="text-xs text-slate-500">
                            Informasi terpercaya yang membangun kredibilitas bagi calon wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Alamat Lengkap Kantor Operasional
                        </label>
                        <textarea
                            name="address"
                            rows="3"
                            required
                            placeholder="Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo, Jawa Tengah 56354"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm resize-none"
                        >{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                    <span>Nomor Legalitas NIB / Perizinan Usaha</span>
                                </label>
                                @unless ($isSuperadmin)
                                    <span class="text-[10px] font-bold text-amber-600 flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-md">
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
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Lencana Asosiasi / Sertifikasi Pemandu</span>
                            </label>
                            <input
                                type="text"
                                name="hpi_badge"
                                value="{{ old('hpi_badge', $settings->hpi_badge) }}"
                                placeholder="Contoh: Anggota Resmi HPI Dieng"
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                            />
                        </div>
                    </div>

                    <!-- Informasi Rekening Bank Perusahaan -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                                <i data-lucide="credit-card" class="w-4 h-4 text-[#0064D2]"></i>
                                <span>Rekening Resmi Pembayaran / Reservasi</span>
                            </h3>
                            @unless ($isSuperadmin)
                                <span class="text-[10px] font-bold text-amber-700 flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                    <i data-lucide="lock" class="w-3 h-3"></i> Terkunci (Superadmin Only)
                                </span>
                            @endunless
                        </div>

                        @unless ($isSuperadmin)
                            <div class="p-3 mb-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-4 h-4 shrink-0 text-amber-600"></i>
                                <span>Rekening pembayaran resmi dilindungi dan hanya dapat diperbarui oleh Super Administrator demi integritas transaksi.</span>
                            </div>
                        @endunless

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Nama Bank & Cabang</label>
                                <input
                                    type="text"
                                    name="bank_name"
                                    value="{{ old('bank_name', $settings->bank_name) }}"
                                    placeholder="BNI Cabang Wonosobo"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Nomor Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_number"
                                    value="{{ old('bank_account_number', $settings->bank_account_number) }}"
                                    placeholder="8166754042"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs font-mono @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_name"
                                    value="{{ old('bank_account_name', $settings->bank_account_name) }}"
                                    placeholder="PT. GOTRIP ASIA TRAVELINDO"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Tautan Media Sosial Resmi -->
                    <div class="pt-4 border-t border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-3 flex items-center gap-1.5">
                            <i data-lucide="share-2" class="w-4 h-4 text-sky-600"></i>
                            <span>Akun Media Sosial Resmi</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Instagram URL</label>
                                <input
                                    type="text"
                                    name="instagram_url"
                                    value="{{ old('instagram_url', $settings->instagram_url) }}"
                                    placeholder="https://www.instagram.com/..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">TikTok URL</label>
                                <input
                                    type="text"
                                    name="tiktok_url"
                                    value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                                    placeholder="https://tiktok.com/@..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Facebook URL</label>
                                <input
                                    type="text"
                                    name="facebook_url"
                                    value="{{ old('facebook_url', $settings->facebook_url) }}"
                                    placeholder="https://www.facebook.com/..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 5: Optimasi SEO & Social Media Share -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-extrabold text-base text-slate-900">5. Optimasi Mesin Pencari & Sosial Media (SEO)</h2>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-[#0064D2] border border-blue-200">
                                GOOGLE & MEDSOS
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">
                            Konfigurasi judul Google, deskripsi pencarian, dan gambar kartu berbagi WhatsApp
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- SEO Title -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Judul Penelusuran Google & Tab Browser (Meta Title)</span>
                            </label>
                            <span id="seoTitleCount" class="text-[11px] font-semibold text-slate-500">
                                {{ strlen($settings->seo_title ?? '') }}/60 karakter ideal
                            </span>
                        </div>
                        <input
                            type="text"
                            name="seo_title"
                            id="inputSeoTitle"
                            value="{{ old('seo_title', $settings->seo_title) }}"
                            placeholder="Otomatis mengikuti: {{ $settings->site_name }} — {{ $settings->site_tagline }}"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Judul utama pada tab peramban dan pencarian Google. <span class="text-[#0064D2] font-semibold">Kosongkan jika ingin selalu otomatis mengikuti Nama Situs & Slogan.</span>
                        </p>
                    </div>

                    <!-- SEO Description -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <span>Deskripsi Penelusuran Google (Meta Description)</span>
                            </label>
                            <span id="seoDescCount" class="text-[11px] font-semibold text-slate-500">
                                {{ strlen($settings->seo_description ?? '') }}/160 karakter ideal
                            </span>
                        </div>
                        <textarea
                            name="seo_description"
                            id="inputSeoDesc"
                            rows="3"
                            placeholder="Biro perjalanan wisata resmi Dataran Tinggi Dieng..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors resize-none leading-relaxed"
                        >{{ old('seo_description', $settings->seo_description) }}</textarea>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Rangkuman singkat yang memikat calon pelanggan di bawah tautan Google.
                        </p>
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Target Kata Kunci Penelusuran (Keywords)
                        </label>
                        <input
                            type="text"
                            name="seo_keywords"
                            value="{{ old('seo_keywords', $settings->seo_keywords) }}"
                            placeholder="paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Pisahkan setiap kata kunci menggunakan tanda koma (,).
                        </p>
                    </div>

                    <!-- OG Image Upload & Preview -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="share-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Gambar Banner Berbagi Medsos & WhatsApp (OG Image)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Rasio 1.91:1 (ideal 1200x630 px)
                            </span>
                        </label>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-24 sm:w-28 h-14 sm:h-16 rounded-xl bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center shrink-0 shadow-2xs">
                                    <img
                                        id="ogPreview"
                                        src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                        alt="Pratinjau Banner Medsos"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800">Banner Media Sosial Aktif</p>
                                    <p class="text-[11px] text-slate-500 truncate" id="ogText">
                                        {{ $settings->og_image_url ?: 'Banner standar aktif' }}
                                    </p>
                                </div>
                            </div>
                            <label class="w-full sm:w-auto relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 border border-blue-200 cursor-pointer transition-all shrink-0">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i>
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
                            class="w-full mt-3 p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs transition-colors"
                        />
                    </div>

                    <!-- LIVE VISUAL PREVIEW (SERP & WHATSAPP CARD) -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">
                            Pratinjau Tampilan Langsung (Live Visual Preview)
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- SERP Google Preview -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="search" class="w-3 h-3 text-[#0064D2]"></i>
                                    Pratinjau di Google Search
                                </span>
                                <div class="p-4 rounded-xl bg-white border border-slate-200 text-left shadow-2xs">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-4 h-4 rounded-full bg-blue-100 flex items-center justify-center text-[9px] text-[#0064D2] font-bold">
                                            G
                                        </div>
                                        <div class="text-[11px] text-slate-600 truncate">
                                            tiketdieng.com <span class="text-slate-400">› paket-wisata</span>
                                        </div>
                                    </div>
                                    <h4 id="previewGoogleTitle" class="text-sm font-semibold text-[#1a0dab] hover:underline line-clamp-1">
                                        {{ $settings->seo_title ?: $settings->site_name }}
                                    </h4>
                                    <p id="previewGoogleDesc" class="text-xs text-[#4d5156] mt-1 line-clamp-2 leading-relaxed">
                                        {{ $settings->seo_description ?: 'Biro perjalanan wisata resmi Dataran Tinggi Dieng dengan layanan VIP...' }}
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp Share Card Preview -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="share-2" class="w-3 h-3 text-emerald-600"></i>
                                    Pratinjau Kartu Berbagi WhatsApp
                                </span>
                                <div class="rounded-xl bg-white border border-slate-200 overflow-hidden text-left shadow-2xs">
                                    <div class="h-28 w-full bg-slate-100 overflow-hidden">
                                        <img
                                            id="previewWaImage"
                                            src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                            alt="Pratinjau WhatsApp"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div class="p-3 bg-slate-50/80 border-t border-slate-100">
                                        <h4 id="previewWaTitle" class="text-xs font-bold text-slate-900 line-clamp-1">
                                            {{ $settings->seo_title ?: $settings->site_name }}
                                        </h4>
                                        <p id="previewWaDesc" class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">
                                            {{ $settings->seo_description ?: $settings->site_tagline }}
                                        </p>
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1 block">
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
            <div class="p-5 sm:p-6 rounded-3xl bg-white/95 backdrop-blur-md border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-30 shadow-xl">
                <div class="text-xs text-slate-500 text-center sm:text-left">
                    Pastikan seluruh data telah sesuai sebelum menekan simpan. Perubahan langsung terbit seketika ke halaman publik.
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="flex-1 sm:flex-none px-7 py-3.5 rounded-xl text-xs font-extrabold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all duration-200 shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Seluruh Pengaturan</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- KARTU KHUSUS SUPERADMIN: MANAJEMEN AKUN PENGELOLA & ROLE (SPATIE) -->
        @if ($isSuperadmin && isset($users))
            <div id="section-users" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-extrabold text-base text-slate-900">Manajemen Tim Pengelola & Hak Akses (Spatie Role)</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-700">Superadmin Only</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Daftar akun staf terautentikasi dan pembagian hak akses sistem.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-xs text-slate-500 font-mono hidden sm:inline">Total: <strong class="text-slate-800">{{ $users->count() }} Akun</strong></span>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all shadow-sm shadow-blue-500/20 flex items-center gap-1.5">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            <span>Kelola Pengelola</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="uppercase tracking-wider text-[11px] text-slate-400 bg-slate-50/80 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="py-3 px-4">Pengelola</th>
                                <th class="py-3 px-4">Email Login</th>
                                <th class="py-3 px-4">Role Sistem</th>
                                <th class="py-3 px-4">Hak Akses & Batasan</th>
                                <th class="py-3 px-4 text-right">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $u)
                                @php
                                    $uIsSuper = $u->hasRole('superadmin');
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs {{ $uIsSuper ? 'bg-[#0064D2] text-white shadow-xs' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 flex items-center gap-2">
                                                    <span>{{ $u->name }}</span>
                                                    @if (Auth::id() === $u->id)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.2 rounded-full text-[10px] font-bold uppercase bg-blue-50 text-[#0064D2] border border-blue-200">
                                                            <span>Anda</span>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">ID #{{ $u->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-600">
                                        {{ $u->email }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                                <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                                                Superadmin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200">
                                                <i data-lucide="user" class="w-3 h-3 text-[#0064D2]"></i>
                                                Admin Staf
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="text-[11px] text-slate-700 font-medium">
                                                Full Control: Multi-Site Themes, NIB & Rekening Bank, Manajemen User & Database.
                                            </span>
                                        @else
                                            <span class="text-[11px] text-slate-500">
                                                Operasional: Kelola Paket Wisata, Titik Jemput, Pesanan & Konten Promosi.
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

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-[#0064D2] shrink-0"></i>
                        <span>Otorisasi role dikelola secara aman menggunakan <strong>Spatie Laravel-Permission</strong> pada tingkat middleware dan model.</span>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 hidden sm:inline">Role Table: roles & model_has_roles</span>
                </div>
            </div>
        @endif

        <!-- Form Reset Default Terpisah -->
        <div class="pt-4 border-t border-slate-200 flex justify-end">
            <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Pengaturan Situs', 'Seluruh konfigurasi kontak, nama perusahaan, dan legalitas akan dikembalikan ke data awal bawaan.') : confirm('Kembalikan ke pengaturan awal bawaan?');">
                @csrf
                <input type="hidden" name="site_key" value="{{ $selectedSite }}">
                <button
                    type="submit"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 transition-colors cursor-pointer"
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

    async function compressImageIfNeeded(file, maxDimension = 1920, quality = 0.85) {
        if (!file || !file.type.startsWith('image/') || file.type === 'image/svg+xml' || file.type === 'image/x-icon') {
            return file;
        }
        if (file.size < 1.5 * 1024 * 1024) {
            return file;
        }
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    let width = img.width;
                    let height = img.height;
                    if (width > maxDimension || height > maxDimension) {
                        if (width > height) {
                            height = Math.round((height * maxDimension) / width);
                            width = maxDimension;
                        } else {
                            width = Math.round((width * maxDimension) / height);
                            height = maxDimension;
                        }
                    }
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    const outputType = 'image/jpeg';
                    canvas.toBlob((blob) => {
                        if (blob && blob.size < file.size) {
                            const newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                            const newFile = new File([blob], newName, { type: outputType, lastModified: Date.now() });
                            resolve(newFile);
                        } else {
                            resolve(file);
                        }
                    }, outputType, quality);
                };
                img.onerror = () => resolve(file);
                img.src = e.target.result;
            };
            reader.onerror = () => resolve(file);
            reader.readAsDataURL(file);
        });
    }

    // 2. Favicon Upload Ajax Handler
    const fileFavicon = document.getElementById('fileFavicon');
    const faviconPreview = document.getElementById('faviconPreview');
    const inputFaviconUrl = document.getElementById('inputFaviconUrl');
    const faviconText = document.getElementById('faviconText');
    const faviconBtnText = document.getElementById('faviconBtnText');

    fileFavicon?.addEventListener('change', async (e) => {
        if (!e.target.files || !e.target.files[0]) return;
        let file = e.target.files[0];

        faviconBtnText.innerText = 'Mengunggah...';

        try {
            file = await compressImageIfNeeded(file, 512, 0.9);
            const formData = new FormData();
            formData.append('favicon', file);
            formData.append('site_key', '{{ $selectedSite }}');
            formData.append('_token', '{{ csrf_token() }}');

            const res = await fetch('{{ route('admin.upload.favicon') }}', {
                method: 'POST',
                body: formData,
            });

            if (!res.ok) {
                const errText = await res.text();
                let errMsg = 'Gagal mengunggah favicon (Status: ' + res.status + ')';
                try {
                    const parsed = JSON.parse(errText);
                    if (parsed.message) errMsg = parsed.message;
                    if (parsed.errors && parsed.errors.favicon) errMsg = parsed.errors.favicon[0];
                } catch(e) {}
                alert(errMsg);
                return;
            }

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
            alert('Terjadi kesalahan saat mengunggah berkas: ' + err.message);
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
        let file = e.target.files[0];

        ogBtnText.innerText = 'Mengoptimasi & Mengunggah...';

        try {
            file = await compressImageIfNeeded(file, 1920, 0.85);
            const formData = new FormData();
            formData.append('og_image', file);
            formData.append('site_key', '{{ $selectedSite }}');
            formData.append('_token', '{{ csrf_token() }}');

            const res = await fetch('{{ route('admin.upload.og') }}', {
                method: 'POST',
                body: formData,
            });

            if (!res.ok) {
                const errText = await res.text();
                let errMsg = 'Gagal mengunggah banner (Status: ' + res.status + ')';
                try {
                    const parsed = JSON.parse(errText);
                    if (parsed.message) errMsg = parsed.message;
                    if (parsed.errors && parsed.errors.og_image) errMsg = parsed.errors.og_image[0];
                } catch(e) {}
                alert(errMsg);
                return;
            }

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
            alert('Terjadi kesalahan saat mengunggah berkas: ' + err.message);
        } finally {
            ogBtnText.innerText = 'Unggah Banner Baru';
        }
    });
</script>
@endpush

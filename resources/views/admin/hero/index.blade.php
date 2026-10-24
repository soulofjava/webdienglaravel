@extends('layouts.app')

@php
    $defaultConfig = \App\Models\SiteSetting::getDefaultConfig($selectedSite);
    $previewUrl = match($selectedSite) {
        'lotus' => url('/?theme=lotus'),
        'jeep' => url('/?theme=jeep'),
        'shuttle' => url('/?theme=shuttle'),
        default => route('home'),
    };
    $siteName = $supportedSites[$selectedSite]['name'] ?? ucfirst($selectedSite);
@endphp

@section('title', 'Kelola Hero Section ' . $siteName . ' — Tiket Partner')

@section('content')
<div 
    class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans"
    x-data="{
        heroTitle: {{ json_encode($settings->hero_title ?: $defaultConfig['hero_title']) }},
        heroAccent: {{ json_encode($settings->hero_title_accent ?: $defaultConfig['hero_title_accent']) }},
        heroSubtitle: {{ json_encode($settings->hero_subtitle ?: $defaultConfig['hero_subtitle']) }},
        badgeText: {{ json_encode($settings->hero_badge_text ?: $defaultConfig['hero_badge_text']) }},
        feature1: {{ json_encode($settings->hero_feature_1 ?: $defaultConfig['hero_feature_1']) }},
        feature2: {{ json_encode($settings->hero_feature_2 ?: $defaultConfig['hero_feature_2']) }},
        feature3: {{ json_encode($settings->hero_feature_3 ?: $defaultConfig['hero_feature_3']) }},
        feature4: {{ json_encode($settings->hero_feature_4 ?: $defaultConfig['hero_feature_4']) }},
        companyName: {{ json_encode($settings->company_name ?: $defaultConfig['company_name']) }},
        hpiBadge: {{ json_encode($settings->hpi_badge ?: $defaultConfig['hpi_badge']) }},
        resetToDefault() {
            this.heroTitle = {{ json_encode($defaultConfig['hero_title']) }};
            this.heroAccent = {{ json_encode($defaultConfig['hero_title_accent']) }};
            this.heroSubtitle = {{ json_encode($defaultConfig['hero_subtitle']) }};
            this.badgeText = {{ json_encode($defaultConfig['hero_badge_text']) }};
            this.feature1 = {{ json_encode($defaultConfig['hero_feature_1']) }};
            this.feature2 = {{ json_encode($defaultConfig['hero_feature_2']) }};
            this.feature3 = {{ json_encode($defaultConfig['hero_feature_3']) }};
            this.feature4 = {{ json_encode($defaultConfig['hero_feature_4']) }};
        }
    }"
>
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Kustomisasi Teks Banner & Poin Keunggulan Hero Section" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Berhasil Disimpan!</p>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="font-bold">Terjadi Kesalahan Validasi</p>
                    <ul class="list-disc list-inside text-xs text-rose-700 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Header Halaman & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <span>Tiket Partner</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span>Hero Section</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">{{ $siteName }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Kustomisasi Hero Banner &mdash; <span class="text-[#0064D2]">{{ $siteName }}</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Edit teks headline, aksen warna, narasi, dan poin keunggulan khusus unit {{ $siteName }} tanpa mengubah unit lainnya.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a
                    href="{{ $previewUrl }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-xs transition-colors"
                >
                    <i data-lucide="external-link" class="w-4 h-4 text-slate-500"></i>
                    <span>Pratinjau {{ $siteName }}</span>
                </a>
            </div>
        </div>

        <!-- Multi-Unit Selector (Hanya Tampil Jika User Memiliki Hak Lebih Dari 1 Site / Superadmin) -->
        @if (count($supportedSites) > 1)
            <div class="bg-white p-2 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-1.5 overflow-x-auto">
                @foreach ($supportedSites as $key => $siteInfo)
                    <a
                        href="{{ route('admin.hero.index', ['site' => $key]) }}"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2 {{ $selectedSite === $key ? 'bg-[#0064D2] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                    >
                        <span>{{ $siteInfo['name'] }}</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ $selectedSite === $key ? 'bg-white/20 text-white' : 'bg-slate-200/80 text-slate-600' }}">
                            {{ $siteInfo['badge'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- ==================== ADAPTIVE LIVE PREVIEW BANNER ==================== -->
        @if ($selectedSite === 'lotus')
            <!-- PREVIEW: LOTUS CREATIVE (STUDIO EDITORIAL STYLE) -->
            <div class="rounded-3xl bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white p-6 sm:p-10 shadow-xl relative overflow-hidden border border-sky-500/30">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-sky-500/15 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-rose-500/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/20 text-[10px] sm:text-xs font-mono font-semibold text-sky-300 uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span class="text-rose-400 font-bold">● LIVE CAPTURE</span>
                        <span class="text-white/40">|</span>
                        <span x-text="badgeText || 'Official Studio PT. GoTrip Asia Travelindo'"></span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        <span x-text="heroTitle || 'Abadikan Momen'"></span> <br class="hidden sm:inline" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-300 to-rose-400 font-serif italic" x-text="heroAccent || 'Magis Dieng'"></span>
                        <span class="font-sans font-black"> Menjadi Karya Sinematik.</span>
                    </h2>

                    <p class="mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base text-slate-300 max-w-2xl font-normal leading-relaxed" x-text="heroSubtitle || 'Deskripsi studio Lotus Creative...'"></p>

                    <!-- Camera Meta Specs Strip Preview -->
                    <div class="mt-6 p-3 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-[11px] font-mono text-slate-300">
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-sky-400">P1:</span>
                            <span x-text="feature1 || 'Full-Frame Cameras'"></span>
                        </div>
                        <span class="text-white/30">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-rose-400">P2:</span>
                            <span x-text="feature2 || 'Cinematic 4K Drone'"></span>
                        </div>
                        <span class="text-white/30">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-emerald-400">P3:</span>
                            <span x-text="feature3 || 'Color Graded'"></span>
                        </div>
                        <span class="text-white/30">&bull;</span>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-amber-400">P4:</span>
                            <span x-text="feature4 || 'Direct Posing Guide'"></span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($selectedSite === 'jeep')
            <!-- PREVIEW: READY JEEP DIENG (RUGGED SPORTY ADVENTURE) -->
            <div class="rounded-3xl bg-gradient-to-r from-slate-950 via-red-950 to-slate-900 text-white p-6 sm:p-10 shadow-xl relative overflow-hidden border border-red-500/30">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-red-600/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-amber-500/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-900/50 border border-red-500/40 text-[10px] sm:text-xs font-bold text-red-200 uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span x-text="badgeText || 'UNIT RESMI 4X4 DAIHATSU FEROZA & SUZUKI KATANA'"></span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        <span x-text="heroTitle || 'Taklukkan Puncak Dieng Bersama'"></span> <br class="hidden sm:inline" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-red-400 to-amber-400 font-black" x-text="heroAccent || 'Ready Jeep Dieng'"></span>
                    </h2>

                    <p class="mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base text-slate-300 max-w-2xl font-normal leading-relaxed" x-text="heroSubtitle || 'Deskripsi petualangan Ready Jeep Dieng...'"></p>

                    <!-- Feature Badges Preview -->
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-xs font-medium text-slate-300 pt-4 border-t border-white/10 w-full">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-red-400"></i>
                            <span x-text="feature1 || 'Tiket Objek Masuk (Included)'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="users" class="w-4 h-4 text-red-400"></i>
                            <span x-text="feature2 || 'Kapasitas 4 Pax + 1 Driver'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="camera" class="w-4 h-4 text-red-400"></i>
                            <span x-text="feature3 || 'Free Foto HP oleh Driver'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-4 h-4 text-red-400"></i>
                            <span x-text="feature4 || 'Unit 4x4 Prima & Terawat'"></span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($selectedSite === 'shuttle')
            <!-- PREVIEW: SHUTTLE DIENG (CLEAN TRANSIT VIBE) -->
            <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 text-white p-6 sm:p-10 shadow-xl relative overflow-hidden border border-sky-400/30">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-sky-400/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sky-500/20 border border-sky-400/40 text-[10px] sm:text-xs font-bold text-sky-200 uppercase tracking-wider mb-4">
                        <i data-lucide="bus" class="w-3.5 h-3.5 text-sky-300"></i>
                        <span x-text="badgeText || 'Armada Mikrobus Ber-AC & Nyaman 15 Seat'"></span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        <span x-text="heroTitle || 'Transportasi Aman & Cepat Menuju'"></span> <br class="hidden sm:inline" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-teal-300 to-blue-400 font-black" x-text="heroAccent || 'Dataran Tinggi Dieng'"></span>
                    </h2>

                    <p class="mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base text-slate-300 max-w-2xl font-normal leading-relaxed" x-text="heroSubtitle || 'Deskripsi rute dan kenyamanan Shuttle Dieng...'"></p>

                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-xs font-medium text-slate-300 pt-4 border-t border-white/10 w-full">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="check-circle" class="w-4 h-4 text-sky-400"></i>
                            <span x-text="feature1 || 'Door to Door Service'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="wind" class="w-4 h-4 text-sky-400"></i>
                            <span x-text="feature2 || 'Armada Ber-AC Nyaman'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="user-check" class="w-4 h-4 text-sky-400"></i>
                            <span x-text="feature3 || 'Driver Berpengalaman'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-4 h-4 text-sky-400"></i>
                            <span x-text="feature4 || 'Jadwal Tepat Waktu'"></span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- PREVIEW: TIKETDIENG PORTAL INDUK (SIGNATURE VIBRANT BLUE & FAJAR EMAS) -->
            <div class="rounded-3xl bg-gradient-to-r from-[#0064D2] via-[#0052B4] to-[#00408F] text-white p-6 sm:p-10 shadow-xl relative overflow-hidden border border-blue-400/30">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-[#FEDD00]/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-sky-300/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center">
                    <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold shadow-xs">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                            <span x-text="companyName"></span>
                            <span class="text-[10px] text-blue-100 border-l border-white/25 pl-1.5 font-normal" x-text="badgeText"></span>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-semibold shadow-xs">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-300"></i>
                            <span x-text="hpiBadge"></span>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 border border-white/20 text-xs font-medium shadow-xs">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                            </span>
                            <i data-lucide="cloud-sun" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                            <span>Live Dieng: <strong>14°C</strong> • Cerah Dingin</span>
                        </div>
                    </div>

                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                        <span x-text="heroTitle || 'Eksplorasi Keajaiban Dieng'"></span>
                        <br class="hidden sm:inline" />
                        <span class="text-[#FEDD00]" x-text="heroAccent || 'Fajar Emas di Atas Awan'"></span>
                    </h2>

                    <p class="mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base text-blue-100 max-w-2xl font-normal leading-relaxed" x-text="heroSubtitle || 'Deskripsi singkat paket wisata Dieng...'"></p>

                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-xs font-medium text-blue-100 pt-4 border-t border-white/15 w-full">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="award" class="w-4 h-4 text-[#FEDD00]"></i>
                            <span x-text="feature1 || 'Biro Berizin Resmi'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="sun" class="w-4 h-4 text-[#FEDD00]"></i>
                            <span x-text="feature2 || 'Golden Sunrise Sikunir'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="car" class="w-4 h-4 text-[#FEDD00]"></i>
                            <span x-text="feature3 || 'Armada Antar-Jemput VIP'"></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-4 h-4 text-[#FEDD00]"></i>
                            <span x-text="feature4 || 'Jaminan Reschedule Aman'"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Editor Teks Hero -->
        <form action="{{ route('admin.hero.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="site_key" value="{{ $selectedSite }}">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kolom 1: Headline & Subtitle -->
                <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                            <i data-lucide="type" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Headline & Copywriting ({{ $siteName }})</h3>
                            <p class="text-xs text-slate-500">Teks utama yang pertama kali dilihat pengunjung saat mengakses web {{ $siteName }}.</p>
                        </div>
                    </div>

                    <!-- Judul Utama (Baris 1) -->
                    <div>
                        <label for="hero_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Judul Utama (Baris 1) <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="hero_title"
                            name="hero_title"
                            x-model="heroTitle"
                            required
                            placeholder="Contoh: {{ $defaultConfig['hero_title'] }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-semibold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>

                    <!-- Teks Aksen Warna (Baris 2) -->
                    <div>
                        <label for="hero_title_accent" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Teks Aksen Warna / Highlight (Baris 2)
                        </label>
                        <input
                            type="text"
                            id="hero_title_accent"
                            name="hero_title_accent"
                            x-model="heroAccent"
                            placeholder="Contoh: {{ $defaultConfig['hero_title_accent'] }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">
                            @if ($selectedSite === 'lotus')
                                Ditampilkan dengan efek gradien warna estetik sky-rose.
                            @elseif ($selectedSite === 'jeep')
                                Ditampilkan dengan highlight warna merah-oranye petualangan.
                            @elseif ($selectedSite === 'shuttle')
                                Ditampilkan dengan highlight warna sky-teal modern.
                            @else
                                Ditampilkan dengan highlight kuning keemasan (#FEDD00) ciri khas tiket.
                            @endif
                        </p>
                    </div>

                    <!-- Deskripsi / Subheading -->
                    <div>
                        <label for="hero_subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Subheading / Deskripsi Singkat
                        </label>
                        <textarea
                            id="hero_subtitle"
                            name="hero_subtitle"
                            rows="4"
                            x-model="heroSubtitle"
                            placeholder="Tuliskan narasi singkat mengenai layanan {{ $siteName }}..."
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none leading-relaxed transition-all"
                        ></textarea>
                    </div>

                    <!-- Keterangan Sub-Badge -->
                    <div>
                        <label for="hero_badge_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Sub-Label Badge / Keterangan Banner
                        </label>
                        <input
                            type="text"
                            id="hero_badge_text"
                            name="hero_badge_text"
                            x-model="badgeText"
                            placeholder="Contoh: {{ $defaultConfig['hero_badge_text'] }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                </div>

                <!-- Kolom 2: 4 Poin Keunggulan (Trust Features) -->
                <div class="bg-white p-5 sm:p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-5 flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-base">4 Poin Keunggulan Layanan</h3>
                                <p class="text-xs text-slate-500">Ikon dan teks ringkas di banner {{ $siteName }} untuk meyakinkan calon pelanggan.</p>
                            </div>
                        </div>

                        <!-- Fitur 1 -->
                        <div>
                            <label for="hero_feature_1" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Poin 1
                            </label>
                            <input
                                type="text"
                                id="hero_feature_1"
                                name="hero_feature_1"
                                x-model="feature1"
                                placeholder="Contoh: {{ $defaultConfig['hero_feature_1'] }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 2 -->
                        <div>
                            <label for="hero_feature_2" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Poin 2
                            </label>
                            <input
                                type="text"
                                id="hero_feature_2"
                                name="hero_feature_2"
                                x-model="feature2"
                                placeholder="Contoh: {{ $defaultConfig['hero_feature_2'] }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 3 -->
                        <div>
                            <label for="hero_feature_3" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Poin 3
                            </label>
                            <input
                                type="text"
                                id="hero_feature_3"
                                name="hero_feature_3"
                                x-model="feature3"
                                placeholder="Contoh: {{ $defaultConfig['hero_feature_3'] }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 4 -->
                        <div>
                            <label for="hero_feature_4" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Poin 4
                            </label>
                            <input
                                type="text"
                                id="hero_feature_4"
                                name="hero_feature_4"
                                x-model="feature4"
                                placeholder="Contoh: {{ $defaultConfig['hero_feature_4'] }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>
                    </div>

                    <!-- Tombol Reset Cepat ke Default Sesuai Site Aktif -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button
                            type="button"
                            @click="resetToDefault()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors"
                        >
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Isi Teks Default {{ $siteName }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Bar Aksi Simpan -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0"></i>
                    <span>Perubahan teks hero {{ $siteName }} akan langsung aktif di web publik setelah disimpan.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 cursor-pointer"
                    >
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan Hero ({{ $siteName }})</span>
                    </button>
                </div>
            </div>
        </form>
    </main>
</div>
@endsection

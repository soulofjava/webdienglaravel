@extends('layouts.app')

@section('title', 'Kelola Hero Section — Tiket Partner')

@section('content')
<div 
    class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans"
    x-data="{
        heroTitle: {{ json_encode($settings->hero_title ?: 'Eksplorasi Keajaiban Dieng') }},
        heroAccent: {{ json_encode($settings->hero_title_accent ?: 'Fajar Emas di Atas Awan') }},
        heroSubtitle: {{ json_encode($settings->hero_subtitle ?: 'Jelajahi samudra awan Sikunir, kawah vulkanik Sikidang, telaga warna berkilau, dan petualangan jip offroad dengan kenyamanan VIP dan pemandu lokal berlisensi.') }},
        badgeText: {{ json_encode($settings->hero_badge_text ?: 'Biro Perjalanan Resmi') }},
        feature1: {{ json_encode($settings->hero_feature_1 ?: 'Biro Berizin Resmi') }},
        feature2: {{ json_encode($settings->hero_feature_2 ?: 'Golden Sunrise Sikunir') }},
        feature3: {{ json_encode($settings->hero_feature_3 ?: 'Armada Antar-Jemput VIP') }},
        feature4: {{ json_encode($settings->hero_feature_4 ?: 'Jaminan Reschedule Aman') }},
        companyName: {{ json_encode($settings->company_name ?: 'PT. GOTRIP ASIA TRAVELINDO') }},
        hpiBadge: {{ json_encode($settings->hpi_badge ?: 'Biro Wisata Resmi Berizin HPI') }}
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
                    <p class="font-bold">Berhasil!</p>
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
                    <span class="text-[#0064D2] font-semibold">Hero Section</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Kustomisasi Hero Banner</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Edit teks headline, aksen fajar emas, narasi singkat, dan 4 poin keunggulan tanpa perlu membuka menu pengaturan panjang.</p>
            </div>

            <div class="flex items-center gap-2.5">
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-xs transition-colors"
                >
                    <i data-lucide="external-link" class="w-4 h-4 text-slate-500"></i>
                    <span>Pratinjau Web Asli</span>
                </a>
            </div>
        </div>

        <!-- Multi-Unit Selector (Bila Superadmin / Tersedia Pilihan Site) -->
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

        <!-- LIVE REALTIME PREVIEW BANNER -->
        <div class="rounded-3xl bg-gradient-to-r from-[#0064D2] via-[#0052B4] to-[#00408F] text-white p-6 sm:p-10 shadow-xl relative overflow-hidden border border-blue-400/30">
            <!-- Ambient Glow -->
            <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-[#FEDD00]/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-sky-300/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl mx-auto text-center flex flex-col items-center">
                <!-- Mini Badge Label Preview -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#FEDD00] mb-4">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    <span>Live Pratinjau Tampilan Beranda</span>
                </div>

                <!-- Badges Bar -->
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

                <!-- Headline & Accent Preview -->
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    <span x-text="heroTitle || 'Eksplorasi Keajaiban Dieng'"></span>
                    <br class="hidden sm:inline" />
                    <span class="text-[#FEDD00]" x-text="heroAccent || 'Fajar Emas di Atas Awan'"></span>
                </h2>

                <!-- Subtitle Preview -->
                <p class="mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base text-blue-100 max-w-2xl font-normal leading-relaxed" x-text="heroSubtitle || 'Deskripsi singkat mengenai keunggulan paket wisata Dieng...'"></p>

                <!-- Trust Features Preview -->
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
                            <h3 class="font-extrabold text-slate-900 text-base">Judul & Headline Hero</h3>
                            <p class="text-xs text-slate-500">Teks utama yang pertama kali dibaca calon wisatawan saat membuka web.</p>
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
                            placeholder="Contoh: Eksplorasi Keajaiban Dieng"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-semibold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Muncul sebagai baris pertama warna putih pada headline beranda.</p>
                    </div>

                    <!-- Teks Aksen Kuning Emas (Baris 2) -->
                    <div>
                        <label for="hero_title_accent" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Teks Aksen Emas (Baris 2)
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="hero_title_accent"
                                name="hero_title_accent"
                                x-model="heroAccent"
                                placeholder="Contoh: Fajar Emas di Atas Awan"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-amber-700 font-bold text-sm focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none transition-all"
                            />
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-[#FEDD00] border border-amber-400 shadow-xs"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Ditampilkan dengan highlight kuning keemasan (#FEDD00) ciri khas tiket.</p>
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
                            placeholder="Tuliskan narasi singkat mengenai keindahan dan kenyamanan paket Dieng..."
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none leading-relaxed transition-all"
                        ></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Disarankan 1-2 kalimat padat dan menarik untuk konversi pemesanan.</p>
                    </div>

                    <!-- Keterangan Sub-Badge Perusahaan -->
                    <div>
                        <label for="hero_badge_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Sub-Label Badge Perusahaan
                        </label>
                        <input
                            type="text"
                            id="hero_badge_text"
                            name="hero_badge_text"
                            x-model="badgeText"
                            placeholder="Contoh: Biro Perjalanan Resmi"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Teks pelengkap di samping nama PT pada pil atas hero banner.</p>
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
                                <h3 class="font-extrabold text-slate-900 text-base">4 Poin Keunggulan (Trust Badges)</h3>
                                <p class="text-xs text-slate-500">Ikon dan teks ringkas di bagian bawah hero banner untuk meyakinkan calon pelanggan.</p>
                            </div>
                        </div>

                        <!-- Fitur 1 (Award) -->
                        <div>
                            <label for="hero_feature_1" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                                <i data-lucide="award" class="w-4 h-4 text-amber-500"></i>
                                <span>Poin 1 (Lisensi / Badan Usaha)</span>
                            </label>
                            <input
                                type="text"
                                id="hero_feature_1"
                                name="hero_feature_1"
                                x-model="feature1"
                                placeholder="Contoh: Biro Berizin Resmi"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 2 (Sunrise / Spot) -->
                        <div>
                            <label for="hero_feature_2" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                                <i data-lucide="sun" class="w-4 h-4 text-amber-500"></i>
                                <span>Poin 2 (Destinasi Ikonik)</span>
                            </label>
                            <input
                                type="text"
                                id="hero_feature_2"
                                name="hero_feature_2"
                                x-model="feature2"
                                placeholder="Contoh: Golden Sunrise Sikunir"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 3 (Armada / Transport) -->
                        <div>
                            <label for="hero_feature_3" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                                <i data-lucide="car" class="w-4 h-4 text-amber-500"></i>
                                <span>Poin 3 (Fasilitas Armada)</span>
                            </label>
                            <input
                                type="text"
                                id="hero_feature_3"
                                name="hero_feature_3"
                                x-model="feature3"
                                placeholder="Contoh: Armada Antar-Jemput VIP"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>

                        <!-- Fitur 4 (Garansi / Fleksibilitas) -->
                        <div>
                            <label for="hero_feature_4" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-amber-500"></i>
                                <span>Poin 4 (Jaminan / Garansi)</span>
                            </label>
                            <input
                                type="text"
                                id="hero_feature_4"
                                name="hero_feature_4"
                                x-model="feature4"
                                placeholder="Contoh: Jaminan Reschedule Aman"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>
                    </div>

                    <!-- Tombol Reset ke Default Cepat -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button
                            type="button"
                            @click="
                                heroTitle = 'Eksplorasi Keajaiban Dieng';
                                heroAccent = 'Fajar Emas di Atas Awan';
                                heroSubtitle = 'Jelajahi samudra awan Sikunir, kawah vulkanik Sikidang, telaga warna berkilau, dan petualangan jip offroad dengan kenyamanan VIP dan pemandu lokal berlisensi.';
                                badgeText = 'Biro Perjalanan Resmi';
                                feature1 = 'Biro Berizin Resmi';
                                feature2 = 'Golden Sunrise Sikunir';
                                feature3 = 'Armada Antar-Jemput VIP';
                                feature4 = 'Jaminan Reschedule Aman';
                            "
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors"
                        >
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Isi Teks Default TiketDieng</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Bar Aksi Simpan -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0"></i>
                    <span>Perubahan teks hero akan langsung aktif seketika di halaman utama web setelah disimpan.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 cursor-pointer"
                    >
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan Hero</span>
                    </button>
                </div>
            </div>
        </form>
    </main>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Panel Pengelola -->
    <header class="border-b border-white/10 bg-[#090d16]/90 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-8 py-3.5">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                        <i data-lucide="compass" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="font-serif text-base sm:text-lg font-bold text-white tracking-wide">
                                Panel Pengelola {{ $settings->site_name }}
                            </h1>
                            <span class="hidden sm:inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                LARAVEL 13 + MYSQL
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 hidden sm:block">
                            Pengelolaan identitas biro wisata, kontak, legalitas usaha, dan optimasi SEO
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status Pengelola & Aksi -->
            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto justify-end">
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-slate-400 text-[11px]">Admin:</span>
                    <span class="font-semibold text-white">{{ Auth::user()->email }}</span>
                </div>

                <a
                    href="{{ route('admin.packages.index') }}"
                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-amber-300 hover:text-amber-200 bg-amber-500/15 hover:bg-amber-500/25 border border-amber-500/30 transition-colors"
                >
                    <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                    <span>Kelola Paket Wisata</span>
                </a>

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors"
                >
                    <span>Lihat Situs Web</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-red-300 hover:text-red-200 bg-red-500/10 hover:bg-red-500/20 border border-red-500/25 transition-colors cursor-pointer"
                        title="Keluar dari sesi pengelola"
                    >
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-8 py-8 space-y-8">
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

            <!-- Kartu 2: Kontak & Pemesanan -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5 text-emerald-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">2. Saluran Komunikasi & Reservasi</h2>
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

            <!-- Kartu 3: Alamat & Legalitas -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="map-pin" class="w-5 h-5 text-rose-400"></i>
                    <div>
                        <h2 class="font-bold text-base text-white">3. Alamat Kantor & Legalitas Usaha</h2>
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
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-amber-400"></i>
                                <span>Nomor Legalitas NIB / Perizinan Usaha</span>
                            </label>
                            <input
                                type="text"
                                name="legal_nib"
                                value="{{ old('legal_nib', $settings->legal_nib) }}"
                                placeholder="Contoh: NIB: 1294801928472"
                                class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors"
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
                </div>
            </div>

            <!-- Kartu 4: Optimasi SEO & Social Media Share -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-xl space-y-6">
                <div class="flex items-center gap-2.5 border-b border-white/10 pb-4">
                    <i data-lucide="search" class="w-5 h-5 text-sky-400"></i>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-base text-white">4. Optimasi Mesin Pencari & Sosial Media (SEO)</h2>
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
                                <span>Judul Penelusuran Google (Meta Title)</span>
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
                            placeholder="TiketDieng.com — Paket Wisata Dieng & Biro Perjalanan Resmi"
                            class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-sky-400 focus:outline-none transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Judul utama yang muncul sebagai tautan biru besar di hasil pencarian Google.
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

        <!-- Form Reset Default Terpisah -->
        <div class="pt-4 border-t border-white/10 flex justify-end">
            <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return confirm('Kembalikan seluruh pengaturan situs ke konfigurasi awal bawaan?');">
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

    function syncLivePreviews() {
        const title = inputSeoTitle.value.trim() || inputSiteName.value.trim() || 'TiketDieng.com — Paket Wisata Dieng Resmi';
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

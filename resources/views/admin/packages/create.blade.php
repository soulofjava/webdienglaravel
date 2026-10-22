@extends('layouts.app')

@section('title', 'Tambah Paket Wisata Baru — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Sticky Pengelola (Tiket Partner Top Bar) -->
    <header class="border-b border-slate-200/80 bg-white/95 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-8 py-3.5 shadow-xs">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-900 transition-colors shrink-0"
                    title="Kembali ke Daftar Paket"
                >
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-[#0064D2]">Tiket Partner</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs text-slate-500">Katalog Tour</span>
                    </div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 leading-tight">
                        Tambah Paket Wisata Baru
                    </h1>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5">
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    form="package-form"
                    class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 flex items-center gap-2 cursor-pointer"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Paket</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Konten Formulir -->
    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-8 py-6 sm:py-8 space-y-6">
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm shadow-xs">
                <div class="font-bold flex items-center gap-2 mb-2 text-rose-900">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    <span>Harap periksa kembali isian formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="package-form" action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. INFORMASI POKOK PAKET -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold text-xs">
                        1
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Informasi Pokok Paket</h2>
                        <p class="text-xs text-slate-500">Judul, kategori, durasi, titik penjemputan, dan ringkasan paket wisata.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Nama / Judul Paket Tour <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Paket Tour Dieng 1 Hari (One Day Tour Sikunir & Sikidang)"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all font-medium"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Slug URL Kustom (Opsional)
                        </label>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="Dikosongkan akan otomatis dibuat dari judul"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                        />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Kategori Tour <span class="text-rose-500">*</span>
                            </label>
                            <a href="{{ route('admin.comcodes.index', ['group' => 'package_category']) }}" target="_blank" class="text-[11px] font-semibold text-[#0064D2] hover:underline flex items-center gap-1">
                                <span>Master Kategori</span>
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                        </div>
                        <div class="relative">
                            <select
                                name="category"
                                required
                                class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer transition-all font-medium"
                            >
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->code_value }}" {{ old('category', 'Jeep Tour') == $cat->code_value ? 'selected' : '' }}>
                                        {{ $cat->code_name }} ({{ $cat->code_value }})
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Durasi Program <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[10px] text-slate-400">Pilih atau ketik kustom</span>
                        </div>
                        <input
                            list="duration_list"
                            type="text"
                            name="duration"
                            value="{{ old('duration', '1 Hari Penuh (03:00 - 17:00 WIB)') }}"
                            placeholder="Pilih dari daftar atau ketik durasi kustom"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all font-medium"
                        />
                        <datalist id="duration_list">
                            @foreach($durations as $dur)
                                <option value="{{ $dur->code_value }}">{{ $dur->code_name }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Titik Penjemputan <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[10px] text-slate-400">Pilih atau ketik kustom</span>
                        </div>
                        <input
                            list="pickup_list"
                            type="text"
                            name="pickup_location"
                            value="{{ old('pickup_location', 'Wonosobo (Basecamp / Hotel / Terminal Mendolo)') }}"
                            placeholder="Pilih dari daftar atau ketik titik penjemputan"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all font-medium"
                        />
                        <datalist id="pickup_list">
                            @foreach($pickupLocations as $loc)
                                <option value="{{ $loc->code_value }}">{{ $loc->code_name }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Badge Label (Opsional)
                            </label>
                            <a href="{{ route('admin.comcodes.index', ['group' => 'package_badge']) }}" target="_blank" class="text-[11px] font-semibold text-[#0064D2] hover:underline flex items-center gap-1">
                                <span>Master Badge</span>
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                            </a>
                        </div>
                        <div class="relative">
                            <select
                                name="badge"
                                class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer transition-all font-medium"
                            >
                                <option value="">-- Tanpa Badge Label --</option>
                                @foreach($badges as $b)
                                    <option value="{{ $b->code_value }}" {{ old('badge') == $b->code_value ? 'selected' : '' }}>
                                        {{ $b->code_name }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Urutan Tampil (Sort Order)
                        </label>
                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', 1) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Ringkasan / Sinopsis Singkat Paket <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="summary"
                        rows="3"
                        required
                        placeholder="Jelaskan gambaran umum perjalanan tour ini secara menarik untuk calon wisatawan..."
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all leading-relaxed"
                    >{{ old('summary') }}</textarea>
                </div>
            </div>

            <!-- 2. HARGA & SKEMA TARIF -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold text-xs">
                        2
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Harga & Skema Penawaran</h2>
                        <p class="text-xs text-slate-500">Nominal dasar tarif, catatan perorangan/rombongan, dan status visibilitas.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tarif Mulai Dari (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">Rp</span>
                            <input
                                type="number"
                                name="price"
                                value="{{ old('price', 350000) }}"
                                min="0"
                                step="1000"
                                required
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono font-bold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Catatan Skema Tarif & Ketentuan <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="price_note"
                            value="{{ old('price_note', '/ orang (Min. 4 Pax • Konfirmasi via WA)') }}"
                            placeholder="Contoh: / orang (Min. 4 Pax • Konfirmasi via WA)"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all font-medium"
                        />
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            class="w-5 h-5 rounded-lg border-slate-300 text-[#0064D2] focus:ring-[#0064D2] cursor-pointer"
                        />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Status Publikasi (Aktif)</span>
                            <span class="text-[11px] text-slate-500">Tampilkan paket di katalog publik website tiket</span>
                        </div>
                    </label>

                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_popular" value="0">
                        <input
                            type="checkbox"
                            name="is_popular"
                            value="1"
                            {{ old('is_popular') ? 'checked' : '' }}
                            class="w-5 h-5 rounded-lg border-slate-300 text-amber-500 focus:ring-amber-400 cursor-pointer"
                        />
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Paket Populer (Hot Promo)</span>
                            <span class="text-[11px] text-slate-500">Beri sorotan bintang & tampil di seksi favorit</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 3. FOTO COVER & MEDIA DROPZONE -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold text-xs">
                        3
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Media Cover & Foto Banner</h2>
                        <p class="text-xs text-slate-500">Foto utama beresolusi tinggi (rasio 16:9 disarankan, maks 5MB dengan kompresi otomatis).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                    <div class="space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Unggah Foto Dari Perangkat
                        </label>
                        <div class="border-2 border-dashed border-slate-300 hover:border-[#0064D2] rounded-2xl p-6 text-center bg-slate-50/50 hover:bg-blue-50/20 transition-all cursor-pointer relative group">
                            <input
                                type="file"
                                id="image_file_input"
                                name="image_file"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            />
                            <div class="space-y-2 pointer-events-none">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0064D2] flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                    <i data-lucide="cloud-upload" class="w-6 h-6"></i>
                                </div>
                                <div class="text-xs font-bold text-slate-800">
                                    Klik atau seret file gambar ke sini
                                </div>
                                <p class="text-[11px] text-slate-400">Mendukung JPG, PNG, WebP (Maks 5MB)</p>
                            </div>
                        </div>
                        <div id="fileInfoText" class="text-xs font-medium text-slate-600"></div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Atau Gunakan Tautan Gambar (URL)
                        </label>
                        <input
                            type="text"
                            id="image_url_input"
                            name="image_url"
                            value="{{ old('image_url', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') }}"
                            placeholder="https://images.unsplash.com/..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                        />

                        <!-- Live Preview Card -->
                        <div class="rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100 relative shadow-xs">
                            <img
                                id="cover_preview"
                                src="{{ old('image_url', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') }}"
                                alt="Pratinjau Cover"
                                class="w-full h-full object-cover"
                            />
                            <span class="absolute bottom-2 right-2 bg-slate-900/75 backdrop-blur-xs text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">
                                Live Preview
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. PILIHAN RUTE & ITINERARY DINAMIS -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold text-xs">
                            4
                        </div>
                        <div>
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Pilihan Rute & Destinasi Itinerary</h2>
                            <p class="text-xs text-slate-500">Dapat diisi beberapa opsi rute perjalanan yang dapat dipilih wisatawan.</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        id="btn-add-itinerary"
                        class="px-3.5 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 text-xs font-bold transition-colors flex items-center gap-1.5 self-start sm:self-auto cursor-pointer"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Tambah Opsi Rute</span>
                    </button>
                </div>

                <!-- Kontainer Kartu Rute -->
                <div id="itinerary-container" class="space-y-4">
                    <div class="itinerary-row p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3 relative">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-[#0064D2] font-mono tracking-wider rute-number">RUTE #1</span>
                            <button type="button" class="btn-remove-row text-slate-400 hover:text-rose-600 transition-colors text-xs flex items-center gap-1 cursor-pointer">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Opsi Rute</label>
                                <input
                                    type="text"
                                    name="itinerary_names[]"
                                    placeholder="Contoh: Rute 1 - Sikidang & Telaga Warna (Klasik)"
                                    class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Daftar Destinasi Singkat</label>
                                <input
                                    type="text"
                                    name="itinerary_destinations[]"
                                    placeholder="Contoh: Sunrise Sikunir, Kawah Sikidang, Candi Arjuna"
                                    class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none"
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Rangkaian Jadwal Jam & Catatan Kegiatan</label>
                            <textarea
                                name="itinerary_descriptions[]"
                                rows="2"
                                placeholder="03.00 Bertemu di meeting point -> 04.30 Golden Sunrise Sikunir -> 08.00 Kawah Sikidang -> 11.30 Istirahat & Makan -> 15.00 Kembali"
                                class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none leading-relaxed"
                            ></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. FASILITAS & CHECKLIST WISATA -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold text-xs">
                        5
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900">Fasilitas Termasuk & Perlengkapan</h2>
                        <p class="text-xs text-slate-500">Transparansi fasilitas included, excluded, dan saran perlengkapan untuk kenyamanan wisatawan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-emerald-700 mb-1 flex items-center gap-1.5">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                            <span>Fasilitas Termasuk (Include)</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu item per baris</p>
                        <textarea
                            name="inclusions_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none leading-relaxed"
                            placeholder="Transportasi AC Wonosobo - Dieng PP&#10;BBM & Driver Berpengalaman&#10;Tiket Masuk Semua Objek Wisata&#10;Makan 2x Sesuai Program&#10;Pemandu Wisata Lokal Ramah"
                        >{{ old('inclusions_text', "Transportasi AC Wonosobo - Dieng PP\nDriver & BBM\nTiket Masuk Seluruh Objek Wisata\nMakan 2x & Air Mineral\nPemandu Wisata Lokal Ramah\nDokumentasi Foto") }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-rose-700 mb-1 flex items-center gap-1.5">
                            <i data-lucide="x-circle" class="w-4 h-4 text-rose-600"></i>
                            <span>Tidak Termasuk (Exclude)</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu item per baris</p>
                        <textarea
                            name="exclusions_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 focus:outline-none leading-relaxed"
                            placeholder="Penjemputan di luar kota Wonosobo&#10;Pengeluaran pribadi & oleh-oleh&#10;Sewa perahu Telaga Menjer&#10;Tipping driver & guide seikhlasnya"
                        >{{ old('exclusions_text', "Antar jemput di luar titik Wonosobo\nPengeluaran pribadi & oleh-oleh\nSewa perahu Telaga Menjer\nTiket wahana berbayar opsional") }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-700 mb-1 flex items-center gap-1.5">
                            <i data-lucide="backpack" class="w-4 h-4 text-amber-600"></i>
                            <span>Checklist Persiapan Dieng</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu saran perlengkapan per baris</p>
                        <textarea
                            name="preparations_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none leading-relaxed"
                            placeholder="Jaket tebal / windbreaker (suhu Dieng bisa 5-10°C)&#10;Sepatu running / treking yang nyaman&#10;Sarung tangan & kupluk penghangat&#10;Obat-obatan pribadi & minyak kayu putih&#10;Powerbank & kamera"
                        >{{ old('preparations_text', "Jaket tebal / windproof (suhu 5-10°C)\nSepatu kets / treking yang nyaman\nKupluk & sarung tangan wol\nObat-obatan pribadi & tolak angin\nPowerbank & jas hujan lipat") }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 border border-slate-200 transition-colors shadow-xs"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 flex items-center gap-2 cursor-pointer"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Paket Wisata</span>
                </button>
            </div>
        </form>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('itinerary-container');
        const btnAdd = document.getElementById('btn-add-itinerary');

        function updateLabels() {
            const rows = container.querySelectorAll('.itinerary-row');
            rows.forEach((row, idx) => {
                const label = row.querySelector('.rute-number');
                if (label) label.textContent = `RUTE #${idx + 1}`;
            });
        }

        if (btnAdd) {
            btnAdd.addEventListener('click', function () {
                const rowCount = container.querySelectorAll('.itinerary-row').length + 1;
                const newRow = document.createElement('div');
                newRow.className = 'itinerary-row p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3 relative';
                newRow.innerHTML = `
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-[#0064D2] font-mono tracking-wider rute-number">RUTE #${rowCount}</span>
                        <button type="button" class="btn-remove-row text-slate-400 hover:text-rose-600 transition-colors text-xs flex items-center gap-1 cursor-pointer">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            <span>Hapus</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Opsi Rute</label>
                            <input
                                type="text"
                                name="itinerary_names[]"
                                placeholder="Contoh: Rute ${rowCount} - Destinasi Favorit"
                                class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none"
                            />
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Daftar Destinasi Singkat</label>
                            <input
                                type="text"
                                name="itinerary_destinations[]"
                                placeholder="Contoh: Sunrise Sikunir, Kawah Sikidang, Telaga Warna"
                                class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Rangkaian Jadwal Jam & Catatan Kegiatan</label>
                        <textarea
                            name="itinerary_descriptions[]"
                            rows="2"
                            placeholder="Rincian jam dan kegiatan..."
                            class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none leading-relaxed"
                        ></textarea>
                    </div>
                `;
                container.appendChild(newRow);
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        }

        if (container) {
            container.addEventListener('click', function (e) {
                const btnRemove = e.target.closest('.btn-remove-row');
                if (btnRemove) {
                    const rows = container.querySelectorAll('.itinerary-row');
                    if (rows.length > 1) {
                        btnRemove.closest('.itinerary-row').remove();
                        updateLabels();
                    } else {
                        alert('Minimal harus ada 1 opsi rute kunjungan.');
                    }
                }
            });
        }

        // Live Preview & Image Dropzone handling
        const urlInput = document.getElementById('image_url_input');
        const fileInput = document.getElementById('image_file_input');
        const preview = document.getElementById('cover_preview');
        const fileInfo = document.getElementById('fileInfoText');

        if (urlInput && preview) {
            urlInput.addEventListener('input', function () {
                if (this.value.trim().length > 5) {
                    preview.src = this.value.trim();
                }
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', async function () {
                if (!this.files || !this.files[0]) return;
                const file = this.files[0];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (preview) preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                // Kompresi otomatis berkas gambar besar sebelum dikirim
                if (file.size > 1.5 * 1024 * 1024 && file.type.startsWith('image/')) {
                    if (fileInfo) {
                        fileInfo.className = 'text-xs text-amber-600 font-medium block mt-1';
                        fileInfo.innerText = 'Mengoptimasi ukuran foto resolusi tinggi...';
                    }

                    const compressed = await new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = new Image();
                            img.onload = () => {
                                let width = img.width, height = img.height;
                                const maxDim = 1920;
                                if (width > maxDim || height > maxDim) {
                                    if (width > height) {
                                        height = Math.round((height * maxDim) / width);
                                        width = maxDim;
                                    } else {
                                        width = Math.round((width * maxDim) / height);
                                        height = maxDim;
                                    }
                                }
                                const canvas = document.createElement('canvas');
                                canvas.width = width;
                                canvas.height = height;
                                const ctx = canvas.getContext('2d');
                                ctx.drawImage(img, 0, 0, width, height);
                                canvas.toBlob((blob) => {
                                    if (blob && blob.size < file.size) {
                                        const newName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                                        resolve(new File([blob], newName, { type: 'image/jpeg', lastModified: Date.now() }));
                                    } else {
                                        resolve(file);
                                    }
                                }, 'image/jpeg', 0.85);
                            };
                            img.onerror = () => resolve(file);
                            img.src = e.target.result;
                        };
                        reader.onerror = () => resolve(file);
                        reader.readAsDataURL(file);
                    });

                    const dt = new DataTransfer();
                    dt.items.add(compressed);
                    this.files = dt.files;
                    if (fileInfo) {
                        fileInfo.className = 'text-xs text-emerald-600 font-medium block mt-1';
                        fileInfo.innerText = `✓ Foto dioptimasi (${(file.size / (1024*1024)).toFixed(1)}MB → ${(compressed.size / 1024).toFixed(0)}KB)`;
                    }
                } else if (fileInfo) {
                    fileInfo.className = 'text-xs text-emerald-600 font-medium block mt-1';
                    fileInfo.innerText = `✓ Berkas dipilih: ${file.name} (${(file.size / 1024).toFixed(0)}KB)`;
                }
            });
        }
    });
</script>
@endpush
@endsection

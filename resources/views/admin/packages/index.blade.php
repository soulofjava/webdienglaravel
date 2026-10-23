@extends('layouts.app')

@section('title', 'Kelola Paket Wisata — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Manajemen Katalog Paket Wisata, Itinerary & Tarif" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header Halaman & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <span>Tiket Partner</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Paket Wisata</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Katalog Paket Wisata</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur daftar produk tour, skema harga tiket, fasilitas, dan jadwal rute kunjungan Dieng.</p>
            </div>

            <a
                href="{{ route('admin.packages.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 shrink-0 cursor-pointer w-full sm:w-auto"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Paket Baru</span>
            </a>
        </div>

        <!-- Bar Atas: Pencarian, Filter & Status -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <form id="filterForm" action="{{ route('admin.packages.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full">
                <!-- Search Input with Debounce & Clear Button -->
                <div class="relative flex-1 min-w-0">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input
                        type="text"
                        id="packageSearchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama paket wisata, rute, atau destinasi..."
                        class="w-full pl-10 pr-9 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                    />
                    @if(request('search'))
                        <a
                            href="{{ route('admin.packages.index', request()->except('search')) }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-200 transition-colors"
                            title="Hapus pencarian"
                        >
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                <!-- Kontrol Filter Dropdown & Aksi Form -->
                <div class="flex items-center gap-2">
                    <!-- Dropdown Kategori -->
                    <div class="relative flex-1 sm:w-48 min-w-[140px]">
                        <select
                            name="category"
                            onchange="this.form.submit()"
                            class="w-full appearance-none py-2.5 pl-3.5 pr-8 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 text-xs sm:text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer transition-all"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 cursor-pointer shrink-0"
                        title="Terapkan filter"
                    >
                        <i data-lucide="filter" class="w-3.5 h-3.5 text-slate-500"></i>
                        <span class="hidden sm:inline">Terapkan</span>
                    </button>

                    @if(request('search') || request('category'))
                        <a
                            href="{{ route('admin.packages.index') }}"
                            class="px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors flex items-center justify-center gap-1 shrink-0"
                            title="Reset filter"
                        >
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- DESKTOP TABLE VIEW (Visible on >= md, hidden on mobile) -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5 min-w-[280px]">Paket & Media</th>
                            <th class="py-3.5 px-4 whitespace-nowrap">Kategori</th>
                            <th class="py-3.5 px-4 whitespace-nowrap">Durasi</th>
                            <th class="py-3.5 px-4 whitespace-nowrap">Tarif</th>
                            <th class="py-3.5 px-4 min-w-[200px]">Pilihan Rute</th>
                            <th class="py-3.5 px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-3.5 px-5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($packages as $pkg)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <!-- Paket & Gambar -->
                                <td class="py-4 px-5 align-top">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-16 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0 shadow-xs relative">
                                            <img
                                                src="{{ $pkg->image_url }}"
                                                alt="{{ $pkg->title }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                onerror="this.src='https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80'"
                                            />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                                                @if ($pkg->badge)
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-[#FEDD00] text-slate-900 border border-amber-300 shadow-xs">
                                                        {{ $pkg->badge }}
                                                    </span>
                                                @endif
                                                <span class="text-[10px] font-mono font-medium text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">#{{ $pkg->sort_order ?? 0 }}</span>
                                            </div>
                                            <a
                                                href="{{ route('admin.packages.edit', $pkg->id) }}"
                                                class="font-bold text-slate-900 hover:text-[#0064D2] transition-colors text-sm line-clamp-1 leading-snug"
                                                title="{{ $pkg->title }}"
                                            >
                                                {{ $pkg->title }}
                                            </a>
                                            <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5 leading-relaxed" title="{{ $pkg->summary }}">
                                                {{ $pkg->summary }}
                                            </p>
                                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400 mt-1">
                                                <i data-lucide="map-pin" class="w-3 h-3 text-[#0064D2] flex-shrink-0"></i>
                                                <span class="truncate" title="{{ $pkg->pickup_location }}">{{ $pkg->pickup_location }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-4 px-4 align-top">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-[#0064D2] border border-blue-100 whitespace-nowrap">
                                        {{ $pkg->category }}
                                    </span>
                                </td>

                                <!-- Durasi -->
                                <td class="py-4 px-4 text-slate-700 whitespace-nowrap align-top">
                                    <div class="flex items-center gap-1.5 text-xs font-medium">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ $pkg->duration }}</span>
                                    </div>
                                </td>

                                <!-- Tarif -->
                                <td class="py-4 px-4 whitespace-nowrap align-top">
                                    <div class="font-extrabold text-[#0064D2] text-sm">
                                        {{ $pkg->formatted_price }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-medium">
                                        {{ $pkg->price_note }}
                                    </div>
                                </td>

                                <!-- Pilihan Rute -->
                                <td class="py-4 px-4 align-top">
                                    @php
                                        $routes = $pkg->itinerary_options ?? [];
                                        $countRoutes = count($routes);
                                    @endphp
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5">
                                            @if ($countRoutes > 0)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-bold">
                                                    <i data-lucide="compass" class="w-3 h-3 text-indigo-500"></i>
                                                    <span>{{ $countRoutes }} Pilihan Rute</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[10px]">
                                                    <i data-lucide="minus" class="w-3 h-3 text-slate-400"></i>
                                                    <span>Rute Tunggal</span>
                                                </span>
                                            @endif
                                        </div>

                                        @if ($countRoutes > 0)
                                            <div class="space-y-0.5 mt-1 text-[11px] text-slate-600">
                                                @foreach(array_slice($routes, 0, 2) as $r)
                                                    <div class="truncate max-w-[210px] leading-tight" title="{{ $r['name'] ?? '' }}">
                                                        <span class="font-semibold text-slate-700">• {{ $r['name'] ?? 'Rute' }}</span>
                                                    </div>
                                                @endforeach
                                                @if ($countRoutes > 2)
                                                    <span class="text-[10px] text-indigo-600 font-medium pl-2 block">
                                                        +{{ $countRoutes - 2 }} rute lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status Aktif -->
                                <td class="py-4 px-4 text-center whitespace-nowrap align-top">
                                    @if ($pkg->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-5 text-right whitespace-nowrap align-top">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a
                                            href="{{ route('package.detail', $pkg->slug) }}"
                                            target="_blank"
                                            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 border border-slate-200/80 transition-colors"
                                            title="Pratinjau Halaman Publik"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <a
                                            href="{{ route('admin.packages.edit', $pkg->id) }}"
                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 transition-colors"
                                            title="Ubah Paket"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.packages.destroy', $pkg->id) }}"
                                            method="POST"
                                            onsubmit="return window.confirmDelete ? window.confirmDelete(event, '{{ addslashes($pkg->title) }}', 'Seluruh data jadwal itinerary dan foto paket ini akan dihapus permanen.') : confirm('Hapus paket?');"
                                            class="inline-block"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors cursor-pointer"
                                                title="Hapus Paket"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-500">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="package-search" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-800">Tidak ada paket wisata yang sesuai.</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau reset filter kategori.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi Desktop -->
            @if ($packages->hasPages())
                <div class="p-4 sm:px-6 border-t border-slate-200/80 bg-slate-50/50">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>

        <!-- MOBILE CARD VIEW (Strictly Mobile-First, Zero Horizontal Scroll on < md) -->
        <div class="block md:hidden space-y-3.5">
            @forelse ($packages as $pkg)
                @php
                    $routes = $pkg->itinerary_options ?? [];
                    $countRoutes = count($routes);
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all p-4 space-y-3">
                    <!-- Header Card: Thumbnail + Info Pokok -->
                    <div class="flex items-start gap-3">
                        <!-- Thumbnail dengan Fallback & Badge Urutan -->
                        <div class="relative w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0 shadow-2xs">
                            <img
                                src="{{ $pkg->image_url }}"
                                alt="{{ $pkg->title }}"
                                class="w-full h-full object-cover"
                                onerror="this.src='https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80'"
                            />
                            <span class="absolute bottom-1 left-1 px-1.5 py-0.5 rounded bg-slate-900/80 backdrop-blur-xs text-[9px] font-mono font-bold text-white leading-none">
                                #{{ $pkg->sort_order ?? 0 }}
                            </span>
                        </div>

                        <!-- Info Judul, Badges & Tarif -->
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                                @if ($pkg->badge)
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wide bg-[#FEDD00] text-slate-900 border border-amber-300 shadow-2xs">
                                        {{ $pkg->badge }}
                                    </span>
                                @endif
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-50 text-[#0064D2] border border-blue-100">
                                    {{ $pkg->category }}
                                </span>
                                @if ($pkg->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>

                            <a
                                href="{{ route('admin.packages.edit', $pkg->id) }}"
                                class="font-bold text-slate-900 hover:text-[#0064D2] transition-colors text-sm line-clamp-2 leading-snug block"
                                title="{{ $pkg->title }}"
                            >
                                {{ $pkg->title }}
                            </a>

                            <div class="mt-1 flex items-baseline gap-1.5 flex-wrap">
                                <span class="text-sm font-extrabold text-[#0064D2]">
                                    {{ $pkg->formatted_price }}
                                </span>
                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $pkg->price_note }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Spesifikasi Paket: Durasi, Titik Jemput, & Opsi Rute -->
                    <div class="pt-2.5 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                        <div class="flex items-center justify-between gap-2 text-[11px]">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span class="truncate font-medium">{{ $pkg->duration }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 min-w-0 text-slate-500">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#0064D2] shrink-0"></i>
                                <span class="truncate font-medium" title="{{ $pkg->pickup_location }}">{{ $pkg->pickup_location }}</span>
                            </div>
                        </div>

                        <!-- Pilihan Rute Itinerary -->
                        @if ($countRoutes > 0)
                            <div class="flex items-center gap-1.5 text-[11px] pt-0.5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-bold shrink-0">
                                    <i data-lucide="compass" class="w-3 h-3 text-indigo-500"></i>
                                    <span>{{ $countRoutes }} Rute</span>
                                </span>
                                <span class="truncate text-slate-500 text-[11px]">
                                    {{ collect($routes)->pluck('name')->implode(', ') }}
                                </span>
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-400">
                                <i data-lucide="minus" class="w-3 h-3 text-slate-300"></i>
                                <span>Rute Tunggal Standar</span>
                            </div>
                        @endif

                        @if ($pkg->summary)
                            <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed pt-1">
                                {{ $pkg->summary }}
                            </p>
                        @endif
                    </div>

                    <!-- Action Bar (Thumb-Friendly, min 38px target) -->
                    <div class="flex items-center justify-between gap-2 pt-2.5 border-t border-slate-100">
                        <a
                            href="{{ route('package.detail', $pkg->slug) }}"
                            target="_blank"
                            class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-colors min-h-[38px] cursor-pointer"
                            title="Pratinjau Halaman Publik"
                        >
                            <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-500"></i>
                            <span>Pratinjau</span>
                        </a>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('admin.packages.edit', $pkg->id) }}"
                                class="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] text-xs font-bold flex items-center gap-1.5 border border-blue-200 transition-colors min-h-[38px] cursor-pointer"
                                title="Ubah Paket"
                            >
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                <span>Ubah</span>
                            </a>

                            <form
                                action="{{ route('admin.packages.destroy', $pkg->id) }}"
                                method="POST"
                                onsubmit="return window.confirmDelete ? window.confirmDelete(event, '{{ addslashes($pkg->title) }}', 'Seluruh data jadwal itinerary dan foto paket ini akan dihapus permanen.') : confirm('Hapus paket?');"
                                class="inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors cursor-pointer min-h-[38px] min-w-[38px] flex items-center justify-center"
                                    title="Hapus Paket"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-500 space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <i data-lucide="package-search" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Tidak ada paket wisata yang sesuai.</p>
                    <p class="text-xs text-slate-400">Coba sesuaikan kata kunci pencarian atau reset filter.</p>
                    @if(request('search') || request('category'))
                        <div class="pt-2">
                            <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#0064D2] bg-blue-50 border border-blue-200 hover:bg-blue-100">
                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                <span>Reset Semua Filter</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse

            <!-- Paginasi Mobile -->
            @if ($packages->hasPages())
                <div class="pt-2">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('packageSearchInput');
        const filterForm = document.getElementById('filterForm');
        let debounceTimer = null;

        if (searchInput && filterForm) {
            const initialVal = searchInput.value.trim();
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    if (searchInput.value.trim() !== initialVal) {
                        filterForm.submit();
                    }
                }, 450);
            });

            if (searchInput.value.length > 0 && new URLSearchParams(window.location.search).has('search')) {
                searchInput.focus();
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }
        }
    });
</script>
@endpush
@endsection
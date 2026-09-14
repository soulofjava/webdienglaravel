@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Manajemen Data Paket Wisata, Itinerary & Tarif" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Bar Atas: Pencarian, Filter & Tombol Tambah -->
        <div class="glass-panel p-5 rounded-3xl border border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.packages.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama paket atau rute..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                    />
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>

                <select
                    name="category"
                    onchange="this.form.submit()"
                    class="py-2.5 px-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none cursor-pointer"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-xs font-semibold text-white transition-colors">
                    Filter
                </button>

                @if(request('search') || request('category'))
                    <a href="{{ route('admin.packages.index') }}" class="text-xs text-amber-400 hover:underline">
                        Reset Filter
                    </a>
                @endif
            </form>

            <a
                href="{{ route('admin.packages.create') }}"
                class="w-full md:w-auto px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Paket Baru</span>
            </a>
        </div>

        <!-- Tabel Daftar Paket Wisata -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-white/5 border-b border-white/10 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="py-4 px-5 min-w-[300px]">Paket & Gambar</th>
                            <th class="py-4 px-4 whitespace-nowrap">Kategori</th>
                            <th class="py-4 px-4 whitespace-nowrap">Durasi</th>
                            <th class="py-4 px-4 whitespace-nowrap">Tarif</th>
                            <th class="py-4 px-4 min-w-[220px]">Opsi Rute & Destinasi</th>
                            <th class="py-4 px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-4 px-5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($packages as $pkg)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 px-5 align-top">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-16 h-14 rounded-xl overflow-hidden bg-black/40 border border-white/10 flex-shrink-0 shadow-md">
                                            <img
                                                src="{{ $pkg->image_url }}"
                                                alt="{{ $pkg->title }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.src='https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80'"
                                            />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                @if ($pkg->badge)
                                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                                        {{ $pkg->badge }}
                                                    </span>
                                                @endif
                                                <span class="text-[10px] font-mono text-slate-500">#{{ $pkg->sort_order ?? 0 }}</span>
                                            </div>
                                            <a
                                                href="{{ route('admin.packages.edit', $pkg->id) }}"
                                                class="font-bold text-white hover:text-amber-400 transition-colors text-sm line-clamp-2 leading-snug"
                                                title="{{ $pkg->title }}"
                                            >
                                                {{ $pkg->title }}
                                            </a>
                                            <p class="text-[11px] text-slate-400 line-clamp-1 mt-1 leading-relaxed" title="{{ $pkg->summary }}">
                                                {{ $pkg->summary }}
                                            </p>
                                            <div class="flex items-center gap-1.5 text-[10px] text-slate-500 mt-1">
                                                <i data-lucide="map-pin" class="w-3 h-3 text-amber-500/70 flex-shrink-0"></i>
                                                <span class="truncate" title="{{ $pkg->pickup_location }}">{{ $pkg->pickup_location }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 align-top">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white/5 border border-white/10 text-slate-300 whitespace-nowrap">
                                        {{ $pkg->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-slate-300 whitespace-nowrap align-top">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-sky-400"></i>
                                        <span>{{ $pkg->duration }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap align-top">
                                    <div class="font-mono font-bold text-amber-400 text-sm">
                                        {{ $pkg->formatted_price }}
                                    </div>
                                    <div class="text-[10px] text-slate-500">
                                        {{ $pkg->price_note }}
                                    </div>
                                </td>
                                <td class="py-4 px-4 align-top">
                                    @php
                                        $routes = $pkg->itinerary_options ?? [];
                                        $countRoutes = count($routes);
                                    @endphp
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-1.5">
                                            @if ($countRoutes > 0)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-purple-500/15 text-purple-300 border border-purple-500/30 text-[10px] font-bold">
                                                    <i data-lucide="compass" class="w-3 h-3 text-purple-400"></i>
                                                    <span>{{ $countRoutes }} Pilihan Rute</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-500/15 text-slate-400 border border-white/10 text-[10px]">
                                                    <i data-lucide="minus" class="w-3 h-3 text-slate-500"></i>
                                                    <span>Rute Tunggal</span>
                                                </span>
                                            @endif
                                        </div>

                                        @if ($countRoutes > 0)
                                            <div class="space-y-1 mt-1">
                                                @foreach(array_slice($routes, 0, 2) as $r)
                                                    <div class="text-[11px] text-slate-300 leading-tight">
                                                        <div class="font-medium text-slate-200 truncate max-w-[200px]" title="{{ $r['name'] ?? '' }}">
                                                            • {{ $r['name'] ?? 'Rute' }}
                                                        </div>
                                                        @if(!empty($r['destinations']))
                                                            <div class="text-[10px] text-slate-400 truncate max-w-[200px] pl-2" title="{{ $r['destinations'] }}">
                                                                {{ $r['destinations'] }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if ($countRoutes > 2)
                                                    <span class="text-[10px] text-purple-300/80 font-mono italic pl-2 block">
                                                        +{{ $countRoutes - 2 }} rute lainnya
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap align-top">
                                    @if ($pkg->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-500/20 text-slate-400 border border-slate-500/30">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right whitespace-nowrap align-top">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('package.detail', $pkg->slug) }}"
                                            target="_blank"
                                            class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white border border-white/10 transition-colors"
                                            title="Pratinjau Halaman Publik"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <a
                                            href="{{ route('admin.packages.edit', $pkg->id) }}"
                                            class="p-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 transition-colors"
                                            title="Ubah Paket"
                                        >
                                            <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.packages.destroy', $pkg->id) }}"
                                            method="POST"
                                            onsubmit="return window.confirmDelete ? window.confirmDelete(event, '{{ addslashes($pkg->title) }}', 'Seluruh data jadwal itinerary dan foto paket ini akan dihapus.') : confirm('Hapus paket?');"
                                            class="inline-block"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-300 border border-red-500/30 transition-colors cursor-pointer"
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
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <i data-lucide="package-x" class="w-8 h-8 mx-auto text-slate-500 mb-2"></i>
                                    <p class="text-sm font-semibold">Belum ada data paket wisata yang sesuai.</p>
                                    <p class="text-xs text-slate-500 mt-1">Silakan tambahkan paket baru atau atur ulang kata kunci filter pencarian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginasi Kustom -->
            @if ($packages->hasPages())
                <div class="p-4 sm:px-6 border-t border-white/10 bg-white/[0.01]">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
@endsection

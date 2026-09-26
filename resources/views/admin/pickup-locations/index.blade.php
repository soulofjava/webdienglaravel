@extends('layouts.app')

@section('title', 'Kelola Titik Penjemputan (Meeting Point)')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Master Lokasi Penjemputan & Surcharge Biaya Antar-Jemput" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Bar Atas: Pencarian & Tombol Tambah -->
        <div class="glass-panel p-5 rounded-3xl border border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.pickup-locations.index') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-80">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kota, stasiun, terminal..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                    />
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                </div>

                <button type="submit" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-xs font-semibold text-white transition-colors">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.pickup-locations.index') }}" class="text-xs text-amber-400 hover:underline">
                        Reset
                    </a>
                @endif
            </form>

            <a
                href="{{ route('admin.pickup-locations.create') }}"
                class="w-full md:w-auto px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer"
            >
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Titik Jemput</span>
            </a>
        </div>

        <!-- Tabel Daftar Titik Jemput -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-slate-300">
                    <thead class="bg-white/[0.03] border-b border-white/10 text-slate-400 font-bold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="py-4 px-4 sm:px-6">Urutan</th>
                            <th class="py-4 px-4 sm:px-6">Nama Titik Jemput</th>
                            <th class="py-4 px-4 sm:px-6">Keterangan / Landmark</th>
                            <th class="py-4 px-4 sm:px-6">Biaya Tambahan (Surcharge)</th>
                            <th class="py-4 px-4 sm:px-6 text-center">Status</th>
                            <th class="py-4 px-4 sm:px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($locations as $loc)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 px-4 sm:px-6 font-mono text-amber-400 font-bold">
                                    #{{ $loc->sort_order }}
                                </td>
                                <td class="py-4 px-4 sm:px-6 font-semibold text-white">
                                    {{ $loc->name }}
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-slate-400 text-xs max-w-xs">
                                    {{ $loc->detail ?? '-' }}
                                </td>
                                <td class="py-4 px-4 sm:px-6 font-mono font-bold">
                                    @if ($loc->surcharge == 0)
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                            BEBAS BIAYA (GRATIS)
                                        </span>
                                    @else
                                        <span class="text-amber-400">
                                            +Rp {{ number_format($loc->surcharge, 0, ',', '.') }}/org
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-center">
                                    <form action="{{ route('admin.pickup-locations.toggle', $loc) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase transition-colors cursor-pointer {{ $loc->is_active ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/25' : 'bg-rose-500/15 text-rose-400 border border-rose-500/30 hover:bg-rose-500/25' }}"
                                            title="Klik untuk ubah status"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $loc->is_active ? 'bg-emerald-400' : 'bg-rose-400' }}"></span>
                                            <span>{{ $loc->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.pickup-locations.edit', $loc) }}"
                                            class="p-2 rounded-xl bg-white/5 hover:bg-amber-500/20 text-slate-300 hover:text-amber-300 border border-white/10 hover:border-amber-500/30 transition-all"
                                            title="Edit Titik Jemput"
                                        >
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.pickup-locations.destroy', $loc) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus titik penjemputan {{ $loc->name }}?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 rounded-xl bg-white/5 hover:bg-rose-500/20 text-slate-300 hover:text-rose-300 border border-white/10 hover:border-rose-500/30 transition-all cursor-pointer"
                                                title="Hapus"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500">
                                    <i data-lucide="map-pin-off" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                    <p>Belum ada titik penjemputan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($locations->hasPages())
                <div class="p-4 border-t border-white/10 bg-white/[0.01]">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
@endsection

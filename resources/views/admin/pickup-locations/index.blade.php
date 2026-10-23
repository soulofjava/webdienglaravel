@extends('layouts.app')

@section('title', 'Kelola Titik Penjemputan — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Master Lokasi Penjemputan & Surcharge Biaya Antar-Jemput" />

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
                    <span class="text-[#0064D2] font-semibold">Titik Jemput</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Titik Penjemputan (Meeting Point)</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola daftar lokasi penjemputan wisatawan dan skema penyesuaian tarif transportasi luar kota.</p>
            </div>

            <a
                href="{{ route('admin.pickup-locations.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 shrink-0 cursor-pointer"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Titik Jemput</span>
            </a>
        </div>

        <!-- Bar Atas: Pencarian & Filter -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <form id="pickupSearchForm" action="{{ route('admin.pickup-locations.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto flex-1 max-w-lg">
                <div class="relative flex-1 min-w-[240px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input
                        type="text"
                        id="pickupSearchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kota, stasiun, bandara, atau landmark..."
                        class="w-full pl-10 pr-9 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                    />
                    @if(request('search'))
                        <a
                            href="{{ route('admin.pickup-locations.index') }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 rounded-full hover:bg-slate-200 transition-colors"
                            title="Hapus pencarian"
                        >
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Cari</span>
                </button>

                @if(request('search'))
                    <a
                        href="{{ route('admin.pickup-locations.index') }}"
                        class="px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors flex items-center gap-1"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- DESKTOP TABLE VIEW -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                            <th class="py-3.5 px-5 min-w-[220px]">Nama Titik Penjemputan</th>
                            <th class="py-3.5 px-5 min-w-[240px]">Keterangan / Landmark</th>
                            <th class="py-3.5 px-5 whitespace-nowrap">Biaya Tambahan (Surcharge)</th>
                            <th class="py-3.5 px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-3.5 px-5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($locations as $loc)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="py-4 px-4 text-center font-mono font-bold text-slate-400">
                                    #{{ $loc->sort_order }}
                                </td>

                                <td class="py-4 px-5 align-top">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <span>{{ $loc->name }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-5 text-slate-500 text-xs leading-relaxed align-top">
                                    {{ $loc->detail ?? '—' }}
                                </td>

                                <td class="py-4 px-5 whitespace-nowrap align-top">
                                    @if ($loc->surcharge == 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                            <span>BEBAS BIAYA (GRATIS)</span>
                                        </span>
                                    @else
                                        <div class="font-extrabold text-[#0064D2] text-sm">
                                            +Rp {{ number_format($loc->surcharge, 0, ',', '.') }}
                                            <span class="text-[10px] font-normal text-slate-400">/ orang</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-center whitespace-nowrap align-top">
                                    <form action="{{ route('admin.pickup-locations.toggle', $loc) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase transition-colors cursor-pointer {{ $loc->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk ubah status aktif"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $loc->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                            <span>{{ $loc->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                        </button>
                                    </form>
                                </td>

                                <td class="py-4 px-5 text-right whitespace-nowrap align-top">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a
                                            href="{{ route('admin.pickup-locations.edit', $loc) }}"
                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 transition-colors"
                                            title="Edit Titik Jemput"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.pickup-locations.destroy', $loc) }}"
                                            method="POST"
                                            onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Titik Jemput {{ addslashes($loc->name) }}', 'Data lokasi ini akan dihapus dari pilihan kalkulator.') : confirm('Hapus titik penjemputan {{ addslashes($loc->name) }}?');"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors cursor-pointer"
                                                title="Hapus Titik Jemput"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="map-pin-off" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-800">Belum ada titik penjemputan.</p>
                                    <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah Titik Jemput" untuk mendaftarkan meeting point baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Desktop -->
            @if ($locations->hasPages())
                <div class="p-4 sm:px-6 border-t border-slate-200/80 bg-slate-50/50">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>

        <!-- MOBILE CARD VIEW -->
        <div class="block md:hidden space-y-3">
            @forelse ($locations as $loc)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400 font-semibold block">#{{ $loc->sort_order }}</span>
                                <h3 class="font-bold text-slate-900 text-sm leading-snug">
                                    {{ $loc->name }}
                                </h3>
                            </div>
                        </div>

                        <form action="{{ route('admin.pickup-locations.toggle', $loc) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase transition-colors {{ $loc->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}"
                            >
                                <span class="w-1.5 h-1.5 rounded-full {{ $loc->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                <span>{{ $loc->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </button>
                        </form>
                    </div>

                    @if($loc->detail)
                        <p class="text-xs text-slate-500 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            {{ $loc->detail }}
                        </p>
                    @endif

                    <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
                        <div>
                            @if ($loc->surcharge == 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    GRATIS
                                </span>
                            @else
                                <div class="text-xs font-extrabold text-[#0064D2]">
                                    +Rp {{ number_format($loc->surcharge, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">/org</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-1.5">
                            <a
                                href="{{ route('admin.pickup-locations.edit', $loc) }}"
                                class="px-3.5 py-1.5 rounded-xl bg-blue-50 text-[#0064D2] text-xs font-bold border border-blue-200 hover:bg-blue-100 flex items-center gap-1.5"
                            >
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                <span>Ubah</span>
                            </a>

                            <form
                                action="{{ route('admin.pickup-locations.destroy', $loc) }}"
                                method="POST"
                                onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Titik Jemput {{ addslashes($loc->name) }}', 'Data meeting point ini akan dihapus.') : confirm('Hapus titik penjemputan?');"
                                class="inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 transition-colors cursor-pointer"
                                    title="Hapus"
                                >
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-500">
                    <p class="text-sm font-bold text-slate-800">Belum ada titik penjemputan.</p>
                </div>
            @endforelse

            @if ($locations->hasPages())
                <div class="pt-2">
                    {{ $locations->links() }}
                </div>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('pickupSearchInput');
        const filterForm = document.getElementById('pickupSearchForm');
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
        }
    });
</script>
@endpush
@endsection

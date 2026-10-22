@extends('layouts.app')

@section('title', 'Tambah Titik Penjemputan — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <x-admin-nav :settings="$settings" subtitle="Tambah Lokasi Penjemputan Baru untuk Kalkulator" />

    <main class="flex-1 max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Header & Breadcrumb -->
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('admin.pickup-locations.index') }}" class="hover:text-[#0064D2] transition-colors">Titik Jemput</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Tambah Baru</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Titik Penjemputan Baru</h1>
            </div>

            <a
                href="{{ route('admin.pickup-locations.index') }}"
                class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition-colors shadow-xs"
            >
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm shadow-xs">
                <div class="font-bold flex items-center gap-2 mb-2 text-rose-900">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    <span>Terdapat kesalahan isian:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pickup-locations.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
            @csrf

            <!-- Nama Titik Jemput -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Nama Titik Penjemputan <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Yogyakarta — Stasiun Tugu / Bandara YIA"
                    required
                    class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 font-medium transition-all"
                />
            </div>

            <!-- Detail / Landmark -->
            <div>
                <label for="detail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Detail Cakupan Lokasi / Landmark (Opsional)
                </label>
                <input
                    type="text"
                    id="detail"
                    name="detail"
                    value="{{ old('detail') }}"
                    placeholder="Contoh: Stasiun Tugu / Lempuyangan / Bandara Internasional YIA / Hotel Jogja"
                    class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Surcharge Biaya Tambahan -->
                <div>
                    <label for="surcharge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Biaya Tambahan Antar-Jemput (Rp / Orang) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">Rp</span>
                        <input
                            type="number"
                            id="surcharge"
                            name="surcharge"
                            value="{{ old('surcharge', 0) }}"
                            min="0"
                            step="5000"
                            required
                            class="w-full p-3.5 pl-10 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono font-bold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1.5">Isi 0 jika bebas biaya / gratis (contoh area Wonosobo & Dieng).</p>
                </div>

                <!-- Urutan Tampil -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Urutan Tampil (Sort Order) <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $nextSortOrder) }}"
                        min="0"
                        required
                        class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                    />
                    <p class="text-[11px] text-slate-500 mt-1.5">Urutan terkecil akan tampil paling atas pada dropdown kalkulator.</p>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 rounded-lg border-slate-300 text-[#0064D2] focus:ring-[#0064D2] cursor-pointer"
                    >
                    <div>
                        <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Aktifkan di Kalkulator Web & Mobile</span>
                        <span class="text-[11px] text-slate-500">Wisatawan dapat memilih lokasi ini saat melakukan kalkulasi paket</span>
                    </div>
                </label>
            </div>

            <!-- Tombol Submit -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a
                    href="{{ route('admin.pickup-locations.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-slate-700 transition-colors"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer flex items-center gap-2"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Titik Jemput</span>
                </button>
            </div>
        </form>
    </main>
</div>
@endsection

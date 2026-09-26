@extends('layouts.app')

@section('title', 'Tambah Titik Penjemputan')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <x-admin-nav :settings="$settings" subtitle="Tambah Lokasi Penjemputan Baru untuk Kalkulator" />

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-bold font-serif text-white">Tambah Titik Penjemputan Baru</h1>
            <a href="{{ route('admin.pickup-locations.index') }}" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-semibold text-slate-300 transition-colors">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs sm:text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pickup-locations.store') }}" method="POST" class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 space-y-6">
            @csrf

            <!-- Nama Titik Jemput -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Nama Titik Penjemputan <span class="text-rose-400">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Yogyakarta — Stasiun Tugu / Bandara YIA"
                    required
                    class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                />
            </div>

            <!-- Detail / Landmark -->
            <div>
                <label for="detail" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Detail Cakupan Lokasi / Landmark (Opsional)</label>
                <input
                    type="text"
                    id="detail"
                    name="detail"
                    value="{{ old('detail') }}"
                    placeholder="Contoh: Stasiun Tugu / Lempuyangan / Bandara Internasional YIA / Hotel Jogja"
                    class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Surcharge Biaya Tambahan -->
                <div>
                    <label for="surcharge" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Biaya Tambahan Antar-Jemput (Rp / Orang) <span class="text-rose-400">*</span></label>
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
                            class="w-full p-3.5 pl-10 rounded-xl bg-white/5 border border-white/10 text-white text-sm font-mono focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">Isi 0 jika bebas biaya / gratis (contoh area Wonosobo & Dieng).</p>
                </div>

                <!-- Urutan Tampil -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Urutan Tampil (Sort Order) <span class="text-rose-400">*</span></label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $nextSortOrder) }}"
                        min="0"
                        required
                        class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm font-mono focus:border-amber-400 focus:outline-none"
                    />
                    <p class="text-[11px] text-slate-400 mt-1.5">Urutan terkecil akan tampil paling atas pada dropdown kalkulator.</p>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded bg-white/10 border-white/20 text-amber-500 focus:ring-0 cursor-pointer">
                    <span class="text-xs font-bold text-white uppercase tracking-wider">Aktifkan di Kalkulator Web & Mobile</span>
                </label>
            </div>

            <!-- Tombol Submit -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.pickup-locations.index') }}" class="px-5 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-semibold text-slate-300 transition-colors">
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-lg shadow-amber-500/25 cursor-pointer"
                >
                    Simpan Titik Jemput
                </button>
            </div>
        </form>
    </main>
</div>
@endsection

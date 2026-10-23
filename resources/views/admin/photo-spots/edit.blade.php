@extends('layouts.app')

@section('title', 'Edit Spot Foto Favorit Lotus — Tiket Partner')

@section('content')
<main class="min-h-screen bg-[#F4F7FB] text-slate-800 pb-16 font-sans">
    <x-admin-nav :settings="$settings" subtitle="Perbarui Data Spot Foto Terindah (Lotus Creative)" />

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-6">

        <!-- Breadcrumb & Title -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('admin.index') }}" class="hover:text-[#0064D2] transition-colors">Extranet</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <a href="{{ route('admin.photo-spots.index') }}" class="hover:text-[#0064D2] transition-colors">Spot Foto Lotus</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Edit #{{ $photoSpot->id }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Edit Spot Foto: {{ $photoSpot->name }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('admin.photo-spots.index') }}"
                    class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 transition-colors flex items-center gap-1.5"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
                <div class="flex items-center gap-2 text-sm font-bold text-rose-900 mb-1">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat beberapa kesalahan pengisian:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.photo-spots.update', $photoSpot->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs space-y-6">

                <!-- 0. Brand Scope (Hanya ditampilkan untuk Superadmin) -->
                @if(Auth::user()->isSuperAdmin())
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Brand / Kategori Tampil <span class="text-rose-500">*</span>
                        </label>
                        <select
                            name="site_scope"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2] font-semibold bg-white"
                            required
                        >
                            <option value="lotus" {{ old('site_scope', $photoSpot->site_scope) === 'lotus' ? 'selected' : '' }}>Lotus Creative (Spot Foto Terindah)</option>
                            <option value="jeep" {{ old('site_scope', $photoSpot->site_scope) === 'jeep' ? 'selected' : '' }}>Ready Jeep Dieng (Destinasi Rute 4x4)</option>
                        </select>
                    </div>
                @else
                    <input type="hidden" name="site_scope" value="{{ $photoSpot->site_scope }}">
                @endif

                <!-- 1. Nama Spot & Best Time Tag -->
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-5">
                    <div class="sm:col-span-8 space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Nama Spot Wisata / Lokasi <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $photoSpot->name) }}"
                            required
                            class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2] font-semibold"
                        >
                    </div>

                    <div class="sm:col-span-4 space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tag Waktu / Tema
                        </label>
                        <input
                            type="text"
                            name="best_time_tag"
                            value="{{ old('best_time_tag', $photoSpot->best_time_tag) }}"
                            placeholder="Contoh: 05.00 WIB, Heritage, Geothermal"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2]"
                        >
                    </div>
                </div>

                <!-- 2. Deskripsi Spot -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Deskripsi Sudut Pandang / Fotografi <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        required
                        class="w-full px-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2] leading-relaxed"
                    >{{ old('description', $photoSpot->description) }}</textarea>
                </div>

                <!-- 3. Foto Spot (File Picker + Fallback URL) -->
                <div class="space-y-3 pt-2 border-t border-slate-100" x-data="{
                    previewUrl: '{{ old('image_url', $photoSpot->image_url) }}',
                    fileName: '',
                    fileSize: '',
                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        this.fileName = file.name;
                        this.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewUrl = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Foto Spot Pemotretan <span class="text-rose-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-5 items-center">
                        <div class="sm:col-span-7">
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-slate-300 hover:border-[#0064D2] rounded-2xl p-6 text-center cursor-pointer bg-slate-50 hover:bg-blue-50/40 transition-colors group">
                                <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200 flex items-center justify-center text-[#0064D2] group-hover:scale-110 transition-transform mb-3">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-800 group-hover:text-[#0064D2]">Ganti File Foto (JPG, PNG, WebP)</span>
                                <span class="text-[11px] text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto saat ini</span>
                                <input
                                    type="file"
                                    name="image_file"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="hidden"
                                    @change="handleFileSelect($event)"
                                >
                            </label>
                            <template x-if="fileName">
                                <div class="mt-2 text-xs font-semibold text-emerald-700 flex items-center gap-1.5">
                                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                                    <span>File baru terpilih: <span x-text="fileName"></span> (<span x-text="fileSize"></span>)</span>
                                </div>
                            </template>
                        </div>

                        <!-- Preview Visual Box -->
                        <div class="sm:col-span-5">
                            <div class="aspect-[4/3] rounded-2xl border border-slate-200 bg-slate-100 overflow-hidden relative flex items-center justify-center">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" alt="Preview Foto Spot" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!previewUrl">
                                    <div class="text-center p-4 text-slate-400 space-y-1">
                                        <i data-lucide="image" class="w-8 h-8 mx-auto text-slate-300"></i>
                                        <p class="text-[11px] font-semibold">Preview foto kosong</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Fallback URL Alternatif -->
                    <div class="pt-2">
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">
                            Tautan URL gambar langsung:
                        </label>
                        <input
                            type="url"
                            name="image_url"
                            x-model="previewUrl"
                            placeholder="https://..."
                            class="w-full px-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 font-mono"
                        >
                    </div>
                </div>

                <!-- 4. Urutan & Status Publikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4 border-t border-slate-100">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Urutan Tampil (Sort Order)
                        </label>
                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $photoSpot->sort_order) }}"
                            min="0"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 font-semibold"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Status Publikasi
                        </label>
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $photoSpot->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#0064D2] rounded border-slate-300 focus:ring-[#0064D2]"
                                >
                                <span class="text-xs sm:text-sm font-bold text-slate-800">Tampilkan ke Halaman Publik Lotus Creative</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Action Submit & Delete -->
            <div class="flex items-center justify-between gap-3">
                <button
                    type="button"
                    onclick="if(confirm('Hapus spot foto ini secara permanen?')) document.getElementById('deleteForm').submit();"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 transition-colors flex items-center gap-1.5"
                >
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus Spot</span>
                </button>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('admin.photo-spots.index') }}"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 transition-colors"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all shadow-md shadow-blue-500/20 flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>

        </form>

        <form id="deleteForm" action="{{ route('admin.photo-spots.destroy', $photoSpot->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>
</main>
@endsection

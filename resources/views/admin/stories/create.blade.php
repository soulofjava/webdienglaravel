@extends('layouts.app')

@section('title', 'Tambah Babak Cerita — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <x-admin-nav :settings="$settings" subtitle="Tambah Babak Baru untuk Scrollytelling 5 Keajaiban Dieng" />

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Header & Breadcrumb -->
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('admin.stories.index') }}" class="hover:text-[#0064D2] transition-colors">Cerita Babak</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Tambah Baru</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Babak Cerita Keajaiban</h1>
            </div>

            <a
                href="{{ route('admin.stories.index') }}"
                class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 transition-colors shadow-xs"
            >
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm shadow-xs">
                <div class="font-bold flex items-center gap-2 mb-2 text-rose-900">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                    <span>Terdapat kesalahan isian formulir:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Card 1: Identitas & Narasi Babak -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="book-open" class="w-5 h-5 text-[#0064D2]"></i>
                        <span>Informasi & Narasi Babak</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Judul, badge penanda ketinggian, kutipan puitis pembuka, dan deskripsi naratif.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-5">
                    <!-- Badge / Babak -->
                    <div class="sm:col-span-5">
                        <label for="chapter_badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Label Babak (Badge) <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="chapter_badge"
                            name="chapter_badge"
                            value="{{ old('chapter_badge', 'BAB 0' . $nextSortOrder . ' • 2.000 MDPL') }}"
                            placeholder="Contoh: BAB 01 • 2.463 MDPL"
                            required
                            class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-semibold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Teks kecil di atas judul (misal nomor babak & ketinggian MDPL).</p>
                    </div>

                    <!-- Judul Babak -->
                    <div class="sm:col-span-7">
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Judul Babak Cerita <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Matahari Pertama di Puncak Sikunir"
                            required
                            class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-bold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                </div>

                <!-- Kutipan Puitis / Quote -->
                <div>
                    <label for="quote" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Kutipan Puitis / Quote Sinematik (Opsional)
                    </label>
                    <input
                        type="text"
                        id="quote"
                        name="quote"
                        value="{{ old('quote') }}"
                        placeholder="Contoh: “Ketika fajar menyingsing di Sikunir, samudra awan di bawah Anda menjelma emas murni.”"
                        class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm italic focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                    />
                    <p class="text-[11px] text-slate-400 mt-1">Satu kalimat puitis dengan tanda petik yang memperkuat suasana destinasi.</p>
                </div>

                <!-- Narasi Deskripsi -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Deskripsi Narasi Babak <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                        placeholder="Tuliskan pengalaman magis atau latar belakang cerita destinasi ini..."
                        class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm leading-relaxed focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                    >{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Card 2: Highlights / Poin-Poin Keunggulan (Repeater) -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="list-checks" class="w-5 h-5 text-[#0064D2]"></i>
                            <span>Poin-Poin Sorotan (Highlights)</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar keunggulan atau aktivitas seru yang tampil dengan centang centong estetik.</p>
                    </div>

                    <button
                        type="button"
                        id="addHighlightBtn"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 transition-colors cursor-pointer"
                    >
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Tambah Poin</span>
                    </button>
                </div>

                <!-- Repeater Container -->
                <div id="highlightsContainer" class="space-y-3">
                    @php
                        $oldHighlights = old('highlights', [
                            'Pendakian santai 30–40 menit dengan anak tangga rapi',
                            'Panorama 360° Gunung Sindoro, Sumbing, Merbabu, Merapi',
                            'Hangatnya teh purwaceng khas desa tertinggi',
                        ]);
                    @endphp

                    @foreach($oldHighlights as $idx => $hl)
                        <div class="flex items-center gap-2.5 highlight-row">
                            <span class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 shrink-0 row-index">
                                {{ $loop->iteration }}
                            </span>
                            <input
                                type="text"
                                name="highlights[]"
                                value="{{ $hl }}"
                                placeholder="Contoh: Pendakian santai 30–40 menit dengan anak tangga rapi"
                                class="flex-1 p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-1 focus:ring-[#0064D2] focus:outline-none transition-all"
                            />
                            <button
                                type="button"
                                onclick="removeHighlightRow(this)"
                                class="p-2.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer shrink-0"
                                title="Hapus baris"
                            >
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card 3: Visual Foto, Tema Warna, & Ikon -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="image" class="w-5 h-5 text-[#0064D2]"></i>
                        <span>Visual & Gaya Estetika</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tautkan foto lanskap sinematik dan tentukan tema warna aksen babak.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    <!-- File Picker / Upload Box -->
                    <div class="md:col-span-7 space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Unggah Foto Dari Perangkat <span class="text-rose-500">*</span>
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
                                        Klik atau seret file gambar babak ke sini
                                    </div>
                                    <p class="text-[11px] text-slate-400">Mendukung JPG, PNG, WebP (Maks 25MB, kompresi otomatis)</p>
                                </div>
                            </div>
                            <div id="fileInfoText" class="text-xs font-medium text-slate-600 mt-1"></div>
                        </div>

                        <div>
                            <label for="image_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Atau Tautkan URL Gambar (Opsional)
                            </label>
                            <input
                                type="url"
                                id="image_url"
                                name="image_url"
                                value="{{ old('image_url') }}"
                                placeholder="https://images.unsplash.com/..."
                                class="w-full p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                            <p class="text-[11px] text-slate-400 mt-1">Dapat dikosongkan jika Anda sudah memilih file unggahan di atas.</p>
                        </div>

                        <!-- Ikon Lucide -->
                        <div>
                            <label for="icon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Nama Ikon Lucide (Opsional)
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="icon"
                                    name="icon"
                                    value="{{ old('icon', 'sunrise') }}"
                                    placeholder="Contoh: sunrise, flame, droplets, landmark, compass"
                                    class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                                />
                            </div>
                            <div class="flex flex-wrap gap-1.5 mt-2 text-[11px]">
                                <span class="text-slate-400">Pilihan cepat:</span>
                                <button type="button" onclick="document.getElementById('icon').value='sunrise'" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono">sunrise</button>
                                <button type="button" onclick="document.getElementById('icon').value='flame'" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono">flame</button>
                                <button type="button" onclick="document.getElementById('icon').value='droplets'" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono">droplets</button>
                                <button type="button" onclick="document.getElementById('icon').value='landmark'" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono">landmark</button>
                                <button type="button" onclick="document.getElementById('icon').value='compass'" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono">compass</button>
                            </div>
                        </div>
                    </div>

                    <!-- Live Image Preview Card -->
                    <div class="md:col-span-5 space-y-2">
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-700">Preview Visual Foto</span>
                        <div class="h-56 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 relative shadow-inner">
                            <img
                                id="imagePreview"
                                src="{{ old('image_url', 'https://placehold.co/800x500/f1f5f9/94a3b8?text=Pilih+Foto+atau+Isi+URL') }}"
                                alt="Preview Foto"
                                class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/800x500/f1f5f9/94a3b8?text=Preview+Foto+Tidak+Tersedia'"
                            />
                            <span class="absolute bottom-2 right-2 bg-slate-900/75 backdrop-blur-xs text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">
                                Live Preview
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pilihan Warna Aksen -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                        Warna Aksen Badge & Ikon <span class="text-rose-500">*</span>
                    </label>

                    @php
                        $accentOptions = [
                            ['val' => 'amber', 'label' => 'Amber (Emas Fajar Sikunir)', 'bg' => 'bg-amber-500', 'badge' => 'bg-amber-50 border-amber-200 text-amber-700'],
                            ['val' => 'emerald', 'label' => 'Emerald (Hijau Toska Telaga)', 'bg' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                            ['val' => 'indigo', 'label' => 'Indigo (Lembah Suci Arjuna)', 'bg' => 'bg-indigo-600', 'badge' => 'bg-indigo-50 border-indigo-200 text-indigo-700'],
                            ['val' => 'blue', 'label' => 'Blue (Tiket.com Blue / Jeep)', 'bg' => 'bg-[#0064D2]', 'badge' => 'bg-blue-50 border-blue-200 text-[#0064D2]'],
                            ['val' => 'rose', 'label' => 'Rose (Merah Eksotis)', 'bg' => 'bg-rose-500', 'badge' => 'bg-rose-50 border-rose-200 text-rose-700'],
                            ['val' => 'purple', 'label' => 'Purple (Mistis Kayangan)', 'bg' => 'bg-purple-600', 'badge' => 'bg-purple-50 border-purple-200 text-purple-700'],
                        ];
                        $selectedAccent = old('accent_color', 'amber');
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($accentOptions as $opt)
                            <label class="relative flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-slate-300 cursor-pointer transition-all has-checked:border-[#0064D2] has-checked:ring-2 has-checked:ring-[#0064D2]/20 has-checked:bg-blue-50/20">
                                <input
                                    type="radio"
                                    name="accent_color"
                                    value="{{ $opt['val'] }}"
                                    {{ $selectedAccent === $opt['val'] ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#0064D2] focus:ring-[#0064D2]"
                                />
                                <span class="w-3.5 h-3.5 rounded-full {{ $opt['bg'] }} shrink-0"></span>
                                <span class="text-xs font-semibold text-slate-800">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card 4: Pengaturan Urutan & Status -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                    <!-- Urutan Tampil -->
                    <div>
                        <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nomor Urut Tampil <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            value="{{ old('sort_order', $nextSortOrder) }}"
                            min="0"
                            required
                            class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-sm font-mono font-bold focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Urutan 1 tampil teratas sebagai Babak Pertama.</p>
                    </div>

                    <!-- Status Aktif -->
                    <div class="pt-2 sm:pt-6">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded-lg border-slate-300 text-[#0064D2] focus:ring-[#0064D2] cursor-pointer"
                            />
                            <div>
                                <span class="text-xs font-bold text-slate-900 uppercase tracking-wider block">Tayangkan di Beranda</span>
                                <span class="text-[11px] text-slate-500">Tampilkan babak cerita ini pada section scrollytelling publik</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button Bar -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a
                        href="{{ route('admin.stories.index') }}"
                        class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-semibold text-slate-700 transition-colors"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer flex items-center gap-2"
                    >
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Babak Cerita</span>
                    </button>
                </div>
            </div>
        </form>
    </main>
</div>

<!-- Script Dynamic Repeater & Image Preview -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlInput = document.getElementById('image_url');
    const fileInput = document.getElementById('image_file_input');
    const preview = document.getElementById('imagePreview');
    const fileInfo = document.getElementById('fileInfoText');

    if (urlInput && preview) {
        urlInput.addEventListener('input', function() {
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

            if (fileInfo) {
                fileInfo.className = 'text-xs text-slate-600 font-medium block mt-1';
                fileInfo.innerText = `File dipilih: ${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
            }

            // Kompresi otomatis jika file > 1.5MB
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
                            canvas.toBlob((blob) => resolve(blob), 'image/jpeg', 0.85);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });

                if (compressed) {
                    const dt = new DataTransfer();
                    dt.items.add(new File([compressed], file.name.replace(/\.[^/.]+$/, "") + ".jpg", { type: 'image/jpeg' }));
                    fileInput.files = dt.files;
                    if (fileInfo) {
                        fileInfo.className = 'text-xs text-emerald-600 font-medium block mt-1';
                        fileInfo.innerText = `Foto berhasil dioptimasi: ${(compressed.size / 1024).toFixed(0)} KB (siap unggah)`;
                    }
                }
            }
        });
    }

    const addBtn = document.getElementById('addHighlightBtn');
    const container = document.getElementById('highlightsContainer');

    if (addBtn && container) {
        addBtn.addEventListener('click', function() {
            const count = container.querySelectorAll('.highlight-row').length + 1;
            const newRow = document.createElement('div');
            newRow.className = 'flex items-center gap-2.5 highlight-row';
            newRow.innerHTML = `
                <span class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 shrink-0 row-index">
                    ${count}
                </span>
                <input
                    type="text"
                    name="highlights[]"
                    value=""
                    placeholder="Contoh: Spot foto eksotis di dataran tinggi Dieng"
                    class="flex-1 p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-1 focus:ring-[#0064D2] focus:outline-none transition-all"
                />
                <button
                    type="button"
                    onclick="removeHighlightRow(this)"
                    class="p-2.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer shrink-0"
                    title="Hapus baris"
                >
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            `;
            container.appendChild(newRow);
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    }
});

function removeHighlightRow(btn) {
    const row = btn.closest('.highlight-row');
    const container = document.getElementById('highlightsContainer');
    if (row && container) {
        const totalRows = container.querySelectorAll('.highlight-row').length;
        if (totalRows <= 1) {
            row.querySelector('input').value = '';
            return;
        }
        row.remove();
        // Re-index row numbers
        container.querySelectorAll('.highlight-row').forEach((r, idx) => {
            const idxBadge = r.querySelector('.row-index');
            if (idxBadge) idxBadge.textContent = idx + 1;
        });
    }
}
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Panel Pengelola -->
    <header class="border-b border-white/10 bg-[#090d16]/90 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-8 py-3.5">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.packages.index') }}" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="font-serif text-base sm:text-lg font-bold text-white tracking-wide">
                        Edit Paket: {{ Str::limit($package->title, 40) }}
                    </h1>
                    <p class="text-xs text-slate-400">
                        Perbarui detail paket tour, jadwal rute, fasilitas, dan tarif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('package.detail', $package->slug) }}"
                    target="_blank"
                    class="px-3 py-2 rounded-xl text-xs font-semibold text-amber-300 hover:text-amber-200 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 transition-colors flex items-center gap-1.5"
                >
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Pratinjau Halaman</span>
                </a>
                <button
                    type="submit"
                    form="package-edit-form"
                    class="px-4 py-2 rounded-xl text-xs font-semibold bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 shadow-lg shadow-amber-500/20 transition-all flex items-center gap-1.5"
                >
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Form Konten -->
    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-8 py-8">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-500/15 border border-red-500/40 text-red-300 text-xs sm:text-sm">
                <div class="font-semibold flex items-center gap-2 mb-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    <span>Terdapat kesalahan pengisian data:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-slate-300 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="package-edit-form" action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Informasi Dasar -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 space-y-5">
                <div class="flex items-center gap-2.5 pb-4 border-b border-white/10 text-amber-400">
                    <i data-lucide="info" class="w-5 h-5"></i>
                    <h2 class="font-serif text-base font-bold text-white">1. Informasi Pokok Paket</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Nama / Judul Paket Tour <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title', $package->title) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Slug URL <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $package->slug) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500 font-mono text-xs"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Kategori Tour <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $package->category) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Durasi Program <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="duration"
                            value="{{ old('duration', $package->duration) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Titik Penjemputan <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="pickup_location"
                            value="{{ old('pickup_location', $package->pickup_location) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Estimasi Tarif / Orang (Rp) <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', $package->price) }}"
                            min="0"
                            step="1000"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Catatan Skema Tarif <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="price_note"
                            value="{{ old('price_note', $package->price_note) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Badge Label (Opsional)
                        </label>
                        <input
                            type="text"
                            name="badge"
                            value="{{ old('badge', $package->badge) }}"
                            placeholder="Contoh: Best Seller, Favorit, Hemat"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Urutan Tampil (Sort Order)
                        </label>
                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $package->sort_order) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Ringkasan / Sinopsis Paket <span class="text-amber-400">*</span>
                    </label>
                    <textarea
                        name="summary"
                        rows="3"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                    >{{ old('summary', $package->summary) }}</textarea>
                </div>
            </div>

            <!-- 2. Media / Banner Foto -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 space-y-5">
                <div class="flex items-center gap-2.5 pb-4 border-b border-white/10 text-amber-400">
                    <i data-lucide="image" class="w-5 h-5"></i>
                    <h2 class="font-serif text-base font-bold text-white">2. Foto Cover Paket</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            URL Gambar (Unsplash / Eksternal)
                        </label>
                        <input
                            type="text"
                            name="image_url"
                            value="{{ old('image_url', $package->image_url) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                        @if ($package->image_url)
                            <div class="mt-3 relative rounded-xl overflow-hidden aspect-video border border-white/10 max-w-xs">
                                <img src="{{ $package->image_url }}" alt="Preview" class="w-full h-full object-cover">
                                <span class="absolute bottom-1 right-1 bg-black/70 px-2 py-0.5 text-[10px] rounded text-slate-300">Foto Saat Ini</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Ganti dengan Unggah Foto Baru (Maks 5MB)
                        </label>
                        <input
                            type="file"
                            name="image_file"
                            accept="image/*"
                            class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer bg-white/5 border border-white/10 rounded-xl"
                        />
                        <p class="text-[11px] text-slate-400 mt-2">Biarkan kosong jika tetap menggunakan gambar yang sudah ada.</p>
                    </div>
                </div>
            </div>

            <!-- 3. Opsi Jadwal & Rute Kunjungan (Itinerary Dinamis) -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5 text-amber-400">
                        <i data-lucide="map" class="w-5 h-5"></i>
                        <div>
                            <h2 class="font-serif text-base font-bold text-white">3. Pilihan Rute & Destinasi Itinerary</h2>
                            <p class="text-xs text-slate-400">Dapat diisi beberapa opsi rute kunjungan</p>
                        </div>
                    </div>
                    <button
                        type="button"
                        id="btn-add-itinerary"
                        class="px-3.5 py-1.5 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/30 text-xs font-semibold transition-colors flex items-center gap-1.5 self-start sm:self-auto"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Tambah Opsi Rute</span>
                    </button>
                </div>

                <!-- Kontainer Kartu Rute -->
                <div id="itinerary-container" class="space-y-4">
                    @php
                        $itineraries = old('itinerary_names') !== null
                            ? array_map(function($name, $i) {
                                return [
                                    'name' => $name,
                                    'destinations' => old('itinerary_destinations')[$i] ?? '',
                                    'description' => old('itinerary_descriptions')[$i] ?? '',
                                ];
                            }, old('itinerary_names'), array_keys(old('itinerary_names')))
                            : ($package->itinerary_options ?? []);
                        if (empty($itineraries)) {
                            $itineraries = [['name' => 'Rute Standar', 'destinations' => '', 'description' => '']];
                        }
                    @endphp

                    @foreach ($itineraries as $index => $item)
                        <div class="itinerary-row p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-3 relative">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-amber-300 font-mono tracking-wider rute-number">RUTE #{{ $index + 1 }}</span>
                                <button type="button" class="btn-remove-row text-slate-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Nama Opsi Rute</label>
                                    <input
                                        type="text"
                                        name="itinerary_names[]"
                                        value="{{ $item['name'] ?? '' }}"
                                        placeholder="Contoh: Rute 1 - Sikidang & Candi Arjuna"
                                        class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Daftar Destinasi Singkat</label>
                                    <input
                                        type="text"
                                        name="itinerary_destinations[]"
                                        value="{{ $item['destinations'] ?? '' }}"
                                        placeholder="Contoh: Sunrise Sikunir, Kawah Sikidang, Candi Arjuna"
                                        class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">Rangkaian Jadwal Jam & Catatan Kegiatan</label>
                                <textarea
                                    name="itinerary_descriptions[]"
                                    rows="2"
                                    placeholder="Rincian jam dan kegiatan..."
                                    class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                                >{{ $item['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. Fasilitas & Persiapan (Include, Exclude, Checklist) -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 space-y-5">
                <div class="flex items-center gap-2.5 pb-4 border-b border-white/10 text-amber-400">
                    <i data-lucide="check-square" class="w-5 h-5"></i>
                    <h2 class="font-serif text-base font-bold text-white">4. Fasilitas & Checklist Wisata Dieng</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-emerald-400 mb-1.5 flex items-center gap-1.5">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            <span>Fasilitas Termasuk (Include)</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu fasilitas per baris</p>
                        <textarea
                            name="inclusions_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-emerald-400 focus:outline-none placeholder:text-slate-600 leading-relaxed font-sans"
                        >{{ old('inclusions_text', is_array($package->inclusions) ? implode("\n", $package->inclusions) : '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-rose-400 mb-1.5 flex items-center gap-1.5">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Tidak Termasuk (Exclude)</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu item per baris</p>
                        <textarea
                            name="exclusions_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-rose-400 focus:outline-none placeholder:text-slate-600 leading-relaxed font-sans"
                        >{{ old('exclusions_text', is_array($package->exclusions) ? implode("\n", $package->exclusions) : '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-amber-400 mb-1.5 flex items-center gap-1.5">
                            <i data-lucide="backpack" class="w-3.5 h-3.5"></i>
                            <span>Checklist Persiapan Dieng</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Tulis satu saran perlengkapan per baris</p>
                        <textarea
                            name="preparations_text"
                            rows="7"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none placeholder:text-slate-600 leading-relaxed font-sans"
                        >{{ old('preparations_text', is_array($package->preparations) ? implode("\n", $package->preparations) : '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 5. Opsi Visibilitas -->
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 flex flex-wrap items-center gap-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', (string)$package->is_active) == '1' ? 'checked' : '' }}
                        class="w-4 h-4 rounded bg-white/10 border-white/20 text-amber-500 focus:ring-amber-400 focus:ring-offset-0 cursor-pointer"
                    />
                    <div>
                        <span class="text-xs font-semibold text-white block">Status Aktif</span>
                        <span class="text-[11px] text-slate-400">Tampilkan paket di halaman publik website</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_popular" value="0">
                    <input
                        type="checkbox"
                        name="is_popular"
                        value="1"
                        {{ old('is_popular', (string)$package->is_popular) == '1' ? 'checked' : '' }}
                        class="w-4 h-4 rounded bg-white/10 border-white/20 text-amber-500 focus:ring-amber-400 focus:ring-offset-0 cursor-pointer"
                    />
                    <div>
                        <span class="text-xs font-semibold text-white block">Paket Populer (Hot)</span>
                        <span class="text-[11px] text-slate-400">Beri tanda bintang / sorotan khusus</span>
                    </div>
                </label>
            </div>

            <!-- Tombol Aksi Bawah -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20 transition-all flex items-center gap-2"
                >
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </main>
</div>

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

        btnAdd.addEventListener('click', function () {
            const rowCount = container.querySelectorAll('.itinerary-row').length + 1;
            const newRow = document.createElement('div');
            newRow.className = 'itinerary-row p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-3 relative';
            newRow.innerHTML = `
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-bold text-amber-300 font-mono tracking-wider rute-number">RUTE #${rowCount}</span>
                    <button type="button" class="btn-remove-row text-slate-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-400 mb-1">Nama Opsi Rute</label>
                        <input
                            type="text"
                            name="itinerary_names[]"
                            placeholder="Contoh: Rute ${rowCount} - Destinasi Favorit"
                            class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-400 mb-1">Daftar Destinasi Singkat</label>
                        <input
                            type="text"
                            name="itinerary_destinations[]"
                            placeholder="Contoh: Sunrise Sikunir, Kawah Sikidang, Telaga Warna"
                            class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Rangkaian Jadwal Jam & Catatan Kegiatan</label>
                    <textarea
                        name="itinerary_descriptions[]"
                        rows="2"
                        placeholder="Rincian jam dan kegiatan..."
                        class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                    ></textarea>
                </div>
            `;
            container.appendChild(newRow);
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });

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
    });
</script>
@endsection

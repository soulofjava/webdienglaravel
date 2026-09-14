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
                        Tambah Paket Wisata Baru
                    </h1>
                    <p class="text-xs text-slate-400">
                        Input detail paket tour, opsi jadwal itinerary, fasilitas, dan harga
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    form="package-form"
                    class="px-4 py-2 rounded-xl text-xs font-semibold bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 shadow-lg shadow-amber-500/20 transition-all flex items-center gap-1.5"
                >
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Paket</span>
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

        <form id="package-form" action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
                            value="{{ old('title') }}"
                            placeholder="Contoh: Paket Tour Dieng 1 Hari (One Day Tour)"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Slug Kustom (Opsional)
                        </label>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="Dikosongkan akan otomatis dibuat dari judul"
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
                            value="{{ old('category', '1 Hari') }}"
                            placeholder="Misal: 1 Hari, 2D1N, Adventure, Khusus"
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
                            value="{{ old('duration', '1 Hari Penuh (03:00 - 17:00 WIB)') }}"
                            placeholder="Contoh: 1 Hari (03:00 - 17:00 WIB)"
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
                            value="{{ old('pickup_location', 'Wonosobo Kota, Hotel, Terminal Mendolo, atau Stasiun Purwokerto') }}"
                            placeholder="Contoh: Wonosobo, Purwokerto, Jogja, Semarang"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Tarif Mulai Dari (Rp) <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', 350000) }}"
                            min="0"
                            step="1000"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Catatan Skema Tarif & Homestay <span class="text-amber-400">*</span>
                        </label>
                        <input
                            type="text"
                            name="price_note"
                            value="{{ old('price_note', '/ orang (Min. 4 Pax • Konfirmasi via WA)') }}"
                            placeholder="Contoh: / orang (Min. 4 Pax • Konfirmasi via WA)"
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
                            value="{{ old('badge', 'Favorit') }}"
                            placeholder="Contoh: Best Seller, Favorit, Hemat, Eksklusif"
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
                            value="{{ old('sort_order', 1) }}"
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
                        placeholder="Jelaskan gambaran umum perjalanan tour ini secara menarik..."
                        class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                    >{{ old('summary') }}</textarea>
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
                            value="{{ old('image_url', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') }}"
                            placeholder="https://images.unsplash.com/..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none placeholder:text-slate-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Atau Unggah Foto Baru (Maks 5MB)
                        </label>
                        <input
                            type="file"
                            name="image_file"
                            accept="image/*"
                            class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20 cursor-pointer bg-white/5 border border-white/10 rounded-xl"
                        />
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
                            <p class="text-xs text-slate-400">Dapat diisi beberapa opsi rute (misal: Rute 1 Sikidang, Rute 2 Sikarim, dst.)</p>
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
                    <!-- Template Baris Awal -->
                    <div class="itinerary-row p-4 rounded-2xl bg-white/[0.03] border border-white/10 space-y-3 relative">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-amber-300 font-mono tracking-wider rute-number">RUTE #1</span>
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
                                    placeholder="Contoh: Rute 1 - Sikidang & Telaga Warna (Klasik)"
                                    class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400 mb-1">Daftar Destinasi Singkat</label>
                                <input
                                    type="text"
                                    name="itinerary_destinations[]"
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
                                placeholder="03.00 Bertemu di meeting point -> 04.30 Golden Sunrise Sikunir -> 08.00 Kawah Sikidang -> 11.30 Istirahat & Makan -> 15.00 Kembali"
                                class="w-full px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                            ></textarea>
                        </div>
                    </div>
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
                            placeholder="Transportasi AC Wonosobo - Dieng PP&#10;BBM & Driver Berpengalaman&#10;Tiket Masuk Semua Objek Wisata&#10;Makan 2x Sesuai Program&#10;Pemandu Wisata Lokal Ramah"
                        >{{ old('inclusions_text', "Transportasi AC Wonosobo - Dieng PP\nDriver & BBM\nTiket Masuk Seluruh Objek Wisata\nMakan 2x & Air Mineral\nPemandu Wisata Lokal Ramah\nDokumentasi Foto") }}</textarea>
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
                            placeholder="Penjemputan di luar kota Wonosobo&#10;Pengeluaran pribadi & oleh-oleh&#10;Sewa perahu Telaga Menjer&#10;Tipping driver & guide seikhlasnya"
                        >{{ old('exclusions_text', "Antar jemput di luar titik Wonosobo\nPengeluaran pribadi & oleh-oleh\nSewa perahu Telaga Menjer\nTiket wahana berbayar opsional") }}</textarea>
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
                            placeholder="Jaket tebal / windbreaker (suhu Dieng bisa 5-10°C)&#10;Sepatu running / treking yang nyaman&#10;Sarung tangan & kupluk penghangat&#10;Obat-obatan pribadi & minyak kayu putih&#10;Powerbank & kamera"
                        >{{ old('preparations_text', "Jaket tebal / windproof (suhu 5-10°C)\nSepatu kets / treking yang nyaman\nKupluk & sarung tangan wol\nObat-obatan pribadi & tolak angin\nPowerbank & jas hujan lipat") }}</textarea>
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
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}
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
                        {{ old('is_popular') ? 'checked' : '' }}
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
                    <span>Simpan Paket Wisata</span>
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

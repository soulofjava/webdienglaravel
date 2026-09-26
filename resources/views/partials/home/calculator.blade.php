<!-- 8. SMART BOOKING CALCULATOR & SIMULATOR HARGA INTERAKTIF -->
    <section id="kalkulator" class="py-24 sm:py-32 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="relative rounded-3xl p-4 sm:p-8 lg:p-12 glass-panel border border-white/15 shadow-2xl overflow-hidden">
            <!-- Glow background -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                    <i data-lucide="calculator" class="w-3.5 h-3.5"></i>
                    <span>SIMULATOR ESTIMASI AWAL</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl font-black text-white">Simulator Estimasi Biaya Wisata</h2>
                <p class="text-xs sm:text-sm text-slate-400 mt-2">Dapatkan perkiraan awal anggaran perjalanan Anda. Tarif resmi final dan ketersediaan kamar homestay/armada akan dikonfirmasi langsung oleh tim admin kami via WhatsApp.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Form Input Parameter -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Pilihan Paket -->
                    <div>
                        <label for="calcPkg" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">1. Pilih Paket Wisata (Estimasi Dasar)</label>
                        <select id="calcPkg" name="calcPkg" aria-label="Pilih Paket Wisata" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            @foreach ($packages as $pkg)
                                <option
                                    value="{{ $pkg->slug }}"
                                    data-price="{{ $pkg->price }}"
                                    data-jeep="{{ str_contains(strtolower($pkg->category . ' ' . $pkg->title), 'jeep') ? '1' : '0' }}"
                                    data-duration="{{ $pkg->duration }}"
                                    {{ $pkg->is_popular ? 'selected' : '' }}
                                >
                                    {{ $pkg->title }} — Mulai {{ $pkg->formatted_price }} ({{ $pkg->duration }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jumlah Peserta -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="calcPax" class="text-xs font-bold uppercase tracking-wider text-slate-300">2. Jumlah Peserta</label>
                            <span id="paxDisplay" class="text-xs font-bold text-amber-400">4 Orang</span>
                        </div>
                        <input id="calcPax" name="calcPax" type="range" min="1" max="25" value="4" aria-label="Jumlah Peserta Wisata" class="w-full accent-amber-400 cursor-pointer">
                        <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                            <span>1 Orang</span>
                            <span>10 Orang (Diskon 10%)</span>
                            <span>25 Orang (Rombongan)</span>
                        </div>
                    </div>

                    <!-- Titik Penjemputan -->
                    <div>
                        <label for="calcMeeting" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">3. Lokasi Titik Penjemputan (Meeting Point)</label>
                        <select id="calcMeeting" name="calcMeeting" aria-label="Lokasi Titik Penjemputan" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            @if(isset($pickupLocations) && count($pickupLocations) > 0)
                                @foreach($pickupLocations as $loc)
                                    @php
                                        $locName = is_array($loc) ? ($loc['name'] ?? '') : ($loc->name ?? '');
                                        $locDesc = is_array($loc) ? ($loc['description'] ?? '') : ($loc->description ?? '');
                                        $locSurcharge = (int) (is_array($loc) ? ($loc['surcharge_per_pax'] ?? 0) : ($loc->surcharge_per_pax ?? 0));
                                    @endphp
                                    <option value="{{ $locName }}" data-surcharge="{{ $locSurcharge }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $locName }}{{ !empty($locDesc) ? ' — ' . $locDesc : '' }}{{ $locSurcharge > 0 ? ' (+Rp ' . number_format($locSurcharge, 0, ',', '.') . '/org)' : ' (Gratis / Standar)' }}
                                    </option>
                                @endforeach
                            @else
                                <option value="Wonosobo / Terminal Mendolo" data-surcharge="0" selected>Kota Wonosobo / Terminal Mendolo (Gratis / Standar)</option>
                                <option value="Purwokerto (Stasiun / Terminal)" data-surcharge="50000">Purwokerto — Stasiun / Terminal Bulupitu (+Rp 50.000/org)</option>
                                <option value="Yogyakarta (Stasiun Tugu / Lempuyangan / YIA)" data-surcharge="100000">Yogyakarta — Stasiun Tugu / Lempuyangan / Bandara YIA (+Rp 100.000/org)</option>
                                <option value="Semarang (Stasiun Tawang / Bandara)" data-surcharge="100000">Semarang — Stasiun Tawang / Bandara Ahmad Yani (+Rp 100.000/org)</option>
                            @endif
                        </select>
                    </div>

                    <!-- Rencana Tanggal & Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="calcDate" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Tanggal Perjalanan</label>
                            <div class="relative">
                                <input id="calcDate" name="calcDate" type="text" placeholder="Pilih tanggal keberangkatan..." readonly class="w-full p-3 pl-3.5 pr-10 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none cursor-pointer placeholder:text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 text-amber-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label for="calcName" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Nama Pemesan</label>
                            <input id="calcName" name="calcName" type="text" placeholder="Contoh: Bpk. Kurniawan" class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="calcNotes" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Catatan Tambahan (Opsional)</label>
                        <input id="calcNotes" name="calcNotes" type="text" placeholder="Permintaan tipe kamar homestay, menu khusus, dsb." class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <!-- Rincian Hasil & Tombol WA -->
                <div class="lg:col-span-5 p-4 sm:p-6 rounded-2xl bg-black/40 border border-white/10 space-y-5">
                    <div class="border-b border-white/10 pb-4">
                        <span class="text-xs font-semibold text-amber-400 uppercase tracking-wider block">Estimasi Awal Mulai Dari</span>
                        <div id="totalPriceDisplay" class="text-3xl sm:text-4xl font-black text-amber-400 mt-2 font-mono">Rp 2.780.000</div>
                        <p id="calcNoteText" class="text-xs text-slate-400 mt-1">Perkiraan awal untuk 4 orang peserta</p>
                    </div>

                    <div class="space-y-3 text-xs text-slate-300">
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Paket:</span>
                            <span id="summaryPkgName" class="font-semibold text-white">Golden Sunrise 2D1N</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Peserta:</span>
                            <span id="summaryPax" class="font-semibold text-white">4 Orang</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-white/5">
                            <span class="text-slate-400">Titik Jemput:</span>
                            <span id="summaryMeeting" class="font-semibold text-white truncate max-w-[200px]">Wonosobo</span>
                        </div>
                        <div id="discountRow" class="hidden justify-between py-1 border-b border-white/5 text-emerald-400">
                            <span>Diskon Rombongan:</span>
                            <span id="summaryDiscount" class="font-semibold">-</span>
                        </div>
                    </div>

                    <!-- Disclaimer Homestay & Seasonality -->
                    <div class="p-3 rounded-xl bg-white/[0.03] border border-white/10 text-[11px] text-slate-300 leading-relaxed flex items-start gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5"></i>
                        <span>Biaya akhir dapat menyesuaikan ketersediaan tipe kamar homestay (standar/VIP), musim liburan, dan kustomisasi rute Anda.</span>
                    </div>

                    <button id="btnSendWa" class="w-full relative group overflow-hidden py-3.5 sm:py-4 px-3 sm:px-4 rounded-xl sm:rounded-2xl text-slate-950 font-bold bg-gradient-to-r from-emerald-400 via-emerald-300 to-emerald-400 hover:from-emerald-300 hover:to-emerald-200 transition-all duration-300 shadow-xl shadow-emerald-500/25 active:scale-[0.98] flex items-center justify-center gap-2.5 cursor-pointer">
                        <span class="w-8 h-8 rounded-xl bg-black/10 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <i data-lucide="message-circle" class="w-4 h-4 text-slate-950"></i>
                        </span>
                        <span class="text-xs sm:text-sm font-extrabold tracking-tight sm:tracking-normal leading-snug text-slate-950 text-center">
                            Konsultasi & Cek Homestay via WA
                        </span>
                    </button>
                    <p class="text-[11px] text-center text-slate-400 leading-tight">Terhubung langsung dengan Admin Resmi {{ $settings->site_name }} untuk pengecekan slot kamar & tanggal.</p>
                </div>
            </div>
        </div>
    </section>

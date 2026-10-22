<!-- 8. SMART BOOKING CALCULATOR & SIMULATOR HARGA INTERAKTIF (TIKET.COM LIGHT THEME) -->
<section id="kalkulator" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto scroll-mt-20">
    <div class="relative rounded-3xl p-6 sm:p-10 lg:p-12 bg-white border border-slate-200 shadow-xl overflow-hidden">
        <!-- Header Section -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-blue-50 text-[#0064D2] border border-blue-100 mb-3">
                <i data-lucide="calculator" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                <span>SIMULATOR ESTIMASI AWAL</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Simulator Estimasi Biaya Wisata</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                Dapatkan perkiraan awal anggaran perjalanan Anda. Tarif resmi final dan ketersediaan kamar homestay/armada akan dikonfirmasi langsung oleh tim admin kami via WhatsApp.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Input Parameter (Kiri) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Pilihan Paket -->
                <div>
                    <label for="calcPkg" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        1. Pilih Paket Wisata (Estimasi Dasar)
                    </label>
                    <select id="calcPkg" name="calcPkg" aria-label="Pilih Paket Wisata" class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all cursor-pointer">
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
                        <label for="calcPax" class="text-xs font-bold uppercase tracking-wider text-slate-700">2. Jumlah Peserta</label>
                        <span id="paxDisplay" class="text-xs font-extrabold text-[#0064D2] bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">4 Orang</span>
                    </div>
                    <input id="calcPax" name="calcPax" type="range" min="1" max="25" value="4" aria-label="Jumlah Peserta Wisata" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-[#0064D2]">
                    <div class="flex justify-between text-[11px] text-slate-500 font-medium mt-1.5">
                        <span>1 Orang</span>
                        <span class="text-[#0064D2] font-semibold">10 Orang (Diskon 10%)</span>
                        <span>25 Orang (Rombongan)</span>
                    </div>
                </div>

                <!-- Titik Penjemputan -->
                <div>
                    <label for="calcMeeting" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">3. Lokasi Titik Penjemputan (Meeting Point)</label>
                    <select id="calcMeeting" name="calcMeeting" aria-label="Lokasi Titik Penjemputan" class="w-full p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all cursor-pointer">
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
                        <label for="calcDate" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tanggal Perjalanan</label>
                        <div class="relative">
                            <input id="calcDate" name="calcDate" type="text" placeholder="Pilih tanggal keberangkatan..." readonly class="w-full p-3 pl-3.5 pr-10 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer placeholder:text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#0064D2] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label for="calcName" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Pemesan</label>
                        <input id="calcName" name="calcName" type="text" placeholder="Contoh: Bpk. Kurniawan" class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <label for="calcNotes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                    <input id="calcNotes" name="calcNotes" type="text" placeholder="Permintaan tipe kamar homestay, menu khusus, dsb." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400">
                </div>
            </div>

            <!-- Rincian Hasil & Tombol WA (Kanan: Prominent tiket-blue Card) -->
            <div class="lg:col-span-5 p-6 sm:p-7 rounded-2xl bg-gradient-to-b from-[#0064D2] to-[#004EA8] text-white shadow-xl shadow-blue-600/20 space-y-5 border border-blue-400/30 relative overflow-hidden">
                <!-- Ambient Glow Highlight -->
                <div class="absolute -top-16 -right-16 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="border-b border-white/15 pb-4 relative z-10">
                    <span class="text-xs font-bold tracking-wider text-blue-100 uppercase block">Estimasi Awal Mulai Dari</span>
                    <div id="totalPriceDisplay" class="text-3xl sm:text-4xl font-black text-[#FEDD00] mt-1 font-mono tracking-tight">Rp 2.780.000</div>
                    <p id="calcNoteText" class="text-xs text-blue-100 font-medium mt-1">Perkiraan awal untuk 4 orang peserta</p>
                </div>

                <!-- Summary Breakdown List -->
                <div class="space-y-2.5 text-xs bg-white/10 rounded-xl p-4 border border-white/15 backdrop-blur-xs relative z-10">
                    <div class="flex justify-between py-1 border-b border-white/10">
                        <span class="text-blue-100">Paket:</span>
                        <span id="summaryPkgName" class="font-bold text-white text-right">Golden Sunrise 2D1N</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-white/10">
                        <span class="text-blue-100">Peserta:</span>
                        <span id="summaryPax" class="font-bold text-white">4 Orang</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-white/10">
                        <span class="text-blue-100">Titik Jemput:</span>
                        <span id="summaryMeeting" class="font-bold text-white truncate max-w-[180px] text-right">Wonosobo</span>
                    </div>
                    <div id="discountRow" class="hidden justify-between py-1 border-b border-white/10 text-[#FEDD00] font-bold">
                        <span>Diskon Rombongan:</span>
                        <span id="summaryDiscount" class="font-bold">-</span>
                    </div>
                </div>

                <!-- Disclaimer Homestay & Seasonality -->
                <div class="p-3.5 rounded-xl bg-white/10 border border-white/15 text-[11px] text-blue-50 leading-relaxed flex items-start gap-2.5 relative z-10">
                    <i data-lucide="info" class="w-4 h-4 text-[#FEDD00] flex-shrink-0 mt-0.5"></i>
                    <span>Biaya akhir dapat menyesuaikan ketersediaan tipe kamar homestay (standar/VIP), musim liburan, dan kustomisasi rute Anda.</span>
                </div>

                <!-- WhatsApp Booking Button -->
                <button id="btnSendWa" class="w-full relative group overflow-hidden py-3.5 sm:py-4 px-4 rounded-xl sm:rounded-2xl text-slate-900 font-extrabold bg-[#FEDD00] hover:bg-[#F5D300] transition-all duration-300 shadow-lg shadow-amber-500/25 active:scale-[0.98] flex items-center justify-center gap-2.5 cursor-pointer relative z-10">
                    <span class="w-7 h-7 rounded-lg bg-black/10 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                        <i data-lucide="message-circle" class="w-4 h-4 text-slate-900"></i>
                    </span>
                    <span class="text-xs sm:text-sm font-black tracking-tight sm:tracking-normal leading-snug text-slate-900 text-center">
                        Konsultasi & Cek Homestay via WA
                    </span>
                </button>
                <p class="text-[11px] text-center text-blue-100 leading-tight relative z-10">Terhubung langsung dengan Admin Resmi {{ $settings->site_name }} untuk pengecekan slot kamar & tanggal.</p>
            </div>
        </div>
    </div>
</section>

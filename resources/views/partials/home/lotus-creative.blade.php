<!-- 7. JASA DOKUMENTASI SINEMATIK & DRONE 4K (OFFICIAL PARTNER: LOTUS CREATIVE) -->
    <section id="dokumentasi" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20 relative">
        <!-- Glow Dekorasi Khas Lotus Creative (Cyan & Rose) -->
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header Section Dokumentasi -->
        <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Logo Lotus Creative" class="w-14 h-14 sm:w-16 sm:h-16 object-contain rounded-2xl bg-black/50 border border-white/15 p-2 shadow-xl shadow-cyan-500/20 hover:scale-105 transition-transform duration-300">
                <div class="text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] font-bold tracking-widest uppercase bg-gradient-to-r from-cyan-500/20 to-rose-500/20 text-cyan-300 border border-cyan-500/30">
                        <i data-lucide="camera" class="w-3 h-3 text-cyan-400"></i>
                        <span>OFFICIAL PHOTOGRAPHY & DRONE PARTNER</span>
                    </span>
                    <h3 class="font-bold text-sm sm:text-base text-white mt-1">LOTUS CREATIVE</h3>
                    <p class="text-[11px] text-slate-400">Travel Photography & Aerial Videography Dieng</p>
                </div>
            </div>

            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">
                Abadikan Momen Sinematik di Tanah Dieng
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-2xl mx-auto">
                Kolaborasi resmi <strong class="text-white">TiketDieng.com</strong> bersama vendor dokumentasi profesional <strong class="text-cyan-300">Lotus Creative</strong>. Dapatkan potret visual memukau, rekaman udara drone 4K, serta video reels estetik yang siap diunggah ke media sosial Anda.
            </p>

            <!-- Mini Hub Kontak Lotus Creative -->
            <div class="flex flex-wrap items-center justify-center gap-3 mt-6 text-xs text-slate-300">
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span>Studio: Jl. Dieng KM 18 Tieng, Kejajar, Wonosobo</span>
                </div>
                <a href="https://wa.me/628164211196" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 hover:text-white transition-colors">
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>WA Studio: 0816-4211-196</span>
                </a>
                <a href="https://www.instagram.com/lotus.creative01?stnk=dG83cjF1NHptaXB3" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-500/10 hover:bg-pink-500/20 border border-pink-500/30 text-pink-300 hover:text-white transition-colors">
                    <i data-lucide="instagram" class="w-3.5 h-3.5 text-pink-400"></i>
                    <span>@lotus.creative01</span>
                </a>
                <a href="https://www.tiktok.com/@lotuscreative_?_r=1&_t=ZS-99iFr2JbCcc" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white transition-colors">
                    <i data-lucide="video" class="w-3.5 h-3.5 text-cyan-400"></i>
                    <span>@lotuscreative_</span>
                </a>
            </div>
        </div>

        <!-- Grid 5 Kartu Paket Dokumentasi Lotus Creative -->
        @if(isset($docPackages) && $docPackages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10 items-stretch mb-16">
                @foreach($docPackages as $doc)
                    <div class="glass-panel rounded-3xl p-6 sm:p-7 border flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden {{ $loop->first ? 'border-cyan-500/40 bg-gradient-to-b from-cyan-500/[0.08] via-white/[0.02] to-transparent lg:col-span-1 shadow-xl shadow-cyan-500/10' : 'border-white/10 hover:border-white/20' }}">
                        
                        @if($loop->first)
                            <div class="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl pointer-events-none"></div>
                        @endif

                        <div class="space-y-4">
                            <!-- Top Tag & Durasi -->
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $loop->first ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 'bg-white/10 text-amber-300 border border-white/10' }}">
                                    {{ $doc->badge ?? 'Lotus Creative' }}
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                    <span>{{ $doc->duration }}</span>
                                </span>
                            </div>

                            <!-- Judul & Deskripsi Singkat -->
                            <div>
                                <h3 class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-cyan-300 transition-colors">
                                    {{ $doc->title }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed line-clamp-2">
                                    {{ $doc->summary }}
                                </p>
                            </div>

                            <!-- Harga Resmi Paket -->
                            <div class="p-3.5 rounded-2xl bg-white/[0.03] border border-white/5">
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Tarif Layanan Resmi</span>
                                <div class="flex items-baseline gap-1.5 mt-0.5">
                                    <span class="text-2xl sm:text-3xl font-extrabold text-white font-mono">Rp {{ number_format($doc->price, 0, ',', '.') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $doc->price_note ?? '/ sesi' }}</span>
                                </div>
                            </div>

                            <!-- Destinasi Wisata yang Dicakup -->
                            <div>
                                <span class="text-[11px] font-semibold text-slate-300 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-cyan-400"></i>
                                    <span>Rute / Objek Wisata:</span>
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @if(is_array($doc->itinerary_options))
                                        @foreach($doc->itinerary_options as $spot)
                                            <span class="px-2 py-0.5 rounded-md bg-white/5 border border-white/10 text-[10px] text-slate-300">
                                                {{ is_array($spot) ? ($spot['destinations'] ?? ($spot['name'] ?? '')) : $spot }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Fasilitas Include Utama -->
                            <div class="pt-3 border-t border-white/10">
                                <span class="text-[11px] font-semibold text-slate-300 uppercase tracking-wider block mb-2">Termasuk (Include):</span>
                                <ul class="space-y-1.5 text-xs text-slate-300">
                                    @if(is_array($doc->inclusions))
                                        @foreach(array_slice($doc->inclusions, 0, 4) as $inc)
                                            <li class="flex items-start gap-2 text-[11px] leading-tight text-slate-300">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 mt-0.5"></i>
                                                <span>{{ is_array($inc) ? ($inc['title'] ?? ($inc['description'] ?? '')) : $inc }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Tombol Pesan via WhatsApp -->
                        <div class="pt-5 mt-4 border-t border-white/10">
                            @php
                                $waMessage = "Halo Lotus Creative & TiketDieng, saya tertarik untuk booking *" . $doc->title . "* dengan tarif Rp " . number_format($doc->price, 0, ',', '.') . ". Mohon informasi ketersediaan jadwal fotografer untuk rencana trip saya.";
                                $waUrl = "https://wa.me/628164211196?text=" . urlencode($waMessage);
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition-all duration-300 {{ $loop->first ? 'text-black bg-gradient-to-r from-cyan-400 to-teal-400 hover:from-cyan-300 hover:to-teal-300 shadow-lg shadow-cyan-500/20' : 'text-white bg-white/10 hover:bg-white/20 border border-white/15' }}">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>Reservasi Jadwal Foto</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- 4 Pilar Keunggulan Lotus Creative -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 relative z-10">
            <div class="text-center max-w-xl mx-auto mb-8">
                <span class="text-[10px] font-bold tracking-widest uppercase text-cyan-400 block mb-1">STANDAR KUALITAS TINGGI</span>
                <h3 class="font-serif text-xl sm:text-2xl font-bold text-white">Mengapa Memilih Dokumentasi Lotus Creative?</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/15 flex items-center justify-center text-cyan-400 mb-3">
                        <i data-lucide="camera" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Kamera Standar Industri</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Penggunaan kamera mirrorless/DSLR modern dengan variasi lensa potret dan pencahayaan flash profesional.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-rose-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center text-rose-400 mb-3">
                        <i data-lucide="video" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Rekaman Udara Drone 4K</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Perspektif aerial dramatis memperlihatkan kemegahan lanskap lautan awan, kawah vulkanik, dan telaga Dieng.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-amber-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center text-amber-400 mb-3">
                        <i data-lucide="film" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Unlimited RAW & Reels</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Seluruh file mentah tanpa batas diserahkan, ditambah bonus video pendek sinematik yang siap posting di TikTok/Instagram.</p>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-emerald-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center text-emerald-400 mb-3">
                        <i data-lucide="sun" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-white mb-1">Pemandu Sudut Fajar</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Fotografer asli Dieng yang memahami titik terbaik matahari terbit dan jam masuknya cahaya keemasan (*golden hour*).</p>
                </div>
            </div>
        </div>
    </section>

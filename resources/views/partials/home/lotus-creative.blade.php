<!-- 7. JASA DOKUMENTASI SINEMATIK & DRONE 4K (OFFICIAL PARTNER: LOTUS CREATIVE - TIKET.COM LIGHT THEME) -->
<section id="dokumentasi" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-200/80 scroll-mt-20 relative">
    <!-- Header Section Dokumentasi -->
    <div class="text-center max-w-3xl mx-auto mb-14 relative z-10">
        <div class="flex items-center justify-center gap-3 mb-4">
            <img src="{{ asset('images/lotus-creative-logo.png') }}" alt="Logo Lotus Creative" class="w-14 h-14 sm:w-16 sm:h-16 object-contain rounded-2xl bg-slate-900 border border-slate-200 p-2 shadow-sm hover:scale-105 transition-transform duration-300">
            <div class="text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-blue-50 text-[#0064D2] border border-blue-200">
                    <i data-lucide="camera" class="w-3 h-3 text-[#0064D2]"></i>
                    <span>OFFICIAL PHOTOGRAPHY & DRONE PARTNER</span>
                </span>
                <h3 class="font-extrabold text-base text-slate-900 mt-1">LOTUS CREATIVE</h3>
                <p class="text-[11px] text-slate-500 font-medium">Travel Photography & Aerial Videography Dieng</p>
            </div>
        </div>

        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">
            Abadikan Momen Sinematik di Tanah Dieng
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
            Kolaborasi resmi <strong class="text-slate-900">TiketDieng.com</strong> bersama vendor dokumentasi profesional <strong class="text-[#0064D2]">Lotus Creative</strong>. Dapatkan potret visual memukau, rekaman udara drone 4K, serta video reels estetik yang siap diunggah ke media sosial Anda.
        </p>

        <!-- Mini Hub Kontak Lotus Creative -->
        <div class="flex flex-wrap items-center justify-center gap-3 mt-6 text-xs text-slate-700">
            <div class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 shadow-xs">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-500"></i>
                <span class="font-medium">Studio: Jl. Dieng KM 18 Tieng, Kejajar, Wonosobo</span>
            </div>
            <a href="https://wa.me/628164211196" target="_blank" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 transition-colors font-medium shadow-xs">
                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                <span>WA Studio: 0816-4211-196</span>
            </a>
            <a href="https://www.instagram.com/lotus.creative01?stnk=dG83cjF1NHptaXB3" target="_blank" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 border border-pink-200 text-pink-700 transition-colors font-medium shadow-xs">
                <svg class="w-3.5 h-3.5 text-pink-600 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                </svg>
                <span>@lotus.creative01</span>
            </a>
            <a href="{{ route('documentation') }}" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-[#0064D2] transition-colors font-bold shadow-xs">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                <span>Halaman Khusus Lotus Creative</span>
            </a>
        </div>
    </div>

    <!-- Grid 5 Kartu Paket Dokumentasi Lotus Creative -->
    @if(isset($docPackages) && $docPackages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10 items-stretch mb-14">
            @foreach($docPackages as $doc)
                <div class="bg-white rounded-3xl p-6 sm:p-7 border flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden {{ $loop->first ? 'border-[#0064D2] ring-2 ring-[#0064D2]/20 shadow-md lg:col-span-1' : 'border-slate-200 shadow-sm hover:border-[#0064D2] hover:shadow-lg' }}">

                    <div class="space-y-4">
                        <!-- Top Tag & Durasi -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $loop->first ? 'bg-blue-50 text-[#0064D2] border border-blue-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                {{ $doc->badge ?? 'Lotus Creative' }}
                            </span>
                            <span class="text-[11px] text-slate-500 font-medium flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                <span>{{ $doc->duration }}</span>
                            </span>
                        </div>

                        <!-- Judul & Deskripsi Singkat -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#0064D2] transition-colors">
                                {{ $doc->title }}
                            </h3>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed line-clamp-2">
                                {{ $doc->summary }}
                            </p>
                        </div>

                        <!-- Harga Resmi Paket -->
                        <div class="p-3.5 rounded-2xl bg-[#F4F7FB] border border-slate-200/80">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block">Tarif Layanan Resmi</span>
                            <div class="flex items-baseline gap-1.5 mt-0.5">
                                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">Rp {{ number_format($doc->price, 0, ',', '.') }}</span>
                                <span class="text-[11px] text-slate-500 font-medium">{{ $doc->price_note ?? '/ sesi' }}</span>
                            </div>
                        </div>

                        <!-- Destinasi Wisata yang Dicakup -->
                        <div>
                            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Rute / Objek Wisata:</span>
                            </span>
                            <div class="flex flex-wrap gap-1.5">
                                @if(is_array($doc->itinerary_options))
                                    @foreach($doc->itinerary_options as $spot)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-[10px] text-slate-700 font-medium">
                                            {{ is_array($spot) ? ($spot['destinations'] ?? ($spot['name'] ?? '')) : $spot }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Fasilitas Include Utama -->
                        <div class="pt-3 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block mb-2">Termasuk (Include):</span>
                            <ul class="space-y-1.5 text-xs text-slate-600">
                                @if(is_array($doc->inclusions))
                                    @foreach(array_slice($doc->inclusions, 0, 4) as $inc)
                                        <li class="flex items-start gap-2 text-[11px] leading-tight text-slate-600">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                            <span>{{ is_array($inc) ? ($inc['title'] ?? ($inc['description'] ?? '')) : $inc }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Tombol Pesan via WhatsApp -->
                    <div class="pt-5 mt-4 border-t border-slate-100">
                        @php
                            $waMessage = "Halo Lotus Creative & TiketDieng, saya tertarik untuk booking *" . $doc->title . "* dengan tarif Rp " . number_format($doc->price, 0, ',', '.') . ". Mohon informasi ketersediaan jadwal fotografer untuk rencana trip saya.";
                            $waUrl = "https://wa.me/628164211196?text=" . urlencode($waMessage);
                        @endphp
                        <a href="{{ $waUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition-all duration-300 {{ $loop->first ? 'text-white bg-[#0064D2] hover:bg-[#0051ab] shadow-sm shadow-blue-500/20' : 'text-slate-700 bg-slate-100 hover:bg-[#0064D2] hover:text-white border border-slate-200' }}">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            <span>Reservasi Jadwal Foto</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- 4 Pilar Keunggulan Lotus Creative -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm relative z-10">
        <div class="text-center max-w-xl mx-auto mb-8">
            <span class="text-[10px] font-bold tracking-widest uppercase text-[#0064D2] block mb-1">STANDAR KUALITAS TINGGI</span>
            <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Mengapa Memilih Dokumentasi Lotus Creative?</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-[#0064D2]/40 hover:bg-white transition-all">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#0064D2] mb-3">
                    <i data-lucide="camera" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-sm text-slate-900 mb-1">Kamera Standar Industri</h4>
                <p class="text-[11px] text-slate-600 leading-relaxed">Penggunaan kamera mirrorless/DSLR modern dengan variasi lensa potret dan pencahayaan flash profesional.</p>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-rose-400/50 hover:bg-white transition-all">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 mb-3">
                    <i data-lucide="video" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-sm text-slate-900 mb-1">Rekaman Udara Drone 4K</h4>
                <p class="text-[11px] text-slate-600 leading-relaxed">Perspektif aerial dramatis memperlihatkan kemegahan lanskap lautan awan, kawah vulkanik, dan telaga Dieng.</p>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-amber-400/50 hover:bg-white transition-all">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 mb-3">
                    <i data-lucide="film" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-sm text-slate-900 mb-1">Unlimited RAW & Reels</h4>
                <p class="text-[11px] text-slate-600 leading-relaxed">Seluruh file mentah tanpa batas diserahkan, ditambah bonus video pendek sinematik yang siap posting di TikTok/Instagram.</p>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-emerald-400/50 hover:bg-white transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-3">
                    <i data-lucide="sun" class="w-5 h-5"></i>
                </div>
                <h4 class="font-bold text-sm text-slate-900 mb-1">Pemandu Sudut Fajar</h4>
                <p class="text-[11px] text-slate-600 leading-relaxed">Fotografer asli Dieng yang memahami titik terbaik matahari terbit dan jam masuknya cahaya keemasan (*golden hour*).</p>
            </div>
        </div>
    </div>
</section>

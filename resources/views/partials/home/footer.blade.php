<!-- 9. TIKET.COM STYLE MODERN FOOTER -->
<footer class="bg-white text-slate-600 border-t border-slate-200">
    <!-- Top Value Proposition / Trust Strip (tiket.com Surface Style) -->
    <div class="bg-[#F4F7FB] border-b border-[#E4EBF2] py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Trust Item 1 -->
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-[#E8F3FF] text-[#0064D2] flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Biro Wisata Berlisensi</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Resmi berbadan hukum PT, terdaftar NIB OSS dan HPI Dieng.</p>
                    </div>
                </div>

                <!-- Trust Item 2 -->
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="tag" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Harga Transparan</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Tanpa biaya tersembunyi, paket all-inclusive tiket masuk & armada.</p>
                    </div>
                </div>

                <!-- Trust Item 3 -->
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Transaksi Aman 100%</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Hanya melalui rekening resmi atas nama PT perusahaan.</p>
                    </div>
                </div>

                <!-- Trust Item 4 -->
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#0064D2] flex items-center justify-center shrink-0 shadow-2xs">
                        <i data-lucide="headphones" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Customer Care 24/7</h4>
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Layanan konsultasi perjalanan Dieng ramah dan responsif.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer Body -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
            <!-- Col 1: Tentang TiketDieng (4 cols) -->
            <div class="lg:col-span-4 space-y-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 group focus:outline-none">
                    <img 
                        src="{{ asset('images/logo-tiketdieng-blue-text.png') }}" 
                        alt="{{ $settings->site_name ?? 'TiketDieng' }}" 
                        width="146" 
                        height="36" 
                        class="h-9 w-auto object-contain transition-transform group-hover:scale-105"
                        onerror="this.style.display='none'; var fb = document.getElementById('footerBrandFallback'); if(fb){ fb.classList.remove('hidden'); fb.classList.add('flex'); }"
                    >
                    <div id="footerBrandFallback" class="hidden items-center gap-1.5 font-sans font-extrabold text-2xl tracking-tight text-[#0064D2]">
                        <span>tiket</span>
                        <span class="w-3 h-3 rounded-full bg-[#FEDD00] shadow-sm inline-block"></span>
                        <span class="text-slate-800">Dieng</span>
                    </div>
                </a>

                <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                    {{ $settings->site_tagline }}. Unit operasional resmi di bawah naungan <strong class="text-slate-800 font-semibold">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong>. Menghadirkan reservasi tour Dieng mudah, jeep adventure sunrise Sikunir, shuttle bus, homestay, dan dokumentasi sinematik berstandar pariwisata nasional.
                </p>

                <!-- Legalitas Badges -->
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-[11px] font-semibold">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                        <span>NIB: {{ $settings->legal_nib }}</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#E8F3FF] border border-[#CBDFF5] text-[#0051A8] text-[11px] font-semibold">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-[#0064D2] shrink-0"></i>
                        <span>{{ $settings->hpi_badge ?? 'Lisensi Resmi HPI Dieng' }}</span>
                    </div>
                </div>

                <!-- Social Media Channels -->
                <div class="pt-3">
                    <h5 class="text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2.5">Ikuti Media Sosial Kami:</h5>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <a 
                            href="https://www.instagram.com/tiketwisatadieng?stkn=MWpxamRlbjkxd3I1Yg==" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-pink-50 text-slate-700 hover:text-pink-600 text-xs font-medium border border-slate-200/70 transition-colors"
                        >
                            <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>@tiketwisatadieng</span>
                        </a>

                        <a 
                            href="https://tiktok.com/@tiketdieng.com" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 text-xs font-medium border border-slate-200/70 transition-colors"
                        >
                            <i data-lucide="video" class="w-3.5 h-3.5 text-slate-700"></i>
                            <span>TikTok</span>
                        </a>

                        <a 
                            href="https://www.facebook.com/share/1Hj4SzNUzH/" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-[#0064D2] text-xs font-medium border border-slate-200/70 transition-colors"
                        >
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Col 2: Produk Wisata (3 cols) -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Produk Wisata Dieng</h4>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="#paket" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Paket Tour All-Inclusive Dieng</span>
                        </a>
                    </li>
                    <li>
                        <a href="#scrollytelling" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Golden Sunrise Bukit Sikunir</span>
                        </a>
                    </li>
                    <li>
                        <a href="#paket" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Jeep Safari Adventure 4x4</span>
                        </a>
                    </li>
                    <li>
                        <a href="#dokumentasi" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Dokumentasi Drone & Foto 4K</span>
                        </a>
                    </li>
                    <li>
                        <a href="#paket" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Sewa Shuttle Bus & HiAce</span>
                        </a>
                    </li>
                    <li>
                        <a href="#paket" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Reservasi Homestay & Villa Dieng</span>
                        </a>
                    </li>
                    <li>
                        <a href="#kalkulator" class="hover:text-[#0064D2] transition-colors flex items-center gap-1.5">
                            <i data-lucide="chevron-right" class="w-3 h-3 text-[#0064D2]"></i>
                            <span>Kalkulator Simulasi Biaya</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Kantor (2 cols) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Kontak & Kantor</h4>
                <ul class="space-y-3 text-xs">
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[#0064D2] shrink-0 mt-0.5"></i>
                        <span class="text-slate-600 leading-relaxed">{{ $settings->address ?? 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                        <span class="font-semibold text-slate-800">{{ $settings->phone_number ?? '0816675404' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                        <a 
                            href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="hover:text-[#0064D2] font-medium transition-colors"
                        >
                            {{ $settings->whatsapp_number }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 text-[#0064D2] shrink-0"></i>
                        <span class="text-slate-600">{{ $settings->email ?? 'tiket.wisatadieng@gmail.com' }}</span>
                    </li>
                    <li class="flex items-center gap-2 text-slate-500 pt-1">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-500 shrink-0"></i>
                        <span>Buka Setiap Hari (24 Jam)</span>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Keamanan Transaksi & Rekening Resmi (3 cols) -->
            <div class="lg:col-span-3 space-y-3">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Keamanan Transaksi</h4>
                
                <!-- Rekening Box -->
                <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-[#E4EBF2] space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#0064D2] flex items-center gap-1.5">
                            <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                            <span>Rekening Resmi Pembayaran:</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Terverifikasi</span>
                    </div>
                    <div>
                        <div class="text-sm font-mono font-extrabold text-slate-900 tracking-wider">BNI: 8166754042</div>
                        <div class="text-[11px] font-semibold text-slate-700">a.n. PT. GOTRIP ASIA TRAVELINDO</div>
                        <div class="text-[10px] text-slate-500">Kantor Cabang Wonosobo</div>
                    </div>
                    <p class="text-[10px] text-amber-700 bg-amber-50 border border-amber-200/80 p-2 rounded-lg leading-relaxed">
                        ⚠️ Demi keamanan Anda, jangan pernah mentransfer dana ke rekening pribadi atas nama perorangan.
                    </p>
                </div>

                <!-- Metode Pembayaran & Keamanan -->
                <div class="pt-1">
                    <span class="text-[11px] font-semibold text-slate-600 block mb-1.5">Metode Pembayaran Didukung:</span>
                    <div class="flex flex-wrap items-center gap-1.5 text-[10px] font-bold">
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">BNI</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">BCA</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">Mandiri</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">BRI</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">QRIS</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar: Copyright & Attribution -->
        <div class="pt-8 mt-10 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p class="text-center sm:text-left">
                © {{ date('Y') }} <strong class="text-slate-700 font-semibold">{{ $settings->site_name }}</strong> • {{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }} • NIB: <span class="font-medium text-slate-700">{{ $settings->legal_nib }}</span>. Hak cipta dilindungi undang-undang.
            </p>
            <div class="flex items-center gap-1.5 text-center sm:text-right shrink-0">
                <span>Dikelola dengan bangga oleh</span>
                <a 
                    href="https://soulofjava.github.io/myportofolio/" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    class="text-slate-700 hover:text-[#0064D2] font-semibold underline underline-offset-2 decoration-blue-300 hover:decoration-[#0064D2] transition-colors"
                >
                    soulofjava labs
                </a>
            </div>
        </div>
    </div>
</footer>
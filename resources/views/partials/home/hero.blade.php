<!-- 2. HERO PARALLAX SINEMATIK: GOLDEN DAWN SIKUNIR -->
    <section class="relative min-h-[110vh] w-full overflow-hidden bg-gradient-to-b from-[#060911] via-[#0d1527] to-[#07090e] flex items-center justify-center pt-20">
        <!-- Sky Atmosphere Glow -->
        <div class="absolute inset-0 z-0 opacity-40 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(245,158,11,0.25),rgba(255,255,255,0))]"></div>

        <!-- Rising Golden Sun (Sikunir Dawn) -->
        <div class="absolute top-[18%] left-1/2 -translate-x-1/2 w-72 h-72 sm:w-96 sm:h-96 rounded-full bg-gradient-to-t from-amber-500 via-orange-400 to-yellow-200 blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute top-[28%] left-1/2 -translate-x-1/2 w-40 h-40 sm:w-56 sm:h-56 rounded-full bg-gradient-to-b from-amber-100 via-amber-300 to-orange-500 shadow-[0_0_90px_rgba(245,158,11,0.7)] pointer-events-none flex items-center justify-center opacity-90 animate-pulse-slow"></div>

        <!-- Siluet Gunung Sindoro & Sumbing -->
        <div class="absolute bottom-0 left-0 right-0 h-[60%] pointer-events-none opacity-40">
            <svg viewBox="0 0 1440 600" fill="none" class="w-full h-full object-cover" preserveAspectRatio="none">
                <path d="M0 600L180 320L340 440L600 160L820 400L1080 220L1260 380L1440 300V600H0Z" fill="url(#mountainGradBack)" />
                <defs>
                    <linearGradient id="mountainGradBack" x1="720" y1="160" x2="720" y2="600" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#283553" />
                        <stop offset="1" stop-color="#080c16" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Siluet Puncak Dekat Bukit Sikunir & Prau -->
        <div class="absolute bottom-0 left-0 right-0 h-[48%] pointer-events-none">
            <svg viewBox="0 0 1440 500" fill="none" class="w-full h-full object-cover opacity-80" preserveAspectRatio="none">
                <path d="M0 500L220 280L420 380L700 210L940 360L1200 190L1440 340V500H0Z" fill="url(#mountainGradMid)" />
                <defs>
                    <linearGradient id="mountainGradMid" x1="720" y1="190" x2="720" y2="500" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#1a253a" />
                        <stop offset="1" stop-color="#07090e" />
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <!-- Kabut Mengambang -->
        <div class="absolute bottom-0 left-0 right-0 h-80 pointer-events-none">
            <div class="w-full h-full bg-gradient-to-t from-[#07090e] via-[#0b1424]/70 to-transparent blur-xl"></div>
        </div>

        <!-- Editorial Hero Content -->
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <!-- Top Badges: Badan Usaha Resmi, HPI License & Live Dieng Atmosphere -->
            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3.5 mb-6">
                <!-- Badge Badan Usaha Resmi PT. GOTRIP ASIA TRAVELINDO -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-amber-500/30 bg-amber-500/10 text-amber-300 text-xs font-semibold tracking-wider uppercase shadow-lg shadow-amber-500/10">
                    <i data-lucide="building-2" class="w-4 h-4 text-amber-400"></i>
                    <span>{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</span>
                    <span class="text-[10px] text-slate-400 border-l border-white/15 pl-2 font-normal hidden sm:inline capitalize">Akomodasi & Transportasi Wisata</span>
                </div>

                <!-- Badge Resmi HPI -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-xs font-semibold tracking-wider uppercase shadow-lg shadow-emerald-500/10">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>{{ $settings->hpi_badge ?? 'Biro Wisata Resmi Berizin HPI' }}</span>
                </div>

                <!-- Live Weather Dieng Atmospheric Pill -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full glass-panel border border-sky-400/25 bg-sky-950/20 text-slate-200 text-xs shadow-lg shadow-sky-500/5 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <i data-lucide="cloud-sun" class="w-4 h-4 text-sky-400"></i>
                    <span class="text-slate-300">
                        Live Dieng: <strong class="text-white font-bold tracking-tight" id="diengTemp">18°C</strong> • <span id="diengCondition" class="text-sky-300 font-medium">Cerah Sejuk</span>
                    </span>
                    <span class="hidden sm:inline text-[10px] text-slate-400 border-l border-white/10 pl-2">2.093 mdpl</span>
                </div>
            </div>

            <!-- Title Sinematik -->
            <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-[1.1] max-w-4xl drop-shadow-2xl">
                Menyaksikan Mahakarya <br />
                <span class="bg-gradient-to-r from-amber-200 via-yellow-400 to-amber-500 bg-clip-text text-transparent">
                    Fajar Emas di Atas Awan
                </span>
            </h1>

            <p class="mt-6 text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl font-light leading-relaxed drop-shadow">
                Jelajahi keajaiban vulkanik purba, samudra awan Sikunir 2.463 mdpl, telaga warna berkilau, dan petualangan jip offroad dengan standar kenyamanan VIP.
            </p>

            <!-- Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center gap-4">
                <a href="#kalkulator" class="w-full sm:w-auto px-8 py-4 rounded-full text-xs sm:text-sm font-bold tracking-wider uppercase text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-xl shadow-amber-500/30 hover:scale-105 flex items-center justify-center gap-2.5">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>Rencanakan Perjalanan</span>
                </a>
                <a href="#scrollytelling" class="w-full sm:w-auto px-8 py-4 rounded-full text-xs sm:text-sm font-semibold tracking-wider text-white glass-panel hover:bg-white/10 transition-all duration-300 border border-white/20 flex items-center justify-center gap-2">
                    <i data-lucide="compass" class="w-4 h-4 text-amber-400"></i>
                    <span>Eksplorasi Cerita</span>
                </a>
            </div>

            <!-- Mini Trust Badges -->
            <div class="mt-14 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8 pt-8 border-t border-white/10 text-slate-400 text-xs">
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="mountain" class="w-4 h-4 text-amber-400"></i>
                    <span>Ketinggian 2.000+ mdpl</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="sun" class="w-4 h-4 text-amber-400"></i>
                    <span>Golden Sunrise Sikunir</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                    <span>Pemandu Berlisensi HPI</span>
                </div>
                <div class="flex items-center gap-2 justify-center">
                    <i data-lucide="map-pin" class="w-4 h-4 text-amber-400"></i>
                    <span>Armada Antar-Jemput VIP</span>
                </div>
            </div>
        </div>
    </section>

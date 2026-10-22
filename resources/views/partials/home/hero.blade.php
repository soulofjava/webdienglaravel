<!-- 2. HERO BANNER TIKET.COM STYLE: VIBRANT TIKET BLUE CURVED HERO -->
<section class="relative bg-gradient-to-r from-[#0064D2] via-[#0052B4] to-[#00408F] text-white rounded-b-[2.5rem] pt-32 pb-24 sm:pb-28 relative overflow-hidden shadow-xl">
    <!-- Decorative Ambient Glow & Geometric Wave (tiket.com Passport Design) -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Soft Golden Accent Glow (tiket Yellow) -->
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-[#FEDD00]/15 blur-3xl"></div>
        <div class="absolute top-1/2 -left-20 w-80 h-80 rounded-full bg-sky-300/10 blur-3xl"></div>

        <!-- Subtle Topography & Mountain Waves Silhouettes -->
        <div class="absolute bottom-0 left-0 right-0 h-44 opacity-15 pointer-events-none">
            <svg viewBox="0 0 1440 320" fill="none" class="w-full h-full object-cover" preserveAspectRatio="none">
                <path d="M0,192L48,176C96,160,192,128,288,138.7C384,149,480,203,576,202.7C672,203,768,149,864,144C960,139,1056,181,1152,192C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="#ffffff"></path>
            </svg>
        </div>
    </div>

    <!-- Hero Content Header -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
        <!-- Badges Bar: Resmi Badan Usaha, Lisensi HPI & Live Weather -->
        <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-6">
            <!-- Badge PT. GOTRIP ASIA TRAVELINDO -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-semibold tracking-wide shadow-sm">
                <i data-lucide="building-2" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                <span>{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</span>
                <span class="text-[10px] text-blue-100 border-l border-white/25 pl-2 font-normal hidden sm:inline">Biro Perjalanan Resmi</span>
            </div>

            <!-- Badge Lisensi HPI -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-semibold tracking-wide shadow-sm">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-300"></i>
                <span>{{ $settings->hpi_badge ?? 'Biro Wisata Resmi Berizin HPI' }}</span>
            </div>

            <!-- Live Weather Dieng (ID diengTemp & diengCondition preserved for JavaScript) -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-medium shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                <i data-lucide="cloud-sun" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                <span>
                    Live Dieng: <strong class="text-white font-bold" id="diengTemp">18°C</strong> • <span id="diengCondition" class="text-sky-200">Cerah Sejuk</span>
                </span>
                <span class="hidden sm:inline text-[10px] text-blue-200 border-l border-white/25 pl-2">2.093 mdpl</span>
            </div>
        </div>

        <!-- Main Headline -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.15] max-w-4xl drop-shadow-sm">
            Eksplorasi Keajaiban Dieng <br class="hidden sm:inline" />
            <span class="text-[#FEDD00]">Fajar Emas di Atas Awan</span>
        </h1>

        <!-- Subheading -->
        <p class="mt-4 sm:mt-5 text-sm sm:text-base lg:text-lg text-blue-50 max-w-2xl font-normal leading-relaxed">
            Jelajahi samudra awan Sikunir, kawah vulkanik Sikidang, telaga warna berkilau, dan petualangan jip offroad dengan kenyamanan VIP dan pemandu lokal berlisensi.
        </p>

        <!-- Trust Features Mini Bar -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4 sm:gap-8 text-xs font-medium text-blue-100">
            <div class="flex items-center gap-1.5">
                <i data-lucide="award" class="w-4 h-4 text-[#FEDD00]"></i>
                <span>Biro Berizin Resmi</span>
            </div>
            <div class="flex items-center gap-1.5">
                <i data-lucide="sun" class="w-4 h-4 text-[#FEDD00]"></i>
                <span>Golden Sunrise Sikunir</span>
            </div>
            <div class="flex items-center gap-1.5">
                <i data-lucide="car" class="w-4 h-4 text-[#FEDD00]"></i>
                <span>Armada Antar-Jemput VIP</span>
            </div>
            <div class="flex items-center gap-1.5">
                <i data-lucide="shield-check" class="w-4 h-4 text-[#FEDD00]"></i>
                <span>Jaminan Reschedule Aman</span>
            </div>
        </div>
    </div>
</section>

<!-- 3. FLOATING SEARCH & FILTER BOOKING WIDGET (TIKET.COM PASSPORT STYLE) -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
    <div
        id="heroBookingWidget"
        class="bg-white rounded-3xl shadow-xl border border-slate-100 p-5 sm:p-7 -mt-16 sm:-mt-18 relative text-slate-800"
        x-data="{
            activeTab: 'all',
            filterText: '',
            selectedPickup: 'Wonosobo (Pusat Kota / Stasiun / Homestay)',
            selectedPax: '2-4 Orang (Keluarga / Teman)',
            switchCategory(category) {
                this.activeTab = category;
                window.dispatchEvent(new CustomEvent('filter-package-category', { detail: category }));
            },
            searchPackages() {
                window.dispatchEvent(new CustomEvent('filter-package-category', { detail: this.activeTab }));
                const target = document.getElementById('paket');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }"
    >
        <!-- Category Pill Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-3 sm:pb-4 border-b border-slate-100 no-scrollbar">
            <button
                @click="switchCategory('all')"
                type="button"
                class="px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer"
                :class="activeTab === 'all'
                    ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/20'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
                <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                <span>Semua Paket</span>
            </button>

            <button
                @click="switchCategory('Family Tour')"
                type="button"
                class="px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer"
                :class="activeTab === 'Family Tour'
                    ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/20'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                <span>Family Tour</span>
            </button>

            <button
                @click="switchCategory('Offroad Jeep')"
                type="button"
                class="px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer"
                :class="activeTab === 'Offroad Jeep'
                    ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/20'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
                <i data-lucide="car" class="w-3.5 h-3.5"></i>
                <span>Offroad Jeep</span>
            </button>

            <button
                @click="switchCategory('Sunrise Sikunir')"
                type="button"
                class="px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 flex-shrink-0 cursor-pointer"
                :class="activeTab === 'Sunrise Sikunir'
                    ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/20'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
            >
                <i data-lucide="sun" class="w-3.5 h-3.5"></i>
                <span>Sunrise Sikunir</span>
            </button>
        </div>

        <!-- Floating Search Input Form Controls -->
        <div class="mt-4 sm:mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
            <!-- 1. Destinasi / Pilihan Spot -->
            <div class="bg-slate-50 hover:bg-slate-100/80 transition-colors p-3 rounded-2xl border border-slate-200/80 focus-within:border-[#0064D2] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#0064D2]/20">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                    <span>Tujuan / Destinasi</span>
                </label>
                <select
                    x-model="activeTab"
                    @change="switchCategory($event.target.value)"
                    class="w-full bg-transparent border-none p-0 text-xs sm:text-sm font-semibold text-slate-800 focus:ring-0 cursor-pointer"
                >
                    <option value="all">Semua Wisata Dieng</option>
                    <option value="Sunrise Sikunir">Bukit Sikunir (Golden Sunrise)</option>
                    <option value="Family Tour">Keluarga & Edukasi Candi</option>
                    <option value="Offroad Jeep">Jeep Safari Lava & Telaga</option>
                    <option value="Paket 1 Hari">Paket 1 Hari (One Day Tour)</option>
                    <option value="Paket 2H1M">Paket 2 Hari 1 Malam (Homestay)</option>
                </select>
            </div>

            <!-- 2. Titik Penjemputan -->
            <div class="bg-slate-50 hover:bg-slate-100/80 transition-colors p-3 rounded-2xl border border-slate-200/80 focus-within:border-[#0064D2] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#0064D2]/20">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <i data-lucide="navigation" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                    <span>Titik Jemput</span>
                </label>
                <select
                    x-model="selectedPickup"
                    class="w-full bg-transparent border-none p-0 text-xs sm:text-sm font-semibold text-slate-800 focus:ring-0 cursor-pointer"
                >
                    <option value="Wonosobo (Pusat Kota / Stasiun / Homestay)">Wonosobo (Gratis Antar-Jemput)</option>
                    <option value="Yogyakarta (Bandara YIA / Stasiun Tugu)">Yogyakarta (YIA / Tugu / Lempuyangan)</option>
                    <option value="Semarang (Bandara / Stasiun Tawang)">Semarang (Bandara / Stasiun Tawang)</option>
                    <option value="Purwokerto (Stasiun Purwokerto)">Purwokerto (Stasiun Purwokerto)</option>
                    <option value="Solo (Bandara SOC / Stasiun Balapan)">Solo (Stasiun Balapan / SOC)</option>
                </select>
            </div>

            <!-- 3. Jumlah Peserta -->
            <div class="bg-slate-50 hover:bg-slate-100/80 transition-colors p-3 rounded-2xl border border-slate-200/80 focus-within:border-[#0064D2] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#0064D2]/20">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <i data-lucide="users" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                    <span>Jumlah Peserta</span>
                </label>
                <select
                    x-model="selectedPax"
                    class="w-full bg-transparent border-none p-0 text-xs sm:text-sm font-semibold text-slate-800 focus:ring-0 cursor-pointer"
                >
                    <option value="1-2 Orang (Couple / Privat)">1 - 2 Orang (Privat Couple)</option>
                    <option value="2-4 Orang (Keluarga / Teman)">2 - 4 Orang (Keluarga Inti)</option>
                    <option value="5-7 Orang (Family Group)">5 - 7 Orang (Family Group)</option>
                    <option value="8-14 Orang (HiAce Group)">8 - 14 Orang (HiAce VIP)</option>
                    <option value="15+ Orang (Rombongan / Bus)">15+ Orang (Rombongan Bus)</option>
                </select>
            </div>

            <!-- 4. Tombol Cari Paket CTA -->
            <div>
                <button
                    @click="searchPackages()"
                    type="button"
                    class="w-full py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-extrabold text-white bg-[#0064D2] hover:bg-[#0051a8] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 cursor-pointer h-[58px]"
                >
                    <i data-lucide="search" class="w-4 h-4 text-[#FEDD00]"></i>
                    <span>Cari Paket Wisata</span>
                </button>
            </div>
        </div>

        <!-- Quick Suggestions Pill -->
        <div class="mt-3.5 pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
            <span class="font-bold text-slate-700 flex items-center gap-1">
                <i data-lucide="sparkles" class="w-3 h-3 text-[#FEDD00]"></i>
                <span>Paling Dicari:</span>
            </span>
            <button
                @click="switchCategory('Sunrise Sikunir'); searchPackages()"
                type="button"
                class="hover:text-[#0064D2] hover:underline underline-offset-2"
            >
                Bukit Sikunir 2D1N
            </button>
            <span>•</span>
            <button
                @click="switchCategory('Offroad Jeep'); searchPackages()"
                type="button"
                class="hover:text-[#0064D2] hover:underline underline-offset-2"
            >
                Jeep Lava Kawah Sikidang
            </button>
            <span>•</span>
            <button
                @click="switchCategory('Family Tour'); searchPackages()"
                type="button"
                class="hover:text-[#0064D2] hover:underline underline-offset-2"
            >
                Telaga Warna & Candi Arjuna
            </button>
            <span>•</span>
            <a
                href="#kalkulator"
                class="text-[#0064D2] font-semibold hover:underline flex items-center gap-1 ml-auto"
            >
                <i data-lucide="calculator" class="w-3 h-3"></i>
                <span>Simulasi Biaya</span>
            </a>
        </div>
    </div>
</div>

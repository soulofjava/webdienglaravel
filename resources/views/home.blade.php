@extends('layouts.app')

@section('content')
<main class="relative min-h-screen bg-[#07090e] text-slate-100 overflow-hidden">

    <!-- 1. FLOATING ATMOSPHERIC NAVIGATION -->
    <header id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div id="navContainer" class="max-w-7xl mx-auto rounded-2xl transition-all duration-500 bg-black/30 backdrop-blur-md py-4 px-5 sm:px-8 border border-white/5">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 via-amber-600 to-emerald-700 flex items-center justify-center p-0.5 shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-[#090d16] rounded-[10px] flex items-center justify-center">
                            <i data-lucide="compass" class="w-5 h-5 text-amber-400 group-hover:rotate-45 transition-transform duration-500"></i>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-serif tracking-wider text-xl font-bold bg-gradient-to-r from-amber-200 via-white to-amber-300 bg-clip-text text-transparent">
                                {{ $settings->site_name }}
                            </span>
                            <span class="text-[10px] uppercase font-bold tracking-widest px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                RESMI
                            </span>
                        </div>
                        <p class="text-[10px] text-slate-400 tracking-wider">{{ $settings->site_tagline }}</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                    <a href="#scrollytelling" class="hover:text-amber-400 transition-colors flex items-center gap-1">
                        <span>Jelajah Cerita</span>
                    </a>
                    <a href="#destinasi" class="hover:text-amber-400 transition-colors">Destinasi</a>
                    <a href="#paket" class="hover:text-amber-400 transition-colors">Paket Wisata</a>
                    <a href="#kalkulator" class="hover:text-amber-400 transition-colors">Kalkulator Biaya</a>
                    <a href="{{ route('admin.login') }}" class="text-xs text-slate-500 hover:text-amber-400/80 transition-colors">Akses Admin</a>
                </nav>

                <!-- Right Section: Live Weather & CTA -->
                <div class="hidden lg:flex items-center gap-4">
                    <!-- Live Weather Dieng HUD (Open-Meteo Real-Time) -->
                    <div class="flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs text-slate-300">
                        <i data-lucide="cloud-fog" class="w-4 h-4 text-sky-400 animate-pulse"></i>
                        <span id="diengWeatherText">
                            Dieng: <strong class="text-white font-semibold" id="diengTemp">11°C</strong> • <span id="diengCondition">Kabut Sejuk</span>
                        </span>
                    </div>

                    <!-- CTA Button -->
                    <a href="#kalkulator" class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <span>Pesan Tiket</span>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 text-slate-200 hover:bg-white/10 transition-colors" aria-label="Buka Menu">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Mobile Drawer -->
            <div id="mobileMenu" class="hidden md:hidden pt-4 pb-2 border-t border-white/10 mt-3 flex flex-col gap-3">
                <a href="#scrollytelling" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Jelajah Cerita Dieng</a>
                <a href="#paket" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Paket Wisata All-Inclusive</a>
                <a href="#kalkulator" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Kalkulator Reservasi</a>
                <a href="{{ route('admin.login') }}" class="text-xs py-1.5 text-slate-500">Panel Pengelola Admin</a>
                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="w-full text-center block px-4 py-2.5 rounded-xl text-xs font-bold text-black bg-amber-400">
                        Chat WhatsApp Resmi
                    </a>
                </div>
            </div>
        </div>
    </header>

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
            <!-- Badge Resmi -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-amber-500/30 text-amber-300 text-xs font-semibold tracking-wider uppercase mb-6 shadow-lg shadow-amber-500/10">
                <i data-lucide="shield-check" class="w-4 h-4 text-amber-400"></i>
                <span>{{ $settings->hpi_badge ?? 'Biro Wisata Resmi Berizin HPI' }}</span>
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

    <!-- 3. SCROLLYTELLING: CERITA SINEMATIK 5 BABAK DIAENG -->
    <section id="scrollytelling" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Jelajah Cerita Magis</span>
            <h2 class="font-serif text-3xl sm:text-5xl font-black text-white mt-2 mb-4">
                5 Babak Keajaiban Dataran Tinggi Para Dewa
            </h2>
            <p class="text-xs sm:text-sm text-slate-400">
                Setiap sudut Dieng menyimpan rahasia geologi purba dan spiritualitas yang memikat hati.
            </p>
        </div>

        <div class="space-y-24">
            <!-- Babak 1: Sikunir -->
            <div id="sikunir" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 border border-amber-500/30 text-amber-300">
                        <i data-lucide="sunrise" class="w-4 h-4 text-amber-400"></i>
                        <span>BAB 01 • 2.463 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Matahari Pertama di Puncak Sikunir</h3>
                    <p class="text-xs text-amber-300 italic">“Ketika fajar menyingsing di Sikunir, samudra awan di bawah Anda menjelma emas murni.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Dari bibir puncak Bukit Sikunir di Desa Sembungan (desa tertinggi di Pulau Jawa), Anda akan menyaksikan fajar keemasan perlahan menembus lautan awan dengan latar belakang siluet megah delapan puncak gunung legendaris Jawa Tengah.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Pendakian santai 30–40 menit dengan anak tangga rapi</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Panorama 360° Gunung Sindoro, Sumbing, Merbabu, Merapi</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-amber-400"></i> Hangatnya teh purwaceng khas desa tertinggi</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=75" alt="Sikunir Sunrise" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>

            <!-- Babak 2: Kawah Sikidang -->
            <div id="sikidang" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10 order-2 lg:order-1">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=75" alt="Kawah Sikidang" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                <div class="lg:col-span-6 space-y-5 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/10 border border-yellow-500/30 text-yellow-300">
                        <i data-lucide="flame" class="w-4 h-4 text-yellow-400"></i>
                        <span>BAB 02 • 2.050 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Napas Hangat Sang Hyang di Kawah Sikidang</h3>
                    <p class="text-xs text-yellow-300 italic">“Di sini, Anda dapat mendengar gemuruh magma bumi yang hidup dan kepulan uap belerang.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Dinamakan 'Sikidang' karena letak kawah utamanya yang kerap berpindah tempat menyerupai lompatan kijang. Berjalan di atas jembatan kayu estetik sepanjang satu kilometer membelah kepulan kabut sulfur putih menghadirkan lanskap megah layaknya dataran purba.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Jembatan kayu ikonik yang membelah tanah vulkanik</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Pengalaman merebus telur di dalam kawah alami</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-yellow-400"></i> Wahana ATV & spot foto eksotis di dataran belerang</li>
                    </ul>
                </div>
            </div>

            <!-- Babak 3: Telaga Warna & Pengilon -->
            <div id="telagawarna" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 border border-emerald-500/30 text-emerald-300">
                        <i data-lucide="droplets" class="w-4 h-4 text-emerald-400"></i>
                        <span>BAB 03 • 2.000 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Simfoni Zamrud di Telaga Warna & Pengilon</h3>
                    <p class="text-xs text-emerald-300 italic">“Dua danau berdampingan dengan warna air toska berkilau dan cermin jernih alami.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Kandungan mineral sulfur yang tinggi membiaskan spektrum warna hijau toska, toska pekat, hingga keemasan saat terkena sinar matahari. Dikelilingi rimbunnya hutan cemara gunung dan gua-gua pertapaan bersejarah.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Panorama dua danau dari Batu Pandang Ratapan Angin</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Gua Semar, Gua Jaran, dan Gua Sumur penuh sejarah mistis</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400"></i> Jalur trekking rindang di bawah kanopi cemara gunung</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=75" alt="Telaga Warna" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>

            <!-- Babak 4: Kompleks Candi Arjuna -->
            <div id="candi-arjuna" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10 order-2 lg:order-1">
                    <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=75" alt="Candi Arjuna" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                <div class="lg:col-span-6 space-y-5 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-purple-500/10 border border-purple-500/30 text-purple-300">
                        <i data-lucide="landmark" class="w-4 h-4 text-purple-400"></i>
                        <span>BAB 04 • 2.093 MDPL</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Jejak Peradaban Suci di Lembah Arjuna</h3>
                    <p class="text-xs text-purple-300 italic">“Percandian Hindu tertua di Jawa dari abad ke-7 yang berdiri kokoh berpagar kabut.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Lima mahakarya batu candi (Arjuna, Semar, Srikandi, Puntadewa, dan Sembadra) menjadi saksi bisu ritual sakral pemotongan rambut gimbal anak-anak Dieng dalam tradisi Dieng Culture Festival.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Fenomena kristal es 'Embun Upas' saat musim dingin (Juli–Agustus)</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Arsitektur batu andesit purba dengan relief relief Dewa Siwa</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-purple-400"></i> Padang rumput hijau menyejukkan di pelataran percandian</li>
                    </ul>
                </div>
            </div>

            <!-- Babak 5: Safari Jip 4x4 -->
            <div id="jeep" class="glass-panel rounded-3xl overflow-hidden border border-white/10 grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
                <div class="lg:col-span-6 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 border border-rose-500/30 text-rose-300">
                        <i data-lucide="compass" class="w-4 h-4 text-rose-400"></i>
                        <span>BAB 05 • ADRENALIN 4X4</span>
                    </div>
                    <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white">Safari Jip 4x4 Melintasi Hutan & Savana</h3>
                    <p class="text-xs text-rose-300 italic">“Rasakan denyut petualangan melewati jalur bebatuan, kebun teh, hingga danau tersembunyi.”</p>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Armada Jeep 4x4 tangguh siap membawa Anda ke destinasi yang tak terjangkau kendaraan biasa: Telaga Dringo (Ranu Kumbolo-nya Jawa Tengah), perkebunan teh Bedakah, dan Savana Lembah Pangonan.
                    </p>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Unit Jeep 4x4 berspesifikasi offroad dengan driver terlatih</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Rute fleksibel (Short, Medium, & Long Safari Trip)</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-rose-400"></i> Sesi pemotretan estetik di atas kap mesin berlatar pegunungan</li>
                    </ul>
                </div>
                <div class="lg:col-span-6 rounded-2xl overflow-hidden h-72 sm:h-96 relative border border-white/10">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=75" alt="Safari Jip 4x4" loading="lazy" decoding="async" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PAKET WISATA UNGGULAN ALL-INCLUSIVE -->
    <section id="paket" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Pilihan Paket Wisata Resmi</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-4">Paket All-Inclusive Tanpa Beban Tersembunyi</h2>
            <p class="text-xs sm:text-sm text-slate-400">Seluruh program terintegrasi mencakup armada transportasi ber-AC, pemandu lokal ramah, tiket masuk VIP objek wisata, dan kuliner khas Wonosobo-Dieng.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($packages as $pkg)
                <div class="glass-panel p-6 rounded-3xl border {{ $pkg->is_popular ? 'border-2 border-amber-400/80 shadow-2xl shadow-amber-500/10' : 'border-white/10' }} flex flex-col justify-between hover:border-amber-400/60 transition-all duration-300 relative group">
                    @if ($pkg->is_popular || $pkg->badge)
                        <div class="absolute -top-3.5 left-6 px-3 py-0.5 rounded-full text-[10px] font-black uppercase {{ $pkg->is_popular ? 'bg-amber-400 text-slate-950' : 'bg-emerald-400 text-slate-950' }} shadow-md">
                            {{ $pkg->badge ?: 'PALING DIMINATI ★' }}
                        </div>
                    @endif

                    <div>
                        <!-- Thumbnail Cover -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10] mb-4 border border-white/5">
                            <img
                                src="{{ $pkg->image_url }}"
                                alt="{{ $pkg->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                                decoding="async"
                            />
                            <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] text-amber-300 font-semibold border border-white/10">
                                {{ $pkg->duration }}
                            </div>
                        </div>

                        <span class="text-[10px] font-bold text-amber-400 tracking-wider uppercase block">
                            {{ $pkg->category }}
                        </span>
                        <h3 class="font-bold text-lg text-white mt-1 group-hover:text-amber-300 transition-colors line-clamp-1">
                            <a href="{{ route('package.detail', $pkg->slug) }}">
                                {{ $pkg->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                            {{ $pkg->summary }}
                        </p>

                        <!-- Estimasi Tarif -->
                        <div class="my-4 pt-3 border-t border-white/10">
                            <span class="text-[11px] text-slate-400 block">Estimasi Tarif</span>
                            <div class="text-2xl font-extrabold text-amber-400">
                                {{ $pkg->formatted_price }}
                                <span class="text-xs text-slate-400 font-normal">/ pax</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block mt-0.5">{{ $pkg->price_note }}</span>
                        </div>

                        <!-- Highlight Destinasi / Rute -->
                        @if (!empty($pkg->itinerary_options) && count($pkg->itinerary_options) > 0)
                            <div class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                <div class="text-[10px] font-semibold text-slate-400 uppercase">Pilihan Rute & Destinasi:</div>
                                @foreach (array_slice($pkg->itinerary_options, 0, 2) as $opt)
                                    <div class="flex items-start gap-1.5 text-[11px] text-slate-300">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                                        <span class="line-clamp-1 font-medium">{{ $opt['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif (!empty($pkg->inclusions) && count($pkg->inclusions) > 0)
                            <ul class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                @foreach (array_slice($pkg->inclusions, 0, 3) as $inc)
                                    <li class="flex items-center gap-1.5 text-[11px]">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 flex-shrink-0"></i>
                                        <span class="line-clamp-1">{{ $inc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a
                            href="{{ route('package.detail', $pkg->slug) }}"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-white bg-white/10 hover:bg-white/20 border border-white/10 transition-colors flex items-center justify-center gap-1"
                        >
                            <span>Detail Rute</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>

                        <a
                            href="#kalkulator"
                            onclick="selectPackageInCalculator('{{ $pkg->slug }}')"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-400 transition-all flex items-center justify-center gap-1"
                        >
                            <span>Pesan Sekarang</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 glass-panel rounded-3xl border border-white/10 text-slate-400 text-sm">
                    Belum ada paket wisata aktif. Silakan tambahkan melalui panel pengelola admin.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. STANDAR LAYANAN VIP (WHY US) -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Mengapa Memilih {{ $settings->site_name }}?</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-4">Standar Layanan Wisata Kelas VIP</h2>
            <p class="text-xs sm:text-sm text-slate-400">Kami mendefinisikan kembali kenyamanan berwisata di Dieng dengan keaslian narasi lokal dan fasilitas prima.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center mb-5 text-amber-400">
                    <i data-lucide="compass" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Putra Daerah Asli Dieng</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Seluruh pemandu kami lahir dan besar di dataran tinggi Dieng. Sangat memahami rahasia cuaca, sudut foto terbaik, dan kearifan sejarah lokal.</p>
            </div>

            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-sky-500/10 flex items-center justify-center mb-5 text-sky-400">
                    <i data-lucide="video" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Dokumentasi Drone & Kamera Gratis</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Dapatkan rekaman sinematik berkualitas 4K tanpa biaya ekstra. Siap dibagikan langsung di media sosial Instagram & TikTok pribadi Anda.</p>
            </div>

            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center mb-5 text-emerald-400">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Garansi Tiket VIP Bebas Antre</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Seluruh tiket masuk destinasi telah kami siapkan di muka. Tidak perlu membuang waktu mengantre di loket wisata yang ramai.</p>
            </div>

            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 flex items-center justify-center mb-5 text-orange-400">
                    <i data-lucide="coffee" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Kuliner Autentik Khas Dieng</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Nikmati Mie Ongklok legendaris Wonosobo, tempe kemul hangat gurih, seduhan purwaceng penghangat tubuh, dan manisan carica segar.</p>
            </div>

            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center mb-5 text-purple-400">
                    <i data-lucide="heart-handshake" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Layanan Eksekutif Ramah</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Armada kendaraan bersih ber-AC terawat, fasilitas selimut di mobil, air mineral tanpa batas, serta keramahan masyarakat pegunungan.</p>
            </div>

            <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 flex items-center justify-center mb-5 text-rose-400">
                    <i data-lucide="award" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-base text-white mb-2">Legalitas Biro Wisata Resmi</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">Operasional berizin NIB resmi dengan lisensi Himpunan Pramuwisata Indonesia (HPI) untuk memastikan keselamatan setiap tamu.</p>
            </div>
        </div>
    </section>

    <!-- 6. SMART BOOKING CALCULATOR & SIMULATOR HARGA INTERAKTIF -->
    <section id="kalkulator" class="py-24 sm:py-32 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="relative rounded-3xl p-6 sm:p-10 lg:p-12 glass-panel border border-white/15 shadow-2xl overflow-hidden">
            <!-- Glow background -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                    <i data-lucide="calculator" class="w-3.5 h-3.5"></i>
                    <span>Simulator Reservasi Cepat</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl font-black text-white">Kalkulator Estimasi Biaya Wisata</h2>
                <p class="text-xs sm:text-sm text-slate-400 mt-2">Transparan tanpa biaya terselubung. Hitung estimasi seketika dan lanjutkan pemesanan via WhatsApp Resmi.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Form Input Parameter -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Pilihan Paket -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">1. Pilih Paket Wisata</label>
                        <select id="calcPkg" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            @foreach ($packages as $pkg)
                                <option
                                    value="{{ $pkg->slug }}"
                                    data-price="{{ $pkg->price }}"
                                    data-jeep="{{ str_contains(strtolower($pkg->category . ' ' . $pkg->title), 'jeep') ? '1' : '0' }}"
                                    data-duration="{{ $pkg->duration }}"
                                    {{ $pkg->is_popular ? 'selected' : '' }}
                                >
                                    {{ $pkg->title }} — {{ $pkg->formatted_price }} ({{ $pkg->duration }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jumlah Peserta -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-300">2. Jumlah Peserta</label>
                            <span id="paxDisplay" class="text-xs font-bold text-amber-400">4 Orang</span>
                        </div>
                        <input id="calcPax" type="range" min="1" max="25" value="4" aria-label="Jumlah Peserta Wisata" class="w-full accent-amber-400 cursor-pointer">
                        <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                            <span>1 Orang</span>
                            <span>10 Orang (Diskon 10%)</span>
                            <span>25 Orang (Rombongan)</span>
                        </div>
                    </div>

                    <!-- Titik Penjemputan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">3. Lokasi Titik Penjemputan (Meeting Point)</label>
                        <select id="calcMeeting" class="w-full p-3.5 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:outline-none transition-colors cursor-pointer">
                            <option value="Wonosobo / Terminal Mendolo" data-surcharge="0" selected>Kota Wonosobo / Terminal Mendolo (Gratis / Standar)</option>
                            <option value="Purwokerto (Stasiun / Terminal)" data-surcharge="50000">Purwokerto — Stasiun / Terminal Bulupitu (+Rp 50.000/org)</option>
                            <option value="Yogyakarta (Stasiun Tugu / Lempuyangan / YIA)" data-surcharge="100000">Yogyakarta — Stasiun Tugu / Lempuyangan / Bandara YIA (+Rp 100.000/org)</option>
                            <option value="Semarang (Stasiun Tawang / Bandara)" data-surcharge="100000">Semarang — Stasiun Tawang / Bandara Ahmad Yani (+Rp 100.000/org)</option>
                        </select>
                    </div>

                    <!-- Rencana Tanggal & Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Tanggal Perjalanan</label>
                            <div class="relative">
                                <input id="calcDate" type="text" placeholder="Pilih tanggal keberangkatan..." readonly class="w-full p-3 pl-3.5 pr-10 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none cursor-pointer placeholder:text-slate-500">
                                <i data-lucide="calendar" class="w-4 h-4 text-amber-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Nama Pemesan</label>
                            <input id="calcName" type="text" placeholder="Contoh: Bpk. Kurniawan" class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">Catatan Tambahan (Opsional)</label>
                        <input id="calcNotes" type="text" placeholder="Permintaan menu khusus, upgrade kamar, dsb." class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <!-- Rincian Hasil & Tombol WA -->
                <div class="lg:col-span-5 p-6 rounded-2xl bg-black/40 border border-white/10 space-y-6">
                    <div class="border-b border-white/10 pb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ringkasan Estimasi Biaya</span>
                        <div id="totalPriceDisplay" class="text-3xl sm:text-4xl font-black text-amber-400 mt-2 font-mono">Rp 2.780.000</div>
                        <p id="calcNoteText" class="text-xs text-slate-400 mt-1">Estimasi untuk 4 orang peserta</p>
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

                    <button id="btnSendWa" class="w-full py-4 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider text-black bg-gradient-to-r from-emerald-400 via-emerald-300 to-emerald-500 hover:from-emerald-300 hover:to-emerald-400 transition-all duration-300 shadow-xl shadow-emerald-500/25 flex items-center justify-center gap-2 cursor-pointer">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Pesan via WhatsApp Resmi</span>
                    </button>
                    <p class="text-[11px] text-center text-slate-500">Pemesanan langsung terhubung ke Customer Service resmi {{ $settings->site_name }}.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONI WISATAWAN -->
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase">Suara Para Penjelajah</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-3">Kisah Nyata dari Atas Awan</h2>
            <p class="text-xs sm:text-sm text-slate-400">Lebih dari 2.500 wisatawan telah mempercayakan liburan mereka bersama {{ $settings->site_name }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Review 1 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Pilihan yang sangat tepat bersama TiketDieng! Momen fajar di Sikunir sangat tepat waktu. Mas Dimas sebagai pemandu sangat ramah dan sabar mengarahkan sudut foto terbaik, serta dokumentasi videonya luar biasa indah!”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=75" alt="Dr. Amanda" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Dr. Amanda Saraswati</h4>
                        <p class="text-[11px] text-slate-400">Jakarta Selatan • <span class="text-amber-300">Paket 2D1N</span></p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Adrenalin kami terpacu saat melintasi jalur off-road perkebunan teh dan Telaga Dringo! Pengemudi jip sangat berpengalaman dan penginapannya sangat bersih dengan air hangat yang lancar.”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=75" alt="Rizky Ramadhan" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Rizky Ramadhan & Rekan</h4>
                        <p class="text-[11px] text-slate-400">Surabaya • <span class="text-amber-300">Safari Jip 4x4</span></p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between group hover:border-amber-500/40 transition-all duration-300">
                <div>
                    <div class="flex items-center gap-1 mb-4 text-amber-400">
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        “Dieng is truly magnificent! The team handled our itinerary so smoothly right from pickup at Yogyakarta. Watching the sunrise piercing through the misty peaks was an unforgettable memory.”
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=100&q=75" alt="Clara & Michael" width="44" height="44" loading="lazy" decoding="async" class="w-11 h-11 rounded-full object-cover border border-amber-400/40">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-white">Clara & Michael</h4>
                        <p class="text-[11px] text-slate-400">Melbourne, Australia • <span class="text-amber-300">Paket 3D2N</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. VISITOR COUNTER PUBLIK (REALTIME TRANSPARENT STATS) -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6 border-b border-white/10 pb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wide">Statistik Kunjungan Pengunjung</h3>
                        <p class="text-[11px] text-slate-400">Data transparan aktivitas penjelajah TiketDieng.com</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span><strong id="counterOnline">{{ $visitorStats['online'] }}</strong> Penjelajah Online</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Hari Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-amber-400 font-mono mt-1">{{ number_format($visitorStats['today'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Pengunjung unik</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Kemarin</span>
                    <div class="text-xl sm:text-2xl font-bold text-sky-400 font-mono mt-1">{{ number_format($visitorStats['yesterday'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Rekap kemarin</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Minggu Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-emerald-400 font-mono mt-1">{{ number_format($visitorStats['this_week'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">7 hari terakhir</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Bulan Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-purple-400 font-mono mt-1">{{ number_format($visitorStats['this_month'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Bulan aktif</span>
                </div>

                <div class="col-span-2 sm:col-span-1 p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Kunjungan</span>
                    <div class="text-xl sm:text-2xl font-bold text-white font-mono mt-1">{{ number_format($visitorStats['total'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-500">Sejak platform rilis</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. FOOTER SINEMATIK & LEGALITAS BIRO PERJALANAN -->
    <footer class="bg-[#04060a] border-t border-white/10 text-slate-400 text-xs pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                <!-- Col 1: Brand & Tagline -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center p-0.5 shadow-md shadow-amber-500/20">
                            <div class="w-full h-full bg-[#090d16] rounded-[10px] flex items-center justify-center">
                                <i data-lucide="compass" class="w-4 h-4 text-amber-400"></i>
                            </div>
                        </div>
                        <span class="font-serif tracking-wider text-xl font-bold text-white">
                            {{ $settings->site_name }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                        {{ $settings->site_tagline }}. Kami menghadirkan standar liburan eksekutif berbalut narasi magis alam dan kebudayaan para dewa.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-amber-300 font-semibold">
                            {{ $settings->legal_nib }}
                        </span>
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-emerald-300 font-semibold">
                            {{ $settings->hpi_badge }}
                        </span>
                    </div>
                </div>

                <!-- Col 2: Destinasi Ikonik -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Destinasi Ikonik</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#sikunir" class="hover:text-amber-400 transition-colors">Golden Sunrise Sikunir</a></li>
                        <li><a href="#sikidang" class="hover:text-amber-400 transition-colors">Kawah Sikidang Purba</a></li>
                        <li><a href="#telagawarna" class="hover:text-amber-400 transition-colors">Telaga Warna & Pengilon</a></li>
                        <li><a href="#candi-arjuna" class="hover:text-amber-400 transition-colors">Kompleks Candi Arjuna</a></li>
                        <li><a href="#jeep" class="hover:text-amber-400 transition-colors">Safari Jip Telaga Dringo</a></li>
                    </ul>
                </div>

                <!-- Col 3: Titik Penjemputan -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Titik Penjemputan</h4>
                    <ul class="space-y-2.5">
                        <li>Stasiun Purwokerto (PWT)</li>
                        <li>Bandara / Stasiun Tugu Yogyakarta</li>
                        <li>Stasiun Tawang Semarang</li>
                        <li>Terminal Mendolo Wonosobo</li>
                        <li>Alun-Alun Wonosobo</li>
                    </ul>
                </div>

                <!-- Col 4: Kantor & Kontak -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Kontak Resmi</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5"></i>
                            <span>{{ $settings->address }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span class="text-white font-medium">{{ $settings->phone_number }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="message-circle" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="hover:text-amber-400 transition-colors">
                                WhatsApp Layanan 24 Jam
                            </a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                            <span>{{ $settings->email }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom credit -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <p>© {{ date('Y') }} {{ $settings->site_name }}. Hak cipta dilindungi undang-undang.</p>
                <p class="flex items-center gap-2">
                    <span>Didukung Laravel 13 & MySQL</span>
                    <span>•</span>
                    <a href="{{ route('admin.login') }}" class="text-amber-400/80 hover:text-amber-300">Akses Pengelola</a>
                </p>
            </div>
        </div>
    </footer>
</main>
@endsection

@push('scripts')
<script>
    // 1. Scroll Navbar Effect
    const navContainer = document.getElementById('navContainer');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navContainer.classList.add('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.remove('bg-black/30', 'py-4');
        } else {
            navContainer.classList.remove('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.add('bg-black/30', 'py-4');
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // 2. Fetch Live Weather Dieng (Open-Meteo)
    async function initDiengWeather() {
        const cacheKey = 'dieng_weather_cache';
        const cacheTimeKey = 'dieng_weather_time';
        const cacheDuration = 15 * 60 * 1000;

        try {
            const cached = sessionStorage.getItem(cacheKey);
            const cachedTime = sessionStorage.getItem(cacheTimeKey);
            if (cached && cachedTime && (Date.now() - parseInt(cachedTime)) < cacheDuration) {
                const w = JSON.parse(cached);
                document.getElementById('diengTemp').innerText = w.temp + '°C';
                document.getElementById('diengCondition').innerText = w.condition;
                return;
            }

            const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-7.2062&longitude=109.9015&current=temperature_2m,relative_humidity_2m,weather_code&timezone=Asia%2FJakarta');
            if (res.ok) {
                const data = await res.json();
                const temp = Math.round(data.current?.temperature_2m ?? 11);
                const code = data.current?.weather_code ?? 0;
                let condition = "Sejuk Berawan";
                if (code === 0) condition = "Cerah Sejuk";
                else if (code <= 2) condition = "Cerah Berawan";
                else if (code <= 3) condition = "Mendung Sejuk";
                else if (code <= 48) condition = "Kabut Dingin";
                else if (code <= 65) condition = "Hujan Dingin";

                document.getElementById('diengTemp').innerText = temp + '°C';
                document.getElementById('diengCondition').innerText = condition;

                sessionStorage.setItem(cacheKey, JSON.stringify({ temp, condition }));
                sessionStorage.setItem(cacheTimeKey, Date.now().toString());
            }
        } catch (e) {
            // Biarkan fallback
        }
    }
    initDiengWeather();

    // 3. Smart Booking Calculator
    const calcPkg = document.getElementById('calcPkg');
    const calcPax = document.getElementById('calcPax');
    const paxDisplay = document.getElementById('paxDisplay');
    const calcMeeting = document.getElementById('calcMeeting');
    const calcDate = document.getElementById('calcDate');
    const calcName = document.getElementById('calcName');
    const calcNotes = document.getElementById('calcNotes');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const calcNoteText = document.getElementById('calcNoteText');
    const summaryPkgName = document.getElementById('summaryPkgName');
    const summaryPax = document.getElementById('summaryPax');
    const summaryMeeting = document.getElementById('summaryMeeting');
    const discountRow = document.getElementById('discountRow');
    const summaryDiscount = document.getElementById('summaryDiscount');
    const btnSendWa = document.getElementById('btnSendWa');

    // Inisialisasi Flatpickr (Tanggal Perjalanan)
    if (window.flatpickr && calcDate) {
        flatpickr(calcDate, {
            locale: "id",
            minDate: "today",
            dateFormat: "d F Y",
            altInput: false,
            defaultDate: new Date(Date.now() + 86400000), // Default keberangkatan besok
            disableMobile: "true", // Memaksa tema gelap Dieng tampil di semua perangkat
        });
    }

    function calculatePrice() {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const basePrice = parseInt(selectedOption.getAttribute('data-price')) || 0;
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = parseInt(calcPax.value) || 1;
        const meetingOption = calcMeeting.options[calcMeeting.selectedIndex];
        const surcharge = parseInt(meetingOption.getAttribute('data-surcharge')) || 0;

        paxDisplay.innerText = pax + ' Orang';
        summaryPax.innerText = pax + ' Orang';
        summaryPkgName.innerText = selectedOption.text.split('—')[0].trim();
        summaryMeeting.innerText = meetingOption.text.split('(')[0].trim();

        let total = 0;
        if (isJeep) {
            const unitsNeeded = Math.ceil(pax / 4);
            total = (unitsNeeded * basePrice) + (surcharge * pax);
            calcNoteText.innerText = `Membutuhkan ${unitsNeeded} Unit Jeep untuk ${pax} orang`;
            discountRow.classList.add('hidden');
        } else {
            let discountPercent = 0;
            if (pax >= 6 && pax < 10) discountPercent = 0.05;
            if (pax >= 10) discountPercent = 0.1;

            const basePerPax = (basePrice * (1 - discountPercent)) + surcharge;
            total = Math.round(basePerPax * pax);
            calcNoteText.innerText = `Estimasi Rp ${Math.round(basePerPax).toLocaleString('id-ID')}/orang`;

            if (discountPercent > 0) {
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                summaryDiscount.innerText = (discountPercent * 100) + '% Potongan Rombongan';
            } else {
                discountRow.classList.add('hidden');
            }
        }

        totalPriceDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    calcPkg.addEventListener('change', calculatePrice);
    calcPax.addEventListener('input', calculatePrice);
    calcMeeting.addEventListener('change', calculatePrice);
    calculatePrice();

    window.selectPackageInCalculator = function(slug) {
        if (calcPkg) {
            calcPkg.value = slug;
            calculatePrice();
        }
    };

    // 4. Send WhatsApp Handler
    btnSendWa.addEventListener('click', () => {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const pkgTitle = selectedOption.text.split('—')[0].trim();
        const duration = selectedOption.getAttribute('data-duration');
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = calcPax.value;
        const unitsNeeded = Math.ceil(pax / 4);
        const meeting = calcMeeting.options[calcMeeting.selectedIndex].text.split('(')[0].trim();
        const dateVal = calcDate.value ? calcDate.value : "Fleksibel / Menyesuaikan";
        const nameVal = calcName.value ? calcName.value : "Tamu {{ $settings->site_name }}";
        const notesVal = calcNotes.value.trim();
        const total = totalPriceDisplay.innerText;

        const waTarget = "{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}";

        const text = `*HALO CS {{ $settings->site_name }} - RESERVASI PERJALANAN*
----------------------------------------
👤 *Nama Pemesan:* ${nameVal}
📦 *Pilihan Paket:* ${pkgTitle} (${duration})
👥 *Jumlah Peserta:* ${pax} Orang ${isJeep ? `(${unitsNeeded} Unit Jeep)` : ""}
📍 *Titik Kumpul (Meeting Point):* ${meeting}
📅 *Rencana Tanggal:* ${dateVal}
💰 *Estimasi Total Biaya:* ${total}
${notesVal ? `📝 *Catatan Khusus:* ${notesVal}` : ""}
----------------------------------------
Mohon konfirmasi ketersediaan jadwal dan panduan pembayaran resminya. Terima kasih! 🙏`;

        window.open(`https://wa.me/${waTarget}?text=${encodeURIComponent(text)}`, '_blank');
    });
</script>
@endpush

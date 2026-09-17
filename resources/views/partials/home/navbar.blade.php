<!-- 1. FLOATING ATMOSPHERIC NAVIGATION -->
    <header id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div id="navContainer" class="max-w-7xl mx-auto rounded-2xl transition-all duration-500 bg-black/30 backdrop-blur-md py-4 px-5 sm:px-8 border border-white/5">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-tiketdieng-transparent.png') }}?v=2" alt="{{ $settings->site_name }}" class="h-8 sm:h-9 w-auto object-contain brightness-110 drop-shadow">
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-300">
                    <a href="#scrollytelling" class="hover:text-amber-400 transition-colors">Jelajah Cerita</a>
                    <a href="#paket" class="hover:text-amber-400 transition-colors">Paket Wisata</a>
                    <a href="#dokumentasi" class="hover:text-amber-400 transition-colors">Dokumentasi</a>
                    <a href="#profil" class="hover:text-amber-400 transition-colors">Tentang Kami</a>
                    <a href="#kalkulator" class="hover:text-amber-400 transition-colors">Kalkulator Biaya</a>
                </nav>

                <!-- Right Section: Search & CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Tombol Spotlight Search Desktop -->
                    <button 
                        type="button"
                        onclick="window.openSpotlightSearch()"
                        class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 hover:border-amber-500/40 text-xs text-slate-300 hover:text-white transition-all group cursor-pointer"
                        title="Pencarian Cepat Paket Wisata (Ctrl+K)"
                    >
                        <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                        <span class="text-[11px] text-slate-400 group-hover:text-slate-200">Cari paket...</span>
                        <kbd class="inline-flex items-center px-1.5 py-0.5 text-[9px] font-mono text-slate-400 bg-white/5 rounded border border-white/10">⌘K</kbd>
                    </button>

                    <!-- CTA Button -->
                    <a href="#kalkulator" class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold tracking-wide text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        <span>Pesan Tiket</span>
                    </a>
                </div>

                <!-- Mobile Actions (Search & Hamburger) -->
                <div class="flex items-center gap-2 md:hidden">
                    <button 
                        type="button" 
                        onclick="window.openSpotlightSearch()"
                        class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-200 hover:text-amber-400 hover:bg-white/10 transition-colors"
                        aria-label="Cari Paket"
                    >
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                    <button id="mobileMenuBtn" class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-200 hover:bg-white/10 transition-colors" aria-label="Buka Menu">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div id="mobileMenu" class="hidden md:hidden pt-4 pb-2 border-t border-white/10 mt-3 flex flex-col gap-3">
                <button type="button" onclick="window.openSpotlightSearch(); document.getElementById('mobileMenu').classList.add('hidden');" class="text-sm py-1.5 text-slate-300 hover:text-amber-400 text-left">
                    <span>Cari Paket & Destinasi (Pencarian Cepat)</span>
                </button>
                <a href="#scrollytelling" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Jelajah Cerita Dieng</a>
                <a href="#paket" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Paket Wisata All-Inclusive</a>
                <a href="#dokumentasi" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Jasa Dokumentasi & Drone (Lotus Creative)</a>
                <a href="#profil" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Tentang Kami & Visi Misi</a>
                <a href="#kalkulator" class="text-sm py-1.5 text-slate-300 hover:text-amber-400">Kalkulator Reservasi</a>
                <div class="pt-2">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="w-full text-center block px-4 py-2.5 rounded-xl text-xs font-bold text-black bg-amber-400">
                        Chat WhatsApp Resmi
                    </a>
                </div>
            </div>
        </div>
    </header>

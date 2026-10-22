<!-- 1. TIKET.COM STYLE STICKY NAVBAR -->
<header id="mainNavbar" class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all duration-300">
    <div id="navContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-3.5 transition-all duration-300">
        <div class="flex items-center justify-between gap-4">
            <!-- Brand Logo & Yellow Dot Badge -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group shrink-0 focus:outline-none" aria-label="{{ $settings->site_name ?? 'TiketDieng' }}">
                <img 
                    src="{{ asset('images/logo-tiketdieng-blue-text.png') }}" 
                    alt="{{ $settings->site_name ?? 'TiketDieng' }}" 
                    width="146" 
                    height="36" 
                    class="h-8 sm:h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                    onerror="this.style.display='none'; var fb = document.getElementById('navbarBrandFallback'); if(fb){ fb.classList.remove('hidden'); fb.classList.add('flex'); }"
                >
                <div id="navbarBrandFallback" class="hidden items-center gap-1.5 font-sans font-extrabold text-xl tracking-tight text-[#0064D2]">
                    <span>tiket</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#FEDD00] shadow-sm inline-block"></span>
                    <span class="text-slate-800">Dieng</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Clean tiket.com style) -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-700">
                <a href="#scrollytelling" class="hover:text-[#0064D2] transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-[#0064D2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform">
                    Jelajah Cerita
                </a>
                <a href="#paket" class="hover:text-[#0064D2] transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-[#0064D2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform">
                    Paket Wisata
                </a>
                <a href="#dokumentasi" class="hover:text-[#0064D2] transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-[#0064D2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform">
                    Dokumentasi
                </a>
                <a href="#profil" class="hover:text-[#0064D2] transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-[#0064D2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform">
                    Tentang Kami
                </a>
                <a href="#kalkulator" class="hover:text-[#0064D2] transition-colors py-1 relative after:absolute after:bottom-0 after:left-0 after:right-0 after:h-0.5 after:bg-[#0064D2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform">
                    Kalkulator Biaya
                </a>
            </nav>

            <!-- Right Actions: Quick Search, Hubungi Kami & Pesan Sekarang -->
            <div class="hidden md:flex items-center gap-3 shrink-0">
                <!-- Tombol Quick Spotlight Search -->
                <button 
                    type="button"
                    onclick="window.openSpotlightSearch()"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-full bg-slate-50 hover:bg-slate-100 border border-slate-200/90 hover:border-blue-300 text-xs text-slate-600 hover:text-[#0064D2] transition-all group cursor-pointer shadow-2xs"
                    title="Pencarian Cepat Paket Wisata (Ctrl+K)"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#0064D2] transition-colors"></i>
                    <span class="text-[12px] text-slate-500 group-hover:text-slate-700 font-medium">Cari paket...</span>
                    <kbd class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-mono text-slate-500 bg-white rounded border border-slate-200 shadow-2xs">⌘K</kbd>
                </button>

                <!-- Hubungi Kami via WhatsApp -->
                @if(!empty($settings->whatsapp_number))
                <a 
                    href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}?text={{ urlencode('Halo TiketDieng, saya ingin konsultasi paket wisata.') }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold text-slate-700 hover:text-[#0064D2] bg-slate-100/80 hover:bg-blue-50/80 transition-all border border-slate-200/80"
                    title="Konsultasi via WhatsApp Resmi"
                >
                    <i data-lucide="message-circle" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                    <span>Hubungi Kami</span>
                </a>
                @endif

                <!-- Pesan Sekarang (tiket.com High-Contrast Blue CTA) -->
                <a 
                    href="#kalkulator" 
                    class="inline-flex items-center gap-2 bg-[#0064D2] text-white hover:bg-[#0051A8] font-bold px-5 py-2.5 rounded-full shadow-md shadow-blue-500/20 hover:shadow-blue-500/35 transition-all text-xs tracking-wide hover:-translate-y-0.5 cursor-pointer"
                >
                    <span class="w-2 h-2 rounded-full bg-[#FEDD00] shadow-sm"></span>
                    <span>Pesan Sekarang</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-white"></i>
                </a>
            </div>

            <!-- Mobile Actions (Search & Hamburger) -->
            <div class="flex items-center gap-2 md:hidden">
                <button 
                    type="button" 
                    onclick="window.openSpotlightSearch()"
                    class="p-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-[#0064D2] transition-colors focus:outline-none"
                    aria-label="Cari Paket"
                >
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <button 
                    id="mobileMenuBtn" 
                    class="p-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-[#0064D2] transition-colors focus:outline-none" 
                    aria-label="Buka Menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Card (tiket.com Clean Modern Mobile Menu) -->
        <div id="mobileMenu" class="hidden md:hidden pt-4 pb-2 border-t border-slate-100 mt-3 flex flex-col gap-2 bg-white rounded-2xl shadow-xl p-4 border border-slate-100/80">
            <button 
                type="button" 
                onclick="window.openSpotlightSearch(); document.getElementById('mobileMenu').classList.add('hidden');" 
                class="flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-[#0064D2] text-xs font-semibold text-left transition-colors border border-slate-200/70"
            >
                <div class="flex items-center gap-2.5">
                    <i data-lucide="search" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Cari Paket & Destinasi</span>
                </div>
                <span class="text-[10px] bg-white px-2 py-0.5 rounded border border-slate-200 text-slate-500 font-mono">⌘K</span>
            </button>

            <div class="flex flex-col gap-1 py-1">
                <a href="#scrollytelling" onclick="document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-[#0064D2] hover:bg-blue-50/60 transition-colors">
                    <i data-lucide="compass" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Jelajah Cerita Dieng</span>
                </a>
                <a href="#paket" onclick="document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-[#0064D2] hover:bg-blue-50/60 transition-colors">
                    <i data-lucide="package" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Paket Wisata All-Inclusive</span>
                </a>
                <a href="#dokumentasi" onclick="document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-[#0064D2] hover:bg-blue-50/60 transition-colors">
                    <i data-lucide="camera" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Foto & Drone 4K (Lotus Creative)</span>
                </a>
                <a href="#profil" onclick="document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-[#0064D2] hover:bg-blue-50/60 transition-colors">
                    <i data-lucide="building-2" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Tentang Kami & Legalitas</span>
                </a>
                <a href="#kalkulator" onclick="document.getElementById('mobileMenu').classList.add('hidden');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:text-[#0064D2] hover:bg-blue-50/60 transition-colors">
                    <i data-lucide="calculator" class="w-4 h-4 text-[#0064D2]"></i>
                    <span>Kalkulator Estimasi Biaya</span>
                </a>
            </div>

            <div class="pt-2 border-t border-slate-100 flex flex-col gap-2">
                @if(!empty($settings->whatsapp_number))
                <a 
                    href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}?text={{ urlencode('Halo TiketDieng, saya ingin konsultasi paket wisata.') }}" 
                    target="_blank" 
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-600/20 transition-colors"
                >
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Chat WhatsApp Resmi</span>
                </a>
                @endif
                <a 
                    href="#kalkulator" 
                    onclick="document.getElementById('mobileMenu').classList.add('hidden');" 
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051A8] shadow-md shadow-blue-500/20 transition-colors"
                >
                    <span class="w-2 h-2 rounded-full bg-[#FEDD00]"></span>
                    <span>Pesan Tiket Sekarang</span>
                </a>
            </div>
        </div>
    </div>
</header>
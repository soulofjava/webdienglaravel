        <!-- Banner Selamat Datang Tiket Partner Style -->
        @if ($isSuperadmin)
            <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 bg-gradient-to-r from-[#0064D2] via-[#0051A8] to-blue-800 text-white shadow-xl shadow-blue-900/10">
                <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute top-0 right-1/4 w-32 h-32 bg-[#FEDD00]/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-13 h-13 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shadow-inner shrink-0">
                            <i data-lucide="crown" class="w-7 h-7 text-[#FEDD00]"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-base sm:text-xl font-extrabold text-white tracking-tight">Selamat Datang, Super Administrator</h2>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#FEDD00] text-slate-900 shadow-xs">Full Access</span>
                            </div>
                            <p class="text-xs text-blue-100 mt-1 max-w-2xl leading-relaxed">
                                Kontrol terpusat partner extranet: alihkan tema multi-site (Tiket Dieng, Lotus Creative, Jeep 4x4, Shuttle), rekening resmi biro, dan otorisasi tim pengelola.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 self-stretch sm:self-auto shrink-0">
                        <a href="#section-theme-switcher" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-900 bg-[#FEDD00] hover:bg-[#F5D300] transition-all flex items-center gap-1.5 shadow-sm">
                            <i data-lucide="palette" class="w-4 h-4"></i>
                            <span>Tema Multi-Site</span>
                        </a>
                        <a href="#section-users" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-white/15 hover:bg-white/25 border border-white/20 transition-all flex items-center gap-1.5 backdrop-blur-sm">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            <span>Daftar Tim</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="relative overflow-hidden rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] font-bold shrink-0">
                        <i data-lucide="user-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">Selamat Datang, {{ $currentUser->name ?? 'Staf Mitra' }}</h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#0064D2] border border-blue-200">Admin Staf</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Panel operasional mitra aktif: kelola paket wisata, rute jemput, dan konten profil biro perjalanan Anda.
                        </p>
                    </div>
                </div>
            </div>
        @endif

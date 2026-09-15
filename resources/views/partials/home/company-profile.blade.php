<!-- 6. PROFIL PERUSAHAAN, VISI & MISI (COMPANY PROFILE & DEDICATION) -->
    <section id="profil" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold tracking-widest text-amber-400 uppercase bg-amber-500/10 border border-amber-500/20 mb-3">
                <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                <span>TENTANG KAMI & DEDIKASI KAMI</span>
            </div>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mb-4">Visi & Komitmen Perjalanan Dieng</h2>
            <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                Mengenal lebih dekat dedikasi {{ $settings->site_name }} di bawah legalitas resmi <strong class="text-slate-200">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong> dalam menghadirkan pengalaman berwisata aman, transparan, dan berkesan di Dataran Tinggi Dieng.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Kolom Kiri: Profil & Sejarah Singkat (7 Kolom di Desktop) -->
            <div class="lg:col-span-7 glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col justify-between relative overflow-hidden group hover:border-white/20 transition-all duration-300">
                <!-- Ambient Glow Dekorasi -->
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-6 relative z-10">
                    <!-- Badges Header -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-amber-500/15 text-amber-300 border border-amber-500/30 flex items-center gap-1.5">
                            <i data-lucide="history" class="w-3.5 h-3.5"></i>
                            <span>Berdiri Sejak 2022</span>
                        </span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-1.5">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>{{ $settings->legal_nib ?? 'Legalitas NIB Resmi' }}</span>
                        </span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-sky-300 bg-sky-500/10 border border-sky-500/20 flex items-center gap-1.5">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            <span>{{ $settings->hpi_badge ?? 'Vendor Resmi HPI Dieng' }}</span>
                        </span>
                    </div>

                    <!-- Judul Profil -->
                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-slate-400 block mb-1">Profil & Sejarah Singkat</span>
                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white tracking-wide">
                            {{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-400/90 font-medium mt-1">
                            Unit Pengelola & Pemasaran Resmi Wisata Dieng
                        </p>
                    </div>

                    <!-- Narasi Tentang Kami & Sejarah (Dinamis dari Database) -->
                    <div class="space-y-4 text-xs sm:text-sm text-slate-300 leading-relaxed">
                        <p class="text-slate-300">
                            {{ $settings->about_us ?? 'Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng yang siap membantu Anda dalam menyusun itinerary eksklusif, menghitung simulasi anggaran transparan, dan merealisasikan liburan impian yang aman dan berkesan di Dataran Tinggi Dieng.' }}
                        </p>
                        <p class="text-slate-400 text-xs sm:text-[13px] border-l-2 border-amber-500/40 pl-4 py-1 italic bg-white/[0.01] rounded-r-xl">
                            {{ $settings->company_history ?? 'Tiket Wisata Dieng berdiri sejak tahun 2022 sebagai anak perusahaan di bawah naungan PT. GOtrip Asia Travelindo Wonosobo guna mempermudah pelayanan menyeluruh wisatawan di Dataran Tinggi Dieng.' }}
                        </p>
                    </div>

                    <!-- Lingkup Layanan Lengkap -->
                    <div class="pt-4 border-t border-white/10">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-3">Layanan & Fasilitas Terpadu:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach([
                                'Akomodasi & Homestay Dieng',
                                'Transportasi Shuttle & Bus',
                                'Sewa Jeep Wisata 4x4',
                                'Pemandu Lokal Berlisensi HPI',
                                'Dokumentasi Kamera & Drone 4K',
                                'Paket Makan & Kuliner Khas',
                                'Outbound & Gathering Perusahaan',
                                'Rafting Serayu & Paralayang'
                            ] as $layanan)
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-white/5 border border-white/10 text-slate-300 hover:border-amber-500/40 hover:text-white transition-colors">
                                    ✓ {{ $layanan }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer Card Lokasi & Rekening -->
                <div class="mt-6 pt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400 relative z-10">
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-rose-400 flex-shrink-0"></i>
                        <span class="line-clamp-1">{{ $settings->address }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                        <span>{{ $settings->bank_name ?? 'BNI Wonosobo' }} (Rekening Resmi PT)</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Visi & Misi (5 Kolom di Desktop) -->
            <div class="lg:col-span-5 flex flex-col gap-6 justify-between">
                <!-- Kartu Visi Perusahaan -->
                <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-amber-500/30 bg-gradient-to-br from-amber-500/[0.07] via-white/[0.02] to-transparent relative overflow-hidden group hover:border-amber-500/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400 flex-shrink-0 shadow-lg shadow-amber-500/10">
                            <i data-lucide="eye" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-bold tracking-widest text-amber-400 uppercase block">Tujuan Jangka Panjang</span>
                            <h4 class="font-serif text-lg font-bold text-white">Visi Perusahaan</h4>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        "{{ $settings->company_vision ?? 'Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman, transparan, dan terpercaya bagi seluruh wisatawan.' }}"
                    </p>
                </div>

                <!-- Kartu Misi Perusahaan -->
                <div class="glass-panel p-6 sm:p-7 rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-500/[0.07] via-white/[0.02] to-transparent relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 flex-shrink-0 shadow-lg shadow-emerald-500/10">
                            <i data-lucide="target" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-bold tracking-widest text-emerald-400 uppercase block">Komitmen Layanan</span>
                            <h4 class="font-serif text-lg font-bold text-white">Misi Perusahaan</h4>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        "{{ $settings->company_mission ?? 'Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo Wonosobo, kami berkomitmen untuk meningkatkan kepercayaan klien dan mempermudah dalam merencanakan sampai membantu terealisasinya liburan terbaik Anda ke Dieng.' }}"
                    </p>
                </div>

                <!-- Kartu Garansi & Kemitraan -->
                <div class="glass-panel p-5 rounded-2xl border border-white/10 bg-white/[0.02] flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/15 flex items-center justify-center text-sky-400 flex-shrink-0">
                        <i data-lucide="check-check" class="w-5 h-5"></i>
                    </div>
                    <div class="text-xs">
                        <h5 class="font-bold text-white">Jaminan Keamanan & Kenyamanan</h5>
                        <p class="text-slate-400 text-[11px] mt-0.5">Seluruh pemesanan tercatat resmi di sistem kami dan dilindungi garansi operasional PT. GOtrip Asia Travelindo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

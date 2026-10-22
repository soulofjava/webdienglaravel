<!-- 6. PROFIL PERUSAHAAN, VISI & MISI (COMPANY PROFILE & DEDICATION - TIKET.COM LIGHT THEME) -->
<section id="profil" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-200/80 scroll-mt-20">
    <div class="text-center max-w-3xl mx-auto mb-14">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold tracking-wider text-[#0064D2] uppercase bg-blue-50 border border-blue-100 mb-3">
            <i data-lucide="compass" class="w-3.5 h-3.5 text-[#0064D2]"></i>
            <span>TENTANG KAMI & DEDIKASI KAMI</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">Visi & Komitmen Perjalanan Dieng</h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto">
            Mengenal lebih dekat dedikasi {{ $settings->site_name }} di bawah legalitas resmi <strong class="text-slate-900 font-semibold">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong> dalam menghadirkan pengalaman berwisata aman, transparan, dan berkesan di Dataran Tinggi Dieng.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        <!-- Kolom Kiri: Profil & Sejarah Singkat (7 Kolom di Desktop) -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden group hover:border-[#0064D2]/40 hover:shadow-md transition-all duration-300">
            <!-- Subtle Light Glow Dekorasi -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="space-y-6 relative z-10">
                <!-- Badges Header -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                        <i data-lucide="history" class="w-3.5 h-3.5 text-amber-600"></i>
                        <span>Berdiri Sejak 2022</span>
                    </span>
                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                        <span>{{ $settings->legal_nib ?? 'Legalitas NIB Resmi' }}</span>
                    </span>
                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold text-[#0064D2] bg-blue-50 border border-blue-200 flex items-center gap-1.5">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                        <span>{{ $settings->hpi_badge ?? 'Vendor Resmi HPI Dieng' }}</span>
                    </span>
                </div>

                <!-- Judul Profil -->
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-slate-500 block mb-1">Profil & Sejarah Singkat</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-[#0064D2] font-semibold mt-1">
                        Unit Pengelola & Pemasaran Resmi Wisata Dieng
                    </p>
                </div>

                <!-- Narasi Tentang Kami & Sejarah (Dinamis dari Database) -->
                <div class="space-y-4 text-xs sm:text-sm text-slate-700 leading-relaxed">
                    <p class="text-slate-700">
                        {{ $settings->about_us ?? 'Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng yang siap membantu Anda dalam menyusun itinerary eksklusif, menghitung simulasi anggaran transparan, dan merealisasikan liburan impian yang aman dan berkesan di Dataran Tinggi Dieng.' }}
                    </p>
                    <p class="text-slate-600 text-xs sm:text-[13px] border-l-3 border-[#0064D2] pl-4 py-2 italic bg-slate-50 rounded-r-xl border border-slate-100">
                        {{ $settings->company_history ?? 'Tiket Wisata Dieng berdiri sejak tahun 2022 sebagai anak perusahaan di bawah naungan PT. GOtrip Asia Travelindo Wonosobo guna mempermudah pelayanan menyeluruh wisatawan di Dataran Tinggi Dieng.' }}
                    </p>
                </div>

                <!-- Lingkup Layanan Lengkap -->
                <div class="pt-4 border-t border-slate-100">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-3">Layanan & Fasilitas Terpadu:</span>
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
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-slate-50 border border-slate-200 text-slate-700 hover:border-[#0064D2] hover:text-[#0064D2] transition-colors">
                                <span class="text-emerald-600 font-bold">✓</span> {{ $layanan }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer Card Lokasi & Rekening -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-600 relative z-10">
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-rose-500 flex-shrink-0"></i>
                    <span class="line-clamp-1 font-medium">{{ $settings->address }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                    <span class="font-medium">{{ $settings->bank_name ?? 'BNI Wonosobo' }} (Rekening Resmi PT)</span>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Visi & Misi (5 Kolom di Desktop) -->
        <div class="lg:col-span-5 flex flex-col gap-6 justify-between">
            <!-- Kartu Visi Perusahaan -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-amber-200 shadow-sm relative overflow-hidden group hover:border-amber-400 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 flex-shrink-0 shadow-xs">
                        <i data-lucide="eye" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-mono font-bold tracking-widest text-amber-700 uppercase block">Tujuan Jangka Panjang</span>
                        <h4 class="text-lg font-bold text-slate-900">Visi Perusahaan</h4>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                    "{{ $settings->company_vision ?? 'Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman, transparan, dan terpercaya bagi seluruh wisatawan.' }}"
                </p>
            </div>

            <!-- Kartu Misi Perusahaan -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-blue-200 shadow-sm relative overflow-hidden group hover:border-[#0064D2] hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <div class="flex items-center gap-3.5 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center text-[#0064D2] flex-shrink-0 shadow-xs">
                        <i data-lucide="target" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-mono font-bold tracking-widest text-[#0064D2] uppercase block">Komitmen Layanan</span>
                        <h4 class="text-lg font-bold text-slate-900">Misi Perusahaan</h4>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                    "{{ $settings->company_mission ?? 'Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo Wonosobo, kami berkomitmen untuk meningkatkan kepercayaan klien dan mempermudah dalam merencanakan sampai membantu terealisasinya liburan terbaik Anda ke Dieng.' }}"
                </p>
            </div>

            <!-- Kartu Garansi & Kemitraan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#0064D2] flex-shrink-0">
                    <i data-lucide="check-check" class="w-5 h-5"></i>
                </div>
                <div class="text-xs">
                    <h5 class="font-bold text-slate-900">Jaminan Keamanan & Kenyamanan</h5>
                    <p class="text-slate-600 text-[11px] mt-0.5">Seluruh pemesanan tercatat resmi di sistem kami dan dilindungi garansi operasional PT. GOtrip Asia Travelindo.</p>
                </div>
            </div>
        </div>
    </div>
</section>

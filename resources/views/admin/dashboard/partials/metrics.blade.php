        <!-- Prominent Summary Metric Cards (Tiket Partner Extranet Pastel Icons) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Metric 1: Total Paket Wisata -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Paket</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalPackages, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ $activePackages }} paket aktif publik
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                    <i data-lucide="compass" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 2: Total Titik Jemput -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Titik Jemput</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalPickups, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-1 flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-3 h-3 text-amber-500"></i>
                        Stasiun & Bandara
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 3: Pengunjung Hari Ini -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Pengunjung Hari Ini</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($statsSummary['today_unique'], 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-slate-500 mt-1 flex items-center gap-1">
                        <span class="text-emerald-600 font-bold">{{ number_format($statsSummary['today_visits'], 0, ',', '.') }}</span>
                        hits halaman
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Metric 4: Total Master Kode / Komisi -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Master Kode</span>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-sans mt-1.5 tracking-tight">
                        {{ number_format($totalComcodes, 0, ',', '.') }}
                    </div>
                    <span class="text-[11px] font-semibold text-purple-600 mt-1 flex items-center gap-1">
                        <i data-lucide="database" class="w-3 h-3 text-purple-500"></i>
                        Kode komisi & kategori
                    </span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                    <i data-lucide="ticket" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

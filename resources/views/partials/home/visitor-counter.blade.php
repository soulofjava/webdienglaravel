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

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Hari Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-amber-400 font-mono mt-1">{{ number_format($visitorStats['today'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">Kunjungan hari ini</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Kemarin</span>
                    <div class="text-xl sm:text-2xl font-bold text-sky-400 font-mono mt-1">{{ number_format($visitorStats['yesterday'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">Rekap kemarin</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Minggu Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-emerald-400 font-mono mt-1">{{ number_format($visitorStats['this_week'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">7 hari terakhir</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Bulan Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-purple-400 font-mono mt-1">{{ number_format($visitorStats['this_month'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">Bulan berjalan</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Tahun Ini</span>
                    <div class="text-xl sm:text-2xl font-bold text-rose-400 font-mono mt-1">{{ number_format($visitorStats['this_year'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">Tahun berjalan</span>
                </div>

                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5">
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Total Kunjungan</span>
                    <div class="text-xl sm:text-2xl font-bold text-white font-mono mt-1">{{ number_format($visitorStats['total'], 0, ',', '.') }}</div>
                    <span class="text-[10px] text-slate-400">Semua kunjungan</span>
                </div>
            </div>
        </div>
    </section>

<!-- 8. VISITOR COUNTER PUBLIK (REALTIME TRANSPARENT STATS - TIKET.COM LIGHT THEME) -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-200/80">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6 border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2]">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-[#0064D2]"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 tracking-wide">Statistik Kunjungan Pengunjung</h3>
                    <p class="text-[11px] text-slate-500">Data transparan aktivitas penjelajah TiketDieng.com</p>
                </div>
            </div>

            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span><strong id="counterOnline" class="font-bold text-emerald-900">{{ $visitorStats['online'] }}</strong> Penjelajah Online</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Hari Ini</span>
                <div class="text-xl sm:text-2xl font-extrabold text-[#0064D2] font-mono mt-1">{{ number_format($visitorStats['today'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">Kunjungan hari ini</span>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Kemarin</span>
                <div class="text-xl sm:text-2xl font-extrabold text-slate-800 font-mono mt-1">{{ number_format($visitorStats['yesterday'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">Rekap kemarin</span>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Minggu Ini</span>
                <div class="text-xl sm:text-2xl font-extrabold text-slate-800 font-mono mt-1">{{ number_format($visitorStats['this_week'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">7 hari terakhir</span>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Bulan Ini</span>
                <div class="text-xl sm:text-2xl font-extrabold text-slate-800 font-mono mt-1">{{ number_format($visitorStats['this_month'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">Bulan berjalan</span>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Tahun Ini</span>
                <div class="text-xl sm:text-2xl font-extrabold text-slate-800 font-mono mt-1">{{ number_format($visitorStats['this_year'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">Tahun berjalan</span>
            </div>

            <div class="p-4 rounded-2xl bg-[#F4F7FB] border border-slate-200/80 hover:border-blue-300 transition-colors">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Total Kunjungan</span>
                <div class="text-xl sm:text-2xl font-extrabold text-[#0064D2] font-mono mt-1">{{ number_format($visitorStats['total'], 0, ',', '.') }}</div>
                <span class="text-[10px] text-slate-500 font-medium">Semua kunjungan</span>
            </div>
        </div>
    </div>
</section>

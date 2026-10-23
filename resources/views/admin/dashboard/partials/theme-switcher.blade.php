            <!-- KARTU KHUSUS: PENGATURAN MULTI-SITUS & GANTI TEMA (SUPERADMIN) -->
            @if ($isSuperadmin)
                <div id="section-theme-switcher" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                                <i data-lucide="palette" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="font-extrabold text-base text-slate-900">Pengaturan Multi-Situs & Tema Beranda Publik</h2>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-[#FEDD00] text-slate-900">Superadmin</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Pilih tema tampilan yang aktif untuk rute beranda publik (<code>/</code>). Di produksi, sistem otomatis mengikuti custom domain pengunjung.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-slate-500 font-medium">Tema Aktif:</span>
                            <span class="px-3 py-1 rounded-xl font-mono font-bold uppercase tracking-wider text-[#0064D2] bg-blue-50 border border-blue-200 shadow-2xs">
                                {{ $globalSetting->active_theme ?? 'tiketdieng' }}
                            </span>
                        </div>
                    </div>

                    <!-- Pilihan 4 Tema Sub-Unit Bisnis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- 1. Tiket Dieng (Portal Induk) -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="tiketdieng" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'tiketdieng' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-blue-300 peer-checked:border-[#0064D2] peer-checked:bg-blue-50/50 peer-checked:ring-2 peer-checked:ring-blue-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#0064D2] flex items-center justify-center font-bold text-xs font-mono">
                                            01
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-blue-100 text-[#0064D2]">
                                            Portal Induk
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-[#0064D2] transition-colors">Tiket Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Portal biro perjalanan terlengkap, paket VIP tour, sunrise Sikunir, kawah, dan candi Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>tiketdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=tiketdieng') }}" target="_blank" class="text-[11px] font-bold text-[#0064D2] hover:text-[#0051A8] flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-[#0064D2] peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 2. Lotus Creative -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="lotus" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'lotus' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-purple-300 peer-checked:border-purple-500 peer-checked:bg-purple-50/50 peer-checked:ring-2 peer-checked:ring-purple-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xs font-mono">
                                            02
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">
                                            Creative Studio
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-purple-700 transition-colors">Lotus Creative</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Layanan dokumentasi foto liburan estetik, video cinematic reels, dan pilot drone 4K Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>lotuscreative.id</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=lotus') }}" target="_blank" class="text-[11px] font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-purple-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 3. Jeep Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="jeep" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'jeep' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 peer-checked:ring-2 peer-checked:ring-emerald-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs font-mono">
                                            03
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                            Adventure 4x4
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-700 transition-colors">Jeep Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Sewa Jeep wisata offroad 4x4, rute fun trip, sunrise Bukit Sikunir, kawah & telaga Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>jeepdieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=jeep') }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-emerald-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>

                        <!-- 4. Shuttle Dieng -->
                        <label class="relative group cursor-pointer block">
                            <input type="radio" name="active_theme" value="shuttle" {{ old('active_theme', $globalSetting->active_theme ?? 'tiketdieng') === 'shuttle' ? 'checked' : '' }} class="peer sr-only">
                            <div class="p-5 rounded-2xl border transition-all duration-300 h-full flex flex-col justify-between bg-slate-50/60 border-slate-200 hover:border-sky-300 peer-checked:border-sky-500 peer-checked:bg-sky-50/50 peer-checked:ring-2 peer-checked:ring-sky-100 shadow-2xs">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs font-mono">
                                            04
                                        </span>
                                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-sky-100 text-sky-700">
                                            Transportasi
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-sm text-slate-900 group-hover:text-sky-700 transition-colors">Shuttle Dieng</h3>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                        Armada mikrobus 15 kursi ber-AC, antar-jemput stasiun/bandara ke Dataran Tinggi Dieng.
                                    </p>
                                    <div class="mt-2.5 text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                        <i data-lucide="globe" class="w-3 h-3 text-slate-400"></i>
                                        <span>shuttledieng.com</span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                    <a href="{{ url('/?theme=shuttle') }}" target="_blank" class="text-[11px] font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1 transition-colors" onclick="event.stopPropagation()">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        <span>Preview</span>
                                    </a>
                                    <span class="text-[11px] font-bold text-sky-600 peer-checked:inline hidden">✓ Dipilih</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 flex items-center justify-between shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="layers" class="w-4 h-4 text-[#0064D2]"></i>
                        <span class="text-xs text-slate-600">Tema Beranda Aktif:</span>
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold uppercase tracking-wider text-[#0064D2] bg-blue-50 border border-blue-200">
                            {{ $globalSetting->active_theme ?? 'tiketdieng' }}
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-400">Dikelola oleh Super Administrator</span>
                </div>
            @endif

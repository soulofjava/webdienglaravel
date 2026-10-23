        <!-- TAB PEMILIH SUB-WEB PENGATURAN (MULTI-SITE SETTINGS) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Pilih Sub-Web Yang Dikonfigurasi:</span>
                        <p class="text-[11px] text-slate-500">Konfigurasi berlaku spesifik untuk unit bisnis yang dipilih di bawah</p>
                    </div>
                </div>
                <div class="text-[11px] text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/80">
                    Profil Aktif: <strong class="text-[#0064D2] font-bold">{{ $supportedSites[$selectedSite]['name'] }}</strong> (<code class="text-slate-500">{{ $supportedSites[$selectedSite]['domain'] }}</code>)
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($supportedSites as $siteKey => $siteInfo)
                    @php
                        $isActiveTab = ($selectedSite === $siteKey);
                    @endphp
                    <a
                        href="{{ route('admin.index', ['site' => $siteKey]) }}"
                        class="p-4 rounded-2xl border transition-all flex flex-col justify-between gap-3 {{ $isActiveTab ? 'bg-blue-50/70 border-2 border-[#0064D2] shadow-sm' : 'bg-slate-50/60 border-slate-200 hover:border-slate-300 hover:bg-slate-100/60' }}"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded-md uppercase font-bold {{ $isActiveTab ? 'bg-[#0064D2] text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $siteInfo['badge'] }}
                            </span>
                            @if ($isActiveTab)
                                <span class="w-2.5 h-2.5 rounded-full bg-[#0064D2] ring-4 ring-blue-100"></span>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs sm:text-sm font-extrabold block {{ $isActiveTab ? 'text-[#0064D2]' : 'text-slate-800' }}">
                                {{ $siteInfo['name'] }}
                            </span>
                            <span class="text-[10px] font-mono text-slate-500 block truncate mt-0.5">
                                {{ $siteInfo['domain'] }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

            <!-- Kartu 1: Identitas Platform -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">1. Identitas Situs Web</h2>
                        <p class="text-xs text-slate-500">
                            Nama jenama dan slogan yang tampil pada bilah navigasi dan footer
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nama Situs / Jenama
                        </label>
                        <input
                            type="text"
                            name="site_name"
                            id="inputSiteName"
                            value="{{ old('site_name', $settings->site_name) }}"
                            required
                            placeholder="TIKETDIENG.COM"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Slogan / Subjudul
                        </label>
                        <input
                            type="text"
                            name="site_tagline"
                            value="{{ old('site_tagline', $settings->site_tagline) }}"
                            required
                            placeholder="Biro Wisata Dataran Tinggi Dieng"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nama Perusahaan / Badan Hukum Resmi
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name', $settings->company_name) }}"
                            placeholder="PT. GOTRIP ASIA TRAVELINDO"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="upload-cloud" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Ikon Tab Peramban (Favicon)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Mendukung berkas .ico, .png, .svg, .webp
                            </span>
                        </label>

                        <!-- Area Pratinjau & Tombol Unggah Berkas -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <!-- Pratinjau Ikon Aktif -->
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden p-2 shrink-0 shadow-2xs">
                                    <img
                                        id="faviconPreview"
                                        src="{{ $settings->favicon_url ?: asset('favicon.ico') }}"
                                        alt="Pratinjau Favicon"
                                        class="w-full h-full object-contain"
                                        onerror="this.src='{{ asset('favicon.ico') }}'"
                                    />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800">Pratinjau Ikon Tab Aktif</p>
                                    <p class="text-[11px] text-slate-500 truncate" id="faviconText">
                                        {{ $settings->favicon_url ?: 'Ikon bawaan aktif' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Pemilih Berkas Ajax -->
                            <div class="w-full sm:w-auto shrink-0">
                                <label class="w-full sm:w-auto relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 border border-blue-200 cursor-pointer transition-all">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    <span id="faviconBtnText">Unggah Berkas Baru</span>
                                    <input
                                        type="file"
                                        id="fileFavicon"
                                        accept=".ico,.png,.svg,.webp,.jpg,.jpeg"
                                        class="hidden"
                                    />
                                </label>
                            </div>
                        </div>

                        <!-- Input Alternatif URL Langsung -->
                        <div class="mt-3">
                            <input
                                type="text"
                                name="favicon_url"
                                id="inputFaviconUrl"
                                value="{{ old('favicon_url', $settings->favicon_url) }}"
                                placeholder="Atau masukkan tautan URL favicon langsung: /favicon.ico atau https://..."
                                class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs transition-colors"
                            />
                        </div>
                    </div>
                </div>
            </div>

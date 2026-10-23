            <!-- Kartu 2: Profil Perusahaan, Visi & Misi -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                        <i data-lucide="compass" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">2. Profil Perusahaan, Visi & Misi</h2>
                        <p class="text-xs text-slate-500">
                            Narasi resmi biro wisata, sejarah berdiri, tujuan jangka panjang, serta komitmen pelayanan ke wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Tentang Kami (Profil Singkat)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Tampil di beranda & profil biro</span>
                        </label>
                        <textarea
                            name="about_us"
                            rows="3"
                            placeholder="Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                        >{{ old('about_us', $settings->about_us) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-purple-600"></i>
                                <span>Sejarah Singkat & Tahun Berdiri</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">Didirikan 2022 di bawah PT. GOtrip Asia</span>
                        </label>
                        <textarea
                            name="company_history"
                            rows="3"
                            placeholder="Tiket Wisata Dieng berdiri sejak tahun 2022 di bawah naungan resmi induk PT. GOtrip Asia Travelindo..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                        >{{ old('company_history', $settings->company_history) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="eye" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Visi Perusahaan (Tujuan Jangka Panjang)</span>
                            </label>
                            <textarea
                                name="company_vision"
                                rows="3"
                                placeholder="Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman..."
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                            >{{ old('company_vision', $settings->company_vision) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="target" class="w-3.5 h-3.5 text-sky-600"></i>
                                <span>Misi Perusahaan & Komitmen Layanan</span>
                            </label>
                            <textarea
                                name="company_mission"
                                rows="3"
                                placeholder="Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo..."
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm leading-relaxed"
                            >{{ old('company_mission', $settings->company_mission) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

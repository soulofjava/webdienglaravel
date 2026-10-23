            <!-- Kartu 4: Alamat & Legalitas -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">4. Alamat Kantor & Legalitas Usaha</h2>
                        <p class="text-xs text-slate-500">
                            Informasi terpercaya yang membangun kredibilitas bagi calon wisatawan
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Alamat Lengkap Kantor Operasional
                        </label>
                        <textarea
                            name="address"
                            rows="3"
                            required
                            placeholder="Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo, Jawa Tengah 56354"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm resize-none"
                        >{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                    <span>Nomor Legalitas NIB / Perizinan Usaha</span>
                                </label>
                                @unless ($isSuperadmin)
                                    <span class="text-[10px] font-bold text-amber-600 flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-md">
                                        <i data-lucide="lock" class="w-3 h-3"></i> Superadmin
                                    </span>
                                @endunless
                            </div>
                            <input
                                type="text"
                                name="legal_nib"
                                value="{{ old('legal_nib', $settings->legal_nib) }}"
                                placeholder="Contoh: NIB: 1294801928472"
                                @unless ($isSuperadmin) readonly disabled @endunless
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Lencana Asosiasi / Sertifikasi Pemandu</span>
                            </label>
                            <input
                                type="text"
                                name="hpi_badge"
                                value="{{ old('hpi_badge', $settings->hpi_badge) }}"
                                placeholder="Contoh: Anggota Resmi HPI Dieng"
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                            />
                        </div>
                    </div>

                    <!-- Informasi Rekening Bank Perusahaan -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                                <i data-lucide="credit-card" class="w-4 h-4 text-[#0064D2]"></i>
                                <span>Rekening Resmi Pembayaran / Reservasi</span>
                            </h3>
                            @unless ($isSuperadmin)
                                <span class="text-[10px] font-bold text-amber-700 flex items-center gap-1 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                    <i data-lucide="lock" class="w-3 h-3"></i> Terkunci (Superadmin Only)
                                </span>
                            @endunless
                        </div>

                        @unless ($isSuperadmin)
                            <div class="p-3 mb-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-4 h-4 shrink-0 text-amber-600"></i>
                                <span>Rekening pembayaran resmi dilindungi dan hanya dapat diperbarui oleh Super Administrator demi integritas transaksi.</span>
                            </div>
                        @endunless

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Nama Bank & Cabang</label>
                                <input
                                    type="text"
                                    name="bank_name"
                                    value="{{ old('bank_name', $settings->bank_name) }}"
                                    placeholder="BNI Cabang Wonosobo"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Nomor Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_number"
                                    value="{{ old('bank_account_number', $settings->bank_account_number) }}"
                                    placeholder="8166754042"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs font-mono @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Atas Nama Rekening</label>
                                <input
                                    type="text"
                                    name="bank_account_name"
                                    value="{{ old('bank_account_name', $settings->bank_account_name) }}"
                                    placeholder="PT. GOTRIP ASIA TRAVELINDO"
                                    @unless ($isSuperadmin) readonly disabled @endunless
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs @unless($isSuperadmin) bg-slate-100 text-slate-500 cursor-not-allowed @endunless"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Tautan Media Sosial Resmi -->
                    <div class="pt-4 border-t border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-3 flex items-center gap-1.5">
                            <i data-lucide="share-2" class="w-4 h-4 text-sky-600"></i>
                            <span>Akun Media Sosial Resmi</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Instagram URL</label>
                                <input
                                    type="text"
                                    name="instagram_url"
                                    value="{{ old('instagram_url', $settings->instagram_url) }}"
                                    placeholder="https://www.instagram.com/..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">TikTok URL</label>
                                <input
                                    type="text"
                                    name="tiktok_url"
                                    value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                                    placeholder="https://tiktok.com/@..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1.5">Facebook URL</label>
                                <input
                                    type="text"
                                    name="facebook_url"
                                    value="{{ old('facebook_url', $settings->facebook_url) }}"
                                    placeholder="https://www.facebook.com/..."
                                    class="w-full p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

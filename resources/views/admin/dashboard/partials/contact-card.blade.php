            <!-- Kartu 3: Kontak & Pemesanan -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900">3. Saluran Komunikasi & Reservasi</h2>
                        <p class="text-xs text-slate-500">
                            Nomor WhatsApp dan telepon untuk kalkulator reservasi otomatis
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                            <span>Nomor WhatsApp Reservasi</span>
                        </label>
                        <input
                            type="text"
                            name="whatsapp_number"
                            value="{{ old('whatsapp_number', $settings->whatsapp_number) }}"
                            required
                            placeholder="62816675404"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">
                            Gunakan awalan angka 62 tanpa spasi atau strip (misal: 62816675404)
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-sky-600"></i>
                            <span>Tampilan Nomor Telepon</span>
                        </label>
                        <input
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $settings->phone_number) }}"
                            required
                            placeholder="+62 816-675-404"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-1.5">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                            <span>Alamat Email Layanan Resmi</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $settings->email) }}"
                            required
                            placeholder="halo@tiketdieng.com"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                    </div>
                </div>
            </div>

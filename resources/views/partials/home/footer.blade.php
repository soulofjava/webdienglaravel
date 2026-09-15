<!-- 9. FOOTER SINEMATIK & LEGALITAS BIRO PERJALANAN -->
    <footer class="bg-[#04060a] border-t border-white/10 text-slate-400 text-xs pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                <!-- Col 1: Brand & Legalitas -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-tiketdieng-transparent.png') }}?v=2" alt="{{ $settings->site_name }}" class="h-9 w-auto object-contain brightness-110">
                    </div>
                    <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                        {{ $settings->site_tagline }}. Bagian resmi dari <strong class="text-white">{{ $settings->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO' }}</strong>. Menghadirkan kemudahan reservasi akomodasi, sewa jeep, shuttle, dokumentasi sinematik, dan outbound profesional di Dieng.
                    </p>
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-amber-300 font-semibold">
                            {{ $settings->legal_nib }}
                        </span>
                        <span class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[10px] text-emerald-300 font-semibold">
                            {{ $settings->hpi_badge }}
                        </span>
                    </div>

                    <!-- Rekening Resmi Perusahaan -->
                    <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 space-y-1 mt-3">
                        <div class="text-[10px] uppercase font-bold tracking-wider text-amber-400 flex items-center gap-1.5">
                            <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                            <span>Rekening Resmi Pembayaran:</span>
                        </div>
                        <p class="text-xs font-mono font-bold text-white tracking-wider">BNI: 8166754042</p>
                        <p class="text-[11px] text-slate-400">a.n. PT. GOTRIP ASIA TRAVELINDO (Cab. Wonosobo)</p>
                    </div>

                    <!-- Social Media Links -->
                    <div class="flex items-center gap-3 pt-2 text-slate-400">
                        <a href="https://www.instagram.com/tiketwisatadieng?stkn=MWpxamRlbjkxd3I1Yg==" target="_blank" class="hover:text-pink-400 transition-colors flex items-center gap-1.5 text-xs">
                            <svg class="w-4 h-4 text-pink-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>@tiketwisatadieng</span>
                        </a>
                        <span>•</span>
                        <a href="https://tiktok.com/@tiketdieng.com" target="_blank" class="hover:text-cyan-400 transition-colors flex items-center gap-1.5 text-xs">
                            <i data-lucide="video" class="w-4 h-4 text-cyan-400"></i>
                            <span>TikTok</span>
                        </a>
                        <span>•</span>
                        <a href="https://www.facebook.com/share/1Hj4SzNUzH/" target="_blank" class="hover:text-blue-400 transition-colors flex items-center gap-1.5 text-xs">
                            <svg class="w-4 h-4 text-blue-400 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Destinasi Ikonik -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Informasi & Navigasi</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#dokumentasi" class="text-cyan-300 font-semibold hover:text-cyan-400 transition-colors flex items-center gap-1.5"><i data-lucide="camera" class="w-3.5 h-3.5 text-cyan-400"></i><span>Foto & Drone (Lotus Creative)</span></a></li>
                        <li><a href="#profil" class="text-amber-300 font-semibold hover:text-amber-400 transition-colors flex items-center gap-1.5"><i data-lucide="compass" class="w-3.5 h-3.5 text-amber-400"></i><span>Profil & Visi Misi</span></a></li>
                        <li><a href="#paket" class="hover:text-amber-400 transition-colors">Paket Wisata Pilihan</a></li>
                        <li><a href="#sikunir" class="hover:text-amber-400 transition-colors">Golden Sunrise Sikunir</a></li>
                        <li><a href="#sikidang" class="hover:text-amber-400 transition-colors">Kawah Sikidang Purba</a></li>
                        <li><a href="#telagawarna" class="hover:text-amber-400 transition-colors">Telaga Warna & Pengilon</a></li>
                        <li><a href="#candi-arjuna" class="hover:text-amber-400 transition-colors">Kompleks Candi Arjuna</a></li>
                        <li><a href="#kalkulator" class="hover:text-amber-400 transition-colors">Kalkulator Reservasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Produk -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Layanan Vendor</h4>
                    <ul class="space-y-2.5">
                        <li>Dokumentasi & Drone 4K (Lotus Creative)</li>
                        <li>Jeep Wisata Dieng 4x4</li>
                        <li>Shuttle Bus Wisata 15 Seat</li>
                        <li>Reservasi Villa & Homestay</li>
                        <li>Paket Outbound & Gathering</li>
                        <li>Pemandu Wisata Resmi HPI</li>
                    </ul>
                </div>

                <!-- Col 4: Kantor & Kontak -->
                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-4">Kontak Resmi</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5"></i>
                            <span>{{ $settings->address ?? 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400 flex-shrink-0"></i>
                            <span class="text-white font-medium">{{ $settings->phone_number ?? '0816675404' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="message-circle" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" target="_blank" class="hover:text-amber-400 transition-colors">
                                WhatsApp: {{ $settings->whatsapp_number }}
                            </a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                            <span>{{ $settings->email ?? 'tiket.wisatadieng@gmail.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom credit -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
                <p>© {{ date('Y') }} {{ $settings->site_name }}. Hak cipta dilindungi undang-undang.</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 text-[11px]">
                    <span>Dikembangkan oleh <a href="https://soulofjava.github.io/myportofolio/" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-amber-400 font-medium underline underline-offset-2 decoration-amber-500/30 hover:decoration-amber-400 transition-colors">Isa Maulana</a></span>
                </div>
            </div>
        </div>
    </footer>

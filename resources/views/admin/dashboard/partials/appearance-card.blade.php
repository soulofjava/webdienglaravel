            <!-- Kartu 6: Pengaturan Tampilan & Desain Tema -->
            <div 
                x-data="{
                    primaryColor: '{{ old('primary_color', $settings->primary_color ?? '#0064D2') }}',
                    accentColor: '{{ old('accent_color', $settings->accent_color ?? '#FEDD00') }}',
                    waColor: '{{ old('whatsapp_color', $settings->whatsapp_color ?? '#25D366') }}',
                    fontFamily: '{{ old('font_family', $settings->font_family ?? 'Plus Jakarta Sans') }}',
                    fontSizeScale: '{{ old('font_size_scale', $settings->font_size_scale ?? 'normal') }}',
                    borderRadiusStyle: '{{ old('border_radius_style', $settings->border_radius_style ?? 'rounded-3xl') }}',
                    heroOverlap: {{ old('hero_widget_overlap', $settings->hero_widget_overlap ?? true) ? 'true' : 'false' }},
                    savingAppearance: false,
                    saveMsg: '',
                    applyPreset(p, a, w) {
                        this.primaryColor = p;
                        this.accentColor = a;
                        this.waColor = w;
                    },
                    submitAppearanceOnly() {
                        this.savingAppearance = true;
                        this.saveMsg = '';
                        const form = document.getElementById('settingsForm');
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('site_key', '{{ $selectedSite }}');
                        formData.append('primary_color', this.primaryColor);
                        formData.append('accent_color', this.accentColor);
                        formData.append('whatsapp_color', this.waColor);
                        formData.append('font_family', this.fontFamily);
                        formData.append('font_size_scale', this.fontSizeScale);
                        formData.append('border_radius_style', this.borderRadiusStyle);
                        formData.append('hero_widget_overlap', this.heroOverlap ? '1' : '0');

                        fetch('{{ route('admin.settings.appearance') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.savingAppearance = false;
                            if (data.success) {
                                this.saveMsg = 'Pengaturan desain berhasil disimpan!';
                                setTimeout(() => { this.saveMsg = ''; }, 4000);
                            } else {
                                this.saveMsg = 'Gagal menyimpan pengaturan: ' + (data.message || 'Terjadi kesalahan');
                            }
                        })
                        .catch(err => {
                            this.savingAppearance = false;
                            this.saveMsg = 'Terjadi kesalahan jaringan.';
                        });
                    }
                }"
                class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-8"
            >
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 shadow-xs">
                            <i data-lucide="palette" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h2 class="font-extrabold text-base sm:text-lg text-slate-900">6. Pengaturan Tampilan dan Desain Tema</h2>
                            <p class="text-xs text-slate-500">
                                Kustomisasi warna utama, aksen, WhatsApp, tipografi, skala font, dan tata letak publik
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Simpan Khusus Bagian Desain -->
                    <div class="flex items-center gap-2">
                        <span x-show="saveMsg" x-text="saveMsg" class="text-xs font-bold text-emerald-600 transition-all"></span>
                        <button
                            type="button"
                            @click="submitAppearanceOnly()"
                            :disabled="savingAppearance"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95 disabled:opacity-50 cursor-pointer"
                        >
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span x-text="savingAppearance ? 'Menyimpan...' : 'Simpan Desain'">Simpan Desain</span>
                        </button>
                    </div>
                </div>

                <!-- Bagian 1: Palet Warna Brand -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            A. Palet Warna Utama & Aksen
                        </label>
                        <!-- Quick Palette Presets -->
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-[11px] text-slate-400 font-medium hidden sm:inline">Preset Cepat:</span>
                            <button type="button" @click="applyPreset('#0064D2', '#FEDD00', '#25D366')" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition-colors">Tiketdieng</button>
                            <button type="button" @click="applyPreset('#7C3AED', '#FBBF24', '#25D366')" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100 transition-colors">Lotus</button>
                            <button type="button" @click="applyPreset('#059669', '#F59E0B', '#25D366')" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors">Jeep</button>
                            <button type="button" @click="applyPreset('#0284C7', '#FDE047', '#25D366')" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 transition-colors">Shuttle</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <!-- Primary Color -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">Primary Color</span>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-600 font-mono" x-text="primaryColor">#0064D2</span>
                            </div>
                            <p class="text-[11px] text-slate-500">Warna hero banner, tombol utama & navigasi</p>
                            <div class="flex items-center gap-2.5 pt-1">
                                <input
                                    type="color"
                                    x-model="primaryColor"
                                    class="w-10 h-10 rounded-xl cursor-pointer border border-slate-300 p-0.5 bg-white shadow-xs shrink-0"
                                />
                                <input
                                    type="text"
                                    name="primary_color"
                                    x-model="primaryColor"
                                    placeholder="#0064D2"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:border-indigo-600 focus:ring-indigo-600 text-xs font-mono font-bold bg-white text-slate-800"
                                />
                            </div>
                        </div>

                        <!-- Accent Color -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">Accent Color</span>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-600 font-mono" x-text="accentColor">#FEDD00</span>
                            </div>
                            <p class="text-[11px] text-slate-500">Warna teks sorotan hero, ikon & badge aktif</p>
                            <div class="flex items-center gap-2.5 pt-1">
                                <input
                                    type="color"
                                    x-model="accentColor"
                                    class="w-10 h-10 rounded-xl cursor-pointer border border-slate-300 p-0.5 bg-white shadow-xs shrink-0"
                                />
                                <input
                                    type="text"
                                    name="accent_color"
                                    x-model="accentColor"
                                    placeholder="#FEDD00"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:border-indigo-600 focus:ring-indigo-600 text-xs font-mono font-bold bg-white text-slate-800"
                                />
                            </div>
                        </div>

                        <!-- WhatsApp Color -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">WhatsApp Color</span>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-600 font-mono" x-text="waColor">#25D366</span>
                            </div>
                            <p class="text-[11px] text-slate-500">Warna tombol floating WhatsApp publik</p>
                            <div class="flex items-center gap-2.5 pt-1">
                                <input
                                    type="color"
                                    x-model="waColor"
                                    class="w-10 h-10 rounded-xl cursor-pointer border border-slate-300 p-0.5 bg-white shadow-xs shrink-0"
                                />
                                <input
                                    type="text"
                                    name="whatsapp_color"
                                    x-model="waColor"
                                    placeholder="#25D366"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:border-indigo-600 focus:ring-indigo-600 text-xs font-mono font-bold bg-white text-slate-800"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian 2: Tipografi & Skala Ukuran Font -->
                <div class="space-y-4 border-t border-slate-100 pt-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        B. Tipografi & Skala Ukuran Teks
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Dropdown Pilihan Font -->
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-700">
                                Font Family (Google Fonts)
                            </label>
                            <select
                                name="font_family"
                                x-model="fontFamily"
                                class="w-full p-3 rounded-xl border border-slate-300 focus:border-indigo-600 focus:ring-indigo-600 bg-white text-slate-800 text-sm transition-colors"
                            >
                                <option value="Plus Jakarta Sans">Plus Jakarta Sans (Modern Geometric, Bawaan)</option>
                                <option value="Inter">Inter (Netral, Sangat Jelas & Terstruktur)</option>
                                <option value="Outfit">Outfit (Ramah, Luwes & Kontemporer)</option>
                                <option value="Poppins">Poppins (Tegas, Bulat & Segar)</option>
                                <option value="Playfair Display">Playfair Display (Klasik, Anggun & Editorial Serif)</option>
                            </select>
                            <p class="text-[11px] text-slate-500">Font utama yang diterapkan pada seluruh konten portal.</p>
                        </div>

                        <!-- Radio Preset Skala Ukuran Font -->
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-700">
                                Skala Ukuran Font (Preset)
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <label 
                                    class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="fontSizeScale === 'compact' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="font_size_scale" value="compact" x-model="fontSizeScale" class="sr-only">
                                    <span class="text-xs">Compact</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">15px (Padat)</span>
                                </label>

                                <label 
                                    class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="fontSizeScale === 'normal' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="font_size_scale" value="normal" x-model="fontSizeScale" class="sr-only">
                                    <span class="text-xs">Normal</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">16px (Standar)</span>
                                </label>

                                <label 
                                    class="relative flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="fontSizeScale === 'relaxed' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="font_size_scale" value="relaxed" x-model="fontSizeScale" class="sr-only">
                                    <span class="text-xs">Relaxed</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">17px (Luwes)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian 3: Tata Letak (Border Radius & Overlap Widget) -->
                <div class="space-y-4 border-t border-slate-100 pt-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        C. Tata Letak (Layout & Kelengkungan)
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Border Radius Style -->
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-700">
                                Gaya Sudut Kotak (Border Radius)
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <label 
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="borderRadiusStyle === 'rounded-3xl' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="border_radius_style" value="rounded-3xl" x-model="borderRadiusStyle" class="sr-only">
                                    <span class="text-xs">rounded-3xl</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">24px (Ekstra)</span>
                                </label>

                                <label 
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="borderRadiusStyle === 'rounded-xl' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="border_radius_style" value="rounded-xl" x-model="borderRadiusStyle" class="sr-only">
                                    <span class="text-xs">rounded-xl</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">12px (Sedang)</span>
                                </label>

                                <label 
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="borderRadiusStyle === 'rounded-lg' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                >
                                    <input type="radio" name="border_radius_style" value="rounded-lg" x-model="borderRadiusStyle" class="sr-only">
                                    <span class="text-xs">rounded-lg</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">8px (Minimal)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Hero Widget Overlap -->
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-700">
                                Posisi Widget Pencarian Hero
                            </label>
                            <input type="hidden" name="hero_widget_overlap" value="0">
                            <div class="grid grid-cols-2 gap-2">
                                <label 
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="heroOverlap ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                    @click="heroOverlap = true"
                                >
                                    <input type="checkbox" name="hero_widget_overlap" value="1" :checked="heroOverlap" class="sr-only">
                                    <span class="text-xs">Mengambang (Overlap)</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">-mt-16 di atas hero</span>
                                </label>

                                <label 
                                    class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer text-center transition-all"
                                    :class="!heroOverlap ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'"
                                    @click="heroOverlap = false"
                                >
                                    <span class="text-xs">Rata (Flow Normal)</span>
                                    <span class="text-[10px] text-slate-500 mt-0.5">mt-6 di bawah hero</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian 4: Pratinjau Langsung (Live Interactive Preview) -->
                <div class="border-t border-slate-100 pt-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">
                            Pratinjau Tampilan Cepat (Live Preview)
                        </span>
                        <span class="text-[11px] text-slate-400">Merender warna dan font yang dipilih</span>
                    </div>

                    <div 
                        class="p-6 rounded-2xl border border-slate-200 shadow-sm transition-all"
                        :style="{
                            fontFamily: fontFamily + ', sans-serif',
                            backgroundColor: '#F8FAFC'
                        }"
                    >
                        <!-- Mini Hero Demo -->
                        <div 
                            class="p-5 text-white shadow-md transition-all relative overflow-hidden"
                            :class="borderRadiusStyle"
                            :style="{
                                background: 'linear-gradient(135deg, ' + primaryColor + ' 0%, #001f4d 100%)'
                            }"
                        >
                            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-white/20">Contoh Banner Hero</span>
                            <h3 class="text-lg sm:text-xl font-black mt-2">
                                Eksplorasi Keajaiban Dieng <span :style="{ color: accentColor }">Fajar Emas</span>
                            </h3>
                            <p class="text-xs text-white/80 mt-1">Rasakan kenyamanan perjalanan berwisata dengan konfigurasi tema terkini.</p>
                        </div>

                        <!-- Mini Floating Demo & Button -->
                        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button"
                                    class="px-4 py-2 text-xs font-bold text-white transition-all shadow-sm"
                                    :class="borderRadiusStyle"
                                    :style="{ backgroundColor: primaryColor }"
                                >
                                    Tombol Utama
                                </button>
                                <button 
                                    type="button"
                                    class="px-4 py-2 text-xs font-bold text-slate-900 transition-all shadow-sm"
                                    :class="borderRadiusStyle"
                                    :style="{ backgroundColor: accentColor }"
                                >
                                    Aksen Sorotan
                                </button>
                            </div>

                            <!-- Mini WhatsApp Pill -->
                            <div 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-white text-xs font-bold shadow-sm"
                                :style="{ backgroundColor: waColor }"
                            >
                                <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                <span>WhatsApp ({{ $settings->whatsapp_number ?? '0816675404' }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

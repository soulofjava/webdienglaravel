            <!-- Kartu 5: Optimasi SEO & Social Media Share -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#0064D2] flex items-center justify-center shrink-0">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-extrabold text-base text-slate-900">5. Optimasi Mesin Pencari & Sosial Media (SEO)</h2>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-[#0064D2] border border-blue-200">
                                GOOGLE & MEDSOS
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">
                            Konfigurasi judul Google, deskripsi pencarian, dan gambar kartu berbagi WhatsApp
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- SEO Title -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Judul Penelusuran Google & Tab Browser (Meta Title)</span>
                            </label>
                            <span id="seoTitleCount" class="text-[11px] font-semibold text-slate-500">
                                {{ strlen($settings->seo_title ?? '') }}/60 karakter ideal
                            </span>
                        </div>
                        <input
                            type="text"
                            name="seo_title"
                            id="inputSeoTitle"
                            value="{{ old('seo_title', $settings->seo_title) }}"
                            placeholder="Otomatis mengikuti: {{ $settings->site_name }} — {{ $settings->site_tagline }}"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Judul utama pada tab peramban dan pencarian Google. <span class="text-[#0064D2] font-semibold">Kosongkan jika ingin selalu otomatis mengikuti Nama Situs & Slogan.</span>
                        </p>
                    </div>

                    <!-- SEO Description -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <span>Deskripsi Penelusuran Google (Meta Description)</span>
                            </label>
                            <span id="seoDescCount" class="text-[11px] font-semibold text-slate-500">
                                {{ strlen($settings->seo_description ?? '') }}/160 karakter ideal
                            </span>
                        </div>
                        <textarea
                            name="seo_description"
                            id="inputSeoDesc"
                            rows="3"
                            placeholder="Biro perjalanan wisata resmi Dataran Tinggi Dieng..."
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors resize-none leading-relaxed"
                        >{{ old('seo_description', $settings->seo_description) }}</textarea>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Rangkuman singkat yang memikat calon pelanggan di bawah tautan Google.
                        </p>
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Target Kata Kunci Penelusuran (Keywords)
                        </label>
                        <input
                            type="text"
                            name="seo_keywords"
                            value="{{ old('seo_keywords', $settings->seo_keywords) }}"
                            placeholder="paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir"
                            class="w-full p-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-sm transition-colors"
                        />
                        <p class="text-[11px] text-slate-500 mt-1">
                            Pisahkan setiap kata kunci menggunakan tanda koma (,).
                        </p>
                    </div>

                    <!-- OG Image Upload & Preview -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="share-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Gambar Banner Berbagi Medsos & WhatsApp (OG Image)</span>
                            </span>
                            <span class="text-[11px] font-normal text-slate-400 lowercase">
                                Rasio 1.91:1 (ideal 1200x630 px)
                            </span>
                        </label>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-24 sm:w-28 h-14 sm:h-16 rounded-xl bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center shrink-0 shadow-2xs">
                                    <img
                                        id="ogPreview"
                                        src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                        alt="Pratinjau Banner Medsos"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800">Banner Media Sosial Aktif</p>
                                    <p class="text-[11px] text-slate-500 truncate" id="ogText">
                                        {{ $settings->og_image_url ?: 'Banner standar aktif' }}
                                    </p>
                                </div>
                            </div>
                            <label class="w-full sm:w-auto relative flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 border border-blue-200 cursor-pointer transition-all shrink-0">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                <span id="ogBtnText">Unggah Banner Baru</span>
                                <input
                                    type="file"
                                    id="fileOg"
                                    accept="image/*"
                                    class="hidden"
                                />
                            </label>
                        </div>

                        <input
                            type="text"
                            name="og_image_url"
                            id="inputOgUrl"
                            value="{{ old('og_image_url', $settings->og_image_url) }}"
                            placeholder="Atau masukkan tautan URL gambar langsung..."
                            class="w-full mt-3 p-2.5 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] bg-white text-slate-800 text-xs transition-colors"
                        />
                    </div>

                    <!-- LIVE VISUAL PREVIEW (SERP & WHATSAPP CARD) -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">
                            Pratinjau Tampilan Langsung (Live Visual Preview)
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- SERP Google Preview -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="search" class="w-3 h-3 text-[#0064D2]"></i>
                                    Pratinjau di Google Search
                                </span>
                                <div class="p-4 rounded-xl bg-white border border-slate-200 text-left shadow-2xs">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-4 h-4 rounded-full bg-blue-100 flex items-center justify-center text-[9px] text-[#0064D2] font-bold">
                                            G
                                        </div>
                                        <div class="text-[11px] text-slate-600 truncate">
                                            tiketdieng.com <span class="text-slate-400">› paket-wisata</span>
                                        </div>
                                    </div>
                                    <h4 id="previewGoogleTitle" class="text-sm font-semibold text-[#1a0dab] hover:underline line-clamp-1">
                                        {{ $settings->seo_title ?: $settings->site_name }}
                                    </h4>
                                    <p id="previewGoogleDesc" class="text-xs text-[#4d5156] mt-1 line-clamp-2 leading-relaxed">
                                        {{ $settings->seo_description ?: 'Biro perjalanan wisata resmi Dataran Tinggi Dieng dengan layanan VIP...' }}
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp Share Card Preview -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-1.5">
                                    <i data-lucide="share-2" class="w-3 h-3 text-emerald-600"></i>
                                    Pratinjau Kartu Berbagi WhatsApp
                                </span>
                                <div class="rounded-xl bg-white border border-slate-200 overflow-hidden text-left shadow-2xs">
                                    <div class="h-28 w-full bg-slate-100 overflow-hidden">
                                        <img
                                            id="previewWaImage"
                                            src="{{ $settings->og_image_url ?: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop' }}"
                                            alt="Pratinjau WhatsApp"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div class="p-3 bg-slate-50/80 border-t border-slate-100">
                                        <h4 id="previewWaTitle" class="text-xs font-bold text-slate-900 line-clamp-1">
                                            {{ $settings->seo_title ?: $settings->site_name }}
                                        </h4>
                                        <p id="previewWaDesc" class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">
                                            {{ $settings->seo_description ?: $settings->site_tagline }}
                                        </p>
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1 block">
                                            TIKETDIENG.COM
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- 4. PAKET WISATA UNGGULAN ALL-INCLUSIVE -->
    @php
        $categories = $packages->pluck('category')->unique()->values();
    @endphp
    <section
        id="paket"
        class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-white/5 scroll-mt-20"
        x-data="{
            activeCategory: 'all',
            showAll: false,
            limit: 6,
            packages: [
                @foreach ($packages as $pkg)
                    { id: {{ $pkg->id }}, category: '{{ addslashes($pkg->category) }}' },
                @endforeach
            ],
            isVisible(pkgId) {
                const filtered = this.activeCategory === 'all'
                    ? this.packages
                    : this.packages.filter(p => p.category === this.activeCategory);
                const index = filtered.findIndex(p => p.id === pkgId);
                if (index === -1) return false;
                return this.showAll ? true : index < this.limit;
            },
            totalFiltered() {
                return this.activeCategory === 'all'
                    ? this.packages.length
                    : this.packages.filter(p => p.category === this.activeCategory).length;
            },
            remainingCount() {
                return Math.max(0, this.totalFiltered() - this.limit);
            }
        }"
    >
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Pilihan Paket Wisata Resmi</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-black text-white mt-2 mb-4">Pilihan Paket Wisata Dieng</h2>
            <p class="text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Seluruh program bersifat fleksibel (private tour). Tarif tertera adalah estimasi dasar <span class="text-amber-400 font-medium">mulai dari</span>; ketersediaan kamar homestay, tanggal keberangkatan, dan penyesuaian rute dilayani langsung oleh tim kami via WhatsApp.
            </p>
        </div>

        <!-- Filter Tab Kategori Interaktif -->
        <div class="flex items-center justify-start sm:justify-center sm:flex-wrap gap-2 overflow-x-auto sm:overflow-visible pb-3 mb-10 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
            <button
                @click="activeCategory = 'all'; showAll = false"
                type="button"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 flex-shrink-0 cursor-pointer flex items-center gap-1.5"
                :class="activeCategory === 'all'
                    ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 font-extrabold'
                    : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white border border-white/10'"
            >
                <span>Semua Paket</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeCategory === 'all' ? 'bg-black/15 text-slate-950 font-extrabold' : 'bg-white/10 text-slate-400'">
                    {{ $packages->count() }}
                </span>
            </button>
            @foreach ($categories as $cat)
                @php
                    $catCount = $packages->where('category', $cat)->count();
                @endphp
                <button
                    @click="activeCategory = '{{ $cat }}'; showAll = false"
                    type="button"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 flex-shrink-0 cursor-pointer flex items-center gap-1.5"
                    :class="activeCategory === '{{ $cat }}'
                        ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 font-extrabold'
                        : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white border border-white/10'"
                >
                    <span>{{ $cat }}</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px]" :class="activeCategory === '{{ $cat }}' ? 'bg-black/15 text-slate-950 font-extrabold' : 'bg-white/10 text-slate-400'">
                        {{ $catCount }}
                    </span>
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($packages as $pkg)
                <div
                    x-show="isVisible({{ $pkg->id }})"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="glass-panel p-6 rounded-3xl border {{ $pkg->is_popular ? 'border-2 border-amber-400/80 shadow-2xl shadow-amber-500/10' : 'border-white/10' }} flex flex-col justify-between hover:border-amber-400/60 transition-all duration-300 relative group"
                >
                    @if ($pkg->is_popular || $pkg->badge)
                        <div class="absolute -top-3.5 left-6 px-3 py-0.5 rounded-full text-[10px] font-black uppercase {{ $pkg->is_popular ? 'bg-amber-400 text-slate-950' : 'bg-emerald-400 text-slate-950' }} shadow-md">
                            {{ $pkg->badge ?: 'PALING DIMINATI ★' }}
                        </div>
                    @endif

                    <div>
                        <!-- Thumbnail Cover with Skeleton Loader -->
                        <div class="relative rounded-2xl overflow-hidden aspect-[16/10] mb-4 border border-white/5 bg-slate-900 skeleton-shimmer">
                            <img
                                src="{{ $pkg->image_url }}"
                                alt="{{ $pkg->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 opacity-0"
                                loading="lazy"
                                decoding="async"
                                onload="this.classList.remove('opacity-0'); this.parentElement.classList.remove('skeleton-shimmer');"
                            />
                            <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] text-amber-300 font-semibold border border-white/10">
                                {{ $pkg->duration }}
                            </div>
                        </div>

                        <span class="text-[10px] font-bold text-amber-400 tracking-wider uppercase block">
                            {{ $pkg->category }}
                        </span>
                        <h3 class="font-bold text-lg text-white mt-1 group-hover:text-amber-300 transition-colors line-clamp-1">
                            <a href="{{ route('package.detail', $pkg->slug) }}">
                                {{ $pkg->title }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                            {{ $pkg->summary }}
                        </p>

                        <!-- Estimasi Tarif Mulai Dari -->
                        <div class="my-4 pt-3 border-t border-white/10">
                            <span class="text-[11px] text-amber-400 font-semibold uppercase tracking-wider block">Mulai Dari</span>
                            <div class="text-2xl font-extrabold text-amber-400">
                                {{ $pkg->formatted_price }}
                                <span class="text-xs text-slate-400 font-normal">/ pax</span>
                            </div>
                            <span class="text-[11px] text-slate-400 block mt-0.5">{{ $pkg->price_note }} • Konfirmasi homestay via WA</span>
                        </div>

                        <!-- Highlight Destinasi / Rute -->
                        @if (!empty($pkg->itinerary_options) && count($pkg->itinerary_options) > 0)
                            <div class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                <div class="text-[10px] font-semibold text-slate-400 uppercase">Pilihan Rute & Destinasi:</div>
                                @foreach (array_slice($pkg->itinerary_options, 0, 2) as $opt)
                                    <div class="flex items-start gap-1.5 text-[11px] text-slate-300">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 mt-0.5 flex-shrink-0"></i>
                                        <span class="line-clamp-1 font-medium">{{ $opt['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif (!empty($pkg->inclusions) && count($pkg->inclusions) > 0)
                            <ul class="space-y-1.5 text-xs text-slate-300 mb-6 bg-white/[0.02] p-3 rounded-xl border border-white/5">
                                @foreach (array_slice($pkg->inclusions, 0, 3) as $inc)
                                    <li class="flex items-center gap-1.5 text-[11px]">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-400 flex-shrink-0"></i>
                                        <span class="line-clamp-1">{{ $inc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a
                            href="{{ route('package.detail', $pkg->slug) }}"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-white bg-white/10 hover:bg-white/20 border border-white/10 transition-colors flex items-center justify-center gap-1"
                        >
                            <span>Detail Rute</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>

                        <a
                            href="#kalkulator"
                            onclick="selectPackageInCalculator('{{ $pkg->slug }}')"
                            class="py-2.5 px-3 rounded-xl text-xs font-bold text-center text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-400 transition-all flex items-center justify-center gap-1"
                        >
                            <span>Hitung / Tanya WA</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 glass-panel rounded-3xl border border-white/10 text-slate-400 text-sm">
                    Belum ada paket wisata aktif. Silakan tambahkan melalui panel pengelola admin.
                </div>
            @endforelse

            <!-- Pesan jika filter kategori tidak menemukan data -->
            <div
                x-show="totalFiltered() === 0"
                class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 glass-panel rounded-3xl border border-white/10 text-slate-400 text-sm"
            >
                Tidak ada paket wisata pada kategori ini.
            </div>
        </div>

        <!-- Tombol Muat Lebih Banyak / Ringkas -->
        <div x-show="totalFiltered() > limit" class="mt-12 text-center">
            <button
                @click="showAll = !showAll; if (!showAll) document.getElementById('paket').scrollIntoView({ behavior: 'smooth', block: 'start' });"
                type="button"
                class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer shadow-lg active:scale-95"
                :class="showAll ? 'text-white bg-white/10 hover:bg-white/20 border border-white/15' : 'text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-400 hover:from-amber-300 hover:to-amber-200 shadow-amber-500/20'"
            >
                <span x-show="!showAll" class="inline-flex items-center gap-2">
                    <span>Lihat Semua Paket</span>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-black/15 text-slate-950" x-text="`+${remainingCount()} Paket Lainnya`"></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </span>
                <span x-show="showAll" class="inline-flex items-center gap-2">
                    <span>Tampilkan Lebih Sedikit (Ringkas)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                </span>
            </button>
            <p class="text-xs text-slate-400 mt-2.5" x-show="!showAll">
                Menampilkan <span class="font-bold text-amber-400" x-text="Math.min(limit, totalFiltered())"></span> dari <span class="font-bold text-white" x-text="totalFiltered()"></span> paket wisata aktif
            </p>
        </div>
    </section>

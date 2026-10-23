<!-- 4. PAKET WISATA UNGGULAN ALL-INCLUSIVE (TIKET.COM CATALOG STYLE) -->
@php
    $categories = $packages->pluck('category')->unique()->values();
    $cleanWa = preg_replace('/\D/', '', $settings->whatsapp_number ?? '628123456789');
@endphp

<section
    id="paket"
    class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto scroll-mt-20 my-10 bg-[#F4F7FB] rounded-3xl border border-slate-200/80 shadow-sm text-slate-800"
    x-data="{
        activeCategory: 'all',
        showAll: false,
        limit: 6,
        bookingModalOpen: false,
        selectedPackage: null,
        packages: [
            @foreach ($packages as $pkg)
                { id: {{ $pkg->id }}, category: '{{ addslashes($pkg->category) }}', title: '{{ addslashes($pkg->title) }}', price: '{{ $pkg->formatted_price }}', slug: '{{ $pkg->slug }}' },
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
        },
        openBookingModal(pkg) {
            this.selectedPackage = pkg;
            this.bookingModalOpen = true;
        }
    }"
    @filter-package-category.window="activeCategory = $event.detail; showAll = true;"
>
    <!-- Section Header (tiket.com clean typography) -->
    <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold tracking-wider text-[#0064D2] bg-blue-50 border border-blue-100 uppercase">
            <i data-lucide="tag" class="w-3.5 h-3.5"></i>
            <span>Pilihan Paket Wisata Resmi</span>
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2 mb-3 tracking-tight">
            Pilihan Paket Wisata Dieng Populer
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Seluruh paket private tour berlisensi HPI dengan fasilitas all-inclusive. Tarif transparan <span class="text-[#0064D2] font-semibold">mulai dari</span>, fleksibel disesuaikan dengan kebutuhan keluarga, rombongan, dan instansi.
        </p>
    </div>

    <!-- Filter Tab Kategori Interaktif (Pill style tiket.com) -->
    <div class="flex items-center justify-start sm:justify-center sm:flex-wrap gap-2 overflow-x-auto sm:overflow-visible pb-3 mb-10 no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
        <!-- Tab Semua Paket -->
        <button
            @click="activeCategory = 'all'; showAll = false"
            type="button"
            class="px-4 py-2.5 rounded-full text-xs font-bold transition-all duration-200 flex-shrink-0 cursor-pointer flex items-center gap-1.5 shadow-xs"
            :class="activeCategory === 'all'
                ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/25'
                : 'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-slate-200/80'"
        >
            <span>Semua Paket</span>
            <span
                class="px-2 py-0.5 rounded-full text-[10px]"
                :class="activeCategory === 'all' ? 'bg-white/20 text-white font-extrabold' : 'bg-slate-100 text-slate-600 font-bold'"
            >
                {{ $packages->count() }}
            </span>
        </button>

        <!-- Dynamic Category Pills -->
        @foreach ($categories as $cat)
            @php
                $catCount = $packages->where('category', $cat)->count();
            @endphp
            <button
                @click="activeCategory = '{{ $cat }}'; showAll = false"
                type="button"
                class="px-4 py-2.5 rounded-full text-xs font-bold transition-all duration-200 flex-shrink-0 cursor-pointer flex items-center gap-1.5 shadow-xs"
                :class="activeCategory === '{{ $cat }}'
                    ? 'bg-[#0064D2] text-white shadow-md shadow-blue-500/25'
                    : 'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-slate-200/80'"
            >
                <span>{{ $cat }}</span>
                <span
                    class="px-2 py-0.5 rounded-full text-[10px]"
                    :class="activeCategory === '{{ $cat }}' ? 'bg-white/20 text-white font-extrabold' : 'bg-slate-100 text-slate-600 font-bold'"
                >
                    {{ $catCount }}
                </span>
            </button>
        @endforeach

        @if(isset($docPackages) && $docPackages->count() > 0)
            <a
                href="#dokumentasi"
                class="px-4 py-2.5 rounded-full text-xs font-bold transition-all duration-200 flex-shrink-0 cursor-pointer flex items-center gap-1.5 bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 shadow-xs"
            >
                <i data-lucide="camera" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>Paket Dokumentasi ({{ $docPackages->count() }})</span>
            </a>
        @endif
    </div>

    <!-- Product Card Grid (tiket.com Card Catalog) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
        @forelse ($packages as $pkg)
            @php
                $pkgWaText = urlencode("Halo Admin {$settings->site_name}, saya melihat paket '{$pkg->title}' seharga {$pkg->formatted_price}/pax di website. Saya ingin menanyakan ketersediaan slot armada dan homestay untuk rencana liburan kami. Mohon informasinya! 🙏");
                $pkgWaUrl = "https://wa.me/{$cleanWa}?text={$pkgWaText}";
                $strikePrice = 'Rp ' . number_format($pkg->price * 1.25, 0, ',', '.');
            @endphp

            <div
                x-show="isVisible({{ $pkg->id }})"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="bg-white rounded-2xl border border-slate-200/80 hover:border-[#0064D2]/50 hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group relative"
            >
                <!-- Image Container with Ratio 16:9 -->
                <div class="aspect-[16/9] w-full overflow-hidden relative bg-slate-100">
                    <img
                        src="{{ $pkg->image_url }}"
                        alt="{{ $pkg->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500 opacity-0"
                        loading="lazy"
                        decoding="async"
                        onload="this.classList.remove('opacity-0');"
                    />

                    <!-- Top Left: Category Badge & Popular Badge -->
                    <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start z-10">
                        <span class="bg-white/95 backdrop-blur-md text-[#0064D2] text-[11px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                            {{ $pkg->category }}
                        </span>

                        @if ($pkg->is_popular || $pkg->badge)
                            <span class="bg-[#FEDD00] text-slate-950 font-extrabold text-[10px] px-2.5 py-0.5 rounded-full shadow-sm uppercase tracking-wide flex items-center gap-1">
                                <i data-lucide="zap" class="w-3 h-3 fill-slate-950"></i>
                                <span>{{ $pkg->badge ?: 'PALING LARIS' }}</span>
                            </span>
                        @endif
                    </div>

                    <!-- Top Right: Rating Badge with tiket Yellow Star -->
                    <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-full text-slate-900 text-xs font-bold flex items-center gap-1 shadow-sm z-10">
                        <svg class="w-3.5 h-3.5 fill-[#FEDD00] text-[#FEDD00]" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span>4.9</span>
                        <span class="text-slate-400 font-normal text-[10px]">(120+)</span>
                    </div>

                    <!-- Bottom Left: Duration Badge -->
                    <div class="absolute bottom-2.5 left-2.5 bg-slate-900/75 backdrop-blur-md text-white text-[11px] font-medium px-2.5 py-1 rounded-lg flex items-center gap-1 z-10">
                        <i data-lucide="clock" class="w-3 h-3 text-[#FEDD00]"></i>
                        <span>{{ $pkg->duration }}</span>
                    </div>
                </div>

                <!-- Card Content Body -->
                <div class="p-5 flex flex-col flex-1 justify-between">
                    <div>
                        <!-- Location / Pickup info -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-1">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#0064D2] flex-shrink-0"></i>
                            <span class="line-clamp-1">Jemput: {{ $pkg->pickup_location ?: 'Kota Wonosobo / Dieng' }}</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-base sm:text-lg text-slate-900 group-hover:text-[#0064D2] transition-colors line-clamp-1 leading-snug">
                            <a href="{{ route('package.detail', $pkg->slug) }}">
                                {{ $pkg->title }}
                            </a>
                        </h3>

                        <!-- Summary -->
                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $pkg->summary }}
                        </p>

                        <!-- List Pills: Transport, Homestay, Tiket Masuk, Guide -->
                        <div class="flex flex-wrap gap-1.5 my-3.5">
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-[#0064D2] text-[10px] font-semibold px-2 py-0.5 rounded-md border border-blue-100">
                                <i data-lucide="car" class="w-3 h-3"></i> Transport VIP
                            </span>
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-amber-100">
                                <i data-lucide="home" class="w-3 h-3"></i> Homestay
                            </span>
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-emerald-100">
                                <i data-lucide="ticket" class="w-3 h-3"></i> Tiket Masuk
                            </span>
                            <span class="inline-flex items-center gap-1 bg-purple-50 text-purple-800 text-[10px] font-semibold px-2 py-0.5 rounded-md border border-purple-100">
                                <i data-lucide="user-check" class="w-3 h-3"></i> Guide HPI
                            </span>
                        </div>

                        <!-- Itinerary / Inclusion Highlights -->
                        @if (!empty($pkg->itinerary_options) && count($pkg->itinerary_options) > 0)
                            <div class="space-y-1 text-xs text-slate-600 mb-4 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Spot Destinasi Pilihan:</div>
                                @foreach (array_slice($pkg->itinerary_options, 0, 2) as $opt)
                                    <div class="flex items-center gap-1.5 text-[11px] text-slate-700">
                                        <i data-lucide="check" class="w-3 h-3 text-[#0064D2] flex-shrink-0"></i>
                                        <span class="line-clamp-1 font-medium">{{ $opt['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Price Row & CTA -->
                    <div class="pt-3 border-t border-slate-100 mt-2">
                        <!-- Strikethrough promo price & badge -->
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-slate-400 line-through">{{ $strikePrice }}</span>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50 border border-rose-100 px-1.5 py-0.2 rounded">
                                Hemat 20%
                            </span>
                        </div>

                        <!-- Final Price in #0064D2 -->
                        <div class="flex items-baseline justify-between mb-3">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Mulai Dari</span>
                                <div class="font-extrabold text-xl text-[#0064D2] leading-tight">
                                    {{ $pkg->formatted_price }}
                                    <span class="text-xs text-slate-500 font-normal">/ pax</span>
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-400 font-medium">Private Tour</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a
                                href="{{ route('package.detail', $pkg->slug) }}"
                                class="py-2.5 px-3 rounded-full text-xs font-bold text-center text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center justify-center gap-1"
                            >
                                <span>Lihat Detail</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>

                            <a
                                href="#kalkulator"
                                onclick="selectPackageInCalculator('{{ $pkg->slug }}')"
                                class="py-2.5 px-3 rounded-full text-xs font-bold text-center text-white bg-[#0064D2] hover:bg-[#0051a8] shadow-md shadow-blue-500/20 active:scale-95 transition-all flex items-center justify-center gap-1"
                            >
                                <span>Pilih Paket</span>
                            </a>
                        </div>

                        <!-- Direct WhatsApp Instant Booking Link -->
                        <div class="mt-2 text-center">
                            <a
                                href="{{ $pkgWaUrl }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 hover:underline"
                            >
                                <i data-lucide="message-circle" class="w-3 h-3 text-emerald-600"></i>
                                <span>Tanya slot / custom via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200 text-slate-500 text-sm">
                Belum ada paket wisata aktif. Silakan tambahkan melalui panel pengelola admin.
            </div>
        @endforelse

        <!-- Pesan jika filter kategori tidak menemukan data -->
        <div
            x-show="totalFiltered() === 0"
            class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200 text-slate-500 text-sm"
        >
            Tidak ada paket wisata pada kategori ini.
        </div>
    </div>

    <!-- Tombol Muat Lebih Banyak / Ringkas -->
    <div x-show="totalFiltered() > limit" class="mt-10 text-center">
        <button
            @click="showAll = !showAll; if (!showAll) document.getElementById('paket').scrollIntoView({ behavior: 'smooth', block: 'start' });"
            type="button"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer shadow-md active:scale-95"
            :class="showAll ? 'text-slate-700 bg-white hover:bg-slate-100 border border-slate-200' : 'text-white bg-[#0064D2] hover:bg-[#0051a8] shadow-blue-500/25'"
        >
            <span x-show="!showAll" class="inline-flex items-center gap-2">
                <span>Lihat Semua Paket</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-white/20 text-white" x-text="`+${remainingCount()} Paket Lainnya`"></span>
                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </span>
            <span x-show="showAll" class="inline-flex items-center gap-2">
                <span>Tampilkan Lebih Sedikit (Ringkas)</span>
                <i data-lucide="chevron-up" class="w-4 h-4"></i>
            </span>
        </button>
        <p class="text-xs text-slate-500 mt-2.5" x-show="!showAll">
            Menampilkan <span class="font-bold text-[#0064D2]" x-text="Math.min(limit, totalFiltered())"></span> dari <span class="font-bold text-slate-800" x-text="totalFiltered()"></span> paket wisata aktif
        </p>
    </div>

    <!-- Booking Quick Modal (For instant booking) -->
    <div
        x-show="bookingModalOpen"
        x-cloak
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    >
        <div
            @click.away="bookingModalOpen = false"
            class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4 text-slate-800"
        >
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-base text-slate-900">Konfirmasi Pemesanan Paket</h3>
                <button @click="bookingModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div>
                <p class="text-xs text-slate-500">Anda memilih paket:</p>
                <div class="font-bold text-base text-[#0064D2] mt-0.5" x-text="selectedPackage?.title"></div>
                <div class="text-sm font-extrabold text-slate-900 mt-1" x-text="selectedPackage?.price + ' / orang'"></div>
            </div>
            <div class="p-3 bg-blue-50 rounded-2xl text-xs text-blue-900 leading-relaxed border border-blue-100 flex items-start gap-2">
                <i data-lucide="info" class="w-4 h-4 text-[#0064D2] flex-shrink-0 mt-0.5"></i>
                <span>Reservasi akan diteruskan ke admin resmi via WhatsApp untuk pengecekan ketersediaan armada & kamar homestay pada tanggal rencana Anda.</span>
            </div>
            <div class="flex gap-2 pt-2">
                <button
                    @click="bookingModalOpen = false"
                    type="button"
                    class="flex-1 py-2.5 rounded-full text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200"
                >
                    Batal
                </button>
                <a
                    :href="'https://wa.me/{{ $cleanWa }}?text=' + encodeURIComponent('Halo Admin, saya ingin memesan paket ' + (selectedPackage ? selectedPackage.title : '') + ' via website.')"
                    target="_blank"
                    class="flex-1 py-2.5 rounded-full text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051a8] text-center flex items-center justify-center gap-1 shadow-md shadow-blue-500/20"
                >
                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                    <span>Lanjut WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</section>

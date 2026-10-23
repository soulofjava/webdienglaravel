<!-- Spotlight Global Search Modal -->
<div 
    id="spotlightModal" 
    class="fixed inset-0 z-50 hidden transition-opacity duration-200 ease-out" 
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="spotlightSearchInput"
>
    <!-- Backdrop Overlay -->
    <div id="spotlightBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal Content Container (Mobile-First: Bottom Sheet / Fullwidth on Mobile, Centered on Tablet/Desktop) -->
    <div class="fixed inset-0 z-10 overflow-y-auto p-2 sm:p-6 flex items-center justify-center min-h-screen">
        <div 
            id="spotlightPanel" 
            class="w-full max-w-2xl transform divide-y divide-slate-100 overflow-hidden rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-2xl transition-all text-slate-800 my-auto"
        >
            <!-- Search Input Header -->
            <div class="relative flex items-center px-3.5 py-3 sm:px-6 sm:py-3.5 bg-white">
                <i data-lucide="search" class="w-5 h-5 text-[#0064D2] flex-shrink-0 pointer-events-none"></i>
                <input 
                    type="text" 
                    id="spotlightSearchInput"
                    class="h-11 sm:h-12 w-full bg-transparent border-0 pl-2.5 sm:pl-3 pr-16 sm:pr-20 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 text-sm sm:text-base font-medium"
                    placeholder="Cari paket wisata, rute, destinasi..."
                    autocomplete="off"
                    spellcheck="false"
                >
                <!-- Loading & Clear Buttons -->
                <div class="absolute right-3 sm:right-4 flex items-center gap-1.5 sm:gap-2">
                    <span id="spotlightSpinner" class="hidden animate-spin w-4 h-4 border-2 border-[#0064D2] border-t-transparent rounded-full"></span>
                    <button 
                        type="button" 
                        id="spotlightClearBtn" 
                        class="hidden text-xs text-slate-400 hover:text-slate-700 p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200"
                        title="Hapus pencarian"
                    >
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                    <!-- Close button on Mobile Header for quick exit -->
                    <button 
                        type="button" 
                        onclick="closeSpotlightSearch()" 
                        class="sm:hidden text-slate-400 hover:text-slate-700 p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200"
                        title="Tutup"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                    <kbd class="hidden sm:inline-flex items-center px-2 py-0.5 text-[10px] font-mono font-medium text-slate-500 bg-slate-100 rounded border border-slate-200">
                        ESC
                    </kbd>
                </div>
            </div>

            <!-- Quick Suggestion Chips -->
            <div class="px-4 py-2.5 sm:px-6 bg-slate-50 border-b border-slate-100 flex items-center gap-2 overflow-x-auto text-xs text-slate-500 no-scrollbar">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex-shrink-0">Populer:</span>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="1 Hari">1 Hari</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="Sikunir">Sikunir Sunrise</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="Jeep">Jeep Safari</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="Sikidang">Kawah Sikidang</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="Keluarga">Family Tour</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white hover:bg-blue-50 hover:text-[#0064D2] border border-slate-200 transition-colors flex-shrink-0 font-medium" data-keyword="DCF">Festival DCF</button>
            </div>

            <!-- Results Container -->
            <div id="spotlightResultsWrapper" class="max-h-96 overflow-y-auto p-2 sm:p-4">
                <!-- Shimmering Skeleton Loader Cards (tiket.com Light Blue Style) -->
                <div id="spotlightSkeleton" class="hidden space-y-2.5 py-1">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/80 flex items-center justify-between gap-3 animate-pulse">
                            <div class="flex items-center gap-3.5 flex-1">
                                <div class="w-16 h-16 rounded-xl bg-slate-200 flex-shrink-0"></div>
                                <div class="space-y-2 flex-1">
                                    <div class="h-4 bg-slate-200 rounded-md w-3/4"></div>
                                    <div class="h-3 bg-slate-100 rounded-md w-1/3"></div>
                                    <div class="h-3 bg-slate-100 rounded-md w-1/2"></div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                <div class="h-4 w-20 bg-blue-100 rounded-md"></div>
                                <div class="h-3 w-12 bg-slate-100 rounded-md"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div id="spotlightResultsList" class="space-y-1.5" role="listbox">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Empty State (Clean Light Style) -->
                <div id="spotlightEmptyState" class="hidden py-10 px-4 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] mx-auto mb-3 shadow-xs">
                        <i data-lucide="compass" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 mb-1">Paket Wisata Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4 leading-relaxed">
                        Tidak menemukan rute atau destinasi yang dicari? Kami melayani kustomisasi paket dan rute privat khusus via WhatsApp.
                    </p>
                    @php
                        $cleanWaNumber = preg_replace('/\D/', '', $siteSettings->whatsapp_number ?? '');
                    @endphp
                    <a 
                        href="https://wa.me/{{ $cleanWaNumber }}?text=Halo%20Admin%2C%20saya%20mencari%20paket%20wisata%20custom%20di%20Dieng.%20Bisa%20bantu%20rekomendasi%3F" 
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051A8] shadow-md shadow-blue-500/20 transition-all cursor-pointer"
                    >
                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                        <span>Tanya Rute Custom via WA</span>
                    </a>
                </div>
            </div>

            <!-- Footer Bar (Mobile-First: Action Button on Mobile, Keyboard Shortcuts on Desktop) -->
            <div class="flex items-center justify-between px-4 py-3 sm:px-6 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-500">
                <!-- Desktop Keyboard Shortcuts (Hidden on Mobile) -->
                <div class="hidden sm:flex items-center gap-3">
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-700 shadow-xs font-semibold">↑</kbd>
                        <kbd class="font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-700 shadow-xs font-semibold">↓</kbd>
                        <span>Pilih</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-700 shadow-xs font-semibold">↵</kbd>
                        <span>Buka</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-700 shadow-xs font-semibold">ESC</kbd>
                        <span>Tutup</span>
                    </span>
                </div>

                <!-- Mobile Navigation / Close Pill (Visible ONLY on Mobile) -->
                <div class="flex sm:hidden items-center justify-between w-full">
                    <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0064D2]"></span>
                        <span>TiketDieng Instant Search</span>
                    </div>
                    <button 
                        type="button" 
                        onclick="closeSpotlightSearch()" 
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-slate-200/80 hover:bg-slate-300 text-slate-700 font-bold text-xs transition-colors"
                    >
                        <span>Tutup</span>
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

                <!-- Desktop Branding Tag (Hidden on Mobile) -->
                <div class="hidden sm:block text-[11px] text-[#0064D2] font-bold">
                    TiketDieng.com Search
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(() => {
    const modal = document.getElementById('spotlightModal');
    const backdrop = document.getElementById('spotlightBackdrop');
    const input = document.getElementById('spotlightSearchInput');
    const spinner = document.getElementById('spotlightSpinner');
    const clearBtn = document.getElementById('spotlightClearBtn');
    const resultsList = document.getElementById('spotlightResultsList');
    const emptyState = document.getElementById('spotlightEmptyState');
    let debounceTimer = null;
    let selectedIndex = -1;
    let currentResults = [];

    // Buka Modal
    window.openSpotlightSearch = function(initialKeyword = '') {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (initialKeyword) {
            input.value = initialKeyword;
            performSearch(initialKeyword);
        } else if (!input.value.trim()) {
            loadDefaultPackages();
        }
        setTimeout(() => {
            input.focus();
            if (window.lucide) window.lucide.createIcons();
        }, 50);
    };

    // Tutup Modal
    window.closeSpotlightSearch = function() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        selectedIndex = -1;
    };

    // Event Klik Backdrop / Close
    backdrop?.addEventListener('click', closeSpotlightSearch);

    // Keyboard Shortcuts (Cmd+K / Ctrl+K & ESC)
    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (modal.classList.contains('hidden')) {
                openSpotlightSearch();
            } else {
                closeSpotlightSearch();
            }
        } else if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            e.preventDefault();
            closeSpotlightSearch();
        } else if (!modal.classList.contains('hidden')) {
            // Navigasi Arrow Keyboard
            const items = resultsList.querySelectorAll('.spotlight-item');
            if (items.length > 0) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    highlightItem(items, selectedIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                    highlightItem(items, selectedIndex);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (selectedIndex >= 0 && items[selectedIndex]) {
                        items[selectedIndex].click();
                    } else if (items.length > 0) {
                        items[0].click();
                    }
                }
            }
        }
    });

    function highlightItem(items, index) {
        items.forEach((item, idx) => {
        if (idx === index) {
        item.classList.add('bg-blue-50', 'border-[#0064D2]', 'ring-1', 'ring-[#0064D2]');
        item.scrollIntoView({ block: 'nearest' });
        } else {
        item.classList.remove('bg-blue-50', 'border-[#0064D2]', 'ring-1', 'ring-[#0064D2]');
        }
        });
    }

    // Input Typing Handler with Debounce
    input?.addEventListener('input', () => {
        const query = input.value.trim();
        clearBtn.classList.toggle('hidden', query.length === 0);
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            performSearch(query);
        }, 180);
    });

    // Clear Button
    clearBtn?.addEventListener('click', () => {
        input.value = '';
        clearBtn.classList.add('hidden');
        loadDefaultPackages();
        input.focus();
    });

    // Quick Suggestion Chips
    document.querySelectorAll('.search-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const kw = chip.getAttribute('data-keyword');
            input.value = kw;
            clearBtn.classList.remove('hidden');
            performSearch(kw);
            input.focus();
        });
    });

    const skeleton = document.getElementById('spotlightSkeleton');

    // Fetch API Search
    function performSearch(query) {
        spinner?.classList.remove('hidden');
        skeleton?.classList.remove('hidden');
        resultsList.classList.add('hidden');
        emptyState.classList.add('hidden');

        fetch(`/api/search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                spinner?.classList.add('hidden');
                skeleton?.classList.add('hidden');
                resultsList.classList.remove('hidden');
                currentResults = data.data || [];
                renderResults(currentResults, data.is_default);
            })
            .catch(err => {
                spinner?.classList.add('hidden');
                skeleton?.classList.add('hidden');
                resultsList.classList.remove('hidden');
                console.error('Search error:', err);
            });
    }

    function loadDefaultPackages() {
        performSearch('');
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Render HTML Hasil Pencarian
    function renderResults(items, isDefault) {
        selectedIndex = -1;
        if (!items || items.length === 0) {
            resultsList.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');

        let headerHtml = '';
        if (isDefault) {
            headerHtml = `<div class="px-3 py-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rekomendasi Paket Paling Populer</div>`;
        } else {
            headerHtml = `<div class="px-3 py-2 text-[11px] font-bold text-[#0064D2] uppercase tracking-wider">Hasil Pencarian (${items.length} paket ditemukan)</div>`;
        }

        const itemsHtml = items.map((item, index) => {
            const badgeHtml = item.badge ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FEDD00]/25 text-amber-900 border border-[#FEDD00]/60">${escapeHtml(item.badge)}</span>` : '';
            const matchBadge = item.match_type === 'rute' ? `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Rute Cocok</span>` : '';

            return `
                <a 
                    href="${item.url}" 
                    class="spotlight-item group flex items-start gap-3.5 p-3 rounded-2xl bg-white hover:bg-blue-50/50 border border-slate-200/80 hover:border-[#0064D2]/40 hover:shadow-sm transition-all cursor-pointer mb-2"
                    role="option"
                    data-index="${index}"
                >
                    <img 
                        src="${escapeHtml(item.image_url)}" 
                        alt="${escapeHtml(item.title)}" 
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover flex-shrink-0 border border-slate-200/80 group-hover:border-[#0064D2]/40 transition-colors"
                        loading="lazy"
                    >
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-1.5 mb-1">
                            <span class="text-[10px] uppercase font-bold text-[#0064D2] bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">${escapeHtml(item.category)}</span>
                            <span class="text-slate-400 text-xs">•</span>
                            <span class="text-[11px] font-medium text-slate-500">${escapeHtml(item.duration)}</span>
                            ${badgeHtml}
                            ${matchBadge}
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#0064D2] transition-colors truncate">
                            ${escapeHtml(item.title)}
                        </h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5 leading-relaxed">
                            ${escapeHtml(item.highlight)}
                        </p>
                        <div class="mt-2 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-slate-500">
                                Mulai Dari <strong class="text-[#0064D2] font-extrabold text-xs sm:text-sm">${escapeHtml(item.price)}</strong> / pax
                            </span>
                            <span class="hidden sm:inline-flex items-center gap-1 text-[11px] font-bold text-[#0064D2] opacity-0 group-hover:opacity-100 transition-opacity">
                                <span>Lihat Detail</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </div>
                    </div>
                </a>
            `;
        }).join('');

        resultsList.innerHTML = headerHtml + itemsHtml;

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
})();
</script>

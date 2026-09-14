<!-- Spotlight Global Search Modal -->
<div 
    id="spotlightModal" 
    class="fixed inset-0 z-50 hidden transition-opacity duration-200 ease-out" 
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="spotlightSearchInput"
>
    <!-- Backdrop Overlay -->
    <div id="spotlightBackdrop" class="fixed inset-0 bg-black/80 backdrop-blur-md transition-opacity"></div>

    <!-- Modal Content Container -->
    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <div 
            id="spotlightPanel" 
            class="mx-auto max-w-2xl transform divide-y divide-white/10 overflow-hidden rounded-2xl bg-[#0b0f19] border border-white/15 shadow-2xl shadow-black/80 transition-all text-slate-100"
        >
            <!-- Search Input Header -->
            <div class="relative flex items-center px-4 py-3 sm:px-6">
                <i data-lucide="search" class="w-5 h-5 text-amber-400 flex-shrink-0 pointer-events-none"></i>
                <input 
                    type="text" 
                    id="spotlightSearchInput"
                    class="h-12 w-full bg-transparent border-0 pl-3 pr-20 text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-0 sm:text-base"
                    placeholder="Cari paket wisata, rute, destinasi (Sikunir, Sikidang, Jeep)..."
                    autocomplete="off"
                    spellcheck="false"
                >
                <!-- Loading & Clear Buttons -->
                <div class="absolute right-4 flex items-center gap-2">
                    <span id="spotlightSpinner" class="hidden animate-spin w-4 h-4 border-2 border-amber-400 border-t-transparent rounded-full"></span>
                    <button 
                        type="button" 
                        id="spotlightClearBtn" 
                        class="hidden text-xs text-slate-400 hover:text-white p-1 rounded-md bg-white/5 hover:bg-white/10"
                        title="Hapus pencarian"
                    >
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                    <kbd class="hidden sm:inline-flex items-center px-2 py-0.5 text-[10px] font-mono font-medium text-slate-400 bg-white/5 rounded border border-white/10">
                        ESC
                    </kbd>
                </div>
            </div>

            <!-- Quick Suggestion Chips -->
            <div class="px-4 py-2.5 sm:px-6 bg-white/[0.02] flex items-center gap-2 overflow-x-auto text-xs text-slate-400 no-scrollbar">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex-shrink-0">Populer:</span>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="1 Hari">1 Hari</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="Sikunir">Sikunir Sunrise</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="Jeep">Jeep Safari</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="Sikidang">Kawah Sikidang</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="Keluarga">Family Tour</button>
                <button type="button" class="search-chip px-2.5 py-1 rounded-full bg-white/5 hover:bg-amber-500/20 hover:text-amber-300 border border-white/10 transition-colors flex-shrink-0" data-keyword="DCF">Festival DCF</button>
            </div>

            <!-- Results Container -->
            <div id="spotlightResultsWrapper" class="max-h-96 overflow-y-auto p-2 sm:p-4">
                <!-- Shimmering Skeleton Loader Cards -->
                <div id="spotlightSkeleton" class="hidden space-y-2 py-1">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/10 flex items-center justify-between gap-3 skeleton-shimmer">
                            <div class="flex items-center gap-3.5 flex-1">
                                <div class="w-14 h-14 rounded-xl bg-white/10 flex-shrink-0 animate-pulse"></div>
                                <div class="space-y-2 flex-1">
                                    <div class="h-4 bg-white/10 rounded w-2/3 animate-pulse"></div>
                                    <div class="h-3 bg-white/5 rounded w-1/3 animate-pulse"></div>
                                    <div class="h-3 bg-white/5 rounded w-1/2 animate-pulse"></div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                <div class="h-4 w-20 bg-amber-400/20 rounded animate-pulse"></div>
                                <div class="h-3 w-12 bg-white/5 rounded animate-pulse"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div id="spotlightResultsList" class="space-y-1.5" role="listbox">
                    <!-- Populated dynamically via JS -->
                </div>

                <!-- Empty State -->
                <div id="spotlightEmptyState" class="hidden py-10 px-4 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 mx-auto mb-3">
                        <i data-lucide="compass" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Paket Wisata Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-4">
                        Tidak menemukan rute atau destinasi yang dicari? Kami melayani kustomisasi paket dan rute privat khusus via WhatsApp.
                    </p>
                    @php
                        $cleanWaNumber = preg_replace('/\D/', '', $siteSettings->whatsapp_number ?? '');
                    @endphp
                    <a 
                        href="https://wa.me/{{ $cleanWaNumber }}?text=Halo%20Admin%2C%20saya%20mencari%20paket%20wisata%20custom%20di%20Dieng.%20Bisa%20bantu%20rekomendasi%3F" 
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors"
                    >
                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                        <span>Tanya Rute Custom via WA</span>
                    </a>
                </div>
            </div>

            <!-- Footer Shortcuts -->
            <div class="flex items-center justify-between px-4 py-2.5 sm:px-6 bg-white/[0.03] text-[11px] text-slate-400">
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white/5 px-1.5 py-0.5 rounded border border-white/10 text-slate-300">↑</kbd>
                        <kbd class="font-mono bg-white/5 px-1.5 py-0.5 rounded border border-white/10 text-slate-300">↓</kbd>
                        <span>Pilih</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white/5 px-1.5 py-0.5 rounded border border-white/10 text-slate-300">↵</kbd>
                        <span>Buka</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <kbd class="font-mono bg-white/5 px-1.5 py-0.5 rounded border border-white/10 text-slate-300">ESC</kbd>
                        <span>Tutup</span>
                    </span>
                </div>
                <div class="text-[11px] text-amber-400/80 font-medium">
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
                item.classList.add('bg-white/10', 'border-amber-500/50', 'ring-1', 'ring-amber-500/30');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('bg-white/10', 'border-amber-500/50', 'ring-1', 'ring-amber-500/30');
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
            headerHtml = `<div class="px-3 py-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Rekomendasi Paket Paling Populer</div>`;
        } else {
            headerHtml = `<div class="px-3 py-1.5 text-[11px] font-semibold text-amber-400 uppercase tracking-wider">Hasil Pencarian (${items.length} paket ditemukan)</div>`;
        }

        const itemsHtml = items.map((item, index) => {
            const badgeHtml = item.badge ? `<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">${escapeHtml(item.badge)}</span>` : '';
            const matchBadge = item.match_type === 'rute' ? `<span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Rute Cocok</span>` : '';

            return `
                <a 
                    href="${item.url}" 
                    class="spotlight-item group flex items-start gap-3.5 p-3 rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-amber-500/40 transition-all cursor-pointer"
                    role="option"
                    data-index="${index}"
                >
                    <img 
                        src="${escapeHtml(item.image_url)}" 
                        alt="${escapeHtml(item.title)}" 
                        class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg object-cover flex-shrink-0 border border-white/10 group-hover:border-amber-400/50 transition-colors"
                        loading="lazy"
                    >
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-1.5 mb-1">
                            <span class="text-[10px] uppercase font-semibold text-slate-400">${escapeHtml(item.category)}</span>
                            <span class="text-slate-600 text-xs">•</span>
                            <span class="text-[10px] text-slate-400">${escapeHtml(item.duration)}</span>
                            ${badgeHtml}
                            ${matchBadge}
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-white group-hover:text-amber-300 transition-colors truncate">
                            ${escapeHtml(item.title)}
                        </h4>
                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">
                            ${escapeHtml(item.highlight)}
                        </p>
                        <div class="mt-1.5 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-slate-400">
                                Mulai Dari <strong class="text-amber-400 font-bold text-xs sm:text-sm">${escapeHtml(item.price)}</strong> / pax
                            </span>
                            <span class="hidden sm:inline-flex items-center gap-1 text-[11px] font-semibold text-amber-300 opacity-0 group-hover:opacity-100 transition-opacity">
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

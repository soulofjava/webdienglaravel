@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full text-xs">
        <!-- Informasi Hasil -->
        <div class="text-slate-400 text-xs">
            Menampilkan
            <span class="font-semibold text-white">{{ $paginator->firstItem() }}</span>
            sampai
            <span class="font-semibold text-white">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-bold text-amber-400">{{ $paginator->total() }}</span>
            data
        </div>

        <!-- Tombol Halaman -->
        <div class="flex items-center gap-1.5">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/[0.03] border border-white/5 text-slate-600 cursor-not-allowed" aria-hidden="true" title="Halaman Sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white hover:border-amber-500/30 transition-colors" title="Halaman Sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            {{-- Angka Halaman --}}
            @foreach ($elements as $element)
                {{-- Separator titik-titik --}}
                @if (is_string($element))
                    <span class="px-2 text-slate-500 text-xs select-none">…</span>
                @endif

                {{-- Link Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 rounded-lg text-xs font-bold text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 shadow-md shadow-amber-500/20 cursor-default">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 rounded-lg text-xs font-medium text-slate-300 bg-white/5 hover:bg-white/10 hover:text-white border border-white/10 hover:border-amber-500/30 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white hover:border-amber-500/30 transition-colors" title="Halaman Selanjutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/[0.03] border border-white/5 text-slate-600 cursor-not-allowed" aria-hidden="true" title="Halaman Selanjutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
    </nav>
@endif

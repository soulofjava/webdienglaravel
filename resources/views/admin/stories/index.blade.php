@extends('layouts.app')

@section('title', 'Kelola Cerita Babak Dieng — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Master Cerita Sinematik 5 Babak Keajaiban Dieng (Scrollytelling)" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                </div>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header Halaman & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <span>Tiket Partner</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Cerita Babak</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">5 Babak Keajaiban Dataran Tinggi</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola narasi scrollytelling sinematik, kutipan puitis, keunggulan babak, dan foto lanskap Dieng.</p>
            </div>

            <a
                href="{{ route('admin.stories.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 shrink-0 cursor-pointer min-h-[44px]"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Babak Cerita</span>
            </a>
        </div>

        <!-- Bar Filter & Pencarian -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            <!-- Quick Status Pill Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0 scrollbar-none">
                <a
                    href="{{ route('admin.stories.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ ($status ?? 'all') === 'all' ? 'bg-[#0064D2] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    <span>Semua Babak</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ ($status ?? 'all') === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalAll }}</span>
                </a>
                <a
                    href="{{ route('admin.stories.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ ($status ?? '') === 'active' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    <span>Aktif Saja</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ ($status ?? '') === 'active' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalActive }}</span>
                </a>
                <a
                    href="{{ route('admin.stories.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ ($status ?? '') === 'inactive' ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    <span>Non-Aktif</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ ($status ?? '') === 'inactive' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalInactive }}</span>
                </a>
            </div>

            <!-- Form Pencarian & Per-Page Controls -->
            <form id="storyFilterForm" action="{{ route('admin.stories.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}" />

                <!-- Per-Page Selector -->
                <div class="flex items-center gap-1.5 text-xs text-slate-600">
                    <span class="hidden sm:inline">Tampil:</span>
                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-700 focus:bg-white focus:border-[#0064D2] focus:ring-1 focus:ring-[#0064D2]"
                    >
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                        <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50 baris</option>
                        <option value="100" {{ request('per_page', 100) == 100 ? 'selected' : '' }}>100 baris</option>
                    </select>
                </div>

                <!-- Debounced Search Box -->
                <div class="relative flex-1 min-w-[220px]">
                    <button type="submit" id="searchSubmitBtn" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer" title="Cari">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                    <input
                        type="text"
                        id="storySearchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul babak, lokasi, narasi..."
                        class="w-full pl-10 pr-9 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                    />
                    @if(request('search'))
                        <a
                            href="{{ route('admin.stories.index', request()->except('search', 'page')) }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 rounded-full hover:bg-slate-200 transition-colors"
                            title="Hapus pencarian"
                        >
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                @if(request('search'))
                    <a
                        href="{{ route('admin.stories.index', ['status' => request('status', 'all')]) }}"
                        class="px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors flex items-center gap-1"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- 1. MOBILE-FIRST RESPONSIVE CARD VIEW (< 768px / block md:hidden) -->
        <div class="space-y-4 md:hidden">
            @forelse($stories as $story)
                @php
                    $accent = $story->accent_classes;
                    $icon = $story->resolved_icon;
                @endphp
                <div class="rounded-2xl border {{ $story->is_active ? 'border-slate-200/90 bg-white' : 'border-slate-200 bg-slate-50/70' }} p-4 shadow-sm space-y-3.5 transition-all">
                    <!-- Visual Banner & Chapter Badges -->
                    <div class="relative w-full h-40 rounded-xl overflow-hidden bg-slate-900 border border-slate-200/80 shadow-xs">
                        <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover" loading="lazy" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/30 to-black/30"></div>

                        <!-- Top Badges -->
                        <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold shadow-xs {{ $accent['badge'] }} backdrop-blur-xs">
                                <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 {{ $accent['icon'] }}"></i>
                                <span>{{ $story->chapter_badge }}</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-mono font-extrabold bg-black/60 text-white backdrop-blur-xs border border-white/20">
                                #{{ $story->sort_order }}
                            </span>
                        </div>

                        <!-- Bottom Title inside Banner -->
                        <div class="absolute bottom-2.5 left-3 right-3">
                            <h3 class="text-base font-extrabold text-white leading-snug drop-shadow-sm">{{ $story->title }}</h3>
                        </div>
                    </div>

                    <!-- Puitis Quote -->
                    @if($story->quote)
                        <div class="text-xs text-slate-700 italic font-medium bg-amber-50/70 p-3 rounded-xl border border-amber-200/60 flex items-start gap-2.5">
                            <i data-lucide="quote" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed">"{{ $story->quote }}"</span>
                        </div>
                    @endif

                    <!-- Narasi Cerita -->
                    @if($story->description)
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed px-0.5">
                            {{ $story->description }}
                        </p>
                    @endif

                    <!-- Poin Sorotan (Highlights) -->
                    @if(!empty($story->highlights))
                        <div class="space-y-1.5 pt-1">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Poin Sorotan:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($story->highlights as $hl)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/80">
                                        <i data-lucide="check" class="w-3 h-3 text-emerald-600 shrink-0"></i>
                                        <span>{{ $hl }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Bottom Action Toolbar (Thumb-friendly & 0px Horizontal Scroll) -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <!-- Toggle Status Button -->
                        <form action="{{ route('admin.stories.toggle', $story->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold {{ $story->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-300' }} transition-colors cursor-pointer min-h-[40px]"
                                title="Klik untuk mengubah status aktif babak"
                            >
                                <span class="w-2 h-2 rounded-full {{ $story->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                <span>{{ $story->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
                            </button>
                        </form>

                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('admin.stories.edit', $story->id) }}"
                                class="px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 text-xs font-bold transition-colors min-h-[40px] flex items-center gap-1.5 cursor-pointer"
                            >
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                <span>Kelola</span>
                            </a>

                            <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus babak \'{{ addslashes($story->title) }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2.5 rounded-xl text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors min-h-[40px] min-w-[40px] flex items-center justify-center cursor-pointer"
                                    title="Hapus Babak"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">Belum ada babak cerita yang sesuai filter.</p>
                    <a href="{{ route('admin.stories.create') }}" class="inline-block text-xs font-bold text-[#0064D2] hover:underline mt-1">+ Buat Babak Pertama</a>
                </div>
            @endforelse
        </div>

        <!-- 2. DESKTOP TABLE VIEW (>= 768px / hidden md:block) -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4 w-14 text-center">Urutan</th>
                            <th class="py-3.5 px-4 w-28">Visual</th>
                            <th class="py-3.5 px-5 min-w-[260px]">Babak & Judul Cerita</th>
                            <th class="py-3.5 px-5 min-w-[220px]">Kutipan & Narasi</th>
                            <th class="py-3.5 px-4 text-center whitespace-nowrap">Highlights</th>
                            <th class="py-3.5 px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-3.5 px-5 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($stories as $story)
                            @php
                                $accent = $story->accent_classes;
                                $icon = $story->resolved_icon;
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors {{ !$story->is_active ? 'bg-slate-50/60 opacity-80' : '' }}">
                                <!-- Sort Order -->
                                <td class="py-4 px-4 text-center font-mono font-bold text-slate-700 text-sm">
                                    {{ $story->sort_order }}
                                </td>

                                <!-- Visual Thumbnail -->
                                <td class="py-4 px-4">
                                    <div class="w-20 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-xs relative group">
                                        <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" />
                                    </div>
                                </td>

                                <!-- Babak & Judul -->
                                <td class="py-4 px-5">
                                    <div class="space-y-1.5">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold {{ $accent['badge'] }}">
                                            <i data-lucide="{{ $icon }}" class="w-3.5 h-3.5 {{ $accent['icon'] }}"></i>
                                            <span>{{ $story->chapter_badge }}</span>
                                        </div>
                                        <div class="text-sm font-extrabold text-slate-900 tracking-tight">
                                            {{ $story->title }}
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            Aksen: <span class="font-medium text-slate-600 capitalize">{{ $story->accent_color ?? 'amber' }}</span> • Icon: <code class="font-mono">{{ $icon }}</code>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kutipan & Narasi -->
                                <td class="py-4 px-5">
                                    <div class="space-y-1 max-w-sm">
                                        @if($story->quote)
                                            <p class="text-xs text-slate-700 italic font-medium line-clamp-1">
                                                {{ $story->quote }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                            {{ $story->description }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Highlights -->
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    @if(!empty($story->highlights))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200" title="{{ implode(' • ', $story->highlights) }}">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            <span>{{ count($story->highlights) }} poin</span>
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">-</span>
                                    @endif
                                </td>

                                <!-- Status Aktif -->
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <form action="{{ route('admin.stories.toggle', $story->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold cursor-pointer transition-colors {{ $story->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 border border-slate-300' }}"
                                            title="Klik untuk ubah status"
                                        >
                                            <span class="w-2 h-2 rounded-full {{ $story->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            <span>{{ $story->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
                                        </button>
                                    </form>
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <a
                                            href="{{ route('admin.stories.edit', $story->id) }}"
                                            class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#0064D2] text-slate-700 hover:text-white text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                                            title="Edit Babak Cerita"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus babak \'{{ addslashes($story->title) }}\'?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                title="Hapus Babak Cerita"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="book-open" class="w-8 h-8 text-slate-300"></i>
                                        <span class="font-medium">Tidak ada babak cerita yang ditemukan.</span>
                                        <a href="{{ route('admin.stories.create') }}" class="text-xs text-[#0064D2] font-bold hover:underline mt-1">+ Tambah Babak Cerita Baru</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Bar (Accessible on both Mobile & Desktop) -->
        @if($stories->hasPages())
            <div class="p-4 sm:px-6 rounded-2xl border border-slate-200/80 bg-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-700">{{ $stories->firstItem() }}</span> - <span class="font-bold text-slate-700">{{ $stories->lastItem() }}</span> dari <span class="font-bold text-slate-700">{{ $stories->total() }}</span> babak
                </div>
                <div class="w-full sm:w-auto flex justify-center sm:justify-end">
                    {{ $stories->links() }}
                </div>
            </div>
        @endif
    </main>
</div>

<!-- Debounce Auto-Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('storyFilterForm');
    const searchInput = document.getElementById('storySearchInput');

    if (filterForm && searchInput) {
        let debounceTimer = null;
        const initialVal = searchInput.value.trim();

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                if (searchInput.value.trim() !== initialVal) {
                    filterForm.submit();
                }
            }, 400);
        });

        // Preservasi kursor jika baru reload dari search
        if (searchInput.value.length > 0 && new URLSearchParams(window.location.search).has('search')) {
            searchInput.focus();
            const len = searchInput.value.length;
            searchInput.setSelectionRange(len, len);
        }
    }
});
</script>
@endsection

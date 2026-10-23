@extends('layouts.app')

@section('title', 'Kelola Spot Foto Favorit Lotus — Tiket Partner')

@section('content')
<main class="min-h-screen bg-[#F4F7FB] text-slate-800 pb-16 font-sans">
    <x-admin-nav :settings="$settings" subtitle="Kelola Daftar Spot Foto Terindah & Waktu Terbaik (Lotus Creative)" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-xs uppercase tracking-wider font-bold">Tutup</button>
            </div>
        @endif

        <!-- Header Actions: Title, Filter Tabs, Add Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('admin.index') }}" class="hover:text-[#0064D2] transition-colors">Extranet</a>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Spot Foto Lotus</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Spot Foto Favorit Dieng</h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">Daftar lokasi pemotretan unggulan yang tampil di beranda Lotus Creative.</p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.photo-spots.create') }}"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all shadow-md shadow-blue-500/20 flex items-center gap-2"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Spot Foto</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Tabs Filter Scope & Status -->
            <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                @if(Auth::user()->isSuperAdmin())
                    <a
                        href="{{ route('admin.photo-spots.index', array_merge(request()->except('scope', 'page'), ['scope' => 'all'])) }}"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $currentScope === 'all' ? 'bg-[#0064D2] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        <span>Semua Brand</span>
                    </a>
                    <a
                        href="{{ route('admin.photo-spots.index', array_merge(request()->except('scope', 'page'), ['scope' => 'lotus'])) }}"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $currentScope === 'lotus' ? 'bg-sky-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                        <span>Lotus Creative</span>
                        <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $currentScope === 'lotus' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalLotus }}</span>
                    </a>
                    <a
                        href="{{ route('admin.photo-spots.index', array_merge(request()->except('scope', 'page'), ['scope' => 'jeep'])) }}"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $currentScope === 'jeep' ? 'bg-red-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                        <span>Ready Jeep</span>
                        <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $currentScope === 'jeep' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalJeep }}</span>
                    </a>

                    <div class="h-4 w-px bg-slate-200 mx-1 shrink-0"></div>
                @endif

                <a
                    href="{{ route('admin.photo-spots.index', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $status === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}"
                >
                    <span>Semua Status</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalAll }}</span>
                </a>
                <a
                    href="{{ route('admin.photo-spots.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $status === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}"
                >
                    <span>Aktif</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $status === 'active' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalActive }}</span>
                </a>
                <a
                    href="{{ route('admin.photo-spots.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shrink-0 {{ $status === 'inactive' ? 'bg-slate-700 text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}"
                >
                    <span>Draf</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $status === 'inactive' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $totalInactive }}</span>
                </a>
            </div>

            <!-- Search Form -->
            <form id="spotFilterForm" action="{{ route('admin.photo-spots.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <input type="hidden" name="scope" value="{{ $currentScope }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative flex-1 md:w-72">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari spot foto atau waktu..."
                        class="w-full pl-9 pr-8 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20 focus:border-[#0064D2]"
                    >
                    @if(request('search'))
                        <a href="{{ route('admin.photo-spots.index', request()->except('search', 'page')) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <select
                        name="per_page"
                        onchange="document.getElementById('spotFilterForm').submit()"
                        class="text-xs py-2 px-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#0064D2]/20"
                    >
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / hal</option>
                    </select>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors"
                    >
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Grid Card Spot Foto -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($spots as $spot)
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Image -->
                        <div class="aspect-[4/3] bg-slate-100 relative overflow-hidden">
                            <img
                                src="{{ $spot->image_url }}"
                                alt="{{ $spot->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=600&auto=format&fit=crop';"
                            >
                            <div class="absolute top-3 left-3 flex items-center gap-1.5">
                                @if($spot->best_time_tag)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/95 backdrop-blur-sm text-slate-800 shadow-xs">
                                        {{ $spot->best_time_tag }}
                                    </span>
                                @endif
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                                    #{{ $spot->sort_order }}
                                </span>
                            </div>
                        </div>

                        <!-- Content info -->
                        <div class="p-5 space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $spot->site_scope === 'jeep' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                    {{ $spot->site_scope === 'jeep' ? 'Ready Jeep' : 'Lotus Creative' }}
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $spot->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $spot->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-base text-slate-900 leading-snug group-hover:text-[#0064D2] transition-colors">
                                {{ $spot->name }}
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $spot->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Card: Action Buttons -->
                    <div class="p-4 pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                        <form action="{{ route('admin.photo-spots.toggle', $spot->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="px-2.5 py-1 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1 {{ $spot->is_active ? 'text-amber-700 hover:bg-amber-50' : 'text-emerald-700 hover:bg-emerald-50' }}"
                                title="{{ $spot->is_active ? 'Nonaktifkan dari web' : 'Publikasikan ke web' }}"
                            >
                                <i data-lucide="{{ $spot->is_active ? 'eye-off' : 'eye' }}" class="w-3.5 h-3.5"></i>
                                <span>{{ $spot->is_active ? 'Sembunyikan' : 'Tampilkan' }}</span>
                            </button>
                        </form>

                        <div class="flex items-center gap-1">
                            <a
                                href="{{ route('admin.photo-spots.edit', $spot->id) }}"
                                class="p-2 rounded-lg text-slate-600 hover:text-[#0064D2] hover:bg-blue-50 transition-colors"
                                title="Edit Spot Foto"
                            >
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.photo-spots.destroy', $spot->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus spot foto \'{{ addslashes($spot->name) }}\'?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                                    title="Hapus Spot Foto"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200/80 p-8 space-y-3">
                    <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto text-[#0064D2]">
                        <i data-lucide="camera" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Spot Foto Terdaftar</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Mulai tambahkan lokasi pemotretan favorit untuk ditampilkan di halaman beranda Lotus Creative.</p>
                    <div class="pt-2">
                        <a href="{{ route('admin.photo-spots.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051A8] transition-colors">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            <span>Tambah Spot Pertama</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($spots->hasPages())
            <div class="p-4 bg-white rounded-2xl border border-slate-200/80 flex items-center justify-between text-xs text-slate-600">
                <div>
                    Menampilkan <span class="font-bold text-slate-800">{{ $spots->firstItem() }}</span> - <span class="font-bold text-slate-800">{{ $spots->lastItem() }}</span> dari <span class="font-bold text-slate-800">{{ $spots->total() }}</span> spot
                </div>
                <div>
                    {{ $spots->links() }}
                </div>
            </div>
        @endif

    </div>
</main>
@endsection

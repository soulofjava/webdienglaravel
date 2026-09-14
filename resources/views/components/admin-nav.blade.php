@props([
    'title' => null,
    'subtitle' => null,
])

@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    
    // Menu navigasi admin terpusat - jika ingin menambah menu baru di masa depan, cukup tambahkan di sini
    $navMenus = [
        [
            'name' => 'Pengaturan',
            'route' => 'admin.index',
            'active' => request()->routeIs('admin.index') || request()->routeIs('admin.settings.*'),
            'icon' => 'sliders-horizontal',
        ],
        [
            'name' => 'Paket Wisata',
            'route' => 'admin.packages.index',
            'active' => request()->routeIs('admin.packages.*'),
            'icon' => 'compass',
        ],
        [
            'name' => 'Master Kode',
            'route' => 'admin.comcodes.index',
            'active' => request()->routeIs('admin.comcodes.*'),
            'icon' => 'database',
        ],
    ];
@endphp

<header class="border-b border-white/10 bg-[#090d16]/95 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-6 lg:px-8 py-3">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4">
        <!-- Sisi Kiri: Identitas Brand & Subtitle -->
        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-start">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 group-hover:scale-105 transition-transform flex-shrink-0">
                    <i data-lucide="compass" class="w-4 h-4"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-serif text-sm sm:text-base font-bold text-white tracking-wide">
                            {{ $settings->site_name ?? 'TiketDieng.com' }}
                        </span>
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            PANEL
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400">
                        {{ $subtitle ?? 'Pengelolaan Sistem & Konten Biro Wisata' }}
                    </p>
                </div>
            </a>

            <!-- Mobile View: Quick Actions -->
            <div class="flex items-center gap-1.5 md:hidden">
                <a href="{{ route('home') }}" target="_blank" class="p-2 rounded-lg bg-white/5 text-slate-300 hover:text-white border border-white/10" title="Buka Situs Web">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return window.confirmLogout ? window.confirmLogout(event) : confirm('Keluar dari sesi pengelola?');">
                    @csrf
                    <button type="submit" class="p-2 rounded-xl bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 border border-rose-500/20 transition-colors" title="Keluar">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sisi Tengah: Tab Menu Utama (Seragam, Rapi & Skalabel) -->
        <nav class="flex items-center p-1 rounded-xl bg-white/[0.03] border border-white/10 w-full md:w-auto justify-center gap-1 overflow-x-auto">
            @foreach($navMenus as $menu)
                <a
                    href="{{ route($menu['route']) }}"
                    class="flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all whitespace-nowrap {{ $menu['active'] ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40 shadow-sm font-semibold' : 'text-slate-400 hover:text-white hover:bg-white/5 border border-transparent' }}"
                >
                    <i data-lucide="{{ $menu['icon'] }}" class="w-3.5 h-3.5 {{ $menu['active'] ? 'text-amber-400' : 'text-slate-400' }}"></i>
                    <span>{{ $menu['name'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Sisi Kanan: Aksi Cepat, Akun & Logout (Desktop) -->
        <div class="hidden md:flex items-center gap-2.5">
            <a
                href="{{ route('home') }}"
                target="_blank"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors"
                title="Buka Website Publik di Tab Baru"
            >
                <span>Lihat Web</span>
                <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
            </a>

            <div class="h-4 w-px bg-white/10 mx-0.5"></div>

            <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300" title="Akun Aktif: {{ Auth::user()?->email ?? 'Admin' }}">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="font-medium text-white max-w-[130px] truncate text-[11px]">{{ Auth::user()?->email ?? 'Admin' }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" onsubmit="return window.confirmLogout ? window.confirmLogout(event) : confirm('Keluar dari sesi pengelola?');" class="m-0 p-0 flex items-center">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition-all duration-200 cursor-pointer shadow-sm shadow-rose-500/5 hover:shadow-rose-500/15"
                    title="Keluar dari sesi pengelola"
                >
                    <i data-lucide="log-out" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

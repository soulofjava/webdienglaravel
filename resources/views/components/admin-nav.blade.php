@props([
    'title' => null,
    'subtitle' => null,
])

@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $user = Auth::user();
    $userScope = $user ? $user->getSiteScope() : null;
    $isSuper = $user && $user->hasRole('superadmin');

    // Penentuan profil & identitas brand panel secara dinamis per unit pengelola (White-Label Multi-Tenant)
    if ($isSuper) {
        $panelBrand = 'Control Panel';
        $panelBadge = 'CENTRAL CMS';
        $panelBadgeClass = 'bg-amber-500/20 text-amber-300 border-amber-500/30';
        $panelIcon = 'layers';
        $panelDefaultSubtitle = 'Pusat Pengelolaan Konten & Multi-Unit Bisnis';
        $webPreviewUrl = route('home');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'SUPERADMIN';
        $rolePillClass = 'bg-gradient-to-r from-amber-500/25 via-amber-500/15 to-yellow-500/10 border-amber-500/40 text-amber-300 shadow-amber-500/10';
        $roleIcon = 'crown';
    } elseif ($userScope === 'lotus') {
        $panelBrand = 'Lotus Creative';
        $panelBadge = 'STUDIO PANEL';
        $panelBadgeClass = 'bg-fuchsia-500/20 text-fuchsia-300 border-fuchsia-500/30';
        $panelIcon = 'camera';
        $panelDefaultSubtitle = 'Pengelolaan Studio Fotografi & Video Dokumentasi';
        $webPreviewUrl = url('/?theme=lotus');
        $webPreviewLabel = 'Lihat Studio';
        $roleLabel = 'ADMIN LOTUS';
        $rolePillClass = 'bg-fuchsia-500/15 border-fuchsia-500/30 text-fuchsia-300 shadow-fuchsia-500/10';
        $roleIcon = 'camera';
    } elseif ($userScope === 'jeep') {
        $panelBrand = 'Jeep Dieng';
        $panelBadge = 'OPERATIONS';
        $panelBadgeClass = 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30';
        $panelIcon = 'compass';
        $panelDefaultSubtitle = 'Pengelolaan Armada & Paket Safari 4x4';
        $webPreviewUrl = url('/?theme=jeep');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'ADMIN JEEP';
        $rolePillClass = 'bg-emerald-500/15 border-emerald-500/30 text-emerald-300 shadow-emerald-500/10';
        $roleIcon = 'compass';
    } elseif ($userScope === 'shuttle') {
        $panelBrand = 'Shuttle Dieng';
        $panelBadge = 'OPERATIONS';
        $panelBadgeClass = 'bg-sky-500/20 text-sky-300 border-sky-500/30';
        $panelIcon = 'bus';
        $panelDefaultSubtitle = 'Pengelolaan Layanan Mikrobus 15 Seat';
        $webPreviewUrl = url('/?theme=shuttle');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'ADMIN SHUTTLE';
        $rolePillClass = 'bg-sky-500/15 border-sky-500/30 text-sky-300 shadow-sky-500/10';
        $roleIcon = 'bus';
    } else {
        // TiketDieng / default admin
        $panelBrand = 'TiketDieng';
        $panelBadge = 'TRAVEL PANEL';
        $panelBadgeClass = 'bg-amber-500/20 text-amber-300 border-amber-500/30';
        $panelIcon = 'compass';
        $panelDefaultSubtitle = 'Pengelolaan Paket Wisata & Biro Perjalanan';
        $webPreviewUrl = url('/?theme=tiketdieng');
        $webPreviewLabel = 'Lihat Portal';
        $roleLabel = 'ADMIN TIKETDIENG';
        $rolePillClass = 'bg-amber-500/15 border-amber-500/30 text-amber-300 shadow-amber-500/10';
        $roleIcon = 'user';
    }

    // Menu navigasi admin terpusat
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

    if ($isSuper) {
        $navMenus[] = [
            'name' => 'Kelola Pengelola',
            'route' => 'admin.users.index',
            'active' => request()->routeIs('admin.users.*'),
            'icon' => 'users',
        ];
    }
@endphp

<header class="border-b border-white/10 bg-[#090d16]/95 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-6 lg:px-8 py-3">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4">
        <!-- Sisi Kiri: Identitas Brand & Subtitle -->
        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-start">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 group-hover:scale-105 transition-transform flex-shrink-0">
                    <i data-lucide="{{ $panelIcon }}" class="w-4 h-4"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-serif text-sm sm:text-base font-bold text-white tracking-wide">
                            {{ $title ?? $panelBrand }}
                        </span>
                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider {{ $panelBadgeClass }}">
                            {{ $panelBadge }}
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400">
                        {{ $subtitle ?? $panelDefaultSubtitle }}
                    </p>
                </div>
            </a>

            <!-- Mobile View: Quick Actions -->
            <div class="flex items-center gap-1.5 md:hidden">
                <a href="{{ $webPreviewUrl }}" target="_blank" class="p-2 rounded-lg bg-white/5 text-slate-300 hover:text-white border border-white/10" title="{{ $webPreviewLabel }}">
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
                href="{{ $webPreviewUrl }}"
                target="_blank"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors"
                title="Buka Website Publik di Tab Baru"
            >
                <span>{{ $webPreviewLabel }}</span>
                <i data-lucide="external-link" class="w-3 h-3 text-slate-400"></i>
            </a>

            <div class="h-4 w-px bg-white/10 mx-0.5"></div>

            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs shadow-md {{ $rolePillClass }}" title="Akun Pengelola: {{ $user?->email }}">
                <i data-lucide="{{ $roleIcon }}" class="w-3.5 h-3.5 shrink-0"></i>
                <div class="leading-tight">
                    <span class="font-black text-[10px] tracking-widest uppercase block">{{ $roleLabel }}</span>
                    <span class="text-[10px] opacity-90 max-w-[130px] truncate block">{{ $user?->email }}</span>
                </div>
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

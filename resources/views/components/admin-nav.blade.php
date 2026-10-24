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
        $panelBadgeClass = 'bg-blue-50 text-[#0064D2] border-blue-200';
        $panelIcon = 'layers';
        $panelDefaultSubtitle = 'Pusat Pengelolaan Konten & Multi-Unit Bisnis';
        $webPreviewUrl = route('home');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'SUPERADMIN';
        $rolePillClass = 'bg-blue-50 border-blue-200 text-[#0064D2]';
        $roleIcon = 'crown';
    } elseif ($userScope === 'lotus') {
        $panelBrand = 'Lotus Creative';
        $panelBadge = 'STUDIO PANEL';
        $panelBadgeClass = 'bg-fuchsia-50 text-fuchsia-700 border-fuchsia-200';
        $panelIcon = 'camera';
        $panelDefaultSubtitle = 'Pengelolaan Studio Fotografi & Video Dokumentasi';
        $webPreviewUrl = url('/?theme=lotus');
        $webPreviewLabel = 'Lihat Studio';
        $roleLabel = 'ADMIN LOTUS';
        $rolePillClass = 'bg-fuchsia-50 border-fuchsia-200 text-fuchsia-700';
        $roleIcon = 'camera';
    } elseif ($userScope === 'jeep') {
        $panelBrand = 'Jeep Dieng';
        $panelBadge = 'OPERATIONS';
        $panelBadgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
        $panelIcon = 'compass';
        $panelDefaultSubtitle = 'Pengelolaan Armada & Paket Safari 4x4';
        $webPreviewUrl = url('/?theme=jeep');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'ADMIN JEEP';
        $rolePillClass = 'bg-emerald-50 border-emerald-200 text-emerald-700';
        $roleIcon = 'compass';
    } elseif ($userScope === 'shuttle') {
        $panelBrand = 'Shuttle Dieng';
        $panelBadge = 'OPERATIONS';
        $panelBadgeClass = 'bg-sky-50 text-sky-700 border-sky-200';
        $panelIcon = 'bus';
        $panelDefaultSubtitle = 'Pengelolaan Layanan Mikrobus 15 Seat';
        $webPreviewUrl = url('/?theme=shuttle');
        $webPreviewLabel = 'Lihat Web';
        $roleLabel = 'ADMIN SHUTTLE';
        $rolePillClass = 'bg-sky-50 border-sky-200 text-sky-700';
        $roleIcon = 'bus';
    } else {
        // TiketDieng / default admin
        $panelBrand = 'TiketDieng';
        $panelBadge = 'PARTNER EXTRANET';
        $panelBadgeClass = 'bg-blue-50 text-[#0064D2] border-blue-200';
        $panelIcon = 'compass';
        $panelDefaultSubtitle = 'Pengelolaan Paket Wisata & Biro Perjalanan';
        $webPreviewUrl = url('/?theme=tiketdieng');
        $webPreviewLabel = 'Lihat Portal';
        $roleLabel = 'ADMIN MITRA';
        $rolePillClass = 'bg-blue-50 border-blue-200 text-[#0064D2]';
        $roleIcon = 'user';
    }

    // Hitung badge cepat spesifik scope akun aktif
    $packageCount = null;
    $pickupCount = null;
    $storyCount = null;
    $photoSpotCount = null;

    if (\Illuminate\Support\Facades\Schema::hasTable('tour_packages')) {
        $pkgQ = \App\Models\TourPackage::query();
        if ($user && method_exists($user, 'getAllowedPackageCategories')) {
            $allowedCats = $user->getAllowedPackageCategories();
            if ($allowedCats !== null) {
                $pkgQ->whereIn('category', $allowedCats);
            }
        }
        $packageCount = $pkgQ->count();
    }

    if (\Illuminate\Support\Facades\Schema::hasTable('pickup_locations')) {
        $pickupCount = \App\Models\PickupLocation::count();
    }

    if (\Illuminate\Support\Facades\Schema::hasTable('destination_stories')) {
        $storyCount = \App\Models\DestinationStory::where('site_scope', $userScope ?: 'tiketdieng')->count();
    }

    if (\Illuminate\Support\Facades\Schema::hasTable('photo_spots')) {
        $spotQ = \App\Models\PhotoSpot::query();
        if ($userScope) {
            $spotQ->where('site_scope', $userScope);
        }
        $photoSpotCount = $spotQ->count();
    }

    // Bangun daftar menu yang terisolasi 100% per identitas brand pengelola
    $navMenus = [
        [
            'name' => 'Pengaturan',
            'route' => 'admin.index',
            'active' => request()->routeIs('admin.index') || request()->routeIs('admin.settings.*'),
            'icon' => 'sliders-horizontal',
            'badge' => null,
        ],
        [
            'name' => 'Hero',
            'route' => 'admin.hero.index',
            'active' => request()->routeIs('admin.hero.*'),
            'icon' => 'sparkles',
            'badge' => null,
        ],
        [
            'name' => $userScope === 'jeep' ? 'Paket Jeep 4x4' : ($userScope === 'lotus' ? 'Paket Dokumentasi' : ($userScope === 'shuttle' ? 'Paket Shuttle' : 'Paket Wisata')),
            'route' => 'admin.packages.index',
            'active' => request()->routeIs('admin.packages.*'),
            'icon' => $userScope === 'jeep' ? 'compass' : ($userScope === 'lotus' ? 'camera' : ($userScope === 'shuttle' ? 'bus' : 'compass')),
            'badge' => $packageCount,
        ],
    ];

    // Menu Cerita Babak HANYA untuk Superadmin dan Admin TiketDieng (karena ini fitur eksklusif scrollytelling TiketDieng)
    if ($isSuper || $userScope === 'tiketdieng') {
        $navMenus[] = [
            'name' => 'Cerita Babak',
            'route' => 'admin.stories.index',
            'active' => request()->routeIs('admin.stories.*') || request()->routeIs('admin.destination-stories.*'),
            'icon' => 'book-open',
            'badge' => $storyCount,
        ];
    }

    // Menu Spot / Rute: Tampil untuk Superadmin, Admin Lotus (Spot Foto), dan Admin Jeep (Destinasi Rute 4x4)
    if ($isSuper || in_array($userScope, ['lotus', 'jeep'])) {
        $spotLabel = $userScope === 'jeep' ? 'Rute Destinasi 4x4' : ($userScope === 'lotus' ? 'Spot Foto' : 'Spot & Rute');
        $spotIcon = $userScope === 'jeep' ? 'map' : 'camera';

        $navMenus[] = [
            'name' => $spotLabel,
            'route' => 'admin.photo-spots.index',
            'active' => request()->routeIs('admin.photo-spots.*'),
            'icon' => $spotIcon,
            'badge' => $photoSpotCount,
        ];
    }

    // Menu Titik Jemput: HANYA untuk Superadmin dan Admin TiketDieng / Shuttle (karena punya kalkulator surcharge penjemputan)
    if ($isSuper || in_array($userScope, ['tiketdieng', 'shuttle'])) {
        $navMenus[] = [
            'name' => 'Titik Jemput',
            'route' => 'admin.pickup-locations.index',
            'active' => request()->routeIs('admin.pickup-locations.*'),
            'icon' => 'map-pin',
            'badge' => $pickupCount,
        ];
    }

    // Menu Master Kode: HANYA untuk Superadmin (agar admin mitra tidak melihat konfigurasi sistem multi-tenant)
    if ($isSuper) {
        $navMenus[] = [
            'name' => 'Master Kode',
            'route' => 'admin.comcodes.index',
            'active' => request()->routeIs('admin.comcodes.*'),
            'icon' => 'database',
            'badge' => null,
        ];
    }

    // Menu Kelola Pengelola: HANYA untuk Superadmin
    if ($isSuper) {
        $navMenus[] = [
            'name' => 'Kelola Pengelola',
            'route' => 'admin.users.index',
            'active' => request()->routeIs('admin.users.*'),
            'icon' => 'users',
            'badge' => null,
        ];
    }
@endphp

<!-- Tiket.com Partner Extranet Topbar Navigation -->
<header class="border-b border-slate-200/90 bg-white/95 backdrop-blur-md sticky top-0 z-40 px-4 sm:px-6 lg:px-8 py-2.5 shadow-xs">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3 sm:gap-4">
        <!-- Sisi Kiri: Brand tiket.com Partner & Subtitle -->
        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-start">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 group">
                <!-- Tiket Blue Mark with Happiness Yellow Dot -->
                <div class="relative w-10 h-10 rounded-2xl bg-[#0064D2] flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:bg-[#0051A8] transition-all flex-shrink-0">
                    <i data-lucide="{{ $panelIcon }}" class="w-5 h-5"></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-[#FEDD00] border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-sans text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center">
                            {{ $title ?? $panelBrand }}
                            <span class="text-[#0064D2] ml-0.5">.</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider border {{ $panelBadgeClass }}">
                            {{ $panelBadge }}
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium hidden sm:block">
                        {{ $subtitle ?? $panelDefaultSubtitle }}
                    </p>
                </div>
            </a>

            <!-- Mobile View: Quick Actions -->
            <div class="flex items-center gap-1.5 md:hidden">
                <a href="{{ $webPreviewUrl }}" target="_blank" class="p-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200" title="{{ $webPreviewLabel }}">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return window.confirmLogout ? window.confirmLogout(event) : confirm('Keluar dari sesi pengelola?');">
                    @csrf
                    <button type="submit" class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 transition-colors" title="Keluar">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sisi Tengah: Tab Menu Navigasi (Pill Tabs tiket Partner Style) -->
        <nav class="flex items-center p-1.5 rounded-2xl bg-slate-100/90 border border-slate-200/80 w-full md:w-auto justify-start md:justify-center gap-1.5 overflow-x-auto no-scrollbar scroll-smooth">
            @foreach($navMenus as $menu)
                <a
                    href="{{ route($menu['route']) }}"
                    class="flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs transition-all whitespace-nowrap shrink-0 {{ $menu['active'] ? 'bg-[#0064D2] text-white font-bold shadow-sm shadow-blue-500/25' : 'text-slate-600 hover:text-slate-900 hover:bg-white/80 font-semibold' }}"
                >
                    <i data-lucide="{{ $menu['icon'] }}" class="w-3.5 h-3.5 shrink-0 {{ $menu['active'] ? 'text-white' : 'text-slate-500' }}"></i>
                    <span class="whitespace-nowrap">{{ $menu['name'] }}</span>
                    @if (!empty($menu['badge']))
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] font-extrabold shrink-0 {{ $menu['active'] ? 'bg-[#FEDD00] text-slate-900' : 'bg-slate-200 text-slate-700' }}">
                            {{ $menu['badge'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        <!-- Sisi Kanan: Web Publik, Profil Pengelola & Tombol Keluar (Desktop) -->
        <div class="hidden md:flex items-center gap-2.5">
            <!-- Tombol Web Publik -->
            <a
                href="{{ $webPreviewUrl }}"
                target="_blank"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:text-[#0064D2] bg-slate-50 hover:bg-blue-50/60 border border-slate-200 hover:border-blue-200 transition-all shadow-2xs"
                title="Buka Website Publik di Tab Baru"
            >
                <span>{{ $webPreviewLabel }}</span>
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-slate-400"></i>
            </a>

            <div class="h-5 w-px bg-slate-200 mx-0.5"></div>

            <!-- Avatar & Info Role Akun -->
            <div class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50/80 shadow-2xs" title="Akun Pengelola: {{ $user?->email }}">
                <div class="w-7 h-7 rounded-full bg-[#0064D2] text-white flex items-center justify-center font-extrabold text-[11px] shadow-xs flex-shrink-0">
                    {{ strtoupper(substr($user?->name ?? 'A', 0, 1)) }}
                </div>
                <div class="leading-tight text-left">
                    <span class="font-black text-[9px] tracking-wider uppercase block text-[#0064D2]">{{ $roleLabel }}</span>
                    <span class="text-[11px] font-semibold text-slate-800 max-w-[130px] truncate block">{{ $user?->name ?? $user?->email }}</span>
                </div>
            </div>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST" onsubmit="return window.confirmLogout ? window.confirmLogout(event) : confirm('Keluar dari sesi pengelola?');" class="m-0 p-0 flex items-center">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 hover:border-rose-600 transition-all duration-200 cursor-pointer shadow-2xs"
                    title="Keluar dari sesi pengelola"
                >
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

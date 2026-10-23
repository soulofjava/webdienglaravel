@extends('layouts.app')

@section('title', 'Kelola Pengguna & Staf — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Manajemen Akun Pengelola & Hak Akses Sistem (Spatie)" />

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

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1 shadow-sm">
                <div class="font-bold flex items-center gap-2 text-rose-900">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat kendala pada proses data:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-slate-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Halaman & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <span>Tiket Partner</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    <span class="text-[#0064D2] font-semibold">Pengelola</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Akun Pengelola & Hak Akses</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola staf operasional biro tiket, akun Superadmin, dan pengujian otorisasi sistem (POV Impersonate).</p>
            </div>

            <button
                type="button"
                onclick="openModalAddUser()"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 shrink-0 cursor-pointer min-h-[44px]"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pengelola Baru</span>
            </button>
        </div>

        <!-- Statistik Ringkas Pengelola (Tiket Style Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0064D2] flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase font-bold tracking-wider text-slate-400 block">Total Pengelola</span>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $users->total() }} Akun</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-amber-200/80 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="crown" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase font-bold tracking-wider text-amber-600 block">Super Administrator</span>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $totalSuperadmins }} Akun</div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-sky-200/80 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase font-bold tracking-wider text-sky-600 block">Admin Staf Operasional</span>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 font-mono mt-0.5">{{ max(0, $users->total() - $totalSuperadmins) }} Akun</div>
                </div>
            </div>
        </div>

        <!-- Bar Kontrol: Filter Role & Pencarian -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <form id="userSearchForm" action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 w-full">
                <!-- Role Filter Quick Pills -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
                    <a
                        href="{{ route('admin.users.index', ['search' => request('search')]) }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ !request('role') ? 'bg-[#0064D2] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua Role
                    </a>
                    <a
                        href="{{ route('admin.users.index', ['role' => 'superadmin', 'search' => request('search')]) }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ request('role') === 'superadmin' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Superadmin
                    </a>
                    <a
                        href="{{ route('admin.users.index', ['role' => 'admin', 'search' => request('search')]) }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ request('role') === 'admin' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Admin Staf
                    </a>
                </div>

                <!-- Search Input with Debounce & Clear -->
                <div class="relative flex-1 min-w-[200px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input
                        type="text"
                        id="userSearchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email pengelola..."
                        class="w-full pl-9 pr-8 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none placeholder:text-slate-400 transition-all"
                    />
                    @if(request('search'))
                        <a
                            href="{{ route('admin.users.index', ['role' => request('role')]) }}"
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 rounded-full hover:bg-slate-200 transition-colors"
                            title="Hapus pencarian"
                        >
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>

                @if(request('search') || request('role'))
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-1"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- 1. MOBILE-FIRST RESPONSIVE CARD VIEW (< 768px / block md:hidden) -->
        <div class="space-y-3.5 md:hidden">
            @forelse ($users as $user)
                @php
                    $isSuper = $user->hasRole('superadmin');
                    $isSelf = Auth::id() === $user->id;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-3.5 transition-all">
                    <!-- Header: Avatar + Initials + Name + Email + Role Badge -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Avatar / Initials -->
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-base shrink-0 shadow-xs {{ $isSuper ? 'bg-[#FEDD00] text-slate-900 border border-amber-300' : 'bg-blue-50 text-[#0064D2] border border-blue-200' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <h3 class="font-extrabold text-slate-900 text-sm leading-tight truncate">
                                        {{ $user->name }}
                                    </h3>
                                    @if ($isSelf)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200 shadow-xs">
                                            <i data-lucide="user" class="w-2.5 h-2.5"></i>
                                            <span>Akun Anda</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 font-mono mt-0.5">
                                    <i data-lucide="mail" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                    <span class="truncate">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Role Badge -->
                        <div class="shrink-0">
                            @if ($isSuper)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200 shadow-xs">
                                    <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                                    <span>Superadmin</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200">
                                    <i data-lucide="shield" class="w-3 h-3 text-sky-600"></i>
                                    <span>Admin Staf</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Authority Note -->
                    <div class="p-2.5 rounded-xl {{ $isSuper ? 'bg-amber-50/50 border border-amber-200/60' : 'bg-slate-50 border border-slate-200/60' }} text-[11px] leading-relaxed">
                        @if ($isSuper)
                            <div class="flex items-start gap-1.5 text-amber-900">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-600 shrink-0 mt-0.5"></i>
                                <span><strong>Hak Akses Penuh:</strong> Switcher Tema Multi-Situs, Rekening Bank, Manajemen User & Database.</span>
                            </div>
                        @else
                            <div class="flex items-start gap-1.5 text-slate-600">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-600 shrink-0 mt-0.5"></i>
                                <span><strong>Akses Operasional:</strong> Manajemen Paket Wisata, Voucher, Pesanan & Konten Promosi.</span>
                            </div>
                        @endif
                    </div>

                    <!-- Meta Information: ID & Tanggal Terdaftar -->
                    <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono px-0.5">
                        <span>ID Pengguna: #{{ $user->id }}</span>
                        <span>Terdaftar: {{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</span>
                    </div>

                    <!-- Action Buttons Toolbar (Thumb-friendly & 0px Horizontal Scroll) -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <div>
                            @if (!$isSelf)
                                <form
                                    action="{{ route('admin.users.impersonate', $user->id) }}"
                                    method="POST"
                                    onsubmit="return confirmImpersonate(event, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}');"
                                    class="inline"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 transition-all cursor-pointer text-xs font-bold min-h-[40px] shadow-xs hover:shadow-amber-500/10 active:scale-95"
                                        title="Login As {{ $user->name }}"
                                    >
                                        <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span>Login As</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Tombol Ubah -->
                            <button
                                type="button"
                                onclick="openModalEditUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $isSuper ? 'superadmin' : 'admin' }}')"
                                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 text-xs font-bold transition-colors min-h-[40px] cursor-pointer active:scale-95"
                                title="Ubah Data Pengelola"
                            >
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                <span>Ubah</span>
                            </button>

                            <!-- Tombol Hapus -->
                            @if ($isSelf)
                                <button
                                    type="button"
                                    disabled
                                    class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-300 min-h-[40px] min-w-[40px] inline-flex items-center justify-center cursor-not-allowed"
                                    title="Tidak dapat menghapus akun Anda sendiri"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            @else
                                <form
                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST"
                                    onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Akun {{ addslashes($user->name) }}', 'Akun pengelola ini akan dihapus permanen dari sistem.') : confirm('Yakin ingin menghapus pengelola {{ addslashes($user->name) }}?');"
                                    class="inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="p-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors min-h-[40px] min-w-[40px] inline-flex items-center justify-center cursor-pointer active:scale-95"
                                        title="Hapus Akun Pengelola"
                                    >
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-500 shadow-xs space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Tidak ada pengelola yang sesuai.</p>
                </div>
            @endforelse
        </div>

        <!-- 2. DESKTOP TABLE VIEW (>= 768px / hidden md:block) -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-5">Nama Pengelola</th>
                            <th class="py-3.5 px-5">Email Login</th>
                            <th class="py-3.5 px-5">Role Sistem</th>
                            <th class="py-3.5 px-5 hidden lg:table-cell">Hak Akses & Otoritas</th>
                            <th class="py-3.5 px-5 text-center">Terdaftar</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            @php
                                $isSuper = $user->hasRole('superadmin');
                                $isSelf = Auth::id() === $user->id;
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-extrabold text-xs shrink-0 {{ $isSuper ? 'bg-[#FEDD00] text-slate-900 border border-amber-300 shadow-xs' : 'bg-blue-50 text-[#0064D2] border border-blue-100' }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 flex items-center gap-2 text-sm">
                                                <span>{{ $user->name }}</span>
                                                @if ($isSelf)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200 shadow-xs">
                                                        <i data-lucide="user" class="w-2.5 h-2.5"></i>
                                                        <span>Akun Anda</span>
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] font-mono text-slate-400">ID: #{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-5 font-mono text-slate-700 text-xs">
                                    {{ $user->email }}
                                </td>

                                <td class="py-4 px-5 whitespace-nowrap">
                                    @if ($isSuper)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200 shadow-xs">
                                            <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                                            Superadmin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200">
                                            <i data-lucide="shield" class="w-3 h-3 text-sky-600"></i>
                                            Admin Staf
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-5 hidden lg:table-cell">
                                    @if ($isSuper)
                                        <span class="text-[11px] text-amber-800 font-medium leading-relaxed block">
                                            Full Akses: Switcher Tema Multi-Situs, Rekening Bank, Manajemen User & Database.
                                        </span>
                                    @else
                                        <span class="text-[11px] text-slate-500 leading-relaxed block">
                                            Operasional: Manajemen Paket Wisata, Voucher, Pesanan & Konten Promosi.
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-5 text-center font-mono text-slate-500 text-[11px] whitespace-nowrap">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}
                                </td>

                                <td class="py-4 px-5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Tombol Login As (Impersonate khusus non-self) -->
                                        @if (!$isSelf)
                                            <form
                                                action="{{ route('admin.users.impersonate', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirmImpersonate(event, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}');"
                                                class="inline"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 transition-all cursor-pointer text-xs font-bold shadow-xs hover:shadow-amber-500/10 group/login"
                                                    title="Login As {{ $user->name }}"
                                                >
                                                    <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-600 group-hover/login:scale-110 transition-transform"></i>
                                                    <span class="tracking-wide">Login As</span>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Tombol Edit -->
                                        <button
                                            type="button"
                                            onclick="openModalEditUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $isSuper ? 'superadmin' : 'admin' }}')"
                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 transition-colors cursor-pointer"
                                            title="Ubah Data Pengelola"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Tombol Hapus (Diproteksi jika akun sendiri) -->
                                        @if ($isSelf)
                                            <button
                                                type="button"
                                                disabled
                                                class="p-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-300 cursor-not-allowed"
                                                title="Tidak dapat menghapus akun Anda sendiri"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        @else
                                            <form
                                                action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Akun {{ addslashes($user->name) }}', 'Akun pengelola ini akan dihapus permanen dari sistem.') : confirm('Yakin ingin menghapus pengelola {{ addslashes($user->name) }}?');"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors cursor-pointer"
                                                    title="Hapus Akun Pengelola"
                                                >
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                        <i data-lucide="users" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-800">Tidak ada pengelola yang sesuai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Bar (Accessible on both Mobile & Desktop) -->
        @if ($users->hasPages())
            <div class="p-4 sm:px-6 rounded-2xl border border-slate-200/80 bg-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-700">{{ $users->firstItem() }}</span> - <span class="font-bold text-slate-700">{{ $users->lastItem() }}</span> dari <span class="font-bold text-slate-700">{{ $users->total() }}</span> akun pengelola
                </div>
                <div class="w-full sm:w-auto flex justify-center sm:justify-end">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </main>
</div>

<!-- MODAL TAMBAH PENGELOLA BARU -->
<div id="modalAddUser" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 relative max-h-[90vh] overflow-y-auto text-slate-800">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Tambah Pengelola Baru</h3>
                    <p class="text-xs text-slate-500">Buat kredensial login akun pengelola tiket</p>
                </div>
            </div>
            <button type="button" onclick="closeModalAddUser()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    required
                    placeholder="Contoh: Budi Santoso"
                    class="w-full p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email Login <span class="text-rose-500">*</span></label>
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="budi@tiketdieng.com"
                    class="w-full p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi (Min. 8) <span class="text-rose-500">*</span></label>
                    <div x-data="{ show: false }" class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required
                            minlength="8"
                            placeholder="••••••••"
                            class="w-full p-3 pr-11 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer" :title="show ? 'Sembunyikan' : 'Tampilkan'">
                            <i data-lucide="eye" x-show="!show" class="w-4 h-4"></i>
                            <i data-lucide="eye-off" x-show="show" class="w-4 h-4 text-[#0064D2]"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Sandi <span class="text-rose-500">*</span></label>
                    <div x-data="{ show: false }" class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="password_confirmation"
                            required
                            minlength="8"
                            placeholder="••••••••"
                            class="w-full p-3 pr-11 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                        <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer" :title="show ? 'Sembunyikan' : 'Tampilkan'">
                            <i data-lucide="eye" x-show="!show" class="w-4 h-4"></i>
                            <i data-lucide="eye-off" x-show="show" class="w-4 h-4 text-[#0064D2]"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role & Tingkat Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-[#0064D2] flex items-start gap-2.5 cursor-pointer has-[:checked]:border-[#0064D2] has-[:checked]:bg-blue-50/50 transition-all">
                        <input type="radio" name="role" value="admin" checked class="mt-0.5 text-[#0064D2] focus:ring-[#0064D2]">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Admin Staf</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Operasional paket tour & katalog.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-amber-400 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/50 transition-all">
                        <input type="radio" name="role" value="superadmin" class="mt-0.5 text-amber-500 focus:ring-amber-400">
                        <div>
                            <span class="text-xs font-bold text-amber-800 block">Super Administrator</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Full akses tema, rekening & user.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalAddUser()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer">
                    Simpan Pengelola
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGELOLA -->
<div id="modalEditUser" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-5 relative max-h-[90vh] overflow-y-auto text-slate-800">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Ubah Data Pengelola</h3>
                    <p class="text-xs text-slate-500">Perbarui identitas, sandi atau hak akses akun</p>
                </div>
            </div>
            <button type="button" onclick="closeModalEditUser()" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-colors cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="formEditUser" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input
                    type="text"
                    id="editUserName"
                    name="name"
                    required
                    class="w-full p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email Login <span class="text-rose-500">*</span></label>
                <input
                    type="email"
                    id="editUserEmail"
                    name="email"
                    required
                    class="w-full p-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                />
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800">Ubah Kata Sandi (Opsional)</span>
                    <span class="text-[10px] text-slate-400">Kosongkan bila tidak ingin diganti</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <div x-data="{ show: false }" class="relative">
                            <input
                                :type="show ? 'text' : 'password'"
                                name="password"
                                minlength="8"
                                placeholder="Sandi Baru"
                                class="w-full p-2.5 pr-10 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer">
                                <i data-lucide="eye" x-show="!show" class="w-3.5 h-3.5"></i>
                                <i data-lucide="eye-off" x-show="show" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <div x-data="{ show: false }" class="relative">
                            <input
                                :type="show ? 'text' : 'password'"
                                name="password_confirmation"
                                minlength="8"
                                placeholder="Konfirmasi Sandi"
                                class="w-full p-2.5 pr-10 rounded-xl bg-white border border-slate-300 text-slate-800 text-xs focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                            />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-700 transition-colors cursor-pointer">
                                <i data-lucide="eye" x-show="!show" class="w-3.5 h-3.5"></i>
                                <i data-lucide="eye-off" x-show="show" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role & Hak Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-[#0064D2] flex items-start gap-2.5 cursor-pointer has-[:checked]:border-[#0064D2] has-[:checked]:bg-blue-50/50 transition-all">
                        <input type="radio" id="editRoleAdmin" name="role" value="admin" class="mt-0.5 text-[#0064D2] focus:ring-[#0064D2]">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Admin Staf</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Operasional paket tour & konten.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-amber-400 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50/50 transition-all">
                        <input type="radio" id="editRoleSuperadmin" name="role" value="superadmin" class="mt-0.5 text-amber-500 focus:ring-amber-400">
                        <div>
                            <span class="text-xs font-bold text-amber-800 block">Super Administrator</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Full akses tema, rekening & user.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalEditUser()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModalAddUser() {
        document.getElementById('modalAddUser').classList.remove('hidden');
    }
    function closeModalAddUser() {
        document.getElementById('modalAddUser').classList.add('hidden');
    }

    function openModalEditUser(id, name, email, role) {
        const form = document.getElementById('formEditUser');
        form.action = `/admin/users/${id}`;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;

        if (role === 'superadmin') {
            document.getElementById('editRoleSuperadmin').checked = true;
        } else {
            document.getElementById('editRoleAdmin').checked = true;
        }

        document.getElementById('modalEditUser').classList.remove('hidden');
    }
    function closeModalEditUser() {
        document.getElementById('modalEditUser').classList.add('hidden');
    }

    function confirmImpersonate(event, userName, userEmail) {
        event.preventDefault();
        const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');

        if (window.Swal) {
            Swal.fire({
                title: 'Login As (Impersonasi)',
                html: `
                    <div class="space-y-3 text-center text-xs text-slate-600">
                        <p>Anda akan masuk dan menguji sistem atas nama:</p>
                        <div class="p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 font-bold text-sm">
                            ${userName}
                            <span class="block text-xs text-slate-500 font-mono font-normal mt-0.5">${userEmail}</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Anda dapat kembali ke akun Superadmin kapan saja melalui banner di bagian atas layar.</p>
                    </div>
                `,
                icon: 'question',
                iconColor: '#f59e0b',
                background: '#ffffff',
                color: '#1e293b',
                showCancelButton: true,
                confirmButtonColor: '#0064D2',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Masuk Sebagai Akun Ini',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl border border-slate-200 shadow-2xl p-6',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs uppercase tracking-wider text-white bg-[#0064D2] shadow-md shadow-blue-500/25 cursor-pointer',
                    cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-xs text-slate-600 hover:text-slate-900 cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
            return false;
        } else {
            if (confirm(`Masuk dan kelola sistem sebagai ${userName} (${userEmail})?`)) {
                form.submit();
            }
            return false;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('userSearchInput');
        const filterForm = document.getElementById('userSearchForm');
        let debounceTimer = null;

        if (searchInput && filterForm) {
            const initialVal = searchInput.value.trim();
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    if (searchInput.value.trim() !== initialVal) {
                        filterForm.submit();
                    }
                }, 450);
            });
        }
    });
</script>
@endpush

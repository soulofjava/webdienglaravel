@extends('layouts.app')

@section('title', 'Kelola Pengguna & Staf')

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Manajemen Akun Pengelola & Hak Akses Sistem (Spatie)" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-red-500/15 border border-red-500/40 text-red-300 text-xs sm:text-sm space-y-1">
                <div class="font-bold flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span>Terdapat kendala pada proses data:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs opacity-90 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Statistik Ringkas Pengelola -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="glass-panel p-5 rounded-2xl border border-white/10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Total Pengelola</span>
                    <div class="text-xl sm:text-2xl font-black text-white font-mono mt-0.5">{{ $users->total() }} Akun</div>
                </div>
            </div>

            <div class="glass-panel p-5 rounded-2xl border border-amber-500/20 bg-amber-500/[0.03] flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-400/20 border border-amber-400/30 flex items-center justify-center text-amber-400">
                    <i data-lucide="crown" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-amber-400/80 block">Super Administrator</span>
                    <div class="text-xl sm:text-2xl font-black text-amber-300 font-mono mt-0.5">{{ $totalSuperadmins }} Akun</div>
                </div>
            </div>

            <div class="glass-panel p-5 rounded-2xl border border-sky-500/20 bg-sky-500/[0.03] flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center text-sky-400">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-sky-400/80 block">Admin Staf Operasional</span>
                    <div class="text-xl sm:text-2xl font-black text-sky-300 font-mono mt-0.5">{{ max(0, $users->total() - $totalSuperadmins) }} Akun</div>
                </div>
            </div>
        </div>

        <!-- Bar Kontrol: Filter, Pencarian & Tombol Tambah Pengelola -->
        <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Filter & Search Form -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <div class="flex items-center gap-1">
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ !request('role') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}"
                    >
                        Semua Role
                    </a>
                    <a
                        href="{{ route('admin.users.index', ['role' => 'superadmin', 'search' => request('search')]) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request('role') === 'superadmin' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}"
                    >
                        Superadmin
                    </a>
                    <a
                        href="{{ route('admin.users.index', ['role' => 'admin', 'search' => request('search')]) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request('role') === 'admin' ? 'bg-sky-500/20 text-sky-300 border border-sky-500/40' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}"
                    >
                        Admin Staf
                    </a>
                </div>

                <div class="relative flex-1 sm:w-60">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:border-amber-400 focus:outline-none"
                    />
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2"></i>
                </div>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white text-xs" title="Reset Filter">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Tambah Pengelola Baru -->
            <button
                type="button"
                onclick="openModalAddUser()"
                class="w-full md:w-auto px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 cursor-pointer shrink-0"
            >
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pengelola Baru</span>
            </button>
        </div>

        <!-- Tabel Daftar Pengelola -->
        <div class="glass-panel rounded-2xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="uppercase tracking-wider text-[10px] text-slate-400 bg-white/[0.03] border-b border-white/10 font-bold">
                        <tr>
                            <th class="py-3.5 px-5">Nama Pengelola</th>
                            <th class="py-3.5 px-5">Email Login</th>
                            <th class="py-3.5 px-5">Role Sistem</th>
                            <th class="py-3.5 px-5 hidden sm:table-cell">Hak Akses & Otoritas</th>
                            <th class="py-3.5 px-5 text-center">Terdaftar</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($users as $user)
                            @php
                                $isSuper = $user->hasRole('superadmin');
                                $isSelf = Auth::id() === $user->id;
                            @endphp
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs {{ $isSuper ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20' : 'bg-sky-500/20 text-sky-300 border border-sky-500/30' }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white flex items-center gap-2">
                                                <span>{{ $user->name }}</span>
                                                @if ($isSelf)
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-400/10 text-amber-300 border border-amber-400/30 shadow-xs">
                                                        <svg class="w-3 h-3 text-amber-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>Akun Anda</span>
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] text-slate-500">ID Pengguna: #{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-mono text-slate-300 text-xs">
                                    {{ $user->email }}
                                </td>
                                <td class="py-4 px-5">
                                    @if ($isSuper)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/40 shadow-sm shadow-amber-500/20">
                                            <i data-lucide="crown" class="w-3 h-3 text-amber-400"></i>
                                            Superadmin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[10px] font-semibold uppercase tracking-wider bg-sky-500/15 text-sky-300 border border-sky-500/30">
                                            <i data-lucide="shield" class="w-3 h-3 text-sky-400"></i>
                                            Admin Staf
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 hidden sm:table-cell">
                                    @if ($isSuper)
                                        <span class="text-[11px] text-amber-300/90 font-medium leading-relaxed block">
                                            Full Akses: Switcher Tema Multi-Situs, Rekening Bank, Manajemen User & Database.
                                        </span>
                                    @else
                                        <span class="text-[11px] text-slate-400 leading-relaxed block">
                                            Operasional: Manajemen Paket Wisata, Voucher, Pesanan & Konten Promosi.
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-center font-mono text-slate-400 text-[11px]">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}
                                </td>
                                <td class="py-4 px-5 text-right">
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
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-400/10 hover:bg-amber-400/20 text-amber-300 hover:text-amber-200 border border-amber-400/25 hover:border-amber-400/50 transition-all cursor-pointer text-xs font-bold shadow-xs hover:shadow-amber-500/10 group/login"
                                                    title="Login As {{ $user->name }}"
                                                >
                                                    <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-400 group-hover/login:scale-110 transition-transform"></i>
                                                    <span class="tracking-wide">Login As</span>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Tombol Edit -->
                                        <button
                                            type="button"
                                            onclick="openModalEditUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $isSuper ? 'superadmin' : 'admin' }}')"
                                            class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white border border-white/10 transition-colors"
                                            title="Ubah Data Pengelola"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <!-- Tombol Hapus (Diproteksi jika akun sendiri) -->
                                        @if ($isSelf)
                                            <button
                                                type="button"
                                                disabled
                                                class="p-2 rounded-xl bg-white/[0.02] border border-white/5 text-slate-600 cursor-not-allowed"
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
                                                    class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-300 border border-rose-500/20 transition-colors cursor-pointer"
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
                                <td colspan="6" class="py-8 text-center text-slate-500 text-xs">
                                    Tidak ada data akun pengelola yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="px-5 py-4 border-t border-white/10 bg-white/[0.01]">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </main>
</div>

<!-- MODAL TAMBAH PENGELOLA BARU -->
<div id="modalAddUser" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#0c1017] border border-white/10 rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Tambah Pengelola Baru</h3>
                    <p class="text-xs text-slate-400">Buat kredensial login untuk pengelola website</p>
                </div>
            </div>
            <button type="button" onclick="closeModalAddUser()" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none" />
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email Login</label>
                <input type="email" name="email" required placeholder="budi@tiketdieng.com" class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Kata Sandi (Min. 8 Karakter)</label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required minlength="8" placeholder="••••••••" class="w-full p-3 pr-11 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none transition-all placeholder:text-slate-500" />
                        <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-white transition-colors cursor-pointer" :title="show ? 'Sembunyikan Sandi' : 'Tampilkan Sandi'">
                            <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Konfirmasi Sandi</label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required minlength="8" placeholder="••••••••" class="w-full p-3 pr-11 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none transition-all placeholder:text-slate-500" />
                        <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-white transition-colors cursor-pointer" :title="show ? 'Sembunyikan Sandi' : 'Tampilkan Sandi'">
                            <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Role & Tingkat Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-3.5 rounded-xl border border-white/10 bg-white/[0.02] hover:border-amber-400/40 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-400/[0.08]">
                        <input type="radio" name="role" value="admin" checked class="mt-0.5 text-amber-400 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-white block">Admin Staf</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Akses operasional paket tour, voucher & pemesanan.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-xl border border-white/10 bg-white/[0.02] hover:border-amber-400/40 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-400/[0.08]">
                        <input type="radio" name="role" value="superadmin" class="mt-0.5 text-amber-400 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-amber-300 block">Super Administrator</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Full akses tema multi-site, rekening & akun pengelola.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalAddUser()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20">
                    Simpan Pengelola
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGELOLA -->
<div id="modalEditUser" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#0c1017] border border-white/10 rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-400/20 text-purple-400 flex items-center justify-center font-bold">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Ubah Data Pengelola</h3>
                    <p class="text-xs text-slate-400">Perbarui identitas, sandi atau hak akses akun</p>
                </div>
            </div>
            <button type="button" onclick="closeModalEditUser()" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="formEditUser" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" id="editUserName" name="name" required class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none" />
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email Login</label>
                <input type="email" id="editUserEmail" name="email" required class="w-full p-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none" />
            </div>

            <div class="p-3.5 rounded-2xl bg-white/[0.02] border border-white/5 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-300">Ubah Kata Sandi (Opsional)</span>
                    <span class="text-[10px] text-slate-500">Kosongkan bila tidak ingin diganti</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <div x-data="{ show: false }" class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" minlength="8" placeholder="Sandi Baru (opsional)" class="w-full p-2.5 pr-10 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none transition-all placeholder:text-slate-500" />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-white transition-colors cursor-pointer" :title="show ? 'Sembunyikan Sandi' : 'Tampilkan Sandi'">
                                <svg x-show="!show" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <div x-data="{ show: false }" class="relative">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" minlength="8" placeholder="Konfirmasi Sandi Baru" class="w-full p-2.5 pr-10 rounded-xl bg-white/5 border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none transition-all placeholder:text-slate-500" />
                            <button type="button" @click="show = !show" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-white transition-colors cursor-pointer" :title="show ? 'Sembunyikan Sandi' : 'Tampilkan Sandi'">
                                <svg x-show="!show" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Role & Hak Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-3.5 rounded-xl border border-white/10 bg-white/[0.02] hover:border-amber-400/40 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-400/[0.08]">
                        <input type="radio" id="editRoleAdmin" name="role" value="admin" class="mt-0.5 text-amber-400 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-white block">Admin Staf</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Operasional paket tour & konten.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-xl border border-white/10 bg-white/[0.02] hover:border-amber-400/40 flex items-start gap-2.5 cursor-pointer has-[:checked]:border-amber-400 has-[:checked]:bg-amber-400/[0.08]">
                        <input type="radio" id="editRoleSuperadmin" name="role" value="superadmin" class="mt-0.5 text-amber-400 focus:ring-0">
                        <div>
                            <span class="text-xs font-bold text-amber-300 block">Super Administrator</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Full akses tema, rekening & user.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModalEditUser()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20">
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
                    <div class="space-y-3 text-center text-xs text-slate-300">
                        <p>Anda akan masuk dan menguji sistem atas nama:</p>
                        <div class="p-3 rounded-2xl bg-amber-400/10 border border-amber-400/25 text-amber-300 font-bold text-sm">
                            ${userName}
                            <span class="block text-xs text-slate-400 font-mono font-normal mt-0.5">${userEmail}</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Anda dapat kembali ke akun Superadmin kapan saja melalui banner di bagian atas layar.</p>
                    </div>
                `,
                icon: 'question',
                iconColor: '#f59e0b',
                background: '#0d1322',
                color: '#f8fafc',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'Ya, Masuk Sebagai Akun Ini',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl border border-white/15 shadow-2xl backdrop-blur-xl',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs uppercase tracking-wider text-slate-950 shadow-lg shadow-amber-500/25 cursor-pointer',
                    cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-xs text-slate-300 hover:text-white cursor-pointer'
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
</script>
@endpush

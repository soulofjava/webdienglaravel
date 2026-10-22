@extends('layouts.app')

@section('title', 'Master Data Kode — Tiket Partner')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Master Standar Kategori, Durasi, Titik Jemput & Badge" />

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

        <!-- Notifikasi Gagal / Proteksi Usage Guard -->
        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1 shadow-sm">
                <div class="font-bold flex items-center gap-2 text-rose-900">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat kesalahan pada isian form:</span>
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
                    <span class="text-[#0064D2] font-semibold">Master Kode</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Master Data Kode Sistem</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Standarisasi pilihan dropdown kategori paket wisata, durasi trip, badge promosi, dan meeting point.</p>
            </div>

            <button
                type="button"
                onclick="document.getElementById('modalAddComcode').classList.remove('hidden')"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/30 shrink-0 cursor-pointer"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Master Kode</span>
            </button>
        </div>

        <!-- Bar Kontrol: Filter Grup -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2 w-full">
                <span class="text-xs font-bold text-slate-400 mr-1">Filter Grup:</span>
                <a
                    href="{{ route('admin.comcodes.index') }}"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ !request('group') ? 'bg-[#0064D2] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    Semua Grup
                </a>
                @foreach ($groups as $groupKey => $groupLabel)
                    <a
                        href="{{ route('admin.comcodes.index', ['group' => $groupKey]) }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ request('group') === $groupKey ? 'bg-[#0064D2] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        {{ $groupLabel }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Daftar Master Kode (Grouped) -->
        <div class="space-y-6">
            @forelse ($comcodes as $groupName => $items)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-[#0064D2]"></span>
                            <h2 class="text-sm font-extrabold text-slate-900 tracking-wide">
                                {{ $groups[$groupName] ?? $groupName }}
                            </h2>
                            <span class="text-[10px] font-mono text-slate-500 px-2 py-0.5 rounded-md bg-white border border-slate-200 font-semibold">
                                {{ $groupName }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-slate-500 bg-slate-200/60 px-2.5 py-0.5 rounded-full">
                            {{ $items->count() }} Pilihan
                        </span>
                    </div>

                    <!-- DESKTOP TABLE VIEW -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50/40 border-b border-slate-200/60 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <tr>
                                    <th class="py-3 px-4 w-14 text-center">Urutan</th>
                                    <th class="py-3 px-5 min-w-[200px]">Nama Tampil (Label Dropdown)</th>
                                    <th class="py-3 px-5 min-w-[180px]">Nilai Teknis (Slug)</th>
                                    <th class="py-3 px-5 whitespace-nowrap">Cakupan Unit</th>
                                    <th class="py-3 px-5 hidden lg:table-cell">Keterangan</th>
                                    <th class="py-3 px-5 w-24 text-center whitespace-nowrap">Status</th>
                                    <th class="py-3 px-5 w-32 text-right whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($items as $item)
                                    @php
                                        $scope = $item->site_scope ?? 'global';
                                        $canManage = $item->canManage(auth()->user());
                                        $usedCount = $item->countUsedPackages();
                                    @endphp
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-400">
                                            {{ $item->sort_order }}
                                        </td>
                                        <td class="py-3.5 px-5 font-bold text-slate-900 text-sm">
                                            {{ $item->code_name }}
                                        </td>
                                        <td class="py-3.5 px-5 font-mono text-xs">
                                            <span class="inline-block px-2.5 py-1 rounded-lg bg-blue-50 text-[#0064D2] border border-blue-200 font-semibold">
                                                {{ $item->code_value }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-5 whitespace-nowrap">
                                            @if ($scope === 'lotus')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-fuchsia-500"></span> Lotus
                                                </span>
                                            @elseif ($scope === 'tiketdieng')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> TiketDieng
                                                </span>
                                            @elseif ($scope === 'jeep')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Jeep
                                                </span>
                                            @elseif ($scope === 'shuttle')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Shuttle
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Global
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-5 text-slate-500 hidden lg:table-cell text-[11px] leading-relaxed">
                                            {{ $item->description ?? '—' }}
                                        </td>
                                        <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                            @if ($item->is_active)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1.5">
                                                @if ($canManage)
                                                    <button
                                                        type="button"
                                                        onclick="openEditModal({{ json_encode($item) }})"
                                                        class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0064D2] border border-blue-200 transition-colors cursor-pointer"
                                                        title="Edit Master Kode"
                                                    >
                                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                    </button>

                                                    @if ($usedCount > 0)
                                                        <span
                                                            class="p-2 rounded-xl text-amber-700 bg-amber-50 border border-amber-200 inline-flex items-center gap-1 cursor-help"
                                                            title="Proteksi Integritas: Master kode ini digunakan oleh {{ $usedCount }} paket wisata aktif"
                                                        >
                                                            <i data-lucide="lock" class="w-3.5 h-3.5 text-amber-600"></i>
                                                            <span class="text-[10px] font-mono font-bold">{{ $usedCount }}</span>
                                                        </span>
                                                    @else
                                                        <form
                                                            action="{{ route('admin.comcodes.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return window.confirmDelete ? window.confirmDelete(event, '{{ addslashes($item->code_name) }}', 'Kode ini akan dihapus dari pilihan master data dropdown.') : confirm('Hapus master kode {{ $item->code_name }}?');"
                                                            class="inline"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition-colors cursor-pointer"
                                                                title="Hapus Master Kode"
                                                            >
                                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 text-[10px] text-slate-500 border border-slate-200 font-medium" title="Kode dilindungi: Hanya Superadmin atau unit terkait yang berhak mengubahnya.">
                                                        <i data-lucide="shield-check" class="w-3 h-3 text-slate-400"></i>
                                                        <span>Terkunci</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- MOBILE CARD LIST -->
                    <div class="block md:hidden p-4 space-y-3">
                        @foreach ($items as $item)
                            @php
                                $scope = $item->site_scope ?? 'global';
                                $canManage = $item->canManage(auth()->user());
                                $usedCount = $item->countUsedPackages();
                            @endphp
                            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2.5">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-1.5 mb-0.5">
                                            <span class="text-[10px] font-mono font-bold text-slate-400">#{{ $item->sort_order }}</span>
                                            <span class="text-xs font-bold text-slate-900">{{ $item->code_name }}</span>
                                        </div>
                                        <span class="font-mono text-[11px] text-[#0064D2] bg-blue-50 px-2 py-0.5 rounded border border-blue-200 inline-block font-semibold">
                                            {{ $item->code_value }}
                                        </span>
                                    </div>

                                    @if ($item->is_active)
                                        <span class="px-2 py-0.2 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-0.2 rounded-full text-[9px] font-semibold bg-slate-100 text-slate-500">
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>

                                @if($item->description)
                                    <p class="text-[11px] text-slate-500">{{ $item->description }}</p>
                                @endif

                                <div class="flex items-center justify-between gap-2 pt-2 border-t border-slate-200/60">
                                    <span class="text-[10px] uppercase font-bold text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">
                                        {{ $scope }}
                                    </span>

                                    <div class="flex items-center gap-1.5">
                                        @if ($canManage)
                                            <button
                                                type="button"
                                                onclick="openEditModal({{ json_encode($item) }})"
                                                class="px-2.5 py-1 rounded-lg bg-blue-50 text-[#0064D2] text-xs font-bold border border-blue-200 flex items-center gap-1"
                                            >
                                                <i data-lucide="edit-3" class="w-3 h-3"></i>
                                                <span>Ubah</span>
                                            </button>

                                            @if ($usedCount > 0)
                                                <span class="px-2 py-1 rounded-lg bg-amber-50 text-amber-800 text-[10px] font-bold border border-amber-200 flex items-center gap-1">
                                                    <i data-lucide="lock" class="w-3 h-3 text-amber-600"></i>
                                                    <span>{{ $usedCount }} paket</span>
                                                </span>
                                            @else
                                                <form
                                                    action="{{ route('admin.comcodes.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return window.confirmDelete ? window.confirmDelete(event, '{{ addslashes($item->code_name) }}', 'Kode akan dihapus.') : confirm('Hapus master kode?');"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 rounded-lg bg-rose-50 text-rose-600 border border-rose-200">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-[10px] text-slate-400 font-medium">Terkunci</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-500 shadow-sm">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="database" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Belum ada master kode</h3>
                    <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah Master Kode" di atas untuk menambahkan item baru.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- MODAL TAMBAH KODE BARU -->
    <div id="modalAddComcode" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-5 shadow-2xl relative text-slate-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Tambah Master Kode Baru</h3>
                        <p class="text-xs text-slate-500">Daftarkan opsi standar untuk dropdown sistem</p>
                    </div>
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('modalAddComcode').classList.add('hidden')"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-colors cursor-pointer"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('admin.comcodes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Grup Master Kode <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="code_group" required class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer">
                            @foreach ($groups as $groupKey => $groupLabel)
                                <option value="{{ $groupKey }}" {{ request('group') === $groupKey ? 'selected' : '' }}>
                                    {{ $groupLabel }} ({{ $groupKey }})
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                </div>

                @if (auth()->user() && auth()->user()->isSuperAdmin())
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cakupan Unit Bisnis (Site Scope) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="site_scope" required class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer">
                                <option value="global">Global (Berlaku untuk seluruh unit bisnis & portal)</option>
                                <option value="tiketdieng">TiketDieng (Portal Utama / Wisata Reguler)</option>
                                <option value="lotus">Lotus Creative (Fotografi, Video & Drone)</option>
                                <option value="jeep">Jeep Dieng 4x4</option>
                                <option value="shuttle">Shuttle Bus Dieng</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Tentukan unit mana yang dapat memilih dan mengelola master data ini.</p>
                    </div>
                @else
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex items-center justify-between">
                        <span>Cakupan Unit Anda:</span>
                        <span class="font-bold uppercase tracking-wider text-[#0064D2]">{{ auth()->user()->getSiteScope() }}</span>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Tampil (Label Dropdown) <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="code_name"
                        required
                        placeholder="Misal: Jeep Tour Dieng, Sunrise Sikunir, VIP Exclusive"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all font-medium"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nilai Teknis / Value Sistem <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        name="code_value"
                        required
                        placeholder="Contoh: Jeep Tour, Best Seller, atau Wonosobo"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-mono text-[#0064D2] focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all font-bold"
                    />
                    <p class="text-[11px] text-slate-400 mt-1">Nilai ini yang tersimpan di kolom database paket wisata.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil (Sort Order)</label>
                        <input
                            type="number"
                            name="sort_order"
                            value="0"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-[#0064D2] border-slate-300 focus:ring-[#0064D2] cursor-pointer" />
                            <span>Aktifkan Kode</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan Opsional</label>
                    <input
                        type="text"
                        name="description"
                        placeholder="Keterangan singkat peruntukan kode"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                    />
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="document.getElementById('modalAddComcode').classList.add('hidden')"
                        class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer"
                    >
                        Simpan Master Kode
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KODE -->
    <div id="modalEditComcode" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 sm:p-7 space-y-5 shadow-2xl relative text-slate-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0064D2] flex items-center justify-center font-bold">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Edit Master Kode</h3>
                        <p class="text-xs text-slate-500">Perbarui nilai label atau status aktif kode sistem</p>
                    </div>
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('modalEditComcode').classList.add('hidden')"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition-colors cursor-pointer"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form id="editComcodeForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Grup Master Kode <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="edit_code_group" name="code_group" required class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer">
                            @foreach ($groups as $groupKey => $groupLabel)
                                <option value="{{ $groupKey }}">{{ $groupLabel }} ({{ $groupKey }})</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                </div>

                @if (auth()->user() && auth()->user()->isSuperAdmin())
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cakupan Unit Bisnis (Site Scope) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="edit_site_scope" name="site_scope" required class="w-full appearance-none px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-medium focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none cursor-pointer">
                                <option value="global">Global (Berlaku untuk seluruh unit bisnis & portal)</option>
                                <option value="tiketdieng">TiketDieng (Portal Utama / Wisata Reguler)</option>
                                <option value="lotus">Lotus Creative (Fotografi, Video & Drone)</option>
                                <option value="jeep">Jeep Dieng 4x4</option>
                                <option value="shuttle">Shuttle Bus Dieng</option>
                            </select>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Tampil (Label Dropdown) <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        id="edit_code_name"
                        name="code_name"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all font-medium"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nilai Teknis / Value Sistem <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        id="edit_code_value"
                        name="code_value"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-mono text-[#0064D2] focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all font-bold"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                        <input
                            type="number"
                            id="edit_sort_order"
                            name="sort_order"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm font-mono focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                        />
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="w-4 h-4 rounded text-[#0064D2] border-slate-300 focus:ring-[#0064D2] cursor-pointer" />
                            <span>Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keterangan Opsional</label>
                    <input
                        type="text"
                        id="edit_description"
                        name="description"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 text-xs sm:text-sm focus:bg-white focus:border-[#0064D2] focus:ring-2 focus:ring-[#0064D2]/20 focus:outline-none transition-all"
                    />
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button
                        type="button"
                        onclick="document.getElementById('modalEditComcode').classList.add('hidden')"
                        class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#0064D2] hover:bg-[#0051ab] transition-all shadow-md shadow-blue-500/25 cursor-pointer"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEditModal(item) {
    const form = document.getElementById('editComcodeForm');
    form.action = `/admin/comcodes/${item.id}`;
    document.getElementById('edit_code_group').value = item.code_group;
    document.getElementById('edit_code_name').value = item.code_name;
    document.getElementById('edit_code_value').value = item.code_value;
    document.getElementById('edit_sort_order').value = item.sort_order ?? 0;
    document.getElementById('edit_description').value = item.description ?? '';
    document.getElementById('edit_is_active').checked = Boolean(item.is_active);

    const siteScopeSelect = document.getElementById('edit_site_scope');
    if (siteScopeSelect) {
        siteScopeSelect.value = item.site_scope || 'global';
    }

    document.getElementById('modalEditComcode').classList.remove('hidden');
    if (window.lucide) {
        window.lucide.createIcons();
    }
}
</script>
@endpush

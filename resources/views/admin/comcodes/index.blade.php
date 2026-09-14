@extends('layouts.app')

@section('title', 'Master Data Kode (Comcodes) — ' . $settings->site_name)

@section('content')
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col">
    <!-- Header Navigasi Terpadu -->
    <x-admin-nav :settings="$settings" subtitle="Master Standar Kategori, Durasi, Titik Jemput & Badge" />

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
                    <span>Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs opacity-90 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Bar Kontrol: Filter Grup, Pencarian & Tombol Tambah Kode -->
        <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Filter Grup -->
            <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
                <a
                    href="{{ route('admin.comcodes.index') }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ !request('group') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}"
                >
                    Semua Grup
                </a>
                @foreach ($groups as $groupKey => $groupLabel)
                    <a
                        href="{{ route('admin.comcodes.index', ['group' => $groupKey]) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ request('group') === $groupKey ? 'bg-amber-500/20 text-amber-300 border border-amber-500/40' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}"
                    >
                        {{ $groupLabel }}
                    </a>
                @endforeach
            </div>

            <!-- Tombol Tambah Kode -->
            <button
                type="button"
                onclick="document.getElementById('modalAddComcode').classList.remove('hidden')"
                class="w-full md:w-auto px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20 flex items-center justify-center gap-2 cursor-pointer flex-shrink-0"
            >
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Master Kode</span>
            </button>
        </div>

        <!-- Daftar Master Kode (Grouped) -->
        @forelse ($comcodes as $groupName => $items)
            <div class="glass-panel rounded-2xl border border-white/10 overflow-hidden">
                <div class="px-5 py-3.5 bg-white/[0.03] border-b border-white/10 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        <h2 class="text-sm font-bold text-white tracking-wide">
                            {{ $groups[$groupName] ?? $groupName }}
                        </h2>
                        <span class="text-[10px] font-mono text-slate-400 px-2 py-0.5 rounded bg-white/5 border border-white/10">
                            {{ $groupName }}
                        </span>
                    </div>
                    <span class="text-xs text-slate-400">
                        {{ $items->count() }} Pilihan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-white/[0.01]">
                                <th class="py-3 px-5 w-12 text-center">Urutan</th>
                                <th class="py-3 px-5">Nama Tampil (Label Dropdown)</th>
                                <th class="py-3 px-5">Nilai Teknis (Slug)</th>
                                <th class="py-3 px-5 hidden md:table-cell">Keterangan</th>
                                <th class="py-3 px-5 w-24 text-center">Status</th>
                                <th class="py-3 px-5 w-28 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-xs text-slate-300">
                            @foreach ($items as $item)
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="py-3 px-5 text-center font-mono text-slate-400">
                                        {{ $item->sort_order }}
                                    </td>
                                    <td class="py-3 px-5">
                                        <div class="font-semibold text-white flex items-center gap-2">
                                            <span>{{ $item->code_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-5 font-mono text-[11px] text-amber-300">
                                        {{ $item->code_value }}
                                    </td>
                                    <td class="py-3 px-5 text-slate-400 hidden md:table-cell text-[11px]">
                                        {{ $item->description ?? '-' }}
                                    </td>
                                    <td class="py-3 px-5 text-center">
                                        @if ($item->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-500/15 text-slate-400 border border-white/10">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-5 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button
                                                type="button"
                                                onclick="openEditModal({{ json_encode($item) }})"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-amber-300 hover:bg-white/5 transition-colors cursor-pointer"
                                                title="Edit Kode"
                                            >
                                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                            </button>

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
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-white/5 transition-colors cursor-pointer"
                                                    title="Hapus Kode"
                                                >
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="glass-panel rounded-2xl border border-white/10 p-12 text-center">
                <i data-lucide="database" class="w-12 h-12 text-slate-600 mx-auto mb-3"></i>
                <h3 class="text-sm font-semibold text-white">Belum ada master kode</h3>
                <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah Master Kode" di atas untuk menambahkan item baru.</p>
            </div>
        @endforelse
    </main>

    <!-- MODAL TAMBAH KODE BARU -->
    <div id="modalAddComcode" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="glass-panel bg-[#0b101c] border border-white/15 rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-2xl relative">
            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white">Tambah Master Kode Baru</h3>
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('modalAddComcode').classList.add('hidden')"
                    class="text-slate-400 hover:text-white"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form action="{{ route('admin.comcodes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Grup Master Kode <span class="text-amber-400">*</span></label>
                    <select name="code_group" required class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                        @foreach ($groups as $groupKey => $groupLabel)
                            <option value="{{ $groupKey }}" {{ request('group') === $groupKey ? 'selected' : '' }}>
                                {{ $groupLabel }} ({{ $groupKey }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Tampil (Label Dropdown) <span class="text-amber-400">*</span></label>
                    <input
                        type="text"
                        name="code_name"
                        required
                        placeholder="Misal: Jeep Tour Dieng, Sunrise Sikunir, VIP Exclusive"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nilai Teknis / Value Sistem <span class="text-amber-400">*</span></label>
                    <input
                        type="text"
                        name="code_value"
                        required
                        placeholder="Contoh: Jeep Tour, Best Seller, atau Wonosobo"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs font-mono text-amber-300 focus:border-amber-400 focus:outline-none"
                    />
                    <p class="text-[10px] text-slate-500 mt-1">Nilai ini yang tersimpan di database paket (misal kolom category atau badge).</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Urutan Tampil (Sort Order)</label>
                        <input
                            type="number"
                            name="sort_order"
                            value="0"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded bg-white/10 border-white/20 accent-amber-400" />
                            <span>Aktifkan Kode</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Keterangan Opsional</label>
                    <input
                        type="text"
                        name="description"
                        placeholder="Keterangan singkat peruntukan kode"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                    />
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-white/10">
                    <button
                        type="button"
                        onclick="document.getElementById('modalAddComcode').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl text-xs font-bold text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20"
                    >
                        Simpan Master Kode
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KODE -->
    <div id="modalEditComcode" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="glass-panel bg-[#0b101c] border border-white/15 rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-2xl relative">
            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white">Edit Master Kode</h3>
                </div>
                <button
                    type="button"
                    onclick="document.getElementById('modalEditComcode').classList.add('hidden')"
                    class="text-slate-400 hover:text-white"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <form id="editComcodeForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Grup Master Kode <span class="text-amber-400">*</span></label>
                    <select id="edit_code_group" name="code_group" required class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none">
                        @foreach ($groups as $groupKey => $groupLabel)
                            <option value="{{ $groupKey }}">{{ $groupLabel }} ({{ $groupKey }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Tampil (Label Dropdown) <span class="text-amber-400">*</span></label>
                    <input
                        type="text"
                        id="edit_code_name"
                        name="code_name"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nilai Teknis / Value Sistem <span class="text-amber-400">*</span></label>
                    <input
                        type="text"
                        id="edit_code_value"
                        name="code_value"
                        required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs font-mono text-amber-300 focus:border-amber-400 focus:outline-none"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Urutan Tampil</label>
                        <input
                            type="number"
                            id="edit_sort_order"
                            name="sort_order"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                        />
                    </div>
                    <div class="flex items-center pt-5">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-300">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded bg-white/10 border-white/20 accent-amber-400" />
                            <span>Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Keterangan Opsional</label>
                    <input
                        type="text"
                        id="edit_description"
                        name="description"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-[#07090e] border border-white/10 text-white text-xs focus:border-amber-400 focus:outline-none"
                    />
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-white/10">
                    <button
                        type="button"
                        onclick="document.getElementById('modalEditComcode').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl text-xs font-bold text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md shadow-amber-500/20"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

    document.getElementById('modalEditComcode').classList.remove('hidden');
}
</script>
@endsection

        <!-- Form Reset Default Terpisah -->
        <div class="pt-4 border-t border-slate-200 flex justify-end">
            <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return window.confirmDelete ? window.confirmDelete(event, 'Pengaturan Situs', 'Seluruh konfigurasi kontak, nama perusahaan, dan legalitas akan dikembalikan ke data awal bawaan.') : confirm('Kembalikan ke pengaturan awal bawaan?');">
                @csrf
                <input type="hidden" name="site_key" value="{{ $selectedSite }}">
                <button
                    type="submit"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 transition-colors cursor-pointer"
                >
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span>Kembalikan ke Pengaturan Awal</span>
                </button>
            </form>
        </div>

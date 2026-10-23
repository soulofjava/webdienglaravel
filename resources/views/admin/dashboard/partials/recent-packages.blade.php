        <!-- Clean Tabular Preview of Recent Packages -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0064D2] shrink-0">
                        <i data-lucide="compass" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Pratinjau Paket Wisata Terbaru</h3>
                        <p class="text-xs text-slate-500">Ringkasan paket tur yang baru saja ditambahkan atau diperbarui</p>
                    </div>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0064D2] hover:text-[#0051A8] hover:underline self-start sm:self-auto">
                    <span>Lihat Semua Paket ({{ $totalPackages }})</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @if($recentPackages->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="uppercase tracking-wider text-[11px] text-slate-400 bg-slate-50/80 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="py-3 px-5">Paket Wisata</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Durasi</th>
                                <th class="py-3 px-4">Tarif Dasar</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($recentPackages as $pkg)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-10 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                                @if($pkg->image_url)
                                                    <img src="{{ $pkg->image_url }}" alt="{{ $pkg->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <i data-lucide="image" class="w-4 h-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1">
                                                    {{ $pkg->title }}
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                                    slug: {{ $pkg->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-600">
                                        {{ $pkg->category ?: 'Standar' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        {{ $pkg->duration ?: '1 Hari' }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($pkg->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-[#0064D2] hover:bg-blue-50 border border-blue-200 transition-colors">
                                            <i data-lucide="edit-3" class="w-3 h-3"></i>
                                            <span>Kelola</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-slate-400 text-xs">
                    Belum ada data paket wisata yang tersimpan.
                </div>
            @endif
        </div>

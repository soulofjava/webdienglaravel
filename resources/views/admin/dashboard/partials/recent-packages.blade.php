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
                <!-- MOBILE CARD VIEW (< md: Strictly zero horizontal scroll) -->
                <div class="block md:hidden p-4 space-y-3 bg-slate-50/50">
                    @foreach ($recentPackages as $pkg)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs hover:border-blue-200 transition-all space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-16 h-14 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 shadow-2xs">
                                    @if($pkg->image_url)
                                        <img src="{{ $pkg->image_url }}" alt="{{ $pkg->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5 flex-wrap mb-1">
                                        @if($pkg->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                Draft
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-[#0064D2] border border-blue-100">
                                            {{ $pkg->category ?: 'Standar' }}
                                        </span>
                                        @if (!empty($pkg->badge))
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-[#FEDD00] text-slate-900 border border-amber-300">
                                                {{ $pkg->badge }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="font-bold text-slate-900 hover:text-[#0064D2] transition-colors text-sm line-clamp-1 block">
                                        {{ $pkg->title }}
                                    </a>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5 truncate">
                                        slug: {{ $pkg->slug }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-2 pt-2.5 border-t border-slate-100">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                        <span>{{ $pkg->duration ?: '1 Hari' }}</span>
                                    </div>
                                    <div class="font-extrabold text-[#0064D2] text-sm">
                                        Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-colors shadow-2xs">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                    <span>Kelola</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- DESKTOP TABLE VIEW (>= md: Clean compact table) -->
                <div class="hidden md:block overflow-x-auto">
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
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
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
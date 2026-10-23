        <!-- KARTU KHUSUS SUPERADMIN: MANAJEMEN AKUN PENGELOLA & ROLE (SPATIE) -->
        @if ($isSuperadmin && isset($users))
            <div id="section-users" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-extrabold text-base text-slate-900">Manajemen Tim Pengelola & Hak Akses (Spatie Role)</h2>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-700">Superadmin Only</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Daftar akun staf terautentikasi dan pembagian hak akses sistem.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-xs text-slate-500 font-mono hidden sm:inline">Total: <strong class="text-slate-800">{{ $users->count() }} Akun</strong></span>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all shadow-sm shadow-blue-500/20 flex items-center gap-1.5">
                            <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                            <span>Kelola Pengelola</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="uppercase tracking-wider text-[11px] text-slate-400 bg-slate-50/80 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="py-3 px-4">Pengelola</th>
                                <th class="py-3 px-4">Email Login</th>
                                <th class="py-3 px-4">Role Sistem</th>
                                <th class="py-3 px-4">Hak Akses & Batasan</th>
                                <th class="py-3 px-4 text-right">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $u)
                                @php
                                    $uIsSuper = $u->hasRole('superadmin');
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs {{ $uIsSuper ? 'bg-[#0064D2] text-white shadow-xs' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 flex items-center gap-2">
                                                    <span>{{ $u->name }}</span>
                                                    @if (Auth::id() === $u->id)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.2 rounded-full text-[10px] font-bold uppercase bg-blue-50 text-[#0064D2] border border-blue-200">
                                                            <span>Anda</span>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">ID #{{ $u->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-600">
                                        {{ $u->email }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                                <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                                                Superadmin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200">
                                                <i data-lucide="user" class="w-3 h-3 text-[#0064D2]"></i>
                                                Admin Staf
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($uIsSuper)
                                            <span class="text-[11px] text-slate-700 font-medium">
                                                Full Control: Multi-Site Themes, NIB & Rekening Bank, Manajemen User & Database.
                                            </span>
                                        @else
                                            <span class="text-[11px] text-slate-500">
                                                Operasional: Kelola Paket Wisata, Titik Jemput, Pesanan & Konten Promosi.
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-400 text-[11px]">
                                        {{ $u->created_at ? $u->created_at->format('d M Y') : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-[#0064D2] shrink-0"></i>
                        <span>Otorisasi role dikelola secara aman menggunakan <strong>Spatie Laravel-Permission</strong> pada tingkat middleware dan model.</span>
                    </div>
                    <span class="text-[10px] font-mono text-slate-400 hidden sm:inline">Role Table: roles & model_has_roles</span>
                </div>
            </div>
        @endif

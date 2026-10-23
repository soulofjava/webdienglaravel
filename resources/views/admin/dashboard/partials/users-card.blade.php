        <!-- KARTU KHUSUS SUPERADMIN: MANAJEMEN AKUN PENGELOLA & ROLE (SPATIE) -->
        @if ($isSuperadmin && isset($users))
            <div id="section-users" class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-8 shadow-xs space-y-6">
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

                <!-- MOBILE CARD VIEW (< md: Strictly zero horizontal scroll) -->
                <div class="block md:hidden space-y-3">
                    @foreach ($users as $u)
                        @php
                            $uIsSuper = $u->hasRole('superadmin');
                            $isSelf = Auth::id() === $u->id;
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs space-y-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-extrabold text-xs shrink-0 {{ $uIsSuper ? 'bg-[#FEDD00] text-slate-900 border border-amber-300 shadow-xs' : 'bg-blue-50 text-[#0064D2] border border-blue-100' }}">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-sm flex items-center gap-1.5 flex-wrap">
                                            <span class="truncate">{{ $u->name }}</span>
                                            @if ($isSelf)
                                                <span class="inline-flex items-center px-1.5 py-0.2 rounded-full text-[9px] font-bold uppercase bg-blue-50 text-[#0064D2] border border-blue-200">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">ID #{{ $u->id }}</div>
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    @if ($uIsSuper)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                                            <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                                            Superadmin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200">
                                            <i data-lucide="shield" class="w-3 h-3 text-[#0064D2]"></i>
                                            Admin Staf
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100 space-y-1.5 text-xs">
                                <div class="flex items-center gap-1.5 text-slate-700 font-mono text-[11px] truncate">
                                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span class="truncate">{{ $u->email }}</span>
                                </div>
                                <div class="text-[11px] {{ $uIsSuper ? 'text-amber-900/90' : 'text-slate-600' }} leading-relaxed">
                                    @if ($uIsSuper)
                                        <strong class="font-semibold text-amber-900">Full Control:</strong> Multi-Site Themes, NIB & Rekening Bank, Manajemen User & Database.
                                    @else
                                        <strong class="font-semibold text-slate-700">Operasional:</strong> Kelola Paket Wisata, Titik Jemput, Pesanan & Konten Promosi.
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-2 pt-1 border-t border-slate-100 text-[11px]">
                                <div class="flex items-center gap-1.5 text-slate-400 font-mono text-[10px]">
                                    <i data-lucide="calendar" class="w-3 h-3 text-slate-400"></i>
                                    <span>{{ $u->created_at ? $u->created_at->format('d M Y') : '—' }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if (!$isSelf)
                                        <form
                                            action="{{ route('admin.users.impersonate', $u->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Masuk ke mode POV sebagai {{ addslashes($u->name) }} ({{ addslashes($u->email) }})?');"
                                            class="inline"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold transition-colors cursor-pointer shadow-2xs"
                                                title="Login As {{ $u->name }}"
                                            >
                                                <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-600"></i>
                                                <span>Login As</span>
                                            </button>
                                        </form>
                                    @endif
                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold text-[#0064D2] bg-blue-50/60 hover:bg-blue-100 border border-blue-200 transition-colors shadow-2xs"
                                    >
                                        <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                                        <span>Kelola</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- DESKTOP TABLE VIEW (>= md: Clean compact table) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="uppercase tracking-wider text-[11px] text-slate-400 bg-slate-50/80 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="py-3 px-4">Pengelola</th>
                                <th class="py-3 px-4">Email Login</th>
                                <th class="py-3 px-4">Role Sistem</th>
                                <th class="py-3 px-4">Hak Akses & Batasan</th>
                                <th class="py-3 px-4 text-center">Terdaftar</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $u)
                                @php
                                    $uIsSuper = $u->hasRole('superadmin');
                                    $isSelf = Auth::id() === $u->id;
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs {{ $uIsSuper ? 'bg-[#FEDD00] text-slate-900 border border-amber-300 shadow-xs' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 flex items-center gap-2">
                                                    <span>{{ $u->name }}</span>
                                                    @if ($isSelf)
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
                                    <td class="py-3.5 px-4 text-center font-mono text-slate-400 text-[11px]">
                                        {{ $u->created_at ? $u->created_at->format('d M Y') : '—' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if (!$isSelf)
                                                <form
                                                    action="{{ route('admin.users.impersonate', $u->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Masuk ke mode POV sebagai {{ addslashes($u->name) }} ({{ addslashes($u->email) }})?');"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold transition-colors cursor-pointer"
                                                        title="Login As {{ $u->name }}"
                                                    >
                                                        <i data-lucide="key-round" class="w-3 h-3 text-amber-600"></i>
                                                        <span>Login As</span>
                                                    </button>
                                                </form>
                                            @endif
                                            <a
                                                href="{{ route('admin.users.index') }}"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-[#0064D2] hover:bg-blue-50 border border-blue-200 transition-colors"
                                                title="Kelola di Halaman Pengelola"
                                            >
                                                <i data-lucide="edit-3" class="w-3 h-3"></i>
                                                <span>Kelola</span>
                                            </a>
                                        </div>
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
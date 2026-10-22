@extends('layouts.app')

@section('title', 'TiketDieng Partner Extranet — Masuk Mitra')

@section('content')
@php
    $settings = \App\Models\SiteSetting::getSettings();
@endphp
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8 font-sans relative overflow-hidden">
    <!-- Subtle Background Accents -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-100/50 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Container Card (Split Screen on Desktop) -->
    <div class="relative w-full max-w-md md:max-w-4xl bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 min-h-[580px]">
            <!-- Sisi Kiri: Tiket.com Blue Brand Presentation -->
            <div class="md:col-span-5 bg-gradient-to-br from-[#0064D2] via-[#0051A8] to-blue-900 text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
                <!-- Background Geometric Accents -->
                <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute top-0 right-10 w-24 h-24 bg-[#FEDD00]/20 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Top Brand Area -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="relative w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-[#0064D2] shadow-md shadow-black/10 shrink-0">
                            <i data-lucide="compass" class="w-6 h-6"></i>
                            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-[#FEDD00] border-2 border-[#0064D2] rounded-full"></span>
                        </div>
                        <div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-white/20 text-[#FEDD00] border border-white/20">
                                EXTRANET PORTAL
                            </span>
                            <h1 class="text-lg sm:text-xl font-extrabold text-white tracking-tight mt-0.5">
                                TiketDieng Partner
                            </h1>
                        </div>
                    </div>

                    <div class="pt-2">
                        <p class="text-xs text-blue-100 leading-relaxed">
                            Pusat kendali terpadu mitra biro perjalanan: kelola paket wisata, armada offroad Jeep 4x4, layanan mikrobus shuttle, dan dokumentasi foto liburan Dieng.
                        </p>
                    </div>

                    <!-- Highlight Features -->
                    <div class="pt-4 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs text-blue-50">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[#FEDD00] shrink-0">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <span>Pembaruan Tarif & Rute Real-Time</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs text-blue-50">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[#FEDD00] shrink-0">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <span>Audit Lalu Lintas Pengunjung MySQL</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs text-blue-50">
                            <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[#FEDD00] shrink-0">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <span>Multi-Tenant & White-Label Switcher</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Security Badges -->
                <div class="pt-8 border-t border-white/15 relative z-10">
                    <div class="flex items-center justify-between text-[10px] text-blue-200">
                        <span class="flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                            256-Bit SSL Encrypted
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="lock" class="w-3.5 h-3.5 text-[#FEDD00]"></i>
                            Spatie RBAC Guard
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: Formulir Masuk Mitra -->
            <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-between">
                <div>
                    <!-- Header Form -->
                    <div class="mb-6">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 text-[#0064D2] border border-blue-200 inline-flex items-center gap-1.5 mb-2">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            Akses Terbatas Mitra & Admin
                        </span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Masuk ke Partner Extranet
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Gunakan kredensial resmi pengelola {{ $settings->site_name }} untuk membuka panel.
                        </p>
                    </div>

                    <!-- Notifikasi Peringatan Keamanan / Inactivity Timeout -->
                    @if (session('warning'))
                        <div class="mb-5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2.5">
                            <i data-lucide="shield-alert" class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-600"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif

                    <!-- Session Status Breeze -->
                    @if (session('status'))
                        <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2.5 font-medium">
                            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0 text-emerald-600"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <!-- Notifikasi Pesan Kesalahan -->
                    @if (isset($errors) && $errors->any())
                        <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2.5">
                            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-600"></i>
                            <div class="space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <p class="font-medium">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Formulir Masuk -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Alamat Email Mitra</span>
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', 'admin@tiketdieng.com') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="admin@tiketdieng.com"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] text-slate-800 bg-white text-sm placeholder:text-slate-400 transition-colors"
                            />
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="key-round" class="w-3.5 h-3.5 text-[#0064D2]"></i>
                                <span>Kata Sandi Mitra</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••••••"
                                    class="w-full px-4 py-3 pr-11 rounded-xl border border-slate-300 focus:border-[#0064D2] focus:ring-[#0064D2] text-slate-800 bg-white text-sm placeholder:text-slate-400 transition-colors"
                                />
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors p-1"
                                    title="Tampilkan / Sembunyikan Kata Sandi"
                                >
                                    <i data-lucide="eye" id="eyeIcon" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-600 pt-1">
                            <label for="remember_me" class="flex items-center gap-2 cursor-pointer select-none">
                                <input id="remember_me" type="checkbox" name="remember" class="accent-[#0064D2] rounded border-slate-300">
                                <span class="font-medium">Ingat sesi masuk</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="w-full mt-2 px-6 py-3.5 rounded-xl text-xs font-extrabold uppercase tracking-wider text-white bg-[#0064D2] hover:bg-[#0051A8] transition-all duration-200 shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                            <span>Masuk ke Panel Pengelola</span>
                        </button>
                    </form>
                </div>

                <!-- Footer Tautan Kembali -->
                <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center gap-1.5 font-bold text-[#0064D2] hover:text-[#0051A8] hover:underline transition-colors"
                    >
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke Beranda {{ $settings->site_name }}</span>
                    </a>
                    <span class="text-[11px] text-slate-400 font-mono">v2.5</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword?.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        if (window.lucide) window.lucide.createIcons();
    });
</script>
@endpush

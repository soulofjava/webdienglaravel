@extends('layouts.app')

@section('content')
@php
    $settings = \App\Models\SiteSetting::getSettings();
@endphp
<div class="min-h-screen bg-[#07090e] text-slate-100 flex flex-col items-center justify-center px-4 relative overflow-hidden">
    <!-- Dekorasi Latar Sinematik -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-gradient-to-br from-amber-500/10 via-amber-600/5 to-transparent rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-72 h-72 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Kartu Autentikasi Admin Breeze -->
    <div class="relative w-full max-w-md">
        <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
            <!-- Ikon & Lambang -->
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-4 shadow-lg shadow-amber-500/10">
                    <i data-lucide="compass" class="w-8 h-8"></i>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-2 flex items-center gap-1.5">
                    <i data-lucide="lock" class="w-3 h-3"></i>
                    Akses Terbatas Pengelola (Laravel Breeze)
                </span>
                <h1 class="font-serif text-2xl font-bold text-white tracking-wide">
                    Portal Administrator
                </h1>
                <p class="text-xs text-slate-400 mt-1 max-w-xs">
                    Silakan masukkan kredensial resmi pengelola untuk mengakses dashboard {{ $settings->site_name }}.
                </p>
            </div>

            <!-- Session Status Breeze -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs flex items-center gap-2.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Pesan Kesalahan Validasi Breeze -->
            @if (isset($errors) && $errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/15 border border-red-500/40 text-red-300 text-xs flex items-start gap-2.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Formulir Masuk Resmi Breeze -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Pengelola -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                        <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>Alamat Email Pengelola</span>
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
                        class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:bg-white/[0.08] focus:outline-none transition-all placeholder:text-slate-500"
                    />
                </div>

                <!-- Kata Sandi Pengelola -->
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5">
                        <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>Kata Sandi Pengelola</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••••••"
                            class="w-full px-4 py-3 pr-11 rounded-xl bg-white/5 border border-white/10 text-white text-sm focus:border-amber-400 focus:bg-white/[0.08] focus:outline-none transition-all placeholder:text-slate-500"
                        />
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors p-1"
                            title="Tampilkan / Sembunyikan Kata Sandi"
                        >
                            <i data-lucide="eye" id="eyeIcon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Ingat Sesi -->
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="accent-amber-400 rounded">
                        <span>Ingat sesi saya</span>
                    </label>
                </div>

                <!-- Tombol Masuk Throttled Breeze -->
                <button
                    type="submit"
                    class="w-full mt-2 px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Masuk ke Panel Pengelola</span>
                </button>
            </form>

            <!-- Navigasi Kembali ke Beranda -->
            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors"
                >
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Halaman Utama {{ $settings->site_name }}</span>
                </a>
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

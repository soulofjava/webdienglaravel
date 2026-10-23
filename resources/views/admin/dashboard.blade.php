@extends('layouts.app')

@section('title', 'Partner Extranet & Konfigurasi')

@section('content')
<div class="min-h-screen bg-[#F4F7FB] text-slate-800 flex flex-col font-sans">
    <!-- Header Navigasi Terpadu Tiket Partner -->
    <x-admin-nav :settings="$settings" subtitle="Pengaturan Identitas Biro, Kontak, Legalitas & SEO" />

    <!-- Konten Utama Panel -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Notifikasi Sukses / Error -->
        @include('admin.dashboard.partials.alerts')

        @php
            $currentUser = Auth::user();
            $isSuperadmin = $currentUser && $currentUser->hasRole('superadmin');
            
            // Query metric counts
            $totalPackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') ? \App\Models\TourPackage::count() : 0;
            $activePackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') ? \App\Models\TourPackage::where('is_active', true)->count() : 0;
            $totalPickups = \Illuminate\Support\Facades\Schema::hasTable('pickup_locations') ? \App\Models\PickupLocation::count() : 0;
            $totalComcodes = \Illuminate\Support\Facades\Schema::hasTable('comcodes') ? \App\Models\Comcode::count() : 0;
            
            // Recent packages preview
            $recentPackages = \Illuminate\Support\Facades\Schema::hasTable('tour_packages') 
                ? \App\Models\TourPackage::latest()->take(5)->get() 
                : collect();
        @endphp

        <!-- Banner Selamat Datang Tiket Partner Style -->
        @include('admin.dashboard.partials.banner')

        <!-- Prominent Summary Metric Cards (Tiket Partner Extranet Pastel Icons) -->
        @include('admin.dashboard.partials.metrics')

        <!-- Clean Tabular Preview of Recent Packages -->
        @include('admin.dashboard.partials.recent-packages')

        <!-- TAB PEMILIH SUB-WEB PENGATURAN (MULTI-SITE SETTINGS) -->
        @include('admin.dashboard.partials.scope-switcher')

        <!-- FORMULIR UTAMA PENGATURAN TIKET PARTNER -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8" id="settingsForm">
            @csrf
            <input type="hidden" name="site_key" value="{{ $selectedSite }}" id="inputSiteKey">

            <!-- KARTU KHUSUS: PENGATURAN MULTI-SITUS & GANTI TEMA (SUPERADMIN) -->
            @include('admin.dashboard.partials.theme-switcher')

            <!-- Kartu 1: Identitas Platform -->
            @include('admin.dashboard.partials.identity-card')

            <!-- Kartu 2: Profil Perusahaan, Visi & Misi -->
            @include('admin.dashboard.partials.profile-card')

            <!-- Kartu 3: Kontak & Pemesanan -->
            @include('admin.dashboard.partials.contact-card')

            <!-- Kartu 4: Alamat & Legalitas -->
            @include('admin.dashboard.partials.legal-card')

            <!-- Kartu 5: Optimasi SEO & Social Media Share -->
            @include('admin.dashboard.partials.seo-card')

            <!-- Tombol Aksi Simpan & Reset -->
            @include('admin.dashboard.partials.save-actions')
        </form>

        <!-- KARTU KHUSUS SUPERADMIN: MANAJEMEN AKUN PENGELOLA & ROLE (SPATIE) -->
        @include('admin.dashboard.partials.users-card')

        <!-- Form Reset Default Terpisah -->
        @include('admin.dashboard.partials.reset-form')
    </main>
</div>
@endsection

@push('scripts')
    @include('admin.dashboard.partials.scripts')
@endpush

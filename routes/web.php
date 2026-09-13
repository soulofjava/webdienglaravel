<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paket/{slug}', [HomeController::class, 'showPackage'])->name('package.detail');
Route::get('/api/visitor-stats', [HomeController::class, 'apiVisitorStats'])->name('api.visitor.stats');

// Redirect helper untuk Admin & Dashboard
Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');
Route::get('/dashboard', fn () => redirect()->route('admin.index'))->name('dashboard');

// Panel Pengelola Terproteksi Auth Breeze
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminSettingController::class, 'index'])->name('admin.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    Route::post('/upload/favicon', [AdminSettingController::class, 'uploadFavicon'])->name('admin.upload.favicon');
    Route::post('/upload/og-image', [AdminSettingController::class, 'uploadOgImage'])->name('admin.upload.og');
    Route::post('/settings/reset', [AdminSettingController::class, 'resetDefault'])->name('admin.settings.reset');

    // CRUD Paket Wisata & Itinerary
    Route::resource('packages', \App\Http\Controllers\AdminPackageController::class)->names([
        'index' => 'admin.packages.index',
        'create' => 'admin.packages.create',
        'store' => 'admin.packages.store',
        'show' => 'admin.packages.show',
        'edit' => 'admin.packages.edit',
        'update' => 'admin.packages.update',
        'destroy' => 'admin.packages.destroy',
    ]);
});

// Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Paket Rute Autentikasi Breeze (Login, Throttling, Logout)
require __DIR__.'/auth.php';

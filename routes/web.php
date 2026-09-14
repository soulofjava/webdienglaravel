<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paket/{slug}', [HomeController::class, 'showPackage'])->name('package.detail');
Route::get('/api/visitor-stats', [HomeController::class, 'apiVisitorStats'])->name('api.visitor.stats');
Route::get('/api/search', [SearchController::class, 'search'])->name('api.search');

// SEO XML Sitemap Dinamis untuk Googlebot
Route::get('/sitemap.xml', function () {
    $packages = \App\Models\TourPackage::where('is_active', true)->orderBy('updated_at', 'desc')->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Beranda Utama
    $xml .= '<url>';
    $xml .= '<loc>' . url('/') . '</loc>';
    $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>daily</changefreq>';
    $xml .= '<priority>1.0</priority>';
    $xml .= '</url>';

    // Setiap Halaman Paket Wisata Aktif
    foreach ($packages as $pkg) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('package.detail', $pkg->slug) . '</loc>';
        $xml .= '<lastmod>' . ($pkg->updated_at ? $pkg->updated_at->toAtomString() : now()->toAtomString()) . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

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

    // CRUD Master Data Comcodes (Dropdown Lookup)
    Route::resource('comcodes', \App\Http\Controllers\AdminComcodeController::class)->names([
        'index' => 'admin.comcodes.index',
        'create' => 'admin.comcodes.create',
        'store' => 'admin.comcodes.store',
        'show' => 'admin.comcodes.show',
        'edit' => 'admin.comcodes.edit',
        'update' => 'admin.comcodes.update',
        'destroy' => 'admin.comcodes.destroy',
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

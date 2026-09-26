<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/debug-error', function () {
    try {
        $req = request();
        $ctrl = new \App\Http\Controllers\HomeController();
        return $ctrl->index($req);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => explode("\n", $e->getTraceAsString()),
        ], 500);
    }
});
Route::get('/paket/{slug}', [HomeController::class, 'showPackage'])->name('package.detail');
Route::get('/dokumentasi', [HomeController::class, 'documentation'])->name('documentation');
Route::get('/photography', fn () => redirect()->route('documentation'));
Route::get('/lotus-creative', fn () => redirect()->route('documentation'));
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

// Panel Pengelola Terproteksi Auth Breeze & Inactivity Timeout Guard
Route::middleware(['auth', 'inactivity.timeout'])->prefix('admin')->group(function () {
    // Keepalive endpoint untuk AJAX ping perpanjangan sesi dari client
    Route::post('/session-keepalive', function () {
        session()->put('last_activity_time', time());
        return response()->json(['status' => 'active', 'timestamp' => time()]);
    })->name('admin.session.keepalive');

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

    // CRUD Titik Penjemputan (Meeting Point) untuk Kalkulator
    Route::patch('pickup-locations/{pickupLocation}/toggle', [\App\Http\Controllers\AdminPickupLocationController::class, 'toggleStatus'])->name('admin.pickup-locations.toggle');
    Route::resource('pickup-locations', \App\Http\Controllers\AdminPickupLocationController::class)->names([
        'index' => 'admin.pickup-locations.index',
        'create' => 'admin.pickup-locations.create',
        'store' => 'admin.pickup-locations.store',
        'edit' => 'admin.pickup-locations.edit',
        'update' => 'admin.pickup-locations.update',
        'destroy' => 'admin.pickup-locations.destroy',
    ]);

    // Kembali dari mode Impersonate (dapat diakses saat sedang impersonate sebagai admin biasa)
    Route::post('/leave-impersonate', [\App\Http\Controllers\AdminUserController::class, 'leaveImpersonate'])->name('admin.users.leave-impersonate');
    Route::get('/leave-impersonate', [\App\Http\Controllers\AdminUserController::class, 'leaveImpersonate']);

    // CRUD Pengelola Akun & Role (Khusus Superadmin)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::post('/users/{user}/impersonate', [\App\Http\Controllers\AdminUserController::class, 'impersonate'])->name('admin.users.impersonate');
        Route::resource('users', \App\Http\Controllers\AdminUserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });
});

// Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Paket Rute Autentikasi Breeze (Login, Throttling, Logout)
require __DIR__.'/auth.php';

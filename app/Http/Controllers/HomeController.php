<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\TourPackage;
use App\Models\VisitorStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Dynamic Multi-Theme Resolver (Prioritas: Query Param -> Host/Domain -> Database CMS)
        $activeTheme = $this->resolveActiveTheme($request);

        // Ambil settings spesifik milik sub-web aktif
        $settings = SiteSetting::getSettings($activeTheme);

        $this->recordVisitor($request);
        $visitorStats = $this->getStats();

        // Mengambil paket tour wisata aktif (di-cache 10 menit untuk respon instan)
        $packages = \Illuminate\Support\Facades\Cache::remember('home_tour_packages', 600, function () {
            return TourPackage::where('is_active', true)
                ->where('category', '!=', 'Dokumentasi')
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        });

        // Mengambil paket dokumentasi foto & drone resmi Lotus Creative (di-cache 10 menit)
        $docPackages = \Illuminate\Support\Facades\Cache::remember('home_doc_packages', 600, function () {
            return TourPackage::where('is_active', true)
                ->where('category', 'Dokumentasi')
                ->orderBy('sort_order', 'asc')
                ->get();
        });

        // Mengambil titik penjemputan kalkulator aktif (di-cache 10 menit)
        $pickupLocations = \Illuminate\Support\Facades\Cache::remember('home_pickup_locations', 600, function () {
            return \App\Models\PickupLocation::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        });

        $themeView = "themes.{$activeTheme}.home";
        if (!view()->exists($themeView)) {
            $themeView = view()->exists('home') ? 'home' : 'themes.tiketdieng.home';
        }

        return response()
            ->view($themeView, compact('settings', 'visitorStats', 'packages', 'docPackages', 'activeTheme', 'pickupLocations'))
            ->header('Cache-Control', 'public, s-maxage=60, stale-while-revalidate=300');
    }

    public function showPackage(Request $request, $slug)
    {
        $activeTheme = $this->resolveActiveTheme($request);
        $settings = SiteSetting::getSettings($activeTheme);

        $this->recordVisitor($request);

        $package = \Illuminate\Support\Facades\Cache::remember('pkg_' . $slug, 600, function () use ($slug) {
            return TourPackage::where('slug', $slug)->first();
        });

        if (!$package) {
            abort(404);
        }

        $otherPackages = \Illuminate\Support\Facades\Cache::remember('other_packages_' . $package->id, 600, function () use ($package) {
            return TourPackage::where('is_active', true)
                ->where('id', '!=', $package->id)
                ->take(3)
                ->get();
        });

        $themeView = "themes.{$activeTheme}.package-detail";
        if (!view()->exists($themeView)) {
            $themeView = view()->exists('package-detail') ? 'package-detail' : 'themes.tiketdieng.package-detail';
        }

        return response()
            ->view($themeView, compact('settings', 'package', 'otherPackages', 'activeTheme'))
            ->header('Cache-Control', 'public, s-maxage=120, stale-while-revalidate=600');
    }

    private function resolveActiveTheme(Request $request): string
    {
        if ($request->filled('theme')) {
            $t = strtolower((string) $request->query('theme'));
            if (in_array($t, ['tiketdieng', 'lotus', 'jeep', 'shuttle'])) {
                return $t;
            }
        }

        $host = strtolower((string) $request->getHost());
        if (str_contains($host, 'lotus') || str_contains($host, 'fotografi')) {
            return 'lotus';
        }
        if (str_contains($host, 'jeep')) {
            return 'jeep';
        }
        if (str_contains($host, 'shuttle')) {
            return 'shuttle';
        }

        return SiteSetting::normalizeSiteKey(null);
    }

    public function documentation(Request $request)
    {
        $settings = SiteSetting::getSettings();
        $this->recordVisitor($request);

        $docPackages = \Illuminate\Support\Facades\Cache::remember('lotus_doc_packages', 600, function () {
            return TourPackage::where('is_active', true)
                ->where('category', 'Dokumentasi')
                ->orderBy('sort_order', 'asc')
                ->get();
        });

        return response()
            ->view('documentation', compact('settings', 'docPackages'))
            ->header('Cache-Control', 'public, s-maxage=120, stale-while-revalidate=600');
    }

    public function apiVisitorStats(Request $request): JsonResponse
    {
        return response()->json($this->getStats());
    }

    private function recordVisitor(Request $request): void
    {
        try {
            $today = Carbon::today()->toDateString();
            $sessionKey = 'visited_' . $today;

            // Jika session user sudah tercatat hari ini, tidak perlu query ke database
            if ($request->hasSession() && $request->session()->has($sessionKey)) {
                return;
            }

            if ($request->hasSession()) {
                $request->session()->put($sessionKey, true);
            }

            // Cukup 1 query atomic upsert/increment ke visitor_stats (clustered PK date)
            DB::statement("
                INSERT INTO visitor_stats (`date`, `total_visits`, `unique_visitors`, `created_at`, `updated_at`)
                VALUES (?, 1, 1, NOW(), NOW())
                ON DUPLICATE KEY UPDATE 
                    `total_visits` = `total_visits` + 1,
                    `unique_visitors` = `unique_visitors` + 1,
                    `updated_at` = NOW()
            ", [$today]);
        } catch (\Throwable $e) {
            // Silently continue jika database cloud sedang mengalami latensi sesaat
        }
    }

    private function getStats(): array
    {
        return Cache::remember('visitor_stats_summary', 300, function () {
            $today = Carbon::today()->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();
            $sevenDaysAgo = Carbon::today()->subDays(6)->toDateString();
            $startOfMonth = Carbon::today()->startOfMonth()->toDateString();
            $startOfYear = Carbon::today()->startOfYear()->toDateString();

            // Konsolidasi seluruh rentang statistik menjadi 1 query tunggal berkecepatan tinggi
            $result = DB::selectOne("
                SELECT 
                    COALESCE(SUM(CASE WHEN `date` = ? THEN `total_visits` ELSE 0 END), 0) as today,
                    COALESCE(SUM(CASE WHEN `date` = ? THEN `total_visits` ELSE 0 END), 0) as yesterday,
                    COALESCE(SUM(CASE WHEN `date` >= ? THEN `total_visits` ELSE 0 END), 0) as this_week,
                    COALESCE(SUM(CASE WHEN `date` >= ? THEN `total_visits` ELSE 0 END), 0) as this_month,
                    COALESCE(SUM(CASE WHEN `date` >= ? THEN `total_visits` ELSE 0 END), 0) as this_year,
                    COALESCE(SUM(`total_visits`), 0) as total
                FROM visitor_stats
            ", [$today, $yesterday, $sevenDaysAgo, $startOfMonth, $startOfYear]);

            return [
                'today' => max(1, (int) ($result->today ?? 1)),
                'yesterday' => (int) ($result->yesterday ?? 0),
                'this_week' => max(1, (int) ($result->this_week ?? 1)),
                'this_month' => max(1, (int) ($result->this_month ?? 1)),
                'this_year' => max(1, (int) ($result->this_year ?? 1)),
                'total' => max(1, (int) ($result->total ?? 1)),
                'online' => rand(4, 9),
            ];
        });
    }
}

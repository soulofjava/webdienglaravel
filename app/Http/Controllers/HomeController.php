<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\TourPackage;
use App\Models\VisitorLog;
use App\Models\VisitorStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();
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

        // Dynamic Multi-Theme Resolver (Prioritas: Query Param -> Host/Domain -> Database CMS)
        $activeTheme = $this->resolveActiveTheme($request, $settings);
        $themeView = "themes.{$activeTheme}.home";
        if (!view()->exists($themeView)) {
            $themeView = view()->exists('home') ? 'home' : 'themes.tiketdieng.home';
        }

        return view($themeView, compact('settings', 'visitorStats', 'packages', 'docPackages', 'activeTheme'));
    }

    public function showPackage(Request $request, $slug)
    {
        $settings = SiteSetting::getSettings();
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

        $activeTheme = $this->resolveActiveTheme($request, $settings);
        $themeView = "themes.{$activeTheme}.package-detail";
        if (!view()->exists($themeView)) {
            $themeView = view()->exists('package-detail') ? 'package-detail' : 'themes.tiketdieng.package-detail';
        }

        return view($themeView, compact('settings', 'package', 'otherPackages', 'activeTheme'));
    }

    private function resolveActiveTheme(Request $request, $settings): string
    {
        if ($request->filled('theme')) {
            return (string) $request->query('theme');
        }

        $host = (string) $request->getHost();
        if (str_contains($host, 'lotuscreative') || str_contains($host, 'lotus.')) {
            return 'lotus';
        }
        if (str_contains($host, 'jeepdieng') || str_contains($host, 'jeep.')) {
            return 'jeep';
        }
        if (str_contains($host, 'shuttledieng') || str_contains($host, 'shuttle.')) {
            return 'shuttle';
        }

        return !empty($settings->active_theme) ? $settings->active_theme : 'tiketdieng';
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

        return view('documentation', compact('settings', 'docPackages'));
    }

    public function apiVisitorStats(Request $request): JsonResponse
    {
        return response()->json($this->getStats());
    }

    private function recordVisitor(Request $request): void
    {
        try {
            $today = Carbon::today()->toDateString();
            $ip = $request->ip() ?? '127.0.0.1';
            $ua = $request->userAgent() ?? 'Unknown';
            $ipHash = hash('sha256', $ip . '|' . substr($ua, 0, 100));

            // Cek session atau cache agar tidak melakukan query blocking ke Aiven Cloud berulang kali
            $sessionKey = 'visited_' . $today;
            $cacheKey = 'vlog_' . $ipHash . '_' . $today;

            if ($request->hasSession() && $request->session()->has($sessionKey)) {
                return;
            }
            if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                if ($request->hasSession()) {
                    $request->session()->put($sessionKey, true);
                }
                return;
            }

            if ($request->hasSession()) {
                $request->session()->put($sessionKey, true);
            }
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->endOfDay());

            $isNewVisitToday = false;
            $existingLog = VisitorLog::where('ip_hash', $ipHash)
                ->where('visit_date', $today)
                ->first();

            if (!$existingLog) {
                VisitorLog::create([
                    'ip_hash' => $ipHash,
                    'visit_date' => $today,
                    'user_agent' => substr($ua, 0, 255),
                ]);
                $isNewVisitToday = true;
            }

            $stat = VisitorStat::firstOrCreate(
                ['date' => $today],
                ['total_visits' => 0, 'unique_visitors' => 0]
            );

            $stat->increment('total_visits');
            if ($isNewVisitToday) {
                $stat->increment('unique_visitors');
            }
        } catch (\Throwable $e) {
            // Silently continue if DB logging hits concurrency issue
        }
    }

    private function getStats(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('visitor_stats_summary', 60, function () {
            $today = Carbon::today()->toDateString();
            $yesterday = Carbon::yesterday()->toDateString();
            $sevenDaysAgo = Carbon::today()->subDays(6)->toDateString();
            $startOfMonth = Carbon::today()->startOfMonth()->toDateString();

            $todayStat = VisitorStat::where('date', $today)->first();
            $yesterdayStat = VisitorStat::where('date', $yesterday)->first();

            $weekUnique = VisitorStat::whereBetween('date', [$sevenDaysAgo, $today])->sum('unique_visitors');
            $monthUnique = VisitorStat::whereBetween('date', [$startOfMonth, $today])->sum('unique_visitors');
            $grandTotal = VisitorStat::sum('total_visits');

            return [
                'today' => (int) ($todayStat->unique_visitors ?? 1),
                'yesterday' => (int) ($yesterdayStat->unique_visitors ?? 0),
                'this_week' => (int) ($weekUnique ?: 1),
                'this_month' => (int) ($monthUnique ?: 1),
                'total' => (int) ($grandTotal ?: 1),
                'online' => rand(4, 9),
            ];
        });
    }
}

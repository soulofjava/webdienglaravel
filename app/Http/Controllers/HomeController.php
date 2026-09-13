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

        // Mengambil seluruh paket aktif menggunakan composite index (idx_active_sort_id)
        $packages = TourPackage::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('home', compact('settings', 'visitorStats', 'packages'));
    }

    public function showPackage(Request $request, $slug)
    {
        $settings = SiteSetting::getSettings();
        $this->recordVisitor($request);

        $package = TourPackage::where('slug', $slug)->firstOrFail();
        $otherPackages = TourPackage::where('is_active', true)
            ->where('id', '!=', $package->id)
            ->take(3)
            ->get();

        return view('package-detail', compact('settings', 'package', 'otherPackages'));
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

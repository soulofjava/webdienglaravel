<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\VisitorStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminSettingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $supportedSites = SiteSetting::supportedSites();

        if ($user && !$user->isSuperAdmin()) {
            $userScope = $user->getSiteScope();
            $selectedSite = $userScope;
            // Batasi tab pengelola hanya ke unit bisnis miliknya
            $supportedSites = array_intersect_key($supportedSites, [$userScope => true]);
        } else {
            $selectedSite = SiteSetting::normalizeSiteKey($request->query('site'));
        }

        // Settings spesifik untuk sub-unit yang dipilih di panel
        $settings = SiteSetting::getSettings($selectedSite);

        // Settings induk untuk memantau tema publik yang sedang aktif
        $globalSetting = SiteSetting::getSettings('tiketdieng');

        // Statistik ringkas untuk dashboard admin (1 single consolidated query ber-cache)
        $today = Carbon::today()->toDateString();
        $statsSummary = Cache::remember('admin_visitor_stats_summary', 300, function () use ($today) {
            $row = DB::selectOne("
                SELECT 
                    COALESCE(SUM(`total_visits`), 0) as total_visits,
                    COALESCE(SUM(`unique_visitors`), 0) as total_unique,
                    COALESCE(SUM(CASE WHEN `date` = ? THEN `total_visits` ELSE 0 END), 0) as today_visits,
                    COALESCE(SUM(CASE WHEN `date` = ? THEN `unique_visitors` ELSE 0 END), 0) as today_unique
                FROM visitor_stats
            ", [$today, $today]);

            return [
                'total_visits' => (int) ($row->total_visits ?? 0),
                'total_unique' => (int) ($row->total_unique ?? 0),
                'today_visits' => (int) ($row->today_visits ?? 0),
                'today_unique' => (int) ($row->today_unique ?? 0),
            ];
        });

        // Daftar akun admin (hanya dikelola superadmin)
        $users = \App\Models\User::with('roles')->get();

        return view('admin.dashboard', compact(
            'settings',
            'globalSetting',
            'selectedSite',
            'supportedSites',
            'statsSummary',
            'users'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $siteKey = SiteSetting::normalizeSiteKey($request->input('site_key'));

        if ($user && !$user->canManageSite($siteKey)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengubah pengaturan sub-web ini.');
        }

        $rules = [
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'required|string|max:200',
            'company_name' => 'nullable|string|max:150',
            'about_us' => 'nullable|string',
            'company_history' => 'nullable|string',
            'company_vision' => 'nullable|string',
            'company_mission' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:30',
            'phone_number' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'address' => 'required|string|max:500',
            'hpi_badge' => 'nullable|string|max:100',
            'favicon_url' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'og_image_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'tiktok_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
        ];

        // Hanya Superadmin yang boleh mengubah tema dan data rekening/legalitas perusahaan
        if ($request->user() && $request->user()->hasRole('superadmin')) {
            $rules['active_theme'] = 'required|string|in:tiketdieng,lotus,jeep,shuttle';
            $rules['bank_name'] = 'nullable|string|max:100';
            $rules['bank_account_number'] = 'nullable|string|max:50';
            $rules['bank_account_name'] = 'nullable|string|max:100';
            $rules['legal_nib'] = 'nullable|string|max:100';
        }

        $validated = $request->validate($rules);

        if (!($request->user() && $request->user()->hasRole('superadmin'))) {
            unset(
                $validated['active_theme'],
                $validated['bank_name'],
                $validated['bank_account_number'],
                $validated['bank_account_name'],
                $validated['legal_nib']
            );
        }

        // Ambil atau buat record row spesifik untuk sub-unit bisnis ini
        $settingRecord = SiteSetting::find($siteKey);
        if (!$settingRecord) {
            $settingRecord = SiteSetting::create(array_merge(
                SiteSetting::getDefaultConfig($siteKey),
                ['id' => $siteKey]
            ));
        }

        $settingRecord->update($validated);

        // Jika superadmin mengubah tema aktif beranda publik, sinkronkan juga ke semua record
        if (!empty($validated['active_theme'])) {
            SiteSetting::whereIn('id', ['tiketdieng', 'default'])->update(['active_theme' => $validated['active_theme']]);
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.index', ['site' => $siteKey])
            ->with('success', "Konfigurasi sub-web '" . strtoupper($siteKey) . "' berhasil disimpan dan diperbarui!");
    }

    public function uploadFavicon(Request $request)
    {
        $user = Auth::user();
        $siteKey = SiteSetting::normalizeSiteKey($request->input('site_key'));

        if ($user && !$user->canManageSite($siteKey)) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak: Tidak berwenang mengunggah favicon untuk sub-web ini.'], 403);
        }

        $request->validate([
            'favicon' => 'required|file|mimes:ico,png,svg,webp,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon_' . $siteKey . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/favicons', $filename, 'public');

            $url = Storage::url($path);

            $settingRecord = SiteSetting::find($siteKey);
            if ($settingRecord) {
                $settingRecord->update(['favicon_url' => $url]);
            }
            SiteSetting::clearCache($siteKey);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Favicon berhasil diunggah.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah berkas.'], 400);
    }

    public function uploadOgImage(Request $request)
    {
        $user = Auth::user();
        $siteKey = SiteSetting::normalizeSiteKey($request->input('site_key'));

        if ($user && !$user->canManageSite($siteKey)) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak: Tidak berwenang mengunggah banner untuk sub-web ini.'], 403);
        }

        $request->validate([
            'og_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('og_image')) {
            $file = $request->file('og_image');
            $filename = 'og_' . $siteKey . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/og-images', $filename, 'public');

            $url = Storage::url($path);

            $settingRecord = SiteSetting::find($siteKey);
            if ($settingRecord) {
                $settingRecord->update(['og_image_url' => $url]);
            }
            SiteSetting::clearCache($siteKey);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Banner gambar media sosial berhasil diunggah.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah berkas.'], 400);
    }

    public function resetDefault(Request $request)
    {
        $user = Auth::user();
        $siteKey = SiteSetting::normalizeSiteKey($request->input('site_key'));

        if ($user && !$user->canManageSite($siteKey)) {
            abort(403, 'Akses ditolak: Tidak berwenang mereset konfigurasi sub-web ini.');
        }

        $settingRecord = SiteSetting::find($siteKey);
        if ($settingRecord) {
            $settingRecord->update(SiteSetting::getDefaultConfig($siteKey));
        }

        SiteSetting::clearCache($siteKey);

        return redirect()->route('admin.index', ['site' => $siteKey])
            ->with('success', "Konfigurasi sub-web '" . strtoupper($siteKey) . "' telah dikembalikan ke pengaturan standar bawaan.");
    }
}

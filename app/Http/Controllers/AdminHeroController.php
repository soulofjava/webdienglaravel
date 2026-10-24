<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminHeroController extends Controller
{
    /**
     * Tampilkan form editor teks hero section
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $supportedSites = SiteSetting::supportedSites();

        if ($user && !$user->isSuperAdmin()) {
            $userScope = $user->getSiteScope();
            $selectedSite = $userScope;
            $supportedSites = array_intersect_key($supportedSites, [$userScope => true]);
        } else {
            $selectedSite = SiteSetting::normalizeSiteKey($request->query('site'));
        }

        $settings = SiteSetting::getSettings($selectedSite);

        return view('admin.hero.index', compact(
            'settings',
            'selectedSite',
            'supportedSites'
        ));
    }

    /**
     * Simpan pembaruan teks hero section
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $siteKey = SiteSetting::normalizeSiteKey($request->input('site_key'));

        if ($user && !$user->canManageSite($siteKey)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki wewenang untuk mengubah pengaturan hero ini.');
        }

        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_title_accent' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_badge_text' => 'nullable|string|max:100',
            'hero_feature_1' => 'nullable|string|max:100',
            'hero_feature_2' => 'nullable|string|max:100',
            'hero_feature_3' => 'nullable|string|max:100',
            'hero_feature_4' => 'nullable|string|max:100',
        ]);

        $setting = SiteSetting::firstOrNew(['id' => $siteKey]);
        $setting->fill($validated);
        $setting->save();

        SiteSetting::clearCache($siteKey);
        Cache::forget("site_settings_{$siteKey}");
        Cache::forget('site_settings_attributes');
        Cache::forget('home_settings');

        return redirect()
            ->route('admin.hero.index', ['site' => $siteKey])
            ->with('success', 'Teks Hero section berhasil diperbarui!');
    }
}

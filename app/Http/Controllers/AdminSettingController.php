<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\VisitorStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getSettings();

        // Statistik ringkas untuk dashboard admin
        $today = Carbon::today()->toDateString();
        $totalVisits = VisitorStat::sum('total_visits');
        $totalUnique = VisitorStat::sum('unique_visitors');
        $todayVisits = VisitorStat::where('date', $today)->value('total_visits') ?? 0;
        $todayUnique = VisitorStat::where('date', $today)->value('unique_visitors') ?? 0;

        $statsSummary = [
            'total_visits' => $totalVisits,
            'total_unique' => $totalUnique,
            'today_visits' => $todayVisits,
            'today_unique' => $todayUnique,
        ];

        return view('admin.dashboard', compact('settings', 'statsSummary'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'required|string|max:200',
            'whatsapp_number' => 'required|string|max:30',
            'phone_number' => 'required|string|max:30',
            'email' => 'required|email|max:100',
            'address' => 'required|string|max:500',
            'legal_nib' => 'nullable|string|max:100',
            'hpi_badge' => 'nullable|string|max:100',
            'favicon_url' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:200',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'og_image_url' => 'nullable|string|max:255',
        ]);

        $settings = SiteSetting::getSettings();
        $settings->update($validated);

        return back()->with('success', 'Konfigurasi situs berhasil disimpan dan diperbarui!');
    }

    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|file|mimes:ico,png,svg,webp,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/favicons', $filename, 'public');

            $url = Storage::url($path);

            $settings = SiteSetting::getSettings();
            $settings->update(['favicon_url' => $url]);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Berkas favicon berhasil diunggah.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah berkas.'], 400);
    }

    public function uploadOgImage(Request $request)
    {
        $request->validate([
            'og_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('og_image')) {
            $file = $request->file('og_image');
            $filename = 'og_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/og-images', $filename, 'public');

            $url = Storage::url($path);

            $settings = SiteSetting::getSettings();
            $settings->update(['og_image_url' => $url]);

            return response()->json([
                'success' => true,
                'url' => $url,
                'message' => 'Banner gambar media sosial berhasil diunggah.',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah berkas.'], 400);
    }

    public function resetDefault()
    {
        $settings = SiteSetting::getSettings();
        $settings->update([
            'site_name' => 'TIKETDIENG.COM',
            'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng',
            'whatsapp_number' => '62816675404',
            'phone_number' => '+62 816-675-404',
            'email' => 'halo@tiketdieng.com',
            'address' => 'Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo, Jawa Tengah 56354',
            'legal_nib' => 'NIB: 1294801928472',
            'hpi_badge' => 'Anggota Resmi HPI Dieng',
            'favicon_url' => '/favicon.ico',
            'seo_title' => 'TiketDieng.com — Paket Wisata Dieng & Biro Perjalanan Resmi',
            'seo_description' => 'Biro perjalanan wisata resmi Dataran Tinggi Dieng. Nikmati keindahan Golden Sunrise Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, dan Jeep Offroad Safari dengan kenyamanan armada eksekutif.',
            'seo_keywords' => 'paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir, open trip dieng, sewa jeep dieng, travel dieng',
            'og_image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
        ]);

        return back()->with('success', 'Konfigurasi telah dikembalikan ke pengaturan standar bawaan.');
    }
}

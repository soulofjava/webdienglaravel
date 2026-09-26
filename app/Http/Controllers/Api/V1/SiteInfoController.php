<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SiteInfoController extends Controller
{
    /**
     * Mengambil informasi resmi platform, kontak CS, dan legalitas PT
     */
    public function index(): JsonResponse
    {
        $setting = SiteSetting::find('tiketdieng');

        return response()->json([
            'status' => 'success',
            'message' => 'Informasi platform berhasil diambil',
            'data' => [
                'app_name' => 'TiketDieng Mobile',
                'company_name' => $setting->company_name ?? 'PT. GOTRIP ASIA TRAVELINDO',
                'tagline' => $setting->site_tagline ?? 'Portal Resmi Wisata Dieng Plateau',
                'whatsapp' => $setting->whatsapp_number ?? '0816675404',
                'email' => $setting->email ?? 'tiket.wisatadieng@gmail.com',
                'address' => $setting->address ?? 'Tieng, Kejajar, Wonosobo, Jawa Tengah 56354',
                'legal_nib' => $setting->legal_nib ?? '0220108920194',
                'bank_official' => [
                    'bank' => $setting->bank_name ?? 'BNI (Bank Negara Indonesia)',
                    'account_number' => $setting->bank_account_number ?? '8166754042',
                    'account_name' => $setting->bank_account_name ?? 'PT. GOTRIP ASIA TRAVELINDO',
                ],
                'units' => [
                    [
                        'key' => 'tiketdieng',
                        'name' => 'TiketDieng (Induk)',
                        'type' => 'Paket Wisata & Tur All-In',
                        'domain' => 'https://webdieng.vercel.app',
                    ],
                    [
                        'key' => 'jeep',
                        'name' => 'Ready Jeep Dieng',
                        'type' => 'Safari Offroad 4x4 & Sunrise Sikunir',
                        'domain' => 'https://jeepdieng.vercel.app',
                    ],
                    [
                        'key' => 'lotus',
                        'name' => 'Lotus Creative',
                        'type' => 'Fotografi & Videografi Drone 4K',
                        'domain' => 'https://lotusfotografi.vercel.app',
                    ],
                ],
            ],
        ]);
    }
}

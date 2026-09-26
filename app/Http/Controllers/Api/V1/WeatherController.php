<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Mengambil data cuaca real-time Dieng Plateau (Open-Meteo) dengan cache 15 menit
     */
    public function current(): JsonResponse
    {
        $weatherData = Cache::remember('api_v1_dieng_weather', 900, function () {
            try {
                $response = Http::timeout(6)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => -7.2062,
                    'longitude' => 109.9015,
                    'current' => 'temperature_2m,relative_humidity_2m,weather_code',
                    'timezone' => 'Asia/Jakarta',
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $temp = round($json['current']['temperature_2m'] ?? 15);
                    $humidity = $json['current']['relative_humidity_2m'] ?? 80;
                    $code = $json['current']['weather_code'] ?? 0;

                    $status = 'Cerah Berawan';
                    $icon = 'sun';
                    if ($code >= 1 && $code <= 3) {
                        $status = 'Sebagian Berawan';
                        $icon = 'cloud-sun';
                    } elseif ($code >= 45 && $code <= 48) {
                        $status = 'Berkabut Tebal';
                        $icon = 'cloud-fog';
                    } elseif ($code >= 51 && $code <= 67) {
                        $status = 'Hujan Ringan';
                        $icon = 'cloud-rain';
                    } elseif ($code >= 80) {
                        $status = 'Hujan Deras';
                        $icon = 'cloud-lightning';
                    }

                    // Deteksi potensi embun es (frost / bun upas) jika suhu dingin
                    $frostRisk = $temp <= 10 ? 'Tinggi (Potensi Embun Es)' : ($temp <= 14 ? 'Sedang' : 'Rendah');

                    return [
                        'location' => 'Dataran Tinggi Dieng (2.263 MDPL)',
                        'temperature' => $temp,
                        'temperature_formatted' => "{$temp}°C",
                        'humidity' => $humidity,
                        'humidity_formatted' => "{$humidity}%",
                        'condition' => $status,
                        'weather_code' => $code,
                        'icon' => $icon,
                        'frost_risk' => $frostRisk,
                        'golden_sunrise_time' => '05:15 WIB',
                        'recommendation' => $temp <= 12 
                            ? 'Suhu sangat dingin. Disarankan memakai jaket tebal, kupluk, dan sarung tangan.'
                            : 'Udara sejuk khas pegunungan. Kenakan pakaian hangat yang nyaman.',
                        'updated_at' => now()->toIso8601String(),
                    ];
                }
            } catch (\Throwable $e) {
                // Fallback default jika koneksi Open-Meteo timeout
            }

            return [
                'location' => 'Dataran Tinggi Dieng (2.263 MDPL)',
                'temperature' => 12,
                'temperature_formatted' => '12°C',
                'humidity' => 85,
                'humidity_formatted' => '85%',
                'condition' => 'Sejuk Berkabut',
                'weather_code' => 45,
                'icon' => 'cloud-fog',
                'frost_risk' => 'Potensial',
                'golden_sunrise_time' => '05:15 WIB',
                'recommendation' => 'Suhu sejuk pegunungan. Siapkan jaket dan pakaian hangat.',
                'updated_at' => now()->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data cuaca Dieng berhasil diambil',
            'data' => $weatherData,
        ]);
    }
}

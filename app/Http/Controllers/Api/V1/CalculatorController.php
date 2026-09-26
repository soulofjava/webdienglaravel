<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalculatorController extends Controller
{
    /**
     * Menghitung estimasi biaya wisata, jeep, atau dokumentasi Dieng
     */
    public function estimate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|in:tur,jeep,fotografi',
            'participants' => 'required|integer|min:1|max:50',
            'duration_days' => 'nullable|integer|in:1,2,3',
            'include_jeep' => 'nullable|boolean',
            'include_photography' => 'nullable|boolean',
            'customer_name' => 'nullable|string|max:100',
            'visit_date' => 'nullable|string|max:50',
        ]);

        $category = $validated['category'];
        $participants = $validated['participants'];
        $durationDays = $validated['duration_days'] ?? 1;
        $includeJeep = $validated['include_jeep'] ?? false;
        $includePhotography = $validated['include_photography'] ?? false;

        $breakdown = [];
        $total = 0;

        if ($category === 'tur') {
            $baseRates = [
                1 => 450000,
                2 => 1100000,
                3 => 1750000,
            ];
            $ratePerPerson = $baseRates[$durationDays] ?? 450000;
            $subtotalTour = $ratePerPerson * $participants;
            $total += $subtotalTour;

            $breakdown[] = [
                'item' => "Paket Wisata {$durationDays} Hari ({$participants} Orang)",
                'rate' => $ratePerPerson,
                'subtotal' => $subtotalTour,
            ];

            if ($includeJeep) {
                $jeepCount = (int) ceil($participants / 4);
                $jeepCost = $jeepCount * 850000;
                $total += $jeepCost;
                $breakdown[] = [
                    'item' => "Ready Jeep Sunrise Safari 4x4 ({$jeepCount} Unit)",
                    'rate' => 850000,
                    'subtotal' => $jeepCost,
                ];
            }

            if ($includePhotography) {
                $photoCost = 1250000;
                $total += $photoCost;
                $breakdown[] = [
                    'item' => 'Dokumentasi Cinematic Fullframe & Drone 4K (Lotus Creative)',
                    'rate' => 1250000,
                    'subtotal' => $photoCost,
                ];
            }
        } elseif ($category === 'jeep') {
            $jeepCount = (int) ceil($participants / 4);
            $subtotalJeep = $jeepCount * 850000;
            $total += $subtotalJeep;

            $breakdown[] = [
                'item' => "Armada Ready Jeep Safari All-In ({$jeepCount} Unit)",
                'rate' => 850000,
                'subtotal' => $subtotalJeep,
            ];

            if ($includePhotography) {
                $photoCost = 950000;
                $total += $photoCost;
                $breakdown[] = [
                    'item' => 'Add-on Dokumentasi Driver & Drone Sikunir',
                    'rate' => 950000,
                    'subtotal' => $photoCost,
                ];
            }
        } else {
            // Fotografi / Dokumentasi
            $total = 1250000;
            $breakdown[] = [
                'item' => 'Sesi Dokumentasi Fotografer Pro + Drone 4K Full Day',
                'rate' => 1250000,
                'subtotal' => 1250000,
            ];
        }

        $formattedTotal = 'Rp ' . number_format($total, 0, ',', '.');

        // Nomor CS default
        $setting = SiteSetting::find('tiketdieng');
        $rawPhone = $setting->whatsapp_number ?? '0816675404';
        $cleanedPhone = preg_replace('/[^0-9]/', '', $rawPhone);
        if (str_starts_with($cleanedPhone, '0')) {
            $cleanedPhone = '62' . substr($cleanedPhone, 1);
        }

        // Generate teks WhatsApp yang rapi
        $catLabel = strtoupper($category);
        $dateText = !empty($validated['visit_date']) ? " (Tanggal: {$validated['visit_date']})" : "";
        $message = "Halo Admin TiketDieng, saya ingin konsultasi simulasi paket {$catLabel}{$dateText} untuk {$participants} orang dengan estimasi total {$formattedTotal}. Apakah jadwal masih tersedia?";
        $whatsappUrl = "https://wa.me/{$cleanedPhone}?text=" . rawurlencode($message);

        // Catat lead event ke log
        Log::info("Lead Simulator Dieng: Cat={$category}, Tamu={$participants}, Total={$total}");

        return response()->json([
            'status' => 'success',
            'message' => 'Estimasi biaya berhasil dihitung',
            'data' => [
                'category' => $category,
                'participants' => $participants,
                'duration_days' => $durationDays,
                'breakdown' => $breakdown,
                'total_amount' => $total,
                'total_formatted' => $formattedTotal,
                'whatsapp_cs' => $cleanedPhone,
                'whatsapp_direct_url' => $whatsappUrl,
                'prefilled_message' => $message,
            ],
        ]);
    }
}

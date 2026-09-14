<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Endpoint pencarian cepat global untuk paket wisata dan destinasi.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->get('q', ''));

        // Jika query kosong, kembalikan paket populer / rekomendasi
        if (mb_strlen($query) < 2) {
            $popularPackages = TourPackage::where('is_active', true)
                ->orderBy('is_popular', 'desc')
                ->orderBy('sort_order', 'asc')
                ->limit(4)
                ->get()
                ->map(function ($pkg) {
                    return [
                        'id' => $pkg->id,
                        'title' => $pkg->title,
                        'slug' => $pkg->slug,
                        'url' => route('package.detail', $pkg->slug),
                        'category' => $pkg->category,
                        'duration' => $pkg->duration,
                        'price' => $pkg->formatted_price,
                        'badge' => $pkg->badge,
                        'image_url' => $pkg->image_url,
                        'match_type' => 'rekomendasi',
                        'highlight' => $pkg->summary,
                    ];
                });

            return response()->json([
                'status' => 'success',
                'is_default' => true,
                'total' => $popularPackages->count(),
                'data' => $popularPackages,
            ]);
        }

        $term = mb_strtolower($query);

        // Cari di TourPackage (title, category, duration, pickup_location, summary, itinerary_options)
        $packages = TourPackage::where('is_active', true)
            ->where(function ($q) use ($term) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(category) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(duration) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(pickup_location) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(summary) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(CAST(itinerary_options AS CHAR)) LIKE ?', ["%{$term}%"]);
            })
            ->orderBy('is_popular', 'desc')
            ->orderBy('sort_order', 'asc')
            ->limit(8)
            ->get()
            ->map(function ($pkg) use ($term) {
                // Cari apakah ada rute spesifik yang cocok
                $matchedRoute = null;
                if (!empty($pkg->itinerary_options) && is_array($pkg->itinerary_options)) {
                    foreach ($pkg->itinerary_options as $option) {
                        $destStr = is_array($option['destinations'] ?? null) 
                            ? implode(', ', $option['destinations']) 
                            : ($option['destinations'] ?? '');
                        $ruteName = $option['name'] ?? '';

                        if (str_contains(mb_strtolower($destStr), $term) || str_contains(mb_strtolower($ruteName), $term)) {
                            $matchedRoute = $ruteName . ': ' . $destStr;
                            break;
                        }
                    }
                }

                return [
                    'id' => $pkg->id,
                    'title' => $pkg->title,
                    'slug' => $pkg->slug,
                    'url' => route('package.detail', $pkg->slug),
                    'category' => $pkg->category,
                    'duration' => $pkg->duration,
                    'price' => $pkg->formatted_price,
                    'badge' => $pkg->badge,
                    'image_url' => $pkg->image_url,
                    'match_type' => $matchedRoute ? 'rute' : 'paket',
                    'highlight' => $matchedRoute ?: $pkg->summary,
                ];
            });

        return response()->json([
            'status' => 'success',
            'is_default' => false,
            'query' => $query,
            'total' => $packages->count(),
            'data' => $packages,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PickupLocation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PickupLocationController extends Controller
{
    /**
     * Mengambil daftar titik penjemputan aktif beserta biaya tambahannya.
     * Di-cache permanen & otomatis di-bust saat ada perubahan di admin CRUD.
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'api_v1_pickup_locations';
        $locations = Cache::rememberForever($cacheKey, function () {
            return PickupLocation::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($loc) {
                    return [
                        'id' => $loc->id,
                        'name' => $loc->name,
                        'description' => $loc->description ?? '',
                        'surcharge_per_pax' => (int) $loc->surcharge_per_pax,
                        'is_active' => (bool) $loc->is_active,
                        'sort_order' => (int) $loc->sort_order,
                    ];
                });
        });

        $etag = '"' . md5(json_encode($locations)) . '"';

        if ($request->header('If-None-Match') === $etag) {
            return response()->json(null, 304, [
                'ETag' => $etag,
                'Cache-Control' => 'public, max-age=86400, stale-while-revalidate=604800',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar titik penjemputan berhasil diambil',
            'data' => $locations,
        ], 200, [
            'ETag' => $etag,
            'Cache-Control' => 'public, max-age=86400, stale-while-revalidate=604800',
        ]);
    }
}

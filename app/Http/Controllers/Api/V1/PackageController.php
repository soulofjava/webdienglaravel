<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PackageController extends Controller
{
    /**
     * Menampilkan daftar paket wisata publik untuk wisatawan dengan 2-Layer Cache Permanen:
     * - Layer 1: HTTP Cache-Control & ETag (304 Not Modified)
     * - Layer 2: Database Cache di Aiven MySQL (rememberForever, auto-bust saat CRUD admin)
     */
    public function index(Request $request): JsonResponse
    {
        $version = TourPackage::getVersion();
        $querySignature = md5(json_encode($request->query()));
        $cacheKey = "api_v1_packages_{$version}_{$querySignature}";
        $etag = '"' . md5("pkg_list_{$version}_{$querySignature}") . '"';

        // Cek jika client memiliki cache yang sama via ETag (304 Not Modified)
        if ($request->header('If-None-Match') === $etag) {
            return response()->json(null, 304, [
                'ETag' => $etag,
                'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            ]);
        }

        $responseData = Cache::rememberForever($cacheKey, function () use ($request) {
            $query = TourPackage::query()
                ->where('is_active', true);

            // Filter kategori
            if ($request->filled('category')) {
                $category = $request->query('category');
                if ($category === 'jeep') {
                    $query->where(function ($q) {
                        $q->where('category', 'LIKE', '%Jeep%')
                          ->orWhere('category', 'LIKE', '%Safari%');
                    });
                } elseif ($category === 'fotografi' || $category === 'dokumentasi') {
                    $query->where(function ($q) {
                        $q->where('category', 'LIKE', '%Dokumentasi%')
                          ->orWhere('category', 'LIKE', '%Foto%');
                    });
                } elseif ($category === 'tur' || $category === 'tour') {
                    $query->where('category', 'NOT LIKE', '%Dokumentasi%')
                          ->where('category', 'NOT LIKE', '%Jeep%')
                          ->where('category', 'NOT LIKE', '%Safari%');
                } else {
                    $query->where('category', $category);
                }
            }

            // Pencarian teks
            if ($request->filled('search')) {
                $search = $request->query('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('summary', 'LIKE', "%{$search}%")
                      ->orWhere('badge', 'LIKE', "%{$search}%");
                });
            }

            // Filter paket terpopuler
            if ($request->boolean('popular')) {
                $query->where('is_popular', true);
            }

            // Pengurutan
            switch ($request->query('sort')) {
                case 'cheapest':
                    $query->orderBy('price', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('price', 'desc');
                    break;
                case 'popular':
                    $query->orderByDesc('is_popular')->orderBy('sort_order', 'asc');
                    break;
                default:
                    $query->orderBy('sort_order', 'asc')->orderByDesc('id');
                    break;
            }

            $limit = min((int) $request->query('limit', 20), 50);
            $packages = $query->paginate($limit);

            return [
                'status' => 'success',
                'message' => 'Daftar paket wisata berhasil diambil',
                'data' => $packages->items(),
                'pagination' => [
                    'current_page' => $packages->currentPage(),
                    'last_page' => $packages->lastPage(),
                    'per_page' => $packages->perPage(),
                    'total' => $packages->total(),
                ],
            ];
        });

        return response()->json($responseData, 200, [
            'ETag' => $etag,
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            'X-Cache-Version' => $version,
        ]);
    }

    /**
     * Menampilkan detail satu paket wisata dengan cache permanen
     */
    public function show(Request $request, string $slugOrId): JsonResponse
    {
        $version = TourPackage::getVersion();
        $cacheKey = "api_v1_pkg_detail_{$version}_{$slugOrId}";
        $etag = '"' . md5("pkg_detail_{$version}_{$slugOrId}") . '"';

        if ($request->header('If-None-Match') === $etag) {
            return response()->json(null, 304, [
                'ETag' => $etag,
                'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            ]);
        }

        $package = Cache::rememberForever($cacheKey, function () use ($slugOrId) {
            return TourPackage::where('is_active', true)
                ->where(function ($q) use ($slugOrId) {
                    $q->where('slug', $slugOrId)
                      ->orWhere('id', $slugOrId);
                })
                ->first();
        });

        if (!$package) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paket wisata tidak ditemukan atau sedang tidak aktif',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail paket wisata berhasil diambil',
            'data' => $package,
        ], 200, [
            'ETag' => $etag,
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            'X-Cache-Version' => $version,
        ]);
    }

    /**
     * Daftar kategori paket beserta jumlahnya dengan cache permanen
     */
    public function categories(Request $request): JsonResponse
    {
        $version = TourPackage::getVersion();
        $cacheKey = "api_v1_categories_{$version}";
        $etag = '"' . md5("categories_{$version}") . '"';

        if ($request->header('If-None-Match') === $etag) {
            return response()->json(null, 304, [
                'ETag' => $etag,
                'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            ]);
        }

        $categories = Cache::rememberForever($cacheKey, function () {
            return TourPackage::where('is_active', true)
                ->selectRaw('category, COUNT(*) as total_packages')
                ->groupBy('category')
                ->orderByDesc('total_packages')
                ->get();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar kategori berhasil diambil',
            'data' => $categories,
        ], 200, [
            'ETag' => $etag,
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
            'X-Cache-Version' => $version,
        ]);
    }
}

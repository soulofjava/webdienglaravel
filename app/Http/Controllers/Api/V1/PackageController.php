<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Menampilkan daftar paket wisata publik untuk wisatawan
     * 
     * Query Parameters:
     * - category: 'jeep', 'tur', 'fotografi', 'dokumentasi', dll
     * - search: kata kunci pencarian judul / ringkasan
     * - popular: 1 atau true (hanya paket terpopuler)
     * - sort: 'cheapest', 'highest', 'popular', 'order' (default)
     * - limit: jumlah item per halaman (default: 20)
     */
    public function index(Request $request): JsonResponse
    {
        $query = TourPackage::query()
            ->where('is_active', true);

        // Filter berdasarkan kategori
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

        // Pengurutan (Sorting)
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

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar paket wisata berhasil diambil',
            'data' => $packages->items(),
            'pagination' => [
                'current_page' => $packages->currentPage(),
                'last_page' => $packages->lastPage(),
                'per_page' => $packages->perPage(),
                'total' => $packages->total(),
            ],
        ]);
    }

    /**
     * Menampilkan detail satu paket wisata
     */
    public function show(string $slugOrId): JsonResponse
    {
        $package = TourPackage::where('is_active', true)
            ->where(function ($q) use ($slugOrId) {
                $q->where('slug', $slugOrId)
                  ->orWhere('id', $slugOrId);
            })
            ->first();

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
        ]);
    }

    /**
     * Daftar kategori paket beserta jumlahnya
     */
    public function categories(): JsonResponse
    {
        $categories = TourPackage::where('is_active', true)
            ->selectRaw('category, COUNT(*) as total_packages')
            ->groupBy('category')
            ->orderByDesc('total_packages')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar kategori berhasil diambil',
            'data' => $categories,
        ]);
    }
}

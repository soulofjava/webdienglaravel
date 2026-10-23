<?php

namespace App\Http\Controllers;

use App\Models\PhotoSpot;
use App\Models\SiteSetting;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminPhotoSpotController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings('lotus');
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $userScope = $user ? $user->getSiteScope() : null;

        $baseQuery = PhotoSpot::query();
        if ($userScope && $userScope === 'lotus') {
            $baseQuery->where('site_scope', 'lotus');
        }

        $totalAll = (clone $baseQuery)->count();
        $totalActive = (clone $baseQuery)->where('is_active', true)->count();
        $totalInactive = (clone $baseQuery)->where('is_active', false)->count();

        $query = clone $baseQuery;

        $status = $request->input('status', 'all');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('best_time_tag', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        $perPage = in_array((int) $request->input('per_page'), [10, 50, 100]) ? (int) $request->input('per_page') : 10;
        $spots = $query->paginate($perPage)->withQueryString();

        return view('admin.photo-spots.index', compact(
            'spots',
            'settings',
            'totalAll',
            'totalActive',
            'totalInactive',
            'status',
            'perPage'
        ));
    }

    public function create()
    {
        $settings = SiteSetting::getSettings('lotus');
        $nextSortOrder = (PhotoSpot::max('sort_order') ?? 0) + 1;

        return view('admin.photo-spots.create', compact('settings', 'nextSortOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'best_time_tag' => 'nullable|string|max:50',
            'description' => 'required|string',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string|max:2000',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['site_scope'] = 'lotus';

        // Penanganan file upload foto spot
        if ($request->hasFile('image_file')) {
            try {
                $opt = ImageOptimizerService::optimizeAndStore(
                    $request->file('image_file'),
                    'uploads/photo-spots',
                    'photo_spot_' . Str::slug($validated['name']) . '_' . time(),
                    1200,
                    82
                );
                $validated['image_url'] = $opt['url'];
            } catch (\Exception $e) {
                Log::error('Gagal mengunggah foto spot: ' . $e->getMessage());
                return back()->withInput()->withErrors(['image_file' => 'Gagal memproses gambar: ' . $e->getMessage()]);
            }
        }

        if (empty($validated['image_url'])) {
            return back()->withInput()->withErrors(['image_url' => 'Harap unggah file foto atau masukkan tautan URL gambar.']);
        }

        unset($validated['image_file']);

        PhotoSpot::create($validated);

        return redirect()->route('admin.photo-spots.index')->with('success', "Spot foto '{$validated['name']}' berhasil ditambahkan.");
    }

    public function edit(PhotoSpot $photoSpot)
    {
        $settings = SiteSetting::getSettings('lotus');

        return view('admin.photo-spots.edit', compact('photoSpot', 'settings'));
    }

    public function update(Request $request, PhotoSpot $photoSpot)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'best_time_tag' => 'nullable|string|max:50',
            'description' => 'required|string',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string|max:2000',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_file')) {
            try {
                $opt = ImageOptimizerService::optimizeAndStore(
                    $request->file('image_file'),
                    'uploads/photo-spots',
                    'photo_spot_' . Str::slug($validated['name']) . '_' . time(),
                    1200,
                    82
                );
                $validated['image_url'] = $opt['url'];
            } catch (\Exception $e) {
                Log::error('Gagal mengunggah foto spot: ' . $e->getMessage());
                return back()->withInput()->withErrors(['image_file' => 'Gagal memproses gambar: ' . $e->getMessage()]);
            }
        }

        if (empty($validated['image_url']) && empty($photoSpot->image_url)) {
            return back()->withInput()->withErrors(['image_url' => 'Harap unggah file foto atau masukkan tautan URL gambar.']);
        }

        if (empty($validated['image_url'])) {
            $validated['image_url'] = $photoSpot->image_url;
        }

        unset($validated['image_file']);

        $photoSpot->update($validated);

        return redirect()->route('admin.photo-spots.index')->with('success', "Spot foto '{$photoSpot->name}' berhasil diperbarui.");
    }

    public function destroy(PhotoSpot $photoSpot)
    {
        $name = $photoSpot->name;
        $photoSpot->delete();

        return redirect()->route('admin.photo-spots.index')->with('success', "Spot foto '{$name}' telah dihapus.");
    }

    public function toggleStatus(PhotoSpot $photoSpot)
    {
        $photoSpot->is_active = !$photoSpot->is_active;
        $photoSpot->save();

        $statusText = $photoSpot->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Spot foto '{$photoSpot->name}' berhasil {$statusText}.");
    }
}

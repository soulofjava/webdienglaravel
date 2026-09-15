<?php

namespace App\Http\Controllers;

use App\Models\Comcode;
use App\Models\SiteSetting;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPackageController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();
        $user = Auth::user();

        $query = TourPackage::query()->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        // Scoping paket sesuai hak akses pengelola
        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null) {
                $query->whereIn('category', $allowedCategories);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $packages = $query->paginate(10)->withQueryString();
        
        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null) {
                $categories = collect($allowedCategories);
            } else {
                $categories = Comcode::getCategories()->pluck('code_value');
            }
        } else {
            $categories = Comcode::getCategories()->pluck('code_value');
            if ($categories->isEmpty()) {
                $categories = TourPackage::select('category')->distinct()->pluck('category');
            }
        }

        return view('admin.packages.index', compact('packages', 'settings', 'categories'));
    }

    public function create()
    {
        $settings = SiteSetting::getSettings();
        $user = Auth::user();
        $categories = Comcode::getCategories();
        $badges = Comcode::getBadges();
        $durations = Comcode::getDurations();
        $pickupLocations = Comcode::getPickupLocations();

        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null) {
                $categories = $categories->filter(fn($c) => in_array($c->code_value, $allowedCategories, true));
            }
        }

        return view('admin.packages.create', compact('settings', 'categories', 'badges', 'durations', 'pickupLocations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:tour_packages,slug',
            'category' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'pickup_location' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'price_note' => 'required|string|max:100',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'summary' => 'required|string',
            'itinerary_names' => 'nullable|array',
            'itinerary_destinations' => 'nullable|array',
            'itinerary_descriptions' => 'nullable|array',
            'inclusions_text' => 'nullable|string',
            'exclusions_text' => 'nullable|string',
            'preparations_text' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $user = Auth::user();
        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null && !in_array($validated['category'], $allowedCategories, true)) {
                abort(403, 'Akses ditolak: Akun pengelola Anda tidak berwenang menerbitkan paket dengan kategori ini.');
            }
        }

        $slug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        if (TourPackage::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(4);
        }

        $imageUrl = $validated['image_url'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/packages', 'public');
            $imageUrl = Storage::url($path);
        }

        // Parsing Itinerary Options
        $itineraryOptions = [];
        if (!empty($request->itinerary_names)) {
            foreach ($request->itinerary_names as $index => $name) {
                if (!empty(trim($name))) {
                    $itineraryOptions[] = [
                        'name' => trim($name),
                        'destinations' => trim($request->itinerary_destinations[$index] ?? ''),
                        'description' => trim($request->itinerary_descriptions[$index] ?? ''),
                    ];
                }
            }
        }

        $inclusions = $this->linesToArray($request->inclusions_text);
        $exclusions = $this->linesToArray($request->exclusions_text);
        $preparations = $this->linesToArray($request->preparations_text);

        TourPackage::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'duration' => $validated['duration'],
            'pickup_location' => $validated['pickup_location'],
            'price' => (int) $validated['price'],
            'price_note' => $validated['price_note'],
            'badge' => $validated['badge'] ?: null,
            'image_url' => $imageUrl ?: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
            'summary' => $validated['summary'],
            'itinerary_options' => $itineraryOptions,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'preparations' => $preparations,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        \Illuminate\Support\Facades\Cache::forget('active_tour_packages');

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata baru berhasil ditambahkan!');
    }

    public function edit(TourPackage $package)
    {
        $user = Auth::user();
        if ($user && !$user->canManagePackage($package)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses untuk mengedit paket unit bisnis lain.');
        }

        $settings = SiteSetting::getSettings();
        $categories = Comcode::getCategories();
        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null) {
                $categories = $categories->filter(fn($c) => in_array($c->code_value, $allowedCategories, true));
            }
        }
        $badges = Comcode::getBadges();
        $durations = Comcode::getDurations();
        $pickupLocations = Comcode::getPickupLocations();

        return view('admin.packages.edit', compact('package', 'settings', 'categories', 'badges', 'durations', 'pickupLocations'));
    }

    public function update(Request $request, TourPackage $package)
    {
        $user = Auth::user();
        if ($user && !$user->canManagePackage($package)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses untuk memperbarui paket unit bisnis lain.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:tour_packages,slug,' . $package->id,
            'category' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'pickup_location' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'price_note' => 'required|string|max:100',
            'badge' => 'nullable|string|max:50',
            'image_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'summary' => 'required|string',
            'itinerary_names' => 'nullable|array',
            'itinerary_destinations' => 'nullable|array',
            'itinerary_descriptions' => 'nullable|array',
            'inclusions_text' => 'nullable|string',
            'exclusions_text' => 'nullable|string',
            'preparations_text' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($user && !$user->isSuperAdmin()) {
            $allowedCategories = $user->getAllowedPackageCategories();
            if ($allowedCategories !== null && !in_array($validated['category'], $allowedCategories, true)) {
                abort(403, 'Akses ditolak: Akun pengelola Anda tidak berwenang mengubah kategori paket ke kategori ini.');
            }
        }

        $imageUrl = $validated['image_url'] ?? $package->image_url;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('uploads/packages', 'public');
            $imageUrl = Storage::url($path);
        }

        // Parsing Itinerary Options
        $itineraryOptions = [];
        if (!empty($request->itinerary_names)) {
            foreach ($request->itinerary_names as $index => $name) {
                if (!empty(trim($name))) {
                    $itineraryOptions[] = [
                        'name' => trim($name),
                        'destinations' => trim($request->itinerary_destinations[$index] ?? ''),
                        'description' => trim($request->itinerary_descriptions[$index] ?? ''),
                    ];
                }
            }
        }

        $inclusions = $this->linesToArray($request->inclusions_text);
        $exclusions = $this->linesToArray($request->exclusions_text);
        $preparations = $this->linesToArray($request->preparations_text);

        $package->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category' => $validated['category'],
            'duration' => $validated['duration'],
            'pickup_location' => $validated['pickup_location'],
            'price' => (int) $validated['price'],
            'price_note' => $validated['price_note'],
            'badge' => $validated['badge'] ?: null,
            'image_url' => $imageUrl,
            'summary' => $validated['summary'],
            'itinerary_options' => $itineraryOptions,
            'inclusions' => $inclusions,
            'exclusions' => $exclusions,
            'preparations' => $preparations,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        \Illuminate\Support\Facades\Cache::forget('active_tour_packages');

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil diperbarui!');
    }

    public function destroy(TourPackage $package)
    {
        $user = Auth::user();
        if ($user && !$user->canManagePackage($package)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses untuk menghapus paket unit bisnis lain.');
        }

        $package->delete();
        \Illuminate\Support\Facades\Cache::forget('active_tour_packages');
        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil dihapus.');
    }

    private function linesToArray(?string $text): array
    {
        if (empty($text)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $text);
        $result = [];
        foreach ($lines as $line) {
            $clean = trim($line, " \t\n\r\0\x0B-•*");
            if (!empty($clean)) {
                $result[] = $clean;
            }
        }
        return $result;
    }
}

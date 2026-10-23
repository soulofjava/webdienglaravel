<?php

namespace App\Http\Controllers;

use App\Models\DestinationStory;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDestinationStoryController extends Controller
{
    public function index(Request $request)
    {
        $settings = SiteSetting::getSettings();
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $userScope = $user ? $user->getSiteScope() : null;

        $baseQuery = DestinationStory::query();
        if ($userScope) {
            $baseQuery->where('site_scope', $userScope);
        }

        // Hitung total untuk tabs pill filter
        $totalAll = (clone $baseQuery)->count();
        $totalActive = (clone $baseQuery)->where('is_active', true)->count();
        $totalInactive = (clone $baseQuery)->where('is_active', false)->count();

        $query = clone $baseQuery;

        // Filter status tab
        $status = $request->input('status', 'all');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Pencarian teks
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('chapter_badge', 'like', "%{$search}%")
                  ->orWhere('quote', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Urutan
        $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        // Per page selector (10, 50, 100) sesuai standar UX
        $perPage = in_array((int) $request->input('per_page'), [10, 50, 100]) ? (int) $request->input('per_page') : 10;
        $stories = $query->paginate($perPage)->withQueryString();

        return view('admin.stories.index', compact(
            'stories',
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
        $settings = SiteSetting::getSettings();
        $nextSortOrder = (DestinationStory::max('sort_order') ?? 0) + 1;

        return view('admin.stories.create', compact('settings', 'nextSortOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_scope' => 'nullable|string|max:50',
            'chapter_badge' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'quote' => 'nullable|string|max:1000',
            'description' => 'required|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:500',
            'highlights_text' => 'nullable|string',
            'image_url' => 'required|string|max:2000',
            'accent_color' => 'required|string|in:amber,emerald,indigo,blue,rose,purple',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $userScope = $user ? $user->getSiteScope() : null;
        $validated['site_scope'] = $userScope ?: ($validated['site_scope'] ?? 'tiketdieng');
        $validated['is_active'] = $request->has('is_active');

        // Proses highlights baik dari repeater array maupun newline textarea
        $validated['highlights'] = $this->parseHighlights($request);

        DestinationStory::create($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Babak cerita keajaiban Dieng berhasil ditambahkan.');
    }

    public function edit(DestinationStory $story)
    {
        $settings = SiteSetting::getSettings();

        return view('admin.stories.edit', compact('story', 'settings'));
    }

    public function update(Request $request, DestinationStory $story)
    {
        $validated = $request->validate([
            'site_scope' => 'nullable|string|max:50',
            'chapter_badge' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'quote' => 'nullable|string|max:1000',
            'description' => 'required|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:500',
            'highlights_text' => 'nullable|string',
            'image_url' => 'required|string|max:2000',
            'accent_color' => 'required|string|in:amber,emerald,indigo,blue,rose,purple',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $userScope = $user ? $user->getSiteScope() : null;
        if ($userScope) {
            $validated['site_scope'] = $userScope;
        }
        $validated['is_active'] = $request->has('is_active');
        $validated['highlights'] = $this->parseHighlights($request);

        $story->update($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', "Babak '{$story->title}' berhasil diperbarui.");
    }

    public function destroy(DestinationStory $story)
    {
        $title = $story->title;
        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', "Babak '{$title}' berhasil dihapus.");
    }

    public function toggleStatus(DestinationStory $story)
    {
        $story->is_active = !$story->is_active;
        $story->save();

        $statusText = $story->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Babak '{$story->title}' berhasil {$statusText}.");
    }

    private function parseHighlights(Request $request): array
    {
        if ($request->has('highlights') && is_array($request->highlights)) {
            $items = array_map('trim', $request->highlights);
            return array_values(array_filter($items, fn($item) => $item !== ''));
        }

        if ($request->filled('highlights_text')) {
            $lines = explode("\n", (string) $request->highlights_text);
            $items = array_map('trim', $lines);
            return array_values(array_filter($items, fn($item) => $item !== ''));
        }

        return [];
    }
}

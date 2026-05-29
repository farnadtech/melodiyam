<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function index(): View
    {
        $featured = Playlist::where('is_system', true)
            ->where('visibility', 'public')
            ->withCount('tracks')
            ->with('user')
            ->orderByDesc('is_featured')
            ->latest()
            ->get();

        $userPlaylists = Playlist::where('visibility', 'public')
            ->where('is_system', false)
            ->withCount('tracks')
            ->with('user')
            ->latest()
            ->paginate(24);

        return view('playlist.index', compact('featured', 'userPlaylists'));
    }

    public function show(Playlist $playlist): View
    {
        if ($playlist->visibility === 'private' && $playlist->user_id !== auth()->id()) {
            abort(403);
        }
        
        $sort = request('sort', 'newest');
        $playlist->load(['user']);
        
        $tracks = $playlist->tracks()
            ->with('artist')
            ->sort($sort)
            ->get();

        $isLiked = auth()->check()
            ? auth()->user()->likes()->where('likeable_type', Playlist::class)->where('likeable_id', $playlist->id)->exists()
            : false;

        return view('playlist.show', compact('playlist', 'tracks', 'sort', 'isLiked'));
    }

    public function create(): View
    {
        return view('playlist.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255|unique:playlists,title',
            'description' => 'nullable|string|max:1000',
            'visibility'  => 'required|in:public,private',
            'cover_image' => 'nullable|image|max:2048',
        ], [
            'title.unique' => 'پلی‌لیستی با این نام قبلاً ثبت شده است.',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        $validated['user_id'] = auth()->id();

        $playlist = Playlist::create($validated);

        return redirect()->route('playlist.show', $playlist)->with('success', 'پلی‌لیست ساخته شد.');
    }

    public function edit(Playlist $playlist): View
    {
        abort_unless($playlist->user_id === auth()->id(), 403);
        $playlist->load('tracks');
        return view('playlist.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist): RedirectResponse
    {
        abort_unless($playlist->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255|unique:playlists,title,' . $playlist->id,
            'description' => 'nullable|string|max:1000',
            'visibility'  => 'required|in:public,private',
            'cover_image' => 'nullable|image|max:2048',
        ], [
            'title.unique' => 'پلی‌لیستی با این نام قبلاً ثبت شده است.',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('playlists', 'public');
        }

        $playlist->update($validated);

        return redirect()->route('playlist.show', $playlist)->with('success', 'پلی‌لیست به‌روز شد.');
    }

    public function destroy(Playlist $playlist): RedirectResponse
    {
        abort_unless($playlist->user_id === auth()->id(), 403);

        if ($playlist->cover_image) {
            Storage::disk('public')->delete($playlist->cover_image);
        }
        $playlist->delete();

        return redirect()->route('playlists.index')->with('success', 'پلی‌لیست حذف شد.');
    }
}

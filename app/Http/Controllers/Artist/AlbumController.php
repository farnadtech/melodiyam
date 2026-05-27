<?php

namespace App\Http\Controllers\Artist;

use App\Helpers\Jalali;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AlbumController extends Controller
{
    private function artistOrAbort()
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');
        return $artist;
    }

    private function checkSubscription($artist): void
    {
        if (\App\Models\Setting::get('artist_subscription_required', '0') !== '1') return;
        abort_unless($artist->canUploadAlbum(), 403, 'برای ساخت آلبوم باید اشتراک فعال داشته باشید یا سقف مجاز پلن شما تمام شده است.');
    }

    public function index(): View
    {
        $artist = $this->artistOrAbort();
        $albums = $artist->albums()
            ->withCount('tracks')
            ->latest()
            ->paginate(20);

        return view('artist.albums.index', compact('albums'));
    }

    public function create(): View
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);
        $genres = Genre::active()->ordered()->get();
        return view('artist.albums.create', compact('genres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);

        $request->validate([
            'title'           => 'required|string|max:255',
            'cover_image'     => 'nullable|image|max:10240',
            'type'            => 'required|in:album,single,ep',
            'genre_id'        => 'nullable|exists:genres,id',
            'release_date'    => 'nullable|string',
            'description'     => 'nullable|string',
            'is_explicit'     => 'nullable|boolean',
            'is_for_sale'     => 'nullable|boolean',
            'price'           => 'nullable|integer|min:0',
            'discount_price'  => 'nullable|integer|min:0',
            'preview_seconds' => 'nullable|integer|min:0|max:300',
            'status'          => 'required|in:draft,published',
        ]);

        $releaseDate = $request->release_date
            ? Jalali::toGregorianString($request->release_date)
            : null;

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers/albums', 'public');
        }

        $album = Album::create([
            'artist_id'       => $artist->id,
            'title'           => $request->title,
            'title_en'        => $request->title_en,
            'cover_image'     => $coverPath,
            'type'            => $request->type,
            'genre_id'        => $request->genre_id,
            'release_date'    => $releaseDate,
            'description'     => $request->description,
            'is_explicit'     => $request->boolean('is_explicit'),
            'is_for_sale'     => $request->boolean('is_for_sale'),
            'price'           => $request->is_for_sale ? $request->price : null,
            'discount_price'  => $request->is_for_sale ? $request->discount_price : null,
            'preview_seconds' => $request->preview_seconds,
            'status'          => $request->status,
            'published_at'    => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('artist.albums')->with('success', 'آلبوم «' . $album->title . '» ایجاد شد.');
    }

    public function edit(Album $album): View
    {
        $artist = $this->artistOrAbort();
        abort_if($album->artist_id !== $artist->id, 403);
        $album->load(['tracks' => fn($q) => $q->orderBy('track_number')->orderBy('id')]);
        $genres = Genre::active()->ordered()->get();
        return view('artist.albums.edit', compact('album', 'genres'));
    }

    public function update(Request $request, Album $album): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($album->artist_id !== $artist->id, 403);

        $request->validate([
            'title'           => 'required|string|max:255',
            'cover_image'     => 'nullable|image|max:10240',
            'type'            => 'required|in:album,single,ep',
            'genre_id'        => 'nullable|exists:genres,id',
            'release_date'    => 'nullable|string',
            'description'     => 'nullable|string',
            'is_explicit'     => 'nullable|boolean',
            'is_for_sale'     => 'nullable|boolean',
            'price'           => 'nullable|integer|min:0',
            'discount_price'  => 'nullable|integer|min:0',
            'preview_seconds' => 'nullable|integer|min:0|max:300',
            'status'          => 'required|in:draft,published',
        ]);

        $releaseDate = $request->release_date
            ? Jalali::toGregorianString($request->release_date)
            : null;

        $data = [
            'title'           => $request->title,
            'title_en'        => $request->title_en,
            'type'            => $request->type,
            'genre_id'        => $request->genre_id,
            'release_date'    => $releaseDate,
            'description'     => $request->description,
            'is_explicit'     => $request->boolean('is_explicit'),
            'is_for_sale'     => $request->boolean('is_for_sale'),
            'price'           => $request->is_for_sale ? $request->price : null,
            'discount_price'  => $request->is_for_sale ? $request->discount_price : null,
            'preview_seconds' => $request->preview_seconds,
            'status'          => $request->status,
        ];

        if ($request->status === 'published' && $album->status !== 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('covers/albums', 'public');
        }

        $album->update($data);

        return redirect()->route('artist.albums')->with('success', 'آلبوم «' . $album->title . '» ویرایش شد.');
    }

    public function destroy(Album $album): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($album->artist_id !== $artist->id, 403);

        if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
        $album->delete();

        return redirect()->route('artist.albums')->with('success', 'آلبوم حذف شد.');
    }

    public function reorderTracks(Request $request, Album $album): \Illuminate\Http\JsonResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($album->artist_id !== $artist->id, 403);

        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $trackId) {
            $album->tracks()->where('id', $trackId)->update(['track_number' => $position + 1]);
        }

        return response()->json(['ok' => true]);
    }
}

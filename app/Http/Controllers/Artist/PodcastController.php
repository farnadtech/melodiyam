<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\PodcastEpisode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PodcastController extends Controller
{
    private function artistOrAbort()
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');
        return $artist;
    }

    private function checkSubscription($artist): void
    {
        $sub = $artist->activeSubscription;
        if (!$sub || !$sub->isActive()) {
            abort(403, 'اشتراک فعال ندارید. لطفاً ابتدا اشتراک هنرمند خریداری کنید.');
        }
    }

    public function index(): View
    {
        $artist = $this->artistOrAbort();
        $podcasts = $artist->podcasts()->withCount('episodes')->latest()->get();
        return view('artist.podcasts.index', compact('podcasts', 'artist'));
    }

    public function create(): View
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);
        $genres = \App\Models\Genre::active()->ordered()->get();
        return view('artist.podcasts.create', compact('artist', 'genres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:255',
            'language'    => 'nullable|string|max:10',
            'cover_image' => 'nullable|image|max:5120',
            'is_explicit' => 'nullable|boolean',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('podcasts/covers', 'public');
        }

        $autoApproveValue = \App\Models\Setting::get('auto_approve_content', true);
        $autoApprove = $autoApproveValue === true || $autoApproveValue === 1 || $autoApproveValue === '1' || $autoApproveValue === 'true';
        $status = $autoApprove ? 'published' : 'pending';

        $podcast = Podcast::create([
            'user_id'     => auth()->id(),
            'artist_id'   => $artist->id,
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category'    => $validated['category'] ?? null,
            'language'    => $validated['language'] ?? 'fa',
            'cover_image' => $coverPath,
            'is_explicit' => $request->boolean('is_explicit'),
            'status'      => $status,
        ]);

        $msg = $autoApprove 
            ? 'پادکست "' . $podcast->title . '" ایجاد شد. حالا قسمت‌های آن را اضافه کنید.'
            : 'پادکست "' . $podcast->title . '" ایجاد شد و پس از تایید مدیر در سایت نمایش داده می‌شود.';

        return redirect()->route('artist.podcasts.episodes.index', $podcast)
            ->with('success', $msg);
    }

    public function edit(Podcast $podcast): View
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id, 403);
        $genres = \App\Models\Genre::active()->ordered()->get();
        return view('artist.podcasts.edit', compact('podcast', 'genres'));
    }

    public function update(Request $request, Podcast $podcast): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id, 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:5120',
            'is_explicit' => 'nullable|boolean',
        ]);

        $data = [
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category'    => $validated['category'] ?? null,
            'is_explicit' => $request->boolean('is_explicit'),
        ];

        if ($request->hasFile('cover_image')) {
            if ($podcast->cover_image) Storage::disk('public')->delete($podcast->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('podcasts/covers', 'public');
        }

        $podcast->update($data);

        return redirect()->route('artist.podcasts.index')
            ->with('success', 'پادکست به‌روزرسانی شد.');
    }

    public function destroy(Podcast $podcast): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id, 403);

        // Delete cover
        if ($podcast->cover_image) Storage::disk('public')->delete($podcast->cover_image);

        // Delete all episode files
        foreach ($podcast->episodes as $episode) {
            if ($episode->file_path) Storage::disk('public')->delete($episode->file_path);
            if ($episode->cover_image) Storage::disk('public')->delete($episode->cover_image);
        }

        $podcast->delete();

        return redirect()->route('artist.podcasts.index')
            ->with('success', 'پادکست حذف شد.');
    }

    // Episode Management
    public function episodesIndex(Podcast $podcast): View
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id, 403);
        $episodes = $podcast->episodes()->orderBy('season_number', 'desc')->orderBy('episode_number', 'desc')->get();
        return view('artist.podcasts.episodes.index', compact('podcast', 'episodes'));
    }

    public function episodesCreate(Podcast $podcast): View
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);
        abort_if($podcast->artist_id !== $artist->id, 403);
        $nextEpisode = $podcast->episodes()->max('episode_number') + 1;
        return view('artist.podcasts.episodes.create', compact('podcast', 'nextEpisode'));
    }

    public function episodesStore(Request $request, Podcast $podcast): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);
        abort_if($podcast->artist_id !== $artist->id, 403);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'file'            => 'required|file|mimes:mp3,wav,ogg,m4a|max:102400',
            'cover_image'     => 'nullable|image|max:5120',
            'season_number'   => 'nullable|integer|min:1',
            'episode_number'  => 'nullable|integer|min:1',
            'is_explicit'     => 'nullable|boolean',
            'is_premium_only' => 'nullable|boolean',
        ]);

        $fileSizeMb = (int) ceil($request->file('file')->getSize() / (1024 * 1024));
        $sub = $artist->activeSubscription;
        if ($sub && !$sub->plan->isUnlimitedStorage()) {
            $newTotal = $sub->storage_used_mb + $fileSizeMb;
            if ($newTotal > $sub->plan->max_storage_mb) {
                return back()->withInput()->with('error', 'فضای ذخیره‌سازی پلن شما کافی نیست. فضای باقی‌مانده: ' . ($sub->plan->max_storage_mb - $sub->storage_used_mb) . ' مگابایت');
            }
        }

        $path = $request->file('file')->store('podcasts/episodes/audio', 'public');

        // Get duration
        $fullPath = Storage::disk('public')->path($path);
        $duration = \App\Helpers\AudioHelper::getDuration($fullPath);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('podcasts/episodes/covers', 'public');
        }

        $autoApproveValue = \App\Models\Setting::get('auto_approve_content', true);
        $autoApprove = $autoApproveValue === true || $autoApproveValue === 1 || $autoApproveValue === '1' || $autoApproveValue === 'true';
        $status = $autoApprove ? 'published' : 'pending';

        $episode = PodcastEpisode::create([
            'podcast_id'       => $podcast->id,
            'title'            => $validated['title'],
            'description'      => $validated['description'] ?? null,
            'file_path'        => $path,
            'cover_image'      => $coverPath,
            'duration'         => $duration,
            'season_number'    => $validated['season_number'] ?? 1,
            'episode_number'   => $validated['episode_number'] ?? ($podcast->episodes()->max('episode_number') + 1),
            'is_explicit'      => $request->boolean('is_explicit'),
            'status'           => $status,
            'published_at'     => $status === 'published' ? now() : null,
        ]);

        // Update storage usage
        $sub->increment('storage_used_mb', $fileSizeMb);

        return redirect()->route('artist.podcasts.episodes.index', $podcast)
            ->with('success', 'قسمت "' . $episode->title . '" اضافه شد.');
    }

    public function episodesEdit(Podcast $podcast, PodcastEpisode $episode): View
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id || $episode->podcast_id !== $podcast->id, 403);
        return view('artist.podcasts.episodes.edit', compact('podcast', 'episode'));
    }

    public function episodesUpdate(Request $request, Podcast $podcast, PodcastEpisode $episode): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id || $episode->podcast_id !== $podcast->id, 403);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'file'            => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:102400',
            'cover_image'     => 'nullable|image|max:5120',
            'season_number'   => 'nullable|integer|min:1',
            'episode_number'  => 'nullable|integer|min:1',
            'is_explicit'     => 'nullable|boolean',
        ]);

        $data = [
            'title'           => $validated['title'],
            'description'     => $validated['description'] ?? null,
            'season_number'   => $validated['season_number'] ?? $episode->season_number,
            'episode_number'  => $validated['episode_number'] ?? $episode->episode_number,
            'is_explicit'     => $request->boolean('is_explicit'),
        ];

        if ($request->hasFile('file')) {
            if ($episode->file_path) Storage::disk('public')->delete($episode->file_path);
            $data['file_path'] = $request->file('file')->store('podcasts/episodes/audio', 'public');

            // Update duration
            $fullPath = Storage::disk('public')->path($data['file_path']);
            $data['duration'] = \App\Helpers\AudioHelper::getDuration($fullPath);
        }

        if ($request->hasFile('cover_image')) {
            if ($episode->cover_image) Storage::disk('public')->delete($episode->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('podcasts/episodes/covers', 'public');
        }

        $episode->update($data);

        return redirect()->route('artist.podcasts.episodes.index', $podcast)
            ->with('success', 'قسمت به‌روزرسانی شد.');
    }

    public function episodesDestroy(Podcast $podcast, PodcastEpisode $episode): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($podcast->artist_id !== $artist->id || $episode->podcast_id !== $podcast->id, 403);

        // Delete files
        if ($episode->file_path) Storage::disk('public')->delete($episode->file_path);
        if ($episode->cover_image) Storage::disk('public')->delete($episode->cover_image);

        // Update storage usage
        $sub = $artist->activeSubscription;
        $fileSize = $episode->duration ? (int) ceil($episode->duration / 60) : 0; // Rough estimate
        $sub->decrement('storage_used_mb', $fileSize);

        $episode->delete();

        return redirect()->route('artist.podcasts.episodes.index', $podcast)
            ->with('success', 'قسمت حذف شد.');
    }
}

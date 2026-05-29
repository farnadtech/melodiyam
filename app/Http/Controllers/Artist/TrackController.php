<?php

namespace App\Http\Controllers\Artist;

use App\Helpers\Jalali;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TrackController extends Controller
{
    private function artistOrAbort()
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');
        return $artist;
    }

    private function checkSubscription($artist): void
    {
        abort_unless($artist->canUploadTrack(), 403, 'برای آپلود آهنگ باید اشتراک فعال داشته باشید یا سقف مجاز پلن شما تمام شده است.');
    }

    private function checkStorageLimit($artist, int $fileSizeMb): void
    {
        $required = \App\Models\Setting::get('artist_subscription_required', '0') === '1';
        if (!$required) return;
        $sub = $artist->activeSubscription;
        if (!$sub) return;
        if ($sub->plan->isUnlimitedStorage()) return;
        
        if (($sub->storage_used_mb + $fileSizeMb) > $sub->plan->max_storage_mb) {
            $remaining = max(0, $sub->plan->max_storage_mb - $sub->storage_used_mb);
            abort(403, "فضای ذخیره‌سازی پلن شما کافی نیست. فضای باقی‌مانده: {$remaining} مگابایت");
        }
    }

    private function incrementSubscriptionUsage($artist, int $fileSizeMb): void
    {
        $required = \App\Models\Setting::get('artist_subscription_required', '0') === '1';
        if (!$required) return;
        $sub = $artist->activeSubscription;
        if (!$sub) return;
        $sub->increment('tracks_used');
        $sub->increment('storage_used_mb', $fileSizeMb);
    }

    public function index(): View
    {
        $artist = $this->artistOrAbort();
        $tracks = $artist->tracks()
            ->with('album')
            ->latest()
            ->paginate(20);

        return view('artist.tracks.index', compact('tracks'));
    }

    public function create(): View
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);
        $albums = $artist->albums()->orderBy('title')->get();
        $genres = Genre::active()->ordered()->get();
        return view('artist.tracks.create', compact('albums', 'genres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        $this->checkSubscription($artist);

        $request->validate([
            'title'           => 'required|string|max:255',
            'file_320'        => 'required|file|mimes:mp3,mp4,ogg,flac,wav,m4a|max:102400',
            'file_128'        => 'nullable|file|mimes:mp3,mp4,ogg,flac,wav,m4a|max:51200',
            'cover_image'     => 'nullable|image|max:5120',
            'album_id'        => 'nullable|exists:albums,id',
            'genre_id'        => 'nullable|exists:genres,id',
            'release_date'    => 'nullable|string',
            'lyrics'          => 'nullable|string',
            'is_explicit'     => 'nullable|boolean',
            'is_for_sale'     => 'nullable|boolean',
            'price'           => 'nullable|integer|min:0',
            'discount_price'  => 'nullable|integer|min:0',
            'preview_seconds' => 'nullable|integer|min:0|max:300',
        ], [
            'file_320.required' => 'فایل صوتی کیفیت بالا الزامی است.',
            'file_320.file' => 'فایل آپلود شده معتبر نیست.',
            'file_320.mimes' => 'فرمت فایل باید یکی از موارد زیر باشد: MP3، MP4، OGG، FLAC، WAV یا M4A.',
            'file_320.max' => 'حجم فایل صوتی نباید بیشتر از ۱۰۰ مگابایت باشد.',
            'file_128.file' => 'فایل آپلود شده معتبر نیست.',
            'file_128.mimes' => 'فرمت فایل باید یکی از موارد زیر باشد: MP3، MP4، OGG، FLAC، WAV یا M4A.',
            'file_128.max' => 'حجم فایل صوتی نباید بیشتر از ۵۰ مگابایت باشد.',
            'cover_image.image' => 'فایل کاور باید تصویر باشد.',
            'cover_image.max' => 'حجم تصویر کاور نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        $releaseDate = $request->release_date
            ? Jalali::toGregorianString($request->release_date)
            : null;

        $file320SizeMb = (int) ceil($request->file('file_320')->getSize() / (1024 * 1024));
        $this->checkStorageLimit($artist, $file320SizeMb);

        $path320 = $request->file('file_320')->store('tracks/320', 'public');
        $path128 = $request->hasFile('file_128') ? $request->file('file_128')->store('tracks/128', 'public') : null;

        // Get duration from file
        $fullPath = Storage::disk('public')->path($path320);
        $duration = \App\Helpers\AudioHelper::getDuration($fullPath);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers/tracks', 'public');
        }

        // Verify album belongs to this artist
        $albumId = null;
        if ($request->album_id) {
            $album = Album::where('id', $request->album_id)->where('artist_id', $artist->id)->first();
            $albumId = $album?->id;
        }

        $autoApproveValue = \App\Models\Setting::get('auto_approve_content', true);
        $autoApprove = $autoApproveValue === true || $autoApproveValue === 1 || $autoApproveValue === '1' || $autoApproveValue === 'true';
        $status = $autoApprove ? 'published' : 'pending';

        $track = Track::create([
            'artist_id'       => $artist->id,
            'album_id'        => $albumId,
            'genre_id'        => $request->genre_id,
            'title'           => $request->title,
            'title_en'        => $request->title_en,
            'release_date'    => $releaseDate,
            'file_path_320'   => $path320,
            'file_path_128'   => $path128,
            'file_path'       => $path320,
            'cover_image'     => $coverPath,
            'duration'        => $duration,
            'lyrics'          => $request->lyrics,
            'is_explicit'     => $request->boolean('is_explicit'),
            'is_downloadable' => \App\Models\Setting::get('allow_download_free', true) || \App\Models\Setting::get('allow_download_premium', true),
            'is_for_sale'     => $request->boolean('is_for_sale'),
            'price'           => $request->is_for_sale ? $request->price : null,
            'discount_price'  => $request->is_for_sale ? $request->discount_price : null,
            'preview_seconds' => $request->preview_seconds,
            'status'          => $status,
            'published_at'    => $status === 'published' ? now() : null,
        ]);

        $this->incrementSubscriptionUsage($artist, $file320SizeMb);

        $msg = $status === 'pending' 
            ? 'آهنگ «' . $track->title . '» با موفقیت آپلود شد و پس از تایید مدیر منتشر می‌شود.'
            : 'آهنگ «' . $track->title . '» با موفقیت آپلود و منتشر شد.';

        return redirect()->route('artist.tracks')->with('success', $msg);
    }

    public function edit(Track $track): View
    {
        $artist = $this->artistOrAbort();
        abort_if($track->artist_id !== $artist->id, 403);
        $albums = $artist->albums()->orderBy('title')->get();
        $genres = Genre::active()->ordered()->get();
        return view('artist.tracks.edit', compact('track', 'albums', 'genres'));
    }

    public function update(Request $request, Track $track): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($track->artist_id !== $artist->id, 403);

        $request->validate([
            'title'           => 'required|string|max:255',
            'file_320'        => 'nullable|file|mimes:mp3,mp4,ogg,flac,wav,m4a|max:102400',
            'file_128'        => 'nullable|file|mimes:mp3,mp4,ogg,flac,wav,m4a|max:51200',
            'cover_image'     => 'nullable|image|max:5120',
            'album_id'        => 'nullable|exists:albums,id',
            'genre_id'        => 'nullable|exists:genres,id',
            'release_date'    => 'nullable|string',
            'lyrics'          => 'nullable|string',
            'is_explicit'     => 'nullable|boolean',
            'is_for_sale'     => 'nullable|boolean',
            'price'           => 'nullable|integer|min:0',
            'discount_price'  => 'nullable|integer|min:0',
            'preview_seconds' => 'nullable|integer|min:0|max:300',
        ], [
            'file_320.file' => 'فایل آپلود شده معتبر نیست.',
            'file_320.mimes' => 'فرمت فایل باید یکی از موارد زیر باشد: MP3، MP4، OGG، FLAC، WAV یا M4A.',
            'file_320.max' => 'حجم فایل صوتی نباید بیشتر از ۱۰۰ مگابایت باشد.',
            'file_128.file' => 'فایل آپلود شده معتبر نیست.',
            'file_128.mimes' => 'فرمت فایل باید یکی از موارد زیر باشد: MP3، MP4، OGG، FLAC، WAV یا M4A.',
            'file_128.max' => 'حجم فایل صوتی نباید بیشتر از ۵۰ مگابایت باشد.',
            'cover_image.image' => 'فایل کاور باید تصویر باشد.',
            'cover_image.max' => 'حجم تصویر کاور نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        $releaseDate = $request->release_date
            ? Jalali::toGregorianString($request->release_date)
            : null;

        $autoApproveValue = \App\Models\Setting::get('auto_approve_content', true);
        $autoApprove = $autoApproveValue === true || $autoApproveValue === 1 || $autoApproveValue === '1' || $autoApproveValue === 'true';
        // Only change status to pending if track is not already published
        if (!$autoApprove && $track->status !== 'published') {
            $status = 'pending';
        } else {
            $status = $track->status;
        }

        $data = [
            'title'           => $request->title,
            'title_en'        => $request->title_en,
            'genre_id'        => $request->genre_id,
            'release_date'    => $releaseDate,
            'lyrics'          => $request->lyrics,
            'is_explicit'     => $request->boolean('is_explicit'),
            'is_for_sale'     => $request->boolean('is_for_sale'),
            'price'           => $request->is_for_sale ? $request->price : null,
            'discount_price'  => $request->is_for_sale ? $request->discount_price : null,
            'preview_seconds' => $request->preview_seconds,
            'status'          => $status,
        ];

        if ($status === 'published' && $track->status !== 'published') {
            $data['published_at'] = now();
        }

        $albumId = null;
        if ($request->album_id) {
            $album = Album::where('id', $request->album_id)->where('artist_id', $artist->id)->first();
            $albumId = $album?->id;
        }
        $data['album_id'] = $albumId;

        if ($request->hasFile('cover_image')) {
            if ($track->cover_image) Storage::disk('public')->delete($track->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('covers/tracks', 'public');
        }

        if ($request->hasFile('file_320')) {
            if ($track->file_path_320) Storage::disk('public')->delete($track->file_path_320);
            $data['file_path_320'] = $request->file('file_320')->store('tracks/320', 'public');
            $data['file_path'] = $data['file_path_320'];
            try {
                $fullPath = Storage::disk('public')->path($data['file_path_320']);
                if (class_exists(\getID3::class)) {
                    $id3 = new \getID3();
                    $info = $id3->analyze($fullPath);
                    $data['duration'] = (int) round($info['playtime_seconds'] ?? 0);
                }
            } catch (\Throwable $e) {}
        }

        if ($request->hasFile('file_128')) {
            if ($track->file_path_128) Storage::disk('public')->delete($track->file_path_128);
            $data['file_path_128'] = $request->file('file_128')->store('tracks/128', 'public');
        }

        $track->update($data);

        return redirect()->route('artist.tracks')->with('success', 'آهنگ «' . $track->title . '» ویرایش شد.');
    }

    public function destroy(Track $track): RedirectResponse
    {
        $artist = $this->artistOrAbort();
        abort_if($track->artist_id !== $artist->id, 403);

        if ($track->file_path_320) Storage::disk('public')->delete($track->file_path_320);
        if ($track->file_path_128) Storage::disk('public')->delete($track->file_path_128);
        if ($track->cover_image)   Storage::disk('public')->delete($track->cover_image);

        $track->delete();

        return redirect()->route('artist.tracks')->with('success', 'آهنگ حذف شد.');
    }
}

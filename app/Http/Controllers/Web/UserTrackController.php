<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserTrackController extends Controller
{
    public function create()
    {
        if (!\App\Models\Setting::get('user_upload_enabled')) {
            abort(404);
        }

        $user = auth()->user();
        
        // If user is an artist, tell them to use their dashboard
        if ($user->artist) {
            return view('track.create', [
                'isArtist' => true,
                'canUpload' => false,
                'genres' => collect()
            ]);
        }

        $canUpload = $user->canUploadMusic();
        $genres = Genre::all();
        
        return view('track.create', compact('genres', 'canUpload'));
    }

    public function store(Request $request)
    {
        if (!\App\Models\Setting::get('user_upload_enabled') || !auth()->user()->canUploadMusic()) {
            abort(403);
        }

        $request->validate([
            'artist_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'lyrics' => 'nullable|string',
            'description' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
            'audio' => 'required|file|mimes:mp3,wav|max:102400',
            'cover' => 'required|image|max:5120',
        ]);

        $autoApprove = \App\Models\Setting::get('auto_approve_user_content', true);
        $status = $autoApprove ? 'published' : 'pending';

        $track = new Track();
        $track->user_id = auth()->id();
        $track->artist_name = $request->artist_name;
        $track->title = $request->title;
        $track->title_en = $request->title_en;
        $track->slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        $track->description = $request->description;
        $track->lyrics = $request->lyrics;
        $track->genre_id = $request->genre_id;
        $track->status = $status;
        $track->published_at = $status === 'published' ? now() : null;
        
        if ($request->hasFile('audio')) {
            $track->file_path = $request->file('audio')->store('tracks/audio', 'public');
            $track->file_path_320 = $track->file_path; // Fill both for compatibility
            
            // Get duration
            $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($track->file_path);
            $track->duration = \App\Helpers\AudioHelper::getDuration($fullPath);
        }
        
        if ($request->hasFile('cover')) {
            $track->cover_image = $request->file('cover')->store('tracks/covers', 'public');
        }

        $track->save();

        if ($status === 'pending') {
            return redirect()->route('home')->with('success', 'آهنگ شما با موفقیت آپلود شد و پس از تایید مدیر منتشر خواهد شد.');
        }

        return redirect()->route('track.show', $track->slug)->with('success', 'آهنگ ' . $track->title . ' با موفقیت منتشر شد.');
    }
}

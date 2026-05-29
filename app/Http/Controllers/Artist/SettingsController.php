<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $artist = auth()->user()->artist;
        return view('artist.settings', compact('artist'));
    }

    public function update(Request $request): RedirectResponse
    {
        $artist = auth()->user()->artist;

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'website' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($artist->cover_image && Storage::disk('public')->exists($artist->cover_image)) {
                Storage::disk('public')->delete($artist->cover_image);
            }

            $path = $request->file('cover_image')->store('artists', 'public');
            $validated['cover_image'] = $path;
        }

        $artist->update($validated);

        return back()->with('success', 'تنظیمات پروفایل هنرمند با موفقیت به‌روزرسانی شد.');
    }
}

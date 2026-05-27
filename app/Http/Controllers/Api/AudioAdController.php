<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AudioAdController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        // کاربران پریمیوم تبلیغ نمی‌بینند
        if ($user && $user->isPremium()) {
            return response()->json(['ad' => null]);
        }

        $ad = Advertisement::active()
            ->where('type', 'audio')
            ->where(function ($q) {
                $q->whereNull('max_impressions')
                  ->orWhereColumn('impressions', '<', 'max_impressions');
            })
            ->orderByDesc('priority')
            ->first();

        if (!$ad) {
            return response()->json(['ad' => null]);
        }

        $url = $ad->media_path
            ? asset('storage/' . $ad->media_path)
            : $ad->media_url;

        return response()->json([
            'ad' => [
                'id'             => $ad->id,
                'title'          => $ad->title,
                'url'            => $url,
                'duration'       => $ad->duration ?? 15,
                'tracks_between' => $ad->tracks_between ?? 3,
                'click_url'      => $ad->click_url,
            ],
        ]);
    }

    public function impression(Request $request): JsonResponse
    {
        $ad = Advertisement::find($request->id);
        if ($ad) {
            $ad->increment('impressions');
        }
        return response()->json(['ok' => true]);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdImpression;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function getAudioAd(Request $request): JsonResponse
    {
        $user = auth()->user();

        // اگر کاربر پریمیوم داره، تبلیغ نشون نده
        if ($user && $user->isPremium()) {
            return response()->json(['ad' => null]);
        }

        // پلن فعال کاربر
        $planSlug = $user?->activeSubscription?->plan?->slug ?? 'free';

        $ad = Advertisement::active()
            ->where('type', 'audio')
            ->where(function ($q) use ($planSlug) {
                $q->whereNull('target_plans')
                  ->orWhereJsonContains('target_plans', $planSlug)
                  ->orWhereJsonContains('target_plans', 'all');
            })
            ->where(function ($q) {
                $q->whereNull('max_impressions')
                  ->orWhereColumn('impressions', '<', 'max_impressions');
            })
            ->orderByDesc('priority')
            ->inRandomOrder()
            ->first();

        if (!$ad) {
            return response()->json(['ad' => null]);
        }

        // ثبت impression
        AdImpression::create([
            'advertisement_id' => $ad->id,
            'user_id'          => $user?->id,
            'event'            => 'impression',
            'ip_address'       => $request->ip(),
        ]);
        $ad->increment('impressions');

        $mediaUrl = $ad->media_path
            ? asset('storage/' . $ad->media_path)
            : $ad->media_url;

        return response()->json([
            'ad' => [
                'id'               => $ad->id,
                'title'            => $ad->title,
                'url'              => $mediaUrl,
                'duration'         => $ad->duration ?? 15,
                'tracks_between'   => $ad->tracks_between ?? 3,
            ]
        ]);
    }

    public function trackClick(Request $request): JsonResponse
    {
        $adId = $request->input('ad_id');
        $ad = Advertisement::find($adId);
        if ($ad) {
            AdImpression::create([
                'advertisement_id' => $ad->id,
                'user_id'          => auth()->id(),
                'event'            => 'click',
                'ip_address'       => $request->ip(),
            ]);
            $ad->increment('clicks');
        }
        return response()->json(['ok' => true]);
    }
}

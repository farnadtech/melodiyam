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

        $ads = Advertisement::active()
            ->where('type', 'audio')
            ->where(function ($q) use ($planSlug) {
                $q->whereNull('target_plans')
                  ->orWhere('target_plans', '[]')
                  ->orWhere('target_plans', '')
                  ->orWhereJsonContains('target_plans', $planSlug)
                  ->orWhereJsonContains('target_plans', 'all');
            })
            ->whereRaw('(max_impressions IS NULL OR impressions < max_impressions)')
            ->get();

        if ($ads->isEmpty()) {
            return response()->json(['ad' => null]);
        }

        // Weighted random based on priority (higher priority = more likely)
        $totalWeight = $ads->sum('priority');
        $random = mt_rand(1, $totalWeight);
        $currentWeight = 0;
        $ad = null;
        foreach ($ads as $candidate) {
            $currentWeight += $candidate->priority;
            if ($random <= $currentWeight) {
                $ad = $candidate;
                break;
            }
        }

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
                'button_text'      => $ad->button_text,
                'button_url'       => $ad->button_url,
            ]
        ]);
    }

    public function getBannerAd(Request $request): JsonResponse
    {
        $user = auth()->user();

        // کاربران پریمیوم تبلیغ بنری نمی‌بینند (اختیاری - بسته به سیاست سایت)
        if ($user && $user->isPremium()) {
            return response()->json(['ad' => null]);
        }

        $planSlug = $user?->activeSubscription?->plan?->slug ?? 'free';

        $ads = Advertisement::active()
            ->where('type', 'banner')
            ->where(function ($q) use ($planSlug) {
                $q->whereNull('target_plans')
                  ->orWhere('target_plans', '[]')
                  ->orWhere('target_plans', '')
                  ->orWhereJsonContains('target_plans', $planSlug)
                  ->orWhereJsonContains('target_plans', 'all');
            })
            ->whereRaw('(max_impressions IS NULL OR impressions < max_impressions)')
            ->get();

        if ($ads->isEmpty()) {
            return response()->json(['ad' => null]);
        }

        // Weighted random based on priority
        $totalWeight = $ads->sum('priority') ?: 1;
        $random = mt_rand(1, $totalWeight);
        $currentWeight = 0;
        $ad = null;
        foreach ($ads as $candidate) {
            $currentWeight += $candidate->priority;
            if ($random <= $currentWeight) {
                $ad = $candidate;
                break;
            }
        }
        $ad = $ad ?: $ads->first();

        // ثبت impression
        AdImpression::create([
            'advertisement_id' => $ad->id,
            'user_id'          => $user?->id,
            'event'            => 'impression',
            'ip_address'       => $request->ip(),
        ]);
        $ad->increment('impressions');

        $imageUrl = $ad->media_path
            ? asset('storage/' . $ad->media_path)
            : $ad->media_url;

        return response()->json([
            'ad' => [
                'id'          => $ad->id,
                'title'       => $ad->title,
                'description' => $ad->description,
                'image_url'   => $imageUrl,
                'button_text' => $ad->button_text,
                'button_url'  => $ad->button_url,
                'click_url'   => $ad->click_url,
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

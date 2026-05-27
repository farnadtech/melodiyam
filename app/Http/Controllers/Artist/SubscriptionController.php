<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\ArtistPlan;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');

        $plans = ArtistPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        $activeSub = $artist->load('activeSubscription')->activeSubscription;

        return view('artist.plans', compact('plans', 'activeSub', 'artist'));
    }
}

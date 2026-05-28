<?php

namespace App\Http\Controllers\Artist;

use App\Helpers\Jalali;
use App\Http\Controllers\Controller;
use App\Models\ArtistEarning;
use App\Models\EarningsSetting;
use App\Models\Sale;
use App\Models\Track;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return view('artist.analytics', ['artist' => null]);
        }

        $trackIds = $artist->tracks()->pluck('id');

        // Top tracks by play count
        $topTracks = $artist->tracks()
            ->orderByDesc('play_count')
            ->take(10)
            ->get();

        // Earnings from sales
        $totalEarnings = Sale::where('seller_id', auth()->id())
            ->where('status', 'completed')
            ->sum('net_amount');

        $monthEarnings = Sale::where('seller_id', auth()->id())
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('net_amount');

        // Recent sales
        $recentSales = Sale::where('seller_id', auth()->id())
            ->where('status', 'completed')
            ->with('saleable', 'buyer')
            ->latest()
            ->take(8)
            ->get();

        // Wallet balance
        $walletBalance = auth()->user()->wallet?->balance ?? 0;

        // Sales chart: daily earnings for last 30 days
        $dailySales = Sale::where('seller_id', auth()->id())
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(net_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $streamChart = [];
        for ($i = 29; $i >= 0; $i--) {
            $day  = now()->subDays($i);
            $date = $day->format('Y-m-d');
            $jalaliLabel = Jalali::format($day, 'm/d');
            $streamChart[] = [
                'date'  => $jalaliLabel,
                'total' => $dailySales[$date] ?? 0,
            ];
        }

        // Stream-based earnings (ArtistEarning model)
        $earningsSettings      = EarningsSetting::getSettings();
        $totalStreamEarnings   = $artist->getTotalEarningsToman();
        $monthStreamEarnings   = $artist->earnings()
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('earning_amount_toman');
        $totalPlays            = $artist->tracks()->sum('play_count');
        $recentStreamEarnings  = $artist->earnings()->with('playable')->latest()->take(10)->get();

        // Next earning milestone for each track
        $nextMilestone = null;
        if ($earningsSettings->is_enabled && $earningsSettings->plays_threshold > 0) {
            $topTrack = $artist->tracks()->orderByDesc('play_count')->first();
            if ($topTrack) {
                $plays = $topTrack->play_count;
                $threshold = $earningsSettings->plays_threshold;
                $remaining = $threshold - ($plays % $threshold);
                if ($remaining === $threshold) $remaining = 0;
                $nextMilestone = ['track' => $topTrack->title, 'remaining' => $remaining];
            }
        }

        return view('artist.analytics', compact(
            'artist', 'topTracks', 'totalEarnings', 'monthEarnings',
            'recentSales', 'walletBalance', 'streamChart',
            'earningsSettings', 'totalStreamEarnings', 'monthStreamEarnings',
            'totalPlays', 'recentStreamEarnings', 'nextMilestone'
        ));
    }
}

<?php

namespace App\Http\Controllers\Artist;

use App\Helpers\Jalali;
use App\Http\Controllers\Controller;
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

        return view('artist.analytics', compact(
            'artist', 'topTracks', 'totalEarnings', 'monthEarnings',
            'recentSales', 'walletBalance', 'streamChart'
        ));
    }
}

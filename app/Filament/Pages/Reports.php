<?php

namespace App\Filament\Pages;

use App\Models\Sale;
use App\Models\User;
use App\Models\WalletTransaction;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|\UnitEnum|null $navigationGroup = 'سیستم';
    protected static ?string $title = 'گزارش‌ها و آمار';
    protected static ?string $navigationLabel = 'گزارش‌ها';
    protected static ?string $slug = 'analytics-reports';
    protected static ?int $navigationSort = 1;

    public string $period = '30';

    public function getView(): string
    {
        return 'filament.pages.reports';
    }

    public function getStats(): array
    {
        try {
            $days = (int) $this->period;
            $from = now()->subDays($days);

            $totalDeposits = WalletTransaction::where('type', 'deposit')
                ->where('status', 'approved')
                ->where('created_at', '>=', $from)
                ->sum('amount');

            $totalWithdrawals = WalletTransaction::where('type', 'withdrawal')
                ->where('status', 'approved')
                ->where('created_at', '>=', $from)
                ->sum('amount');

            $totalCommission = Sale::where('status', 'completed')
                ->where('created_at', '>=', $from)
                ->sum('commission_amount');

            $artistEarnings = Sale::where('status', 'completed')
                ->where('created_at', '>=', $from)
                ->sum('net_amount');

            $salesCount = Sale::where('status', 'completed')
                ->where('created_at', '>=', $from)
                ->count();

            $newUsers = User::where('created_at', '>=', $from)->count();

            $pendingTransactions = WalletTransaction::where('status', 'pending')->count();

            $streamingEarnings = \App\Models\ArtistEarning::where('status', 'paid')
                ->where('created_at', '>=', $from)
                ->sum('earning_amount_toman');

            // Streaming earnings by artist
            $streamingByArtistRaw = DB::table('artist_earnings')
                ->select('artist_id',
                    DB::raw('SUM(play_count) as total_plays'),
                    DB::raw('SUM(earning_amount_toman) as total_earnings')
                )
                ->where('status', 'paid')
                ->where('created_at', '>=', $from)
                ->whereNotNull('artist_id')
                ->groupBy('artist_id')
                ->orderByDesc('total_earnings')
                ->limit(10)
                ->get();

            $artistIds = $streamingByArtistRaw->pluck('artist_id');
            $artists = \App\Models\Artist::whereIn('id', $artistIds)->get()->keyBy('id');

            $streamingByArtist = $streamingByArtistRaw->map(function ($row) use ($artists) {
                $row->artist = $artists->get($row->artist_id);
                return $row;
            });

            $dailyRevenue = WalletTransaction::where('type', 'deposit')
                ->where('status', 'approved')
                ->where('created_at', '>=', now()->subDays(30))
                ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray();

            // برترین فروشندگان — join جداگانه برای جلوگیری از conflict با groupBy
            $topArtistsRaw = DB::table('sales')
                ->select('seller_id',
                    DB::raw('SUM(gross_amount) as total_sales'),
                    DB::raw('SUM(net_amount) as total_earnings'),
                    DB::raw('COUNT(*) as sales_count')
                )
                ->where('status', 'completed')
                ->where('created_at', '>=', $from)
                ->whereNotNull('seller_id')
                ->groupBy('seller_id')
                ->orderByDesc('total_sales')
                ->limit(10)
                ->get();

            $sellerIds = $topArtistsRaw->pluck('seller_id');
            $sellers   = User::whereIn('id', $sellerIds)->get()->keyBy('id');

            $topArtists = $topArtistsRaw->map(function ($row) use ($sellers) {
                $row->seller = $sellers->get($row->seller_id);
                return $row;
            });

        } catch (\Throwable $e) {
            $totalDeposits = $totalWithdrawals = $totalCommission = 0;
            $artistEarnings = $salesCount = $newUsers = $pendingTransactions = 0;
            $dailyRevenue = [];
            $topArtists = collect();
        }

        return compact(
            'totalDeposits', 'totalWithdrawals', 'totalCommission',
            'artistEarnings', 'salesCount', 'newUsers',
            'pendingTransactions', 'streamingEarnings', 'streamingByArtist', 'dailyRevenue', 'topArtists'
        );
    }
}

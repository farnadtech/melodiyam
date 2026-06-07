<?php

namespace App\Filament\Widgets;

use App\Helpers\Jalali;
use App\Models\Payment;
use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 5;
    protected ?string $heading = 'درآمد سایت';
    protected ?string $description = 'اشتراک پرمیوم کاربران + پلن هنرمندان + کمیسیون فروش آهنگ، آلبوم و پادکست';
    protected ?string $pollingInterval = null;
    protected ?string $maxHeight = '300px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7'  => '۷ روز اخیر',
            '30' => '۳۰ روز اخیر',
            '90' => '۹۰ روز اخیر',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?? 30);
        $since = now()->subDays($days);

        // 1) Subscription & plan payments (premium users + artist plans)
        $payments = Payment::where('status', 'paid')
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        // 2) Platform commission from content sales (track / album / podcast)
        $commissions = Sale::where('status', 'completed')
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, SUM(commission_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $totals = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date     = now()->subDays($i)->format('Y-m-d');
            $labels[] = Jalali::format($date, 'm/d');
            $totals[] = (float) (($payments[$date] ?? 0) + ($commissions[$date] ?? 0));
        }

        return [
            'datasets' => [
                [
                    'label'                => 'درآمد کل - تومان',
                    'data'                 => $totals,
                    'borderColor'          => '#f59e0b',
                    'backgroundColor'      => 'rgba(245, 158, 11, 0.12)',
                    'fill'                 => true,
                    'tension'              => 0.35,
                    'pointRadius'          => 3,
                    'pointBackgroundColor' => '#f59e0b',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(148,163,184,0.12)'],
                ],
                'x' => [
                    'grid'    => ['display' => false],
                    'ticks'   => ['maxRotation' => 45, 'autoSkip' => true, 'maxTicksLimit' => 15],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                    'rtl'      => true,
                ],
                'tooltip' => [
                    'rtl'           => true,
                    'textDirection'  => 'rtl',
                ],
            ],
            'interaction' => [
                'mode'      => 'index',
                'intersect' => false,
            ],
        ];
    }
}

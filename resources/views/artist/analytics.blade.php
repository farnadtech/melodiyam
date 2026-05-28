<x-layouts.app title="آمار و درآمد">
<div class="p-4 lg:p-8 space-y-8 max-w-6xl mx-auto">
    <div>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آمار و درآمد</h1>
        <p class="text-sm text-surface-500 mt-1">مشاهده آمار پخش، فروش و درآمد از پخش</p>
    </div>

    @if(!$artist)
    <div class="text-center py-16"><p class="text-surface-500">پروفایل هنرمندی یافت نشد.</p></div>
    @else

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">کل پخش‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->total_streams) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">دنبال‌کننده‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->followers_count) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">درآمد فروش این ماه</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($monthEarnings) }}</p>
            <p class="text-xs text-surface-400">تومان</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">موجودی کیف پول</p>
            <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($walletBalance) }}</p>
            <p class="text-xs text-surface-400">تومان</p>
        </div>
    </div>

    {{-- Stream Earnings Section --}}
    @if($earningsSettings->is_enabled)
    <div>
        <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">درآمد از پخش</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">کل درآمد پخش</p>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($totalStreamEarnings) }} <span class="text-sm font-normal text-surface-500">تومان</span></p>
                <p class="text-xs text-surface-400 mt-1">واریز شده به کیف پول</p>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">درآمد این ماه</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400 mt-1">{{ number_format($monthStreamEarnings) }} <span class="text-sm font-normal text-surface-500">تومان</span></p>
                <p class="text-xs text-surface-400 mt-1">واریز شده این ماه</p>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">کل پخش‌ها</p>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ number_format($totalPlays) }}</p>
                @if($nextMilestone && $nextMilestone['remaining'] > 0)
                <p class="text-xs text-amber-500 mt-1">{{ $nextMilestone['remaining'] }} پخش تا درآمد بعدی</p>
                @elseif($nextMilestone && $nextMilestone['remaining'] === 0)
                <p class="text-xs text-emerald-500 mt-1">درآمد جدید واریز شد!</p>
                @endif
            </div>
        </div>
        <div class="glass-card rounded-2xl p-5 mb-4 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-surface-600 dark:text-surface-400">
                    نرخ درآمد: به ازای هر <span class="font-bold text-primary-500">{{ $earningsSettings->plays_threshold }}</span> پخش ←
                    <span class="font-bold text-emerald-500">{{ number_format($earningsSettings->earning_amount_toman) }} تومان</span>
                    خودکار به کیف پول واریز می‌شود
                </p>
                @if($earningsSettings->payout_description)
                <p class="text-xs text-surface-400 mt-1">{{ $earningsSettings->payout_description }}</p>
                @endif
            </div>
            <a href="{{ route('wallet') }}" wire:navigate class="flex-shrink-0 px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium transition-colors">
                مشاهده کیف پول
            </a>
        </div>
    </div>
    @else
    <div class="rounded-2xl p-5 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400 text-sm">
        <p class="font-medium">سیستم درآمدزایی از پخش فعال نیست</p>
        <p class="mt-1">در حال حاضر سیستم کسب درآمد از پخش غیرفعال است.</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Earnings Chart (30 days) --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-semibold text-surface-900 dark:text-white mb-4">درآمد ۳۰ روز گذشته (تومان)</h2>
            @php
                $maxVal = max(array_column($streamChart, 'total') ?: [1]);
            @endphp
            <div class="flex items-end gap-px h-24 mb-2">
                @foreach($streamChart as $item)
                @php $h = $maxVal > 0 ? max(2, round(($item['total']/$maxVal)*100)) : 2; @endphp
                <div class="flex-1 rounded-t-sm bg-emerald-400/60 hover:bg-emerald-500 transition-colors min-h-[2px] cursor-default"
                     style="height:{{ $h }}%" title="{{ $item['date'] }}: {{ number_format($item['total']) }} ت"></div>
                @endforeach
            </div>
            <div class="flex justify-between text-xs text-surface-400">
                <span>۳۰ روز پیش</span>
                <span>امروز</span>
            </div>
            <p class="text-xs text-surface-500 mt-2">کل درآمد: <strong class="text-surface-900 dark:text-white">{{ number_format($totalEarnings) }} تومان</strong></p>
        </div>

        {{-- Top Tracks --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-semibold text-surface-900 dark:text-white mb-4">پرپخش‌ترین آهنگ‌ها</h2>
            @if($topTracks->isEmpty())
            <p class="text-sm text-surface-400 text-center py-8">هنوز آهنگی ندارید</p>
            @else
            @php $maxPlays = $topTracks->first()->play_count ?: 1; @endphp
            <div class="space-y-3">
                @foreach($topTracks as $i => $track)
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-surface-400 w-5 text-center">{{ $i+1 }}</span>
                    <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate">{{ $track->title }}</p>
                        <div class="w-full bg-surface-100 dark:bg-surface-700 rounded-full h-1 mt-1">
                            <div class="bg-primary-500 h-1 rounded-full" style="width:{{ $maxPlays > 0 ? round($track->play_count/$maxPlays*100) : 0 }}%"></div>
                        </div>
                    </div>
                    <span class="text-xs text-surface-400 flex-shrink-0">{{ number_format($track->play_count) }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Recent Sales --}}
    <div class="glass-card rounded-2xl p-6">
        <h2 class="font-semibold text-surface-900 dark:text-white mb-4">آخرین فروش‌ها</h2>
        @if($recentSales->isEmpty())
        <p class="text-sm text-surface-400 text-center py-8">هنوز فروشی ثبت نشده</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-surface-200 dark:border-surface-700">
                        <th class="text-right py-2 px-3 text-xs font-medium text-surface-400">خریدار</th>
                        <th class="text-right py-2 px-3 text-xs font-medium text-surface-400">آیتم</th>
                        <th class="text-right py-2 px-3 text-xs font-medium text-surface-400">درآمد شما</th>
                        <th class="text-right py-2 px-3 text-xs font-medium text-surface-400">تاریخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-100 dark:divide-surface-800">
                    @foreach($recentSales as $sale)
                    <tr>
                        <td class="py-2.5 px-3 text-surface-700 dark:text-surface-300">{{ $sale->buyer?->name ?? '—' }}</td>
                        <td class="py-2.5 px-3 text-surface-700 dark:text-surface-300">{{ $sale->saleable?->title ?? '—' }}</td>
                        <td class="py-2.5 px-3 font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($sale->net_amount) }} ت</td>
                        <td class="py-2.5 px-3 text-xs text-surface-400">{{ \App\Helpers\Jalali::format($sale->created_at, 'Y/m/d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Stream Earnings History --}}
    @if($earningsSettings->is_enabled && $recentStreamEarnings->isNotEmpty())
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="p-5 border-b border-surface-200 dark:border-surface-700 flex items-center justify-between">
            <h2 class="font-semibold text-surface-900 dark:text-white">تاریخچه درآمد از پخش</h2>
            <span class="text-xs text-emerald-500 font-medium">همه به کیف پول واریز شده</span>
        </div>
        <div class="divide-y divide-surface-200 dark:divide-surface-700">
            @foreach($recentStreamEarnings as $earning)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-surface-900 dark:text-white text-sm">{{ $earning->playable?->title ?? 'آهنگ حذف شده' }}</p>
                    <p class="text-xs text-surface-500">{{ number_format($earning->play_count) }} پخش | {{ \App\Helpers\Jalali::format($earning->created_at, 'Y/m/d') }}</p>
                </div>
                <p class="font-semibold text-emerald-600 dark:text-emerald-400">+ {{ number_format($earning->earning_amount_toman) }} تومان</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif
</div>
</x-layouts.app>

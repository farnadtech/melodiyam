<x-layouts.app title="درآمد من">
<div class="p-4 lg:p-8 space-y-8 max-w-5xl mx-auto">

    <div>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">درآمد من</h1>
        <p class="text-sm text-surface-500 mt-1">مشاهده وضعیت درآمد و آمار پخش</p>
    </div>

    @php
        $settings = \App\Models\EarningsSetting::getSettings();
        $totalEarnings = $artist->getTotalEarningsToman();
        $pendingEarnings = $artist->getPendingEarningsToman();
        $paidEarnings = $artist->getPaidEarningsToman();
        $totalPlays = $artist->tracks()->sum('play_count');
    @endphp

    @if(!$settings->is_enabled)
    <div class="rounded-2xl p-5 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400 text-sm">
        <p class="font-medium">سیستم درآمدزایی فعال نیست</p>
        <p class="mt-1">در حال حاضر سیستم کسب درآمد غیرفعال است. لطفاً بعداً مراجعه کنید.</p>
    </div>
    @else

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <p class="text-sm text-surface-500">کل درآمد</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ number_format($totalEarnings) }} <span class="text-sm font-normal">تومان</span></p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-sm text-surface-500">در انتظار پرداخت</p>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ number_format($pendingEarnings) }} <span class="text-sm font-normal">تومان</span></p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-sm text-surface-500">پرداخت شده</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($paidEarnings) }} <span class="text-sm font-normal">تومان</span></p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-sm text-surface-500">کل پخش‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ number_format($totalPlays) }}</p>
        </div>
    </div>

    <!-- Settings Info -->
    <div class="glass-card rounded-2xl p-5">
        <h2 class="font-semibold text-surface-900 dark:text-white mb-3">نرخ درآمد</h2>
        <p class="text-sm text-surface-600 dark:text-surface-400">
            به ازای هر <span class="font-bold text-primary-500">{{ $settings->plays_threshold }}</span> پخش = 
            <span class="font-bold text-emerald-500">{{ number_format($settings->earning_amount_toman) }} تومان</span>
            درآمد
        </p>
        <p class="text-sm text-surface-500 mt-3">حداقل مبلغ برداشت: {{ number_format($settings->min_payout_toman) }} تومان</p>
        @if($settings->payout_description)
        <p class="text-sm text-surface-500 mt-2 bg-surface-50 dark:bg-surface-800/50 p-3 rounded-lg">
            {{ $settings->payout_description }}
        </p>
        @endif
    </div>

    <!-- Tracks Earnings -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="p-5 border-b border-surface-200 dark:border-surface-700">
            <h2 class="font-semibold text-surface-900 dark:text-white">درآمد به تفکیک آهنگ</h2>
        </div>
        <div class="divide-y divide-surface-200 dark:divide-surface-700">
            @forelse($artist->tracks()->withCount('earnings')->latest()->take(10)->get() as $track)
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ $track->cover_image ? asset('storage/'.$track->cover_image) : asset('images/default-cover.png') }}" class="w-10 h-10 rounded-lg object-cover">
                    <div>
                        <p class="font-medium text-surface-900 dark:text-white text-sm">{{ $track->title }}</p>
                        <p class="text-xs text-surface-500">{{ number_format($track->play_count) }} پخش</p>
                    </div>
                </div>
                @php
                    $trackEarnings = $artist->earnings()->where('playable_id', $track->id)->where('playable_type', \App\Models\Track::class)->sum('earning_amount_toman');
                @endphp
                <p class="font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($trackEarnings) }} تومان</p>
            </div>
            @empty
            <div class="p-8 text-center text-surface-500">
                <p>هنوز آهنگی آپلود نکرده‌اید</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Earnings History -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="p-5 border-b border-surface-200 dark:border-surface-700">
            <h2 class="font-semibold text-surface-900 dark:text-white">تاریخچه درآمد</h2>
        </div>
        <div class="divide-y divide-surface-200 dark:divide-surface-700">
            @forelse($artist->earnings()->with('playable')->latest()->take(10)->get() as $earning)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-surface-900 dark:text-white text-sm">{{ $earning->playable?->title ?? 'آهنگ حذف شده' }}</p>
                    <p class="text-xs text-surface-500">{{ $earning->play_count }} پخش | {{ \App\Helpers\Jalali::format($earning->created_at, 'Y/m/d') }}</p>
                </div>
                <div class="text-left">
                    <p class="font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($earning->earning_amount_toman) }} تومان</p>
                    <p class="text-xs {{ $earning->status === 'paid' ? 'text-emerald-500' : ($earning->status === 'pending' ? 'text-amber-500' : 'text-rose-500') }}">
                        {{ $earning->status === 'paid' ? 'پرداخت شده' : ($earning->status === 'pending' ? 'در انتظار' : 'لغو شده') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-surface-500">
                <p>هنوز درآمدی ثبت نشده است</p>
            </div>
            @endforelse
        </div>
    </div>

    @endif

</div>
</x-layouts.app>

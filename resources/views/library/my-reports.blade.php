<x-layouts.app title="گزارش‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
            </svg>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">گزارش‌های من</h1>
        </div>

        @if($reports->isEmpty())
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="w-12 h-12 text-surface-300 dark:text-surface-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
            </svg>
            <p class="text-surface-500 dark:text-surface-400">هیچ گزارشی ثبت نکرده‌اید.</p>
        </div>
        @else
        <div class="space-y-3">
            @foreach($reports as $report)
            @php
                $contentTitle = '—';
                $contentUrl   = null;
                if ($report->reportable_type === 'App\Models\Track' && $report->reportable) {
                    $contentTitle = $report->reportable->title;
                    $contentUrl   = route('track.show', $report->reportable);
                } elseif ($report->reportable_type === 'App\Models\Album' && $report->reportable) {
                    $contentTitle = $report->reportable->title;
                    $contentUrl   = route('album.show', $report->reportable);
                }
                $typeLabel = match($report->reportable_type) {
                    'App\Models\Track' => 'آهنگ',
                    'App\Models\Album' => 'آلبوم',
                    default => 'محتوا',
                };
                $statusColor = match($report->status) {
                    'pending'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                    'reviewed' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                    'resolved' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                    'rejected' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400',
                    default    => 'bg-surface-100 dark:bg-surface-700 text-surface-500',
                };
            @endphp
            <div class="glass-card rounded-2xl p-5 space-y-3">
                <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-medium px-2 py-0.5 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-500">{{ $typeLabel }}</span>
                        @if($contentUrl)
                        <a href="{{ $contentUrl }}" wire:navigate class="text-sm font-semibold text-surface-900 dark:text-white hover:text-primary-500 transition-colors">
                            {{ $contentTitle }}
                        </a>
                        @else
                        <span class="text-sm font-semibold text-surface-400">(حذف شده)</span>
                        @endif
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColor }}">
                        {{ \App\Models\Report::$statuses[$report->status] ?? $report->status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-surface-500 dark:text-surface-400">
                    <div>
                        <span class="font-medium">دلیل:</span>
                        {{ \App\Models\Report::$reasons[$report->reason] ?? $report->reason }}
                    </div>
                    <div>
                        <span class="font-medium">تاریخ ثبت:</span>
                        {{ \App\Helpers\Jalali::format($report->created_at, 'Y/m/d') }}
                    </div>
                </div>

                @if($report->description)
                <p class="text-xs text-surface-500 dark:text-surface-400 bg-surface-50 dark:bg-surface-800/50 rounded-xl px-3 py-2">
                    <span class="font-medium">توضیحات شما:</span> {{ $report->description }}
                </p>
                @endif

                {{-- نتیجه بررسی ادمین --}}
                @if(in_array($report->status, ['resolved', 'rejected']) && $report->admin_note)
                <div class="rounded-xl px-4 py-3 text-sm {{ $report->status === 'resolved' ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800' }}">
                    <p class="font-semibold mb-1 {{ $report->status === 'resolved' ? 'text-emerald-700 dark:text-emerald-400' : 'text-rose-700 dark:text-rose-400' }}">
                        {{ $report->status === 'resolved' ? '✓ گزارش پذیرفته شد' : '✕ گزارش رد شد' }}
                    </p>
                    <p class="text-surface-600 dark:text-surface-300">{{ $report->admin_note }}</p>
                    @if($report->reviewed_at)
                    <p class="text-xs text-surface-400 mt-1">{{ \App\Helpers\Jalali::format($report->reviewed_at, 'Y/m/d') }}</p>
                    @endif
                </div>
                @elseif($report->status === 'reviewed')
                <div class="rounded-xl px-4 py-3 text-sm bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400">
                    در حال بررسی توسط تیم پشتیبانی...
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $reports->links() }}
        </div>
        @endif
    </div>
</x-layouts.app>

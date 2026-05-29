<x-layouts.app title="پلن‌های هنرمند">
<div class="p-4 lg:p-8 space-y-8 max-w-4xl mx-auto">

    <div>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پلن‌های اشتراک هنرمند</h1>
        <p class="text-sm text-surface-500 mt-1">برای آپلود آهنگ و آلبوم یک پلن انتخاب کنید</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="rounded-2xl px-5 py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="rounded-2xl px-5 py-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 text-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- اشتراک فعال --}}
    @if($activeSub)
    <div class="rounded-2xl p-5 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800">
        <div class="flex items-center gap-3 mb-3">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h2 class="font-semibold text-emerald-800 dark:text-emerald-200">اشتراک فعال شما: {{ $activeSub->plan->name }}</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 text-xs mb-0.5">انقضا</p>
                <p class="font-medium text-emerald-800 dark:text-emerald-200">
                    {{ $activeSub->expires_at ? \App\Helpers\Jalali::format($activeSub->expires_at, 'Y/m/d') : 'نامحدود' }}
                </p>
            </div>
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 text-xs mb-0.5">آهنگ‌های آپلود شده</p>
                <p class="font-medium text-emerald-800 dark:text-emerald-200">
                    {{ $activeSub->tracks_used }} / {{ $activeSub->plan->max_tracks == 0 ? '∞' : $activeSub->plan->max_tracks }}
                </p>
            </div>
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 text-xs mb-0.5">آلبوم‌ها</p>
                <p class="font-medium text-emerald-800 dark:text-emerald-200">
                    {{ $activeSub->albums_used }} / {{ $activeSub->plan->max_albums == 0 ? '∞' : $activeSub->plan->max_albums }}
                </p>
            </div>
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 text-xs mb-0.5">فضا</p>
                <p class="font-medium text-emerald-800 dark:text-emerald-200">
                    {{ $activeSub->storage_used_mb }} MB / {{ $activeSub->plan->max_storage_mb == 0 ? '∞' : $activeSub->plan->max_storage_mb . ' MB' }}
                </p>
            </div>
        </div>
    </div>
    @endif

    @php
        $siteEmail = \App\Models\Setting::get('site_email');
    @endphp

    @if($plans->isEmpty())
    <div class="glass-card rounded-2xl p-10 text-center text-surface-500">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="font-medium">در حال حاضر پلنی موجود نیست</p>
        <p class="text-sm mt-1">برای خرید اشتراک با پشتیبانی تماس بگیرید</p>
        @if($siteEmail)
        <a href="mailto:{{ $siteEmail }}" class="mt-4 inline-block px-4 py-2 rounded-xl bg-primary-500 text-white text-sm font-medium hover:bg-primary-600 transition-colors">
            تماس با پشتیبانی
        </a>
        @endif
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
        @php
            $isCurrent = $activeSub && $activeSub->plan_id === $plan->id;
        @endphp
        <div class="glass-card rounded-2xl p-6 flex flex-col gap-4 {{ $isCurrent ? 'ring-2 ring-emerald-400 dark:ring-emerald-500' : '' }}">
            @if($isCurrent)
            <div class="flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 rounded-full px-3 py-1 w-fit">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                پلن فعلی شما
            </div>
            @endif

            <div>
                <h3 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name }}</h3>
                @if($plan->description)
                <p class="text-sm text-surface-500 mt-1">{{ $plan->description }}</p>
                @endif
            </div>

            <div class="text-3xl font-bold text-surface-900 dark:text-white">
                @if($plan->price == 0)
                    رایگان
                @else
                    {{ number_format($plan->price) }}
                    <span class="text-base font-normal text-surface-500">تومان</span>
                @endif
            </div>

            <ul class="space-y-2 flex-1 text-sm text-surface-600 dark:text-surface-400">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ $plan->duration_days }} روز اعتبار
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ $plan->max_tracks == 0 ? 'آهنگ نامحدود' : 'تا ' . $plan->max_tracks . ' آهنگ' }}
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ $plan->max_albums == 0 ? 'آلبوم نامحدود' : 'تا ' . $plan->max_albums . ' آلبوم' }}
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ $plan->max_storage_mb == 0 ? 'فضای نامحدود' : $plan->max_storage_mb . ' MB فضا' }}
                </li>
            </ul>

            @if($isCurrent)
            <div class="w-full py-2.5 rounded-xl text-center text-sm font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 cursor-default">
                اشتراک فعال
            </div>
            @elseif($plan->price == 0)
            <a href="{{ route('artist.subscription.checkout', $plan) }}"
               class="w-full py-2.5 rounded-xl text-center text-sm font-medium btn-primary block transition-colors">
                فعال‌سازی رایگان
            </a>
            @else
            <a href="{{ route('artist.subscription.checkout', $plan) }}"
               class="w-full py-2.5 rounded-xl text-center text-sm font-medium btn-primary block transition-colors">
                خرید این پلن
            </a>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <div class="text-center text-sm text-surface-400">
        در صورت بروز مشکل در خرید با پشتیبانی تماس بگیرید{{ $siteEmail ? ':' : '' }}
        @if($siteEmail)
        <a href="mailto:{{ $siteEmail }}" class="text-primary-500 hover:underline">{{ $siteEmail }}</a>
        @endif
    </div>

</div>
</x-layouts.app>

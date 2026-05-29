<x-layouts.app title="پریمیوم ملودیام">
    <div class="p-4 lg:p-8 space-y-10">

        @if(!($premiumEnabled ?? true))
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-2">پریمیوم فعلاً در دسترس نیست</h2>
            <p class="text-surface-500">سرویس اشتراک ویژه موقتاً غیرفعال شده است.</p>
        </div>
        @else

        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2z"/></svg>
                ملودیام پریمیوم
            </div>
            <h1 class="text-3xl lg:text-4xl font-display font-extrabold text-surface-900 dark:text-white mb-4">
                تجربه موسیقی بدون محدودیت
            </h1>
            <p class="text-surface-500 text-lg">بدون تبلیغات، کیفیت بالا، دانلود آفلاین و خیلی بیشتر</p>
        </div>

        @if(isset($activeSubscription))
        {{-- Active Subscription Info --}}
        <div class="max-w-4xl mx-auto">
            <div class="glass-card rounded-3xl p-6 border-2 border-amber-500/20 bg-amber-500/5">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-amber-500 flex items-center justify-center text-white shadow-lg shadow-amber-500/20">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-surface-900 dark:text-white">اشتراک فعلی: {{ $activeSubscription->plan->name_fa }}</h3>
                            <p class="text-surface-500 text-sm mt-1">
                                @if($activeSubscription->is_trial)
                                    <span class="text-emerald-500 font-bold">دوره آزمایشی رایگان</span> — 
                                @endif
                                پایان اعتبار: {{ \Morilog\Jalali\Jalalian::fromDateTime($activeSubscription->expires_at)->format('Y/m/d') }} 
                                <span class="mr-2 text-xs opacity-75">({{ $activeSubscription->expires_at->diffForHumans() }})</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-sm">فعال</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Plans Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach($plans as $plan)
            @php
                $isTrialPlan = ($plan->trial_days ?? 0) > 0;
                // Hide trial plan if user already used it
                if ($isTrialPlan && ($hasUsedTrial ?? false)) continue;
            @endphp
            <div class="relative glass-card rounded-3xl p-6 {{ $plan->is_popular ? 'ring-2 ring-primary-500 shadow-xl shadow-primary-500/10' : '' }}">
                @php
                    $isActivePlan = isset($activeSubscription) && $activeSubscription->plan_id === $plan->id;
                    $isFreePlan = $plan->price <= 0 && ($plan->trial_days ?? 0) <= 0;
                    $isUserOnPremium = isset($activeSubscription);
                @endphp

                @if($plan->is_popular)
                <div class="absolute -top-3 right-1/2 translate-x-1/2 px-4 py-1 rounded-full bg-primary-500 text-white text-xs font-bold shadow-lg">
                    محبوب‌ترین
                </div>
                @endif

                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name_fa }}</h3>
                    @if(($plan->trial_days ?? 0) > 0)
                    <div class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        {{ $plan->trial_days }} روز رایگان
                    </div>
                    @endif
                    <div class="mt-3">
                        @if($plan->price > 0)
                        <span class="text-3xl font-extrabold text-surface-900 dark:text-white">{{ number_format($plan->price) }}</span>
                        <span class="text-surface-500 text-sm">تومان / {{ $plan->duration_days <= 31 ? 'ماه' : 'سال' }}</span>
                        @else
                        <span class="text-3xl font-extrabold text-surface-900 dark:text-white">رایگان</span>
                        @endif
                    </div>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach($plan->features ?? [] as $feature)
                    <li class="flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>

                @if($isActivePlan)
                    <div class="btn-ghost border-2 border-emerald-500/50 text-emerald-600 dark:text-emerald-400 w-full text-center font-bold cursor-default flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        طرح فعلی شما
                    </div>
                @elseif($isFreePlan && !$isUserOnPremium)
                    <div class="btn-ghost border border-surface-300 dark:border-surface-600 w-full text-center opacity-60 cursor-default">طرح فعلی</div>
                @elseif($isFreePlan && $isUserOnPremium)
                    <div class="btn-ghost border border-surface-200 dark:border-surface-700 w-full text-center opacity-40 cursor-default text-xs">طرح پایه</div>
                @else
                    @auth
                    <a href="{{ route('subscription.checkout', $plan) }}" wire:navigate class="{{ $plan->is_popular ? 'btn-primary' : 'btn-ghost border border-surface-300 dark:border-surface-600' }} w-full text-center">
                        {{ ($plan->trial_days ?? 0) > 0 ? 'شروع دوره رایگان' : 'انتخاب این طرح' }}
                    </a>
                    @else
                    <a href="{{ route('login') }}" wire:navigate class="{{ $plan->is_popular ? 'btn-primary' : 'btn-ghost border border-surface-300 dark:border-surface-600' }} w-full text-center">
                        ورود و {{ ($plan->trial_days ?? 0) > 0 ? 'شروع رایگان' : 'خرید' }}
                    </a>
                    @endauth
                @endif
            </div>
            @endforeach
        </div>

        @php
            $faqs = \App\Models\Setting::get('premium_faqs');
            if (is_string($faqs)) {
                $faqs = json_decode($faqs, true);
            }
            if (!is_array($faqs) || empty($faqs)) {
                $faqs = [
                    ['question' => 'آیا می‌توانم هر زمان لغو کنم؟', 'answer' => 'بله، اشتراک شما تا پایان دوره فعال باقی می‌ماند و پس از آن تمدید نخواهد شد.'],
                    ['question' => 'آیا دانلود آفلاین امکان‌پذیر است؟', 'answer' => 'بله، در طرح پریمیوم می‌توانید آهنگ‌ها را برای پخش آفلاین دانلود کنید.'],
                    ['question' => 'حداکثر چند دستگاه می‌توان استفاده کرد؟', 'answer' => 'بسته به طرح اشتراکی شما، از ۱ تا ۵ دستگاه همزمان پشتیبانی می‌شود.'],
                ];
            }
        @endphp

        {{-- FAQ --}}
        <div class="max-w-2xl mx-auto" x-data="{ open: null }">
            <h2 class="text-xl font-bold text-surface-900 dark:text-white text-center mb-6">سؤالات متداول</h2>
            <div class="space-y-3">
                @foreach($faqs as $i => $faq)
                <div class="glass-card rounded-xl overflow-hidden">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full px-5 py-4 flex items-center justify-between text-right">
                        <span class="font-medium text-surface-900 dark:text-white">{{ $faq['question'] ?? ($faq['q'] ?? '') }}</span>
                        <svg class="w-5 h-5 text-surface-400 transition-transform" :class="open === {{ $i }} && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse class="px-5 pb-4 text-sm text-surface-500">{{ $faq['answer'] ?? ($faq['a'] ?? '') }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
        @endif
</x-layouts.app>

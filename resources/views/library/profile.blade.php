<x-layouts.app title="پروفایل">
    <div class="p-4 lg:p-8 space-y-6 max-w-2xl mx-auto">

        {{-- Header Card --}}
        <div class="glass-card rounded-3xl p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                {{-- Avatar --}}
                <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/default-avatar.png') }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-20 h-20 rounded-2xl object-cover shadow-lg flex-shrink-0">
                {{-- Info --}}
                <div class="flex-1 text-center sm:text-right">
                    <div class="flex flex-wrap items-center gap-2 justify-center sm:justify-start mb-1">
                        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">{{ auth()->user()->name }}</h1>
                        @if(auth()->user()->isArtist())
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 text-xs font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            هنرمند
                        </span>
                        @endif
                        @if(auth()->user()->isPremium())
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-medium">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            پریمیوم
                        </span>
                        @endif
                    </div>
                    @if(auth()->user()->username)
                    <p class="text-sm text-surface-400 mb-1">@{{ auth()->user()->username }}</p>
                    @endif
                    <p class="text-sm text-surface-500">{{ auth()->user()->email }}</p>
                    @if(auth()->user()->phone)
                    <p class="text-sm text-surface-500">{{ auth()->user()->phone }}</p>
                    @endif
                    @if(auth()->user()->bio)
                    <p class="text-sm text-surface-600 dark:text-surface-400 mt-2">{{ auth()->user()->bio }}</p>
                    @endif
                </div>
                {{-- Edit button --}}
                <a href="{{ route('profile.edit') }}" wire:navigate class="flex-shrink-0 flex items-center gap-1.5 px-4 py-2 rounded-xl border border-surface-200 dark:border-surface-700 text-sm text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    ویرایش
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-3 mt-6 pt-5 border-t border-surface-200 dark:border-surface-700">
                <a href="{{ url('/library/liked') }}" wire:navigate class="text-center hover:bg-surface-50 dark:hover:bg-surface-800 rounded-xl p-2 transition-colors">
                    <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($likeCount) }}</p>
                    <p class="text-xs text-surface-500 mt-0.5">پسندیده</p>
                </a>
                <a href="{{ url('/library/playlists') }}" wire:navigate class="text-center hover:bg-surface-50 dark:hover:bg-surface-800 rounded-xl p-2 transition-colors">
                    <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($playlistCount) }}</p>
                    <p class="text-xs text-surface-500 mt-0.5">پلی‌لیست</p>
                </a>
                <a href="{{ url('/library/artists') }}" wire:navigate class="text-center hover:bg-surface-50 dark:hover:bg-surface-800 rounded-xl p-2 transition-colors">
                    <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($followCount) }}</p>
                    <p class="text-xs text-surface-500 mt-0.5">دنبال‌شده</p>
                </a>
            </div>
        </div>

        {{-- بنر هنرمند شو --}}
        @if(auth()->user()->isListener())
            @if(!$application)
            <a href="{{ route('artist-application.show') }}" wire:navigate
               class="flex items-center gap-4 p-5 rounded-2xl bg-gradient-to-l from-primary-500/10 to-accent-500/10 border border-primary-200 dark:border-primary-800 hover:border-primary-400 dark:hover:border-primary-600 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center shadow-lg flex-shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-surface-900 dark:text-white text-sm">هنرمند هستید؟ حساب خود را ارتقا دهید</p>
                    <p class="text-xs text-surface-500 mt-0.5">موسیقی آپلود کنید، آلبوم بسازید و درآمد کسب کنید</p>
                </div>
                <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            @elseif(in_array($application->status, ['pending', 'reviewing']))
            <div class="flex items-center gap-4 p-5 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400">درخواست هنرمند شدن در انتظار بررسی است</p>
                    <a href="{{ route('artist-application.show') }}" wire:navigate class="text-xs text-amber-600 dark:text-amber-500 underline mt-0.5 inline-block">مشاهده وضعیت ←</a>
                </div>
            </div>
            @elseif($application->status === 'rejected')
            <a href="{{ route('artist-application.show') }}" wire:navigate
               class="flex items-center gap-4 p-5 rounded-2xl bg-rose-50 dark:bg-rose-900/10 border border-rose-200 dark:border-rose-800 hover:border-rose-400 transition-all">
                <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400">درخواست رد شد — ارسال مجدد</p>
                    @if($application->admin_note)
                    <p class="text-xs text-rose-500 mt-0.5">دلیل: {{ $application->admin_note }}</p>
                    @endif
                </div>
            </a>
            @endif
        @endif

        {{-- Quick Links --}}
        <div class="glass-card rounded-2xl divide-y divide-surface-200 dark:divide-surface-700">
            <a href="{{ url('/library/liked') }}" wire:navigate class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-surface-800 dark:text-surface-200">آهنگ‌های پسندیده</span>
                </div>
                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <a href="{{ url('/library/playlists') }}" wire:navigate class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h10M4 18h10m3-2v6m3-3H14"/></svg>
                    </div>
                    <span class="text-sm font-medium text-surface-800 dark:text-surface-200">پلی‌لیست‌های من</span>
                </div>
                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <a href="{{ url('/library/history') }}" wire:navigate class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-surface-800 dark:text-surface-200">تاریخچه پخش</span>
                </div>
                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <a href="{{ route('my.reports') }}" wire:navigate class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    </div>
                    <span class="text-sm font-medium text-surface-800 dark:text-surface-200">گزارش‌های من</span>
                </div>
                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <a href="{{ route('settings') }}" wire:navigate class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors rounded-b-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-surface-800 dark:text-surface-200">ویرایش پروفایل و تنظیمات</span>
                </div>
                <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        </div>

    </div>
</x-layouts.app>

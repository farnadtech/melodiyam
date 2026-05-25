{{-- Desktop Sidebar --}}
<aside
    class="hidden lg:flex flex-col w-72 bg-white dark:bg-surface-900 border-l border-surface-200 dark:border-surface-800 transition-all duration-300 h-screen"
    x-show="sidebarOpen"
    x-data="{ playerActive: false }"
    x-init="playerActive = !!$store.player.currentTrack; $watch('$store.player.currentTrack', v => playerActive = !!v)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-x-4"
    x-transition:enter-end="opacity-100 translate-x-0"
>
    {{-- Logo --}}
    <div class="p-6 border-b border-surface-200 dark:border-surface-800">
        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
            </div>
            <span class="text-xl font-bold font-display text-gradient">ملودیام</span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 p-4 pb-24 space-y-1 overflow-y-auto scrollbar-hide">
        <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">منو</p>

        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
            {{ request()->is('/') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>خانه</span>
        </a>

        <a href="{{ url('/browse') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
            {{ request()->is('browse*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span>مرور</span>
        </a>

        <a href="{{ url('/search') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
            {{ request()->is('search*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span>جستجو</span>
        </a>

        <a href="{{ url('/podcasts') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
            {{ request()->is('podcasts*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
            </svg>
            <span>پادکست</span>
        </a>

        @auth
        <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">کتابخانه</p>

            <a href="{{ url('/library') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('library*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>کتابخانه من</span>
            </a>

            <a href="{{ url('/library/liked') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>علاقه‌مندی‌ها</span>
            </a>

            <a href="{{ url('/library/playlists') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
                <span>پلی‌لیست‌ها</span>
            </a>

            <a href="{{ url('/library/history') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>تاریخچه</span>
            </a>
        </div>
        @endauth
    </nav>

    {{-- Premium CTA --}}
    @auth
        @unless(auth()->user()->isPremium())
        <div class="sticky bottom-0 p-4 bg-white dark:bg-surface-900 border-t border-surface-200 dark:border-surface-800 transition-transform duration-300" :class="playerActive ? 'translate-y-[-80px]' : 'translate-y-0'">
            <div class="gradient-primary rounded-xl p-4 text-white text-center">
                <p class="text-sm font-bold mb-1">ملودیام پریمیوم</p>
                <p class="text-xs opacity-90 mb-3">بدون تبلیغات، کیفیت بالا</p>
                <a href="{{ url('/premium') }}" wire:navigate class="block w-full py-2 rounded-lg bg-white/20 hover:bg-white/30 text-sm font-medium transition-colors">
                    ارتقا حساب
                </a>
            </div>
        </div>
        @endunless
    @endauth
</aside>

{{-- Mobile Sidebar Overlay --}}
<div
    class="lg:hidden fixed inset-0 z-50 touch-pan-y"
    x-cloak
    x-show="mobileSidebar"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click.self="mobileSidebar = false"
>
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div
        class="relative w-72 h-full bg-white dark:bg-surface-900 shadow-2xl flex flex-col"
        x-show="mobileSidebar"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        {{-- Mobile header --}}
        <div class="p-6 flex items-center justify-between border-b border-surface-200 dark:border-surface-800">
            <a href="{{ url('/') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold font-display text-gradient">ملودیام</span>
            </a>
            <button @click="mobileSidebar = false" class="p-2 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Navigation --}}
        <nav class="flex-1 p-4 pb-24 space-y-1 overflow-y-auto scrollbar-hide overscroll-contain">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">منو</p>

            <a href="{{ url('/') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('/') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>خانه</span>
            </a>

            <a href="{{ url('/browse') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('browse*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>مرور</span>
            </a>

            <a href="{{ url('/search') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('search*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>جستجو</span>
            </a>

            <a href="{{ url('/podcasts') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('podcasts*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                </svg>
                <span>پادکست</span>
            </a>

            @auth
            <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
                <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">کتابخانه</p>

                <a href="{{ url('/library') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                    {{ request()->is('library') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>کتابخانه من</span>
                </a>

                <a href="{{ url('/library/liked') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span>علاقه‌مندی‌ها</span>
                </a>

                <a href="{{ url('/library/playlists') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <span>پلی‌لیست‌ها</span>
                </a>

                <a href="{{ url('/library/history') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>تاریخچه</span>
                </a>
            </div>

            <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
                <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">حساب</p>

                <a href="{{ url('/profile') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>پروفایل</span>
                </a>

                <a href="{{ url('/settings') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>تنظیمات</span>
                </a>

                <form method="POST" action="{{ url('/logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>خروج</span>
                    </button>
                </form>
            </div>
            @else
            <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800 space-y-2">
                <a href="{{ url('/login') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">ورود</a>
                <a href="{{ url('/register') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium btn-primary">ثبت‌نام</a>
            </div>
            @endauth

            {{-- Mobile Premium CTA --}}
            @auth
                @unless(auth()->user()->isPremium())
                <div class="pt-4 mt-2 pb-4">
                    <div class="gradient-primary rounded-xl p-4 text-white text-center">
                        <p class="text-sm font-bold mb-1">ملودیام پریمیوم</p>
                        <p class="text-xs opacity-90 mb-3">بدون تبلیغات، کیفیت بالا</p>
                        <a href="{{ url('/premium') }}" wire:navigate @click="mobileSidebar = false" class="block w-full py-2 rounded-lg bg-white/20 hover:bg-white/30 text-sm font-medium transition-colors">
                            ارتقا حساب
                        </a>
                    </div>
                </div>
                @endunless
            @endauth
        </nav>
    </div>
</div>

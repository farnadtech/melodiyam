@php
    $pbEnabled = \App\Models\Setting::get('premium_banner_enabled', '1') === '1';
    $abEnabled = \App\Models\Setting::get('artist_banner_enabled',  '1') === '1';
    // Premium banner vars
    $_pbImg  = \App\Models\Setting::get('premium_banner_image');
    $pbImg   = $_pbImg ? asset('storage/' . $_pbImg) : null;
    $pbFrom  = \App\Models\Setting::get('premium_banner_bg_from');
    $pbTo    = \App\Models\Setting::get('premium_banner_bg_to');
    $pbStyle = $pbImg ? "background-image:url('{$pbImg}');background-size:cover;background-position:center;" : ($pbFrom && $pbTo ? "background:linear-gradient(135deg,{$pbFrom},{$pbTo});" : '');
    $pbTitle = \App\Models\Setting::get('premium_banner_title',    'ملودیام پریمیوم');
    $pbSub   = \App\Models\Setting::get('premium_banner_subtitle', 'بدون تبلیغات، کیفیت بالا');
    $pbBtn   = \App\Models\Setting::get('premium_banner_btn_text', 'ارتقا حساب');
    $pbUrl   = (string)(\App\Models\Setting::get('premium_banner_btn_url') ?: '/premium');
    $pbColor = (string)(\App\Models\Setting::get('premium_banner_text_color') ?: '#ffffff');
    // Artist banner vars
    $_abImg  = \App\Models\Setting::get('artist_banner_image');
    $abImg   = $_abImg ? asset('storage/' . $_abImg) : null;
    $abFrom  = \App\Models\Setting::get('artist_banner_bg_from');
    $abTo    = \App\Models\Setting::get('artist_banner_bg_to');
    $abStyle = $abImg ? "background-image:url('{$abImg}');background-size:cover;background-position:center;" : ($abFrom && $abTo ? "background:linear-gradient(135deg,{$abFrom},{$abTo});" : '');
    $abTitle = \App\Models\Setting::get('artist_banner_title',    'هنرمند شوید!');
    $abSub   = \App\Models\Setting::get('artist_banner_subtitle', 'موسیقی‌تان را با جهان به اشتراک بگذارید');
    $abBtn   = \App\Models\Setting::get('artist_banner_btn_text', 'شروع کنید');
    $abUrl   = (string)(\App\Models\Setting::get('artist_banner_btn_url') ?: '/become-artist');
    $abColor = (string)(\App\Models\Setting::get('artist_banner_text_color') ?: '#ffffff');

    // Sidebar footer vars
    $sfEnabled = \App\Models\Setting::get('sidebar_footer_enabled', '1') === '1';
    $sfDesc = \App\Models\Setting::get('sidebar_footer_description');
    $sfLinks = \App\Models\Setting::get('sidebar_footer_links', []);
    if (is_string($sfLinks)) {
        $sfLinks = json_decode($sfLinks, true) ?: [];
    }
@endphp

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
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" 
                     style="height: {{ $logoHeight }}px; max-height: 150px;" 
                     class="w-auto object-contain">
            @else
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                    </svg>
                </div>
            @endif
            
            @if($showSiteName)
                <span class="text-xl font-bold font-display text-gradient">{{ $siteName }}</span>
            @endif
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 p-4 pb-24 space-y-1 overflow-y-auto scrollbar-hide">

        @php
        $navLink = fn($path, $label, $icon, $exact = false) =>
            '<a href="' . url($path) . '" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors ' .
            (($exact ? request()->is(ltrim($path,'/')) || request()->is('/') && $path === '/' : request()->is(ltrim($path,'/').'*'))
                ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400'
                : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800') .
            '">' . $icon . '<span>' . $label . '</span></a>';
        @endphp

        <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">کشف موسیقی</p>

        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('/') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>خانه</span>
        </a>

        <a href="{{ url('/discover') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('discover*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            <span>کشف کن</span>
        </a>

        <a href="{{ url('/browse') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('browse*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>مرور</span>
        </a>

        <a href="{{ url('/albums') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('albums*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
            <span>آلبوم‌ها</span>
        </a>

        <a href="{{ url('/search') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('search*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span>جستجو</span>
        </a>

        <a href="{{ url('/podcasts') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('podcasts*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
            <span>پادکست</span>
        </a>

        <a href="{{ url('/playlists') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('playlists*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h10M4 18h10m3-2v6m3-3H14"/></svg>
            <span>پلی‌لیست‌ها</span>
        </a>

        @auth
        {{-- Library Section --}}
        <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">کتابخانه</p>

            <a href="{{ url('/library') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>کتابخانه من</span>
            </a>

            <a href="{{ url('/library/playlists') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/playlists*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <span>پلی‌لیست‌ها</span>
            </a>

            <a href="{{ url('/library/liked') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/liked*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                <span>آهنگ‌های پسندیده</span>
            </a>

            <a href="{{ url('/library/albums') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/albums*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <span>آلبوم‌ها</span>
            </a>

            <a href="{{ url('/library/artists') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/artists*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>هنرمندان</span>
            </a>

            <a href="{{ url('/library/podcasts') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/podcasts*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                <span>پادکست‌های من</span>
            </a>

            <a href="{{ url('/library/history') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/history*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>تاریخچه</span>
            </a>

            <a href="{{ url('/library/downloads') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('library/downloads*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>دانلودها</span>
            </a>

        </div>

        {{-- Artist Section --}}
        @if(auth()->user()?->isArtist())
        <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">پنل هنرمند</p>
            <a href="{{ route('artist.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('artist/dashboard*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <span>داشبورد هنرمند</span>
            </a>
            <a href="{{ route('artist.tracks') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('artist/tracks*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>آهنگ‌های من</span>
            </a>
            <a href="{{ route('artist.albums') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('artist/albums*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>آلبوم‌های من</span>
            </a>
            <a href="{{ route('artist.analytics') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('artist/analytics*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>آمار و درآمد</span>
            </a>
            <a href="{{ route('artist.settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('artist/settings*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>تنظیمات هنرمند</span>
            </a>
        </div>
        @endif

        {{-- Account Section --}}
        <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-2">حساب کاربری</p>

            <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('profile') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>ویرایش پروفایل</span>
            </a>

            <a href="{{ url('/notifications') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('notifications*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span>اعلان‌ها</span>
            </a>

            <a href="{{ url('/wallet') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('wallet*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span>کیف پول</span>
            </a>

            <a href="{{ route('purchases') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('my-purchases*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                <span>خریدهای من</span>
            </a>

            <a href="{{ route('my.reports') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('my-reports*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                <span>گزارش‌های من</span>
            </a>

            @if(auth()->user()->isListener())
            <a href="{{ route('artist-application.show') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('become-artist*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <span>هنرمند شو</span>
            </a>
            @endif

            <a href="{{ url('/premium') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('premium*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <span>اشتراک پریمیوم</span>
            </a>

            <a href="{{ url('/settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('settings*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>تنظیمات</span>
            </a>
        </div>
        @guest
        <div class="pt-4 mt-4 border-t border-surface-200 dark:border-surface-800">
            <p class="text-xs font-medium text-surface-400 dark:text-surface-500 px-3 mb-3">ورود به حساب</p>
            <div class="space-y-2 px-1">
                <a href="{{ url('/login') }}" wire:navigate class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    ورود
                </a>
                <a href="{{ url('/register') }}" wire:navigate class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium btn-primary w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    ثبت‌نام رایگان
                </a>
            </div>
        </div>
        @endguest

        @endauth
    </nav>

    {{-- Sidebar Banners --}}
    @auth
    <div class="sticky bottom-0 bg-white dark:bg-surface-900 border-t border-surface-200 dark:border-surface-800 transition-transform duration-300 space-y-0" :class="playerActive ? 'translate-y-[-80px]' : 'translate-y-0'">

        {{-- Sidebar Footer (Links & Text) --}}
        @if($sfEnabled)
        <div class="px-5 py-5 border-b border-surface-100 dark:border-surface-800/50 bg-surface-50/30 dark:bg-surface-800/10">
            @if($sfLinks)
            <div class="grid grid-cols-2 gap-x-4 gap-y-2 mb-4">
                @foreach($sfLinks as $link)
                <a href="{{ $link['url'] }}" wire:navigate class="text-[11px] font-medium text-surface-400 hover:text-primary-500 transition-all flex items-center gap-1.5 group/link">
                    <span class="w-1 h-1 rounded-full bg-surface-300 dark:bg-surface-700 group-hover/link:bg-primary-500 transition-colors"></span>
                    {{ $link['label'] }}
                </a>
                @endforeach
            </div>
            @endif
            @if($sfDesc)
            <div class="pt-3 border-t border-surface-100 dark:border-surface-800/50">
                <p class="text-[10px] text-surface-400 leading-relaxed text-justify opacity-80">{{ $sfDesc }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- بنر تبلیغاتی داینامیک (Advertisement Model) --}}
        <div x-data="{
            ad: null,
            async fetchAd() {
                try {
                    const r = await fetch('/api/banner-ad');
                    const d = await r.json();
                    this.ad = d.ad;
                } catch(e) { this.ad = null; }
            },
            trackClick() {
                if (!this.ad) return;
                fetch('/api/ad-click', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ad_id: this.ad.id })
                });
            }
        }" x-init="fetchAd()" x-show="ad" class="p-3 pb-0">
            <div class="rounded-xl overflow-hidden relative group border border-surface-200 dark:border-surface-800">
                <template x-if="ad && ad.image_url">
                    <a :href="ad.click_url || ad.button_url || '#'"
                       @click="trackClick()"
                       :target="ad.click_url || ad.button_url ? '_blank' : '_self'"
                       class="block">
                        <img :src="ad.image_url" :alt="ad.title" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-4">
                            <p class="text-white text-sm font-bold" x-text="ad.title"></p>
                            <p x-show="ad.description" class="text-white/80 text-[10px] mt-1 line-clamp-1" x-text="ad.description"></p>
                            <span x-show="ad.button_text" class="mt-2 inline-block w-fit px-3 py-1 bg-primary-500 text-white text-[10px] font-bold rounded-lg" x-text="ad.button_text"></span>
                        </div>
                    </a>
                </template>
            </div>
        </div>

        {{-- بنر هنرمند شو --}}
        @if($abEnabled && auth()->user()->isListener())
        <div class="p-3 pb-0">
            <div class="rounded-xl p-4 text-center {{ !$abImg && !$abFrom ? 'bg-gradient-to-br from-violet-500 to-fuchsia-600' : '' }}" style="{{ $abStyle }} color:{{ $abColor }};">
                <p class="text-sm font-bold mb-1">{{ $abTitle }}</p>
                <p class="text-xs opacity-90 mb-3">{{ $abSub }}</p>
                <a href="{{ $abUrl }}" wire:navigate class="block w-full py-2 rounded-lg text-sm font-medium transition-colors" style="background:color-mix(in srgb,{{ $abColor }} 20%,transparent);color:{{ $abColor }};">
                    {{ $abBtn }}
                </a>
            </div>
        </div>
        @endif

        {{-- بنر پریمیوم --}}
        @if($pbEnabled && !auth()->user()->isPremium())
        <div class="p-3">
            <div class="rounded-xl p-4 text-center {{ !$pbImg && !$pbFrom ? 'gradient-primary' : '' }}" style="{{ $pbStyle }} color:{{ $pbColor }};">
                <p class="text-sm font-bold mb-1">{{ $pbTitle }}</p>
                <p class="text-xs opacity-90 mb-3">{{ $pbSub }}</p>
                <a href="{{ $pbUrl }}" wire:navigate class="block w-full py-2 rounded-lg text-sm font-medium transition-colors" style="background:color-mix(in srgb,{{ $pbColor }} 20%,transparent);color:{{ $pbColor }};">
                    {{ $pbBtn }}
                </a>
            </div>
        </div>
        @endif

    </div>
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
                @if($siteLogo)
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" 
                         style="height: {{ min($logoHeight, 60) }}px; max-height: 80px;" 
                         class="w-auto object-contain">
                @else
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-white flex-shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                @endif
                
                @if($showSiteName)
                    <span class="text-xl font-bold font-display text-gradient">{{ $siteName }}</span>
                @endif
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

            <a href="{{ url('/playlists') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                {{ request()->is('playlists*') ? 'bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h10M4 18h10m3-2v6m3-3H14"/>
                </svg>
                <span>پلی‌لیست‌ها</span>
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

                <a href="{{ url('/library/podcasts') }}" wire:navigate @click="mobileSidebar = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                    </svg>
                    <span>پادکست‌های من</span>
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

            {{-- Mobile Banners --}}
            @auth
                {{-- Sidebar Footer (Mobile) --}}
                @if($sfEnabled)
                <div class="px-4 py-5 mt-4 border-t border-surface-200 dark:border-surface-800 bg-surface-50/30 dark:bg-surface-800/20 rounded-2xl">
                    @if($sfLinks)
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 mb-3">
                        @foreach($sfLinks as $link)
                        <a href="{{ $link['url'] }}" wire:navigate @click="mobileSidebar = false" class="text-xs font-medium text-surface-400 hover:text-primary-500 transition-all flex items-center gap-2 group/mlink">
                            <span class="w-1 h-1 rounded-full bg-surface-300 dark:bg-surface-700 group-hover/mlink:bg-primary-500 transition-colors"></span>
                            {{ $link['label'] }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                    @if($sfDesc)
                    <div class="pt-2 border-t border-surface-100 dark:border-surface-800/50">
                        <p class="text-[10px] text-surface-400 leading-relaxed opacity-80">{{ $sfDesc }}</p>
                    </div>
                    @endif
                </div>
                @endif

                {{-- بنر هنرمند شو --}}
                @if($abEnabled && auth()->user()->isListener())
                <div class="pt-3 mt-2">
                    <div class="rounded-xl p-4 text-center {{ !$abImg && !$abFrom ? 'bg-gradient-to-br from-violet-500 to-fuchsia-600' : '' }}" style="{{ $abStyle }} color:{{ $abColor }};">
                        <p class="text-sm font-bold mb-1">{{ $abTitle }}</p>
                        <p class="text-xs opacity-90 mb-3">{{ $abSub }}</p>
                        <a href="{{ $abUrl }}" wire:navigate @click="mobileSidebar = false" class="block w-full py-2 rounded-lg text-sm font-medium transition-colors" style="background:color-mix(in srgb,{{ $abColor }} 20%,transparent);color:{{ $abColor }};">
                            {{ $abBtn }}
                        </a>
                    </div>
                </div>
                @endif

                {{-- بنر پریمیوم --}}
                @if($pbEnabled && !auth()->user()->isPremium())
                <div class="pt-3 mt-2 pb-4">
                    <div class="rounded-xl p-4 text-center {{ !$pbImg && !$pbFrom ? 'gradient-primary' : '' }}" style="{{ $pbStyle }} color:{{ $pbColor }};">
                        <p class="text-sm font-bold mb-1">{{ $pbTitle }}</p>
                        <p class="text-xs opacity-90 mb-3">{{ $pbSub }}</p>
                        <a href="{{ $pbUrl }}" wire:navigate @click="mobileSidebar = false" class="block w-full py-2 rounded-lg text-sm font-medium transition-colors" style="background:color-mix(in srgb,{{ $pbColor }} 20%,transparent);color:{{ $pbColor }};">
                            {{ $pbBtn }}
                        </a>
                    </div>
                </div>
                @endif
            @endauth
        </nav>
    </div>
</div>

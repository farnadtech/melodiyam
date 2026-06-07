<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Prevent browser-level caching for SPA-like Livewire pages --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ $title ?? $metaTitle ?? $siteName }} - {{ $siteName }}</title>
    <meta name="description" content="{{ $metaDescription ?? $siteDescription ?? '' }}">
    @if(!empty($metaKeywords))
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif

    @php
        $ts = \App\Models\Setting::getByGroup('theme');
    @endphp
    <script>
        (function() {
            var d = localStorage.getItem('theme_dark');
            if (d === null) d = 'true';
            if (d === 'true') document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Admin theme overrides — must come AFTER Vite CSS --}}
    <style>
        :root {
            --admin-primary:       {{ $ts['theme_primary']       ?? '#0ea5e9' }};
            --admin-accent:        {{ $ts['theme_accent']        ?? '#d946ef' }};
            --admin-gradient-from: {{ $ts['theme_gradient_from'] ?? '#0ea5e9' }};
            --admin-gradient-to:   {{ $ts['theme_gradient_to']   ?? '#d946ef' }};
            --admin-player-bg:     {{ $ts['theme_player_bg']     ?? '#1a1a2e' }};
            --admin-player-text:   {{ $ts['theme_player_text_light'] ?? '#ffffff' }};
            --admin-player-ctrl:   {{ $ts['theme_player_control']?? '#0ea5e9' }};
            --color-red-500:       {{ $ts['theme_danger']        ?? '#ef4444' }};
            --color-emerald-500:   {{ $ts['theme_success']       ?? '#10b981' }};
            --color-amber-500:     {{ $ts['theme_warning']       ?? '#f59e0b' }};
            /* Sidebar */
            --sidebar-text:        {{ $ts['theme_sidebar_text']        ?? '#64748b' }};
            --sidebar-active-bg:   {{ $ts['theme_sidebar_active_bg']   ?? '#0ea5e9' }};
            --sidebar-active-text: {{ $ts['theme_sidebar_active_text'] ?? '#ffffff' }};
            --sidebar-border:      {{ $ts['theme_sidebar_border']      ?? '#e2e8f0' }};
        }

        /* Light mode */
        html:not(.dark) {
            --color-surface-50:  {{ $ts['theme_bg_light']      ?? '#f8fafc' }};
            --color-surface-100: color-mix(in srgb, {{ $ts['theme_bg_light'] ?? '#f8fafc' }} 80%, white);
            --color-surface-200: color-mix(in srgb, {{ $ts['theme_bg_light'] ?? '#f8fafc' }} 50%, white);
            --color-surface-900: {{ $ts['theme_surface_light'] ?? '#0f172a' }};
            --color-surface-950: color-mix(in srgb, {{ $ts['theme_surface_light'] ?? '#0f172a' }} 80%, black);
            --sidebar-bg:        {{ $ts['theme_sidebar_bg_light']  ?? '#ffffff' }};
            --header-bg:         {{ $ts['theme_header_bg_light']   ?? '#ffffff' }};
            --header-border:     {{ $ts['theme_header_border']     ?? '#e2e8f0' }};
        }

        /* Dark mode */
        html.dark {
            --admin-player-text: {{ $ts['theme_player_text'] ?? '#ffffff' }};
            --color-surface-950: {{ $ts['theme_bg_dark']      ?? '#020617' }};
            --color-surface-900: {{ $ts['theme_surface_dark'] ?? '#0f172a' }};
            --color-surface-800: color-mix(in srgb, {{ $ts['theme_surface_dark'] ?? '#0f172a' }} 70%, white);
            --color-surface-50:  color-mix(in srgb, {{ $ts['theme_bg_dark'] ?? '#020617' }} 15%, white);
            --sidebar-bg:        {{ $ts['theme_sidebar_bg_dark']   ?? '#0f172a' }};
            --header-bg:         {{ $ts['theme_header_bg_dark']    ?? '#0f172a' }};
            --header-border:     color-mix(in srgb, {{ $ts['theme_header_border'] ?? '#e2e8f0' }} 20%, transparent);
        }

        .gradient-primary {
            background: linear-gradient(135deg, var(--admin-gradient-from), var(--admin-gradient-to)) !important;
        }
        #global-player-bar {
            background-color: var(--admin-player-bg) !important;
            color: var(--admin-player-text) !important;
            border-color: color-mix(in srgb, var(--admin-player-text) 12%, transparent) !important;
        }
        #global-player-bar .player-text { color: var(--admin-player-text) !important; }
        #global-player-bar .player-text-muted { color: color-mix(in srgb, var(--admin-player-text) 55%, transparent) !important; }
        #global-player-bar .player-icon { color: color-mix(in srgb, var(--admin-player-text) 50%, transparent) !important; }
        #global-player-bar .player-icon-active { color: var(--admin-player-ctrl) !important; }
        #global-player-bar .player-control-btn,
        #global-player-bar .player-btn { color: var(--admin-player-ctrl) !important; }
        #global-player-bar .player-btn:hover { background-color: color-mix(in srgb, var(--admin-player-text) 8%, transparent) !important; }
        #global-player-bar .player-progress-track { background-color: color-mix(in srgb, var(--admin-player-text) 15%, transparent) !important; }
        html.dark body  { background-color: {{ $ts['theme_bg_dark']   ?? '#020617' }} !important; }
        html:not(.dark) body { background-color: {{ $ts['theme_bg_light'] ?? '#f8fafc' }} !important; }

        /* Sidebar */
        #app-sidebar { background-color: var(--sidebar-bg) !important; border-color: var(--sidebar-border) !important; }
        #app-sidebar .sidebar-item { color: var(--sidebar-text) !important; }
        #app-sidebar .sidebar-item.active,
        #app-sidebar .sidebar-item[aria-current="page"] {
            background-color: var(--sidebar-active-bg) !important;
            color: var(--sidebar-active-text) !important;
        }
        /* Header */
        #app-header { background-color: var(--header-bg) !important; border-color: var(--header-border) !important; }

        /* Default content padding (overridden by layout manager when player opens) */
        @media (max-width: 1023px) {
            #main-content { padding-bottom: calc(60px + env(safe-area-inset-bottom, 0px) + 48px); }
        }
        @media (min-width: 1024px) {
            #main-content { padding-bottom: 24px; }
        }
    </style>
    <link rel="icon" href="{{ $siteFavicon ?? asset('images/favicon.ico') }}">
    <meta name="base-url" content="{{ url('/') }}">
    {{-- PWA --}}
    @if(\App\Models\Setting::get('pwa_enabled', '1'))
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="{{ \App\Models\Setting::get('pwa_theme_color', '#0ea5e9') }}">
    <script>
        // PWA early event capture & Service Worker registration
        window._pwaDeferredPrompt = null;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            window._pwaDeferredPrompt = e;
            window.dispatchEvent(new CustomEvent('pwa-prompt-available'));
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(reg) {
                    reg.update();
                }).catch(function() {});
            });
        }

        // Fix for iOS PWA opening links in Safari
        (function(document,navigator,standalone) {
            if ((standalone in navigator) && navigator[standalone]) {
                var curnode, location=document.location, stop=/^(a|html)$/i;
                document.addEventListener('click', function(e) {
                    curnode=e.target;
                    while (!(stop).test(curnode.nodeName)) {
                        curnode=curnode.parentNode;
                    }
                    if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) && (!curnode.classList.contains('no-pwa-fix'))) {
                        e.preventDefault();
                        location.href = curnode.href;
                    }
                },false);
            }
        })(document,window.navigator,'standalone');
    </script>
    @php $_appleIcon = \App\Models\Setting::get('pwa_icon_180'); @endphp
    @if($_appleIcon)
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . $_appleIcon) }}">
    @else
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/pwa-icon-180.png') }}">
    @endif
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    @endif
    @livewireStyles
    @if(!empty($googleAnalytics))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytics }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $googleAnalytics }}');</script>
    @endif
</head>
@if($maintenanceMode ?? false)
<body class="min-h-screen bg-surface-950 flex items-center justify-center">
    <div class="text-center text-white p-12">
        <svg class="w-16 h-16 mx-auto mb-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/></svg>
        <h1 class="text-3xl font-bold mb-3">{{ $siteName ?? config('app.name') }}</h1>
        <p class="text-surface-300 text-lg">{{ $maintenanceMessage ?? 'سایت در حال به‌روزرسانی است. لطفاً بعداً مراجعه کنید.' }}</p>
    </div>
</body>
@else
<body class="min-h-screen bg-surface-50 dark:bg-surface-950 antialiased overflow-hidden" x-data="{ toast: '{{ session('success') }}', toastType: 'success' }" x-init="if(toast) setTimeout(() => toast = '', 5000)">

    {{-- PWA Install Banner --}}
    @include('partials.pwa-banner')

    {{-- Global Toast --}}
    <div x-show="toast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] pointer-events-none" x-cloak>
        <div class="px-5 py-2.5 rounded-xl shadow-xl text-sm font-medium backdrop-blur" :class="toastType === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'" x-text="toast"></div>
    </div>

    <div class="flex h-screen" x-data="{ sidebarOpen: true, mobileSidebar: false }">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top Header --}}
            @include('partials.header')

            {{-- Verification Banner --}}
            @auth
            @php
                $_reqEmail = \App\Models\Setting::get('email_verification', '0') === '1';
                $_reqPhone = \App\Models\Setting::get('phone_verification', '0') === '1';
                $_u = auth()->user();
                $_needsVerify = ($_reqEmail && !$_u->email_verified_at) || ($_reqPhone && !$_u->phone_verified_at);
            @endphp
            @if($_needsVerify && !request()->routeIs('verify-account'))
            <div class="bg-amber-500/10 border-b border-amber-500/30 px-4 py-2.5 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2 text-sm text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>حساب شما نیاز به احراز هویت دارد.</span>
                </div>
                <a href="{{ route('verify-account') }}" class="btn-primary text-xs py-1.5 px-4 rounded-lg flex-shrink-0">احراز هویت</a>
            </div>
            @endif
            @endauth

            {{-- Main Content --}}
            <main id="main-content" class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- Mobile Navigation (always at screen bottom on mobile) --}}
    @include('partials.mobile-nav')

    {{-- Global Player (persisted across wire:navigate, sits above nav on mobile) --}}
    @persist('player')
    @include('partials.player')
    @endpersist

    {{-- Layout Manager: dynamic padding when player is open --}}
    <script>
    (function() {
        'use strict';

        var _lastPlayerState = null;
        var _layoutInterval = null;

        function updateLayout() {
            var main = document.getElementById('main-content');
            var nav = document.getElementById('mobile-bottom-nav');
            var playerBar = document.getElementById('global-player-bar');

            if (!main) return;

            var isMobile = window.innerWidth < 1024;
            var hasPlayer = false;

            try {
                hasPlayer = !!(window.Alpine && Alpine.store && Alpine.store('player') && Alpine.store('player').currentTrack);
            } catch(e) {}

            var playerWrap = document.getElementById('global-player-wrapper');
            var navHeight = (isMobile && nav) ? (nav.offsetHeight || 60) : 0;
            var playerHeight = (playerBar && hasPlayer) ? (playerBar.offsetHeight || 74) : 0;

            var safeArea = 0;
            try {
                var sat = getComputedStyle(document.documentElement).getPropertyValue('env(safe-area-inset-bottom)');
                if (sat) safeArea = parseInt(sat, 10) || 0;
            } catch(e) {}

            if (isMobile) {
                if (nav) nav.style.transform = 'translateY(0)';
                var navOffset = navHeight + safeArea;
                if (playerWrap) {
                    playerWrap.style.bottom = hasPlayer ? (navOffset + 'px') : '0px';
                }
                main.style.paddingBottom = (navHeight + playerHeight + safeArea + 48) + 'px';
            } else {
                if (nav) nav.style.transform = 'translateY(0)';
                if (playerWrap) playerWrap.style.bottom = '0px';
                main.style.paddingBottom = (hasPlayer ? (playerHeight + 24) : 24) + 'px';
            }

            _lastPlayerState = hasPlayer;
        }

        function startLayoutManager() {
            updateLayout();

            if (_layoutInterval) clearInterval(_layoutInterval);

            _layoutInterval = setInterval(function() {
                var currentState = false;
                try {
                    currentState = !!(window.Alpine && Alpine.store && Alpine.store('player') && Alpine.store('player').currentTrack);
                } catch(e) {}

                if (currentState !== _lastPlayerState || currentState) {
                    updateLayout();
                }
            }, 300);
        }

        window.addEventListener('resize', updateLayout);
        window.addEventListener('load', startLayoutManager);
        document.addEventListener('DOMContentLoaded', startLayoutManager);
        document.addEventListener('livewire:navigated', function() {
            setTimeout(startLayoutManager, 100);
        });
        document.addEventListener('alpine:initialized', startLayoutManager);
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) setTimeout(startLayoutManager, 50);
        });
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') updateLayout();
        });

        if (typeof ResizeObserver !== 'undefined') {
            var ro = new ResizeObserver(updateLayout);
            function attachObserver() {
                var player = document.getElementById('global-player-bar');
                var nav = document.getElementById('mobile-bottom-nav');
                if (player) ro.observe(player);
                if (nav) ro.observe(nav);
            }
            document.addEventListener('DOMContentLoaded', attachObserver);
            document.addEventListener('livewire:navigated', attachObserver);
        }
    })();
    </script>


    {{-- Anti-Cache Script: Force fresh content on every wire:navigate --}}
    <script>
    (function() {
        // Track auth state via CSRF token presence (auth pages have sessions)
        var _wasAuth = document.querySelector('meta[name="csrf-token"]') !== null;

        // On every Livewire navigation, force components to re-fetch fresh data
        document.addEventListener('livewire:navigated', function() {
            // Dispatch custom event so components can refresh stats
            window.dispatchEvent(new CustomEvent('page-content-refreshed'));
            // Refresh sidebar auth state after every navigation
            Livewire.dispatch('sidebar-navigated');
        });

        // Auth state guard: detect logout across wire:navigate SPA navigation
        (function() {
            var _authState = null; // null = not yet checked

            function checkAuthState() {
                fetch('/auth/state', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (_authState === null) {
                            _authState = data.authenticated;
                            return;
                        }
                        // Auth state changed → full reload to re-render sidebar
                        if (_authState !== data.authenticated) {
                            _authState = data.authenticated;
                            window.location.reload();
                        }
                    })
                    .catch(function() {});
            }

            // Check on first load
            checkAuthState();

            // Check after every SPA navigation
            document.addEventListener('livewire:navigated', checkAuthState);
        })();

        // Force full page reload on back/forward navigation (prevents stale cached pages)
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                window.location.reload();
            }
        });
    })();
    </script>
    @livewireScripts
    @stack('scripts')
</body>
@endif
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'پلتفرم استریم موسیقی فارسی - گوش دادن به بهترین موسیقی‌ها' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <meta name="base-url" content="{{ url('/') }}">
    {{-- PWA --}}
    @if(\App\Models\Setting::get('pwa_enabled', '1'))
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}">
    <meta name="msapplication-TileColor" content="{{ \App\Models\Setting::get('pwa_theme_color', '#0ea5e9') }}">
    <meta name="msapplication-navbutton-color" content="{{ \App\Models\Setting::get('pwa_theme_color', '#0ea5e9') }}">
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
                const swPath = '{{ url("/sw.js") }}';
                const scope = '{{ parse_url(url("/"), PHP_URL_PATH) ?: "/" }}';
                navigator.serviceWorker.register(swPath, { scope: scope }).then(function(reg) {
                    reg.update();
                }).catch(function(err) {
                    console.error('SW registration failed:', err);
                });
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
    <meta name="livewire-navigate-cache" content="off">
</head>
<body class="min-h-screen bg-surface-50 dark:bg-surface-950 antialiased overflow-hidden">

    {{-- PWA Install Banner --}}
    @include('partials.pwa-banner')

    <div class="flex h-screen" x-data="{ sidebarOpen: true, mobileSidebar: false }">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top Header --}}
            @include('partials.header')

            {{-- Main Content --}}
            <main id="main-content" class="flex-1 overflow-y-auto" style="padding-bottom: 0">
                {{-- Flash Messages --}}
                <div x-data="{ 
                    show: false, 
                    message: '', 
                    type: 'success',
                    init() {
                        @if(session('success'))
                            this.showFlash('{{ session('success') }}', 'success');
                        @endif
                        @if(session('error'))
                            this.showFlash('{{ session('error') }}', 'error');
                        @endif
                        @if(session('info'))
                            this.showFlash('{{ session('info') }}', 'info');
                        @endif
                        
                        window.addEventListener('flash-message', e => {
                            this.showFlash(e.detail.message, e.detail.type || 'success');
                        });
                    },
                    showFlash(msg, type) {
                        this.message = msg;
                        this.type = type;
                        this.show = true;
                        setTimeout(() => { this.show = false }, 5000);
                    }
                }" 
                x-show="show" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="fixed bottom-28 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-4 pointer-events-none"
                x-cloak>
                    <div class="px-5 py-3 rounded-2xl shadow-2xl backdrop-blur-xl border flex items-center gap-3 pointer-events-auto"
                         :class="{
                            'bg-emerald-500/90 border-emerald-400 text-white': type === 'success',
                            'bg-rose-500/90 border-rose-400 text-white': type === 'error',
                            'bg-blue-500/90 border-blue-400 text-white': type === 'info'
                         }">
                        <div class="flex-shrink-0">
                            <template x-if="type === 'success'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </template>
                            <template x-if="type === 'error'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <template x-if="type === 'info'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                        </div>
                        <p class="text-sm font-bold" x-text="message"></p>
                        <button @click="show = false" class="mr-auto opacity-70 hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- Global Player (z-100) --}}
    @include('partials.player')

    {{-- Mobile Navigation (z-90, moves up when player appears) --}}
    @include('partials.mobile-nav')

    {{-- Layout Manager Script --}}
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
            
            var navHeight = (isMobile && nav) ? (nav.offsetHeight || 60) : 0;
            var playerHeight = (playerBar && hasPlayer) ? (playerBar.offsetHeight || 74) : 0;
            
            // Safe area (iOS notch)
            var safeArea = 0;
            try {
                var sv = getComputedStyle(document.documentElement).getPropertyValue('--sat');
                if (sv) safeArea = parseInt(sv, 10) || 0;
            } catch(e) {}
            
            if (isMobile) {
                // Mobile: Nav moves up when player appears
                if (nav) {
                    nav.style.transform = hasPlayer ? 'translateY(-' + playerHeight + 'px)' : 'translateY(0)';
                }
                // Main content padding = nav + (player if visible) + safe area
                main.style.paddingBottom = (navHeight + playerHeight + safeArea + 8) + 'px';
            } else {
                // Desktop: No nav, only player
                if (nav) {
                    nav.style.transform = 'translateY(0)';
                }
                main.style.paddingBottom = (hasPlayer ? (playerHeight + 20) : 20) + 'px';
            }
            
            _lastPlayerState = hasPlayer;
        }
        
        function startLayoutManager() {
            updateLayout();
            
            if (_layoutInterval) clearInterval(_layoutInterval);
            
            // Poll every 300ms to detect player state changes
            _layoutInterval = setInterval(function() {
                var currentState = false;
                try {
                    currentState = !!(window.Alpine && Alpine.store && Alpine.store('player') && Alpine.store('player').currentTrack);
                } catch(e) {}
                
                if (currentState !== _lastPlayerState) {
                    updateLayout();
                }
            }, 300);
        }
        
        // Event listeners
        window.addEventListener('resize', updateLayout);
        window.addEventListener('load', startLayoutManager);
        document.addEventListener('DOMContentLoaded', startLayoutManager);
        document.addEventListener('livewire:navigated', function() { 
            setTimeout(startLayoutManager, 100); 
        });
        document.addEventListener('alpine:initialized', startLayoutManager);
        
        // ResizeObserver for player/nav dimension changes
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

    @livewireScripts
    @stack('scripts')
</body>
</html>

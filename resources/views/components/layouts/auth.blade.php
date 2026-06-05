<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'ورود' }} - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</title>
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
        // PWA early event capture
        window._pwaDeferredPrompt = null;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            window._pwaDeferredPrompt = e;
            // Dispatch custom event so app.js can show the banner if it's already loaded
            window.dispatchEvent(new CustomEvent('pwa-prompt-available'));
        });

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

    @php $ts = \App\Models\Setting::getByGroup('theme'); @endphp
    <script>
        (function() {
            var d = localStorage.getItem('theme_dark');
            if (d === null) d = 'true';
            if (d === 'true') document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="base-url" content="{{ url('/') }}">
    <style>
        :root {
            --admin-primary:       {{ $ts['theme_primary']       ?? '#0ea5e9' }};
            --admin-accent:        {{ $ts['theme_accent']        ?? '#d946ef' }};
            --admin-gradient-from: {{ $ts['theme_gradient_from'] ?? '#0ea5e9' }};
            --admin-gradient-to:   {{ $ts['theme_gradient_to']   ?? '#d946ef' }};
        }
        html:not(.dark) {
            --color-surface-50:  {{ $ts['theme_bg_light']      ?? '#f8fafc' }};
            --color-surface-900: {{ $ts['theme_surface_light'] ?? '#0f172a' }};
        }
        html.dark {
            --color-surface-950: {{ $ts['theme_bg_dark']      ?? '#020617' }};
            --color-surface-900: {{ $ts['theme_surface_dark'] ?? '#0f172a' }};
        }
        html.dark body { background-color: {{ $ts['theme_bg_dark']   ?? '#020617' }} !important; }
        html:not(.dark) body { background-color: {{ $ts['theme_bg_light'] ?? '#f8fafc' }} !important; }
        .gradient-primary { background: linear-gradient(135deg, var(--admin-gradient-from), var(--admin-gradient-to)) !important; }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen bg-surface-50 dark:bg-surface-950 flex items-center justify-center p-4">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                @php $logo = \App\Models\Setting::get('site_logo'); @endphp
                @if($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="logo" class="h-10 w-auto">
                @else
                <div class="w-12 h-12 rounded-2xl gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/25">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                    </svg>
                </div>
                @endif
                @if($showSiteName)
                <span class="text-2xl font-display font-extrabold text-gradient">{{ $siteName }}</span>
                @endif
            </a>
        </div>

        {{-- Content --}}
        <div class="bg-white dark:bg-surface-900 rounded-3xl shadow-xl border border-surface-200 dark:border-surface-800 p-8">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            --admin-player-text:   {{ $ts['theme_player_text']   ?? '#ffffff' }};
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
        }
        #global-player-bar .player-control-btn {
            color: var(--admin-player-ctrl) !important;
        }
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
    </style>
    <link rel="icon" href="{{ $siteFavicon ?? asset('images/favicon.ico') }}">
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

            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto pb-24">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- Global Player (persisted across wire:navigate) --}}
    @persist('player')
    @include('partials.player')
    @endpersist

    {{-- Mobile Navigation --}}
    @include('partials.mobile-nav')

    @livewireScripts
    @stack('scripts')
</body>
@endif
</html>

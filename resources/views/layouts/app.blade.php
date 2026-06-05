<!DOCTYPE html>
<html lang="fa" dir="rtl" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'پلتفرم استریم موسیقی فارسی - گوش دادن به بهترین موسیقی‌ها' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    {{-- PWA --}}
    @if(\App\Models\Setting::get('pwa_enabled', '1'))
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="{{ \App\Models\Setting::get('pwa_theme_color', '#0ea5e9') }}">
    @php $_appleIcon = \App\Models\Setting::get('pwa_icon_180'); @endphp
    @if($_appleIcon)
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . $_appleIcon) }}">
    @else
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/pwa-icon-180.png') }}">
    @endif
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    @endif
</head>
<body class="min-h-screen bg-surface-50 dark:bg-surface-950 antialiased overflow-hidden">

    <div class="flex h-screen" x-data="{ sidebarOpen: true, mobileSidebar: false }">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top Header --}}
            @include('partials.header')

            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto pb-32 md:pb-6">
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

    {{-- Global Player --}}
    @include('partials.player')

    {{-- Mobile Navigation --}}
    @include('partials.mobile-nav')

    @livewireScripts
    @stack('scripts')
</body>
</html>

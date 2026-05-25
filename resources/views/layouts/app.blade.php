<!DOCTYPE html>
<html lang="fa" dir="rtl" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ملودیام' }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'پلتفرم استریم موسیقی فارسی - گوش دادن به بهترین موسیقی‌ها' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
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
            <main class="flex-1 overflow-y-auto pb-24">
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

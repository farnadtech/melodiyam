{{-- Mobile Bottom Navigation --}}
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 dark:bg-surface-900/95 backdrop-blur-xl border-t border-surface-200/50 dark:border-surface-800/50 safe-area-bottom">
    <div class="flex items-center justify-around py-2 px-2" x-data>
        <a href="{{ url('/') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-colors
            {{ request()->is('/') ? 'text-primary-500' : 'text-surface-400 dark:text-surface-500' }}">
            <svg class="w-5 h-5" fill="{{ request()->is('/') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-medium">خانه</span>
        </a>

        <a href="{{ url('/search') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-colors
            {{ request()->is('search*') ? 'text-primary-500' : 'text-surface-400 dark:text-surface-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <span class="text-[10px] font-medium">جستجو</span>
        </a>

        <a href="{{ url('/browse') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-colors
            {{ request()->is('browse*') ? 'text-primary-500' : 'text-surface-400 dark:text-surface-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="text-[10px] font-medium">مرور</span>
        </a>

        @auth
        <a href="{{ url('/library') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-colors
            {{ request()->is('library*') ? 'text-primary-500' : 'text-surface-400 dark:text-surface-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span class="text-[10px] font-medium">کتابخانه</span>
        </a>
        @else
        <a href="{{ url('/login') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-colors text-surface-400 dark:text-surface-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[10px] font-medium">ورود</span>
        </a>
        @endauth
    </div>
</nav>

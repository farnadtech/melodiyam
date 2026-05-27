<header class="sticky top-0 z-40 flex items-center justify-between px-4 lg:px-8 py-3 bg-white/80 dark:bg-surface-900/80 backdrop-blur-xl border-b border-surface-200/50 dark:border-surface-800/50">

    {{-- Right Side: Mobile menu + Search --}}
    <div class="flex items-center gap-3">
        {{-- Mobile Menu Toggle --}}
        <button @click="mobileSidebar = true" class="lg:hidden p-2 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            <svg class="w-5 h-5 text-surface-600 dark:text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Navigation arrows (desktop) --}}
        <div class="hidden lg:flex items-center gap-1">
            <button onclick="history.forward()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <svg class="w-5 h-5 text-surface-600 dark:text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <button onclick="history.back()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <svg class="w-5 h-5 text-surface-600 dark:text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Search Bar --}}
        <div class="hidden md:block relative">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="جستجوی آهنگ، هنرمند، آلبوم..."
                    class="w-64 lg:w-80 pr-10 pl-4 py-2.5 rounded-full text-sm
                           bg-surface-100 dark:bg-surface-800 border-0
                           text-surface-900 dark:text-surface-100
                           placeholder:text-surface-400 dark:placeholder:text-surface-500
                           focus:outline-none focus:ring-2 focus:ring-primary-500/50
                           transition-all duration-200"
                >
            </form>
        </div>
    </div>

    {{-- Left Side: Actions --}}
    <div class="flex items-center gap-2">
        {{-- Theme Toggle --}}
        <button
            @click="$store.theme.toggle()"
            class="p-2.5 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors"
            title="تغییر تم"
        >
            {{-- Sun icon (shown in dark mode = click to go light) --}}
            <svg class="w-5 h-5 text-amber-400 hidden dark:block" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            {{-- Moon icon (shown in light mode = click to go dark) --}}
            <svg class="w-5 h-5 text-surface-600 block dark:hidden" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        {{-- Notifications --}}
        @auth
        <div x-data="{ open: false, notifications: [], unreadCount: 0, loading: false }" x-init="
            fetch('{{ route('notifications.index') }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.ok ? r.json() : null)
                .then(d => { if(d) { notifications = d.notifications; unreadCount = d.unread_count; } });
        " class="relative">
            <button @click="open = !open" class="relative p-2.5 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <svg class="w-5 h-5 text-surface-600 dark:text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span x-show="unreadCount > 0" x-cloak class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
            </button>

            {{-- Dropdown --}}
            <div
                x-cloak
                x-show="open"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 top-full mt-2 w-80 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 z-50"
            >
                <div class="px-4 py-3 border-b border-surface-200 dark:border-surface-700 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-surface-900 dark:text-white">ناتیفیکیشن‌ها</h3>
                    <span x-show="unreadCount > 0" x-text="unreadCount + ' خوانده نشده'" class="text-xs text-rose-500 font-medium"></span>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    <template x-if="notifications.length === 0">
                        <div class="px-4 py-8 text-center text-sm text-surface-400">ناتیفیکیشنی ندارید</div>
                    </template>
                    <template x-for="notif in notifications" :key="notif.id">
                        <a :href="notif.url || '#'" @click="if(notif.url) open = false" class="block px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors border-b border-surface-100 dark:border-surface-700/50 last:border-0" :class="!notif.read_at && 'bg-primary-50/50 dark:bg-primary-900/20'">
                            <p class="text-sm font-medium text-surface-900 dark:text-white" x-text="notif.title"></p>
                            <p class="text-xs text-surface-500 mt-1" x-text="notif.message"></p>
                            <p class="text-[10px] text-surface-400 mt-1" x-text="notif.created_at"></p>
                        </a>
                    </template>
                </div>
                <div x-show="unreadCount > 0" class="px-4 py-2 border-t border-surface-200 dark:border-surface-700">
                    <button @click="
                        fetch('{{ route('notifications.read-all') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
                        }).then(() => { unreadCount = 0; notifications.forEach(n => n.read_at = new Date()); });
                    " class="w-full text-xs text-center text-primary-600 dark:text-primary-400 hover:text-primary-700 transition-colors">
                        علامت‌گذاری همه به عنوان خوانده شده
                    </button>
                </div>
            </div>
        </div>
        @endauth

        {{-- User Menu --}}
        @auth
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 p-1.5 pr-3 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <span class="text-sm font-medium text-surface-700 dark:text-surface-300">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-white text-xs font-bold">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
            </button>

            {{-- Dropdown --}}
            <div
                x-cloak
                x-show="open"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute left-0 top-full mt-2 w-56 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 py-2 z-50"
            >
                <a href="{{ url('/profile') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    پروفایل
                </a>
                <a href="{{ url('/settings') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    تنظیمات
                </a>
                @if(auth()->user()->isArtist())
                <a href="{{ url('/artist/dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    پنل هنرمند
                </a>
                @endif
                @if(auth()->user()->isAdmin())
                <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    پنل مدیریت
                </a>
                @endif
                <hr class="my-2 border-surface-200 dark:border-surface-700">
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        خروج
                    </button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ url('/login') }}" wire:navigate class="btn-ghost text-sm">ورود</a>
        <a href="{{ url('/register') }}" wire:navigate class="btn-primary text-sm !py-2.5 !px-5">ثبت‌نام</a>
        @endauth
    </div>
</header>

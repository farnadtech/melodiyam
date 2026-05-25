<x-layouts.app title="پلی‌لیست‌ها">
    <div class="p-4 lg:p-8 space-y-10">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پلی‌لیست‌ها</h1>
            @auth
                <a href="{{ route('playlist.create') }}" wire:navigate class="btn-primary flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    پلی‌لیست جدید
                </a>
            @endauth
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- ── Admin Playlists Section ── --}}
        @if($featured->isNotEmpty())
            <section>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white">پلی‌لیست‌های ملودیام</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($featured as $playlist)
                        <a href="{{ route('playlist.show', $playlist) }}" wire:navigate
                            class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group {{ $playlist->is_featured ? 'ring-2 ring-amber-400/30' : '' }}">
                            <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                                <img src="{{ $playlist->cover_image ? asset('storage/'.$playlist->cover_image) : asset('images/default-playlist.png') }}"
                                    alt="{{ $playlist->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                @if($playlist->is_featured)
                                    <span class="absolute top-2 right-2 bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full">ویژه ⭐</span>
                                @endif
                            </div>
                            <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                            <p class="text-xs text-surface-500 mt-1">{{ $playlist->tracks_count }} آهنگ</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ── User Playlists Section ── --}}
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">پلی‌لیست‌های کاربران</h2>

            @if($userPlaylists->isEmpty())
                <div class="glass-card rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h10M4 18h10m3-2v6m3-3H14"/>
                    </svg>
                    <p class="text-surface-500 text-lg mb-4">هنوز پلی‌لیستی وجود ندارد</p>
                    @auth
                        <a href="{{ route('playlist.create') }}" wire:navigate class="btn-primary inline-block">اولین پلی‌لیست را بساز</a>
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($userPlaylists as $playlist)
                        <a href="{{ route('playlist.show', $playlist) }}" wire:navigate class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group">
                            <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                                <img src="{{ $playlist->cover_image ? asset('storage/'.$playlist->cover_image) : asset('images/default-playlist.png') }}"
                                    alt="{{ $playlist->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                            <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                            <p class="text-xs text-surface-500 mt-1">{{ $playlist->tracks_count }} آهنگ · {{ $playlist->user->name ?? '' }}</p>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $userPlaylists->links() }}</div>
            @endif
        </section>

    </div>
</x-layouts.app>

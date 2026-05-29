<x-layouts.app title="پلی‌لیست‌های من">
    <div class="p-4 lg:p-8 space-y-10">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پلی‌لیست‌های من</h1>
            <a href="{{ route('playlist.create') }}" wire:navigate class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                پلی‌لیست جدید
            </a>
        </div>

        {{-- My Playlists --}}
        <section>
            <h2 class="text-base font-bold text-surface-700 dark:text-surface-300 mb-3">ساخته‌شده توسط من</h2>
            @if($myPlaylists->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($myPlaylists as $playlist)
                        <a href="{{ route('playlist.show', $playlist) }}" wire:navigate class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group relative">
                            <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                                @php $cover = $playlist->cover_image ? asset('storage/'.$playlist->cover_image) : asset('images/default-playlist.png'); @endphp
                                {{-- Blurred background for non-square images --}}
                                <img src="{{ $cover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
                                {{-- Main image showing fully --}}
                                <img src="{{ $cover }}" alt="{{ $playlist->title }}" class="relative z-10 w-full h-full object-contain">
                                
                                @if($playlist->visibility === 'private')
                                    <span class="absolute top-2 left-2 bg-black/60 text-white text-xs px-1.5 py-0.5 rounded-full z-20">
                                        <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </span>
                                @endif
                            </div>
                            <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                            <p class="text-xs text-surface-500 mt-1">{{ $playlist->tracks_count }} آهنگ</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-surface-400 text-sm">هنوز پلی‌لیستی نساخته‌اید.</p>
            @endif
        </section>

        {{-- Saved (Liked) Playlists --}}
        <section>
            <h2 class="text-base font-bold text-surface-700 dark:text-surface-300 mb-3">ذخیره‌شده‌ها</h2>
            @if($savedPlaylists->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($savedPlaylists as $playlist)
                        <a href="{{ route('playlist.show', $playlist) }}" wire:navigate class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group">
                            <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                                @php $cover = $playlist->cover_image ? asset('storage/'.$playlist->cover_image) : asset('images/default-playlist.png'); @endphp
                                {{-- Blurred background for non-square images --}}
                                <img src="{{ $cover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
                                {{-- Main image showing fully --}}
                                <img src="{{ $cover }}" alt="{{ $playlist->title }}" class="relative z-10 w-full h-full object-contain">
                            </div>
                            <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                            <p class="text-xs text-surface-500 mt-1">{{ $playlist->tracks_count }} آهنگ · {{ $playlist->user->name ?? '' }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-surface-400 text-sm">هنوز پلی‌لیستی ذخیره نکرده‌اید.</p>
            @endif
        </section>

    </div>
</x-layouts.app>

<x-layouts.app title="آلبوم‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آلبوم‌های من</h1>

        @if($albums->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <p class="text-surface-500 text-lg">هنوز آلبومی پسند نکرده‌اید</p>
                <a href="{{ url('/browse') }}" wire:navigate class="btn-primary mt-4 inline-block">مرور آلبوم‌ها</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($albums as $album)
                    <a href="{{ route('album.show', $album) }}" wire:navigate class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group">
                        <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700">
                            @if($album->cover_image)
                                <img src="{{ asset('storage/'.$album->cover_image) }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                </div>
                            @endif
                        </div>
                        <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $album->title }}</p>
                        <p class="text-xs text-surface-500 truncate mt-1">{{ $album->artist->display_name ?? '' }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>

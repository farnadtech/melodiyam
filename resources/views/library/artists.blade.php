<x-layouts.app title="هنرمندان دنبال‌شده">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">هنرمندان</h1>

        @if($artists->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="text-surface-500 text-lg">هنوز هنرمندی دنبال نکرده‌اید</p>
                <a href="{{ url('/discover') }}" wire:navigate class="btn-primary mt-4 inline-block">کشف هنرمندان</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($artists as $artist)
                    <a href="{{ route('artist.show', $artist) }}" wire:navigate class="glass-card rounded-2xl p-4 text-center hover:scale-105 transition-transform">
                        <div class="w-20 h-20 rounded-full overflow-hidden mx-auto mb-3 bg-surface-200 dark:bg-surface-700">
                            <img src="{{ $artist->getAvatarUrl() }}" alt="{{ $artist->display_name }}" class="w-full h-full object-cover">
                        </div>
                        <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $artist->display_name }}</p>
                        <p class="text-xs text-surface-500 mt-1">{{ number_format($artist->followers_count) }} دنبال‌کننده</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>

<x-layouts.app title="آلبوم‌ها">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آلبوم‌ها</h1>
                <p class="text-surface-500 mt-1">مجموعه‌ای از بهترین آلبوم‌های موسیقی</p>
            </div>
            
            <x-sort-filters :currentSort="$sort" />
        </div>

        {{-- Albums Grid --}}
        @if($albums->isEmpty())
        <div class="text-center py-20 text-surface-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
            </svg>
            <p class="text-sm">هنوز آلبومی منتشر نشده</p>
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
            @foreach($albums as $album)
            <a href="{{ route('album.show', $album) }}" wire:navigate
               class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer block">
                <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                    @php $albumCover = $album->getCoverUrl(); @endphp
                    {{-- Blurred background for non-square images --}}
                    <img src="{{ $albumCover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
                    {{-- Main image showing fully --}}
                    <img src="{{ $albumCover }}" alt="{{ $album->title }}"
                         class="relative z-10 w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                        <svg class="w-10 h-10 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
                        </svg>
                    </div>
                    @if($album->is_explicit)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm z-10">18+</div>
                    @endif
                    @if($album->is_for_sale && $album->price)
                    <div class="absolute top-2 left-2 bg-primary-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                        {{ number_format($album->discount_price ?? $album->price) }} ت
                    </div>
                    @endif
                </div>
                <p class="font-semibold text-surface-900 dark:text-white text-sm truncate">{{ $album->title }}</p>
                <p class="text-xs text-surface-500 truncate mt-0.5">{{ $album->artist->display_name ?? '' }}</p>
                <div class="flex items-center justify-between mt-1.5">
                    <span class="text-xs text-surface-400">{{ $album->tracks_count }} آهنگ</span>
                    @if($album->release_date)
                    <span class="text-xs text-surface-400">{{ \App\Helpers\Jalali::format($album->release_date, 'Y') }}</span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($albums->hasPages())
        <div class="flex justify-center pt-4">
            {{ $albums->links() }}
        </div>
        @endif
        @endif

    </div>
</x-layouts.app>

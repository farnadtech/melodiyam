@props(['currentSort' => 'newest'])

@php
    $sortOptions = [
        'newest'        => 'جدیدترین ها',
        'most_played'   => 'پربازدیدترین ها',
        'most_popular'  => 'محبوب ترین ها',
        'most_comments' => 'پربحث ترین ها',
        'oldest'        => 'قدیمی ترین ها',
        'recommended'   => 'پیشنهادی ها',
    ];
    
    // Support aliases
    $aliases = [
        'play_count' => 'most_played',
        'like_count' => 'most_popular',
    ];
    $displaySort = $aliases[$currentSort] ?? $currentSort;
    $currentLabel = $sortOptions[$displaySort] ?? 'جدیدترین ها';
@endphp

<div class="flex items-center gap-3" x-data="{ 
    open: false,
    sort: '{{ $currentSort }}',
    updateSort(val) {
        if (typeof window.Livewire !== 'undefined') {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            window.Livewire.navigate(url.toString());
        } else {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            window.location.href = url.toString();
        }
    }
}" @click.away="open = false">
    <span class="text-sm text-surface-500">مرتب‌سازی بر اساس:</span>
    
    <div class="relative">
        <button 
            @click="open = !open" 
            class="flex items-center gap-2 px-4 py-2 bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-200 rounded-xl text-sm font-medium border border-surface-200 dark:border-surface-700 hover:bg-surface-200 dark:hover:bg-surface-700 transition-all"
        >
            <span>{{ $currentLabel }}</span>
            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 z-50 overflow-hidden"
            style="display: none;"
        >
            @foreach($sortOptions as $value => $label)
            <button 
                @click="updateSort('{{ $value }}')"
                class="w-full text-right px-4 py-2.5 text-sm hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors {{ $currentSort === $value ? 'text-primary-500 font-bold bg-primary-500/5' : 'text-surface-600 dark:text-surface-400' }}"
            >
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>
</div>

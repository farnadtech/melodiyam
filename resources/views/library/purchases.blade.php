<x-layouts.app title="خریدهای من">
<div class="p-4 lg:p-8 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">خریدهای من</h1>
            <p class="text-sm text-surface-500 mt-0.5">آهنگ‌ها و آلبوم‌های خریداری شده</p>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
        <p class="text-sm text-emerald-700 dark:text-emerald-400">{{ session('success') }}</p>
    </div>
    @endif

    @if($purchases->isEmpty())
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-12 text-center">
        <svg class="w-16 h-16 mx-auto mb-4 text-surface-300 dark:text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
        </svg>
        <p class="text-surface-500 dark:text-surface-400">هنوز خریدی انجام نداده‌اید</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-xl transition">
            کشف موسیقی
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($purchases as $sale)
        @php $item = $sale->saleable; @endphp
        @if($item)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden hover:shadow-lg transition-shadow group">
            {{-- Cover --}}
            <div class="aspect-square relative overflow-hidden">
                <img src="{{ $item->cover_image ? asset('storage/'.$item->cover_image) : asset('images/default-cover.png') }}"
                     alt="{{ $item->title }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    @if($item instanceof \App\Models\Track)
                    <button onclick="window.Alpine && Alpine.store('player').play({
                        id: {{ $item->id }},
                        title: '{{ addslashes($item->title) }}',
                        artist: '{{ addslashes($item->artist?->display_name ?? '') }}',
                        cover: '{{ $item->cover_image ? asset('storage/'.$item->cover_image) : asset('images/default-cover.png') }}',
                        url: '{{ $item->file_url ?: ($item->file_path ? asset('storage/'.$item->file_path) : '') }}'
                    })"
                    class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center">
                        <svg class="w-6 h-6 text-surface-900 mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    @else
                    <a href="{{ route('album.show', $item->slug) }}" class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center">
                        <svg class="w-6 h-6 text-surface-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @endif
                </div>
                {{-- Badge نوع --}}
                <div class="absolute top-2 right-2">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $item instanceof \App\Models\Track ? 'bg-primary-500/90 text-white' : 'bg-amber-500/90 text-white' }}">
                        {{ $item instanceof \App\Models\Track ? 'آهنگ' : 'آلبوم' }}
                    </span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-sm font-semibold text-surface-900 dark:text-white truncate">{{ $item->title }}</h3>
                <p class="text-xs text-surface-500 mt-0.5 truncate">
                    {{ $item instanceof \App\Models\Track ? $item->artist?->display_name : ($item->artist?->display_name . ' · ' . ($item->tracks_count ?? 0) . ' آهنگ') }}
                </p>
                <div class="flex items-center justify-between mt-3">
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
                        خریداری شده
                    </span>
                    <span class="text-xs text-surface-400">{{ number_format($sale->gross_amount) }} ت</span>
                </div>
                <p class="text-[10px] text-surface-400 mt-1">{{ $sale->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $purchases->links() }}
    </div>
    @endif

</div>
</x-layouts.app>

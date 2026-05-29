<x-layouts.app title="جستجو">
    <div class="p-4 lg:p-8 space-y-8">

        <div>
            <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">جستجو</h1>
        </div>

        {{-- Search box (mobile) --}}
        <div class="md:hidden">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative">
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="آهنگ، هنرمند، آلبوم..." class="input-field pr-11" autofocus>
                </div>
            </form>
        </div>

        @if(!empty($query) && !empty($results))

            {{-- Tracks --}}
            @if(isset($results['tracks']) && $results['tracks']->isNotEmpty())
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white">آهنگ‌ها</h2>
                </div>
                
                <x-sort-filters :currentSort="$sort" />

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($results['tracks'] as $track)
                        @include('components.track-card', ['track' => $track])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Artists --}}
            @if(isset($results['artists']) && $results['artists']->isNotEmpty())
            <section>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">هنرمندان</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($results['artists'] as $artist)
                        @include('components.artist-card', ['artist' => $artist])
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Albums --}}
            @if(isset($results['albums']) && $results['albums']->isNotEmpty())
            <section>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">آلبوم‌ها</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($results['albums'] as $album)
                        @include('components.album-card', ['album' => $album])
                    @endforeach
                </div>
            </section>
            @endif

            @if(collect($results)->every(fn($r) => $r->isEmpty()))
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-surface-300 dark:text-surface-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-surface-500 text-lg">نتیجه‌ای برای «{{ $query }}» یافت نشد</p>
            </div>
            @endif

        @elseif(empty($query))
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-surface-300 dark:text-surface-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-surface-500 text-lg">عبارتی برای جستجو وارد کنید</p>
            </div>
        @endif
    </div>
</x-layouts.app>

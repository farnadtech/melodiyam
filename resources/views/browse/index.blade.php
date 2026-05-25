<x-layouts.app title="مرور موسیقی">
    <div class="p-4 lg:p-8 space-y-8">

        <div>
            <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">مرور موسیقی</h1>
            <p class="text-surface-500 mt-1">ژانرها و محبوب‌ترین آهنگ‌ها را کشف کنید</p>
        </div>

        {{-- Genres Grid --}}
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">ژانرها</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($genres as $genre)
                    @include('components.genre-card', ['genre' => $genre])
                @endforeach
            </div>
        </section>

        {{-- All Tracks --}}
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">محبوب‌ترین آهنگ‌ها</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($tracks as $track)
                    @include('components.track-card', ['track' => $track])
                @endforeach
            </div>
            <div class="mt-6">
                {{ $tracks->links() }}
            </div>
        </section>
    </div>
</x-layouts.app>

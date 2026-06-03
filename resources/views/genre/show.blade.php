<x-layouts.app :title="'سبک ' . $genre->title">
    <div class="p-4 lg:p-8 space-y-8">
        <div>
            <nav class="flex mb-4 text-sm text-surface-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 space-x-reverse">
                    <li><a href="{{ route('genre.index') }}" wire:navigate class="hover:text-primary-500 transition">ژانرها</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-surface-900 dark:text-white font-bold">{{ $genre->title }}</li>
                </ol>
            </nav>
            <h1 class="text-4xl font-black text-surface-900 dark:text-white">{{ $genre->title }}</h1>
            <p class="text-surface-500 mt-1">آرشیو تمامی آهنگ‌های سبک {{ $genre->title }}</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4 lg:gap-6">
            @foreach($tracks as $track)
                <x-track-card :track="$track" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $tracks->links() }}
        </div>
    </div>
</x-layouts.app>

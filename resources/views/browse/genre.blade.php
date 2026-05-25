<x-layouts.app :title="$genre->name_fa">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Genre Header --}}
        <div class="relative overflow-hidden rounded-3xl p-8 lg:p-12" style="background-color: {{ $genre->color ?? '#6366f1' }}">
            <div class="absolute inset-0 bg-gradient-to-l from-black/30 to-transparent"></div>
            <div class="relative z-10">
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-white">{{ $genre->name_fa }}</h1>
                <p class="text-white/80 mt-2">{{ $genre->name }}</p>
            </div>
        </div>

        {{-- Tracks --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($tracks as $track)
                @include('components.track-card', ['track' => $track])
            @endforeach
        </div>
        <div class="mt-6">{{ $tracks->links() }}</div>
    </div>
</x-layouts.app>

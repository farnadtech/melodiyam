<x-layouts.app title="ژانرها و دسته‌بندی‌ها">
    <div class="p-4 lg:p-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-surface-900 dark:text-white">ژانرها</h1>
                <p class="text-surface-500 mt-1">آهنگ‌ها را بر اساس سبک مورد علاقه خود پیدا کنید</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($genres as $genre)
            <a href="{{ route('genre.show', $genre) }}" wire:navigate 
               class="group relative aspect-square rounded-3xl overflow-hidden transition-all hover:scale-[1.02] active:scale-95 shadow-lg shadow-surface-900/5 bg-surface-100 dark:bg-surface-800"
               style="{{ $genre->color ? 'background-color: ' . $genre->color . ';' : '' }}">
                
                @if($genre->cover_image)
                <img src="{{ $genre->getCoverUrl() }}" alt="{{ $genre->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity">
                @endif

                <div class="absolute inset-0 bg-gradient-to-br from-black/20 to-black/60 group-hover:from-black/40 transition-colors z-10"></div>
                
                <div class="absolute inset-0 p-6 flex flex-col justify-end z-20">
                    <h3 class="text-xl font-black text-white leading-tight">{{ $genre->title }}</h3>
                    <p class="text-xs text-white/80 mt-1">{{ number_format($genre->tracks_count) }} آهنگ</p>
                </div>

                {{-- Decorative element --}}
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors"></div>
            </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>

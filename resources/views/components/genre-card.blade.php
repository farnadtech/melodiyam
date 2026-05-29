<a href="{{ route('browse.genre', $genre) }}" wire:navigate class="relative overflow-hidden rounded-xl p-4 h-24 flex items-center justify-center group transition-transform hover:scale-[1.02]" style="background-color: {{ $genre->color ?? '#6366f1' }}">
    @if($genre->cover_image)
    <img src="{{ asset('storage/' . $genre->cover_image) }}" alt="{{ $genre->name_fa }}" class="absolute inset-0 w-full h-full object-cover transition-transform group-hover:scale-110 duration-500">
    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>
    @else
    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
    @endif
    <div class="absolute -top-4 -left-4 w-16 h-16 bg-white/10 rounded-full blur-xl"></div>
    <div class="relative flex flex-col items-center gap-1 drop-shadow-lg text-center">
        <span class="text-white font-bold text-base">{{ $genre->name_fa }}</span>
        @if($showCount ?? false)
            <span class="text-[10px] text-white/80 font-medium bg-black/20 px-2 py-0.5 rounded-full backdrop-blur-sm">
                {{ number_format($genre->tracks_count ?? 0) }} آهنگ
            </span>
        @endif
    </div>
</a>

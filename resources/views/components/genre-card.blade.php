<a href="{{ route('browse.genre', $genre) }}" wire:navigate class="relative overflow-hidden rounded-xl p-4 h-24 flex items-end group transition-transform hover:scale-[1.02]" style="background-color: {{ $genre->color ?? '#6366f1' }}">
    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
    <div class="absolute -top-4 -left-4 w-16 h-16 bg-white/10 rounded-full blur-xl"></div>
    <span class="relative text-white font-bold text-sm">{{ $genre->name_fa }}</span>
</a>

<a href="{{ route('artist.show', $artist) }}" wire:navigate class="group text-center">
    <div class="relative mx-auto w-full aspect-square rounded-full overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
        <img
            src="{{ $artist->user->avatar ? asset('storage/' . $artist->user->avatar) : asset('images/default-avatar.png') }}"
            alt="{{ $artist->display_name }}"
            class="w-full h-full object-cover"
            loading="lazy"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </div>
    <p class="mt-3 text-sm font-medium text-surface-900 dark:text-surface-100 truncate group-hover:text-primary-500 transition-colors">
        {{ $artist->display_name }}
    </p>
    <p class="text-xs text-surface-400">هنرمند</p>
</a>

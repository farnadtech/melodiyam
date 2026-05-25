<x-layouts.app :title="$playlist->title">
    <div class="p-4 lg:p-8 space-y-8">

        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : asset('images/default-playlist.png') }}" alt="{{ $playlist->title }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">پلی‌لیست</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $playlist->title }}</h1>
                @if($playlist->description)
                <p class="text-sm text-surface-500 mb-3">{{ $playlist->description }}</p>
                @endif
                <div class="flex items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <span>{{ $playlist->user->name ?? '' }}</span>
                    <span>·</span>
                    <span>{{ $playlist->tracks->count() }} آهنگ</span>
                </div>

                @if($playlist->tracks->isNotEmpty())
                <div class="flex items-center gap-3 mt-5" x-data>
                    <button
                        @click="$store.player.playQueue([
                            @foreach($playlist->tracks as $track)
                            { id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }} }{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        ], 0)"
                        class="w-12 h-12 rounded-full bg-primary-500 hover:bg-primary-400 hover:scale-105 flex items-center justify-center shadow-lg shadow-primary-500/30 transition-all"
                    >
                        <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <button
                        @click="let tracks = [
                            @foreach($playlist->tracks as $track)
                            { id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }} }{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        ]; let shuffled = [...tracks].sort(() => Math.random() - 0.5); $store.player.playQueue(shuffled, 0)"
                        class="w-12 h-12 rounded-full bg-surface-100 dark:bg-surface-800 hover:bg-surface-200 dark:hover:bg-surface-700 flex items-center justify-center transition-colors"
                        title="پخش تصادفی"
                    >
                        <svg class="w-5 h-5 text-surface-600 dark:text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                    </button>
                </div>
                @endif
            </div>
        </div>

        {{-- Track List --}}
        <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
            @foreach($playlist->tracks as $i => $track)
            <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group" x-data>
                <span class="text-sm text-surface-400 w-6 text-center">{{ $i + 1 }}</span>
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                    <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 hover:text-primary-500 truncate block">{{ $track->title }}</a>
                    <p class="text-xs text-surface-400 truncate">{{ $track->artist->display_name ?? '' }}</p>
                </div>
                <span class="text-xs text-surface-400">{{ $track->formattedDuration() }}</span>
                <button
                    @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }} })"
                    class="opacity-0 group-hover:opacity-100 w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center transition-opacity"
                >
                    <svg class="w-3.5 h-3.5 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>

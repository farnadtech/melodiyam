@php
    $cfg = $section->config ?? [];
    $artistId = $cfg['artist_id'] ?? null;
    $spotlightText = $cfg['spotlight_text'] ?? null;

    $artist = $artistId ? \App\Models\Artist::with('tracks')->find($artistId) : null;
    if (!$artist) return;

    $topTracks = $artist->tracks()->published()->orderByDesc('play_count')->take(5)->get();
@endphp

<section>
    <div class="rounded-2xl overflow-hidden bg-gradient-to-l from-primary-600/10 to-accent-600/10 dark:from-primary-900/30 dark:to-accent-900/30 border border-primary-200/50 dark:border-primary-800/50">
        <div class="flex flex-col md:flex-row gap-6 p-6 lg:p-8">
            {{-- Artist Info --}}
            <div class="flex flex-col items-center md:items-start gap-4 md:w-64 flex-shrink-0">
                <a href="{{ route('artist.show', $artist->slug) }}" wire:navigate>
                    <img src="{{ $artist->avatar_url ?? asset('images/default-artist.png') }}"
                         class="w-32 h-32 rounded-full object-cover ring-4 ring-primary-500/30 shadow-xl" alt="{{ $artist->display_name }}">
                </a>
                <div class="text-center md:text-right">
                    <div class="text-xs text-primary-500 font-medium mb-1">{{ $section->title_fa }}</div>
                    <h3 class="text-2xl font-bold text-surface-900 dark:text-white">{{ $artist->display_name }}</h3>
                    @if($artist->followers_count)
                    <p class="text-sm text-surface-500 mt-1">{{ number_format($artist->followers_count) }} دنبال‌کننده</p>
                    @endif
                </div>
                @if($spotlightText)
                <p class="text-sm text-surface-600 dark:text-surface-400 text-center md:text-right leading-relaxed">
                    {{ $spotlightText }}
                </p>
                @endif
                <a href="{{ route('artist.show', $artist->slug) }}" wire:navigate
                   class="btn-primary text-sm px-5 py-2">
                    مشاهده پروفایل
                </a>
            </div>

            {{-- Top Tracks --}}
            @if($topTracks->isNotEmpty())
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-surface-500 mb-3 uppercase tracking-wider">محبوب‌ترین آهنگ‌ها</h4>
                <div class="space-y-1">
                    @foreach($topTracks as $i => $track)
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-white/50 dark:hover:bg-white/5 transition cursor-pointer"
                         x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$artist->display_name,'cover'=>$track->cover_url,'url'=>$track->stream_url]) }})">
                        <span class="text-surface-400 text-xs w-4 text-center">{{ $i + 1 }}</span>
                        <img src="{{ $track->cover_url ?? asset('images/default-cover.png') }}" class="w-9 h-9 rounded-lg object-cover" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $track->title }}</p>
                        </div>
                        <span class="text-xs text-surface-400">{{ gmdate('i:s', $track->duration ?? 0) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

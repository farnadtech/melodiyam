<x-layouts.app title="دانلودها">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">دانلودها</h1>
            
            <div class="flex items-center gap-2">
                @if($items->isNotEmpty())
                    @php
                        $playerTracks = $items->map(function($item) {
                            $t = $item->downloadable;
                            if (!$t) return null;
                            $isEpisode = $t instanceof \App\Models\PodcastEpisode;
                            return [
                                'id' => $isEpisode ? 'episode-' . $t->id : $t->id,
                                'title' => $t->title,
                                'artist' => $isEpisode ? ($t->podcast->artist->display_name ?? '') : ($t->artist->display_name ?? ''),
                                'url' => $t->getStreamUrl(),
                                'cover' => $t->getCoverUrl(),
                                'duration' => $t->duration,
                                'canPlay' => true,
                                'isPremium' => (bool) $t->is_premium_only,
                                'previewSeconds' => (bool) $t->is_premium_only ? (int) \App\Models\Setting::get('premium_preview_seconds', 30) : 0
                            ];
                        })->filter()->values()->toArray();
                    @endphp
                    <button 
                        @click="$store.player.playQueue({{ json_encode($playerTracks) }})"
                        class="btn-primary !rounded-full gap-2 px-6"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش همه
                    </button>
                    <button 
                        @click="$store.player.isShuffled = true; $store.player.playQueue({{ json_encode($playerTracks) }}.sort(() => Math.random() - 0.5))"
                        class="p-2.5 rounded-full border border-surface-200 dark:border-surface-700 text-surface-600 dark:text-surface-400 hover:text-primary-500 hover:border-primary-500 transition-all"
                        title="پخش تصادفی"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                @endif
            </div>
        </div>

        <x-sort-filters :currentSort="$sort" />

        @if($items->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800">
            @foreach($items as $item)
                @php 
                    $track = $item->downloadable;
                    if(!$track) continue;
                    $isEpisode = $track instanceof \App\Models\PodcastEpisode;
                    $isPremiumOnly = (bool) $track->is_premium_only;
                    $isPremiumUser = auth()->user()?->isPremium() ?? false;
                    $premiumPreviewSec = $isPremiumOnly && !$isPremiumUser
                        ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                        : 0;
                    $artistName = $isEpisode ? ($track->podcast->artist->display_name ?? 'نامشخص') : ($track->artist->display_name ?? 'نامشخص');
                @endphp
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group">
                    <div class="relative w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                        <button 
                            @click="$store.player.play({ 
                                id: '{{ $isEpisode ? 'episode-' . $track->id : $track->id }}', 
                                title: '{{ e($track->title) }}', 
                                artist: '{{ e($artistName) }}', 
                                url: '{{ $track->getStreamUrl() }}', 
                                cover: '{{ $track->getCoverUrl() }}', 
                                duration: {{ $track->duration }}, 
                                canPlay: {{ $isPremiumOnly && !$isPremiumUser ? 'false' : 'true' }}, 
                                isPremium: {{ $isPremiumOnly ? 'true' : 'false' }}, 
                                previewSeconds: {{ $premiumPreviewSec }} 
                            })"
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate block">{{ $track->title }}</span>
                            @if($isEpisode)
                            <span class="px-1.5 py-0.5 rounded bg-surface-100 dark:bg-surface-700 text-[10px] text-surface-500">پادکست</span>
                            @endif
                        </div>
                        <span class="text-xs text-surface-400 truncate block">{{ $artistName }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs text-surface-400 font-mono">{{ $track->formattedDuration() }}</span>
                        <a href="{{ $isEpisode ? route('podcast.episode.download', $track) : route('track.download', $track) }}" class="text-surface-400 hover:text-primary-500 transition-colors" title="دانلود مجدد">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
        @else
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <p class="text-surface-500 text-lg">هنوز موردی دانلود نکرده‌اید</p>
            @unless(auth()->user()->isPremium())
                <p class="text-surface-400 text-sm mt-2">دانلود آفلاین مخصوص کاربران پریمیوم است</p>
                <a href="{{ url('/premium') }}" wire:navigate class="btn-primary mt-4 inline-block">ارتقا به پریمیوم</a>
            @else
                <a href="{{ route('browse') }}" wire:navigate class="btn-primary mt-4 inline-block">مشاهده آهنگ‌ها</a>
            @endunless
        </div>
        @endif
    </div>
</x-layouts.app>

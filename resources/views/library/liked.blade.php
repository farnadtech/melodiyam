<x-layouts.app title="آهنگ‌های مورد علاقه">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آهنگ‌های مورد علاقه</h1>
            
            <div class="flex items-center gap-2">
                @if($tracks->isNotEmpty())
                    @php
                        $playerTracks = $tracks->map(fn($t) => [
                            'id' => $t->id,
                            'title' => $t->title,
                            'artist' => $t->artist->display_name ?? '',
                            'url' => $t->getStreamUrl(),
                            'cover' => $t->getCoverUrl(),
                            'duration' => $t->duration,
                            'canPlay' => true,
                            'isPremium' => (bool) $t->is_premium_only,
                            'previewSeconds' => (bool) $t->is_premium_only ? (int) \App\Models\Setting::get('premium_preview_seconds', 30) : 0
                        ])->values()->toArray();
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

        @if($tracks->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800">
            @foreach($tracks as $track)
                @php
                    $isPremiumOnly = (bool) $track->is_premium_only;
                    $isPremiumUser = auth()->user()?->isPremium() ?? false;
                    $premiumPreviewSec = $isPremiumOnly && !$isPremiumUser
                        ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                        : 0;
                @endphp
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group">
                    <div class="relative w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                        <button 
                            @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }}, canPlay: {{ $isPremiumOnly && !$isPremiumUser ? 'false' : 'true' }}, isPremium: {{ $isPremiumOnly ? 'true' : 'false' }}, previewSeconds: {{ $premiumPreviewSec }} })"
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate block hover:text-primary-500 transition-colors">{{ $track->title }}</a>
                        <a href="{{ route('artist.show', $track->artist ?? '') }}" wire:navigate class="text-xs text-surface-400 truncate hover:text-primary-500 transition-colors">{{ $track->artist->display_name ?? 'نامشخص' }}</a>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs text-surface-400 font-mono">{{ $track->formattedDuration() }}</span>
                        @auth
                        <button @click="
                            fetch('{{ route('like.toggle') }}', {
                                method: 'POST',
                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                                body: JSON.stringify({type: 'track', id: {{ $track->id }}})
                            }).then(r => r.json()).then(d => { if(!d.liked) $el.closest('.flex.items-center.gap-4').parentElement.remove() })
                        " class="text-rose-500 hover:scale-110 transition-transform" title="حذف از علاقه‌مندی‌ها">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
        @else
        <div class="text-center py-16">
            <p class="text-surface-500">هنوز آهنگی لایک نکرده‌اید</p>
            <a href="{{ route('browse') }}" wire:navigate class="btn-primary mt-4 inline-block">مشاهده آهنگ‌ها</a>
        </div>
        @endif
    </div>
</x-layouts.app>

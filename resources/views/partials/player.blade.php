{{-- Global Music Player --}}
<div
    x-data="{ showQueue: false }"
    x-cloak
    x-show="$store.player.currentTrack"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full"
    x-transition:enter-end="translate-y-0"
    class="fixed bottom-0 inset-x-0 z-50"
>
    <div id="global-player-bar" class="bg-white/95 dark:bg-surface-900/95 backdrop-blur-xl border-t border-surface-200/50 dark:border-surface-800/50 px-3 lg:px-4 py-2 lg:py-3">

        {{-- Desktop Player --}}
        <div class="hidden lg:flex items-center gap-4 max-w-screen-2xl mx-auto">

            {{-- Track Info (Right) --}}
            <div class="flex items-center gap-3 w-72 min-w-0">
                <div class="w-14 h-14 rounded-lg overflow-hidden shadow-md flex-shrink-0">
                    <img
                        x-bind:src="$store.player.currentTrack?.cover || '/images/default-cover.png'"
                        class="w-full h-full object-cover"
                        alt=""
                    >
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate" x-text="$store.player.currentTrack?.title || ''"></p>
                    <p class="text-xs text-surface-500 dark:text-surface-400 truncate" x-text="$store.player.currentTrack?.artist || ''"></p>
                </div>
                {{-- Like button --}}
                <button
                    x-data="{ liked: false, loading: false }"
                    x-effect="if ($store.player.currentTrack?.id) {
                        fetch('/like/check?type=track&id=' + $store.player.currentTrack.id)
                            .then(r => r.json()).then(d => liked = d.liked).catch(() => {});
                    }"
                    @click="if (!$store.player.currentTrack?.id || loading) return;
                        loading = true;
                        fetch('/like/toggle', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}'},
                            body: JSON.stringify({type: 'track', id: $store.player.currentTrack.id})
                        }).then(r => r.json()).then(d => { liked = d.liked; loading = false; }).catch(() => loading = false)"
                    class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors flex-shrink-0"
                >
                    <svg x-show="!liked" class="w-4 h-4 text-surface-400 hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <svg x-show="liked" class="w-4 h-4 text-rose-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>

            {{-- Player Controls (Center) --}}
            <div class="flex-1 flex flex-col items-center gap-1.5 max-w-xl mx-auto">
                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    {{-- Shuffle --}}
                    <button @click="$store.player.toggleShuffle()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                        <svg class="w-4 h-4" :class="$store.player.isShuffled ? 'text-primary-500' : 'text-surface-400'" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.59 9.17L5.41 4 4 5.41l5.17 5.17 1.42-1.41zM14.5 4l2.04 2.04L4 18.59 5.41 20 17.96 7.46 20 9.5V4h-5.5zm.33 9.41l-1.41 1.41 3.13 3.13L14.5 20H20v-5.5l-2.04 2.04-3.13-3.13z"/>
                        </svg>
                    </button>

                    {{-- Previous (RTL: arrow points right) --}}
                    <button @click="$store.player.previous()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                        <svg class="w-5 h-5 text-surface-700 dark:text-surface-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/>
                        </svg>
                    </button>

                    {{-- Play/Pause --}}
                    <button @click="$store.player.toggle()" class="w-10 h-10 rounded-full bg-surface-900 dark:bg-white flex items-center justify-center hover:scale-105 transition-transform shadow-lg">
                        <svg x-show="!$store.player.isPlaying" class="w-5 h-5 text-white dark:text-surface-900 mr-[-2px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <svg x-show="$store.player.isPlaying" class="w-5 h-5 text-white dark:text-surface-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    {{-- Next (RTL: arrow points left) --}}
                    <button @click="$store.player.next()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                        <svg class="w-5 h-5 text-surface-700 dark:text-surface-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
                        </svg>
                    </button>

                    {{-- Repeat --}}
                    <button @click="$store.player.toggleRepeat()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors relative">
                        <svg class="w-4 h-4" :class="$store.player.repeatMode !== 'off' ? 'text-primary-500' : 'text-surface-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span x-show="$store.player.repeatMode === 'one'" class="absolute -top-0.5 -right-0.5 text-[9px] font-bold text-primary-500">۱</span>
                    </button>
                </div>

                {{-- Progress Bar --}}
                <div class="w-full flex items-center gap-2">
                    <span class="text-[11px] text-surface-400 w-10 text-left tabular-nums" x-text="$store.player.formattedCurrentTime"></span>
                    <div class="flex-1 relative group h-4 cursor-pointer flex items-center" @click="
                        let rect = $event.currentTarget.getBoundingClientRect();
                        let pct = (rect.right - $event.clientX) / rect.width;
                        pct = Math.max(0, Math.min(1, pct));
                        let a = $store.player.audio;
                        let dur = (a && a.duration && !isNaN(a.duration)) ? a.duration : 0;
                        if (dur > 0) { a.currentTime = pct * dur; }
                    ">
                        <div class="absolute inset-x-0 h-1.5 rounded-full bg-surface-200 dark:bg-surface-700 pointer-events-none"></div>
                        <div class="absolute inset-y-0 right-0 h-1.5 top-1/2 -translate-y-1/2 rounded-full bg-primary-500 group-hover:bg-primary-400 transition-colors pointer-events-none" :style="`width: ${$store.player.progress}%`"></div>
                        <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-primary-500 shadow-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" :style="`right: calc(${$store.player.progress}% - 6px)`"></div>
                    </div>
                    <span class="text-[11px] text-surface-400 w-10 tabular-nums" x-text="$store.player.formattedDuration"></span>
                </div>
            </div>

            {{-- Volume & Extra (Left) --}}
            <div class="flex items-center gap-2 w-48 justify-end">
                {{-- Queue --}}
                <button @click="showQueue = !showQueue" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors" :class="showQueue && 'text-primary-500 bg-surface-100 dark:bg-surface-800'">
                    <svg class="w-4 h-4" :class="showQueue ? 'text-primary-500' : 'text-surface-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10m-10 4h6"/>
                    </svg>
                </button>

                {{-- Volume --}}
                <button @click="$store.player.toggleMute()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    <svg x-show="!$store.player.isMuted && $store.player.volume > 50" class="w-4 h-4 text-surface-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                    </svg>
                    <svg x-show="!$store.player.isMuted && $store.player.volume <= 50 && $store.player.volume > 0" class="w-4 h-4 text-surface-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM5 9v6h4l5 5V4L9 9H5z"/>
                    </svg>
                    <svg x-show="$store.player.isMuted || $store.player.volume === 0" class="w-4 h-4 text-surface-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                    </svg>
                </button>

                {{-- Volume Slider --}}
                <div class="w-20 relative group h-4 cursor-pointer flex items-center" @click="let rect = $event.currentTarget.getBoundingClientRect(); let pct = (rect.right - $event.clientX) / rect.width; $store.player.setVolume(Math.round(Math.max(0, Math.min(1, pct)) * 100))">
                    <div class="absolute inset-x-0 h-1 rounded-full bg-surface-200 dark:bg-surface-700 pointer-events-none"></div>
                    <div class="absolute right-0 h-1 rounded-full bg-surface-500 group-hover:bg-primary-500 transition-colors pointer-events-none" :style="`width: ${$store.player.volume}%`"></div>
                </div>

                {{-- Fullscreen --}}
                <button @click="$store.player.isFullscreen = !$store.player.isFullscreen" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    <svg class="w-4 h-4 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                    </svg>
                </button>

                {{-- Close Player --}}
                <button @click="$store.player.stop()" class="p-2 rounded-full hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors" title="بستن پلیر">
                    <svg class="w-4 h-4 text-surface-400 hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>

        {{-- Mobile Player --}}
        <div class="lg:hidden space-y-2 relative">
            {{-- Close button (top-left corner) --}}
            <button @click="$store.player.stop()" class="absolute -top-5 left-1 p-1 rounded-full bg-surface-200 dark:bg-surface-700 hover:bg-rose-100 dark:hover:bg-rose-900/30 shadow transition-colors z-10" title="بستن پلیر">
                <svg class="w-3.5 h-3.5 text-surface-500 hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            {{-- Track info + controls --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                    <img x-bind:src="$store.player.currentTrack?.cover || '/images/default-cover.png'" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-surface-900 dark:text-white truncate" x-text="$store.player.currentTrack?.title"></p>
                    <p class="text-xs text-surface-400 truncate" x-text="$store.player.currentTrack?.artist"></p>
                </div>
                {{-- Shuffle --}}
                <button @click="$store.player.toggleShuffle()" class="p-1.5">
                    <svg class="w-4 h-4" :class="$store.player.isShuffled ? 'text-primary-500' : 'text-surface-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                </button>
                {{-- Previous --}}
                <button @click="$store.player.previous()" class="p-1.5">
                    <svg class="w-5 h-5 text-surface-600 dark:text-surface-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/></svg>
                </button>
                {{-- Play/Pause --}}
                <button @click="$store.player.toggle()" class="w-9 h-9 rounded-full bg-surface-900 dark:bg-white flex items-center justify-center flex-shrink-0">
                    <svg x-show="!$store.player.isPlaying" class="w-4 h-4 text-white dark:text-surface-900 mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg x-show="$store.player.isPlaying" class="w-4 h-4 text-white dark:text-surface-900" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>
                {{-- Next --}}
                <button @click="$store.player.next()" class="p-1.5">
                    <svg class="w-5 h-5 text-surface-600 dark:text-surface-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/></svg>
                </button>
                {{-- Repeat --}}
                <button @click="$store.player.toggleRepeat()" class="p-1.5 relative">
                    <svg class="w-4 h-4" :class="$store.player.repeatMode !== 'off' ? 'text-primary-500' : 'text-surface-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span x-show="$store.player.repeatMode === 'one'" class="absolute -top-0.5 -right-0.5 text-[8px] font-bold text-primary-500">۱</span>
                </button>
                {{-- Queue --}}
                <button @click="showQueue = !showQueue" class="p-1.5">
                    <svg class="w-4 h-4" :class="showQueue ? 'text-primary-500' : 'text-surface-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10m-10 4h6"/></svg>
                </button>
            </div>
            {{-- Progress Bar --}}
            <div class="flex items-center gap-2">
                <span class="text-[10px] text-surface-400 w-8 text-left tabular-nums" x-text="$store.player.formattedCurrentTime"></span>
                <div class="flex-1 relative group h-3 cursor-pointer flex items-center" @click="
                    let rect = $event.currentTarget.getBoundingClientRect();
                    let pct = (rect.right - $event.clientX) / rect.width;
                    pct = Math.max(0, Math.min(1, pct));
                    let a = $store.player.audio;
                    let dur = (a && a.duration && !isNaN(a.duration)) ? a.duration : 0;
                    if (dur > 0) { a.currentTime = pct * dur; }
                ">
                    <div class="absolute inset-x-0 h-1 rounded-full bg-surface-200 dark:bg-surface-700 pointer-events-none"></div>
                    <div class="absolute right-0 h-1 rounded-full bg-primary-500 pointer-events-none" :style="`width: ${$store.player.progress}%`"></div>
                </div>
                <span class="text-[10px] text-surface-400 w-8 tabular-nums" x-text="$store.player.formattedDuration"></span>
            </div>
        </div>

    </div>

    {{-- Queue Panel --}}
    <div
        x-show="showQueue"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click.away="showQueue = false"
        class="absolute bottom-full left-4 mb-2 w-80 max-h-96 bg-white dark:bg-surface-800 rounded-2xl shadow-2xl border border-surface-200 dark:border-surface-700 overflow-hidden"
    >
        <div class="px-4 py-3 border-b border-surface-200 dark:border-surface-700 flex items-center justify-between">
            <h3 class="text-sm font-bold text-surface-900 dark:text-white">صف پخش</h3>
            <span class="text-xs text-surface-400" x-text="$store.player.queue.length + ' آهنگ'"></span>
        </div>
        <div class="overflow-y-auto max-h-80 divide-y divide-surface-100 dark:divide-surface-700/50">
            <template x-if="$store.player.queue.length === 0">
                <div class="px-4 py-8 text-center text-sm text-surface-400">صف پخش خالی است</div>
            </template>
            <template x-for="(track, index) in $store.player.queue" :key="index">
                <button
                    @click="$store.player.queueIndex = index; $store.player.play($store.player.queue[index])"
                    class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors text-right"
                    :class="$store.player.queueIndex === index && 'bg-primary-50 dark:bg-primary-900/20'"
                >
                    <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0 relative">
                        <img :src="track.cover" class="w-full h-full object-cover" alt="">
                        <div x-show="$store.player.queueIndex === index && $store.player.isPlaying" class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate" :class="$store.player.queueIndex === index ? 'text-primary-500' : 'text-surface-900 dark:text-surface-100'" x-text="track.title"></p>
                        <p class="text-xs text-surface-400 truncate" x-text="track.artist"></p>
                    </div>
                    <span class="text-[11px] text-surface-400 tabular-nums" x-text="track.duration ? Math.floor(track.duration/60) + ':' + String(Math.floor(track.duration%60)).padStart(2,'0') : ''"></span>
                </button>
            </template>
        </div>
    </div>
</div>

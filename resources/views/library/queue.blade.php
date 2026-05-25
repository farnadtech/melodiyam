<x-layouts.app title="صف پخش">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">صف پخش</h1>

        <div class="glass-card rounded-2xl p-6"
            x-data="{ queue: $store.player.queue ?? [] }"
            x-init="$watch('$store.player.queue', v => queue = v)"
        >
            <template x-if="queue.length === 0">
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h8m-8 4h8"/></svg>
                    <p class="text-surface-500 text-lg">صف پخش خالی است</p>
                </div>
            </template>
            <template x-if="queue.length > 0">
                <div class="space-y-2">
                    <template x-for="(track, index) in queue" :key="index">
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                            <span class="text-sm text-surface-400 w-5 text-center" x-text="index + 1"></span>
                            <img :src="track.cover ?? '/images/default-cover.png'" class="w-10 h-10 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-surface-900 dark:text-white text-sm truncate" x-text="track.title"></p>
                                <p class="text-xs text-surface-500 truncate" x-text="track.artist"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</x-layouts.app>

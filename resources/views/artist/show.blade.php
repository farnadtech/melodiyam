<x-layouts.app :title="$artist->display_name">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Artist Header --}}
        <div class="relative overflow-hidden rounded-3xl p-8 lg:p-12 gradient-primary">
            <div class="absolute inset-0 bg-gradient-to-l from-black/30 to-transparent"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center md:items-end gap-6">
                <div class="w-36 h-36 md:w-48 md:h-48 rounded-full overflow-hidden shadow-2xl border-4 border-white/20 flex-shrink-0">
                    <img src="{{ $artist->user->avatar ? asset('storage/' . $artist->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $artist->display_name }}" class="w-full h-full object-cover">
                </div>
                <div class="text-center md:text-right">
                    @if($artist->verification_status === 'approved')
                    <div class="inline-flex items-center gap-1 text-xs text-white/80 bg-white/20 rounded-full px-3 py-1 mb-2">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        هنرمند تأیید شده
                    </div>
                    @endif
                    <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-white">{{ $artist->display_name }}</h1>
                    <p class="text-white/80 mt-2">
                        {{ number_format($artist->monthly_listeners) }} شنونده ماهانه · <span id="artist-followers-count">{{ number_format($artist->followers_count) }}</span> دنبال‌کننده
                    </p>
                </div>
            </div>
        </div>

        {{-- Action buttons --}}
        <div class="flex items-center gap-3"
            x-data="{
                following: {{ auth()->check() && auth()->user()->isFollowing($artist) ? 'true' : 'false' }},
                followers: {{ $artist->followers_count }},
                async toggleFollow() {
                    const res = await fetch('/follow/toggle', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
                        body: JSON.stringify({type: 'artist', id: {{ $artist->id }}})
                    });
                    const data = await res.json();
                    this.following = data.following;
                    this.followers = data.following ? this.followers + 1 : this.followers - 1;
                    document.getElementById('artist-followers-count').textContent = new Intl.NumberFormat('en').format(this.followers);
                }
            }"
        >
            @auth
                <button
                    x-on:click="toggleFollow"
                    x-bind:class="following ? 'btn-ghost !rounded-full !px-8' : 'btn-primary !rounded-full !px-8'"
                    x-text="following ? 'دنبال می‌کنید' : 'دنبال کردن'"
                ></button>
            @else
                <a href="{{ route('login') }}" class="btn-primary !rounded-full !px-8">دنبال کردن</a>
            @endauth
            <button class="p-3 rounded-full border border-surface-300 dark:border-surface-600 hover:border-primary-500 transition-colors">
                <svg class="w-5 h-5 text-surface-600 dark:text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </button>
        </div>

        {{-- Bio --}}
        @if($artist->bio)
        <section>
            <p class="text-surface-600 dark:text-surface-400 leading-relaxed">{{ $artist->bio }}</p>
        </section>
        @endif

        {{-- Top Tracks --}}
        @if($topTracks->isNotEmpty())
        <section>
            <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-4">محبوب‌ترین آهنگ‌ها</h2>
            <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
                @foreach($topTracks as $i => $track)
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group" x-data>
                    <span class="text-sm text-surface-400 w-6 text-center">{{ $i + 1 }}</span>
                    <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 hover:text-primary-500 truncate block">{{ $track->title }}</a>
                    </div>
                    <span class="text-xs text-surface-400">{{ number_format($track->play_count) }} پخش</span>
                    <span class="text-xs text-surface-400">{{ $track->formattedDuration() }}</span>
                    <button
                        @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($artist->display_name) }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }} })"
                        class="opacity-0 group-hover:opacity-100 w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center transition-opacity"
                    >
                        <svg class="w-3.5 h-3.5 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Albums --}}
        @if($albums->isNotEmpty())
        <section>
            <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-4">آلبوم‌ها</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($albums as $album)
                    @include('components.album-card', ['album' => $album])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-layouts.app>

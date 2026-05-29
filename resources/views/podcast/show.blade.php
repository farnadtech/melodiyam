<x-layouts.app :title="$podcast->title">
    <div class="p-4 lg:p-8 space-y-8">
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0 relative bg-surface-100 dark:bg-surface-800">
                @php $podcastCover = $podcast->cover_image ? asset('storage/' . $podcast->cover_image) : asset('images/default-cover.png'); @endphp
                {{-- Blurred background for non-square images --}}
                <img src="{{ $podcastCover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-50 scale-110">
                {{-- Main image showing fully --}}
                <img src="{{ $podcastCover }}" alt="{{ $podcast->title }}" class="relative z-10 w-full h-full object-contain">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right"
                 x-data="{ subscribed: {{ $isSubscribed ? 'true' : 'false' }}, loading: false, count: {{ $podcast->subscribers_count }} }">
                @if($podcast->is_explicit)
                <div class="mb-3 inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-red-500/10 border border-red-500/20 text-red-500 w-fit mx-auto md:mx-0">
                    <span class="flex items-center justify-center w-5 h-5 rounded bg-red-500 text-white text-[10px] font-bold">18+</span>
                    <span class="text-[11px] font-bold">مناسب برای زیر ۱۸ سال نیست</span>
                </div>
                @endif
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">پادکست</p>
                <h1 class="text-3xl lg:text-4xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $podcast->title }}</h1>
                <p class="text-sm text-surface-500 mb-3">{{ $podcast->artist->display_name ?? '' }}</p>
                <div class="flex items-center gap-3 justify-center md:justify-start mb-3">
                    <span class="text-xs text-surface-400" x-text="count.toLocaleString('fa-IR') + ' دنبال‌کننده'">{{ number_format($podcast->subscribers_count) }} دنبال‌کننده</span>
                </div>
                @if($podcast->description)
                <p class="text-surface-600 dark:text-surface-400 text-sm leading-relaxed">{{ Str::limit($podcast->description, 200) }}</p>
                @endif
                @auth
                <div class="flex items-center gap-3 mt-4 justify-center md:justify-start">
                    <button
                        @click="if (loading) return; loading = true; fetch('{{ route('podcast.subscribe', $podcast) }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } }).then(r => r.json()).then(d => { subscribed = d.subscribed; count = d.count; loading = false; }).catch(e => { console.error(e); loading = false; })"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium text-sm transition-all"
                        :class="subscribed ? 'bg-surface-200 dark:bg-surface-700 text-surface-700 dark:text-surface-300' : 'bg-primary-500 hover:bg-primary-600 text-white'"
                    >
                        <svg x-show="!subscribed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <svg x-show="subscribed" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        <span x-text="subscribed ? 'دنبال شده' : 'دنبال کردن'"></span>
                    </button>
                </div>
                @endauth
            </div>
        </div>

        {{-- Episodes --}}
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white">قسمت‌ها</h2>
            </div>
            
            <x-sort-filters :currentSort="$sort" />

            @if($sort === 'newest' || $sort === 'oldest')
                {{-- Group by Season for chronological sorts --}}
                @foreach($episodes->groupBy('season_number')->sortKeysDesc() as $season => $seasonEpisodes)
                <div x-data="{ open: true }" class="space-y-4">
                    <button @click="open = !open" class="flex items-center gap-2 text-lg font-bold text-surface-700 dark:text-surface-300">
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        فصل {{ $season }}
                    </button>

                    <div x-show="open" x-collapse class="space-y-3">
                        @foreach($seasonEpisodes as $episode)
                        <div class="bg-surface-50 dark:bg-surface-800/40 rounded-2xl p-4 hover:bg-surface-100 dark:hover:bg-surface-800/60 transition-colors">
                            <div class="flex gap-4 items-start">
                                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ $episode->getCoverUrl() }}" alt="{{ $episode->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-surface-900 dark:text-white truncate">{{ $episode->title }}</h3>
                                        @if($episode->is_explicit)
                                        <span class="px-1.5 py-0.5 bg-red-500/10 text-red-500 border border-red-500/20 rounded text-[10px] font-bold">18+</span>
                                        @endif
                                        @if($episode->is_premium_only)
                                        <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded text-[10px] font-medium">پریمیوم</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-surface-400 mt-1">قسمت {{ $episode->episode_number }}</p>
                                    @if($episode->description)
                                    <p class="text-xs text-surface-500 mt-2 line-clamp-2">{{ $episode->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 mt-3 text-xs text-surface-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $episode->formattedDuration() }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ number_format($episode->play_count) }} پخش
                                        </span>
                                        @if($episode->published_at)
                                        <span>{{ $episode->published_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $epIsPremium = $episode->is_premium_only && !$isPremiumUser;
                                    $epPreviewSec = $epIsPremium ? $premiumPreviewSec : 0;
                                @endphp
                                <button
                                    x-data
                                    @click="$store.player.play({
                                        id: 'episode-{{ $episode->id }}',
                                        title: '{{ e($episode->title) }}',
                                        artist: '{{ e($podcast->artist->display_name ?? '') }}',
                                        cover: '{{ $episode->getCoverUrl() }}',
                                        url: '{{ $episode->getStreamUrl() }}',
                                        previewSeconds: {{ $epPreviewSec }},
                                        canPlay: {{ $epIsPremium ? 'false' : 'true' }},
                                        isPremium: {{ $epIsPremium ? 'true' : 'false' }},
                                        purchaseUrl: '{{ route('premium') }}'
                                    })"
                                    class="w-10 h-10 rounded-full {{ $epIsPremium ? 'bg-purple-500 hover:bg-purple-400' : 'bg-primary-500 hover:bg-primary-400' }} flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-4 h-4 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </button>
                                @if($canDownload && $episode->is_downloadable)
                                <a href="{{ route('podcast.episode.download', $episode) }}" class="w-10 h-10 rounded-full border border-surface-300 dark:border-surface-600 hover:border-primary-500 flex items-center justify-center flex-shrink-0 transition-colors" title="دانلود">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                {{-- Flat list for other sorts --}}
                <div class="space-y-3">
                    @foreach($episodes as $episode)
                    <div class="bg-surface-50 dark:bg-surface-800/40 rounded-2xl p-4 hover:bg-surface-100 dark:hover:bg-surface-800/60 transition-colors">
                        <div class="flex gap-4 items-start">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $episode->getCoverUrl() }}" alt="{{ $episode->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-surface-900 dark:text-white truncate">{{ $episode->title }}</h3>
                                    @if($episode->is_explicit)
                                    <span class="px-1.5 py-0.5 bg-red-500/10 text-red-500 border border-red-500/20 rounded text-[10px] font-bold">18+</span>
                                    @endif
                                    @if($episode->is_premium_only)
                                    <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded text-[10px] font-medium">پریمیوم</span>
                                    @endif
                                </div>
                                <p class="text-xs text-surface-400 mt-1">فصل {{ $episode->season_number }} - قسمت {{ $episode->episode_number }}</p>
                                @if($episode->description)
                                <p class="text-xs text-surface-500 mt-2 line-clamp-2">{{ $episode->description }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-3 text-xs text-surface-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $episode->formattedDuration() }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ number_format($episode->play_count) }} پخش
                                    </span>
                                    @if($episode->published_at)
                                    <span>{{ $episode->published_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                            @php
                                $epIsPremium = $episode->is_premium_only && !$isPremiumUser;
                                $epPreviewSec = $epIsPremium ? $premiumPreviewSec : 0;
                            @endphp
                            <button
                                x-data
                                @click="$store.player.play({
                                    id: 'episode-{{ $episode->id }}',
                                    title: '{{ e($episode->title) }}',
                                    artist: '{{ e($podcast->artist->display_name ?? '') }}',
                                    cover: '{{ $episode->getCoverUrl() }}',
                                    url: '{{ $episode->getStreamUrl() }}',
                                    previewSeconds: {{ $epPreviewSec }},
                                    canPlay: {{ $epIsPremium ? 'false' : 'true' }},
                                    isPremium: {{ $epIsPremium ? 'true' : 'false' }},
                                    purchaseUrl: '{{ route('premium') }}'
                                })"
                                class="w-10 h-10 rounded-full {{ $epIsPremium ? 'bg-purple-500 hover:bg-purple-400' : 'bg-primary-500 hover:bg-primary-400' }} flex items-center justify-center flex-shrink-0 transition-colors">
                                <svg class="w-4 h-4 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                            @if($canDownload && $episode->is_downloadable)
                            <a href="{{ route('podcast.episode.download', $episode) }}" class="w-10 h-10 rounded-full border border-surface-300 dark:border-surface-600 hover:border-primary-500 flex items-center justify-center flex-shrink-0 transition-colors" title="دانلود">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

</x-layouts.app>

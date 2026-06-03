<x-layouts.app :title="$podcast->title">
    <div class="p-4 lg:p-8 space-y-8" x-data="{ toast: '', toastType: 'success' }" x-init="$watch('toast', v => { if(v) setTimeout(() => toast = '', 3000) })">
        {{-- Toast notification --}}
        <div x-show="toast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] pointer-events-none" x-cloak>
            <div class="px-5 py-2.5 rounded-xl shadow-xl text-sm font-medium backdrop-blur" :class="toastType === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'" x-text="toast"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0 relative bg-surface-100 dark:bg-surface-800">
                @php $podcastCover = $podcast->cover_image ? asset('storage/' . $podcast->cover_image) : asset('images/default-cover.png'); @endphp
                {{-- Blurred background for non-square images --}}
                <img src="{{ $podcastCover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-50 scale-110">
                {{-- Main image showing fully --}}
                <img src="{{ $podcastCover }}" alt="{{ $podcast->title }}" class="relative z-10 w-full h-full object-contain">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right"
                 x-data="{ subscribed: {{ $isSubscribed ? 'true' : 'false' }}, loading: false, count: {{ $podcast->subscribers_count }}, reposted: {{ $userRepostedPodcast ? 'true' : 'false' }}, repostCount: {{ $podcast->repost_count ?? 0 }}, liked: {{ $userLikedPodcast ? 'true' : 'false' }}, likeCount: {{ $podcast->like_count ?? 0 }}, shareOpen: false }">
                @if($podcast->is_explicit)
                <div class="mb-3 inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-red-500/10 border border-red-500/20 text-red-500 w-fit mx-auto md:mx-0">
                    <span class="flex items-center justify-center w-5 h-5 rounded bg-red-500 text-white text-[10px] font-bold">18+</span>
                    <span class="text-[11px] font-bold">مناسب برای زیر ۱۸ سال نیست</span>
                </div>
                @endif
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">پادکست</p>
                <h1 class="text-3xl lg:text-4xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $podcast->title }}</h1>
                <div class="flex items-center gap-2 justify-center md:justify-start mb-3 text-sm">
                    <a href="{{ $podcast->artist ? route('artist.show', $podcast->artist) : '#' }}" wire:navigate class="font-medium text-surface-900 dark:text-white hover:text-primary-500">
                        {{ $podcast->artist->display_name ?? '' }}
                    </a>
                    @if($podcast->category)
                    <span class="text-surface-300">·</span>
                    <a href="{{ route('podcasts.index', ['category' => $podcast->category]) }}" wire:navigate class="text-surface-500 hover:text-primary-500 transition-colors">{{ $podcast->category }}</a>
                    @endif
                </div>
                <div class="flex items-center gap-3 justify-center md:justify-start mb-3">
                    <span class="text-xs text-surface-400" x-text="count.toLocaleString('fa-IR') + ' دنبال‌کننده'">{{ number_format($podcast->subscribers_count) }} دنبال‌کننده</span>
                </div>
                @if($podcast->description)
                <p class="text-surface-600 dark:text-surface-400 text-sm leading-relaxed">{{ Str::limit($podcast->description, 200) }}</p>
                @endif
                @auth
                <div class="flex items-center flex-wrap gap-3 mt-4 justify-center md:justify-start">
                    <button
                        @click="if (loading) return; loading = true; fetch('{{ route('podcast.subscribe', $podcast) }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } }).then(r => r.json()).then(d => { subscribed = d.subscribed; count = d.count; loading = false; }).catch(e => { console.error(e); loading = false; })"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium text-sm transition-all"
                        :class="subscribed ? 'bg-surface-200 dark:bg-surface-700 text-surface-700 dark:text-surface-300' : 'bg-primary-500 hover:bg-primary-600 text-white'"
                    >
                        <svg x-show="!subscribed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <svg x-show="subscribed" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        <span x-text="subscribed ? 'دنبال شده' : 'دنبال کردن'"></span>
                    </button>

                    {{-- Like button --}}
                    <button @click="
                        fetch('{{ route('like.toggle') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                            body: JSON.stringify({type: 'podcast', id: {{ $podcast->id }}})
                        }).then(r => r.json()).then(d => { liked = d.liked; likeCount += d.liked ? 1 : -1; })
                    " class="px-5 py-2.5 rounded-xl border transition-colors flex items-center gap-2 text-sm font-medium" :class="liked ? 'border-rose-500 text-rose-500 bg-rose-50 dark:bg-rose-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-rose-500 hover:text-rose-500'">
                        <svg class="w-5 h-5" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span x-text="liked ? 'پسندیده شده' : 'پسندیدن'"></span>
                        <span x-show="likeCount > 0" class="text-xs opacity-60" x-text="likeCount"></span>
                    </button>

                    {{-- Repost button --}}
                    <button @click="
                        fetch('{{ route('repost.toggle') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                            body: JSON.stringify({type: 'podcast', id: {{ $podcast->id }}})
                        }).then(r => r.json()).then(d => { 
                            reposted = d.reposted; 
                            repostCount += d.reposted ? 1 : -1;
                            toast = d.reposted ? 'در فید شما بازنشر شد' : 'از فید شما حذف شد';
                            toastType = 'success';
                        })
                    " class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-medium text-sm transition-all border" :class="reposted ? 'border-primary-500 text-primary-500 bg-primary-50 dark:bg-primary-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-primary-500 hover:text-primary-500 text-surface-700 dark:text-surface-200'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span x-text="reposted ? 'بازنشر شده' : 'بازنشر'"></span>
                    </button>

                    {{-- Report button --}}
                    <x-report-button type="podcast" :id="$podcast->id" label="شکایت" />

                    {{-- Share button --}}
                    <div class="relative">
                        <button @click="shareOpen = !shareOpen" class="px-5 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 hover:border-primary-500 transition-colors flex items-center gap-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            <span>اشتراک‌گذاری</span>
                        </button>
                        <div x-show="shareOpen" @click.outside="shareOpen = false" x-transition x-cloak class="absolute top-full mt-2 right-0 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 p-2 min-w-48 z-20">
                            <button @click="navigator.clipboard.writeText(window.location.href); shareOpen = false; toast = 'لینک کپی شد'; toastType = 'success'" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                کپی لینک
                            </button>
                        </div>
                    </div>
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
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white transition-colors {{ $epIsPremium ? 'bg-purple-500 hover:bg-purple-400' : 'bg-primary-500 hover:bg-primary-400' }}">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    پخش
                                </button>
                                @if($canDownload && $episode->is_downloadable)
                                <a href="{{ route('podcast.episode.download', $episode) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border border-surface-300 dark:border-surface-600 hover:border-primary-500 text-surface-700 dark:text-surface-300 transition-colors" title="دانلود">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    دانلود
                                </a>
                                @endif
                                @auth
                                <button
                                    x-data="{ epReposted: {{ in_array($episode->id, $userRepostedEpisodes) ? 'true' : 'false' }} }"
                                    @click="fetch('{{ route('repost.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'episode', id: {{ $episode->id }} }) }).then(r => r.json()).then(d => { epReposted = d.reposted; toast = d.reposted ? 'قسمت پادکست بازنشر شد' : 'از فید حذف شد'; toastType = 'success'; })"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border transition-colors"
                                    :class="epReposted ? 'border-primary-500 text-primary-500 bg-primary-50 dark:bg-primary-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-primary-500 hover:text-primary-500 text-surface-700 dark:text-surface-200'"
                                    title="بازنشر این قسمت">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span x-text="epReposted ? 'بازنشر شده' : 'بازنشر'"></span>
                                </button>
                                @endauth
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
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white transition-colors {{ $epIsPremium ? 'bg-purple-500 hover:bg-purple-400' : 'bg-primary-500 hover:bg-primary-400' }}">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                پخش
                            </button>
                            @if($canDownload && $episode->is_downloadable)
                                <a href="{{ route('podcast.episode.download', $episode) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border border-surface-300 dark:border-surface-600 hover:border-primary-500 text-surface-700 dark:text-surface-300 transition-colors" title="دانلود">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    دانلود
                                </a>
                                @endif
                                @auth
                                <button
                                    x-data="{ epReposted: {{ in_array($episode->id, $userRepostedEpisodes) ? 'true' : 'false' }} }"
                                    @click="fetch('{{ route('repost.toggle') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ type: 'episode', id: {{ $episode->id }} }) }).then(r => r.json()).then(d => { epReposted = d.reposted; toast = d.reposted ? 'قسمت پادکست بازنشر شد' : 'از فید حذف شد'; toastType = 'success'; })"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold border transition-colors"
                                    :class="epReposted ? 'border-primary-500 text-primary-500 bg-primary-50 dark:bg-primary-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-primary-500 hover:text-primary-500 text-surface-700 dark:text-surface-200'"
                                    title="بازنشر این قسمت">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span x-text="epReposted ? 'بازنشر شده' : 'بازنشر'"></span>
                                </button>
                                @endauth
                            </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

</x-layouts.app>

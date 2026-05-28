<x-layouts.app :title="$track->title">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Track Header --}}
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $track->getCoverUrl() }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">آهنگ</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-2">{{ $track->title }}</h1>
                @if($track->is_featured || $track->is_explicit)
                <div class="flex items-center gap-2 justify-center md:justify-start mb-3">
                    @if($track->is_featured)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-600 dark:text-amber-400 border border-amber-400/30">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        ویژه
                    </span>
                    @endif
                    @if($track->is_explicit)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-500 border border-rose-500/20">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        نامناسب
                    </span>
                    @endif
                </div>
                @endif
                <div class="flex flex-wrap items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <a href="{{ route('artist.show', $track->artist ?? '') }}" wire:navigate class="font-medium text-surface-900 dark:text-white hover:text-primary-500">
                        {{ $track->artist->display_name ?? '' }}
                    </a>
                    @if($track->album)
                    <span>·</span>
                    <a href="{{ route('album.show', $track->album) }}" wire:navigate class="hover:text-primary-500">{{ $track->album->title }}</a>
                    @endif
                    <span>·</span>
                    <span>{{ $track->formattedDuration() }}</span>
                    <span>·</span>
                    <span>{{ number_format($track->play_count) }} پخش</span>
                </div>
                <div class="flex items-center flex-wrap gap-3 mt-5 justify-center md:justify-start" x-data="{ liked: {{ $userLikedTrack ? 'true' : 'false' }}, likeCount: {{ $track->like_count ?? 0 }}, shareOpen: false, plOpen: false, toast: '', toastType: 'success' }" x-init="$watch('toast', v => { if(v) setTimeout(() => toast = '', 3000) })">
                    {{-- Toast notification --}}
                    <div x-show="toast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] pointer-events-none" x-cloak>
                        <div class="px-5 py-2.5 rounded-xl shadow-xl text-sm font-medium backdrop-blur" :class="toastType === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'" x-text="toast"></div>
                    </div>

                    @if($canPlay)
                    <button
                        @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist) : '' }}', duration: {{ $track->duration }}, previewSeconds: 0, canPlay: true })"
                        class="btn-primary !rounded-full !px-8 !py-3 gap-2"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش
                    </button>
                    @elseif($isPremiumOnly)
                    {{-- Premium locked: play preview if available, then show upgrade modal --}}
                    <div class="flex items-center gap-3 flex-wrap">
                        @if($premiumPreviewSec > 0)
                        <button
                            @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist) : '' }}', duration: {{ $track->duration }}, previewSeconds: {{ $premiumPreviewSec }}, canPlay: false, isPremium: true, purchaseUrl: '{{ route('premium') }}' })"
                            class="btn-primary !rounded-full !px-8 !py-3 gap-2"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            پخش پیش‌نمایش ({{ $premiumPreviewSec }} ثانیه)
                        </button>
                        @endif
                        <div class="flex items-center gap-2 px-5 py-3 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            این آهنگ مخصوص کاربران پریمیوم است
                        </div>
                        <a href="{{ route('premium') }}" wire:navigate class="btn-primary !rounded-full !px-8 !py-3 gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            خرید اشتراک پریمیوم
                        </a>
                    </div>
                    @elseif($isPaidTrack && $previewSec > 0)
                    {{-- Has preview: play with timer --}}
                    <button
                        @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist) : '' }}', duration: {{ $track->duration }}, previewSeconds: {{ $previewSec }}, canPlay: false, price: {{ $sellPrice ?? 0 }}, discountPrice: {{ $sellDiscount ?? 'null' }}, purchaseUrl: '{{ $buyUrl }}' })"
                        class="btn-primary !rounded-full !px-8 !py-3 gap-2"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش پیش‌نمایش ({{ $previewSec }} ثانیه)
                    </button>
                    @elseif($isPaidTrack)
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="flex items-center gap-2 px-5 py-3 rounded-full bg-surface-200 dark:bg-surface-700 text-surface-500 dark:text-surface-400 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            @if($track->album && !($track->is_for_sale && $track->price))
                                برای شنیدن این آهنگ باید البوم «{{ $track->album->title }}» را خریداری کنید
                            @else
                                محتوای پولی
                            @endif
                        </div>
                        @auth
                        <a href="{{ $buyUrl }}"
                           class="btn-primary !rounded-full !px-8 !py-3 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            @if($track->album && !($track->is_for_sale && $track->price))
                                خرید البوم
                            @else
                                خرید
                            @endif
                            @if($sellDiscount)
                                <span class="line-through text-xs opacity-60">{{ number_format($sellPrice) }}</span>
                                {{ number_format($sellDiscount) }} ت
                            @elseif($sellPrice)
                                {{ number_format($sellPrice) }} ت
                            @endif
                        </a>
                        @else
                        <a href="{{ route('login') }}" wire:navigate class="btn-primary !rounded-full !px-8 !py-3 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            ورود برای خرید
                        </a>
                        @endauth
                    </div>
                    @endif

                    {{-- Like button --}}
                    @auth
                    <button @click="
                        fetch('{{ route('like.toggle') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                            body: JSON.stringify({type: 'track', id: {{ $track->id }}})
                        }).then(r => r.json()).then(d => { liked = d.liked; likeCount += d.liked ? 1 : -1; })
                    " class="p-3 rounded-full border transition-colors flex items-center gap-1.5" :class="liked ? 'border-rose-500 text-rose-500 bg-rose-50 dark:bg-rose-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-rose-500 hover:text-rose-500'">
                        <svg class="w-5 h-5" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span x-show="likeCount > 0" class="text-xs font-medium" x-text="likeCount"></span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" wire:navigate class="p-3 rounded-full border border-surface-300 dark:border-surface-600 hover:border-rose-500 hover:text-rose-500 transition-colors flex items-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span x-show="likeCount > 0" class="text-xs font-medium text-surface-500" x-text="likeCount"></span>
                    </a>
                    @endauth

                    {{-- Add to Playlist --}}
                    @auth
                    <div class="relative">
                        <button @click="plOpen = !plOpen" class="p-3 rounded-full border border-surface-300 dark:border-surface-600 hover:border-primary-500 transition-colors" title="افزودن به پلی‌لیست">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </button>
                        <div x-show="plOpen" @click.outside="plOpen = false" x-transition x-cloak class="absolute top-full mt-2 right-0 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 py-1.5 min-w-52 z-20 max-h-64 overflow-y-auto">
                            <p class="text-xs font-medium text-surface-400 px-3 py-1.5 border-b border-surface-100 dark:border-surface-700 mb-1">افزودن به پلی‌لیست</p>
                            @php $userPlaylists = auth()->user()->playlists()->orderBy('title')->get(); @endphp
                            @forelse($userPlaylists as $pl)
                            <button @click="
                                fetch('{{ route('playlist.add-track') }}', {
                                    method: 'POST',
                                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                                    body: JSON.stringify({playlist_id: {{ $pl->id }}, track_id: {{ $track->id }}})
                                }).then(r => r.json()).then(d => {
                                    plOpen = false;
                                    if (d.exists) { toast = 'این آهنگ قبلاً در این پلی‌لیست موجود است'; toastType = 'warning'; }
                                    else { toast = 'به پلی‌لیست اضافه شد'; toastType = 'success'; }
                                });
                            " class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors text-right mx-1" style="width:calc(100% - 0.5rem)">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                {{ $pl->title }}
                            </button>
                            @empty
                            <p class="text-xs text-surface-400 px-3 py-2">پلی‌لیستی ندارید</p>
                            @endforelse
                        </div>
                    </div>
                    @endauth

                    {{-- Report button --}}
                    @auth
                    <x-report-button type="track" :id="$track->id" />
                    @endauth

                    {{-- Share button --}}
                    <div class="relative">
                        <button @click="shareOpen = !shareOpen" class="p-3 rounded-full border border-surface-300 dark:border-surface-600 hover:border-primary-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </button>
                        <div x-show="shareOpen" @click.outside="shareOpen = false" x-transition x-cloak class="absolute top-full mt-2 right-0 bg-white dark:bg-surface-800 rounded-xl shadow-xl border border-surface-200 dark:border-surface-700 p-2 min-w-48 z-20">
                            <button @click="navigator.clipboard.writeText(window.location.href); shareOpen = false; toast = 'لینک کپی شد'; toastType = 'success'" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                کپی لینک
                            </button>
                            <a :href="'https://t.me/share/url?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ e($track->title) }}')" target="_blank" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                                تلگرام
                            </a>
                            <a :href="'https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('{{ e($track->title) }}')" target="_blank" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                ایکس (توییتر)
                            </a>
                            <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('{{ e($track->title) }} ' + window.location.href)" target="_blank" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                واتساپ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Waveform --}}
        @if(!$canPlay && $previewSec == 0)
        {{-- Fully locked, no preview --}}
        <div class="glass-card rounded-2xl p-8 flex flex-col items-center justify-center gap-4 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-200 dark:bg-surface-700 flex items-center justify-center">
                <svg class="w-8 h-8 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            @if($track->album && !($track->is_for_sale && $track->price))
            <p class="text-surface-600 dark:text-surface-400 text-sm font-medium">این آهنگ بخشی از البوم «{{ $track->album->title }}» است — برای شنیدن باید البوم را خریداری کنید</p>
            @else
            <p class="text-surface-600 dark:text-surface-400 text-sm font-medium">این آهنگ پولیه — برای شنیدن باید خریداری کنید</p>
            @endif
            <div class="flex items-center gap-3">
                @if($sellDiscount)
                <span class="text-surface-400 line-through text-sm">{{ number_format($sellPrice) }} ت</span>
                <span class="text-2xl font-bold text-primary-500">{{ number_format($sellDiscount) }} ت</span>
                @elseif($sellPrice)
                <span class="text-2xl font-bold text-primary-500">{{ number_format($sellPrice) }} ت</span>
                @endif
            </div>
            @auth
            <a href="{{ $buyUrl }}" class="btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                @if($track->album && !($track->is_for_sale && $track->price))خرید البوم «{{ $track->album->title }}»@elseخرید آهنگ@endif
                @if($sellDiscount) <span class="line-through text-xs opacity-60">{{ number_format($sellPrice) }}</span> {{ number_format($sellDiscount) }} ت @elseif($sellPrice) {{ number_format($sellPrice) }} ت @endif
            </a>
            @else
            <a href="{{ route('login') }}" wire:navigate class="btn-primary gap-2">ورود و خرید</a>
            @endauth
        </div>
        @elseif(!$canPlay && $previewSec > 0)
        {{-- Has preview — show waveform but player will cut off --}}
        <section
            wire:key="waveform-preview-{{ $track->id }}"
            x-data="waveform('{{ $track->getStreamUrl() }}', {{ $track->id }}, [])"
            x-init="init()"
            class="relative"
        >
            <div class="glass-card rounded-2xl p-4 lg:p-6 overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-primary-400 font-medium">پیش‌نمایش {{ $previewSec }} ثانیه‌ای</span>
                    <span class="text-xs text-surface-400 tabular-nums" x-text="formatTime(duration)"></span>
                </div>
                <div class="relative h-24 lg:h-32 cursor-pointer" @click="seek($event)" x-ref="waveContainer">
                    <canvas x-ref="waveCanvas" class="absolute inset-0 w-full h-full"></canvas>
                    <canvas x-ref="waveProgress" class="absolute inset-0 w-full h-full"></canvas>
                    {{-- Preview cutoff marker — positioned by JS after audio duration is known --}}
                    <div x-ref="previewMarker" class="absolute top-0 bottom-0 w-0 border-r-2 border-dashed border-primary-500/70 z-10 hidden">
                        <span class="absolute top-1 right-1 text-xs text-primary-400 bg-surface-900/80 px-1 rounded whitespace-nowrap">پایان پیش‌نمایش</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-4">
                    <button @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist) : '' }}', duration: {{ $track->duration }}, previewSeconds: {{ $previewSec }}, canPlay: false, price: {{ $sellPrice ?? 0 }}, discountPrice: {{ $sellDiscount ?? 'null' }}, purchaseUrl: '{{ $buyUrl }}' })"
                        class="btn-primary gap-2 !py-2 !px-5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش پیش‌نمایش
                    </button>
                    @auth
                    <a href="{{ $buyUrl }}" class="btn-secondary gap-2 !py-2 !px-5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @if($track->album && !($track->is_for_sale && $track->price))خرید البوم@elseخرید@endif
                        @if($sellDiscount) <span class="line-through text-xs opacity-60">{{ number_format($sellPrice) }}</span> {{ number_format($sellDiscount) }} ت @elseif($sellPrice) {{ number_format($sellPrice) }} ت @endif
                    </a>
                    @endauth
                </div>
            </div>
        </section>
        @else
        <section
            wire:key="waveform-full-{{ $track->id }}"
            x-data="waveform('{{ $track->getStreamUrl() }}', {{ $track->id }}, {{ json_encode($comments->whereNotNull('timestamp_at')->map(fn($c) => ['id' => $c->id, 'body' => $c->body, 'user' => $c->user->name ?? 'کاربر', 'at' => $c->timestamp_at, 'likes' => $c->likes_count ?? 0])->values()) }})"
            x-init="init()"
            class="relative"
        >
            <div class="glass-card rounded-2xl p-4 lg:p-6 overflow-hidden">
                {{-- Time display --}}
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-surface-400 tabular-nums" x-text="formatTime(currentTime)"></span>
                    <span class="text-xs text-surface-400 tabular-nums" x-text="formatTime(duration)"></span>
                </div>
                {{-- Waveform Canvas --}}
                <div class="relative h-24 lg:h-32 cursor-pointer" @click="seek($event)" x-ref="waveContainer">
                    <canvas x-ref="waveCanvas" class="absolute inset-0 w-full h-full"></canvas>
                    <canvas x-ref="waveProgress" class="absolute inset-0 w-full h-full"></canvas>

                    {{-- Timed comment markers (grouped by second) --}}
                    <template x-for="marker in groupedMarkers" :key="marker.at">
                        <div class="absolute bottom-0 pointer-events-auto" :style="`right: ${(marker.at / (duration || 1)) * 100}%`"
                            @click.stop="openMarker = openMarker === marker.at ? null : marker.at">
                            <div class="w-5 h-5 -mb-1 rounded-full border-2 border-white dark:border-surface-800 flex items-center justify-center cursor-pointer shadow-sm translate-x-1/2 relative transition-transform hover:scale-110"
                                :class="openMarker === marker.at ? 'bg-primary-500' : 'bg-amber-400'">
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                                <span x-show="marker.count > 1" class="absolute -top-2 -right-2 w-3.5 h-3.5 rounded-full bg-rose-500 text-white text-[8px] flex items-center justify-center font-bold" x-text="marker.count"></span>
                            </div>
                        </div>
                    </template>

                    {{-- Active timed comment popup (auto) --}}
                    <div x-show="activeComment && !openMarker" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute top-2 left-1/2 -translate-x-1/2 z-20 pointer-events-none">
                        <div class="bg-surface-900/95 dark:bg-surface-700/95 backdrop-blur text-white text-sm rounded-xl px-4 py-2.5 shadow-2xl max-w-xs whitespace-nowrap">
                            <span class="font-medium text-amber-300" x-text="activeComment?.user"></span>
                            <span class="mx-1.5 text-surface-500">·</span>
                            <span x-text="activeComment?.body"></span>
                        </div>
                    </div>
                </div>

                {{-- Marker comments panel (click to open, outside waveform so no overflow) --}}
                <div x-show="openMarker !== null" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" x-cloak @click.outside="openMarker = null" class="mt-3 bg-surface-800/95 dark:bg-surface-700/95 backdrop-blur rounded-xl shadow-2xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2.5 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                            <span class="text-white text-sm font-medium">نظرات در <span class="text-amber-300" x-text="openMarkerLabel"></span></span>
                        </div>
                        <button @click="openMarker = null" class="text-surface-400 hover:text-white transition-colors p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="max-h-48 overflow-y-auto p-3 space-y-2.5">
                        <template x-for="marker in groupedMarkers" :key="'panel-'+marker.at">
                            <template x-if="marker.at === openMarker">
                                <div>
                                    <template x-for="item in marker.items" :key="item.id">
                                        <div class="flex items-start gap-2.5 py-1.5">
                                            <div class="w-6 h-6 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-300 text-[10px] font-bold flex-shrink-0 mt-0.5" x-text="item.user.charAt(0)"></div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-1.5">
                                                    <p class="text-xs font-medium text-amber-300" x-text="item.user"></p>
                                                    <span class="text-[10px] text-surface-400" x-text="formatTime(item.at)"></span>
                                                </div>
                                                <p class="text-sm text-white/90 leading-relaxed mt-0.5" x-text="item.body"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </section>
        @endif

        @push('scripts')
        <script>
        function registerWaveform() {
            if (typeof Alpine === 'undefined') return;
            Alpine.data('waveform', (audioUrl, trackId, timedCommentsData) => ({
                peaks: [],
                currentTime: 0,
                duration: 0,
                progress: 0,
                isThisTrack: false,
                animFrame: null,
                timedComments: timedCommentsData || [],
                groupedMarkers: [],
                activeComment: null,
                lastCheckedSecond: -1,
                openMarker: null,

                async init() {
                    // Group timed comments by second
                    const groups = {};
                    (this.timedComments || []).forEach(tc => {
                        if (!groups[tc.at]) groups[tc.at] = [];
                        groups[tc.at].push(tc);
                    });
                    const sorted = Object.entries(groups)
                        .map(([sec, items]) => ({ at: parseInt(sec), items, count: items.length }))
                        .sort((a, b) => a.at - b.at);

                    // Merge nearby markers (within 3s) to prevent overlap
                    const merged = [];
                    for (const g of sorted) {
                        const last = merged[merged.length - 1];
                        if (last && Math.abs(g.at - last.at) <= 3) {
                            last.items = last.items.concat(g.items);
                            last.count = last.items.length;
                            last.seconds = last.seconds || [last.at];
                            if (!last.seconds.includes(g.at)) last.seconds.push(g.at);
                        } else {
                            g.seconds = [g.at];
                            merged.push({...g});
                        }
                    }
                    this.groupedMarkers = merged;

                    await this.generatePeaks(audioUrl);
                    const isDark = document.documentElement.classList.contains('dark');
                    this.drawWave(this.$refs.waveCanvas, isDark ? 'rgba(148,163,184,0.3)' : 'rgba(100,116,139,0.3)', isDark ? 'rgba(148,163,184,0.12)' : 'rgba(100,116,139,0.12)');
                    this.tick();
                },

                async generatePeaks(url) {
                    const phpDur = {{ $track->duration > 0 ? $track->duration : 0 }};
                    try {
                        const resp = await fetch(url);
                        const buf = await resp.arrayBuffer();
                        const ctx = new (window.AudioContext || window.webkitAudioContext)();
                        const audio = await ctx.decodeAudioData(buf);
                        const raw = audio.getChannelData(0);
                        const samples = 200;
                        const blockSize = Math.floor(raw.length / samples);
                        const peaks = [];
                        for (let i = 0; i < samples; i++) {
                            let sum = 0;
                            for (let j = 0; j < blockSize; j++) {
                                sum += Math.abs(raw[i * blockSize + j]);
                            }
                            peaks.push(sum / blockSize);
                        }
                        const max = Math.max(...peaks);
                        this.peaks = peaks.map(p => p / max);
                        this.duration = audio.duration;
                        // Use audio.duration (accurate float) for marker; phpDur is integer and causes rounding offset
                        this.positionPreviewMarker(audio.duration);
                    } catch (e) {
                        this.peaks = Array.from({length: 200}, () => 0.2 + Math.random() * 0.8);
                        if (phpDur > 0) this.positionPreviewMarker(phpDur);
                    }
                },

                positionPreviewMarker(totalDuration) {
                    const previewSec = {{ $previewSec ?? 0 }};
                    const marker = this.$refs.previewMarker;
                    if (!marker || previewSec <= 0 || totalDuration <= 0) return;
                    // drawWave renders bar[i=0] at x = rect.width (RIGHT edge) = second 0
                    // bar[i=last] at x = 0 (LEFT edge) = end of track
                    // So previewSec is at distance (previewSec/totalDuration) from the RIGHT edge
                    const rightPct = (previewSec / totalDuration) * 100;
                    marker.style.right = rightPct + '%';
                    marker.style.left = 'auto';
                    marker.classList.remove('hidden');
                },

                drawWave(canvas, fillTop, fillBottom) {
                    if (!canvas || !canvas.parentElement) return;
                    const dpr = window.devicePixelRatio || 1;
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = rect.width * dpr;
                    canvas.height = rect.height * dpr;
                    canvas.style.width = rect.width + 'px';
                    canvas.style.height = rect.height + 'px';
                    const ctx = canvas.getContext('2d');
                    ctx.scale(dpr, dpr);
                    ctx.clearRect(0, 0, rect.width, rect.height);
                    const barW = Math.max(2, (rect.width / this.peaks.length) - 1);
                    const gap = (rect.width - barW * this.peaks.length) / (this.peaks.length - 1);
                    const mid = rect.height / 2;
                    this.peaks.forEach((peak, i) => {
                        const x = rect.width - (i * (barW + gap)) - barW;
                        const h = Math.max(2, peak * (mid - 2));
                        ctx.fillStyle = fillTop;
                        ctx.beginPath();
                        ctx.roundRect(x, mid - h, barW, h, barW / 2);
                        ctx.fill();
                        ctx.fillStyle = fillBottom;
                        ctx.beginPath();
                        ctx.roundRect(x, mid + 1, barW, h * 0.6, barW / 2);
                        ctx.fill();
                    });
                },

                drawProgress() {
                    const canvas = this.$refs.waveProgress;
                    if (!canvas || !canvas.parentElement) return;
                    const dpr = window.devicePixelRatio || 1;
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = rect.width * dpr;
                    canvas.height = rect.height * dpr;
                    canvas.style.width = rect.width + 'px';
                    canvas.style.height = rect.height + 'px';
                    const ctx = canvas.getContext('2d');
                    ctx.scale(dpr, dpr);
                    ctx.clearRect(0, 0, rect.width, rect.height);
                    const barW = Math.max(2, (rect.width / this.peaks.length) - 1);
                    const gap = (rect.width - barW * this.peaks.length) / (this.peaks.length - 1);
                    const mid = rect.height / 2;
                    const pct = this.progress / 100;
                    const playedBars = Math.floor(this.peaks.length * pct);
                    for (let i = 0; i < playedBars; i++) {
                        const x = rect.width - (i * (barW + gap)) - barW;
                        const h = Math.max(2, this.peaks[i] * (mid - 2));
                        ctx.fillStyle = '#0ea5e9';
                        ctx.beginPath();
                        ctx.roundRect(x, mid - h, barW, h, barW / 2);
                        ctx.fill();
                        ctx.fillStyle = '#38bdf8';
                        ctx.beginPath();
                        ctx.roundRect(x, mid + 1, barW, h * 0.6, barW / 2);
                        ctx.fill();
                    }
                },

                pickWeightedRandom(candidates) {
                    if (candidates.length === 1) return candidates[0];
                    const weights = candidates.map(c => (c.likes || 0) + 1);
                    const total = weights.reduce((a, b) => a + b, 0);
                    let r = Math.random() * total;
                    for (let i = 0; i < candidates.length; i++) {
                        r -= weights[i];
                        if (r <= 0) return candidates[i];
                    }
                    return candidates[candidates.length - 1];
                },

                checkTimedComments() {
                    const t = Math.floor(this.currentTime);
                    if (this.lastCheckedSecond === t) return;
                    this.lastCheckedSecond = t;

                    const candidates = this.timedComments.filter(tc => tc.at === t);
                    if (candidates.length === 0) return;

                    const picked = this.pickWeightedRandom(candidates);
                    this.activeComment = picked;
                    setTimeout(() => {
                        if (this.activeComment && this.activeComment.id === picked.id) {
                            this.activeComment = null;
                        }
                    }, 3000);
                },

                tick() {
                    if (!this.$refs.waveProgress) {
                        if (this.animFrame) cancelAnimationFrame(this.animFrame);
                        return;
                    }
                    const phpDuration = {{ $track->duration > 0 ? $track->duration : 0 }};
                    const store = Alpine.store('player');
                    this.isThisTrack = store.currentTrack && store.currentTrack.id === trackId;
                    if (this.isThisTrack && store.audio) {
                        this.currentTime = store.audio.currentTime || 0;
                        // Use PHP duration so progress bar spans full track length
                        const audioDur = store.audio.duration;
                        this.duration = (audioDur && isFinite(audioDur) && audioDur > 1) ? audioDur : (phpDuration || this.duration);
                        this.progress = this.duration > 0 ? (this.currentTime / this.duration) * 100 : 0;
                        this.drawProgress();
                        this.checkTimedComments();
                    } else {
                        if (this.progress !== 0) {
                            this.currentTime = 0;
                            this.progress = 0;
                            this.drawProgress();
                        }
                    }
                    this.animFrame = requestAnimationFrame(() => this.tick());
                },

                seek(event) {
                    const rect = this.$refs.waveContainer.getBoundingClientRect();
                    const pct = (rect.right - event.clientX) / rect.width;
                    const clampedPct = Math.max(0, Math.min(1, pct));
                    const trackDuration = {{ $track->duration > 0 ? $track->duration : 0 }};
                    const previewSec = {{ $previewSec ?? 0 }};
                    const canPlay = {{ $canPlay ? 'true' : 'false' }};
                    const targetTime = clampedPct * (trackDuration || 0);

                    // Block seeking past preview limit
                    if (!canPlay && previewSec > 0 && targetTime >= previewSec) return;

                    const store = Alpine.store('player');
                    if (!this.isThisTrack) {
                        store.play({
                            id: trackId,
                            title: '{{ e($track->title) }}',
                            artist: '{{ e($track->artist->display_name ?? '') }}',
                            url: '{{ $track->getStreamUrl() }}',
                            cover: '{{ $track->getCoverUrl() }}',
                            duration: trackDuration,
                            previewSeconds: previewSec,
                            canPlay: canPlay,
                            @if($isPaidTrack ?? false)
                            price: {{ $sellPrice ?? 0 }},
                            discountPrice: {{ $sellDiscount ?? 'null' }},
                            purchaseUrl: '{{ $buyUrl ?? '' }}',
                            @endif
                        });
                        setTimeout(() => {
                            if (store.audio) store.audio.currentTime = targetTime;
                        }, 300);
                    } else if (store.audio) {
                        store.audio.currentTime = targetTime;
                    }
                    this.lastCheckedSecond = -1;
                },

                get openMarkerLabel() {
                    if (this.openMarker === null) return '';
                    const m = this.groupedMarkers.find(g => g.at === this.openMarker);
                    if (!m || !m.seconds || m.seconds.length <= 1) return this.formatTime(this.openMarker);
                    const sorted = [...m.seconds].sort((a, b) => a - b);
                    return this.formatTime(sorted[0]) + ' - ' + this.formatTime(sorted[sorted.length - 1]);
                },

                formatTime(s) {
                    if (!s || isNaN(s)) return '0:00';
                    const m = Math.floor(s / 60);
                    const sec = Math.floor(s % 60);
                    return m + ':' + String(sec).padStart(2, '0');
                },

                destroy() {
                    if (this.animFrame) cancelAnimationFrame(this.animFrame);
                }
            }));
        }
        document.addEventListener('alpine:init', registerWaveform);
        document.addEventListener('livewire:navigated', () => {
            if (typeof Alpine === 'undefined') return;
            // Re-register so the new page's waveform data factory is fresh
            registerWaveform();
            // Find uninitialized waveform elements and init them
            document.querySelectorAll('[x-data^="waveform"]').forEach(el => {
                // If already has Alpine data stack, skip (already initialized this navigation)
                if (el._x_dataStack && el._x_dataStack.length > 0) return;
                Alpine.initTree(el);
            });
        });
        // Also handle the case where the script runs after Alpine is already initialized
        if (typeof Alpine !== 'undefined' && typeof Alpine.data === 'function') {
            registerWaveform();
        }
        </script>
        @endpush

        {{-- Lyrics --}}
        @if($track->lyrics)
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">متن آهنگ</h2>
            <div class="glass-card p-6 rounded-2xl">
                <div class="text-surface-700 dark:text-surface-300 leading-relaxed whitespace-pre-line">{{ $track->lyrics }}</div>
            </div>
        </section>
        @endif

        {{-- Comments --}}
        <section x-data="trackComments({{ $track->id }})">
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">نظرات <span class="text-sm font-normal text-surface-400" x-text="'(' + commentCount + ')'"></span></h2>

            @auth
            <div class="mb-6">
                <div class="flex gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <textarea x-model="newBody" rows="2" placeholder="نظر خود را بنویسید..." class="input-field text-sm resize-none"></textarea>
                        <div class="flex items-center justify-between mt-2">
                            <span x-show="$store.player.currentTrack && $store.player.currentTrack.id === {{ $track->id }} && $store.player.isPlaying" class="text-xs text-amber-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                                نظر در ثانیه <span x-text="Math.floor($store.player.currentTime)"></span> ثبت می‌شود
                            </span>
                            <span x-show="!($store.player.currentTrack && $store.player.currentTrack.id === {{ $track->id }} && $store.player.isPlaying)"></span>
                            <button @click="submitComment()" :disabled="submitting || !newBody.trim()" class="btn-primary text-sm !py-2 !px-5 disabled:opacity-50">
                                <span x-show="!submitting">ارسال نظر</span>
                                <span x-show="submitting">...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="glass-card rounded-2xl p-4 mb-6 text-center">
                <p class="text-sm text-surface-500">برای ثبت نظر <a href="{{ route('login') }}" wire:navigate class="text-primary-500 font-medium hover:underline">وارد شوید</a></p>
            </div>
            @endauth

            {{-- New comments (added via AJAX) --}}
            <template x-for="nc in newComments" :key="nc.id">
                <div class="glass-card rounded-2xl p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0" x-text="nc.user.charAt(0)"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-surface-900 dark:text-white" x-text="nc.user"></span>
                                <template x-if="nc.timestamp_at !== null && nc.timestamp_at !== ''">
                                    <span class="text-[11px] bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-1.5 py-0.5 rounded font-medium" x-text="Math.floor(nc.timestamp_at/60) + ':' + String(nc.timestamp_at%60).padStart(2,'0')"></span>
                                </template>
                                <span class="text-xs text-surface-400" x-text="nc.created_at"></span>
                            </div>
                            <p class="text-sm text-surface-700 dark:text-surface-300 leading-relaxed" x-text="nc.body"></p>
                        </div>
                    </div>
                </div>
            </template>

            @if($comments->isNotEmpty())
            <div class="space-y-4">
                @foreach($comments as $comment)
                <div class="glass-card rounded-2xl p-4" x-data="{ liked: {{ $comment->user_liked ? 'true' : 'false' }}, likeCount: {{ $comment->likes_count ?? 0 }} }">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-surface-300 to-surface-400 dark:from-surface-600 dark:to-surface-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ mb_substr($comment->user->name ?? '?', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-surface-900 dark:text-white">{{ $comment->user->name ?? 'کاربر' }}</span>
                                @if($comment->timestamp_at !== null)
                                <button @click="
                                    const store = Alpine.store('player');
                                    if (store.currentTrack && store.currentTrack.id === {{ $track->id }} && store.audio) {
                                        store.audio.currentTime = {{ $comment->timestamp_at }};
                                    }
                                " class="text-[11px] bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-1.5 py-0.5 rounded font-medium hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors cursor-pointer">{{ floor($comment->timestamp_at / 60) }}:{{ str_pad($comment->timestamp_at % 60, 2, '0', STR_PAD_LEFT) }}</button>
                                @endif
                                <span class="text-xs text-surface-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-surface-700 dark:text-surface-300 leading-relaxed">{{ $comment->body }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                @auth
                                <button @click="
                                    fetch('/comment/{{ $comment->id }}/like', {
                                        method: 'POST',
                                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                                    }).then(r => r.json()).then(d => { liked = d.liked; likeCount = d.count; })
                                " class="flex items-center gap-1 text-xs transition-colors" :class="liked ? 'text-rose-500' : 'text-surface-400 hover:text-rose-500'">
                                    <svg class="w-3.5 h-3.5" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span x-text="likeCount > 0 ? likeCount : ''"></span>
                                </button>
                                <button @click="replyTo = replyTo === {{ $comment->id }} ? null : {{ $comment->id }}" class="text-xs text-primary-500 hover:underline">پاسخ</button>
                                @else
                                <span x-show="likeCount > 0" class="flex items-center gap-1 text-xs text-surface-400">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span x-text="likeCount"></span>
                                </span>
                                @endauth
                            </div>
                        </div>
                    </div>

                    @auth
                    <div x-show="replyTo === {{ $comment->id }}" x-cloak class="mt-3 mr-11" x-data="{ replyBody: '' }">
                        <textarea x-model="replyBody" rows="2" placeholder="پاسخ شما..." class="input-field text-sm resize-none"></textarea>
                        <div class="flex justify-end gap-2 mt-2">
                            <button type="button" @click="replyTo = null; replyBody = ''" class="text-sm text-surface-400 hover:text-surface-600">انصراف</button>
                            <button @click="submitReply({{ $comment->id }}, replyBody); replyBody = ''" :disabled="!replyBody.trim()" class="btn-primary text-xs !py-1.5 !px-4 disabled:opacity-50">ارسال</button>
                        </div>
                    </div>
                    @endauth

                    @if($comment->replies->isNotEmpty())
                    <div class="mt-3 mr-11 space-y-3 border-r-2 border-surface-200 dark:border-surface-700 pr-4">
                        @foreach($comment->replies as $reply)
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-surface-300 to-surface-400 dark:from-surface-600 dark:to-surface-700 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                {{ mb_substr($reply->user->name ?? '?', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-medium text-surface-900 dark:text-white">{{ $reply->user->name ?? 'کاربر' }}</span>
                                    <span class="text-xs text-surface-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-surface-700 dark:text-surface-300">{{ $reply->body }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div x-show="newComments.length === 0" class="text-center py-8">
                <p class="text-surface-400 text-sm">هنوز نظری ثبت نشده. اولین نفر باشید!</p>
            </div>
            @endif
        </section>

        @push('scripts')
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('trackComments', (trackId) => ({
                newBody: '',
                submitting: false,
                replyTo: null,
                newComments: [],
                commentCount: {{ $comments->count() }},

                async submitComment() {
                    if (!this.newBody.trim() || this.submitting) return;
                    this.submitting = true;
                    const store = Alpine.store('player');
                    let ts = '';
                    if (store.currentTrack && store.currentTrack.id === trackId && store.audio) {
                        ts = Math.floor(store.audio.currentTime);
                    }
                    try {
                        const resp = await fetch('{{ route("comment.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                commentable_type: 'track',
                                commentable_id: trackId,
                                body: this.newBody,
                                timestamp_at: ts !== '' ? ts : null,
                            })
                        });
                        const data = await resp.json();
                        this.newComments.unshift(data);
                        this.commentCount++;
                        this.newBody = '';
                    } catch (e) { console.error(e); }
                    this.submitting = false;
                },

                async submitReply(parentId, body) {
                    if (!body || !body.trim()) return;
                    try {
                        await fetch('{{ route("comment.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                commentable_type: 'track',
                                commentable_id: trackId,
                                body: body,
                                parent_id: parentId,
                            })
                        });
                        this.replyTo = null;
                        // Simple feedback
                        this.commentCount++;
                    } catch (e) { console.error(e); }
                }
            }));
        });
        </script>
        @endpush

        {{-- Related Tracks --}}
        @if($relatedTracks->isNotEmpty())
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">آهنگ‌های مشابه</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($relatedTracks as $related)
                    @include('components.track-card', ['track' => $related])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-layouts.app>

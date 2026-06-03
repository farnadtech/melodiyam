<x-layouts.app :title="$album->title">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Album Header --}}
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0 relative bg-surface-100 dark:bg-surface-800">
                @php $albumCover = $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png'); @endphp
                {{-- Blurred background for non-square images --}}
                <img src="{{ $albumCover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-50 scale-110">
                {{-- Main image showing fully --}}
                <img src="{{ $albumCover }}" alt="{{ $album->title }}" class="relative z-10 w-full h-full object-contain">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                @if($album->is_explicit)
                <div class="mb-3 inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-red-500/10 border border-red-500/20 text-red-500 w-fit mx-auto md:mx-0">
                    <span class="flex items-center justify-center w-5 h-5 rounded bg-red-500 text-white text-[10px] font-bold">18+</span>
                    <span class="text-[11px] font-bold">مناسب برای زیر ۱۸ سال نیست</span>
                </div>
                @endif
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">{{ $album->type === 'single' ? 'سینگل' : 'آلبوم' }}</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-2">{{ $album->title }}</h1>
                @if($album->is_featured)
                <div class="flex items-center gap-2 justify-center md:justify-start mb-3">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-600 dark:text-amber-400 border border-amber-400/30">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        ویژه
                    </span>
                </div>
                @endif
                <div class="flex flex-wrap items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <a href="{{ route('artist.show', $album->artist ?? '') }}" wire:navigate class="font-medium text-surface-900 dark:text-white hover:text-primary-500">
                        {{ $album->artist->display_name ?? '' }}
                    </a>
                    @if($album->genre)
                    <span>·</span>
                    <span class="text-xs text-surface-500">ژانر:</span>
                    <a href="{{ route('genre.show', $album->genre) }}" wire:navigate class="hover:text-primary-500 font-medium">{{ $album->genre->title }}</a>
                    @endif
                    @if($album->release_date)
                    <span>·</span>
                    <span>{{ \App\Helpers\Jalali::format($album->release_date, 'Y') }}</span>
                    @endif
                    <span>·</span>
                    <span>{{ $album->tracks->count() }} آهنگ</span>
                    <span>·</span>
                    <span>{{ number_format($album->play_count) }} پخش</span>
                </div>

                {{-- Action Buttons --}}
                @php
                    $albumIsPaid = $album->is_for_sale && $album->price;
                    $albumPreviewSec = $album->preview_seconds ?? 0;

                    // A track is "effectively paid" if it has its own price OR belongs to a paid album without own price
                    $freeOrAccessibleTracks = $album->tracks->filter(function($t) use ($hasPlanAccess, $purchasedTrackIds, $albumAlreadyBought, $albumIsPaid) {
                        $trackHasOwnPrice = $t->is_for_sale && $t->price;
                        $effectivelyPaid = $trackHasOwnPrice || ($albumIsPaid && !$trackHasOwnPrice);
                        if (!$effectivelyPaid) return true;
                        return $hasPlanAccess || $albumAlreadyBought || in_array($t->id, $purchasedTrackIds);
                    });
                    $coverUrl = $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png');
                @endphp
                <div class="mt-5 flex items-center gap-3 justify-center md:justify-start flex-wrap" x-data="{ liked: {{ $userLikedAlbum ? 'true' : 'false' }}, likeCount: {{ $album->like_count ?? 0 }}, reposted: {{ $userRepostedAlbum ? 'true' : 'false' }}, repostCount: {{ $album->repost_count ?? 0 }}, toast: '', toastType: 'success', shareOpen: false }" x-init="$watch('toast', v => { if(v) setTimeout(() => toast = '', 3000) })">
                    {{-- Toast notification --}}
                    <div x-show="toast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] pointer-events-none" x-cloak>
                        <div class="px-5 py-2.5 rounded-xl shadow-xl text-sm font-medium backdrop-blur" :class="toastType === 'success' ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'" x-text="toast"></div>
                    </div>

                    @if($freeOrAccessibleTracks->isNotEmpty())
                    <button
                        @click="$store.player.playQueue({{ json_encode($freeOrAccessibleTracks->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'artist' => $album->artist->display_name ?? '', 'url' => $t->getStreamUrl(), 'cover' => $coverUrl, 'cover_page' => route('track.show', $t->slug ?? $t->id), 'artist_url' => $album->artist ? route('artist.show', $album->artist->slug) : '', 'duration' => $t->duration])->toArray()) }}, 0)"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-primary-500/30"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش همه
                    </button>
                    @endif
                    @if($freeOrAccessibleTracks->count() > 1)
                    <button
                        @click="$store.player.isShuffled = true; $store.player.playQueue({{ json_encode($freeOrAccessibleTracks->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'artist' => $album->artist->display_name ?? '', 'url' => $t->getStreamUrl(), 'cover' => $coverUrl, 'cover_page' => route('track.show', $t->slug ?? $t->id), 'artist_url' => $album->artist ? route('artist.show', $album->artist->slug) : '', 'duration' => $t->duration])->toArray()) }}, 0)"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-200 dark:bg-surface-700 hover:bg-surface-300 dark:hover:bg-surface-600 text-surface-700 dark:text-surface-200 text-sm font-semibold rounded-xl transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                        پخش تصادفی
                    </button>
                    @endif

                    {{-- Like button --}}
                    @auth
                    <button @click="
                        fetch('{{ route('like.toggle') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                            body: JSON.stringify({type: 'album', id: {{ $album->id }}})
                        }).then(r => r.json()).then(d => { liked = d.liked; likeCount += d.liked ? 1 : -1; })
                    " class="p-2.5 rounded-xl border transition-colors flex items-center gap-2" :class="liked ? 'border-rose-500 text-rose-500 bg-rose-50 dark:bg-rose-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-rose-500 hover:text-rose-500 text-surface-700 dark:text-surface-200'">
                        <svg class="w-5 h-5" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-sm font-medium" x-text="liked ? 'پسندیده شده' : 'پسندیدن'"></span>
                        <span x-show="likeCount > 0" class="text-xs opacity-60" x-text="likeCount"></span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" wire:navigate class="p-2.5 rounded-xl border border-surface-300 dark:border-surface-600 hover:border-rose-500 hover:text-rose-500 text-surface-700 dark:text-surface-200 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="text-sm font-medium">پسندیدن</span>
                        <span x-show="likeCount > 0" class="text-xs opacity-60" x-text="likeCount"></span>
                    </a>
                    @endauth

                    {{-- Repost button --}}
                    @auth
                    <button @click="
                        fetch('{{ route('repost.toggle') }}', {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                            body: JSON.stringify({type: 'album', id: {{ $album->id }}})
                        }).then(r => r.json()).then(d => { 
                            reposted = d.reposted; 
                            repostCount += d.reposted ? 1 : -1;
                            toast = d.reposted ? 'در فید شما بازنشر شد' : 'از فید شما حذف شد';
                            toastType = 'success';
                        })
                    " class="p-2.5 rounded-xl border transition-colors flex items-center gap-2" :class="reposted ? 'border-primary-500 text-primary-500 bg-primary-50 dark:bg-primary-500/10' : 'border-surface-300 dark:border-surface-600 hover:border-primary-500 hover:text-primary-500 text-surface-700 dark:text-surface-200'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="text-sm font-medium" x-text="reposted ? 'بازنشر شده' : 'بازنشر'"></span>
                        <span x-show="repostCount > 0" class="text-xs opacity-60" x-text="repostCount"></span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" wire:navigate class="p-2.5 rounded-xl border border-surface-300 dark:border-surface-600 hover:border-primary-500 hover:text-primary-500 text-surface-700 dark:text-surface-200 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="text-sm font-medium">بازنشر</span>
                        <span x-show="repostCount > 0" class="text-xs opacity-60" x-text="repostCount"></span>
                    </a>
                    @endauth

                    {{-- Share button --}}
                    <div class="relative">
                        <button @click="shareOpen = !shareOpen" class="p-2.5 rounded-xl border border-surface-300 dark:border-surface-600 hover:border-primary-500 transition-colors flex items-center gap-2 text-sm font-medium text-surface-700 dark:text-surface-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                {{-- Buy Album Button --}}
                @if($album->is_for_sale && $album->price)
                <div class="mt-4 flex items-center gap-3 justify-center md:justify-start">
                    @if($hasPlanAccess || $albumAlreadyBought)
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-sm font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
                        {{ $albumAlreadyBought ? 'خریداری شده' : 'دسترسی رایگان (پلن)' }}
                    </span>
                    @else
                    <a href="{{ route('purchase', ['type'=>'album','id'=>$album->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-primary-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        خرید آلبوم —
                        @if($album->discount_price)
                        <span class="line-through opacity-60 text-xs">{{ number_format($album->price) }}</span>
                        {{ number_format($album->discount_price) }} تومان
                        @else
                        {{ number_format($album->price) }} تومان
                        @endif
                    </a>
                    @endif
                </div>
                @endif

                {{-- Report button --}}
                @auth
                <div class="mt-3 flex justify-center md:justify-start">
                    <x-report-button type="album" :id="$album->id" label="گزارش تخلف" />
                </div>
                @endauth

                @if(session('success') || session('error') || session('info'))
                <div class="mt-3 px-4 py-2.5 rounded-xl text-sm
                    {{ session('success') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200' : (session('error') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border border-red-200' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 border border-blue-200') }}">
                    {{ session('success') ?? session('error') ?? session('info') }}
                </div>
                @endif
            </div>
        </div>

        {{-- Track List --}}
        <section>
            <x-sort-filters :currentSort="$sort" />
            
            <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
                @foreach($tracks as $track)
                @php
                    // Set album on track so getCoverUrl() uses album cover without extra query
                    $track->setRelation('album', $album);
                    $tCover = $track->getCoverUrl();
                    $tHasOwnPrice = $track->is_for_sale && $track->price;
                    // Effectively paid: own price OR album is paid (and track has no own price)
                    $tEffectivelyPaid = $tHasOwnPrice || ($albumIsPaid && !$tHasOwnPrice);
                    $tHasAccess = !$tEffectivelyPaid || $hasPlanAccess || $albumAlreadyBought || in_array($track->id, $purchasedTrackIds);
                    // Preview seconds: use track's own, fallback to album's preview_seconds
                    $tPreviewSec = ($track->preview_seconds ?? 0) > 0 ? $track->preview_seconds : $albumPreviewSec;
                    $tHasPreview = $tPreviewSec > 0;
                    // For purchase URL and price: use track's own if set, else album's
                    $tIsPaid = $tEffectivelyPaid;
                    $tPrice = $tHasOwnPrice ? $track->price : ($albumIsPaid ? $album->price : 0);
                    $tDiscountPrice = $tHasOwnPrice ? $track->discount_price : ($albumIsPaid ? $album->discount_price : null);
                    $tPurchaseUrl = $tHasOwnPrice
                        ? route('purchase', ['type'=>'track','id'=>$track->id])
                        : ($albumIsPaid ? route('purchase', ['type'=>'album','id'=>$album->id]) : null);
                @endphp
                <div class="flex items-center gap-3 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group" x-data>
                    <span class="text-sm text-surface-400 w-5 text-center flex-shrink-0 group-hover:hidden">{{ $track->track_number }}</span>
                    @php
                        $tData = json_encode([
                            'id'             => $track->id,
                            'title'          => $track->title,
                            'artist'         => $album->artist->display_name ?? '',
                            'url'            => $track->getStreamUrl(),
                            'cover'          => $tCover,
                            'cover_page'     => route('track.show', $track->slug ?? $track->id),
                            'artist_url'     => $album->artist ? route('artist.show', $album->artist->slug) : '',
                            'duration'       => $track->duration,
                            'previewSeconds' => $tHasAccess ? 0 : $tPreviewSec,
                            'canPlay'        => $tHasAccess,
                            'price'          => $tIsPaid ? (int)$tPrice : 0,
                            'discountPrice'  => $tIsPaid ? $tDiscountPrice : null,
                            'purchaseUrl'    => $tPurchaseUrl,
                        ]);
                    @endphp
                    {{-- Cover with play overlay --}}
                    <div class="relative w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="{{ $tCover }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                        @if($tHasAccess)
                        <button
                            @click="$store.player.play(JSON.parse(decodeURIComponent($el.dataset.track)))"
                            data-track="{{ rawurlencode($tData) }}"
                            class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity"
                        >
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                        @elseif($tHasPreview)
                        <button
                            @click="$store.player.play(JSON.parse(decodeURIComponent($el.dataset.track)))"
                            data-track="{{ rawurlencode($tData) }}"
                            class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity"
                            title="پخش پیش‌نمایش"
                        >
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                        @else
                        <button
                            @click="$store.player.showPurchaseModal(JSON.parse(decodeURIComponent($el.dataset.track)))"
                            data-track="{{ rawurlencode($tData) }}"
                            class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity"
                            title="خرید آهنگ"
                        >
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </button>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 hover:text-primary-500 truncate block">{{ $track->title }}</a>
                        <p class="text-xs text-surface-400 truncate">{{ $track->artist->display_name ?? $album->artist->display_name ?? '' }}</p>
                    </div>
                    <span class="text-xs text-surface-400 tabular-nums">{{ $track->formattedDuration() }}</span>

                    {{-- قیمت یا وضعیت خرید --}}
                    @if($track->is_for_sale && $track->price)
                        @if($hasPlanAccess || in_array($track->id, $purchasedTrackIds) || $albumAlreadyBought)
                        <span class="text-xs text-emerald-500 font-medium px-2 py-0.5 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">✓</span>
                        @else
                        <a href="{{ route('purchase', ['type'=>'track','id'=>$track->id]) }}" class="text-xs font-semibold px-3 py-1 rounded-lg bg-primary-500 hover:bg-primary-600 text-white transition whitespace-nowrap">
                            {{ number_format($track->discount_price ?: $track->price) }} ت
                        </a>
                        @endif
                    @else
                    <span class="text-xs text-surface-400">{{ number_format($track->play_count) }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.app>

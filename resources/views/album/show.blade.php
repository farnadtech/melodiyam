<x-layouts.app :title="$album->title">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Album Header --}}
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png') }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">{{ $album->type === 'single' ? 'سینگل' : 'آلبوم' }}</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $album->title }}</h1>
                <div class="flex flex-wrap items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <a href="{{ route('artist.show', $album->artist ?? '') }}" wire:navigate class="font-medium text-surface-900 dark:text-white hover:text-primary-500">
                        {{ $album->artist->display_name ?? '' }}
                    </a>
                    @if($album->release_date)
                    <span>·</span>
                    <span>{{ $album->release_date->year }}</span>
                    @endif
                    <span>·</span>
                    <span>{{ $album->tracks->count() }} آهنگ</span>
                    <span>·</span>
                    <span>{{ number_format($album->play_count) }} پخش</span>
                </div>

                {{-- Action Buttons --}}
                @php
                    $freeOrAccessibleTracks = $album->tracks->filter(function($t) use ($hasPlanAccess, $purchasedTrackIds, $albumAlreadyBought) {
                        if (!$t->is_for_sale || !$t->price) return true;
                        return $hasPlanAccess || $albumAlreadyBought || in_array($t->id, $purchasedTrackIds);
                    });
                    $coverUrl = $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png');
                @endphp
                <div class="mt-5 flex items-center gap-3 justify-center md:justify-start flex-wrap" x-data>
                    @if($freeOrAccessibleTracks->isNotEmpty())
                    <button
                        @click="$store.player.playQueue({{ json_encode($freeOrAccessibleTracks->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'artist' => $album->artist->display_name ?? '', 'url' => $t->getStreamUrl(), 'cover' => $coverUrl, 'duration' => $t->duration])->toArray()) }}, 0)"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-primary-500/30"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        پخش همه
                    </button>
                    @endif
                    <button
                        @click="$store.player.isShuffled = true; $store.player.playQueue({{ json_encode($freeOrAccessibleTracks->values()->map(fn($t) => ['id' => $t->id, 'title' => $t->title, 'artist' => $album->artist->display_name ?? '', 'url' => $t->getStreamUrl(), 'cover' => $coverUrl, 'duration' => $t->duration])->toArray()) }}, 0)"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-200 dark:bg-surface-700 hover:bg-surface-300 dark:hover:bg-surface-600 text-surface-700 dark:text-surface-200 text-sm font-semibold rounded-xl transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                        پخش تصادفی
                    </button>
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
            <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
                @foreach($album->tracks as $track)
                @php
                    // Set album on track so getCoverUrl() uses album cover without extra query
                    $track->setRelation('album', $album);
                    $tCover = $track->getCoverUrl();
                    $tIsPaid = $track->is_for_sale && $track->price;
                    $tHasAccess = !$tIsPaid || $hasPlanAccess || $albumAlreadyBought || in_array($track->id, $purchasedTrackIds);
                    $tHasPreview = ($track->preview_seconds ?? 0) > 0;
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
                            'duration'       => $track->duration,
                            'previewSeconds' => $tHasAccess ? 0 : ($track->preview_seconds ?? 0),
                            'canPlay'        => $tHasAccess,
                            'price'          => $tIsPaid ? (int)$track->price : 0,
                            'discountPrice'  => $tIsPaid ? $track->discount_price : null,
                            'purchaseUrl'    => $tIsPaid ? route('purchase', ['type'=>'track','id'=>$track->id]) : null,
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

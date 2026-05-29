<x-layouts.app :title="$playlist->title">
    <div class="p-4 lg:p-8 space-y-8">

        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0 relative bg-surface-100 dark:bg-surface-800">
                @php $cover = $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : asset('images/default-playlist.png'); @endphp
                {{-- Blurred background for non-square images --}}
                <img src="{{ $cover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-50 scale-110">
                {{-- Main image showing fully --}}
                <img src="{{ $cover }}" alt="{{ $playlist->title }}" class="relative z-10 w-full h-full object-contain">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">پلی‌لیست</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $playlist->title }}</h1>
                @if($playlist->description)
                <p class="text-sm text-surface-500 mb-3">{{ $playlist->description }}</p>
                @endif
                <div class="flex items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <span>{{ $playlist->user->name ?? '' }}</span>
                    <span>·</span>
                    <span>{{ $playlist->tracks->count() }} آهنگ</span>
                </div>

                @if($playlist->tracks->isNotEmpty())
                <div class="flex items-center gap-3 mt-5 flex-wrap" x-data>
                    <button
                        @click="$store.player.playQueue([
                            @foreach($playlist->tracks as $track)
                            @php
                                $qIsPremiumOnly = (bool) $track->is_premium_only;
                                $qIsPremiumUser = auth()->user()?->isPremium() ?? false;
                                $qPremiumPreview = $qIsPremiumOnly && !$qIsPremiumUser ? (int) \App\Models\Setting::get('premium_preview_seconds', 30) : 0;
                                $qIsPaid = !$qIsPremiumOnly && $track->is_for_sale && $track->price;
                                $qCanPlay = (!$qIsPremiumOnly || $qIsPremiumUser) && !$qIsPaid;
                                $qPreview = $qIsPremiumOnly ? $qPremiumPreview : ($track->preview_seconds ?? 0);
                            @endphp
                            { id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist->slug) : '' }}', duration: {{ $track->duration }}, canPlay: {{ $qCanPlay ? 'true' : 'false' }}, previewSeconds: {{ $qPreview }}, isPremium: {{ $qIsPremiumOnly && !$qIsPremiumUser ? 'true' : 'false' }}, price: {{ $track->discount_price ?: ($track->price ?? 0) }}, purchaseUrl: '{{ $qIsPremiumOnly ? route('premium') : route('purchase', ['type' => 'track', 'id' => $track->id]) }}' }{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        ], 0)"
                        class="w-12 h-12 rounded-full bg-primary-500 hover:bg-primary-400 hover:scale-105 flex items-center justify-center shadow-lg shadow-primary-500/30 transition-all"
                    >
                        <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <button
                        @click="let tracks = [
                            @foreach($playlist->tracks as $track)
                            @php
                                $sqIsPremiumOnly = (bool) $track->is_premium_only;
                                $sqIsPremiumUser = auth()->user()?->isPremium() ?? false;
                                $sqPremiumPreview = $sqIsPremiumOnly && !$sqIsPremiumUser ? (int) \App\Models\Setting::get('premium_preview_seconds', 30) : 0;
                                $sqIsPaid = !$sqIsPremiumOnly && $track->is_for_sale && $track->price;
                                $sqCanPlay = (!$sqIsPremiumOnly || $sqIsPremiumUser) && !$sqIsPaid;
                                $sqPreview = $sqIsPremiumOnly ? $sqPremiumPreview : ($track->preview_seconds ?? 0);
                            @endphp
                            { id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist->slug) : '' }}', duration: {{ $track->duration }}, canPlay: {{ $sqCanPlay ? 'true' : 'false' }}, previewSeconds: {{ $sqPreview }}, isPremium: {{ $sqIsPremiumOnly && !$sqIsPremiumUser ? 'true' : 'false' }}, price: {{ $track->discount_price ?: ($track->price ?? 0) }}, purchaseUrl: '{{ $sqIsPremiumOnly ? route('premium') : route('purchase', ['type' => 'track', 'id' => $track->id]) }}' }{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        ]; let shuffled = [...tracks].sort(() => Math.random() - 0.5); $store.player.playQueue(shuffled, 0)"
                        class="w-12 h-12 rounded-full bg-surface-100 dark:bg-surface-800 hover:bg-surface-200 dark:hover:bg-surface-700 flex items-center justify-center transition-colors"
                        title="پخش تصادفی"
                    >
                        <svg class="w-5 h-5 text-surface-600 dark:text-surface-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"/></svg>
                    </button>

                    {{-- Like Button --}}
                    @auth
                    <button
                        x-data="{ liked: {{ $isLiked ? 'true' : 'false' }} }"
                        x-on:click="fetch('/like/toggle', {
                            method: 'POST',
                            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
                            body: JSON.stringify({type:'playlist', id:{{ $playlist->id }}})
                        }).then(r=>r.json()).then(d=>{ liked = d.liked })"
                        x-bind:class="liked ? 'text-rose-500 bg-rose-50 dark:bg-rose-900/30 border-rose-300 dark:border-rose-700' : 'text-surface-500 bg-surface-100 dark:bg-surface-800 border-surface-200 dark:border-surface-700'"
                        class="flex items-center gap-2 px-4 py-2 rounded-full border text-sm font-medium transition-colors"
                        title="لایک پلی‌لیست"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span x-text="liked ? 'ذخیره شد' : 'ذخیره'"></span>
                    </button>
                    @endauth

                    {{-- Owner Actions --}}
                    @auth
                    @if(auth()->id() === $playlist->user_id)
                    <a href="{{ route('playlist.edit', $playlist) }}" wire:navigate
                        class="flex items-center gap-2 px-4 py-2 rounded-full border border-surface-200 dark:border-surface-700 text-surface-500 bg-surface-100 dark:bg-surface-800 text-sm font-medium transition-colors hover:bg-surface-200 dark:hover:bg-surface-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        ویرایش
                    </a>
                    @endif
                    @endauth
                </div>
                @endif
            </div>
        </div>

        {{-- Track List --}}
        <div class="space-y-4">
            <x-sort-filters :currentSort="$sort" />
            
            <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
                @foreach($tracks as $i => $track)
            <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group" x-data>
                <span class="text-sm text-surface-400 w-6 text-center">{{ $i + 1 }}</span>
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                    <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 hover:text-primary-500 truncate block">{{ $track->title }}</a>
                    <p class="text-xs text-surface-400 truncate">{{ $track->artist->display_name ?? '' }}</p>
                </div>
                @php
                    $plIsPremiumOnly = (bool) $track->is_premium_only;
                    $plIsPremiumUser = auth()->user()?->isPremium() ?? false;
                    $plPremiumPreview = $plIsPremiumOnly && !$plIsPremiumUser
                        ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                        : 0;
                    $plIsPaid = !$plIsPremiumOnly && $track->is_for_sale && $track->price;
                    $plPreview = $track->preview_seconds ?? 0;
                    $plCanPlay = (!$plIsPremiumOnly || $plIsPremiumUser) && !$plIsPaid;
                    $plPurchaseUrl = route('purchase', ['type'=>'track','id'=>$track->id]);
                    $plCoverPage = route('track.show', $track);
                    $plArtistUrl = $track->artist ? route('artist.show', $track->artist->slug) : '';
                @endphp
                @if($plIsPremiumOnly)
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 leading-none whitespace-nowrap">پریمیوم</span>
                @elseif($plIsPaid)
                <span class="text-xs font-bold text-primary-500 whitespace-nowrap">{{ number_format($track->discount_price ?: $track->price) }} ت</span>
                @else
                <span class="text-xs text-surface-400">{{ $track->formattedDuration() }}</span>
                @endif
                <button
                    @click="@if($plIsPremiumOnly && !$plIsPremiumUser)$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ $plCoverPage }}', artist_url: '{{ $plArtistUrl }}', duration: {{ $track->duration }}, previewSeconds: {{ $plPremiumPreview }}, canPlay: false, isPremium: true, purchaseUrl: '{{ route('premium') }}' })@elseif($plIsPaid && $plPreview == 0)$store.player.showPurchaseModal({ title: '{{ e($track->title) }}', price: {{ $track->discount_price ?: $track->price }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $plPurchaseUrl }}' })@else$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ $plCoverPage }}', artist_url: '{{ $plArtistUrl }}', duration: {{ $track->duration }}, canPlay: {{ $plCanPlay ? 'true' : 'false' }}, previewSeconds: {{ $plPreview }}, price: {{ $track->discount_price ?: ($track->price ?? 0) }}, purchaseUrl: '{{ $plPurchaseUrl }}' })@endif"
                    class="opacity-0 group-hover:opacity-100 w-8 h-8 rounded-full {{ $plIsPremiumOnly && !$plIsPremiumUser ? 'bg-purple-500' : 'bg-primary-500' }} flex items-center justify-center transition-opacity"
                >
                    <svg class="w-3.5 h-3.5 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>

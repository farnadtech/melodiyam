@php
    $isPremiumOnly = (bool) $track->is_premium_only;
    $isPremiumUser = auth()->user()?->isPremium() ?? false;
    $premiumPreview = $isPremiumOnly && !$isPremiumUser
        ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
        : 0;
    $isPaid = !$isPremiumOnly && $track->is_for_sale && $track->price;
    $previewSec = $track->preview_seconds ?? 0;
    $canPlay = !$isPaid && (!$isPremiumOnly || $isPremiumUser);
    $purchaseUrl = route('purchase', ['type' => 'track', 'id' => $track->id]);
    $trackUrl = route('track.show', $track);
    $artistUrl = $track->artist ? route('artist.show', $track->artist->slug) : '';
    $cover = $track->cover_image ? asset('storage/'.$track->cover_image) : asset('images/default-cover.png');

    // Build player data JSON for the click handler
    $playerData = [
        'id' => $track->id,
        'title' => $track->title,
        'artist' => $track->artist->display_name ?? '',
        'url' => $track->getStreamUrl(),
        'cover' => $track->getCoverUrl(),
        'cover_page' => $trackUrl,
        'artist_url' => $artistUrl,
        'duration' => $track->duration,
        'previewSeconds' => $isPremiumOnly ? $premiumPreview : $previewSec,
        'canPlay' => $canPlay,
        'price' => $track->discount_price ?: ($track->price ?? 0),
        'discountPrice' => $track->discount_price ?: null,
        'purchaseUrl' => $purchaseUrl,
    ];
    if ($isPremiumOnly) {
        $playerData['isPremium'] = true;
        $playerData['purchaseUrl'] = route('premium');
    }
@endphp
<div class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group relative">
    <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
        <img src="{{ $cover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
        <img src="{{ $cover }}" alt="{{ $track->title }}" class="relative z-10 w-full h-full object-contain">

        @if($isPremiumOnly)
        <div class="absolute top-2 left-2 bg-purple-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">پریمیوم</div>
        @elseif($isPaid)
        <div class="absolute top-2 left-2 bg-primary-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
            {{ number_format($track->discount_price ?: $track->price) }} ت
        </div>
        @endif

        @if($badge)
        <span class="absolute top-2 right-2 text-lg z-10">{{ $badge }}</span>
        @endif

        {{-- Play button overlay --}}
        <button type="button"
            x-data
            @click.stop="
                @if($isPremiumOnly && !$isPremiumUser)
                    $store.player.play({{ Js::from($playerData) }})
                @elseif($isPaid && $previewSec == 0)
                    $store.player.showPurchaseModal({ title: '{{ e($track->title) }}', price: {{ $track->discount_price ?: $track->price }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $purchaseUrl }}' })
                @else
                    $store.player.play({{ Js::from($playerData) }})
                @endif
            "
            class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity z-20">
            @if($isPaid && $previewSec == 0)
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            @else
            <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            @endif
        </button>
    </div>

    @if($reason)
    <span class="inline-block bg-primary-500/10 text-primary-500 text-[10px] font-medium px-2 py-0.5 rounded-full mb-1.5 max-w-full truncate">{{ $reason }}</span>
    @endif

    <a href="{{ $trackUrl }}" wire:navigate class="block">
        <div class="flex items-center gap-1.5">
            <p class="font-medium text-surface-900 dark:text-white text-sm truncate hover:text-primary-500 transition-colors">{{ $track->title }}</p>
            @if($track->is_explicit)
            <span class="text-[10px] font-bold px-1 py-0.5 rounded bg-red-500/10 text-red-500 border border-red-500/20 leading-none">18+</span>
            @endif
        </div>
        <p class="text-xs text-surface-500 truncate mt-1">{{ $track->artist->display_name ?? '' }}</p>
    </a>
</div>

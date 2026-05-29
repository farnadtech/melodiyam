<div class="music-card" x-data>
    <div class="music-card-cover relative overflow-hidden bg-surface-100 dark:bg-surface-800">
        @php $cover = $track->getCoverUrl(); @endphp
        {{-- Blurred background for non-square images --}}
        <img src="{{ $cover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
        {{-- Main image showing fully --}}
        <img
            src="{{ $cover }}"
            alt="{{ $track->title }}"
            class="relative z-10 w-full h-full object-contain"
            loading="lazy"
        >
        <div class="play-button-overlay z-20">
            @php
                $isPremiumOnly = (bool) $track->is_premium_only;
                $isPremiumUser = auth()->user()?->isPremium() ?? false;
                $premiumPreviewSec = $isPremiumOnly && !$isPremiumUser
                    ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                    : 0;
                $isPaid = !$isPremiumOnly && $track->is_for_sale && $track->price;
                $previewSec = $track->preview_seconds ?? 0;
                $trackPurchaseUrl = route('purchase', ['type' => 'track', 'id' => $track->id]);
                $trackPrice = $track->discount_price ?: $track->price;
            @endphp
            @if($isPremiumOnly && !$isPremiumUser)
            {{-- Premium track: play preview seconds then show upgrade modal --}}
            <button
                @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track->slug ?? $track->id) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist->slug) : '' }}', duration: {{ $track->duration }}, previewSeconds: {{ $premiumPreviewSec }}, canPlay: false, isPremium: true, purchaseUrl: '{{ route('premium') }}' })"
                class="w-12 h-12 rounded-full bg-purple-500 hover:bg-purple-400 flex items-center justify-center shadow-lg shadow-purple-500/40 hover:scale-110 transition-all"
            >
                @if($premiumPreviewSec > 0)
                <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                @else
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                @endif
            </button>
            @elseif($isPaid && $previewSec == 0)
            {{-- No preview: clicking shows purchase modal immediately --}}
            <button
                @click="$store.player.showPurchaseModal({ title: '{{ e($track->title) }}', price: {{ $trackPrice ?? 0 }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $trackPurchaseUrl }}' })"
                class="w-12 h-12 rounded-full bg-primary-500 hover:bg-primary-400 flex items-center justify-center shadow-lg shadow-primary-500/40 hover:scale-110 transition-all"
            >
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </button>
            @else
            {{-- Free or has preview: play normally (previewSeconds > 0 handled by player timer) --}}
            <button
                @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ route('track.show', $track->slug ?? $track->id) }}', artist_url: '{{ $track->artist ? route('artist.show', $track->artist->slug) : '' }}', duration: {{ $track->duration }}, previewSeconds: {{ $previewSec }}, canPlay: {{ $isPaid ? 'false' : 'true' }}, price: {{ $trackPrice ?? 0 }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $trackPurchaseUrl }}' })"
                class="w-12 h-12 rounded-full bg-primary-500 hover:bg-primary-400 flex items-center justify-center shadow-lg shadow-primary-500/40 hover:scale-110 transition-all"
            >
                <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </button>
            @endif
        </div>
    </div>
    <div class="mt-3 min-w-0">
        <div class="flex items-center gap-1 mb-1">
            @if($isPremiumOnly)
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 leading-none">پریمیوم</span>
            @endif
            @if($track->is_featured)
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-400/20 text-amber-600 dark:text-amber-400 leading-none">ویژه</span>
            @endif
            @if($track->is_explicit)
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-red-500/10 text-red-500 border border-red-500/20 leading-none">18+</span>
            @endif
        </div>
        <a href="{{ route('track.show', $track) }}" wire:navigate class="block text-sm font-medium text-surface-900 dark:text-surface-100 truncate hover:text-primary-500 transition-colors">
            {{ $track->title }}
        </a>
        <div class="flex items-center justify-between mt-0.5">
            <a href="{{ route('artist.show', $track->artist ?? '') }}" wire:navigate class="block text-xs text-surface-500 dark:text-surface-400 truncate hover:text-primary-500 transition-colors">
                {{ $track->artist->display_name ?? 'نامشخص' }}
            </a>
            @if($track->is_for_sale && $track->price)
            <span class="whitespace-nowrap mr-1 flex items-center gap-1">
                @if($track->discount_price)
                <span class="text-xs text-surface-400 line-through">{{ number_format($track->price) }}</span>
                <span class="text-xs font-bold text-primary-500">{{ number_format($track->discount_price) }} ت</span>
                @else
                <span class="text-xs font-bold text-primary-500">{{ number_format($track->price) }} ت</span>
                @endif
            </span>
            @endif
        </div>
    </div>
</div>

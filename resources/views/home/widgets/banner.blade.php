@php
    $cfg = $section->config ?? [];
    $bannerImage = !empty($cfg['banner_image']) ? asset('storage/'.$cfg['banner_image']) : null;
    $bannerTitle = $cfg['banner_title'] ?? null;
    $bannerUrl   = $cfg['banner_url']   ?? '#';
    $bannerBg    = $cfg['banner_bg']    ?? null;
    $btnLabel    = $cfg['banner_btn_label'] ?? 'مشاهده';

    if (!$bannerImage && !$bannerTitle) return;
@endphp

<section>
    <a href="{{ $bannerUrl }}" wire:navigate
       class="block relative overflow-hidden rounded-2xl group"
       style="{{ $bannerBg ? 'background-color:'.$bannerBg : '' }}">
        @if($bannerImage)
        <img src="{{ $bannerImage }}" alt="{{ $bannerTitle }}"
             class="w-full h-40 md:h-56 object-cover group-hover:scale-105 transition-transform duration-500">
        @endif
        @if($bannerTitle)
        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/20 transition">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-white mb-3">{{ $bannerTitle }}</h3>
                <span class="inline-block px-5 py-2 bg-white text-surface-900 rounded-xl text-sm font-bold shadow-lg">
                    {{ $btnLabel }}
                </span>
            </div>
        </div>
        @endif
    </a>
</section>

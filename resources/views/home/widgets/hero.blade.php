@php
    $cfg = $section->config ?? [];
    $heroTitle    = !empty($cfg['hero_title'])    ? $cfg['hero_title']    : null;
    $heroSubtitle = !empty($cfg['hero_subtitle']) ? $cfg['hero_subtitle'] : null;
    $btn1Label    = !empty($cfg['hero_btn1_label']) ? $cfg['hero_btn1_label'] : null;
    $btn1Url      = !empty($cfg['hero_btn1_url'])   ? $cfg['hero_btn1_url']   : '#';
    $btn2Label    = !empty($cfg['hero_btn2_label']) ? $cfg['hero_btn2_label'] : null;
    $btn2Url      = !empty($cfg['hero_btn2_url'])   ? $cfg['hero_btn2_url']   : '#';
    $colorFrom    = $cfg['hero_color_from'] ?? null;
    $colorTo      = $cfg['hero_color_to']   ?? null;
    $heroImage    = !empty($cfg['hero_image']) ? asset('storage/'.$cfg['hero_image']) : null;
    $gradientStyle = $colorFrom && $colorTo
        ? "background: linear-gradient(135deg, {$colorFrom}, {$colorTo});"
        : '';
@endphp

<section class="relative overflow-hidden rounded-3xl p-8 lg:p-12 gradient-primary"
    @if($gradientStyle) style="{{ $gradientStyle }}" @endif>
    @if($heroImage)
        <div class="absolute inset-0 rounded-3xl overflow-hidden">
            <img src="{{ $heroImage }}" class="w-full h-full object-cover opacity-30" alt="">
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-l from-black/20 to-transparent rounded-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

    <div class="relative z-10 max-w-2xl">
        @if($heroTitle)
        <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-white mb-4 leading-tight">
            {{ $heroTitle }}
        </h1>
        @endif
        @if($heroSubtitle)
        <p class="text-base lg:text-lg text-white/80 mb-6 leading-relaxed">{{ $heroSubtitle }}</p>
        @endif
        @if($btn1Label || $btn2Label)
        <div class="flex flex-wrap gap-3">
            @if($btn1Label)
            <a href="{{ $btn1Url }}" wire:navigate
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-primary-600 font-bold text-sm hover:bg-white/90 transition-colors shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2z"/></svg>
                {{ $btn1Label }}
            </a>
            @endif
            @if($btn2Label)
            <a href="{{ $btn2Url }}" wire:navigate
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white/20 text-white font-medium text-sm hover:bg-white/30 transition-colors backdrop-blur-sm">
                {{ $btn2Label }}
            </a>
            @endif
        </div>
        @endif
    </div>
</section>

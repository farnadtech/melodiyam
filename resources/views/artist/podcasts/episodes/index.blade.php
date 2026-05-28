<x-layouts.app title="قسمت‌های {{ $podcast->title }}">
<div class="p-4 lg:p-8 space-y-8 max-w-5xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">{{ $podcast->title }}</h1>
            <p class="text-sm text-surface-500 mt-1">مدیریت قسمت‌های پادکست</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('artist.podcasts.episodes.create', $podcast) }}" class="btn-primary px-4 py-2 text-sm">
                + قسمت جدید
            </a>
            <a href="{{ route('artist.podcasts.index') }}" class="btn-ghost px-4 py-2 text-sm border border-surface-300">
                بازگشت
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="rounded-2xl px-5 py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="rounded-2xl px-5 py-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 text-sm">
        {{ session('error') }}
    </div>
    @endif

    @if($episodes->isEmpty())
    <div class="glass-card rounded-2xl p-10 text-center text-surface-500">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-medium">هنوز قسمتی ندارید</p>
        <p class="text-sm mt-1">با کلیک روی دکمه بالا اولین قسمت را اضافه کنید</p>
    </div>
    @else
    @php
        $episodesBySeason = $episodes->groupBy('season_number');
        $seasons = $episodesBySeason->keys()->sortDesc();
    @endphp
    @foreach($seasons as $season)
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-surface-600 dark:text-surface-400 mb-3 flex items-center gap-2">
            <span class="px-3 py-1 bg-surface-100 dark:bg-surface-800 rounded-full">فصل {{ $season }}</span>
        </h3>
        <div class="space-y-3">
        @foreach($episodesBySeason[$season] as $episode)
        <div class="glass-card rounded-2xl p-5 flex flex-col sm:flex-row gap-4 items-start sm:items-center">
            <div class="flex items-center gap-4 flex-1">
                <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-lg">
                    {{ $episode->episode_number }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-surface-900 dark:text-white truncate">{{ $episode->title }}</h3>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-surface-500 mt-1">
                        <span>{{ $episode->formattedDuration() }}</span>
                        <span>•</span>
                        <span>{{ $episode->play_count }} پخش</span>
                        @if($episode->status === 'draft')
                        <span class="px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded">پیش‌نویس</span>
                        @elseif($episode->status === 'pending')
                        <span class="px-2 py-0.5 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded">در انتظار تایید</span>
                        @elseif($episode->status === 'published')
                        <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded">منتشر</span>
                        @endif
                        @if($episode->is_premium_only)
                        <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded">پریمیوم</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 self-end sm:self-auto">
                <button 
                    @click="$dispatch('play-track', { 
                        id: 'episode-{{ $episode->id }}',
                        title: '{{ $episode->title }}',
                        artist: '{{ $podcast->artist->display_name ?? '' }}',
                        cover: '{{ $episode->getCoverUrl() }}',
                        url: '{{ $episode->getStreamUrl() }}'
                    })"
                    class="p-2 text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors" title="پخش">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
                <a href="{{ route('artist.podcasts.episodes.edit', [$podcast, $episode]) }}" class="px-3 py-2 rounded-xl text-sm font-medium btn-ghost border border-surface-300">
                    ویرایش
                </a>
                <form action="{{ route('artist.podcasts.episodes.destroy', [$podcast, $episode]) }}" method="POST" class="inline" onsubmit="return confirm('آیا مطمئنید؟ این قسمت حذف خواهد شد.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-2 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 border border-rose-200 dark:border-rose-800">
                        حذف
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        </div>
    </div>
    @endforeach
    @endif

</div>
</x-layouts.app>

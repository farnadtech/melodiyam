<x-layouts.app title="پادکست‌های من">
<div class="p-4 lg:p-8 space-y-8 max-w-5xl mx-auto">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پادکست‌های من</h1>
            <p class="text-sm text-surface-500 mt-1">پادکست‌های خود را مدیریت کنید</p>
        </div>
        <a href="{{ route('artist.podcasts.create') }}" class="btn-primary px-4 py-2 text-sm">
            + پادکست جدید
        </a>
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

    @if($podcasts->isEmpty())
    <div class="glass-card rounded-2xl p-10 text-center text-surface-500">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
        <p class="font-medium">هنوز پادکستی ندارید</p>
        <p class="text-sm mt-1">با کلیک روی دکمه بالا اولین پادکست خود را بسازید</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($podcasts as $podcast)
        <div class="glass-card rounded-2xl overflow-hidden flex flex-col">
            <div class="aspect-square bg-surface-100 dark:bg-surface-800 relative">
                <img src="{{ $podcast->cover_image ? asset('storage/'.$podcast->cover_image) : asset('images/default-cover.png') }}" class="w-full h-full object-cover">
                @if($podcast->status === 'draft')
                <span class="absolute top-2 right-2 px-2 py-1 bg-amber-500 text-white text-xs rounded-lg">پیش‌نویس</span>
                @elseif($podcast->status === 'published')
                <span class="absolute top-2 right-2 px-2 py-1 bg-emerald-500 text-white text-xs rounded-lg">منتشر</span>
                @endif
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-bold text-surface-900 dark:text-white mb-1">{{ $podcast->title }}</h3>
                <p class="text-sm text-surface-500 mb-3 line-clamp-2">{{ $podcast->description ?: 'بدون توضیحات' }}</p>
                <div class="flex items-center gap-4 text-xs text-surface-400 mb-4">
                    <span>{{ $podcast->episodes_count }} قسمت</span>
                    <span>{{ $podcast->subscribers_count }} مشترک</span>
                </div>
                <div class="mt-auto flex items-center gap-2">
                    <a href="{{ route('artist.podcasts.episodes.index', $podcast) }}" class="flex-1 py-2 rounded-xl text-center text-sm font-medium btn-primary">
                        قسمت‌ها
                    </a>
                    <a href="{{ route('artist.podcasts.edit', $podcast) }}" class="px-3 py-2 rounded-xl text-sm font-medium btn-ghost border border-surface-300">
                        ویرایش
                    </a>
                    <form action="{{ route('artist.podcasts.destroy', $podcast) }}" method="POST" class="inline" onsubmit="return confirm('آیا مطمئنید؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-2 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 border border-rose-200 dark:border-rose-800">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
</x-layouts.app>

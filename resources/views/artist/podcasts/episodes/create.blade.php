<x-layouts.app title="افزودن قسمت به {{ $podcast->title }}">
<div class="p-4 lg:p-8 max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('artist.podcasts.episodes.index', $podcast) }}" wire:navigate class="text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">افزودن قسمت جدید</h1>
            <p class="text-sm text-surface-500">{{ $podcast->title }}</p>
        </div>
    </div>

    @if(session('error'))
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <p class="text-sm text-rose-600 dark:text-rose-400">{{ session('error') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.podcasts.episodes.store', $podcast) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">اطلاعات قسمت</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">عنوان قسمت <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توضیحات</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره فصل</label>
                    <input type="number" name="season_number" value="{{ old('season_number', 1) }}" min="1"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره قسمت</label>
                    <input type="number" name="episode_number" value="{{ old('episode_number', $nextEpisode) }}" min="1"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">فایل‌ها</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">فایل صوتی <span class="text-rose-500">*</span></label>
                <input type="file" name="file" required accept=".mp3,.wav,.ogg,.m4a"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                <p class="text-xs text-surface-400 mt-1">MP3، WAV، OGG، M4A — حداکثر ۱۰۰ مگابایت</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر کاور قسمت (اختیاری)</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-surface-100 file:text-surface-700 hover:file:bg-surface-200 dark:file:bg-surface-700 dark:file:text-surface-300">
                <p class="text-xs text-surface-400 mt-1">اگر خالی بماند از کاور پادکست استفاده می‌شود</p>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">تنظیمات</h2>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_explicit" value="1" {{ old('is_explicit') ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                    <span class="text-sm text-surface-700 dark:text-surface-300">محتوای نامناسب</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-3">افزودن قسمت</button>
            <a href="{{ route('artist.podcasts.episodes.index', $podcast) }}" wire:navigate class="btn-ghost px-6 py-3">انصراف</a>
        </div>
    </form>
</div>
</x-layouts.app>

<x-layouts.app title="ویرایش قسمت: {{ $episode->title }}">
<div class="p-4 lg:p-8 max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('artist.podcasts.episodes.index', $podcast) }}" wire:navigate class="text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">ویرایش قسمت</h1>
            <p class="text-sm text-surface-500">{{ $podcast->title }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.podcasts.episodes.update', [$podcast, $episode]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">اطلاعات قسمت</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">عنوان قسمت <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $episode->title) }}" required
                       class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توضیحات</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $episode->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره فصل</label>
                    <input type="number" name="season_number" value="{{ old('season_number', $episode->season_number) }}" min="1"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره قسمت</label>
                    <input type="number" name="episode_number" value="{{ old('episode_number', $episode->episode_number) }}" min="1"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">فایل‌ها</h2>

            @if($episode->file_path)
            <div class="flex items-center gap-3 text-sm">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 3-2 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 3-2 3 2zM9 10l12-3"/></svg>
                <span class="text-emerald-600 dark:text-emerald-400">فایل صوتی موجود است</span>
                <span class="text-surface-400">({{ $episode->formattedDuration() }})</span>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تغییر فایل صوتی (اختیاری)</label>
                <input type="file" name="file" accept=".mp3,.wav,.ogg,.m4a"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر کاور</label>
                @if($episode->cover_image)
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ asset('storage/'.$episode->cover_image) }}" class="w-12 h-12 rounded-lg object-cover">
                    <span class="text-xs text-surface-400">کاور فعلی</span>
                </div>
                @endif
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-surface-100 file:text-surface-700 hover:file:bg-surface-200 dark:file:bg-surface-700 dark:file:text-surface-300">
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">تنظیمات</h2>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_explicit" value="1" {{ old('is_explicit', $episode->is_explicit) ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                    <span class="text-sm text-surface-700 dark:text-surface-300">محتوای نامناسب</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-3">ذخیره تغییرات</button>
            <a href="{{ route('artist.podcasts.episodes.index', $podcast) }}" wire:navigate class="btn-ghost px-6 py-3">انصراف</a>
        </div>
    </form>
</div>
</x-layouts.app>

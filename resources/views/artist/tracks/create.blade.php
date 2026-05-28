<x-layouts.app title="آپلود آهنگ جدید">
<div class="p-4 lg:p-8 max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('artist.tracks') }}" wire:navigate class="text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آپلود آهنگ جدید</h1>
    </div>

    @if($errors->any())
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.tracks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">اطلاعات اصلی</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">عنوان آهنگ <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required
                       class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">آلبوم (اختیاری)</label>
                    <select name="album_id" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">بدون آلبوم</option>
                        @foreach($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ژانر</label>
                    <select name="genre_id" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">انتخاب ژانر</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name_fa ?: $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-jalali-date-input name="release_date" label="تاریخ انتشار (شمسی)" />
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">فایل‌های صوتی</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">فایل کیفیت بالا (320kbps) <span class="text-rose-500">*</span></label>
                <input type="file" name="file_320" required accept=".mp3,.mp4,.ogg,.flac,.wav,.m4a"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                <p class="text-xs text-surface-400 mt-1">MP3، FLAC، WAV — حداکثر ۱۰۰ مگابایت</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">فایل کیفیت پایین (128kbps) — اختیاری</label>
                <input type="file" name="file_128" accept=".mp3,.mp4,.ogg,.flac,.wav,.m4a"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-surface-100 file:text-surface-700 hover:file:bg-surface-200 dark:file:bg-surface-700 dark:file:text-surface-300">
                <p class="text-xs text-surface-400 mt-1">اگر نداشتید همان فایل ۳۲۰ برای هر دو استفاده می‌شود</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر کاور (اختیاری)</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-surface-100 file:text-surface-700 hover:file:bg-surface-200 dark:file:bg-surface-700 dark:file:text-surface-300">
                <p class="text-xs text-surface-400 mt-1">اگر خالی بماند از کاور آلبوم استفاده می‌شود</p>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5" x-data="{ forSale: false }">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">قیمت‌گذاری</h2>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_for_sale" id="is_for_sale" value="1" x-model="forSale" @change="forSale = $event.target.checked"
                       class="w-4 h-4 rounded accent-primary-500">
                <label for="is_for_sale" class="text-sm font-medium text-surface-700 dark:text-surface-300 cursor-pointer">این آهنگ قابل فروش است</label>
            </div>

            <div x-show="forSale" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت (تومان)</label>
                    <input type="number" name="price" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت با تخفیف (تومان)</label>
                    <input type="number" name="discount_price" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ثانیه‌های پیش‌نمایش</label>
                    <input type="number" name="preview_seconds" value="30" min="0" max="300"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_explicit" value="1" class="w-4 h-4 rounded accent-primary-500">
                    <span class="text-sm text-surface-700 dark:text-surface-300">محتوای بزرگسال (Explicit)</span>
                </label>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">متن آهنگ (اختیاری)</h2>
            <textarea name="lyrics" rows="8" placeholder="متن آهنگ را اینجا بنویسید..."
                      class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-y"></textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-3">آپلود آهنگ</button>
            <a href="{{ route('artist.tracks') }}" wire:navigate class="btn-ghost px-6 py-3">انصراف</a>
        </div>
    </form>
</div>
</x-layouts.app>

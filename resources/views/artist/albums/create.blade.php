<x-layouts.app title="ایجاد آلبوم جدید">
<div class="p-4 lg:p-8 max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('artist.albums') }}" wire:navigate class="text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">ایجاد آلبوم جدید</h1>
    </div>

    @if($errors->any())
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.albums.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">اطلاعات آلبوم</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">عنوان آلبوم <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">نوع <span class="text-rose-500">*</span></label>
                    <select name="type" required class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="album" @selected(old('type','album')==='album')>آلبوم</option>
                        <option value="single" @selected(old('type')==='single')>سینگل</option>
                        <option value="ep" @selected(old('type')==='ep')>EP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ژانر</label>
                    <select name="genre_id" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">انتخاب ژانر</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" @selected(old('genre_id') == $genre->id)>{{ $genre->name_fa ?: $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-jalali-date-input name="release_date" label="تاریخ انتشار (شمسی)" />

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توضیحات</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-y">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر کاور</label>
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">وضعیت</label>
                <select name="status" required class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="draft" @selected(old('status','draft')==='draft')>پیش‌نویس</option>
                    <option value="published" @selected(old('status')==='published')>منتشرشده</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_explicit" id="al_explicit" value="1" {{ old('is_explicit') ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                <label for="al_explicit" class="text-sm text-surface-700 dark:text-surface-300 cursor-pointer">محتوای بزرگسال (Explicit)</label>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5" x-data="{ forSale: {{ old('is_for_sale') ? 'true' : 'false' }} }">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">قیمت‌گذاری آلبوم</h2>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_for_sale" id="al_for_sale" value="1" x-model="forSale" {{ old('is_for_sale') ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                <label for="al_for_sale" class="text-sm font-medium text-surface-700 dark:text-surface-300 cursor-pointer">این آلبوم قابل فروش است</label>
            </div>

            <div x-show="forSale" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت (تومان)</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت با تخفیف</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ثانیه‌های پیش‌نمایش</label>
                    <input type="number" name="preview_seconds" value="{{ old('preview_seconds', 30) }}" min="0" max="300"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-3">ایجاد آلبوم</button>
            <a href="{{ route('artist.albums') }}" wire:navigate class="btn-ghost px-6 py-3">انصراف</a>
        </div>
    </form>
</div>
</x-layouts.app>

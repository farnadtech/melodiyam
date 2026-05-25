<x-layouts.app title="ساخت پلی‌لیست">
    <div class="p-4 lg:p-8 max-w-2xl mx-auto">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white mb-6">ساخت پلی‌لیست جدید</h1>

        <form method="POST" action="{{ route('playlist.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="glass-card rounded-2xl p-6 space-y-5">
                {{-- Cover Image --}}
                <div x-data="{ preview: null }" class="flex flex-col items-center gap-4">
                    <div class="w-36 h-36 rounded-2xl overflow-hidden bg-surface-200 dark:bg-surface-700 flex items-center justify-center relative group cursor-pointer"
                        @click="$refs.coverInput.click()">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center">
                                <svg class="w-10 h-10 text-surface-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-surface-400">کاور</p>
                            </div>
                        </template>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                    </div>
                    <input type="file" name="cover_image" accept="image/*" class="hidden" x-ref="coverInput"
                        @change="preview = URL.createObjectURL($event.target.files[0])">
                    <p class="text-xs text-surface-400">برای تغییر تصویر کلیک کنید</p>
                    @error('cover_image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">عنوان پلی‌لیست *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-surface-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">توضیحات</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-surface-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description') }}</textarea>
                </div>

                {{-- Visibility --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">دسترسی</label>
                    <div class="flex gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="visibility" value="public" {{ old('visibility', 'public') === 'public' ? 'checked' : '' }} class="accent-primary-500">
                            <span class="text-sm text-surface-700 dark:text-surface-300">عمومی — همه می‌توانند ببینند</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="visibility" value="private" {{ old('visibility') === 'private' ? 'checked' : '' }} class="accent-primary-500">
                            <span class="text-sm text-surface-700 dark:text-surface-300">خصوصی — فقط من</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1 py-3">ساخت پلی‌لیست</button>
                <a href="{{ url('/playlists') }}" wire:navigate class="btn-ghost flex-1 py-3 text-center">انصراف</a>
            </div>
        </form>
    </div>
</x-layouts.app>

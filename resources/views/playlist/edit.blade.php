<x-layouts.app :title="'ویرایش: '.$playlist->title">
    <div class="p-4 lg:p-8 max-w-2xl mx-auto">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white mb-6">ویرایش پلی‌لیست</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('playlist.update', $playlist) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('POST')

            <div class="glass-card rounded-2xl p-6 space-y-5">
                {{-- Cover Image --}}
                <div x-data="{ preview: '{{ $playlist->cover_image ? asset('storage/'.$playlist->cover_image) : '' }}' }" class="flex flex-col items-center gap-4">
                    <div class="w-36 h-36 rounded-2xl overflow-hidden bg-surface-200 dark:bg-surface-700 flex items-center justify-center relative group cursor-pointer"
                        @click="$refs.coverInput.click()">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center">
                                <svg class="w-10 h-10 text-surface-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </template>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                    </div>
                    <input type="file" name="cover_image" accept="image/*" class="hidden" x-ref="coverInput"
                        @change="preview = URL.createObjectURL($event.target.files[0])">
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">عنوان پلی‌لیست *</label>
                    <input type="text" name="title" value="{{ old('title', $playlist->title) }}" required
                        class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-surface-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">توضیحات</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-surface-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $playlist->description) }}</textarea>
                </div>

                {{-- Visibility --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">دسترسی</label>
                    <div class="flex gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="visibility" value="public" {{ old('visibility', $playlist->visibility) === 'public' ? 'checked' : '' }} class="accent-primary-500">
                            <span class="text-sm text-surface-700 dark:text-surface-300">عمومی</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="visibility" value="private" {{ old('visibility', $playlist->visibility) === 'private' ? 'checked' : '' }} class="accent-primary-500">
                            <span class="text-sm text-surface-700 dark:text-surface-300">خصوصی</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1 py-3">ذخیره تغییرات</button>
                <a href="{{ route('playlist.show', $playlist) }}" wire:navigate class="btn-ghost flex-1 py-3 text-center">انصراف</a>
            </div>
        </form>

        {{-- Delete --}}
        <div class="mt-8 glass-card rounded-2xl p-6 border border-red-200 dark:border-red-900/50">
            <h3 class="font-bold text-red-600 dark:text-red-400 mb-2">حذف پلی‌لیست</h3>
            <p class="text-sm text-surface-500 mb-4">این عملیات قابل بازگشت نیست.</p>
            <form method="POST" action="{{ route('playlist.destroy', $playlist) }}"
                x-data x-on:submit.prevent="if(confirm('آیا مطمئن هستید؟')) $el.submit()">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
                    حذف پلی‌لیست
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>

<x-layouts.app title="تنظیمات هنرمند">
<div class="p-4 lg:p-8 max-w-4xl mx-auto">

    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">تنظیمات پروفایل هنرمند</h1>
        <p class="text-sm text-surface-500 mt-1">اطلاعات هنری و تصویر پروفایل خود را مدیریت کنید</p>
    </div>

    @if(session('success'))
    <div class="rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 text-sm mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ imageUrl: '{{ $artist->getAvatarUrl() }}' }">
        @csrf
        @method('PUT')

        <!-- Profile Image -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-semibold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                تصویر هنرمند
            </h2>
            
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="relative group">
                    <img :src="imageUrl" 
                         class="w-40 h-40 rounded-full object-cover border-4 border-surface-200 dark:border-surface-700 shadow-xl">
                    <label for="cover_image" class="absolute inset-0 flex items-center justify-center bg-black/40 text-white opacity-0 group-hover:opacity-100 rounded-full cursor-pointer transition-opacity">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812-1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden" 
                           @change="const file = $el.files[0]; if(file) imageUrl = URL.createObjectURL(file)">
                </div>
                <div class="text-center sm:text-right space-y-2">
                    <p class="text-sm font-medium text-surface-900 dark:text-white">تصویر پروفایل هنری</p>
                    <p class="text-xs text-surface-500 leading-relaxed">
                        این تصویر در صفحه عمومی شما، لیست هنرمندان و کنار آهنگ‌هایتان نمایش داده می‌شود.<br>
                        فرمت‌های مجاز: JPG, PNG, WEBP (حداکثر ۵ مگابایت)
                    </p>
                    <button type="button" onclick="document.getElementById('cover_image').click()" class="text-sm text-primary-500 font-semibold hover:underline">
                        تغییر تصویر
                    </button>
                </div>
            </div>
        </div>

        <!-- Artistic Info -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-semibold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                اطلاعات هنری
            </h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">نام نمایشی هنرمند</label>
                    <input type="text" name="display_name" value="{{ old('display_name', $artist->display_name) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">بیوگرافی</label>
                    <textarea name="bio" rows="4" maxlength="1000"
                              class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">{{ old('bio', $artist->bio) }}</textarea>
                    <p class="text-xs text-surface-500 mt-1.5">درباره سبک موسیقی و فعالیت‌های هنری خود بنویسید (حداکثر ۱۰۰۰ کاراکتر).</p>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-semibold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                شبکه‌های اجتماعی و وب‌سایت
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">وب‌سایت</label>
                    <input type="url" name="website" value="{{ old('website', $artist->website) }}" placeholder="https://..."
                           class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">اینستاگرام</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $artist->instagram) }}" placeholder="Username"
                           class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-left" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تلگرام</label>
                    <input type="text" name="telegram" value="{{ old('telegram', $artist->telegram) }}" placeholder="Channel/ID"
                           class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-left" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توییتر (X)</label>
                    <input type="text" name="twitter" value="{{ old('twitter', $artist->twitter) }}" placeholder="Username"
                           class="w-full px-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-left" dir="ltr">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('artist.dashboard') }}" wire:navigate class="px-6 py-2.5 text-sm font-medium text-surface-600 dark:text-surface-400 hover:text-surface-900 dark:hover:text-white transition-colors">
                انصراف
            </a>
            <button type="submit" 
                    class="px-8 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/25">
                ذخیره تنظیمات هنرمند
            </button>
        </div>
    </form>

</div>
</x-layouts.app>

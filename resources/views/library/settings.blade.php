<x-layouts.app title="تنظیمات">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">تنظیمات</h1>

        <div class="glass-card rounded-2xl divide-y divide-surface-200 dark:divide-surface-700">
            <div class="p-5 flex items-center justify-between">
                <div>
                    <p class="font-medium text-surface-900 dark:text-white">حالت تاریک</p>
                    <p class="text-sm text-surface-500">تغییر تم ظاهر برنامه</p>
                </div>
                <button x-data @click="$store.theme.toggle()" class="relative w-12 h-6 rounded-full transition-colors" :class="$store.theme.dark ? 'bg-primary-500' : 'bg-surface-300'">
                    <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform" :class="$store.theme.dark ? 'translate-x-0.5' : 'translate-x-6'"></span>
                </button>
            </div>
            <div class="p-5 flex items-center justify-between" x-data="{ 
                quality: localStorage.getItem('playback_quality') || 'auto',
                setQuality(val) {
                    this.quality = val;
                    localStorage.setItem('playback_quality', val);
                    // Dispatch event for player if needed
                    window.dispatchEvent(new CustomEvent('quality-changed', { detail: val }));
                }
            }">
                <div>
                    <p class="font-medium text-surface-900 dark:text-white">کیفیت پخش</p>
                    <p class="text-sm text-surface-500">تنظیم کیفیت استریم</p>
                </div>
                <select 
                    class="input-field w-40 text-sm" 
                    x-model="quality" 
                    @change="setQuality($event.target.value)"
                >
                    <option value="auto">خودکار</option>
                    <option value="high">بالا (320kbps)</option>
                    <option value="medium">متوسط (128kbps)</option>
                </select>
            </div>
            <div class="p-5 flex items-center justify-between">
                <div>
                    <p class="font-medium text-surface-900 dark:text-white">اعلان‌ها</p>
                    <p class="text-sm text-surface-500">دریافت اعلان‌های جدید</p>
                </div>
                <button class="relative w-12 h-6 rounded-full bg-primary-500 transition-colors">
                    <span class="absolute top-0.5 right-0.5 w-5 h-5 bg-white rounded-full shadow"></span>
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>

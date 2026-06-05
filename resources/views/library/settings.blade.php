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
                isPremium: {{ auth()->check() && auth()->user()->isPremium() ? 'true' : 'false' }},
                setQuality(val) {
                    if (val === 'high' && !this.isPremium) {
                        window.dispatchEvent(new CustomEvent('premium-quality'));
                        this.quality = localStorage.getItem('playback_quality') || 'auto';
                        return;
                    }
                    this.quality = val;
                    localStorage.setItem('playback_quality', val);
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
                    <option value="high" :disabled="!isPremium">بالا (320kbps) 🔒</option>
                    <option value="medium">متوسط (128kbps)</option>
                </select>
            </div>

            {{-- Premium Required Modal --}}
            <div x-data="{ showPremiumModal: false }" x-show="showPremiumModal" x-cloak
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4"
                 @premium-quality.window="showPremiumModal = true"
                 x-transition>
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showPremiumModal = false"></div>
                <div class="relative bg-white dark:bg-surface-900 rounded-3xl shadow-2xl border border-surface-200 dark:border-surface-700 p-8 max-w-sm w-full text-center">
                    <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 dark:text-white mb-2">نیاز به اشتراک پریمیوم</h3>
                    <p class="text-sm text-surface-500 mb-6">برای پخش با کیفیت بالا (320kbps) نیاز به اشتراک پریمیوم دارید.</p>
                    <div class="flex gap-3">
                        <button @click="showPremiumModal = false" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border border-surface-300 dark:border-surface-600 text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">انصراف</button>
                        <a href="{{ url('/premium') }}" wire:navigate class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium btn-primary block text-center">خرید پریمیوم</a>
                    </div>
                </div>
            </div>
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

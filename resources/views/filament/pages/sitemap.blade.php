<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white mb-4">وضعیت نقشه سایت</h2>
            
            <div class="flex items-center gap-4 p-4 bg-primary-50 dark:bg-primary-950/20 border border-primary-200 dark:border-primary-800 rounded-lg">
                <div class="p-2 bg-primary-100 dark:bg-primary-900 rounded-full">
                    <x-heroicon-o-globe-alt class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-950 dark:text-white">لینک نقشه سایت (Sitemap URL)</p>
                    <a href="{{ url('sitemap.xml') }}" target="_blank" class="text-xs font-mono text-primary-600 dark:text-primary-400 hover:underline">
                        {{ url('sitemap.xml') }}
                    </a>
                </div>
                <x-filament::button wire:click="generateSitemap" icon="heroicon-m-arrow-path">
                    تولید مجدد نقشه سایت
                </x-filament::button>
            </div>

            <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                <p>💡 <strong>راهنما:</strong> این فایل هر ۲۴ ساعت به صورت خودکار به‌روزرسانی می‌شود. شما می‌توانید این لینک را در کنسول جستجوی گوگل (Google Search Console) ثبت کنید تا تمام صفحات سایت شما به سرعت شناسایی و ایندکس شوند.</p>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white mb-4">تنظیمات سئو (SEO)</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                برای تنظیم متاتگ‌های عمومی، عنوان سایت و کلمات کلیدی، لطفاً به بخش 
                <a href="{{ \App\Filament\Pages\Settings::getUrl() }}" class="text-primary-600 dark:text-primary-400 underline">تنظیمات عمومی ← زبانه سئو</a> 
                مراجعه کنید.
            </p>
        </div>
    </div>
</x-filament-panels::page>

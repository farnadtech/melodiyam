<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                وضعیت نقشه سایت
            </x-slot>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900/30 rounded-lg text-primary-600 dark:text-primary-400">
                        <x-heroicon-o-globe-alt class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">لینک نقشه سایت (Sitemap URL)</p>
                        <a href="{{ url('sitemap.xml') }}" target="_blank" class="text-xs font-mono text-primary-600 dark:text-primary-400 hover:underline">
                            {{ url('sitemap.xml') }}
                        </a>
                    </div>
                </div>
                
                <x-filament::button 
                    wire:click="generateSitemap" 
                    icon="heroicon-m-arrow-path"
                    wire:loading.attr="disabled"
                    wire:target="generateSitemap"
                >
                    <span wire:loading.remove wire:target="generateSitemap">تولید مجدد نقشه سایت</span>
                    <span wire:loading wire:target="generateSitemap">در حال تولید...</span>
                </x-filament::button>
            </div>

            <div class="mt-4 flex items-start gap-3 text-sm text-gray-500 dark:text-gray-400">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500 shrink-0" />
                <p>این فایل هر ۲۴ ساعت به صورت خودکار به‌روزرسانی می‌شود. شما می‌توانید این لینک را در کنسول جستجوی گوگل (Google Search Console) ثبت کنید.</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                تنظیمات سئو (SEO)
            </x-slot>
            
            <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                <p>برای تنظیم متاتگ‌های عمومی، عنوان سایت و کلمات کلیدی، به بخش تنظیمات مراجعه کنید:</p>
                <x-filament::link href="{{ \App\Filament\Pages\Settings::getUrl() }}" icon="heroicon-m-cog-6-tooth">
                    تنظیمات عمومی ← زبانه سئو
                </x-filament::link>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

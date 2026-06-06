<x-filament-panels::page>
    <style>
        .custom-flex-align {
            display: flex !important;
            align-items: center !important;
            gap: 1rem !important;
        }
        .custom-icon-wrapper {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
        }
        .custom-content-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.5rem !important;
        }
        .custom-button-spacing {
            margin-right: 2rem !important;
        }
        .custom-section-spacing {
            margin-top: 1.5rem !important;
        }
        .custom-card-spacing {
            gap: 2.5rem !important;
        }
    </style>

    <div class="space-y-8">
        <x-filament::section>
            <x-slot name="heading">
                وضعیت نقشه سایت
            </x-slot>

            <div class="p-6 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <!-- Icon و لینک در یک خط -->
                <div class="custom-flex-align mb-4">
                    <div class="custom-icon-wrapper p-3 bg-primary-100 dark:bg-primary-900/30 rounded-lg text-primary-600 dark:text-primary-400">
                        <x-filament::icon icon="heroicon-o-globe-alt" class="w-6 h-6" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">لینک نقشه سایت (Sitemap URL)</p>
                    </div>
                </div>
                
                <!-- URL و دکمه در یک خط -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 pr-12">
                    <a href="{{ url('sitemap.xml') }}" target="_blank" class="text-xs font-mono text-primary-600 dark:text-primary-400 hover:underline break-all">
                        {{ url('sitemap.xml') }}
                    </a>
                    <x-filament::button 
                        wire:click="generateSitemap" 
                        icon="heroicon-m-arrow-path"
                        wire:loading.attr="disabled"
                        wire:target="generateSitemap"
                        size="sm"
                    >
                        <span wire:loading.remove wire:target="generateSitemap">تولید مجدد نقشه سایت</span>
                        <span wire:loading wire:target="generateSitemap">در حال تولید...</span>
                    </x-filament::button>
                </div>
            </div>

            <!-- Info Box با ایکون -->
            <div class="custom-flex-align custom-section-spacing text-sm text-gray-500 dark:text-gray-400">
                <div class="custom-icon-wrapper">
                    <x-filament::icon
                        icon="heroicon-o-information-circle"
                        class="w-6 h-6 text-blue-500"
                    />
                </div>
                <p>این فایل هر ۲۴ ساعت به صورت خودکار به‌روزرسانی می‌شود. شما می‌توانید این لینک را در کنسول جستجوی گوگل (Google Search Console) ثبت کنید.</p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                تنظیمات سئو (SEO)
            </x-slot>
            
            <div class="custom-content-wrapper">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    برای تنظیم متاتگ‌های عمومی، عنوان سایت و کلمات کلیدی، به بخش تنظیمات مراجعه کنید:
                </p>
                <div class="custom-button-spacing">
                    <x-filament::link href="{{ \App\Filament\Pages\Settings::getUrl() }}" icon="heroicon-m-cog-6-tooth">
                        تنظیمات عمومی ← زبانه سئو
                    </x-filament::link>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

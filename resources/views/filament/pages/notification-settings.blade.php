<x-filament-panels::page>
    <div class="space-y-6">
        {{-- اطلاعات تماس ادمین (نمایش وضعیت) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-filament::section>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-success-50 text-success-600 dark:bg-success-400/10 dark:text-success-400">
                        <x-filament::icon
                            icon="heroicon-m-check-circle"
                            class="h-6 w-6"
                        />
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">شماره موبایل مدیر:</p>
                        <p class="text-sm font-bold text-gray-950 dark:text-white">{{ $this->data['admin_mobile'] ?: 'تنظیم نشده' }}</p>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-success-50 text-success-600 dark:bg-success-400/10 dark:text-success-400">
                        <x-filament::icon
                            icon="heroicon-m-check-circle"
                            class="h-6 w-6"
                        />
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">ایمیل مدیر:</p>
                        <p class="text-sm font-bold text-gray-950 dark:text-white">{{ $this->data['admin_email'] ?: 'تنظیم نشده' }}</p>
                    </div>
                </div>
            </x-filament::section>
        </div>

        <form wire:submit.prevent="save">
            {{ $this->form }}

            <div class="mt-6 flex justify-end">
                <x-filament::button type="submit" size="lg">
                    ذخیره تنظیمات
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>

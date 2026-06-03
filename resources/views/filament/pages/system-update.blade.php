<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- ستون سمت راست: وضعیت فعلی و عملیات -->
            <div class="lg:col-span-1 space-y-6">
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-cpu-chip" class="w-5 h-5 text-primary-500" />
                            <span>وضعیت سیستم</span>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/10">
                            <span class="text-sm text-gray-500 dark:text-gray-400">نسخه فعلی:</span>
                            <x-filament::badge color="gray" size="lg" class="font-mono">{{ $currentVersion }}</x-filament::badge>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/10">
                            <span class="text-sm text-gray-500 dark:text-gray-400">آخرین نسخه:</span>
                            <x-filament::badge color="info" size="lg" class="font-mono">{{ $serverVersion ?: '---' }}</x-filament::badge>
                        </div>

                        @if($hasUpdate)
                            <div class="p-4 bg-primary-50 dark:bg-primary-500/10 rounded-xl border border-primary-200 dark:border-primary-500/20 relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-16 h-16 bg-primary-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                                
                                <div class="relative z-10">
                                    <div class="flex items-center gap-2 text-primary-700 dark:text-primary-400 font-bold mb-2">
                                        <x-filament::icon icon="heroicon-o-sparkles" class="w-5 h-5 animate-pulse" />
                                        <span>نسخه جدید موجود است</span>
                                    </div>
                                    <p class="text-xs text-primary-600 dark:text-primary-300/80 leading-relaxed mb-4">
                                        تغییرات جدیدی برای اسکریپت شما منتشر شده است. پیشنهاد می‌شود جهت امنیت و کارایی بهتر، سیستم را آپدیت کنید.
                                    </p>
                                    
                                    <x-filament::button 
                                        wire:click="runUpdate" 
                                        class="w-full shadow-lg shadow-primary-500/20"
                                        color="primary"
                                        icon="heroicon-o-arrow-up-circle"
                                        wire:loading.attr="disabled"
                                    >
                                        <span wire:loading.remove>شروع آپدیت خودکار</span>
                                        <span wire:loading>در حال پردازش...</span>
                                    </x-filament::button>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-green-50 dark:bg-green-500/10 rounded-xl border border-green-200 dark:border-green-500/20 flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center text-green-600 dark:text-green-400">
                                    <x-filament::icon icon="heroicon-o-check-badge" class="w-6 h-6" />
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-green-700 dark:text-green-400">سیستم به‌روز است</div>
                                    <div class="text-[10px] text-green-600/70 dark:text-green-400/60">شما از آخرین نسخه استفاده می‌کنید</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </x-filament::section>

                <div class="p-4 bg-amber-50 dark:bg-amber-500/10 rounded-xl border border-amber-200 dark:border-amber-500/20 flex gap-3 items-start">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-5 h-5 text-amber-600 mt-0.5" />
                    <div class="text-xs text-amber-800 dark:text-amber-400 leading-relaxed">
                        <strong class="block mb-1">نکته مهم:</strong>
                        قبل از هر آپدیت، سیستم به صورت خودکار از فایل‌ها و دیتابیس شما بکاپ تهیه می‌کند تا در صورت بروز مشکل، امکان بازگشت فراهم باشد.
                    </div>
                </div>
            </div>

            <!-- ستون سمت چپ: چنج‌لاگ -->
            <div class="lg:col-span-2">
                <x-filament::section class="h-full">
                    <x-slot name="heading">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-document-text" class="w-5 h-5 text-primary-500" />
                                <span>جزئیات تغییرات (Changelog)</span>
                            </div>
                            @if($serverVersion)
                                <x-filament::badge color="info" size="sm">نسخه {{ $serverVersion }}</x-filament::badge>
                            @endif
                        </div>
                    </x-slot>
                    
                    <div class="relative">
                        <div class="absolute right-4 top-0 bottom-0 w-px bg-gray-100 dark:bg-white/10"></div>
                        
                        <div class="space-y-6 pr-8">
                            @if($changelog)
                                <div class="relative">
                                    <div class="absolute -right-10 top-1 w-4 h-4 rounded-full bg-primary-500 border-4 border-white dark:border-gray-900 shadow-sm z-10"></div>
                                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-7">
                                        {!! nl2br(e($changelog)) !!}
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <x-filament::icon icon="heroicon-o-clock" class="w-12 h-12 text-gray-200 dark:text-white/10 mb-4" />
                                    <p class="text-gray-400 text-sm italic">در حال حاضر تاریخچه تغییراتی برای نمایش وجود ندارد.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-filament::section>
            </div>
        </div>

        <!-- مدیریت بکاپ‌ها (تمام عرض) -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-archive-box" class="w-5 h-5 text-primary-500" />
                    <span>مدیریت بکاپ‌ها و بازگردانی سریع</span>
                </div>
            </x-slot>
            
            <div class="overflow-x-auto -mx-6">
                <table class="w-full text-right divide-y divide-gray-200 dark:divide-white/5">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-white/2">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">شناسه بکاپ</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">زمان ایجاد</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($backups as $backup)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/1 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-filament::icon icon="heroicon-o-folder" class="w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-colors" />
                                        <span class="text-xs font-mono text-gray-600 dark:text-gray-300">{{ $backup['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $backup['date'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-left">
                                    <x-filament::button 
                                        wire:click="rollback('{{ $backup['name'] }}')" 
                                        color="warning" 
                                        size="xs"
                                        variant="outline"
                                        icon="heroicon-o-arrow-path"
                                        wire:confirm="آیا از بازگردانی این نسخه مطمئن هستید؟ تمام تغییرات بعد از این تاریخ از بین خواهد رفت."
                                    >
                                        بازگردانی (Rollback)
                                    </x-filament::button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <x-filament::icon icon="heroicon-o-circle-stack" class="w-10 h-10 text-gray-200 dark:text-white/10 mb-3" />
                                        <span class="text-sm text-gray-400">هنوز هیچ بکاپی در سیستم ثبت نشده است.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

<x-layouts.app title="خانه">

    <div class="p-4 lg:p-8 space-y-10">

        @forelse($sections as $section)
            @include('home.widgets._dispatcher', ['section' => $section])
        @empty
            {{-- Fallback: no widgets configured yet --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-20 h-20 rounded-full bg-surface-100 dark:bg-surface-800 flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-2">صفحه اصلی هنوز تنظیم نشده</h2>
                <p class="text-surface-500 text-sm">از پنل ادمین → محتوا → صفحه اصلی، ویجت‌ها را اضافه کنید.</p>
            </div>
        @endforelse

    </div>

</x-layouts.app>

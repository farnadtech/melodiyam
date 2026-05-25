<x-layouts.app title="پروفایل">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                {{ mb_substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">{{ auth()->user()->name }}</h1>
                <p class="text-surface-500">{{ auth()->user()->phone }}</p>
                @if(auth()->user()->is_premium)
                <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-medium">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2z"/></svg>
                    پریمیوم
                </span>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

<x-layouts.app title="دانلودها">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">دانلودها</h1>
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <p class="text-surface-500 text-lg">دانلود آفلاین برای اعضای پریمیوم</p>
            @unless(auth()->user()->isPremium())
                <a href="{{ url('/premium') }}" wire:navigate class="btn-primary mt-4 inline-block">ارتقا به پریمیوم</a>
            @endunless
        </div>
    </div>
</x-layouts.app>

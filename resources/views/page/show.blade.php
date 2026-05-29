<x-layouts.app :title="$page->title">
    <div class="p-4 lg:p-12 max-w-4xl mx-auto">
        {{-- Header Section --}}
        <div class="relative mb-10 text-center">
            <div class="absolute inset-x-0 top-1/2 h-px bg-gradient-to-r from-transparent via-surface-200 dark:via-surface-800 to-transparent -z-10"></div>
            <span class="inline-block px-6 py-2 bg-white dark:bg-surface-900 text-2xl lg:text-4xl font-display font-black text-surface-900 dark:text-white relative">
                {{ $page->title }}
            </span>
        </div>

        {{-- Content Card --}}
        <div class="glass-card rounded-3xl overflow-hidden border border-surface-200 dark:border-surface-800 shadow-xl shadow-surface-500/5">
            <div class="p-6 lg:p-10">
                <div class="prose prose-lg dark:prose-invert max-w-none 
                    prose-headings:font-display prose-headings:font-bold prose-headings:text-primary-500
                    prose-p:text-surface-600 dark:prose-p:text-surface-400 prose-p:leading-loose
                    prose-a:text-primary-500 prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-2xl prose-img:shadow-lg
                    prose-strong:text-surface-900 dark:prose-strong:text-white
                    prose-blockquote:border-r-4 prose-blockquote:border-primary-500 prose-blockquote:bg-primary-500/5 prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:rounded-l-xl prose-blockquote:italic">
                    {!! $page->content !!}
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/30 border-t border-surface-100 dark:border-surface-800/50 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-surface-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>آخرین بروزرسانی: {{ \App\Helpers\Jalali::format($page->updated_at, 'Y/m/d') }}</span>
                </div>
                <div class="flex gap-3">
                    <button onclick="window.print()" class="p-2 rounded-full hover:bg-surface-200 dark:hover:bg-surface-700 text-surface-400 transition-colors" title="چاپ صفحه">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    </button>
                    <button onclick="navigator.clipboard.writeText(window.location.href)" class="p-2 rounded-full hover:bg-surface-200 dark:hover:bg-surface-700 text-surface-400 transition-colors" title="کپی لینک">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Back Button --}}
        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-surface-400 hover:text-primary-500 transition-colors group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                بازگشت به صفحه اصلی
            </a>
        </div>
    </div>
</x-layouts.app>

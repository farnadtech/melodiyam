<x-layouts.app :title="$page->title">
    <div class="p-4 lg:p-8 max-w-3xl mx-auto">
        <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white mb-6">{{ $page->title }}</h1>
        <div class="prose dark:prose-invert max-w-none leading-relaxed">{!! $page->content !!}</div>
    </div>
</x-layouts.app>

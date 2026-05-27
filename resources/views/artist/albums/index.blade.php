<x-layouts.app title="آلبوم‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آلبوم‌های من</h1>
            <a href="{{ route('artist.albums.create') }}" wire:navigate class="btn-primary text-sm">+ آلبوم جدید</a>
        </div>

        @if(session('success'))
        <div class="glass-card rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-sm text-emerald-700 dark:text-emerald-400">
            {{ session('success') }}
        </div>
        @endif

        @if($albums && $albums->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($albums as $album)
            <div class="glass-card rounded-2xl p-4 flex gap-4">
                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ $album->cover_image ? asset('storage/'.$album->cover_image) : asset('images/default-cover.png') }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-surface-900 dark:text-surface-100 truncate">{{ $album->title }}</p>
                    <p class="text-xs text-surface-400 mt-0.5">{{ $album->tracks_count }} آهنگ</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $album->status === 'published' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-surface-100 text-surface-500' }}">
                            {{ $album->status === 'published' ? 'منتشر' : 'پیش‌نویس' }}
                        </span>
                        @if($album->is_for_sale && $album->price)
                        <span class="text-xs text-primary-500 font-medium">{{ number_format($album->price) }} ت</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mt-3">
                        <a href="{{ route('artist.albums.edit', $album) }}" wire:navigate
                           class="text-xs px-3 py-1.5 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-600 dark:text-surface-300 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            ویرایش
                        </a>
                        <form method="POST" action="{{ route('artist.albums.destroy', $album) }}"
                              onsubmit="return confirm('آلبوم «{{ $album->title }}» حذف شود؟')" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-surface-100 dark:bg-surface-700 text-rose-500 hover:bg-rose-50 transition-colors">
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $albums->links() }}</div>
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303"/></svg>
            <p class="text-surface-500 mb-4">هنوز آلبومی ندارید</p>
            <a href="{{ route('artist.albums.create') }}" wire:navigate class="btn-primary">اولین آلبوم را بسازید</a>
        </div>
        @endif
    </div>
</x-layouts.app>

<x-layouts.app title="اعلان‌ها">
    <div class="p-4 lg:p-8 space-y-6 max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">اعلان‌ها</h1>
            @if($notifications->where('is_read', false)->count() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                        همه را خوانده‌شده کن
                    </button>
                </form>
            @endif
        </div>

        {{-- List --}}
        @if($notifications->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="text-surface-500 text-lg">هیچ اعلانی ندارید</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($notifications as $notification)
                    <div class="glass-card rounded-2xl p-4 flex items-start gap-4 {{ !$notification->is_read ? 'border-r-2 border-primary-500' : '' }}">
                        {{-- Icon --}}
                        <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center
                            {{ !$notification->is_read ? 'bg-primary-100 dark:bg-primary-900/50 text-primary-600 dark:text-primary-400' : 'bg-surface-100 dark:bg-surface-800 text-surface-400' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-surface-900 dark:text-white text-sm">
                                {{ $notification->title ?? ($notification->data['title'] ?? 'اعلان') }}
                            </p>
                            @php $notifBody = $notification->body ?? ($notification->data['message'] ?? ''); @endphp
                            @if(!empty($notifBody))
                                <p class="text-sm text-surface-500 mt-0.5">{{ $notifBody }}</p>
                            @endif
                            <p class="text-xs text-surface-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>

                        {{-- Unread dot + mark read --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if(!$notification->is_read)
                                <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-surface-400 hover:text-surface-600 dark:hover:text-surface-300">
                                        خواندم
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>

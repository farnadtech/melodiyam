<x-layouts.app :title="'خرید: ' . $item->title">
    <div class="min-h-[70vh] flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
            @endif
            @if(session('info'))
            <div class="mb-4 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm">
                {{ session('info') }}
            </div>
            @endif

            <div class="card p-6 space-y-6">

                {{-- Header --}}
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-500/10 border border-primary-500/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-surface-900 dark:text-white">تأیید خرید</h1>
                    <p class="text-sm text-surface-500 mt-1">جزئیات خرید را بررسی کنید</p>
                </div>

                {{-- Item Info --}}
                <div class="flex items-center gap-4 p-4 rounded-xl bg-surface-100 dark:bg-surface-800">
                    <img src="{{ $item->getCoverUrl() }}" alt="{{ $item->title }}"
                         class="w-16 h-16 rounded-xl object-cover flex-shrink-0 shadow-md">
                    <div class="min-w-0">
                        <p class="text-xs text-surface-400 mb-0.5">{{ $type === 'track' ? 'آهنگ' : 'آلبوم' }}</p>
                        <p class="font-semibold text-surface-900 dark:text-white truncate">{{ $item->title }}</p>
                        <p class="text-sm text-surface-500 truncate">{{ $item->artist?->display_name }}</p>
                    </div>
                </div>

                {{-- Price --}}
                <div class="flex items-center justify-between p-4 rounded-xl bg-surface-100 dark:bg-surface-800">
                    <span class="text-sm text-surface-500">قیمت</span>
                    <div class="flex items-center gap-2">
                        @if($item->discount_price)
                        <span class="text-sm text-surface-400 line-through">{{ number_format($item->price) }} ت</span>
                        <span class="text-xl font-bold text-primary-500">{{ number_format($item->discount_price) }} ت</span>
                        @else
                        <span class="text-xl font-bold text-primary-500">{{ number_format($item->price) }} ت</span>
                        @endif
                    </div>
                </div>

                {{-- Wallet Balance --}}
                <div class="flex items-center justify-between p-4 rounded-xl {{ $wallet->balance >= $finalPrice ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-red-500/10 border border-red-500/20' }}">
                    <span class="text-sm {{ $wallet->balance >= $finalPrice ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }}">موجودی کیف پول</span>
                    <span class="font-bold {{ $wallet->balance >= $finalPrice ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }}">
                        {{ number_format($wallet->balance) }} ت
                    </span>
                </div>

                @if($wallet->balance < $finalPrice)
                <div class="text-center text-sm text-surface-500">
                    موجودی کافی ندارید.
                    <a href="{{ route('wallet') }}" class="text-primary-500 hover:underline">شارژ کیف پول</a>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <a href="{{ url()->previous() }}" class="btn-secondary flex-1 justify-center">
                        انصراف
                    </a>
                    @if($wallet->balance >= $finalPrice)
                    <form action="{{ route('purchase.submit') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <button type="submit" class="btn-primary w-full justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            خرید کن
                        </button>
                    </form>
                    @else
                    <a href="{{ route('wallet') }}" class="btn-primary flex-1 justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        شارژ کیف پول
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>

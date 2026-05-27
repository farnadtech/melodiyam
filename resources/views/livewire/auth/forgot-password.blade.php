<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">فراموشی رمز عبور</h2>
    <p class="text-sm text-surface-500 text-center mb-6">ایمیل خود را وارد کنید تا لینک بازیابی ارسال شود</p>

    @if($sent)
    <div class="rounded-2xl px-5 py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm text-center space-y-2">
        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="font-medium">لینک بازیابی ارسال شد!</p>
        <p class="text-xs opacity-80">ایمیل خود را بررسی کنید و روی لینک کلیک کنید.</p>
    </div>
    @else
    <form wire:submit="send" class="space-y-5">
        <div>
            <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">آدرس ایمیل</label>
            <input
                wire:model="email"
                id="email"
                type="email"
                placeholder="example@email.com"
                class="input-field text-left ltr"
                dir="ltr"
                autofocus
            >
            @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="send">ارسال لینک بازیابی</span>
            <span wire:loading wire:target="send">
                <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </span>
        </button>
    </form>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">
            ← بازگشت به صفحه ورود
        </a>
    </div>
</div>

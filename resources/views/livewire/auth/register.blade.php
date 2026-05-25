<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">ثبت‌نام در ملودیام</h2>
    <p class="text-sm text-surface-500 text-center mb-8">حساب جدید بسازید و از موسیقی لذت ببرید</p>

    @if(!$codeSent)
        <form wire:submit="sendCode" class="space-y-5">
            <div>
                <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">نام</label>
                <input
                    wire:model="name"
                    id="name"
                    type="text"
                    placeholder="نام شما"
                    class="input-field"
                    autofocus
                >
                @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">شماره موبایل</label>
                <input
                    wire:model="phone"
                    id="phone"
                    type="tel"
                    placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                    class="input-field text-left ltr"
                    dir="ltr"
                >
                @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>ارسال کد تأیید</span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>
        </form>
    @else
        <form wire:submit="register" class="space-y-5">
            <div>
                <label for="code" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">کد تأیید</label>
                <p class="text-xs text-surface-500 mb-3">کد ۶ رقمی ارسال شده به {{ $phone }} را وارد کنید</p>
                <input
                    wire:model="code"
                    id="code"
                    type="text"
                    maxlength="6"
                    placeholder="______"
                    class="input-field text-center text-2xl tracking-[0.5em] ltr"
                    dir="ltr"
                    autofocus
                >
                @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>تأیید و ثبت‌نام</span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>

            <div class="text-center">
                <button type="button" wire:click="$set('codeSent', false)" class="text-sm text-primary-500 hover:text-primary-600">
                    تغییر اطلاعات
                </button>
            </div>
        </form>
    @endif

    <div class="mt-6 text-center">
        <p class="text-sm text-surface-500">
            قبلاً ثبت‌نام کردید؟
            <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-medium">ورود</a>
        </p>
    </div>
</div>

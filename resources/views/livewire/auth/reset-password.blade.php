<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">تغییر رمز عبور</h2>
    <p class="text-sm text-surface-500 text-center mb-6">رمز عبور جدید خود را وارد کنید</p>

    <form wire:submit="resetPassword" class="space-y-5">
        <div>
            <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">ایمیل</label>
            <input
                wire:model="email"
                id="email"
                type="email"
                class="input-field text-left ltr"
                dir="ltr"
                readonly
            >
            @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">رمز عبور جدید</label>
            <input
                wire:model="password"
                id="password"
                type="password"
                placeholder="حداقل ۸ کاراکتر"
                class="input-field"
            >
            @error('password') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">تکرار رمز عبور</label>
            <input
                wire:model="password_confirmation"
                id="password_confirmation"
                type="password"
                placeholder="تکرار رمز عبور"
                class="input-field"
            >
        </div>

        <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="reset">تغییر رمز عبور</span>
            <span wire:loading wire:target="reset">
                <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </span>
        </button>
    </form>
</div>

<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">ثبت‌نام در ملودیام</h2>
    <p class="text-sm text-surface-500 text-center mb-8">حساب جدید بسازید و از موسیقی لذت ببرید</p>

    {{-- Method Tabs - Only show when auth_type is not set to a specific method --}}
    @if($authType === 'password')
        {{-- Only show email tab for password mode --}}
        <div class="bg-primary-50 dark:bg-primary-950/30 border border-primary-200 dark:border-primary-800 rounded-xl p-4 mb-6 text-center">
            <p class="text-sm text-primary-700 dark:text-primary-400">ثبت‌نام با ایمیل و رمز عبور</p>
        </div>
    @elseif($authType === 'otp')
        {{-- No tabs for OTP mode - only phone method is available --}}
        <div class="bg-primary-50 dark:bg-primary-950/30 border border-primary-200 dark:border-primary-800 rounded-xl p-4 mb-6 text-center">
            <p class="text-sm text-primary-700 dark:text-primary-400">ثبت‌نام با شماره موبایل و کد OTP</p>
        </div>
    @else
        {{-- When auth_type is not set, show both tabs --}}
        <div class="flex rounded-xl bg-surface-100 dark:bg-surface-800 p-1 mb-6">
            <button
                wire:click="switchMethod('email')"
                class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all {{ $registerMethod === 'email' ? 'bg-white dark:bg-surface-700 text-surface-900 dark:text-white shadow-sm' : 'text-surface-500 hover:text-surface-700' }}"
            >
                ایمیل و رمز عبور
            </button>
            <button
                wire:click="switchMethod('phone')"
                class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all {{ $registerMethod === 'phone' ? 'bg-white dark:bg-surface-700 text-surface-900 dark:text-white shadow-sm' : 'text-surface-500 hover:text-surface-700' }}"
            >
                شماره موبایل
            </button>
        </div>
    @endif

    {{-- Email/Password Registration --}}
    @if($registerMethod === 'email')
        <form wire:submit="registerWithEmail" class="space-y-5">
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
                <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">ایمیل</label>
                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    placeholder="example@email.com"
                    class="input-field text-left ltr"
                    dir="ltr"
                >
                @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">رمز عبور</label>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    placeholder="رمز عبور"
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
                @error('password_confirmation') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>ثبت‌نام</span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>
        </form>

    {{-- Phone OTP Registration - Only show if auth_type allows it --}}
    @elseif($authType !== 'password' && !$codeSent)
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

    {{-- OTP Verify --}}
    @else
        <form wire:submit="registerWithPhone" class="space-y-5">
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

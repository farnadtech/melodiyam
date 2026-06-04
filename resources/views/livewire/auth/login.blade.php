<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">ورود به {{ config('app.name') }}</h2>
    <p class="text-sm text-surface-500 text-center mb-6">روش ورود خود را انتخاب کنید</p>

    {{-- Method Tabs - Only show when auth_type is 'both' --}}
    @if($authType === 'password')
        <div class="bg-primary-50 dark:bg-primary-950/30 border border-primary-200 dark:border-primary-800 rounded-xl p-4 mb-6 text-center">
            <p class="text-sm text-primary-700 dark:text-primary-400">ورود با ایمیل/شماره و رمز عبور</p>
        </div>
    @elseif($authType === 'otp')
        <div class="bg-primary-50 dark:bg-primary-950/30 border border-primary-200 dark:border-primary-800 rounded-xl p-4 mb-6 text-center">
            <p class="text-sm text-primary-700 dark:text-primary-400">ورود با شماره موبایل و کد OTP</p>
        </div>
    @elseif($authType === 'both')
        <div class="flex rounded-xl bg-surface-100 dark:bg-surface-800 p-1 mb-6">
            <button
                wire:click="switchMethod('password')"
                class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all {{ $loginMethod === 'password' ? 'bg-white dark:bg-surface-700 text-surface-900 dark:text-white shadow-sm' : 'text-surface-500 hover:text-surface-700' }}"
            >
                رمز عبور
            </button>
            <button
                wire:click="switchMethod('otp')"
                class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all {{ $loginMethod === 'otp' ? 'bg-white dark:bg-surface-700 text-surface-900 dark:text-white shadow-sm' : 'text-surface-500 hover:text-surface-700' }}"
            >
                کد تایید (OTP)
            </button>
        </div>
    @endif

    {{-- Password Login --}}
    @if($loginMethod === 'password')
        <form wire:submit="loginWithPassword" class="space-y-5">
            <div>
                <label for="identifier" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">ایمیل یا شماره موبایل</label>
                <input
                    wire:model="identifier"
                    id="identifier"
                    type="text"
                    placeholder="example@email.com یا 09123456789"
                    class="input-field text-left ltr"
                    dir="ltr"
                    autofocus
                >
                @error('identifier') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300">رمز عبور</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-primary-500 hover:text-primary-600">فراموشی رمز عبور؟</a>
                </div>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    placeholder="رمز عبور"
                    class="input-field"
                >
                @error('password') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="loginWithPassword">ورود</span>
                <span wire:loading wire:target="loginWithPassword">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>
        </form>

    {{-- Phone OTP Login --}}
    @elseif($loginMethod === 'otp' && !$codeSent)
        <form wire:submit="sendCode" class="space-y-5">
            <div>
                <label for="phone" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">شماره موبایل</label>
                <input
                    wire:model="phone"
                    id="phone"
                    type="tel"
                    placeholder="09123456789"
                    class="input-field text-left ltr"
                    dir="ltr"
                    autofocus
                >
                @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="sendCode">ارسال کد تأیید</span>
                <span wire:loading wire:target="sendCode">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>
        </form>

    {{-- OTP Verify --}}
    @else
        <form wire:submit="verify" class="space-y-5">
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
                <span wire:loading.remove wire:target="verify">تأیید و ورود</span>
                <span wire:loading wire:target="verify">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </span>
            </button>

            <div class="text-center">
                <button type="button" wire:click="$set('codeSent', false)" class="text-sm text-primary-500 hover:text-primary-600">
                    تغییر شماره
                </button>
            </div>
        </form>
    @endif

    <div class="mt-6 text-center">
        <p class="text-sm text-surface-500">
            حساب ندارید؟
            <a href="{{ route('register') }}" class="text-primary-500 hover:text-primary-600 font-medium">ثبت‌نام</a>
        </p>
    </div>
</div>

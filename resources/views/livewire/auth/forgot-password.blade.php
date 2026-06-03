<div>
    <h2 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center mb-2">فراموشی رمز عبور</h2>
    
    @if($method === 'email')
        <p class="text-sm text-surface-500 text-center mb-6">ایمیل خود را وارد کنید تا لینک بازیابی ارسال شود</p>
    @elseif(!$codeSent)
        <p class="text-sm text-surface-500 text-center mb-6">شماره موبایل خود را وارد کنید تا کد بازیابی ارسال شود</p>
    @elseif(!$codeVerified)
        <p class="text-sm text-surface-500 text-center mb-6">کد ۶ رقمی ارسال شده به شماره {{ $phone }} را وارد کنید</p>
    @else
        <p class="text-sm text-surface-500 text-center mb-6">رمز عبور جدید خود را وارد کنید</p>
    @endif

    {{-- Email Sent Success --}}
    @if($sent)
        <div class="rounded-2xl px-5 py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm text-center space-y-2">
            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">لینک بازیابی ارسال شد!</p>
            <p class="text-xs opacity-80">ایمیل خود را بررسی کنید و روی لینک کلیک کنید.</p>
        </div>
    
    {{-- OTP Method: Step 3 (Reset Password) --}}
    @elseif($method === 'phone' && $codeVerified)
        <form wire:submit="resetPassword" class="space-y-5">
            <div>
                <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">رمز عبور جدید</label>
                <input wire:model="password" id="password" type="password" class="input-field" placeholder="••••••••">
                @error('password') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">تکرار رمز عبور جدید</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" class="input-field" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full">
                تغییر رمز عبور
            </button>
        </form>

    {{-- OTP Method: Step 2 (Verify Code) --}}
    @elseif($method === 'phone' && $codeSent)
        <form wire:submit="verifyOtp" class="space-y-5">
            <div>
                <label for="code" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">کد تأیید</label>
                <input wire:model="code" id="code" type="text" maxlength="6" class="input-field text-center tracking-widest font-bold" placeholder="------">
                @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full">
                تأیید و ادامه
            </button>

            <div class="text-center">
                <button type="button" wire:click="sendOtp" class="text-xs text-surface-500 hover:text-primary-500" @if($countdown > 0) disabled @endif>
                    @if($countdown > 0)
                        ارسال مجدد کد تا {{ $countdown }} ثانیه دیگر
                    @else
                        ارسال مجدد کد
                    @endif
                </button>
            </div>
        </form>

    {{-- Step 1: Initial Form (Email or Phone) --}}
    @else
        <form wire:submit="send" class="space-y-5">
            {{-- Method switcher: show for 'both' --}}
            @if($authType === 'both')
                <div class="flex p-1 bg-surface-100 dark:bg-surface-800 rounded-xl mb-4">
                    <button type="button" wire:click="$set('method', 'email')" class="flex-1 py-2 text-xs font-medium rounded-lg transition-all {{ $method === 'email' ? 'bg-white dark:bg-surface-700 shadow-sm text-primary-600' : 'text-surface-500' }}">
                        ایمیل
                    </button>
                    <button type="button" wire:click="$set('method', 'phone')" class="flex-1 py-2 text-xs font-medium rounded-lg transition-all {{ $method === 'phone' ? 'bg-white dark:bg-surface-700 shadow-sm text-primary-600' : 'text-surface-500' }}">
                        شماره موبایل
                    </button>
                </div>
            @endif

            @if($method === 'email')
                <div>
                    <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">آدرس ایمیل</label>
                    <input wire:model="email" id="email" type="email" placeholder="example@email.com" class="input-field text-left ltr" dir="ltr" autofocus>
                    @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            @else
                <div>
                    <label for="phone" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">شماره موبایل</label>
                    <input wire:model="phone" id="phone" type="tel" placeholder="09123456789" class="input-field text-left ltr" dir="ltr" autofocus>
                    @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="send">
                    {{ $method === 'email' ? 'ارسال لینک بازیابی' : 'ارسال کد تأیید' }}
                </span>
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

    @script
    <script>
        $wire.on('start-countdown', () => {
            let timer = setInterval(() => {
                if ($wire.countdown > 0) {
                    $wire.countdown--;
                } else {
                    clearInterval(timer);
                }
            }, 1000);
        });
    </script>
    @endscript
</div>

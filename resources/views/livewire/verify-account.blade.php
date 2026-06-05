<div>
    {{-- Success Banner --}}
    @if($phoneVerified && $emailVerified)
    <div class="text-center py-8">
        <div class="w-20 h-20 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-2">احراز هویت کامل شد!</h2>
        <p class="text-sm text-surface-500 mb-6">حساب شما با موفقیت تایید شد. در حال انتقال...</p>
    </div>
    <script>setTimeout(function(){ window.location.href = '/'; }, 1500);</script>
    @else
    <div class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-surface-900 dark:text-white">احراز هویت حساب</h2>
            <p class="text-sm text-surface-500 mt-1">برای استفاده از سایت، لطفاً هویت خود را تایید کنید.</p>
        </div>

        {{-- Phone Verification --}}
        @if($requirePhone)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-700 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl {{ $phoneVerified ? 'bg-emerald-500/20' : 'bg-primary-500/20' }} flex items-center justify-center flex-shrink-0">
                    @if($phoneVerified)
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-surface-900 dark:text-white text-sm">تایید شماره موبایل</h3>
                    <p class="text-xs text-surface-500">{{ $phoneVerified ? 'تایید شده ✅' : 'ارسال کد تایید به شماره شما' }}</p>
                </div>
            </div>

            @if(!$phoneVerified)
            <div class="space-y-3">
                <input type="text" wire:model="phone" placeholder="09120000000" class="input-field w-full text-sm" dir="ltr">
                @error('phone') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                @if(!$phoneCodeSent)
                <button wire:click="sendPhoneCode" wire:loading.attr="disabled" class="btn-primary w-full py-2.5 rounded-xl text-sm font-medium">
                    <span wire:loading.remove wire:target="sendPhoneCode">ارسال کد تایید</span>
                    <span wire:loading wire:target="sendPhoneCode">در حال ارسال...</span>
                </button>
                @else
                <div class="flex gap-2">
                    <input type="text" wire:model="phoneCode" placeholder="کد ۶ رقمی" class="input-field flex-1 text-center text-lg tracking-widest" maxlength="6" dir="ltr">
                    <button wire:click="verifyPhone" wire:loading.attr="disabled" class="btn-primary px-6 rounded-xl text-sm font-medium">
                        <span wire:loading.remove wire:target="verifyPhone">تایید</span>
                        <span wire:loading wire:target="verifyPhone">...</span>
                    </button>
                </div>
                @error('phoneCode') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                <div class="flex items-center justify-between text-xs">
                    <button wire:click="sendPhoneCode" class="text-primary-500 hover:underline disabled:opacity-50" {{ $phoneCountdown > 0 ? 'disabled' : '' }}>
                        ارسال مجدد {{ $phoneCountdown > 0 ? "({$phoneCountdown}ث)" : '' }}
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif

        {{-- Email Verification --}}
        @if($requireEmail)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-700 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl {{ $emailVerified ? 'bg-emerald-500/20' : 'bg-blue-500/20' }} flex items-center justify-center flex-shrink-0">
                    @if($emailVerified)
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div>
                    <h3 class="font-bold text-surface-900 dark:text-white text-sm">تایید ایمیل</h3>
                    <p class="text-xs text-surface-500">{{ $emailVerified ? 'تایید شده ✅' : 'ارسال کد تایید به ایمیل شما' }}</p>
                </div>
            </div>

            @if(!$emailVerified)
            <div class="space-y-3">
                <input type="email" wire:model="email" placeholder="email@example.com" class="input-field w-full text-sm" dir="ltr">
                @error('email') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                @if(!$emailCodeSent)
                <button wire:click="sendEmailCode" wire:loading.attr="disabled" class="btn-primary w-full py-2.5 rounded-xl text-sm font-medium">
                    <span wire:loading.remove wire:target="sendEmailCode">ارسال کد تایید</span>
                    <span wire:loading wire:target="sendEmailCode">در حال ارسال...</span>
                </button>
                @else
                <div class="flex gap-2">
                    <input type="text" wire:model="emailCode" placeholder="کد ۶ رقمی" class="input-field flex-1 text-center text-lg tracking-widest" maxlength="6" dir="ltr">
                    <button wire:click="verifyEmail" wire:loading.attr="disabled" class="btn-primary px-6 rounded-xl text-sm font-medium">
                        <span wire:loading.remove wire:target="verifyEmail">تایید</span>
                        <span wire:loading wire:target="verifyEmail">...</span>
                    </button>
                </div>
                @error('emailCode') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                <div class="flex items-center justify-between text-xs">
                    <button wire:click="sendEmailCode" class="text-primary-500 hover:underline disabled:opacity-50" {{ $emailCountdown > 0 ? 'disabled' : '' }}>
                        ارسال مجدد {{ $emailCountdown > 0 ? "({$emailCountdown}ث)" : '' }}
                    </button>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif

        {{-- Countdown Scripts --}}
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('start-phone-countdown', () => {
                    let t = setInterval(() => {
                        if (@this.phoneCountdown <= 0) { clearInterval(t); return; }
                        @this.phoneCountdown--;
                    }, 1000);
                });
                Livewire.on('start-email-countdown', () => {
                    let t = setInterval(() => {
                        if (@this.emailCountdown <= 0) { clearInterval(t); return; }
                        @this.emailCountdown--;
                    }, 1000);
                });
                Livewire.on('verification-complete', () => {
                    setTimeout(() => { window.location.href = '/'; }, 1500);
                });
            });
        </script>
    </div>
    @endif
</div>

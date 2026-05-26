<x-layouts.app title="کیف پول">
<div class="p-4 lg:p-8 space-y-6" x-data="{ tab: '{{ $card2cardEnabled ? 'deposit' : 'withdraw' }}' }">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">کیف پول</h1>
            <p class="text-sm text-surface-500 mt-0.5">مدیریت موجودی و تراکنش‌های مالی</p>
        </div>
    </div>

    @if(!$walletEnabled)
    <div class="rounded-2xl bg-surface-100 dark:bg-surface-800 p-8 text-center text-surface-500">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
        <p class="font-medium">کیف پول در حال حاضر غیرفعال است</p>
    </div>
    @else

    {{-- Balance Card --}}
    <div class="relative overflow-hidden rounded-3xl gradient-primary p-7 text-white">
        <div class="absolute -top-8 -left-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex items-start justify-between">
            <div>
                <p class="text-sm text-white/70 mb-1">موجودی فعلی</p>
                <p class="text-4xl font-bold font-display tracking-tight">
                    {{ number_format((int)$wallet->balance) }}
                    <span class="text-lg font-normal opacity-80">تومان</span>
                </p>
                <p class="text-sm text-white/60 mt-2">{{ auth()->user()->name }}</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18-3a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3m18-3V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6"/></svg>
            </div>
        </div>
        {{-- Quick stats --}}
        <div class="relative z-10 mt-6 grid grid-cols-3 gap-4 pt-5 border-t border-white/20">
            @php
                $totalDeposit   = $wallet->transactions()->where('type','deposit')->where('status','approved')->sum('amount');
                $totalWithdraw  = $wallet->transactions()->where('type','withdrawal')->where('status','approved')->sum('amount');
                $pendingCount   = $wallet->transactions()->where('status','pending')->count();
            @endphp
            <div class="text-center">
                <p class="text-lg font-bold">{{ number_format($totalDeposit) }}</p>
                <p class="text-xs text-white/60 mt-0.5">کل شارژ</p>
            </div>
            <div class="text-center border-x border-white/20">
                <p class="text-lg font-bold">{{ number_format($totalWithdraw) }}</p>
                <p class="text-xs text-white/60 mt-0.5">کل برداشت</p>
            </div>
            <div class="text-center">
                <p class="text-lg font-bold">{{ $pendingCount }}</p>
                <p class="text-xs text-white/60 mt-0.5">در انتظار</p>
            </div>
        </div>
    </div>

    {{-- Session Messages --}}
    @if(session('success'))
    <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-4 flex gap-3 items-start">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
        <p class="text-sm text-emerald-700 dark:text-emerald-300">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 p-4 flex gap-3 items-start">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd"/></svg>
        <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Tabs --}}
    <div class="flex gap-2 bg-surface-100 dark:bg-surface-800 rounded-2xl p-1.5">
        @if($card2cardEnabled || $gatewayEnabled)
        <button @click="tab='deposit'"
                :class="tab==='deposit' ? 'bg-white dark:bg-surface-700 shadow text-surface-900 dark:text-white' : 'text-surface-500'"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium transition-all">
            شارژ کیف پول
        </button>
        @endif
        <button @click="tab='withdraw'"
                :class="tab==='withdraw' ? 'bg-white dark:bg-surface-700 shadow text-surface-900 dark:text-white' : 'text-surface-500'"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium transition-all">
            برداشت وجه
        </button>
        <button @click="tab='history'"
                :class="tab==='history' ? 'bg-white dark:bg-surface-700 shadow text-surface-900 dark:text-white' : 'text-surface-500'"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium transition-all">
            تاریخچه
        </button>
    </div>

    {{-- Deposit Tab --}}
    @if($card2cardEnabled || $gatewayEnabled)
    <div x-show="tab==='deposit'" x-transition
         x-data="{ method: '{{ $card2cardEnabled && $gatewayEnabled ? 'card2card' : ($card2cardEnabled ? 'card2card' : 'gateway') }}' }">
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden">

            {{-- Method selector (only when both available) --}}
            @if($card2cardEnabled && $gatewayEnabled)
            <div class="flex gap-2 p-4 border-b border-surface-100 dark:border-surface-800">
                <button type="button" @click="method='card2card'"
                        :class="method==='card2card' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-600' : 'border-surface-200 dark:border-surface-700 text-surface-500'"
                        class="flex-1 flex items-center gap-2 justify-center p-3 rounded-xl border-2 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    کارت به کارت
                </button>
                <button type="button" @click="method='gateway'"
                        :class="method==='gateway' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 text-primary-600' : 'border-surface-200 dark:border-surface-700 text-surface-500'"
                        class="flex-1 flex items-center gap-2 justify-center p-3 rounded-xl border-2 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                    پرداخت آنلاین
                </button>
            </div>
            @endif

            {{-- Card2Card Form --}}
            @if($card2cardEnabled)
            <div x-show="method==='card2card'">
            {{-- Bank Card Info --}}
            @if($bankCardNumber)
            <div class="p-5 bg-gradient-to-l from-blue-600 to-indigo-700 text-white">
                <p class="text-xs text-white/70 mb-3">برای شارژ کیف پول به کارت زیر واریز کنید</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xl font-mono font-bold tracking-widest">{{ $bankCardNumber }}</p>
                        @if($bankCardOwner)<p class="text-sm text-white/80 mt-1">{{ $bankCardOwner }}</p>@endif
                    </div>
                    <svg class="w-10 h-10 text-white/30" fill="currentColor" viewBox="0 0 24 24"><path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                </div>
            </div>
            @endif

            <form action="{{ route('wallet.deposit') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                {{-- Amount presets --}}
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-3">مبلغ شارژ (تومان)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-3">
                        @foreach([50000, 100000, 200000, 500000] as $preset)
                        <button type="button"
                                onclick="document.getElementById('deposit_amount').value='{{ $preset }}'"
                                class="py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 text-sm font-medium text-surface-700 dark:text-surface-300 hover:border-primary-400 hover:text-primary-600 transition">
                            {{ number_format($preset) }}
                        </button>
                        @endforeach
                    </div>
                    <input type="number" id="deposit_amount" name="amount" placeholder="مبلغ دلخواه (حداقل {{ number_format($depositMin) }})" min="{{ $depositMin }}" max="{{ $depositMax }}"
                           class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                           value="{{ old('amount') }}">
                    @error('amount')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">۴ رقم آخر کارت پرداختی</label>
                        <input type="text" name="card_number" placeholder="مثلاً: 1234" maxlength="20"
                               class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition"
                               value="{{ old('card_number') }}">
                        @error('card_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره پیگیری تراکنش</label>
                        <input type="text" name="reference_number" placeholder="کد پیگیری بانک" maxlength="50"
                               class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition"
                               value="{{ old('reference_number') }}">
                        @error('reference_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر رسید پرداخت</label>
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-surface-300 dark:border-surface-600 rounded-xl cursor-pointer hover:border-primary-400 transition bg-surface-50 dark:bg-surface-800">
                        <svg class="w-8 h-8 text-surface-400 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        <span class="text-sm text-surface-500">تصویر رسید را آپلود کنید</span>
                        <input type="file" name="receipt_image" accept="image/*" class="hidden">
                    </label>
                    @error('receipt_image')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-semibold text-sm transition shadow-lg shadow-primary-500/30">
                    ثبت درخواست شارژ
                </button>
                <p class="text-xs text-surface-400 text-center">پس از بررسی توسط ادمین، موجودی شما افزایش می‌یابد</p>
            </form>
            </div>{{-- end card2card div --}}
            @endif

            {{-- Gateway Form --}}
            @if($gatewayEnabled)
            <div x-show="method==='gateway'" class="p-6 space-y-5">
                <div class="rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 p-4 text-sm text-blue-700 dark:text-blue-300">
                    پس از انتخاب مبلغ به درگاه پرداخت منتقل می‌شوید و موجودی بلافاصله شارژ می‌شود.
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-3">مبلغ شارژ (تومان)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-3">
                        @foreach([50000, 100000, 200000, 500000] as $preset)
                        <button type="button"
                                onclick="document.getElementById('gateway_amount').value='{{ $preset }}'"
                                class="py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 text-sm font-medium text-surface-700 dark:text-surface-300 hover:border-primary-400 hover:text-primary-600 transition">
                            {{ number_format($preset) }}
                        </button>
                        @endforeach
                    </div>
                    <input type="number" id="gateway_amount" placeholder="مبلغ دلخواه" min="10000"
                           class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition">
                </div>
                <button type="button" class="w-full py-3.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-semibold text-sm transition shadow-lg shadow-primary-500/30">
                    پرداخت آنلاین
                </button>
                <p class="text-xs text-surface-400 text-center">درگاه پرداخت آنلاین در حال آماده‌سازی است</p>
            </div>
            @endif

        </div>
    </div>
    @endif

    {{-- Withdraw Tab --}}
    <div x-show="tab==='withdraw'" x-transition>
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 space-y-5">
            <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400">موجودی فعلی: {{ number_format((int)$wallet->balance) }} تومان</p>
                    <p class="text-xs text-amber-600 dark:text-amber-500 mt-0.5">
                    حداقل برداشت: {{ number_format($withdrawMin) }} تومان
                    @if($withdrawFee > 0) | کارمزد برداشت: {{ number_format($withdrawFee) }} تومان @endif
                    @if($taxPercent > 0) | مالیات: {{ $taxPercent }}٪ @endif
                </p>
                </div>
            </div>

            <form action="{{ route('wallet.withdraw') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">مبلغ برداشت (تومان)</label>
                    <input type="number" name="amount" min="{{ $withdrawMin }}" max="{{ min($withdrawMax, (int)$wallet->balance) }}"
                           placeholder="مبلغ درخواستی"
                           class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition"
                           value="{{ old('amount') }}">
                    @error('amount')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">شماره کارت (۱۶ رقم)</label>
                        <input type="text" name="card_number" maxlength="16" placeholder="6037XXXXXXXXXXXX"
                               class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition"
                               value="{{ old('card_number') }}">
                        @error('card_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">نام صاحب کارت</label>
                        <input type="text" name="card_owner" placeholder="نام و نام خانوادگی"
                               class="w-full px-4 py-3 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 outline-none transition"
                               value="{{ old('card_owner') }}">
                        @error('card_owner')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="submit"
                        @if((int)$wallet->balance < 10000) disabled @endif
                        class="w-full py-3.5 rounded-xl bg-surface-900 dark:bg-white text-white dark:text-surface-900 font-semibold text-sm transition hover:opacity-90 disabled:opacity-40 disabled:cursor-not-allowed">
                    ثبت درخواست برداشت
                </button>
            </form>
        </div>
    </div>

    {{-- History Tab --}}
    <div x-show="tab==='history'" x-transition>
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden">
            @if($transactions->isEmpty())
            <div class="text-center py-16 text-surface-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                <p class="text-sm">تراکنشی وجود ندارد</p>
            </div>
            @else
            <div class="divide-y divide-surface-100 dark:divide-surface-800">
                @foreach($transactions as $tx)
                <div class="flex items-center gap-4 px-5 py-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                        @if($tx->type === 'deposit') bg-emerald-100 dark:bg-emerald-900/30
                        @elseif($tx->type === 'withdrawal') bg-red-100 dark:bg-red-900/30
                        @else bg-blue-100 dark:bg-blue-900/30 @endif">
                        @if($tx->type === 'deposit')
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        @elseif($tx->type === 'withdrawal')
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
                        @else
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $tx->description ?? 'تراکنش' }}</p>
                        <p class="text-xs text-surface-400 mt-0.5">{{ $tx->created_at->diffForHumans() }}</p>
                        @if($tx->status === 'rejected' && $tx->admin_note)
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                            دلیل رد: {{ $tx->admin_note }}
                        </p>
                        @endif
                        @if($tx->status === 'pending' && $tx->admin_note)
                        <p class="text-xs text-amber-500 mt-1">یادداشت: {{ $tx->admin_note }}</p>
                        @endif
                    </div>
                    <div class="text-left flex-shrink-0">
                        <p class="text-sm font-bold {{ $tx->type === 'deposit' || $tx->type === 'earning' ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $tx->type === 'deposit' || $tx->type === 'earning' ? '+' : '-' }}{{ number_format((int)$tx->amount) }}
                        </p>
                        <span class="inline-block text-xs px-2 py-0.5 rounded-full mt-1
                            @if($tx->status === 'approved') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                            @elseif($tx->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                            @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @endif">
                            {{ $tx->status === 'approved' ? 'تایید شده' : ($tx->status === 'pending' ? 'در انتظار' : 'رد شده') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4 border-t border-surface-100 dark:border-surface-800">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>

    @endif {{-- end walletEnabled --}}

</div>
</x-layouts.app>

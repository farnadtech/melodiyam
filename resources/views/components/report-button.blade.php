{{-- Report button + modal --}}
{{-- Usage: <x-report-button type="track" :id="$track->id" /> --}}
@props(['type', 'id'])

@php
    $uid = 'rep_' . $type . '_' . $id;
    $hasExisting = false;
    if (auth()->check()) {
        $modelClass = $type === 'track' ? \App\Models\Track::class : \App\Models\Album::class;
        $hasExisting = \App\Models\Report::where('user_id', auth()->id())
            ->where('reportable_type', $modelClass)
            ->where('reportable_id', $id)
            ->whereIn('status', ['pending', 'reviewed'])
            ->exists();
    }
@endphp

<div x-data="{ open: false, sending: false, done: {{ $hasExisting ? 'true' : 'false' }}, reason: '', description: '' }" class="relative">
    {{-- Trigger button --}}
    <button @click="open = true"
            class="p-3 rounded-full border transition-colors flex items-center gap-1.5 text-xs"
            :class="done
                ? 'border-rose-400 text-rose-400 bg-rose-50 dark:bg-rose-500/10 cursor-default'
                : 'border-surface-300 dark:border-surface-600 hover:border-rose-400 hover:text-rose-400'"
            :disabled="done"
            :title="done ? 'شکایت ثبت شده' : 'گزارش تخلف'"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
        </svg>
        <span x-show="done" class="text-[11px]">گزارش شده</span>
    </button>

    {{-- Modal backdrop --}}
    <div x-show="open && !done" x-cloak
         @click.self="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[200] flex items-center justify-center bg-black/50 p-4"
    >
        <div @click.stop
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white dark:bg-surface-900 rounded-2xl shadow-2xl w-full max-w-md p-6"
        >
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-surface-900 dark:text-white">گزارش تخلف</h3>
                <button @click="open = false" class="text-surface-400 hover:text-surface-600 dark:hover:text-surface-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form @submit.prevent="
                sending = true;
                fetch('{{ route('report.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ type: '{{ $type }}', id: {{ $id }}, reason: reason, description: description })
                })
                .then(r => r.json())
                .then(d => {
                    sending = false;
                    if (d.ok) { done = true; open = false; }
                    else if (d.error) { alert(d.error); }
                })
                .catch(() => { sending = false; });
            " class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">دلیل گزارش <span class="text-rose-500">*</span></label>
                    <div class="space-y-2">
                        @foreach(\App\Models\Report::$reasons as $key => $label)
                        <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-xl hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                            <input type="radio" name="reason_{{ $uid }}" value="{{ $key }}"
                                   x-model="reason"
                                   class="text-primary-500 focus:ring-primary-500 border-surface-300 dark:border-surface-600">
                            <span class="text-sm text-surface-700 dark:text-surface-200">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توضیحات <span class="text-rose-500">*</span></label>
                    <textarea x-model="description" rows="3" required
                              placeholder="لطفاً توضیح دهید چرا این محتوا را گزارش می‌کنید..."
                              class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100 resize-none"
                              :class="description.trim().length < 10 && description.length > 0 ? 'border-rose-400' : ''"></textarea>
                    <p x-show="description.length > 0 && description.trim().length < 10"
                       class="text-xs text-rose-500 mt-1">حداقل ۱۰ کاراکتر بنویسید</p>
                </div>

                <div class="flex gap-3 pt-1">
                    <button type="submit"
                            :disabled="!reason || description.trim().length < 10 || sending"
                            class="flex-1 btn-primary !py-2.5 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!sending">ثبت گزارش</span>
                        <span x-show="sending">در حال ارسال...</span>
                    </button>
                    <button type="button" @click="open = false"
                            class="px-5 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 text-sm text-surface-600 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                        انصراف
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

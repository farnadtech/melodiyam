<x-layouts.app title="درخواست هنرمند شدن">
    <div class="p-4 lg:p-8 space-y-6 max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-accent-500 flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">درخواست هنرمند شدن</h1>
                <p class="text-sm text-surface-500 dark:text-surface-400">اطلاعات خود را تکمیل کنید تا درخواست شما بررسی شود</p>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="rounded-2xl px-5 py-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="rounded-2xl px-5 py-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 text-sm">
            {{ session('error') }}
        </div>
        @endif

        {{-- وضعیت درخواست موجود --}}
        @if($application)
        @php
            $stColor = match($application->status) {
                'pending'   => 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400',
                'reviewing' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400',
                'approved'  => 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400',
                'rejected'  => 'bg-rose-50 dark:bg-rose-900/20 border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400',
                default     => 'bg-surface-100 dark:bg-surface-800',
            };
        @endphp
        <div class="glass-card rounded-2xl p-5 border {{ $stColor }}">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <div>
                    <p class="font-bold text-base">وضعیت درخواست: {{ \App\Models\ArtistApplication::$statuses[$application->status] }}</p>
                    <p class="text-xs mt-1 opacity-75">{{ \App\Helpers\Jalali::format($application->created_at, 'Y/m/d') }}</p>
                </div>
                @if($application->status === 'approved')
                <span class="text-2xl">🎉</span>
                @elseif($application->status === 'rejected')
                <span class="text-2xl">❌</span>
                @elseif($application->status === 'pending')
                <span class="text-2xl">⏳</span>
                @else
                <span class="text-2xl">🔍</span>
                @endif
            </div>
            @if($application->admin_note)
            <div class="mt-3 pt-3 border-t border-current/20">
                <p class="text-sm font-medium">یادداشت بررسی‌کننده:</p>
                <p class="text-sm mt-1 opacity-90">{{ $application->admin_note }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- فرم ارسال --}}
        @if(!$application || $application->status === 'rejected')
        @if($fields->isEmpty())
        <div class="glass-card rounded-2xl p-8 text-center text-surface-400">
            <p>فرم درخواست هنوز تنظیم نشده. لطفاً بعداً مراجعه کنید.</p>
        </div>
        @else
        <form action="{{ route('artist-application.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="glass-card rounded-2xl p-6 space-y-5">
                @foreach($fields as $field)
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                        {{ $field->label }}
                        @if($field->required)<span class="text-rose-500 ml-0.5">*</span>@endif
                    </label>

                    @if($field->type === 'text' || $field->type === 'url' || $field->type === 'number')
                    <input
                        type="{{ $field->type === 'url' ? 'url' : ($field->type === 'number' ? 'number' : 'text') }}"
                        name="field_{{ $field->key }}"
                        value="{{ old('field_' . $field->key, $application?->data[$field->key] ?? '') }}"
                        placeholder="{{ $field->placeholder }}"
                        class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100 @error('field_' . $field->key) border-rose-400 @enderror"
                        {{ $field->required ? 'required' : '' }}
                    >

                    @elseif($field->type === 'textarea')
                    <textarea
                        name="field_{{ $field->key }}"
                        rows="4"
                        placeholder="{{ $field->placeholder }}"
                        class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100 resize-none @error('field_' . $field->key) border-rose-400 @enderror"
                        {{ $field->required ? 'required' : '' }}
                    >{{ old('field_' . $field->key, $application?->data[$field->key] ?? '') }}</textarea>

                    @elseif($field->type === 'select')
                    <select
                        name="field_{{ $field->key }}"
                        class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100 @error('field_' . $field->key) border-rose-400 @enderror"
                        {{ $field->required ? 'required' : '' }}
                    >
                        <option value="">— انتخاب کنید —</option>
                        @foreach($field->options ?? [] as $opt)
                        <option value="{{ $opt }}" {{ old('field_' . $field->key, $application?->data[$field->key] ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>

                    @elseif($field->type === 'file')
                    @php $existingFile = $application?->data[$field->key] ?? null; @endphp
                    @if($existingFile)
                    <div class="mb-2 text-xs text-surface-500">
                        فایل قبلی:
                        <a href="{{ asset('storage/' . $existingFile) }}" target="_blank" class="text-primary-500 underline">مشاهده فایل</a>
                    </div>
                    @endif
                    <input
                        type="file"
                        name="field_{{ $field->key }}"
                        class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100 @error('field_' . $field->key) border-rose-400 @enderror"
                        {{ $field->required && !$existingFile ? 'required' : '' }}
                    >

                    @elseif($field->type === 'checkbox')
                    <label class="flex items-start gap-3 cursor-pointer p-3 rounded-xl border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-800">
                        <input type="checkbox" name="field_{{ $field->key }}" value="1"
                               class="mt-0.5 text-primary-500 rounded focus:ring-primary-500"
                               {{ old('field_' . $field->key, $application?->data[$field->key] ?? false) ? 'checked' : '' }}
                               {{ $field->required ? 'required' : '' }}>
                        <span class="text-sm text-surface-700 dark:text-surface-300">{{ $field->placeholder ?: $field->label }}</span>
                    </label>
                    @endif

                    @if($field->help_text)
                    <p class="text-xs text-surface-400 mt-1">{{ $field->help_text }}</p>
                    @endif

                    @error('field_' . $field->key)
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>

            <button type="submit" class="w-full btn-primary !py-3 gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                @if($application && $application->status === 'rejected')
                    ارسال مجدد درخواست
                @else
                    ارسال درخواست
                @endif
            </button>
        </form>
        @endif
        @elseif($application && in_array($application->status, ['pending', 'reviewing']))
        <div class="glass-card rounded-2xl p-6 text-center space-y-3 text-surface-500">
            <svg class="w-10 h-10 mx-auto text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm">درخواست شما در صف بررسی است. پس از تأیید، حساب شما به حساب هنرمند تبدیل خواهد شد.</p>
        </div>
        @endif

    </div>
</x-layouts.app>

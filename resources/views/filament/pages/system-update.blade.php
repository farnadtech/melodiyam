<x-filament-panels::page>

{{-- ===== PROGRESS OVERLAY ===== --}}
<div
    id="update-overlay"
    wire:loading.flex
    wire:target="runUpdate,uploadManualUpdate"
    style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;padding:1rem;"
>
    <div style="background:#fff;border-radius:14px;padding:24px;width:100%;max-width:340px;box-shadow:0 25px 60px rgba(0,0,0,0.35);text-align:center;">
        <svg style="width:40px;height:40px;margin:0 auto 16px;animation:upd-spin 0.9s linear infinite;" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" stroke="#e5e7eb" stroke-width="3"/>
            <path d="M12 2a10 10 0 0 1 10 10" stroke="#3b82f6" stroke-width="3" stroke-linecap="round"/>
        </svg>
        <p style="margin:0 0 4px;font-size:15px;font-weight:700;color:#111827;">در حال نصب بروزرسانی</p>
        <p style="margin:0 0 16px;font-size:12px;color:#6b7280;">لطفاً صبور باشید...</p>
        <div style="height:5px;background:#e5e7eb;border-radius:9999px;overflow:hidden;margin-bottom:14px;">
            <div style="height:100%;background:#3b82f6;border-radius:9999px;animation:upd-progress 2s ease-in-out infinite;"></div>
        </div>
        <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:8px 12px;">
            <p style="margin:0;font-size:11px;color:#92400e;">⚠️ مرورگر را نبندید — صفحه به صورت خودکار بروزرسانی می‌شود</p>
        </div>
    </div>
</div>

<style>
@keyframes upd-spin { to { transform: rotate(360deg); } }
@keyframes upd-progress {
    0%   { width:10%; margin-right:90%; }
    50%  { width:60%; margin-right:0%; }
    100% { width:10%; margin-right:90%; }
}
@keyframes upd-pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>

<script>
document.addEventListener('livewire:navigating', function() {
    var el = document.getElementById('update-overlay');
    if (el) el.style.display = 'flex';
});
</script>

{{-- ===== PAGE ===== --}}
<div style="display:flex;flex-direction:column;gap:1.5rem;">

    {{-- کارت بروزرسانی خودکار --}}
    <x-filament::section>
        <x-slot name="heading">بروزرسانی خودکار</x-slot>

        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- ردیف: نسخه فعلی ← نسخه جدید + badge --}}
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;padding:12px 16px;background:#f9fafb;border-radius:12px;border:1px solid #e5e7eb;">

                {{-- نسخه فعلی --}}
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:34px;height:34px;border-radius:50%;background:#fff;border:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:15px;height:15px;color:#9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 12h6M9 15h4"/>
                        </svg>
                    </div>
                    <div>
                        <p style="margin:0;font-size:10px;color:#9ca3af;line-height:1;">نسخه فعلی</p>
                        <p style="margin:0;font-size:14px;font-weight:700;font-family:monospace;color:#374151;line-height:1.4;">{{ $currentVersion }}</p>
                    </div>
                </div>

                {{-- فلش --}}
                <svg style="width:14px;height:14px;color:#d1d5db;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>

                {{-- آخرین نسخه --}}
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:34px;height:34px;border-radius:50%;background:{{ $hasUpdate ? '#eff6ff' : '#f0fdf4' }};border:1px solid {{ $hasUpdate ? '#bfdbfe' : '#bbf7d0' }};display:flex;align-items:center;justify-content:center;">
                        @if($hasUpdate)
                            <svg style="width:15px;height:15px;color:#3b82f6;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        @else
                            <svg style="width:15px;height:15px;color:#22c55e;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p style="margin:0;font-size:10px;color:#9ca3af;line-height:1;">آخرین نسخه</p>
                        <p style="margin:0;font-size:14px;font-weight:700;font-family:monospace;color:{{ $hasUpdate ? '#3b82f6' : '#374151' }};line-height:1.4;">{{ $serverVersion }}</p>
                    </div>
                </div>

                {{-- badge وضعیت --}}
                <div style="margin-right:auto;">
                    @if($hasUpdate)
                        <span style="display:inline-flex;align-items:center;gap:5px;background:#dbeafe;color:#1d4ed8;font-size:11px;font-weight:600;padding:4px 10px;border-radius:9999px;white-space:nowrap;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#3b82f6;display:inline-block;animation:upd-pulse 1.5s ease-in-out infinite;"></span>
                            آپدیت موجود
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:5px;background:#dcfce7;color:#15803d;font-size:11px;font-weight:600;padding:4px 10px;border-radius:9999px;white-space:nowrap;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                            به‌روز است
                        </span>
                    @endif
                </div>
            </div>

            {{-- دکمه عملیات --}}
            @if($hasUpdate)
                <x-filament::button wire:click="runUpdate" color="primary" icon="heroicon-o-arrow-down-circle" class="w-full">
                    <span wire:loading.remove wire:target="runUpdate">نصب نسخه {{ $serverVersion }}</span>
                    <span wire:loading wire:target="runUpdate">در حال پردازش...</span>
                </x-filament::button>
            @else
                <x-filament::button wire:click="checkUpdate" color="gray" icon="heroicon-o-magnifying-glass" class="w-full">
                    <span wire:loading.remove wire:target="checkUpdate">بررسی مجدد</span>
                    <span wire:loading wire:target="checkUpdate">در حال بررسی...</span>
                </x-filament::button>
            @endif

            @if($errorDebug)
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 12px;">
                    <p style="margin:0;font-size:11px;font-family:monospace;color:#dc2626;word-break:break-all;">{{ $errorDebug }}</p>
                </div>
            @endif

        </div>
    </x-filament::section>

    {{-- کارت آپدیت دستی --}}
    <x-filament::section>
        <x-slot name="heading">آپدیت دستی</x-slot>

        <form wire:submit.prevent="uploadManualUpdate" style="display:flex;flex-direction:column;gap:12px;">
            <p class="text-xs text-gray-500 dark:text-gray-400" style="margin:0;line-height:1.6;">
                اگر آپدیت خودکار انجام نمی‌شود، فایل ZIP پکیج آپدیت را اینجا آپلود کنید.
            </p>
            {{ $this->form }}
            <x-filament::button type="submit" color="gray" icon="heroicon-o-cloud-arrow-up" class="w-full">
                <span wire:loading.remove wire:target="uploadManualUpdate">نصب پکیج آپلود شده</span>
                <span wire:loading wire:target="uploadManualUpdate">در حال نصب...</span>
            </x-filament::button>
        </form>
    </x-filament::section>

    {{-- Changelog --}}
    <x-filament::section collapsible collapsed>
        <x-slot name="heading">لیست تغییرات (Changelog)</x-slot>

        @if($changelog)
            <div style="background:#f9fafb;border:1px solid #f3f4f6;border-radius:10px;padding:16px;font-size:13px;color:#4b5563;line-height:1.8;">
                {!! nl2br(e($changelog)) !!}
            </div>
        @else
            <p style="text-align:center;padding:2rem 0;font-size:13px;color:#9ca3af;font-style:italic;margin:0;">توضیحاتی وجود ندارد.</p>
        @endif
    </x-filament::section>

</div>

</x-filament-panels::page>

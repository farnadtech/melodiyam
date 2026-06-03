<div class="flex items-center gap-2">
    @if($getRecord()->file_path)
        <audio controls class="h-8 w-48" preload="none">
            <source src="{{ asset('storage/' . $getRecord()->file_path) }}" type="audio/mpeg">
            مرورگر شما از پخش صوتی پشتیبانی نمی‌کند.
        </audio>
    @elseif($getRecord()->file_url)
        <audio controls class="h-8 w-48" preload="none">
            <source src="{{ $getRecord()->file_url }}" type="audio/mpeg">
            مرورگر شما از پخش صوتی پشتیبانی نمی‌کند.
        </audio>
    @else
        <span class="text-xs text-gray-400 italic">بدون فایل</span>
    @endif
</div>

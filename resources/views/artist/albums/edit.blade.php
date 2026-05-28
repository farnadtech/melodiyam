<x-layouts.app title="ویرایش آلبوم">
<div class="p-4 lg:p-8 max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('artist.albums') }}" wire:navigate class="text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">ویرایش آلبوم: {{ $album->title }}</h1>
    </div>

    @if(session('success'))
    <div class="glass-card rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-sm text-emerald-700 dark:text-emerald-400">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="glass-card rounded-xl p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800">
        <ul class="text-sm text-rose-600 dark:text-rose-400 space-y-1 list-disc list-inside">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('artist.albums.update', $album) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="glass-card rounded-2xl p-6 space-y-5">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">اطلاعات آلبوم</h2>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">عنوان آلبوم <span class="text-rose-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $album->title) }}" required
                       class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">نوع</label>
                    <select name="type" required class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="album" @selected(old('type', $album->type)==='album')>آلبوم</option>
                        <option value="single" @selected(old('type', $album->type)==='single')>سینگل</option>
                        <option value="ep" @selected(old('type', $album->type)==='ep')>EP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ژانر</label>
                    <select name="genre_id" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">انتخاب ژانر</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" @selected(old('genre_id', $album->genre_id) == $genre->id)>{{ $genre->name_fa ?: $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-jalali-date-input name="release_date" label="تاریخ انتشار (شمسی)" :value="old('release_date', $album->release_date?->format('Y-m-d'))" />

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">توضیحات</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-y">{{ old('description', $album->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">تصویر کاور</label>
                @if($album->cover_image)
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ asset('storage/'.$album->cover_image) }}" class="w-16 h-16 rounded-xl object-cover">
                    <span class="text-xs text-surface-400">کاور فعلی</span>
                </div>
                @endif
                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-surface-600 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_explicit" id="al_explicit_e" value="1"
                       {{ old('is_explicit', $album->is_explicit) ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                <label for="al_explicit_e" class="text-sm text-surface-700 dark:text-surface-300 cursor-pointer">محتوای بزرگسال (Explicit)</label>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-5" x-data="{ forSale: {{ $album->is_for_sale ? 'true' : 'false' }} }">
            <h2 class="font-semibold text-surface-900 dark:text-white border-b border-surface-200 dark:border-surface-700 pb-3">قیمت‌گذاری</h2>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_for_sale" id="al_for_sale_e" value="1" x-model="forSale"
                       {{ old('is_for_sale', $album->is_for_sale) ? 'checked' : '' }} class="w-4 h-4 rounded accent-primary-500">
                <label for="al_for_sale_e" class="text-sm font-medium text-surface-700 dark:text-surface-300 cursor-pointer">این آلبوم قابل فروش است</label>
            </div>

            <div x-show="forSale" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت (تومان)</label>
                    <input type="number" name="price" value="{{ old('price', $album->price) }}" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">قیمت با تخفیف</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $album->discount_price) }}" min="0"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">ثانیه‌های پیش‌نمایش</label>
                    <input type="number" name="preview_seconds" value="{{ old('preview_seconds', $album->preview_seconds ?? 30) }}" min="0" max="300"
                           class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary px-8 py-3">ذخیره تغییرات</button>
            <a href="{{ route('artist.albums') }}" wire:navigate class="btn-ghost px-6 py-3">انصراف</a>
        </div>
    </form>

    {{-- Tracks of this album — drag & drop reorder --}}
    @if($album->tracks->isNotEmpty())
    <div class="glass-card rounded-2xl p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-surface-200 dark:border-surface-700 pb-3">
            <h2 class="font-semibold text-surface-900 dark:text-white">آهنگ‌های این آلبوم ({{ $album->tracks->count() }})</h2>
            <div class="flex items-center gap-3">
                <span id="reorder-status" class="text-xs text-emerald-500 hidden">✓ ذخیره شد</span>
                <a href="{{ route('artist.tracks.create') }}" wire:navigate class="text-sm text-primary-500 hover:underline">+ آهنگ جدید</a>
            </div>
        </div>
        <p class="text-xs text-surface-400">برای تغییر ترتیب، آهنگ‌ها را بکشید و رها کنید.</p>
        <div id="tracks-sortable" class="divide-y divide-surface-100 dark:divide-surface-700">
            @foreach($album->tracks as $track)
            <div class="flex items-center gap-3 py-3 cursor-grab active:cursor-grabbing select-none"
                 data-id="{{ $track->id }}">
                <span class="text-surface-300 dark:text-surface-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                    </svg>
                </span>
                <span class="track-num text-xs text-surface-400 w-5 text-center flex-shrink-0">{{ $track->track_number ?? '—' }}</span>
                <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0">
                    <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate">{{ $track->title }}</p>
                    <p class="text-xs text-surface-400">
                        @if($track->release_date){{ \App\Helpers\Jalali::format($track->release_date, 'Y/m/d') }}@endif
                    </p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $track->status === 'published' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-surface-100 text-surface-500' }}">
                    {{ $track->status === 'published' ? 'منتشر' : 'پیش‌نویس' }}
                </span>
                <a href="{{ route('artist.tracks.edit', $track) }}" wire:navigate
                   class="p-1.5 rounded-lg text-surface-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <script>
    (function(){
        var list = document.getElementById('tracks-sortable');
        if (!list) return;
        var reorderUrl = '{{ route('artist.albums.reorder', $album) }}';
        var csrfToken = '{{ csrf_token() }}';
        var statusEl = document.getElementById('reorder-status');
        var dragged = null;

        list.querySelectorAll('[data-id]').forEach(function(item) {
            item.draggable = true;
            item.addEventListener('dragstart', function(e) {
                dragged = item;
                item.style.opacity = '0.5';
                e.dataTransfer.effectAllowed = 'move';
            });
            item.addEventListener('dragend', function() {
                item.style.opacity = '';
                dragged = null;
                saveOrder();
            });
            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                var rect = item.getBoundingClientRect();
                var midY = rect.top + rect.height / 2;
                if (dragged && dragged !== item) {
                    if (e.clientY < midY) list.insertBefore(dragged, item);
                    else list.insertBefore(dragged, item.nextSibling);
                }
            });
        });

        function saveOrder() {
            var order = [];
            list.querySelectorAll('[data-id]').forEach(function(el, i) {
                order.push(parseInt(el.dataset.id));
                var numEl = el.querySelector('.track-num');
                if (numEl) numEl.textContent = i + 1;
            });
            fetch(reorderUrl, {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
                body: JSON.stringify({order: order})
            }).then(function(r){ return r.json(); }).then(function(d){
                if (d.ok && statusEl) {
                    statusEl.classList.remove('hidden');
                    setTimeout(function(){ statusEl.classList.add('hidden'); }, 2000);
                }
            });
        }
    })();
    </script>
    @endif

</div>
</x-layouts.app>

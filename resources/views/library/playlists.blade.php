<x-layouts.app title="پلی‌لیست‌ها">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پلی‌لیست‌های من</h1>
            <div x-data="{ showModal: false, title: '', description: '', creating: false }">
                <button @click="showModal = true" class="btn-primary text-sm">ساخت پلی‌لیست جدید</button>

                {{-- Create Playlist Modal --}}
                <div x-show="showModal" x-cloak @keydown.escape.window="showModal = false" class="fixed inset-0 z-[100] flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = false"></div>
                    <div class="relative bg-white dark:bg-surface-800 rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4" @click.stop>
                        <h3 class="text-lg font-bold text-surface-900 dark:text-white mb-4">ساخت پلی‌لیست جدید</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">نام پلی‌لیست</label>
                                <input x-model="title" type="text" class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-700 border-0 text-surface-900 dark:text-surface-100 text-sm focus:ring-2 focus:ring-primary-500/50 focus:outline-none" placeholder="مثلاً: آهنگ‌های مورد علاقه">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">توضیحات (اختیاری)</label>
                                <textarea x-model="description" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-surface-100 dark:bg-surface-700 border-0 text-surface-900 dark:text-surface-100 text-sm focus:ring-2 focus:ring-primary-500/50 focus:outline-none resize-none" placeholder="توضیح کوتاه..."></textarea>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-6 justify-end">
                            <button @click="showModal = false" class="px-4 py-2 rounded-xl text-sm text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">انصراف</button>
                            <button
                                @click="if(!title.trim() || creating) return;
                                    creating = true;
                                    fetch('/playlist/create', {
                                        method: 'POST',
                                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content},
                                        body: JSON.stringify({title: title.trim(), description: description.trim()})
                                    }).then(r => r.json()).then(d => { creating = false; showModal = false; window.location.href = '/playlist/' + d.slug; }).catch(() => creating = false)"
                                class="btn-primary text-sm"
                                :class="creating ? 'opacity-50' : ''"
                            >
                                <span x-show="!creating">ساخت</span>
                                <span x-show="creating">در حال ساخت...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($playlists->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($playlists as $playlist)
                @include('components.playlist-card', ['playlist' => $playlist])
            @endforeach
        </div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">هنوز پلی‌لیستی ندارید</p></div>
        @endif
    </div>
</x-layouts.app>

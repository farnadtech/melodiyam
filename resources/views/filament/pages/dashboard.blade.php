<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->getStats() as $key => $stat)
                <div class="relative overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20">
                            <x-heroicon-o-{{ str_replace('heroicon-o-', '', $stat['icon']) }} class="h-6 w-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                    @if($stat['trend'])
                        <div class="mt-4 flex items-center gap-1 text-sm text-success-600 dark:text-success-400">
                            <x-heroicon-o-arrow-up class="h-4 w-4" />
                            <span>+{{ $stat['trend'] }} این هفته</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Tracks --}}
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">آهنگ‌های جدید</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">۵ آهنگ اخیراً اضافه شده</p>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($this->getRecentTracks() as $track)
                        <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <img src="{{ $track['cover'] }}" alt="" class="h-10 w-10 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-950 dark:text-white truncate">{{ $track['title'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $track['artist'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $track['plays'] }} پخش</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $track['created'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            آهنگی یافت نشد
                        </div>
                    @endforelse
                </div>
                <div class="border-t border-gray-200 px-6 py-3 dark:border-gray-800">
                    <a href="{{ route('filament.admin.resources.tracks.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                        مشاهده همه →
                    </a>
                </div>
            </div>

            {{-- Top Artists --}}
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">برترین هنرمندان</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">بر اساس تعداد پخش</p>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($this->getTopArtists() as $artist)
                        <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <img src="{{ $artist['avatar'] }}" alt="" class="h-10 w-10 rounded-full object-cover">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $artist['name'] }}</p>
                            </div>
                            <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                <x-heroicon-o-play class="h-4 w-4" />
                                <span>{{ $artist['streams'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            هنرمندی یافت نشد
                        </div>
                    @endforelse
                </div>
                <div class="border-t border-gray-200 px-6 py-3 dark:border-gray-800">
                    <a href="{{ route('filament.admin.resources.artists.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                        مشاهده همه →
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">کاربران جدید</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">آخرین کاربران ثبت‌نام شده</p>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($this->getRecentUsers() as $user)
                    <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <img src="{{ $user['avatar'] }}" alt="" class="h-10 w-10 rounded-full object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $user['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user['email'] }}</p>
                        </div>
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $user['joined'] }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        کاربری یافت نشد
                    </div>
                @endforelse
            </div>
            <div class="border-t border-gray-200 px-6 py-3 dark:border-gray-800">
                <a href="{{ route('filament.admin.resources.users.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                    مشاهده همه کاربران →
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>

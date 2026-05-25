<x-layouts.app title="خانه">

    <div class="p-4 lg:p-8 space-y-10">

        {{-- Hero Section --}}
        <section class="relative overflow-hidden rounded-3xl gradient-primary p-8 lg:p-12">
            <div class="absolute inset-0 bg-gradient-to-l from-black/20 to-transparent"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>

            <div class="relative z-10 max-w-2xl">
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-white mb-4 leading-tight">
                    موسیقی بی‌پایان
                    <br>
                    <span class="text-white/80">با ملودیام</span>
                </h1>
                <p class="text-base lg:text-lg text-white/80 mb-6 leading-relaxed">
                    میلیون‌ها آهنگ، پادکست و پلی‌لیست. هر لحظه، هر جا، هر دستگاه.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('premium') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-primary-600 font-bold text-sm hover:bg-white/90 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2z"/></svg>
                        شروع رایگان
                    </a>
                    <a href="{{ route('browse') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white/20 text-white font-medium text-sm hover:bg-white/30 transition-colors backdrop-blur-sm">
                        مرور موسیقی
                    </a>
                </div>
            </div>
        </section>

        {{-- New Releases --}}
        @if($newReleases->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">تازه‌ترین‌ها</h2>
                    <p class="text-sm text-surface-500 mt-1">جدیدترین آهنگ‌های منتشر شده</p>
                </div>
                <a href="{{ route('browse') }}" wire:navigate class="btn-ghost text-sm">مشاهده همه</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($newReleases->take(6) as $track)
                    @include('components.track-card', ['track' => $track])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Trending --}}
        @if($trendingTracks->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">پرطرفدارها</h2>
                    <p class="text-sm text-surface-500 mt-1">محبوب‌ترین آهنگ‌های این ماه</p>
                </div>
                <a href="{{ route('browse') }}" wire:navigate class="btn-ghost text-sm">مشاهده همه</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($trendingTracks->take(6) as $track)
                    @include('components.track-card', ['track' => $track])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Featured Artists --}}
        @if($featuredArtists->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">هنرمندان برتر</h2>
                    <p class="text-sm text-surface-500 mt-1">محبوب‌ترین هنرمندان ملودیام</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                @foreach($featuredArtists as $artist)
                    @include('components.artist-card', ['artist' => $artist])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Genres --}}
        @if($genres->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">ژانرها</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($genres as $genre)
                    @include('components.genre-card', ['genre' => $genre])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Latest Albums --}}
        @if($latestAlbums->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">آلبوم‌های جدید</h2>
                    <p class="text-sm text-surface-500 mt-1">جدیدترین آلبوم‌ها</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($latestAlbums as $album)
                    @include('components.album-card', ['album' => $album])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Featured Playlists --}}
        @if($featuredPlaylists->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">پلی‌لیست‌های ویژه</h2>
                    <p class="text-sm text-surface-500 mt-1">پلی‌لیست‌های منتخب تیم ملودیام</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($featuredPlaylists as $playlist)
                    @include('components.playlist-card', ['playlist' => $playlist])
                @endforeach
            </div>
        </section>
        @endif

    </div>

</x-layouts.app>

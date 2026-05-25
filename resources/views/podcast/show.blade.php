<x-layouts.app :title="$podcast->title">
    <div class="p-4 lg:p-8 space-y-8">
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $podcast->cover_image ? asset('storage/' . $podcast->cover_image) : asset('images/default-cover.png') }}" alt="{{ $podcast->title }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">پادکست</p>
                <h1 class="text-3xl lg:text-4xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $podcast->title }}</h1>
                <p class="text-sm text-surface-500 mb-3">{{ $podcast->user->name ?? '' }}</p>
                @if($podcast->description)
                <p class="text-surface-600 dark:text-surface-400 text-sm leading-relaxed">{{ Str::limit($podcast->description, 200) }}</p>
                @endif
            </div>
        </div>

        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">قسمت‌ها</h2>
            <div class="space-y-3">
                @foreach($podcast->episodes as $episode)
                <div class="glass-card rounded-2xl p-5">
                    <div class="flex items-start gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-surface-900 dark:text-surface-100">{{ $episode->title }}</p>
                            <p class="text-xs text-surface-400 mt-1">فصل {{ $episode->season_number }} · قسمت {{ $episode->episode_number }}</p>
                            @if($episode->description)
                            <p class="text-xs text-surface-500 mt-2 line-clamp-2">{{ $episode->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-3 text-xs text-surface-400">
                                <span>{{ $episode->formattedDuration() }}</span>
                                @if($episode->published_at)
                                <span>{{ $episode->published_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>
                        <button class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center flex-shrink-0 hover:bg-primary-400 transition-colors">
                            <svg class="w-4 h-4 text-white mr-[-1px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.app>

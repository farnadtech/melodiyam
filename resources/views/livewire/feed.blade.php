<div class="w-full max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-black text-white">
            {{ $title === 'Stream' ? 'فید موسیقی' : $title }}
        </h1>
        <div class="flex items-center bg-gray-900/50 p-1 rounded-xl border border-gray-800">
            <button wire:click="setFilter('all')" 
                    class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-300 {{ $filter === 'all' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/20' : 'text-gray-400 hover:text-gray-200' }}">
                همه فعالیت‌ها
            </button>
            <button wire:click="setFilter('tracks')" 
                    class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-300 {{ $filter === 'tracks' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/20' : 'text-gray-400 hover:text-gray-200' }}">
                فقط آهنگ‌ها
            </button>
        </div>
    </div>

    <div class="space-y-10">
        @forelse($activities as $activity)
            <div class="activity-item group animate-in fade-in slide-in-from-bottom-4 duration-500">
                {{-- Header: User/Artist info --}}
                <div class="flex items-center gap-4 mb-4 text-sm">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $activity->user->getAvatarUrl() }}" 
                             class="w-10 h-10 rounded-full object-cover border border-gray-700">
                        @if($activity->user->artist)
                            <div class="absolute -bottom-1 -right-1 bg-primary-500 rounded-full p-0.5 border border-black">
                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col min-w-0 flex-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-gray-200 font-bold hover:text-white cursor-pointer transition">
                                {{-- اگه هنرمنده اسم هنرمندیشو نشون بده --}}
                                {{ $activity->user->artist?->display_name ?? $activity->user->name }}
                            </span>
                            <span class="text-gray-500">
                                @if($activity->type === 'reposted')
                                    این را بازنشر کرد
                                @elseif($activity->type === 'track_published')
                                    آهنگ جدید منتشر کرد
                                @elseif($activity->type === 'album_published')
                                    آلبوم جدید منتشر کرد
                                @elseif($activity->type === 'podcast_published')
                                    پادکست جدید منتشر کرد
                                @elseif($activity->type === 'liked')
                                    این را پسندید
                                @else
                                    فعالیت جدیدی داشت
                                @endif
                            </span>
                        </div>
                        <span class="text-gray-600 text-[10px]">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @php
                    $subject = $activity->subject;
                    if($activity->type === 'reposted' && $subject instanceof \App\Models\Repost) {
                        $subject = $subject->repostable;
                    }
                @endphp

                @if(!$subject)
                    <div class="bg-gray-900/30 p-4 rounded-xl border border-gray-800 text-gray-600 text-xs italic">
                        این محتوا دیگر در دسترس نیست.
                    </div>
                @elseif($subject instanceof \App\Models\Track)
                    @php
                        $user = auth()->user();
                        $isPremiumUser = $user?->isPremium() ?? false;
                        $isPremiumOnly = (bool) $subject->is_premium_only;
                        $premiumPreviewSec = $isPremiumOnly && !$isPremiumUser
                            ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                            : 0;
                        $isPaid = !$isPremiumOnly && $subject->is_for_sale && $subject->price;
                        // Premium users with includes_paid_content can play paid tracks
                        $hasPlanPaidAccess = $user?->activeSubscription?->plan?->includes_paid_content ?? false;
                        
                        $previewSec = $subject->preview_seconds ?? 0;
                        $canPlay = (!$isPremiumOnly || $isPremiumUser) && (!$isPaid || $hasPlanPaidAccess);
                        $price = $subject->discount_price ?: $subject->price;
                        
                        $playerTrack = [
                            'id'               => $subject->id,
                            'title'            => $subject->title,
                            'artist'           => $subject->artist?->display_name ?? ($subject->artist_name ?? ($subject->user?->name ?? 'کاربر ناشناس')),
                            'cover'            => $subject->getCoverUrl(),
                            'url'              => $subject->getStreamUrl(),
                            'previewSeconds'   => $isPremiumOnly ? $premiumPreviewSec : (int)$previewSec,
                            'canPlay'          => $canPlay,
                            'isPremium'        => $isPremiumOnly && !$isPremiumUser,
                            'price'            => $price,
                            'purchaseUrl'      => $isPremiumOnly
                                ? route('premium')
                                : route('purchase', ['type' => 'track', 'id' => $subject->id]),
                        ];
                    @endphp
                    <div class="flex flex-col md:flex-row bg-gradient-to-br from-gray-900 to-black p-4 md:p-5 rounded-xl border border-gray-800 hover:border-gray-700 transition shadow-2xl relative overflow-hidden group/card">
                        <div class="w-full md:w-44 h-48 md:h-44 flex-shrink-0 relative group/cover z-10 mb-4 md:mb-0">
                            <img src="{{ $subject->getCoverUrl() }}" 
                                 class="w-full h-full object-cover rounded shadow-2xl">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/cover:opacity-100 transition-all duration-300 flex items-center justify-center rounded">
                                <button 
                                     @click.stop="{{ $playerTrack['isPremium'] ? 'true' : 'false' }}
                                         ? $store.player.play({ ...{{ Js::from($playerTrack) }}, canPlay: false })
                                         : ({{ ($isPaid && !$hasPlanPaidAccess) ? 'true' : 'false' }} && !{{ $playerTrack['previewSeconds'] ?: 0 }}
                                             ? $store.player.showPurchaseModal({{ Js::from($playerTrack) }})
                                             : $store.player.play({{ Js::from($playerTrack) }}))"
                                     :class="{{ $playerTrack['isPremium'] ? 'true' : 'false' }} ? 'bg-purple-500 hover:bg-purple-400 shadow-purple-500/40' : 'bg-primary-500 hover:bg-primary-400'"
                                     class="w-14 h-14 rounded-full flex items-center justify-center text-white shadow-2xl transform scale-90 group-hover/cover:scale-100 transition duration-300">
                                     <template x-if="{{ ($isPaid && !$hasPlanPaidAccess) ? 'true' : 'false' }} && !{{ $playerTrack['previewSeconds'] ?: 0 }} && !{{ $playerTrack['isPremium'] ? 'true' : 'false' }}">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </template>
                                    <template x-if="!({{ ($isPaid && !$hasPlanPaidAccess) ? 'true' : 'false' }} && !{{ $playerTrack['previewSeconds'] ?: 0 }} && !{{ $playerTrack['isPremium'] ? 'true' : 'false' }})">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                    </template>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex-1 md:mr-6 flex flex-col z-10 min-w-0">
                            <div class="flex justify-between items-start mb-2">
                                <div class="min-w-0">
                                    <h3 class="text-white text-xl md:text-2xl font-black leading-tight truncate">
                                        <a href="{{ route('track.show', $subject->slug) }}" wire:navigate class="hover:text-primary-400 transition">{{ $subject->title }}</a>
                                    </h3>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <p class="text-gray-400 font-medium truncate">{{ $subject->artist?->display_name ?? ($subject->artist_name ?? ($subject->user?->name ?? 'کاربر ناشناس')) }}</p>
                                        @if($isPremiumOnly)
                                            <span class="whitespace-nowrap text-[10px] font-bold px-1.5 py-0.5 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 leading-none">پریمیوم</span>
                                        @elseif($isPaid && !$hasPlanPaidAccess)
                                            <span class="whitespace-nowrap text-xs font-bold text-primary-500">{{ number_format($price) }} ت</span>
                                        @endif
                                    </div>
                                </div>
                                @if($subject->genre)
                                    <span class="text-[10px] px-2.5 py-1 bg-gray-800/80 text-gray-400 rounded-full border border-gray-700 uppercase tracking-tighter whitespace-nowrap">#{{ $subject->genre->name_fa }}</span>
                                @endif
                            </div>

                            {{-- Waveform - Hidden on mobile to save space --}}
                            <div class="hidden md:flex mt-4 mb-6 h-14 items-end gap-[2px] space-x-reverse opacity-40 hover:opacity-70 transition duration-500 cursor-pointer">
                                @for($i=0; $i<70; $i++)
                                    @php $h = rand(15, 100); @endphp
                                    <div class="flex-1 bg-gradient-to-t from-primary-500 to-primary-300 rounded-full" style="height: {{ $h }}%"></div>
                                @endfor
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-4 mt-auto">
                                <div class="flex items-center gap-2">
                                    <button wire:click="toggleLike('track', {{ $subject->id }})" 
                                            class="px-3 md:px-4 py-1.5 bg-gray-800/50 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded border border-gray-700/50 transition flex items-center gap-1.5 group/btn {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'text-rose-500 border-rose-500/30 bg-rose-500/5' : '' }}">
                                        <svg class="w-4 h-4 {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'fill-current' : 'group-hover/btn:text-rose-500' }} transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        <span class="hidden sm:inline">پسندیدن</span>
                                    </button>
                                    <button wire:click="toggleRepost('track', {{ $subject->id }})"
                                            class="px-3 md:px-4 py-1.5 bg-gray-800/50 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded border border-gray-700/50 transition flex items-center gap-1.5 group/btn {{ auth()->user() && $subject->reposts()->where('user_id', auth()->id())->exists() ? 'text-primary-500 border-primary-500/30 bg-primary-500/5' : '' }}">
                                        <svg class="w-4 h-4 {{ auth()->user() && $subject->reposts()->where('user_id', auth()->id())->exists() ? 'text-primary-500' : 'group-hover/btn:text-primary-500' }} transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                        <span class="hidden sm:inline">بازنشر</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-3 md:gap-4 text-gray-500 text-[10px] md:text-[11px] font-medium">
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>{{ number_format($subject->play_count) }}</span>
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>{{ number_format($subject->like_count) }}</span>
                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>{{ number_format($subject->comment_count) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($subject instanceof \App\Models\Album)
                    <div class="flex flex-col md:flex-row bg-gradient-to-br from-gray-900 to-black p-5 md:p-6 rounded-xl border border-gray-800 hover:border-gray-700 transition shadow-xl relative overflow-hidden group/card">
                        <div class="w-full md:w-40 h-48 md:h-40 flex-shrink-0 relative group/cover z-10 mb-4 md:mb-0">
                            <img src="{{ $subject->getCoverUrl() }}" 
                                 class="w-full h-full object-cover rounded shadow-2xl">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/cover:opacity-100 transition-all duration-300 flex items-center justify-center rounded">
                                <a href="{{ route('album.show', $subject->slug) }}" class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-2xl transform scale-90 group-hover/cover:scale-100 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex-1 md:mr-8 flex flex-col justify-center z-10 min-w-0">
                                <span class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em] mb-1">آلبوم</span>
                                <h3 class="text-white text-2xl md:text-3xl font-black leading-tight truncate">
                                <a href="{{ route('album.show', $subject->slug) }}" wire:navigate class="hover:text-primary-400 transition">{{ $subject->title }}</a>
                            </h3>
                            <p class="text-gray-400 text-base md:text-lg mt-1 truncate">{{ $subject->artist->display_name }}</p>
                            <div class="mt-4 md:mt-6 flex items-center justify-between text-gray-500 text-xs font-bold">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>{{ $subject->tracks()->count() }} آهنگ</span>
                                    <span>@if($subject->release_date) @jalali($subject->release_date, 'Y') @endif</span>
                                </div>
                                <div class="flex items-center gap-1 md:gap-2">
                                    <button wire:click="toggleLike('album', {{ $subject->id }})" 
                                            class="p-2 hover:bg-rose-500/10 rounded-full transition {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'text-rose-500' : 'text-gray-600' }}">
                                        <svg class="w-5 h-5 {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                    <button wire:click="toggleRepost('album', {{ $subject->id }})" 
                                            class="p-2 hover:bg-primary-500/10 rounded-full transition {{ auth()->user() && $subject->reposts()->where('user_id', auth()->id())->exists() ? 'text-primary-500' : 'text-gray-600' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($subject instanceof \App\Models\Podcast)
                        <div class="flex flex-col md:flex-row bg-gradient-to-br from-gray-900 to-black p-5 rounded-xl border border-gray-800 hover:border-gray-700 transition shadow-xl relative overflow-hidden group/card">
                            <div class="w-full md:w-40 h-48 md:h-40 flex-shrink-0 relative group/cover z-10 mb-4 md:mb-0">
                            <img src="{{ $subject->getCoverUrl() }}" 
                                 class="w-full h-full object-cover rounded shadow-2xl">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/cover:opacity-100 transition-all duration-300 flex items-center justify-center rounded">
                                    <a href="{{ route('podcast.show', $subject->slug) }}" class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-2xl transform scale-90 group-hover/cover:scale-100 transition duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-1 md:mr-8 flex flex-col justify-center z-10 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="min-w-0">
                                        <span class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em] mb-1">پادکست</span>
                                        <h3 class="text-white text-2xl font-black leading-tight truncate">
                                            <a href="{{ route('podcast.show', $subject->slug) }}" wire:navigate class="hover:text-primary-400 transition">{{ $subject->title }}</a>
                                        </h3>
                                        <p class="text-gray-400 mt-1 truncate">{{ $subject->artist?->display_name ?? $subject->user?->name }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button wire:click="toggleLike('podcast', {{ $subject->id }})" 
                                                class="p-2 hover:bg-rose-500/10 rounded-full transition {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'text-rose-500' : 'text-gray-600' }}">
                                            <svg class="w-6 h-6 {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        </button>
                                        <button wire:click="toggleRepost('podcast', {{ $subject->id }})" 
                                                class="p-2 hover:bg-primary-500/10 rounded-full transition {{ auth()->user() && $subject->reposts()->where('user_id', auth()->id())->exists() ? 'text-primary-500' : 'text-gray-600' }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($subject instanceof \App\Models\PodcastEpisode)
                        <div class="flex flex-col md:flex-row bg-gradient-to-br from-gray-900 to-black p-5 rounded-xl border border-gray-800 hover:border-gray-700 transition shadow-xl relative overflow-hidden group/card">
                            <div class="w-full md:w-32 h-40 md:h-32 flex-shrink-0 relative group/cover z-10 mb-4 md:mb-0">
                            <img src="{{ $subject->getCoverUrl() }}" 
                                 class="w-full h-full object-cover rounded shadow-2xl">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/cover:opacity-100 transition flex items-center justify-center rounded">
                                    <a href="{{ route('podcast.show', $subject->podcast->slug) }}" class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-xl transform scale-90 group-hover/cover:scale-100 transition">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-1 md:mr-6 flex flex-col justify-center z-10 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="min-w-0">
                                        <span class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em] mb-1">پادکست</span>
                                        <h3 class="text-white text-xl font-bold leading-tight truncate">
                                            <a href="{{ route('podcast.show', $subject->podcast->slug) }}" wire:navigate class="hover:text-primary-400 transition">{{ $subject->title }}</a>
                                        </h3>
                                        <p class="text-gray-400 text-sm mt-1 truncate">{{ $subject->podcast->title }}</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button wire:click="toggleLike('episode', {{ $subject->id }})" 
                                                class="p-2 hover:bg-rose-500/10 rounded-full transition {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'text-rose-500' : 'text-gray-600' }}">
                                            <svg class="w-5 h-5 {{ auth()->user() && $subject->likes()->where('user_id', auth()->id())->exists() ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        </button>
                                        <button wire:click="toggleRepost('episode', {{ $subject->id }})" 
                                                class="p-2 hover:bg-primary-500/10 rounded-full transition {{ auth()->user() && $subject->reposts()->where('user_id', auth()->id())->exists() ? 'text-primary-500' : 'text-gray-600' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        @empty
            <div class="text-center py-24 bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-800/50">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-600">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4"></path></svg>
                </div>
                <h3 class="text-white text-xl font-bold mb-2">هنوز خبری نیست!</h3>
                <p class="text-gray-500 max-w-xs mx-auto">هنرمندان و دوستان خود را دنبال کنید تا آخرین فعالیت‌های آن‌ها را اینجا ببینید.</p>
                <a href="{{ route('browse') }}" wire:navigate class="mt-8 inline-flex items-center px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-full transition shadow-lg shadow-primary-500/20">
                    کشف هنرمندان جدید
                </a>
            </div>
        @endforelse
    </div>

    @if($activities->hasMorePages())
        <div x-data="{
            observe() {
                let observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            @this.loadMore()
                        }
                    })
                }, {
                    rootMargin: '150px',
                })
                observer.observe(this.$el)
            }
        }" x-init="observe()" class="mt-16 flex justify-center py-8">
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 bg-primary-500 rounded-full animate-bounce [animation-duration:0.8s]"></div>
                <div class="w-2 h-2 bg-primary-500 rounded-full animate-bounce [animation-duration:0.8s] [animation-delay:0.2s]"></div>
                <div class="w-2 h-2 bg-primary-500 rounded-full animate-bounce [animation-duration:0.8s] [animation-delay:0.4s]"></div>
            </div>
        </div>
    @endif
</div>

<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Album;
use App\Models\Podcast;
use App\Models\PodcastEpisode;
use App\Models\PodcastSubscription;
use App\Models\Repost;
use Livewire\Component;
use Livewire\WithPagination;

class Feed extends Component
{
    use WithPagination;

    public $userId = null;
    public $title = 'Stream';
    public $perPage = 10;
    public $filter = 'all'; // all, tracks

    public function mount($userId = null, $title = 'Stream')
    {
        $this->userId = $userId;
        $this->title = $title;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->perPage = 10;
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function toggleLike($type, $id)
    {
        if (!auth()->check()) return redirect()->route('login');

        $controller = new \App\Http\Controllers\Web\InteractionController();
        $request = new \Illuminate\Http\Request([
            'type' => $type,
            'id' => $id
        ]);
        
        $controller->like($request);
    }

    public function toggleRepost($type, $id)
    {
        if (!auth()->check()) return redirect()->route('login');

        $controller = new \App\Http\Controllers\Web\InteractionController();
        $request = new \Illuminate\Http\Request([
            'type' => $type,
            'id' => $id
        ]);
        
        $controller->repost($request);
    }

    public function render()
    {
        $user = auth()->user();
        
        $query = Activity::query();

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        } else {
            if (!$user) {
                return view('livewire.feed', ['activities' => collect()]);
            }

            // Get IDs of followed users
            $followingUserIds = $user->followingUsers()->pluck('followable_id')->toArray();
            
            // Get user_ids of followed artists
            $followingArtistIds = $user->followingArtists()->pluck('followable_id')->toArray();
            $artistUserIds = Artist::whereIn('id', $followingArtistIds)->pluck('user_id')->toArray();
            
            // Combine all user IDs we are interested in (including the user themselves)
            $allFollowingUserIds = array_unique(array_merge($followingUserIds, $artistUserIds, [$user->id]));

            // Podcast subscriptions
            $subscribedPodcastIds = PodcastSubscription::where('user_id', $user->id)
                ->pluck('podcast_id')->toArray();

            $query->where(function($q) use ($allFollowingUserIds, $followingArtistIds, $subscribedPodcastIds) {
                // 1. Activities by followed users/artists AND own activities
                $q->whereIn('user_id', $allFollowingUserIds)
                
                // 2. Activities where the subject belongs to a followed artist (redundant but safe)
                ->orWhere(function($sq) use ($followingArtistIds) {
                    $sq->whereIn('subject_type', [Track::class, Album::class, Podcast::class, PodcastEpisode::class])
                      ->whereHasMorph('subject', [Track::class, Album::class, Podcast::class, PodcastEpisode::class], function($ssq, $type) use ($followingArtistIds) {
                          if ($type === PodcastEpisode::class) {
                              $ssq->whereHas('podcast', fn($pq) => $pq->whereIn('artist_id', $followingArtistIds));
                          } else {
                              $ssq->whereIn('artist_id', $followingArtistIds);
                          }
                      });
                })
                
                // 3. Subscribed podcasts
                ->orWhere(function($sq) use ($subscribedPodcastIds) {
                    $sq->where(function($ssq) use ($subscribedPodcastIds) {
                        $ssq->where('subject_type', Podcast::class)
                           ->whereIn('subject_id', $subscribedPodcastIds);
                    })
                    ->orWhere(function($ssq) use ($subscribedPodcastIds) {
                        $ssq->where('subject_type', PodcastEpisode::class)
                           ->whereHasMorph('subject', [PodcastEpisode::class], function($eq) use ($subscribedPodcastIds) {
                               $eq->whereIn('podcast_id', $subscribedPodcastIds);
                           });
                    });
                });
            });
        }

        if ($this->filter === 'tracks') {
            $query->where(function($q) {
                $q->where('type', 'track_published')
                  ->orWhere(function($sq) {
                      $sq->where('type', 'reposted')
                         ->where('subject_type', Repost::class)
                         ->whereHasMorph('subject', [Repost::class], function($ssq) {
                             $ssq->where('repostable_type', Track::class);
                         });
                  });
            });
        }

        $activities = $query->with(['user', 'subject', 'user.artist'])
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.feed', [
            'activities' => $activities
        ]);
    }
}

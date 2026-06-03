<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        static::updated(function (Model $model) {
            // Record activity when status changes to 'published'
            if ($model->isDirty('status') && $model->status === 'published') {
                $model->recordActivity('published');
            }
        });

        static::created(function (Model $model) {
            // Record activity if created with 'published' status
            if ($model->status === 'published') {
                $model->recordActivity('published');
            }
        });
    }

    public function recordActivity($event)
    {
        $user_id = $this->getActivityUserId();
        
        if (!$user_id) return;

        $activityType = $this->getActivityType($event);

        // Avoid duplicate activities for the same subject and type
        Activity::updateOrCreate([
            'user_id' => $user_id,
            'type' => $activityType,
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
        ], [
            'ip_address' => request()->ip(),
        ]);

        // Notify followers
        if ($event === 'published') {
            $this->notifyFollowers();
        }
    }

    protected function notifyFollowers()
    {
        $owner = null;
        if (isset($this->artist_id) && $this->artist_id) {
            $this->loadMissing('artist');
            $owner = $this->artist;
        } elseif (isset($this->user_id) && $this->user_id) {
            $this->loadMissing('user');
            $owner = $this->user;
        }

        if ($owner) {
            // Using a job would be better for performance
            $followers = \App\Models\Follow::where('followable_type', get_class($owner))
                ->where('followable_id', $owner->id)
                ->with('user')
                ->get();

            foreach ($followers as $follower) {
                if ($follower->user) {
                    \App\Services\NotificationDispatcher::dispatch('new_content_follower', [
                        'artist_name' => $owner->display_name ?? $owner->name,
                        'content_title' => $this->title ?? 'محتوای جدید',
                    ], $follower->user);
                }
            }
        }
    }

    protected function getActivityUserId()
    {
        if (isset($this->user_id) && $this->user_id) return $this->user_id;
        
        if (isset($this->artist_id) && $this->artist_id) {
            $this->loadMissing('artist');
            return $this->artist?->user_id;
        }

        if (isset($this->podcast_id) && $this->podcast_id) {
            $this->loadMissing('podcast.user');
            return $this->podcast?->user_id;
        }
        
        return auth()->id();
    }

    protected function getActivityType($event)
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$name}_{$event}";
    }
}

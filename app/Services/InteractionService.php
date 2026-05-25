<?php

namespace App\Services;

use App\Models\Follow;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InteractionService
{
    public function toggleLike(User $user, Model $likeable): bool
    {
        $existing = Like::where('user_id', $user->id)
            ->where('likeable_type', get_class($likeable))
            ->where('likeable_id', $likeable->id)
            ->first();

        if ($existing) {
            $existing->delete();
            if (method_exists($likeable, 'decrement')) {
                $likeable->decrement('like_count');
            }
            return false; // unliked
        }

        Like::create([
            'user_id' => $user->id,
            'likeable_type' => get_class($likeable),
            'likeable_id' => $likeable->id,
        ]);

        if (method_exists($likeable, 'increment')) {
            $likeable->increment('like_count');
        }

        return true; // liked
    }

    public function toggleFollow(User $user, Model $followable): bool
    {
        $existing = Follow::where('user_id', $user->id)
            ->where('followable_type', get_class($followable))
            ->where('followable_id', $followable->id)
            ->first();

        if ($existing) {
            $existing->delete();
            if (property_exists($followable, 'followers_count') || $followable->getConnection()->getSchemaBuilder()->hasColumn($followable->getTable(), 'followers_count')) {
                $followable->decrement('followers_count');
            }
            return false; // unfollowed
        }

        Follow::create([
            'user_id' => $user->id,
            'followable_type' => get_class($followable),
            'followable_id' => $followable->id,
        ]);

        if (property_exists($followable, 'followers_count') || $followable->getConnection()->getSchemaBuilder()->hasColumn($followable->getTable(), 'followers_count')) {
            $followable->increment('followers_count');
        }

        return true; // followed
    }
}

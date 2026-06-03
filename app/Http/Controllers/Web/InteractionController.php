<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Repost;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InteractionController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
        ]);

        $user = auth()->user();
        $type = $this->resolveType($request->type);
        
        $like = Like::where([
            'user_id' => $user->id,
            'likeable_type' => $type,
            'likeable_id' => $request->id,
        ])->first();

        if ($like) {
            $like->delete();
            $this->decrementCount($type, $request->id, 'like_count');
            return response()->json(['liked' => false]);
        }

        Like::create([
            'user_id' => $user->id,
            'likeable_type' => $type,
            'likeable_id' => $request->id,
        ]);
        
        $this->incrementCount($type, $request->id, 'like_count');

        // Record Activity for Feed
        \App\Models\Activity::create([
            'user_id' => $user->id,
            'type' => 'liked',
            'subject_type' => $type,
            'subject_id' => $request->id,
            'ip_address' => $request->ip(),
        ]);
        
        // Send Notification
        $target = $type::find($request->id);
        $owner = $this->getOwner($target);
        if ($owner && $owner->id !== $user->id) {
            \App\Services\NotificationDispatcher::dispatch('track_liked', [
                'track_title' => $target->title ?? ($target->name ?? 'محتوا'),
                'user_name' => $user->name,
            ], $owner);
        }
        
        return response()->json(['liked' => true]);
    }

    public function repost(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
        ]);

        $user = auth()->user();
        $type = $this->resolveType($request->type);

        $repost = Repost::where([
            'user_id' => $user->id,
            'repostable_type' => $type,
            'repostable_id' => $request->id,
        ])->first();

        if ($repost) {
            $repost->delete();
            return response()->json(['reposted' => false]);
        }

        $repost = Repost::create([
            'user_id' => $user->id,
            'repostable_type' => $type,
            'repostable_id' => $request->id,
            'ip_address' => $request->ip(),
        ]);

        // Send Notification
        $target = $type::find($request->id);
        $owner = $this->getOwner($target);
        if ($owner && $owner->id !== $user->id) {
            \App\Services\NotificationDispatcher::dispatch('track_reposted', [
                'track_title' => $target->title ?? ($target->name ?? 'محتوا'),
                'user_name' => $user->name,
            ], $owner);
        }

        return response()->json(['reposted' => true]);
    }

    public function comment(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $user = auth()->user();
        $type = $this->resolveType($request->type);

        $comment = Comment::create([
            'user_id' => $user->id,
            'commentable_type' => $type,
            'commentable_id' => $request->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'is_approved' => true,
        ]);

        $this->incrementCount($type, $request->id, 'comment_count');

        // Send Notification
        $target = $type::find($request->id);
        $owner = $this->getOwner($target);
        if ($owner && $owner->id !== $user->id) {
            $owner->notify(new \App\Notifications\CommentNotification($user, $target, $comment));
        }

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function follow(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:user,artist',
            'id' => 'required|integer',
        ]);

        $user = auth()->user();
        $type = $request->type === 'user' ? \App\Models\User::class : \App\Models\Artist::class;

        $follow = \App\Models\Follow::where([
            'user_id' => $user->id,
            'followable_type' => $type,
            'followable_id' => $request->id,
        ])->first();

        if ($follow) {
            $follow->delete();
            return response()->json(['following' => false]);
        }

        \App\Models\Follow::create([
            'user_id' => $user->id,
            'followable_type' => $type,
            'followable_id' => $request->id,
        ]);

        // Send Notification
        $target = $type::find($request->id);
        $targetUser = $request->type === 'user' ? $target : $target->user;
        if ($targetUser && $targetUser->id !== $user->id) {
            \App\Services\NotificationDispatcher::dispatch('user_followed', [
                'follower_name' => $user->name,
            ], $targetUser);
        }

        return response()->json(['following' => true]);
    }

    protected function getOwner($model)
    {
        if ($model instanceof \App\Models\User) return $model;
        if (isset($model->user)) return $model->user;
        if (isset($model->artist)) return $model->artist->user;
        return null;
    }

    public function report(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'id' => 'required|integer',
            'reason' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $type = $this->resolveType($request->type);

        Report::create([
            'user_id' => $user->id,
            'reportable_type' => $type,
            'reportable_id' => $request->id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json(['success' => true]);
    }

    protected function resolveType($type)
    {
        return match($type) {
            'track' => \App\Models\Track::class,
            'album' => \App\Models\Album::class,
            'podcast' => \App\Models\Podcast::class,
            'episode', 'podcast_episode' => \App\Models\PodcastEpisode::class,
            'comment' => \App\Models\Comment::class,
            'playlist' => \App\Models\Playlist::class,
            default => abort(400, 'Invalid type'),
        };
    }

    protected function incrementCount($type, $id, $column)
    {
        $model = $type::find($id);
        if ($model && Schema::hasColumn($model->getTable(), $column)) {
            $model->increment($column);
        }
    }

    protected function decrementCount($type, $id, $column)
    {
        $model = $type::find($id);
        if ($model && Schema::hasColumn($model->getTable(), $column)) {
            $model->decrement($column);
        }
    }
}

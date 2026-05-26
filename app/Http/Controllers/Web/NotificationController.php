<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->expectsJson()) {
            $notifications = $request->user()
                ->notifications()
                ->latest()
                ->limit(20)
                ->get()
                ->map(fn($n) => [
                    'id'         => $n->id,
                    'title'      => $n->title ?? ($n->data['title'] ?? 'اعلان'),
                    'message'    => $n->body  ?? ($n->data['message'] ?? ''),
                    'url'        => $n->data['url'] ?? $n->data['track_url'] ?? null,
                    'read_at'    => $n->is_read ? $n->read_at : null,
                    'created_at' => $n->created_at->diffForHumans(),
                ]);

            $unreadCount = $request->user()->notifications()->unread()->count();

            return response()->json([
                'notifications' => $notifications,
                'unread_count'  => $unreadCount,
            ]);
        }

        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead(); // uses NotificationLog::markAsRead() which sets is_read=true

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->unread()->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }
}

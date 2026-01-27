<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user notifications
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get active announcements
        $announcements = Announcement::active()
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'announcements', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->markAsRead();

        if ($notification->link) {
            return redirect($notification->link);
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }
}

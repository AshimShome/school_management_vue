<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->notifications()->latest()->get());
    }

    public function markAllRead()
    {
        return auth()->user()->unreadNotifications->markAsRead();
    }

    public function unreadCount()
    {
        return response()->json(auth()->user()->unreadNotifications->count());
    }

    public function getSingleNotification($notification_id)
    {
        return response()->json(auth()->user()->notifications()->find($notification_id));
    }

    public function markRead($notification_id)
    {
        $notification = auth()->user()->notifications()->find($notification_id);

        $notification->markAsRead();
    }

    public function markToggleRead($notification_id)
    {
        $notification = auth()->user()->notifications()->find($notification_id);

        if ($notification->read_at) {
            $notification->markAsUnread();
        } else {
            $notification->markAsRead();
        }
    }
}

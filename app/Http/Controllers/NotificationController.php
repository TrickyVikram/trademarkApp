<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if (!$notification || $notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }
}

<?php

namespace App\Services;

use App\Events\NewNotification;
use App\Models\Notification;

class NotificationService
{
    public function getUserNotifications()
    {
        $user = auth()->user();

        return $user->notifications()->orderByDesc('created_at')->get();
    }

    public function createNotification(array $notificationData)
    {
        $notification = Notification::create($notificationData);

        broadcast(new NewNotification($notification))->toOthers();

        return $notification;
    }

    public function markAsRead(string $notificationId)
    {
        $notification = Notification::findOrFail($notificationId);

        $notification->update(['is_read' => true]);
    }
}

<?php

namespace NotificationChannels\Ombala\Tests\TestSupport;

use Illuminate\Notifications\Notification;

class TestNotificationStringMessage extends Notification
{
    public function toOmbala($notifiable): string
    {
        return 'this is my message';
    }
}

<?php

namespace NotificationChannels\Ombala\Tests\TestSupport;

use Illuminate\Notifications\Notification;
use NotificationChannels\Ombala\OmbalaMessage;

class TestNotification extends Notification
{
    public function toOmbala($notifiable): OmbalaMessage
    {
        return (new OmbalaMessage('this is my message'))->from('9223123321');
    }
}

<?php

namespace NotificationChannels\Ombala\Tests\TestSupport;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public string $phone_number = '9123123321';

    public function routeNotificationForOmbala($notification)
    {
        return $this->phone_number;
    }
}

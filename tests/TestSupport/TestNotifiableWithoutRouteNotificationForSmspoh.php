<?php

namespace NotificationChannels\Ombala\Tests\TestSupport;

class TestNotifiableWithoutRouteNotificationForOmbala extends TestNotifiable
{
    public function routeNotificationForOmbala($notification)
    {
        return false;
    }
}

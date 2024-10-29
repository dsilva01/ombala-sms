<?php

use NotificationChannels\Ombala\Exceptions\CouldNotSendNotification;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotifiable;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotifiableWithoutRouteNotificationForOmbala;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotification;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotificationLimitCountMessage;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotificationStringMessage;
use NotificationChannels\Ombala\Tests\TestSupport\TestNotificationTooLongMessage;

it('can send a notification', function () {
    $this->OmbalaApi->shouldReceive('send')->with([
        'from' => '9223123321',
        'to' => '9123123321',
        'message' => 'this is my message',
    ])->once();

    $this->channel->send(new TestNotifiable(), new TestNotification());
});

it('can send string message', function () {
    $this->OmbalaApi->shouldReceive('send')->once();

    $this->channel->send(new TestNotifiable(), new TestNotificationStringMessage());
});

it('does not send a message when to missed', function () {
    $this->OmbalaApi->shouldNotReceive('send');

    $this->channel->send(new TestNotifiableWithoutRouteNotificationForOmbala(), new TestNotification());
});

it('can check long content length', function () {
    $this->channel->send(new TestNotifiable(), new TestNotificationTooLongMessage());
})->throws(CouldNotSendNotification::class, 'Notification was not sent. Content length may not be greater than 918 characters.');

it('can check limit count content', function () {
    $this->OmbalaApi->shouldReceive('send')->once();

    $this->channel->send(new TestNotifiable(), new TestNotificationLimitCountMessage());
});

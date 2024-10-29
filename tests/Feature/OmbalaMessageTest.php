<?php

use NotificationChannels\Ombala\OmbalaMessage;

it('can accept a content when constructing a message', function () {
    $message = new OmbalaMessage('hello');

    $this->assertEquals('hello', $message->content);
});

it('can set the content', function () {
    $message = (new OmbalaMessage())->content('hello');

    $this->assertEquals('hello', $message->content);
});

it('can set the from', function () {
    $message = (new OmbalaMessage())->from('Ombala');

    $this->assertEquals('Ombala', $message->from);
});

<?php

use GuzzleHttp\Client;
use NotificationChannels\Ombala\Exceptions\CouldNotSendNotification;
use NotificationChannels\Ombala\OmbalaApi;

it('has config with default', function () {
    $endpoint = 'https://api.useombala.ao/v1/messages';

    config()->set('services.ombala.token', 'token');
    config()->set('services.ombala.endpoint', $endpoint);

    $ombala = getExtendedOmbalaApi('token', new Client);

    $this->assertEquals('token', $ombala->getToken());
    $this->assertEquals($endpoint, $ombala->getEndpoint());
});

it('can check ombala responded with error', function () {
    $ombala = new OmbalaApi('token', new Client());

    $ombala->send([
        'from' => '9223123321',
        'to' => '9123123321',
        'message' => 'this is my message',
        'test' => true,
    ]);
})->throws(CouldNotSendNotification::class);

it('can check not communicate with ombala', function () {
    config()->set('services.ombala.endpoint', 'https://api.useombala.ao/v1/messages');

    $ombala = new OmbalaApi('token', new Client());

    $ombala->send([
        'from' => '9223123321',
        'to' => '9123123321',
        'message' => 'this is my message',
        'test' => true,
    ]);
})->throws(CouldNotSendNotification::class);

function getExtendedOmbalaApi(string $token, Client $httpClient): OmbalaApi
{
    return new class($token, $httpClient) extends OmbalaApi
    {
        public function getEndpoint(): string
        {
            return $this->endpoint;
        }

        public function getToken(): string
        {
            return $this->token;
        }
    };
}

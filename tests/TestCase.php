<?php

namespace NotificationChannels\Ombala\Tests;

use Mockery;
use NotificationChannels\Ombala\OmbalaApi;
use NotificationChannels\Ombala\OmbalaChannel;
use NotificationChannels\Ombala\OmbalaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected OmbalaApi $OmbalaApi;

    protected OmbalaChannel $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(OmbalaApi::class, function () {
            return Mockery::mock(OmbalaApi::class);
        });

        $this->OmbalaApi = app(OmbalaApi::class);

        $this->channel = new OmbalaChannel($this->OmbalaApi, '4444444444');
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            OmbalaServiceProvider::class,
        ];
    }
}

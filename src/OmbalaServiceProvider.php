<?php

namespace NotificationChannels\Ombala;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class OmbalaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(OmbalaApi::class, static fn () => new OmbalaApi(
            config('services.ombala.token'),
            app(HttpClient::class)
        ));

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('ombala', static fn ($app) => new OmbalaChannel(
                $app[OmbalaApi::class],
                $app['config']['services.ombala.from'])
            );
        });
    }
}

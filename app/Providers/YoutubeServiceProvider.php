<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\Google\Service\YouTube::class, function ($app) {
            $client = new Google_Client();
            $client->setApplicationName('Hololive Livestream Notifier');
            $client->setScopes([
                'https://www.googleapis.com/auth/youtube.readonly',
            ]);
            $client->setDeveloperKey(config('services.youtube.api_key'));
            $client->setAccessType('offline');

            $service = new \Google\Service\YouTube($client);

            return $service;
        });
    }
}

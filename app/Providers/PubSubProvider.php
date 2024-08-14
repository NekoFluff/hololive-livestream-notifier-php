<?php

namespace App\Providers;

use App\Http\Clients\PubSubClient;
use Illuminate\Support\ServiceProvider;

class PubSubProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PubSubClient::class, function ($app) {
            return new PubSubClient(
                new \GuzzleHttp\Client(),
                config('services.pubsub.callback_url')
            );
        });
    }
}

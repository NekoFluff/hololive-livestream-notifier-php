<?php

namespace App\Console\Commands;

use App\Http\Clients\PubSubClient;
use Illuminate\Console\Command;

class SubscribeToAllTopics extends Command
{
    protected $signature = 'pubsub:subscribe';

    protected $description = 'Subscribe to all topics';

    /**
     * Execute the console command.
     */
    public function handle(PubSubClient $pubsubClient)
    {
        $pubsubClient->subscribeToTopics();
    }
}

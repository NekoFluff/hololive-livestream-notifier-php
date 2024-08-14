<?php

namespace App\Http\Clients;

use App\Models\Topic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PubSubClient
{
    public function __construct(
        protected Client $client,
        protected string $callbackUrl,
    ) {
    }

    public function subscribeToTopics(): void
    {
        try {
            $topics = Topic::all();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return;
        }


        foreach ($topics as $topic) {
            $hub = $this->discoverHub($topic->topic_url);
            $this->subscribe($hub, $topic);
        }
    }

    public function subscribe(string $hub, Topic $topic): void
    {
        $response = $this->client->post($hub, [
            'form_params' => [
                'hub.mode' => 'subscribe',
                'hub.topic' => $topic->topic_url,
                'hub.callback' => $this->callbackUrl,
                'hub.verify' => 'async',
            ],
        ]);

        if ($response->getStatusCode() !== 202) {
            Log::error('Failed to subscribe to topic: ' . $topic->first, [
                'status' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ]);
            return;
        }

        Log::info('Sent subscription request for topic: ' . $topic->name() . '... Waiting for verification');
    }

    public function discoverHub(string $url): string
    {
        $response = $this->client->get($url, [
            'query' => [
                'hub.mode' => 'discover',
            ],
        ]);

        $hub = $response->getBody()->getContents();

        $feed = simplexml_load_string($hub);
        for ($i = 0; $i < count($feed->link); $i++) {
            if ($feed->link[$i]['rel'] == 'hub') {
                $hub = (string) $feed->link[$i]['href'];
                break;
            }
        }
        return $hub;
    }
}

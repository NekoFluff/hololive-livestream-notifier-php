<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class YoutubeScraper
{
    public static function getVideoMetadata($url)
    {
        // $browser = new HttpBrowser(HttpClient::create());
        // $browser->request('GET', $url);
        // $crawler = $browser->getCrawler();

        $client = new Client();
        $response = $client->request('GET', $url);
        $crawler = new Crawler($response->getBody()->getContents());

        $title = $crawler->filter('meta[name="title"]')->attr('content', null);
        $description = $crawler->filter('meta[name="description"]')->attr('content', null);
        $html = $crawler->html();
        preg_match('/"scheduledStartTime":"(\d+)"/', $html, $matches);
        $livestream_start_dt = $matches[1] ?? null;

        Log::info("HTML", [
            'html' => $html,
        ]);

        return [
            'title' => $title,
            'description' => $description,
            'livestream_start_dt' => $livestream_start_dt,
        ];
    }
}

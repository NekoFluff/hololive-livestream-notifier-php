<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Spatie\Crawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
// use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class YoutubeScraper
{
    public static function getVideoMetadata($url)
    {
        // $browser = new HttpBrowser(HttpClient::create()->withOptions([
        //     'headers' => [
        //         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
        //         'Accept-Language' => 'en-US,en;q=0.9',
        //         'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        //     ],
        // ]));
        // $browser->request('GET', $url);
        // $crawler = $browser->getCrawler();

        // $client = new Client();
        // $response = $client->request('GET', $url);
        // $crawler = new Crawler($response->getBody()->getContents());

        // $title = $crawler->filter('meta[name="title"]')->attr('content', null);
        // $description = $crawler->filter('meta[name="description"]')->attr('content', null);
        // $html = $crawler->html();
        // preg_match('/"scheduledStartTime":"(\d+)"/', $html, $matches);
        // $livestream_start_dt = $matches[1] ?? null;

        // Log::info("HTML", [
        //     'html' => $html,
        // ]);

        // return [
        //     'title' => $title,
        //     'description' => $description,
        //     'livestream_start_dt' => $livestream_start_dt,
        // ];

        Crawler::create()
            ->setCrawlObserver(new YoutubeCrawlObserver())
            ->setMaximumDepth(0)
            ->setTotalCrawlLimit(1)
            ->startCrawling($url);

        return [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'livestream_start_dt' => null,
        ];
    }
}

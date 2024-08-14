<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class YoutubeCrawlObserver extends CrawlObserver
{
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {

        $html = $response->getBody();

        $crawler = new Crawler((string) $response->getBody());

        // dd($url, (string) $response->getBody());

        $title = $crawler->filter('meta[property="og:title"]')->attr('content', null);
        $description = $crawler->filter('meta[property="og:description"]')->attr('content', null);
        preg_match('/"scheduledStartTime":"(\d+)"/', $html, $matches);
        $livestream_start_dt = $matches[1] ?? null;


        Log::info("Crawled", [
            'url' => (string) $url,
            'title' => $title,
            'description' => $description,
            'livestream_start_dt' => $livestream_start_dt,
        ]);

    }
}

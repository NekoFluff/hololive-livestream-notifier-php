<?php

namespace App\Services;

use Symfony\Component\BrowserKit\HttpBrowser;

class YoutubeScraper
{
    public static function getVideoMetadata($url)
    {
        $client = new HttpBrowser();

        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('meta[name="title"]')->attr('content');
        $description = $crawler->filter('meta[name="description"]')->attr('content');
        // $image = $crawler->filter('meta[property="og:image"]')->attr('content');
        $html = $crawler->html();
        preg_match('/"scheduledStartTime":"(\d+)"/', $html, $matches);
        $livestream_start_dt = $matches[1] ?? null;

        return [
            'title' => $title,
            'description' => $description,
            'livestream_start_dt' => $livestream_start_dt,
            // 'image' => $image,
        ];
    }
}

<?php

namespace App\Services;

class VideoService
{
    public function __construct(public \Google\Service\YouTube $service)
    {
    }

    public function getVideoInfo(string $videoId)
    {
        $queryParams = [
            'id' => $videoId,
        ];

        $response = $this->service->videos->listVideos('snippet,contentDetails,statistics,liveStreamingDetails', $queryParams);

        return [
            'title' => $response->items[0]->snippet->title,
            'channel_title' => $response->items[0]->snippet->channelTitle,
            'thumbnail' => $response->items[0]->snippet->thumbnails->default->url,
            'view_count' => $response->items[0]->statistics->viewCount,
            'like_count' => $response->items[0]->statistics->likeCount,
            'dislike_count' => $response->items[0]->statistics->dislikeCount,
            'comment_count' => $response->items[0]->statistics->commentCount,
            'livestream_start_dt' => $response->items[0]->liveStreamingDetails->scheduledStartTime ?? null,
        ];
    }
}

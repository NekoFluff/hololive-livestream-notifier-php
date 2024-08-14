<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use App\Services\YoutubeScraper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon as DateTime;

class YoutubeController extends Controller
{
    public function challenge(Request $request)
    {
        Log::info("Challenge request received", [
            'mode' => $request->input('mode'),
            'topic' => $request->input('topic'),
            'lease_seconds' => $request->input('lease_seconds'),
            'challenge' => $request->input('challenge'),
        ]);

        return response($request->input('challenge'), 200);
    }

    public function callback()
    {
        $xml = simplexml_load_string(request()->getContent());

        // TODO: Send message to developer on discord

        $livestreamUrl = (string) $xml->entry->link->attributes()->href;

        $data = YoutubeScraper::getVideoMetadata($livestreamUrl);

        if (!isset($data['livestream_start_dt'])) {
            Log::warning('Livestream start date not found', [
                'url' => $livestreamUrl,
                'data' => $data,
            ]);
            return response();
        }

        Livestream::updateOrCreate([
            'url' => $livestreamUrl,
        ], [
            'title' => (string) $xml->entry->title,
            'author' => (string) $xml->entry->author->name,
            'livestream_start_dt' => DateTime::createFromTimestamp($data['livestream_start_dt']),
        ]);

        Log::info('Livestream data saved', [
            'url' => $livestreamUrl,
            'data' => $data,
        ]);

        // TODO: Send message to channel on discord

        // TODO: Setup discord livestream notification

        return response()->noContent();
    }
}

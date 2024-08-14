<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon as DateTime;
use Illuminate\Support\Facades\App;

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

        $livestreamUrl = (string) $xml->entry->link->attributes()->href;
        $videoId = (string) $xml->entry->id;
        $videoId = str_replace('yt:video:', '', $videoId);

        $videoService = new VideoService(App::make(\Google\Service\YouTube::class));
        $data = $videoService->getVideoInfo($videoId);

        if (!isset($data['livestream_start_dt'])) {
            Log::warning('Livestream start date not found', [
                'url' => $livestreamUrl,
                'data' => $data,
            ]);
            return response()->noContent();
        }

        $livesteam = Livestream::updateOrCreate([
            'url' => $livestreamUrl,
        ], [
            'title' => $data['title'],
            'author' => $data['channel_title'],
            'livestream_start_dt' => DateTime::createFromTimeString($data['livestream_start_dt']),
        ]);

        Log::info('Livestream data saved', [
            'url' => $livestreamUrl,
            'livestream' => $livesteam->toArray(),
        ]);

        // TODO: Send message to channel on discord

        // TODO: Setup discord livestream notification

        return response()->noContent();
    }
}

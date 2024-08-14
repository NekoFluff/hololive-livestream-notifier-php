<?php

use App\Http\Controllers\YoutubeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/yt-pubsub', [YoutubeController::class, 'challenge'])->name('yt-pubsub.challenge');
Route::post('api/yt-pubsub', [YoutubeController::class, 'callback'])->name('yt-pubsub.callback');

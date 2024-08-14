<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            [
                "first_name" => "irys",
                "last_name" => "",
                "topic_url" => "https://www.youtube.com/xml/feeds/videos.xml?channel_id=UC8rcEBzJSleTkf_-agPM20g",
                "group" => "en",
                "generation" => 2,
            ],
        ];

        foreach ($topics as $topic) {
            \App\Models\Topic::create($topic);
        }
    }
}

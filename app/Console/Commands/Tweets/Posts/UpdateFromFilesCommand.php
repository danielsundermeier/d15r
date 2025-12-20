<?php

namespace App\Console\Commands\Tweets\Posts;

use App\Enums\Tweets\Type;
use App\Models\Tweets\Tweet;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateFromFilesCommand extends Command
{
    protected $signature = 'tweets:posts:update-from-files';

    protected $description = 'Updates posts tweets from json files';

    public function handle()
    {
        $this->info('Updating tweeted posts...');
        $this->tweeted();

        $this->info('Updating scheduled posts...');
        $this->posts();

        return self::SUCCESS;
    }

    private function tweeted(): void
    {
        $tweets = Tweet::query()
            ->where('type', Type::POST)
            ->whereNotNull('tweet_id')
            ->get();

        foreach ($tweets as $tweet) {
            $this->line($tweet->scheduled_at->toDateString());

            $tweet->update([
                'scheduled_at' => $tweet->tweeted_at->setTime(0, 0, 0),
            ]);
        }
    }

    private function posts(): void
    {
        $files = glob(resource_path('tweets/posts/*.json'));
        foreach ($files as $file) {
            $basename = basename($file);

            $this->info($basename);

            $json = file_get_contents($file);
            $data = json_decode($json, true);

            foreach ($data as $key => $tweetData) {
                $scheduledAt = Carbon::parse($tweetData['date'])->setTime(0, 0, 0);
                $tweet = Tweet::updateOrCreate([
                    'type' => Type::POST,
                    'scheduled_at' => $scheduledAt,
                ], [
                    'text' => $tweetData['message'],
                    'source' => $basename,
                ]);
                $this->line("\t" . ($key + 1) . "\t" . $tweet->scheduled_at->format('Y-m-d') . "\t" . $tweet->text);
            }
        }
    }
}

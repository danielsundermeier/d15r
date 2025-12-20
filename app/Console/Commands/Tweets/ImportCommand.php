<?php

namespace App\Console\Commands\Tweets;

use App\Enums\Tweets\Type;
use App\Models\Tweets\Tweet;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ImportCommand extends Command
{
    protected $signature = 'tweets:import';

    protected $description = 'Imports tweets from json files';

    public function handle()
    {
        $this->info('Importing daylies...');
        $this->daylies();

        $this->info('Importing posts...');
        $this->posts();

        return self::SUCCESS;
    }

    private function daylies(): void
    {
        $files = glob(resource_path('tweets/daylies/*.json'));
        foreach ($files as $file) {
            $this->info(basename($file));

            $json = file_get_contents($file);
            $data = json_decode($json, true);

            foreach ($data as $key => $tweetData) {
                $scheduledAt = Carbon::parse($tweetData['date'])->setTime(0, 0, 0);
                $tweet = Tweet::updateOrCreate([
                    'type' => Type::DAYLY,
                    'source' => 'play.md',
                    'scheduled_at' => $scheduledAt,
                ], [
                    'text' => $tweetData['message'],
                ]);
                $this->line("\t" . ($key + 1) . "\t" . $tweet->scheduled_at->format('Y-m-d') . "\t" . $tweet->text);
            }
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

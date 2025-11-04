<?php

namespace App\Console\Commands\Tweets;

use App\Models\Tweets\Tweet;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'tweets:import';

    protected $description = 'Imports tweets from json files';

    public function handle()
    {
        // get all JSON files in ressources/daylies
        $files = glob(resource_path('daylies/*.json'));
        foreach ($files as $file) {
            $this->info(basename($file));

            $json = file_get_contents($file);
            $data = json_decode($json, true);

            foreach ($data as $key => $tweetData) {
                $tweet = Tweet::updateOrCreate([
                    'scheduled_at' => $tweetData['date'],
                ], [
                    'text' => $tweetData['message'],
                ]);
                $this->line("\t" . ($key + 1) . "\t" . $tweet->scheduled_at->format('Y-m-d') . "\t" . $tweet->text);
            }
        }

        return self::SUCCESS;
    }
}

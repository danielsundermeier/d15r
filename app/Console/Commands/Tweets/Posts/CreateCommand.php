<?php

namespace App\Console\Commands\Tweets\Posts;

use App\Enums\Tweets\Type;
use App\Models\Tweets\Tweet;
use Illuminate\Console\Command;
use App\Http\Integrations\Twitter\Tweets\CreateRequest;

class CreateCommand extends Command
{
    protected $signature = 'tweets:posts:create';

    protected $description = 'Creates post tweet';

    public function handle()
    {
        $tweet = Tweet::query()
            ->where('type', Type::POST)
            ->whereNull('tweet_id')
            ->whereDate('scheduled_at', '<=', now()->toDateString())
            ->orderBy('scheduled_at', 'DESC')
            ->first();

        if (!$tweet) {
            return self::SUCCESS;
        }

        $this->line($tweet->scheduled_at->toDateString() . ': ' . $tweet->text);

        $response = CreateRequest::make()
            ->text($tweet->text)
            ->send();

        if ($response->failed()) {
            $this->error('Failed to create tweet: ' . $response->body());

            return self::FAILURE;
        }

        $responseData = $response->json();

        $tweet->update([
            'scheduled_at' => $tweet->scheduled_at->setTime(0, 0, 0),
            'tweet_id' => $responseData['data']['id'],
            'tweeted_at' => now(),
        ]);

        return self::SUCCESS;
    }
}

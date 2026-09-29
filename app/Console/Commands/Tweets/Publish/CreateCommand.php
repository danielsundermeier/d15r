<?php

namespace App\Console\Commands\Tweets\Publish;

use App\Http\Integrations\Buffer\Posts\CreateRequest;
use App\Models\Posts\Post;
use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'tweets:publish:create';

    protected $description = 'Adds today\'s blog post to the Buffer queue';

    public function handle()
    {
        $post = Post::query()
            ->whereDate('published_at', now('Europe/Berlin')->toDateString())
            ->first();

        if (! $post) {
            return self::SUCCESS;
        }

        $description = Post::descriptionFromFile('blog/' . $post->filename);

        if (blank($description)) {
            return self::SUCCESS;
        }

        $text = $description . "\n\n" . route('posts.show', ['post' => $post]);

        $this->line($post->published_at->toDateString() . ': ' . $text);

        $response = CreateRequest::make()
            ->channel(config('services.buffer.channel_id'))
            ->text($text)
            ->send();

        if ($response->failed()) {
            $this->error('Failed to add post to Buffer: ' . $response->body());

            return self::FAILURE;
        }

        $responseData = $response->json();

        if (isset($responseData['errors'])) {
            $this->error('Failed to add post to Buffer: ' . json_encode($responseData['errors']));

            return self::FAILURE;
        }

        $result = $responseData['data']['createPost'] ?? [];

        if (($result['__typename'] ?? null) !== 'PostActionSuccess') {
            $this->error('Failed to add post to Buffer: ' . ($result['message'] ?? 'Unknown error'));

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}

<?php

namespace App\Http\Integrations\Buffer\Posts;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CreateRequest
{
    private string $channelId;

    private string $text;

    public static function make(): self
    {
        return new self;
    }

    public function channel(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function send(): Response
    {
        return Http::withToken(config('services.buffer.api_key'))
            ->acceptJson()
            ->timeout(10)
            ->post('https://api.buffer.com', [
                'query' => <<<'GRAPHQL'
                    mutation CreatePost($input: CreatePostInput!) {
                      createPost(input: $input) {
                        ... on PostActionSuccess {
                          __typename
                          post {
                            id
                            dueAt
                          }
                        }
                        ... on MutationError {
                          __typename
                          message
                        }
                      }
                    }
                    GRAPHQL,
                'variables' => [
                    'input' => [
                        'text' => $this->text,
                        'channelId' => $this->channelId,
                        'schedulingType' => 'automatic',
                        'mode' => 'addToQueue',
                    ],
                ],
            ]);
    }
}

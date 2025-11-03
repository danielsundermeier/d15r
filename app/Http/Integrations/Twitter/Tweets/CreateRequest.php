<?php

namespace App\Http\Integrations\Twitter\Tweets;

use App\Enums\Http\Method;
use App\Http\Integrations\Twitter\Request;

class CreateRequest extends Request
{
    protected Method $method = Method::POST;

    private string $text;

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    protected function sending(): void
    {
        $data = [
            'text' => $this->text,
        ];

        $this->pendingRequest->withBody(json_encode($data), 'application/json');
    }

    protected function resolveEndpoint(): string
    {
        return 'tweets';
    }
}

<?php

namespace App\Http\Integrations\Twitter;

use LogicException;
use App\Enums\Http\Method;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Integrations\Twitter\OAuth1;
use Tests\Support\Snapshots\JsonSnapshot;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class Request
{
    use ForwardsCalls;

    protected Method $method;

    protected PendingRequest $pendingRequest;

    abstract protected function resolveEndpoint(): string;

    public static function make(): self
    {
        return new static;
    }

    public function __construct()
    {
        $this->pendingRequest = $this->buildPendingRequest();
    }

    public function send(array $options = []): Response
    {
        $this->sending();

        // Middleware nutzen
        // Fixture erstellen
        // Query Parameter setzen
        // Body Parameter setzen

        $response = $this->pendingRequest->send($this->getMethod()->value, $this->resolveEndpoint(), $options);

        return $response;
    }

    public function mock(array $data, array $headers = [], int $status = \Illuminate\Http\Response::HTTP_OK): FakeResponse
    {
        $endpoint = $this->resolveEndpoint();

        Http::fake([
            $this->resolveBaseUrl().$endpoint => Http::response($data, $status, $headers),
        ]);

        return FakeResponse::make($status, $data, $headers, $this->resolveBaseUrl().$endpoint);
    }

    public function fixture(array $headers = [], int $status = \Illuminate\Http\Response::HTTP_OK, ?string $path = null): FakeResponse
    {
        $endpoint = $this->resolveEndpoint();
        $path = $path ?? $this->fixturePath();

        $data = JsonSnapshot::get($path, function () {
            return $this->send()->json();
        });

        $defaultHeaders = [
            //
        ];

        $headers = array_merge($defaultHeaders, $headers);

        Http::fake([
            $this->resolveBaseUrl().$endpoint => Http::response($data, $status, $headers),
        ]);

        return FakeResponse::make($status, $data, $headers, $this->resolveBaseUrl().$endpoint);
    }

    protected function fixturePath(): string
    {
        return 'tests/snapshots/twitter/'.str_replace('output.json/', '', $this->resolveEndpoint()).'.json';
    }

    protected function resolveBaseUrl(): string
    {
        return 'https://api.x.com/2/';
    }

    protected function buildPendingRequest(): PendingRequest
    {
        $middleware = new OAuth1([
            'consumer_key' => config('services.twitter.api_key'),
            'consumer_secret' => config('services.twitter.api_secret_key'),
            'token' => config('services.twitter.access_token'),
            'token_secret' => config('services.twitter.access_token_secret'),
        ]);

        return Http::baseUrl($this->resolveBaseUrl())
            ->withMiddleware($middleware)
            ->withOptions([
                'auth' => 'oauth',
                'debug' => false,
            ])
            ->timeout(10);
    }

    public function getMethod(): Method
    {
        if (! isset($this->method)) {
            throw new LogicException('Your request is missing a HTTP method. You must add a method property like [protected Method $method = Method::GET]');
        }

        return $this->method;
    }

    protected function sending(): void
    {
        //
    }

    public function __call($method, $parameters)
    {
        return $this->forwardDecoratedCallTo($this->pendingRequest, $method, $parameters);
    }
}

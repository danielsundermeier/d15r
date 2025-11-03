<?php

namespace App\Http\Integrations\Twitter;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Assert as PHPUnit;

class FakeResponse
{
    private $status;

    private array $headers = [];

    private array $data;

    private string $url;

    public static function make(int $status, array $data, array $headers = [], string $url)
    {
        return new static($status, $data, $headers, $url);
    }

    public function __construct(int $status, array $data, array $headers = [], string $url)
    {
        $this->status = $status;
        $this->data = $data;
        $this->headers = $headers;
        $this->url = $url;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function json(): array
    {
        return $this->data;
    }

    public function assertSent()
    {
        Http::assertSent(function (Request $request) {
            return $request->url() == $this->url;
        });
    }

    public function assertSentCount(int $count)
    {
        $recorded = Http::recorded(function (Request $request) {
            return $request->url() == $this->url;
        });

        PHPUnit::assertCount($count, $recorded, $this->url);
    }
}
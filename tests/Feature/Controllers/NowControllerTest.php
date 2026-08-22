<?php

namespace Tests\Feature\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NowControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        config(['services.overland.token' => 'secret']);
    }

    public function test_it_stores_the_latest_payload_and_appends_to_the_daily_log(): void
    {
        $this->travelTo('2026-08-22 13:45:00');

        $firstPayload = $this->payload('2026-08-22T13:44:55+02:00', 8.91, 52.28);
        $secondPayload = $this->payload('2026-08-22T13:45:04+02:00', 8.92, 52.29);

        $this->withToken('secret')->postJson('/now', $firstPayload)
            ->assertOk()
            ->assertExactJson(['result' => 'ok']);

        $this->withToken('secret')->postJson('/now', $secondPayload)
            ->assertOk();

        $this->assertSame($secondPayload, Cache::get('now.latest'));
        Storage::disk('local')->assertExists('now/2026-08-22.ndjson');

        $entries = collect(explode("\n", trim(Storage::disk('local')->get('now/2026-08-22.ndjson'))))
            ->map(fn (string $line): array => json_decode($line, true, 512, JSON_THROW_ON_ERROR));

        $this->assertCount(2, $entries);
        $this->assertSame('2026-08-22T13:45:00+02:00', $entries[0]['received_at']);
        $this->assertSame($firstPayload, $entries[0]['payload']);
        $this->assertSame($secondPayload, $entries[1]['payload']);
    }

    public function test_it_rejects_requests_without_the_configured_token(): void
    {
        $this->postJson('/now', $this->payload('2026-08-22T13:44:55+02:00', 8.91, 52.28))
            ->assertUnauthorized();

        $this->assertNull(Cache::get('now.latest'));
        Storage::disk('local')->assertDirectoryEmpty('/');
    }

    public function test_it_rejects_payloads_without_locations(): void
    {
        $this->withToken('secret')->postJson('/now', ['current' => []])
            ->assertUnprocessable();

        $this->assertNull(Cache::get('now.latest'));
        Storage::disk('local')->assertDirectoryEmpty('/');
    }

    public function test_it_rejects_json_that_is_not_an_object(): void
    {
        $this->withToken('secret')->call(
            'POST',
            '/now',
            server: ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer secret'],
            content: 'null'
        )->assertUnprocessable();

        $this->assertNull(Cache::get('now.latest'));
        Storage::disk('local')->assertDirectoryEmpty('/');
    }

    private function payload(string $timestamp, float $longitude, float $latitude): array
    {
        return [
            'locations' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [$longitude, $latitude],
                    ],
                    'properties' => [
                        'timestamp' => $timestamp,
                        'motion' => ['walking'],
                    ],
                ],
            ],
        ];
    }
}

<?php

namespace Tests\Feature\Console\Tweets\Publish;

use App\Enums\Tweets\Type;
use App\Models\Tweets\Tweet;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        DB::purge('sqlite');
        DB::setDefaultConnection('sqlite');

        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('source');
            $table->dateTime('scheduled_at');
            $table->text('text');
            $table->string('tweet_id')->nullable();
            $table->dateTime('tweeted_at')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_creates_a_due_publish_tweet_and_ignores_other_tweets(): void
    {
        Carbon::setTestNow('2026-09-04 09:30:00 Europe/Berlin');
        Http::fake([
            'https://api.x.com/2/tweets' => Http::response([
                'data' => ['id' => '123456789'],
            ]),
        ]);

        $publish = $this->tweet(Type::PUBLISH, '2026-09-04', 'Der Artikel ist da.');
        $post = $this->tweet(Type::POST, '2026-09-04', 'Ein anderer Tweet.');
        $future = $this->tweet(Type::PUBLISH, '2026-09-05', 'Ein zukünftiger Artikel.');

        $this->artisan('tweets:publish:create')->assertSuccessful();

        $this->assertSame('123456789', $publish->fresh()->tweet_id);
        $this->assertNotNull($publish->fresh()->tweeted_at);
        $this->assertNull($post->fresh()->tweet_id);
        $this->assertNull($future->fresh()->tweet_id);

        Http::assertSent(fn ($request) => $request->data() === [
            'text' => 'Der Artikel ist da.',
        ]);
    }

    public function test_it_succeeds_when_no_publish_tweet_is_due(): void
    {
        Carbon::setTestNow('2026-09-04 09:30:00 Europe/Berlin');
        Http::fake();

        $this->tweet(Type::PUBLISH, '2026-09-05', 'Ein zukünftiger Artikel.');

        $this->artisan('tweets:publish:create')->assertSuccessful();

        Http::assertNothingSent();
    }

    private function tweet(Type $type, string $scheduledAt, string $text): Tweet
    {
        return Tweet::create([
            'type' => $type,
            'source' => $type->value . '.md',
            'scheduled_at' => $scheduledAt,
            'text' => $text,
        ]);
    }
}

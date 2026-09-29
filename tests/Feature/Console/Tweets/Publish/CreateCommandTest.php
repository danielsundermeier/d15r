<?php

namespace Tests\Feature\Console\Tweets\Publish;

use App\Models\Posts\Post;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'services.buffer.api_key' => 'buffer-api-key',
            'services.buffer.channel_id' => 'buffer-channel-id',
        ]);

        DB::purge('sqlite');
        DB::setDefaultConnection('sqlite');
        Storage::fake();
        URL::forceRootUrl('https://d15r.de');
        URL::forceScheme('https');

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('markdown_body')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        URL::forceRootUrl(null);
        URL::forceScheme(null);

        parent::tearDown();
    }

    public function test_it_adds_todays_post_to_the_buffer_queue(): void
    {
        Carbon::setTestNow('2026-09-04 08:00:00 Europe/Berlin');
        Http::fake([
            'https://api.buffer.com' => Http::response([
                'data' => [
                    'createPost' => [
                        '__typename' => 'PostActionSuccess',
                        'post' => [
                            'id' => 'buffer-post-id',
                            'dueAt' => '2026-09-04T08:30:00.000Z',
                        ],
                    ],
                ],
            ]),
        ]);

        $this->createPost('2026-09-03', 'Ein alter Artikel', 'Alt.');
        $this->createPost('2026-09-04', 'Der heutige Artikel', 'Die Beschreibung.');
        $this->createPost('2026-09-05', 'Ein zukünftiger Artikel', 'Später.');

        $this->artisan('tweets:publish:create')->assertSuccessful();

        Http::assertSent(fn ($request) => $request->url() === 'https://api.buffer.com'
            && $request->hasHeader('Authorization', 'Bearer buffer-api-key')
            && $request['variables']['input'] === [
                'text' => "Die Beschreibung.\n\nhttps://d15r.de/blog/der-heutige-artikel",
                'channelId' => 'buffer-channel-id',
                'schedulingType' => 'automatic',
                'mode' => 'addToQueue',
            ]);
        Http::assertSentCount(1);
    }

    public function test_it_succeeds_when_no_post_is_published_today(): void
    {
        Carbon::setTestNow('2026-09-04 08:00:00 Europe/Berlin');
        Http::fake();

        $this->createPost('2026-09-05', 'Ein zukünftiger Artikel', 'Später.');

        $this->artisan('tweets:publish:create')->assertSuccessful();

        Http::assertNothingSent();
    }

    public function test_it_fails_when_buffer_rejects_the_post(): void
    {
        Carbon::setTestNow('2026-09-04 08:00:00 Europe/Berlin');
        Http::fake([
            'https://api.buffer.com' => Http::response([
                'data' => [
                    'createPost' => [
                        '__typename' => 'MutationError',
                        'message' => 'The channel is unavailable.',
                    ],
                ],
            ]),
        ]);

        $this->createPost('2026-09-04', 'Der heutige Artikel', 'Die Beschreibung.');

        $this->artisan('tweets:publish:create')
            ->expectsOutput('Failed to add post to Buffer: The channel is unavailable.')
            ->assertFailed();
    }

    private function createPost(string $date, string $title, string $description): Post
    {
        $filename = $date . ' ' . $title . '.md';
        $slug = str($title)->slug()->toString();

        Storage::put('blog/' . $filename, <<<MARKDOWN
        ---
        beschreibung: "{$description}"
        ---

        # {$title}

        Der Inhalt.
        MARKDOWN);

        return Post::create([
            'filename' => $filename,
            'slug' => $slug,
            'title' => $title,
            'markdown_body' => "# {$title}\n\nDer Inhalt.",
            'published_at' => $date,
        ]);
    }
}

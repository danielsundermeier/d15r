<?php

namespace Tests\Feature\Console\Posts;

use App\Enums\Tweets\Type;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ImportCommandTest extends TestCase
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
        URL::forceRootUrl(null);
        URL::forceScheme(null);

        parent::tearDown();
    }

    public function test_it_imports_one_publish_tweet_for_a_post_published_today_or_later(): void
    {
        Carbon::setTestNow('2026-09-04 10:00:00 Europe/Berlin');
        $this->putPost('2026-09-05 Ein neuer Gedanke.md', 'Die erste Beschreibung.');

        $this->artisan('posts:import')->assertSuccessful();

        $this->putPost('2026-09-05 Ein neuer Gedanke.md', 'Die neue Beschreibung.');
        $this->artisan('posts:import')->assertSuccessful();

        $this->assertDatabaseCount('tweets', 1);
        $this->assertDatabaseHas('tweets', [
            'type' => Type::PUBLISH->value,
            'source' => '2026-09-05 Ein neuer Gedanke.md',
            'scheduled_at' => '2026-09-05 00:00:00',
            'text' => "Die neue Beschreibung.\n\nhttps://d15r.de/blog/ein-neuer-gedanke",
        ]);
    }

    public function test_it_does_not_import_a_publish_tweet_for_a_past_post(): void
    {
        Carbon::setTestNow('2026-09-04 10:00:00 Europe/Berlin');
        $this->putPost('2026-09-03 Ein alter Gedanke.md', 'Die Beschreibung.');

        $this->artisan('posts:import')->assertSuccessful();

        $this->assertDatabaseCount('tweets', 0);
    }

    private function putPost(string $filename, string $description): void
    {
        $title = substr($filename, 11, -3);

        Storage::put('blog/' . $filename, <<<MARKDOWN
---
beschreibung: "{$description}"
---

# {$title}

Der Inhalt.
MARKDOWN);
    }
}

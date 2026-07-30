<?php

namespace Tests\Feature\Controllers\Posts;

use App\Http\Controllers\Posts\PostController;
use App\Models\Posts\Post;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PostControllerTest extends TestCase
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

        parent::tearDown();
    }

    public function test_navigation_only_contains_published_posts(): void
    {
        Carbon::setTestNow('2026-07-31 12:00:00');

        $previous = $this->createPost('Vorheriger Gedanke', now()->subDays(3));
        $current = $this->createPost('Aktueller Gedanke', now()->subDays(2));
        $next = $this->createPost('Nächster veröffentlichter Gedanke', now()->subDay());
        $future = $this->createPost('Noch nicht veröffentlichter Gedanke', now()->addDay());

        $currentView = app(PostController::class)->show($current);

        $this->assertTrue($currentView->getData()['previous_post']->is($previous));
        $this->assertTrue($currentView->getData()['next_post']->is($next));

        $nextView = app(PostController::class)->show($next);

        $this->assertTrue($nextView->getData()['previous_post']->is($current));
        $this->assertNull($nextView->getData()['next_post']);
        $this->assertDatabaseHas('posts', ['id' => $future->id]);
    }

    private function createPost(string $title, Carbon $publishedAt): Post
    {
        return Post::create([
            'filename' => $publishedAt->toDateString() . ' ' . $title . '.md',
            'slug' => str($title)->slug(),
            'title' => $title,
            'markdown_body' => "# {$title}\n\nInhalt",
            'published_at' => $publishedAt,
        ]);
    }
}

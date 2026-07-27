<?php

namespace Tests\Unit\Models\Posts;

use App\Models\Posts\Post;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_it_recognizes_article_files_by_their_filename_structure(): void
    {
        $this->assertTrue(Post::isArticleFile('2026-07-26 Welches Spiel wollen wir spielen?.md'));

        $this->assertFalse(Post::isArticleFile('.gitignore'));
        $this->assertFalse(Post::isArticleFile('AGENTS.md'));
        $this->assertFalse(Post::isArticleFile('2026-07-26 Artikel.txt'));
        $this->assertFalse(Post::isArticleFile('2026-02-30 Ungültiges Datum.md'));
        $this->assertFalse(Post::isArticleFile('entwürfe/2026-07-26 Artikel.md'));
    }

    public function test_attributes_are_the_same_with_and_without_frontmatter(): void
    {
        Storage::fake();

        $path = 'blog/2026-07-26 Welches Spiel wollen wir spielen?.md';
        $markdown = <<<MARKDOWN
# Welches Spiel wollen wir spielen?

Der eigentliche Beitrag.

---

Dieser Trenner gehört zum Beitrag.
MARKDOWN;

        Storage::put($path, $markdown);
        $attributesWithoutFrontmatter = Post::attributesFromFile($path);

        Storage::put($path, <<<MARKDOWN
---
beschreibung: "Wird vorerst nicht verwendet."
status: veroeffentlicht
iteration: 2
---

{$markdown}
MARKDOWN);
        $attributesWithFrontmatter = Post::attributesFromFile($path);

        $this->assertSame(
            $attributesWithoutFrontmatter['markdown_body'],
            $attributesWithFrontmatter['markdown_body']
        );
        $this->assertSame(
            $attributesWithoutFrontmatter['title'],
            $attributesWithFrontmatter['title']
        );
        $this->assertSame(
            $attributesWithoutFrontmatter['slug'],
            $attributesWithFrontmatter['slug']
        );
        $this->assertTrue(
            $attributesWithoutFrontmatter['published_at']->equalTo(
                $attributesWithFrontmatter['published_at']
            )
        );
    }
}

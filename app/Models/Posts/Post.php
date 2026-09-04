<?php

namespace App\Models\Posts;

use Carbon\Carbon;
use App\Traits\HasMarkdown;

use Illuminate\Support\Str;
use D15r\ModelPath\Traits\HasModelPath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Symfony\Component\Yaml\Yaml;

class Post extends Model
{
    use HasFactory,
        HasMarkdown,
        HasModelPath;

    const ROUTE_NAME = 'posts';

    protected $appends = [
        //
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'filename',
        'markdown_body',
        'published_at',
        'slug',
        'title',
    ];

    public static function isArticleFile(string $path): bool
    {
        if ($path !== basename($path)) {
            return false;
        }

        if (! preg_match('/^(?<date>\d{4}-\d{2}-\d{2}) .+\.md$/u', $path, $matches)) {
            return false;
        }

        try {
            return Carbon::createFromFormat('!Y-m-d', $matches['date'])->format('Y-m-d') === $matches['date'];
        } catch (\Throwable) {
            return false;
        }
    }

    public static function updateOrCreateFromFile(string $path): self
    {
        $attributes = self::attributesFromFile($path);
        $post = self::where('filename', $attributes['filename'])->first();

        if (is_null($post)) {
            $post = self::createFromFile($attributes);
        }
        else {
            $post->updateFromFile($attributes);
        }

        return $post;
    }

    public static function attributesFromFile(string $path): array
    {
        $filename = basename($path);
        $content = self::contentStartingAtTitle(Storage::get($path));
        $first_line = preg_split('#\r?\n#', $content, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));

        return [
            'markdown_body' => $content,
            'filename' => $filename,
            'published_at' => new Carbon(substr($filename, 0, 10)),
            'title' => $title,
            'slug' => Str::slug($title, '-', 'de'),
        ];
    }

    public static function descriptionFromFile(string $path): ?string
    {
        $content = Storage::get($path);

        if (! preg_match('/\A---\R(?<frontmatter>.*?)\R---(?:\R|\z)/s', $content, $matches)) {
            return null;
        }

        $frontmatter = Yaml::parse($matches['frontmatter']);

        return isset($frontmatter['beschreibung'])
            ? trim($frontmatter['beschreibung'])
            : null;
    }

    private static function contentStartingAtTitle(string $content): string
    {
        if (!preg_match('/^# .+$/m', $content, $matches, PREG_OFFSET_CAPTURE)) {
            return $content;
        }

        return substr($content, $matches[0][1]);
    }

    public static function createFromFile(array $attributes): self
    {
        $slug_count = self::where('slug', $attributes['slug'])->count();
        if ($slug_count > 0) {
            $attributes['slug'] .= '-' . $slug_count;
        }

        return self::create($attributes);
    }

    public function updateFromFile(array $attributes): self
    {
        $this->update([
            'title' => $attributes['title'],
            'markdown_body' => $attributes['markdown_body'],
        ]);

        return $this;
    }

    public function isDeletable() : bool
    {
        return true;
    }

    protected function getAvailablePaths() : array
    {
        return [
            'index_path',
            'path',
        ];
    }

    public function getDescriptionAttribute(): string
    {
        return trim(preg_replace('/\s+/', ' ', strip_tags($this->excerpt)));
    }

    public function getGithubEditUrlAttribute(): string
    {
        return 'https://github.com/danielsundermeier/blog/edit/main/' . $this->filename;
    }
}

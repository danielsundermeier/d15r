<?php

namespace App\Models\Posts;

use App\Support\Markdown;
use Carbon\Carbon;
use D15r\ModelPath\Traits\HasModelPath;
use D15r\Traits\HasPath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory,
        HasModelPath;

    const ROUTE_NAME = 'posts';

    const WORDS_PER_MINUTE = 200;

    protected $appends = [
        //
    ];

    protected $casts = [
        //
    ];

    protected $dates = [
        'published_at',
    ];

    protected $fillable = [
        'filename',
        'markdown_body',
        'published_at',
        'slug',
        'title',
    ];

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
        $content = Storage::get($path);
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

    public function getBodyAttribute(): string
    {
        if (is_null($this->markdown_body)) {
            return '';
        }

        return Markdown::convertToHtml($this->markdown_body);
    }

    public function getMarkdownContentAttribute(): string
    {
        return trim(substr($this->markdown_body, strpos($this->markdown_body, "\n") + 1));
    }

    public function getContentAttribute(): string
    {
        if (is_null($this->markdown_body)) {
            return '';
        }

        return Markdown::convertToHtml($this->markdown_content);
    }

    public function getMarkdownExcerptAttribute()
    {
        $body = trim(substr($this->markdown_body, strpos($this->markdown_body, "\n") + 1));

        $needle = "\n\n";
        $pos1 = strpos($body, $needle);
        $pos2 = strpos($body, $needle, $pos1 + strlen($needle));

        return trim(substr($body, 0, $pos2)) . '...';
    }

    public function getExcerptAttribute()
    {
        if (empty($this->markdown_excerpt)) {
            return '';
        }

        return Markdown::convertToHtml($this->markdown_excerpt);
    }

    public function getGithubEditUrlAttribute(): string
    {
        return 'https://github.com/danielsundermeier/blog/edit/main/' . $this->filename;
    }

    public function getWordCountAttribute(): int
    {
        return str_word_count($this->markdown_body);
    }

    public function getReadingTimeAttribute(): int
    {
        return ceil($this->word_count / self::WORDS_PER_MINUTE);
    }
}
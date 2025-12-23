<?php

namespace App\Models\Guides;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use D15r\ModelPath\Traits\HasModelPath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory,
        HasModelPath;

    const ROUTE_NAME = 'guides';

    const FILES = [
        'theorie' => 'Theorie',
        'spickzettel' => 'Spickzettel',
        'umsetzung' => 'Meine Umsetzung',
        'integration' => 'Integration',
        'handbuch' => 'Handbuch',
    ];

    protected $appends = [
        //
    ];

    protected $casts = [
        //
    ];

    protected $fillable = [
        'directory',
        'slug',
        'sort',
        'category_slug',
        'notes_url',
        'title',
        'has_spickzettel',
        'has_integration',
        'has_umsetzung',
        'has_handbuch',
    ];

    public static function updateOrCreateFromDirectory(string $directory): self
    {
        $attributes = self::attributesFromDirectory($directory);
        $guide = self::where('directory', $attributes['directory'])->first();

        if (is_null($guide)) {
            $guide = self::createFromDirectory($attributes);
        }
        else {
            $guide->updateFromDirectory($attributes);
        }

        return $guide;
    }

    public static function attributesFromDirectory(string $directory): array
    {
        $slug = basename($directory);
        $directories = array_reverse(explode('/', $directory));
        $category_slug = $directories[1];

        $attributes = [
            'directory' => $directory,
            'categorie_slug' => $category_slug,
            'title' => Str::headline($slug),
            'slug' => $slug,
        ];

        $files = Storage::files($directory);
        foreach ($files as $file) {
            $attributes['has_' . basename($file, '.md')] = true;
        }

        return $attributes;

    }

    public static function createFromDirectory(array $attributes): self
    {
        $slug_count = self::where('slug', $attributes['slug'])->count();
        if ($slug_count > 0) {
            $attributes['slug'] .= '-' . $slug_count;
        }

        return self::create($attributes);
    }

    public function updateFromDirectory(array $attributes): self
    {
        $this->update([
            'has_theorie' => Arr::get($attributes, 'has_theorie', false),
            'has_spickzettel' => Arr::get($attributes, 'has_spickzettel', false),
            'has_integration' => Arr::get($attributes, 'has_integration', false),
            'has_umsetzung' => Arr::get($attributes, 'has_umsetzung', false),
            'has_handbuch' => Arr::get($attributes, 'has_handbuch', false),
        ]);

        return $this;
    }

    public function isDeletable() : bool
    {
        return true;
    }

    public function getAvailableFilesAttribute(): array
    {
        $available_files = [];
        foreach (self::FILES as $key => $value) {
            if ($this->{'has_' . $key}) {
                $available_files[$key] = $value;
            }
        }

        return $available_files;
    }

    protected function getAvailablePaths() : array
    {
        return [
            'index_path',
            'path',
        ];
    }

    public function getGithubEditUrlAttribute(): string
    {
        return 'https://github.com/danielsundermeier/blog/edit/main/' . str_replace('blog/', '', $this->directory);
    }

    public function getNotesUrlAttribute(): string
    {
        return 'https://notes.d15r.de/leben/' . str_replace('blog/guides/', '', $this->directory);
    }


}

<?php

namespace App\Traits;

use App\Support\Markdown;
use Illuminate\Support\Str;

trait HasMarkdown
{
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

    public function getWordCountAttribute(): int
    {
        return str_word_count($this->markdown_body);
    }

    public function getReadingTimeAttribute(): int
    {
        return ceil($this->word_count / self::WORDS_PER_MINUTE);
    }
}

?>
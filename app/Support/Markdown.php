<?php

namespace App\Support;

use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;

class Markdown
{
    public static function convertToHtml(string $text) : string
    {
        $config = [
            'allow_unsafe_links' => false,
        ];

        $environment = new Environment($config);

        $environment->addExtension(new CommonMarkCoreExtension());

        $environment->addExtension(new AutolinkExtension());
        $environment->addExtension(new DisallowedRawHtmlExtension());
        $environment->addExtension(new StrikethroughExtension());
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new TaskListExtension());

        // Version > 1.4 needed
        $environment->addExtension(new MentionExtension());
        $environment->addExtension(new FootnoteExtension());

        $converter = new MarkdownConverter($environment);

        return $converter->convert($text);
    }
}
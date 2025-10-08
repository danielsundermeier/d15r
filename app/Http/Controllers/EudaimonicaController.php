<?php

namespace App\Http\Controllers;

use App\Support\Markdown;

class EudaimonicaController extends MarkdownController
{
    protected $markdown_path = 'markdown/eudaimonica/eudaimonica.md';

    public function show(string $section)
    {
        $markdown_path = 'markdown/eudaimonica/' . $section . '.md';

        abort_if(!file_exists(resource_path($markdown_path)), 404);

        $markdown = file_get_contents(resource_path($markdown_path));
        $first_line = preg_split('#\r?\n#', $markdown, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));
        $markdown_without_title = trim(substr($markdown, strpos($markdown, "\n") + 1));

        return view('markdown.index')
            ->with('title', $title)
            ->with('content', Markdown::convertToHtml($markdown_without_title));
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Markdown;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $markdown = file_get_contents(resource_path('markdown/welcome/about.md'));
        $first_line = preg_split('#\r?\n#', $markdown, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));
        $markdown_without_title = trim(substr($markdown, strpos($markdown, "\n") + 1));

        return view('about')
            ->with('title', $title)
            ->with('content', Markdown::convertToHtml($markdown_without_title));

        return view('about');
    }
}

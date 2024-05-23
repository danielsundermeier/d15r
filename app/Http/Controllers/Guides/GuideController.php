<?php

namespace App\Http\Controllers\Guides;

use App\Support\Markdown;
use App\Models\Guides\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $guides = Guide::orderBy('title', 'ASC')->get();

        return view('guides.index')
            ->with('guides', $guides);
    }

    public function show(Request $request, Guide $guide, string $file = 'spickzettel')
    {
        $markdown_body = Storage::get($guide->directory . '/' . $file . '.md');
        $markdown_content = trim(substr($markdown_body, strpos($markdown_body, "\n") + 1));
        $content = Markdown::convertToHtml($markdown_content);

        return view('guides.show')
            ->with('guide', $guide)
            ->with('file', $file)
            ->with('content', $content);
    }
}

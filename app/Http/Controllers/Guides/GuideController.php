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
        $guides = Guide::orderBy('category_slug', 'ASC')->orderBy('sort', 'ASC')->get()->keyBy('category_slug');

        $categories = [
            'antifragiles_selbstvertrauen' => 'Antifragiles Selbstvertrauen',
            'fundament' => 'Fundament',
        ];

        $filled_categories = array_filter($categories, function ($category) use ($guides) {
            return $guides->has($category);
        }, ARRAY_FILTER_USE_KEY);

        return view('guides.index')
            ->with('guides', $guides)
            ->with('categories', $filled_categories);
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

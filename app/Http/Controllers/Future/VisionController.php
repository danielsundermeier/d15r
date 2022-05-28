<?php

namespace App\Http\Controllers\Future;

use App\Support\Markdown;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class VisionController extends Controller
{
    public function show(string $markdownfilename = 'vision')
    {
        $path = storage_path('app/blog/future/vision/' . $markdownfilename . '.md');

        if (! file_exists($path)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $order = [
            'vision' => 'Vision',
            'heute' => 'Heute',
            'post-poverty' => 'Post Poverty',
            'post-scarcity' => 'Post Scarcity',
            'orbit' => 'Orbit',
            'mond' => 'Mond',
            'inneres-sonnensystem' => 'Inneres Sonnensystem',
            'aeußeres-sonnensystem' => 'Äußeres Sonnensystem',
        ];

        $order_keys = array_keys($order);
        $current_key = array_search($markdownfilename, $order_keys);

        if ($current_key !== false) {
            // Previous
            if ($current_key > 0) {
                $previous = [
                    'title' => $order[$order_keys[$current_key - 1]],
                    'url' => route('future.vision.show', $order_keys[$current_key - 1]),
                ];
            }

            // Next
            if ($current_key <= count($order_keys) - 2) {
                $next = [
                    'title' => $order[$order_keys[$current_key + 1]],
                    'url' => route('future.vision.show', $order_keys[$current_key + 1]),
                ];
            }
        }

        $content = file_get_contents($path);
        $pos_first_new_line = (strpos($content, "\n"));
        $title = trim(substr($content, 2, $pos_first_new_line));
        $markdown_content = trim(substr($content, $pos_first_new_line + 1));

        return view('future.vision.show')
            ->with('title', $title)
            ->with('content', Markdown::convertToHtml($markdown_content))
            ->with('previous', $previous ?? null)
            ->with('next', $next ?? null)
            ->with('github_edit_url', 'https://github.com/danielsundermeier/blog/edit/main/future/vision/' . $markdownfilename . '.md');
    }
}

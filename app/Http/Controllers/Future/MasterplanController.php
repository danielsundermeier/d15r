<?php

namespace App\Http\Controllers\Future;

use App\Support\Markdown;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class MasterplanController extends Controller
{
    public function show(string $markdownfilename = 'masterplan')
    {
        $path = storage_path('app/blog/future/masterplan/' . $markdownfilename . '.md');

        if (! file_exists($path)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $order = [
            'masterplan' => 'Masterplan',
            'start' => 'Start',
            'energie' => 'Energie',
            'forschung' => 'Forschung',
            'freizeit' => 'Freizeit',
            'gesundheit' => 'Gesundheit',
            'nahrung' => 'Nahrung',
            'wirtschaft' => 'Wirtschaft',
            'wohnen' => 'Wohnen',
        ];

        $order_keys = array_keys($order);
        $current_key = array_search($markdownfilename, $order_keys);

        if ($current_key !== false) {
            // Previous
            if ($current_key > 0) {
                $previous = [
                    'title' => $order[$order_keys[$current_key - 1]],
                    'url' => route('future.masterplan.show', $order_keys[$current_key - 1]),
                ];
            }

            // Next
            if ($current_key <= count($order_keys) - 2) {
                $next = [
                    'title' => $order[$order_keys[$current_key + 1]],
                    'url' => route('future.masterplan.show', $order_keys[$current_key + 1]),
                ];
            }
        }

        $content = file_get_contents($path);
        $pos_first_new_line = (strpos($content, "\n"));
        $title = trim(substr($content, 2, $pos_first_new_line));
        $markdown_content = trim(substr($content, $pos_first_new_line + 1));

        return view('future.masterplan.show')
            ->with('title', $title)
            ->with('content', Markdown::convertToHtml($markdown_content))
            ->with('previous', $previous ?? null)
            ->with('next', $next ?? null)
            ->with('github_edit_url', 'https://github.com/danielsundermeier/blog/edit/main/future/masterplan/' . $markdownfilename . '.md');
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Markdown;
use App\Models\Posts\Post;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest('published_at')->limit(5)->get();

        $markdown = file_get_contents(resource_path('markdown/welcome/welcome.md'));
        $first_line = preg_split('#\r?\n#', $markdown, 0)[0];
        $title = trim(str_replace('# ', '', $first_line));
        $markdown_without_title = trim(substr($markdown, strpos($markdown, "\n") + 1));

        return view('welcome')
            ->with('posts', $posts)
            ->with('title', $title)
            ->with('content', Markdown::convertToHtml($markdown_without_title));
    }

    public function show(Post $post)
    {
        $next_post = Post::where('id', '!=', $post->id)
            ->where('published_at', '>=', $post->published_at)
            ->orderBy('published_at', 'ASC')
            ->orderBy('id', 'ASC')
            ->first();

        $previous_post = Post::where('id', '!=', $post->id)
            ->where('published_at', '<=', $post->published_at)
            ->orderBy('published_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        return view('posts.show')
            ->with('post', $post)
            ->with('next_post', $next_post)
            ->with('previous_post', $previous_post);
    }
}

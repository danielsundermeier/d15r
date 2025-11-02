<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Posts\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->get();

        return view('posts.index')
            ->with('posts', $posts)
            ->with('last_year', 0)
            ->with('last_month', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts\Post  $post
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}

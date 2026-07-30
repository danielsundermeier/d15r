@extends('layouts.app')

@section('title', $post->title)
@section('canonical', route('posts.show', ['post' => $post->slug]))
@section('description', $post->description)

@section('content')
    <article class="bg-stone-50 dark:bg-slate-900">
        <header class="border-b border-slate-200 dark:border-slate-800">
            <div class="mx-auto max-w-4xl px-5 py-16 sm:px-8 sm:py-24">
                <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-slate-500 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">← Journal</a>
                <p class="mt-12 text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">Journal</p>
                <h1 class="mt-5 text-4xl font-semibold tracking-[-0.035em] text-slate-900 sm:text-6xl dark:text-white">{{ $post->title }}</h1>
                <div class="mt-7 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-slate-500 dark:text-slate-400">
                    <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('d. F Y') }}</time>
                    <span aria-hidden="true">·</span>
                    <span>{{ $post->reading_time }} Minuten</span>
                    <span aria-hidden="true">·</span>
                    <span>Aktueller Spielstand</span>
                </div>
            </div>
        </header>

        <div class="bg-white dark:bg-slate-900/30">
            <div class="mx-auto max-w-3xl px-5 py-16 sm:px-8 sm:py-24">
                <div id="post" class="prose prose-lg max-w-none prose-slate prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-sky-700 prose-a:no-underline hover:prose-a:underline prose-hr:border-slate-200 dark:prose-invert dark:prose-a:text-sky-400 dark:prose-hr:border-slate-800">
                    {!! $post->content !!}
                </div>

                <div class="mt-16 border-t border-slate-200 pt-8 dark:border-slate-800">
                    <a href="{{ $post->github_edit_url }}" target="_blank" class="text-sm text-slate-400 transition hover:text-slate-700 dark:text-slate-500 dark:hover:text-slate-300">Diesen Text auf GitHub bearbeiten</a>
                </div>
            </div>
        </div>

        <nav class="border-t border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900" aria-label="Weitere Artikel">
            <div class="mx-auto grid max-w-5xl divide-y divide-slate-200 px-5 sm:grid-cols-2 sm:divide-x sm:divide-y-0 sm:px-8 dark:divide-slate-800">
                <div class="py-10 sm:pr-10">
                    @isset($previous_post)
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600">Vorheriger Gedanke</p>
                        <a href="{{ route('posts.show', ['post' => $previous_post->slug]) }}" class="mt-3 block text-lg font-medium text-slate-800 transition hover:text-sky-700 dark:text-slate-200 dark:hover:text-sky-400">← {{ $previous_post->title }}</a>
                    @endisset
                </div>
                <div class="py-10 sm:pl-10 sm:text-right">
                    @isset($next_post)
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600">Nächster Gedanke</p>
                        <a href="{{ route('posts.show', ['post' => $next_post->slug]) }}" class="mt-3 block text-lg font-medium text-slate-800 transition hover:text-sky-700 dark:text-slate-200 dark:hover:text-sky-400">{{ $next_post->title }} →</a>
                    @endisset
                </div>
            </div>
        </nav>
    </article>
@endsection

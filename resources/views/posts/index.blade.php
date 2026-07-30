@extends('layouts.app')

@section('title', 'Journal')
@section('description', 'Aktuelle Erfahrungen, Fragen und Beobachtungen aus dem laufenden Experiment.')

@section('content')
    @php
        $featuredPost = $posts->first();
        $archivePosts = $posts->skip(1);
    @endphp

    <header class="border-b border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 sm:py-28">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-600 dark:text-sky-400">Laufende Beobachtungen</p>
            <h1 class="mt-5 text-5xl font-semibold tracking-[-0.04em] text-slate-900 sm:text-7xl dark:text-white">Journal</h1>
            <p class="mt-7 max-w-2xl text-xl leading-9 text-slate-600 dark:text-slate-300">
                Erfahrungen, Fragen und Gedanken aus dem Versuch, mein Weltmodell nicht nur zu beschreiben, sondern zu leben.
            </p>
        </div>
    </header>

    @if ($featuredPost)
        <section class="bg-white dark:bg-slate-900/30">
            <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
                <article class="grid gap-10 lg:grid-cols-[0.65fr_1.35fr] lg:gap-20">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400">Neu</p>
                        <time class="mt-3 block text-sm text-slate-500 dark:text-slate-400" datetime="{{ $featuredPost->published_at->toDateString() }}">
                            {{ $featuredPost->published_at->translatedFormat('d. F Y') }}
                        </time>
                        <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">{{ $featuredPost->reading_time }} Minuten</p>
                    </div>
                    <div>
                        <h2 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl dark:text-white">
                            <a href="{{ route('posts.show', ['post' => $featuredPost->slug]) }}" class="transition hover:text-sky-700 dark:hover:text-sky-400">{{ $featuredPost->title }}</a>
                        </h2>
                        <div class="mt-6 line-clamp-4 text-lg leading-8 text-slate-600 dark:text-slate-300">{!! $featuredPost->excerpt !!}</div>
                        <a href="{{ route('posts.show', ['post' => $featuredPost->slug]) }}" class="mt-7 inline-flex text-sm font-semibold text-sky-700 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300">Weiterlesen <span class="ml-2">→</span></a>
                    </div>
                </article>
            </div>
        </section>
    @endif

    <section class="border-t border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <div class="grid gap-12 lg:grid-cols-[0.65fr_1.35fr] lg:gap-20">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400 dark:text-slate-500">Archiv</p>
                    <h2 class="mt-4 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">Alle Gedanken</h2>
                </div>
                <div class="divide-y divide-slate-200 border-y border-slate-200 dark:divide-slate-800 dark:border-slate-800">
                    @forelse ($archivePosts as $post)
                        <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="group grid gap-2 py-6 sm:grid-cols-[8rem_1fr_auto] sm:items-center">
                            <time class="text-sm text-slate-400 dark:text-slate-500" datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y') }}</time>
                            <span class="text-lg font-medium text-slate-800 transition group-hover:text-sky-700 dark:text-slate-200 dark:group-hover:text-sky-400">{{ $post->title }}</span>
                            <span class="hidden text-slate-400 transition group-hover:translate-x-1 sm:block" aria-hidden="true">→</span>
                        </a>
                    @empty
                        <p class="py-6 text-slate-500 dark:text-slate-400">Weitere Gedanken folgen.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

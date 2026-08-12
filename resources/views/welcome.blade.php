@extends('layouts.app')

@section('title', 'Wie werde ich besser darin, zu leben?')
@section('description', 'D15r ist ein lebendes Experiment darüber, wie ich besser darin werde, zu leben.')

@section('content')
    @php
        $featuredPost = $posts->first();
        $morePosts = $posts->skip(1);
    @endphp

    <section class="border-b border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 sm:py-28 lg:py-36">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-600 dark:text-amber-400">Philosophie als lebendes Experiment</p>
                <h1 class="mt-6 text-5xl font-semibold tracking-[-0.04em] text-slate-900 sm:text-7xl dark:text-white">{{ $title }}</h1>
                <p class="mt-8 max-w-2xl text-xl leading-9 text-slate-600 dark:text-slate-300">
                    Ich entwickle ein Weltmodell, lebe danach und beobachte, welcher Mensch daraus entsteht.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('why-ai.index') }}" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                        Das Experiment verstehen
                    </a>
                    <a href="{{ route('posts.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-white dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-900">
                        Aktuelle Gedanken lesen
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if ($featuredPost)
        <section class="bg-white dark:bg-slate-900/40">
            <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
                <div class="grid gap-10 lg:grid-cols-[0.75fr_1.25fr] lg:gap-20">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">Aktueller Gedanke</p>
                        <time class="mt-3 block text-sm text-slate-500 dark:text-slate-400" datetime="{{ $featuredPost->published_at->toDateString() }}">
                            {{ $featuredPost->published_at->translatedFormat('d. F Y') }}
                        </time>
                    </div>
                    <article>
                        <h2 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl dark:text-white">
                            <a href="{{ route('posts.show', ['post' => $featuredPost->slug]) }}" class="transition hover:text-sky-700 dark:hover:text-sky-400">
                                {{ $featuredPost->title }}
                            </a>
                        </h2>
                        <div class="mt-6 line-clamp-3 text-lg leading-8 text-slate-600 dark:text-slate-300">
                            {!! $featuredPost->excerpt !!}
                        </div>
                        <a href="{{ route('posts.show', ['post' => $featuredPost->slug]) }}" class="mt-7 inline-flex text-sm font-semibold text-sky-700 transition hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300">
                            Weiterlesen <span class="ml-2" aria-hidden="true">→</span>
                        </a>
                    </article>
                </div>
            </div>
        </section>
    @endif

    <section class="border-y border-slate-200 bg-stone-100/70 dark:border-slate-800 dark:bg-slate-900/30">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <div class="grid gap-12 lg:grid-cols-[0.7fr_1.3fr] lg:gap-20">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400">Die Aufwärtsspirale</p>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">Aus Gedanken wird gelebte Erfahrung.</h2>
                </div>
                <div>
                    <ol class="grid grid-cols-2 gap-x-4 gap-y-7 sm:grid-cols-4">
                        @foreach (['Leben', 'Sprechen', 'Veröffentlichen', 'Lesen', 'Handeln', 'Erfahren', 'Lernen', 'Weiterleben'] as $index => $step)
                            <li class="border-t border-slate-300 pt-3 dark:border-slate-700">
                                <span class="text-xs text-slate-400 dark:text-slate-600">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p class="mt-1 font-medium text-slate-800 dark:text-slate-200">{{ $step }}</p>
                            </li>
                        @endforeach
                    </ol>
                    <p class="mt-8 max-w-2xl text-base leading-7 text-slate-600 dark:text-slate-400">
                        Jede Erfahrung verändert mein Weltmodell. Das veränderte Modell beeinflusst, wie ich weiterlebe. Es ist keine Wiederholung, sondern eine Spirale.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <div class="mb-12 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">Drei Zugänge</p>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">Ein Gedanke, verschiedene Tiefen.</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <a href="{{ route('answer.index') }}" class="group rounded-2xl border border-slate-200 bg-stone-50 p-7 transition hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-sm dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700 dark:hover:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">01</p>
                    <h3 class="mt-8 text-xl font-semibold text-slate-900 group-hover:text-sky-700 dark:text-white dark:group-hover:text-sky-400">Antwort</h3>
                    <p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Meine aktuelle Antwort auf die Frage, wie wir leben sollten.</p>
                </a>
                <a href="{{ route('eudaimonica.index') }}" class="group rounded-2xl border border-slate-200 bg-stone-50 p-7 transition hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-sm dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700 dark:hover:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">02</p>
                    <h3 class="mt-8 text-xl font-semibold text-slate-900 group-hover:text-sky-700 dark:text-white dark:group-hover:text-sky-400">Eudaimonica</h3>
                    <p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Der ausführliche Versuch, das gute Leben als erlernbares Spiel zu beschreiben.</p>
                </a>
                <a href="{{ route('posts.index') }}" class="group rounded-2xl border border-slate-200 bg-stone-50 p-7 transition hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-sm dark:border-slate-800 dark:bg-slate-900/50 dark:hover:border-slate-700 dark:hover:bg-slate-900">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">03</p>
                    <h3 class="mt-8 text-xl font-semibold text-slate-900 group-hover:text-sky-700 dark:text-white dark:group-hover:text-sky-400">Journal</h3>
                    <p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Aktuelle Erfahrungen, Fragen und Beobachtungen aus dem laufenden Experiment.</p>
                </a>
            </div>
        </div>
    </section>

    <section class="border-t border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <div class="grid gap-12 lg:grid-cols-[0.7fr_1.3fr] lg:gap-20">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">Hintergrund</p>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">Was hinter dieser Seite entsteht.</h2>
                </div>
                <div class="prose prose-lg max-w-none prose-slate prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-sky-700 dark:prose-invert dark:prose-a:text-sky-400">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </section>

    @if ($morePosts->isNotEmpty())
        <section class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/30">
            <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
                <div class="flex items-end justify-between gap-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">Journal</p>
                        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">Weitere Gedanken</h2>
                    </div>
                    <a href="{{ route('posts.index') }}" class="hidden text-sm font-semibold text-slate-600 hover:text-slate-900 sm:block dark:text-slate-400 dark:hover:text-white">Alle ansehen →</a>
                </div>

                <div class="mt-10 divide-y divide-slate-200 border-y border-slate-200 dark:divide-slate-800 dark:border-slate-800">
                    @foreach ($morePosts as $post)
                        <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="group grid gap-2 py-6 sm:grid-cols-[8rem_1fr_auto] sm:items-center">
                            <time class="text-sm text-slate-400 dark:text-slate-500" datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y') }}</time>
                            <span class="text-lg font-medium text-slate-800 transition group-hover:text-sky-700 dark:text-slate-200 dark:group-hover:text-sky-400">{{ $post->title }}</span>
                            <span class="hidden text-slate-400 transition group-hover:translate-x-1 sm:block" aria-hidden="true">→</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

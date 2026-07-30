@extends('layouts.app')

@section('title', $title)

@section('content')
    <article class="bg-stone-50 dark:bg-slate-900">
        <header class="border-b border-slate-200 dark:border-slate-800">
            <div class="mx-auto max-w-4xl px-5 py-16 sm:px-8 sm:py-24">
                @if (request()->routeIs('why-ai.index'))
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400">Experiment läuft · Entwicklung offen</p>
                @else
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">D15r</p>
                @endif
                <h1 class="mt-5 text-4xl font-semibold tracking-[-0.035em] text-slate-900 sm:text-6xl dark:text-white">{{ $title }}</h1>
            </div>
        </header>

        <div class="bg-white dark:bg-slate-900/30">
            <div class="mx-auto max-w-3xl px-5 py-16 sm:px-8 sm:py-24">
                <div id="post" class="prose prose-lg max-w-none prose-slate prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-sky-700 prose-a:no-underline hover:prose-a:underline prose-hr:border-slate-200 dark:prose-invert dark:prose-a:text-sky-400 dark:prose-hr:border-slate-800">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </article>
@endsection

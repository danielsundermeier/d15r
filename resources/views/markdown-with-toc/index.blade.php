@extends('layouts.app')

@section('title')
{{ $title }}
@endsection

@section('content')

    <div class="relative mx-auto flex w-full max-w-8xl flex-auto justify-center px-2 sm:px-2 lg:px-8 xl:px-12">

        <div class="max-w-2xl min-w-0 flex-auto px-4 py-16 lg:max-w-none lg:pr-0 lg:pl-8 xl:px-16">

            <article>

                <header class="mb-9 space-y-1">
                    {{-- <p class="font-display text-sm font-medium text-sky-500">Test</p> --}}
                    <h1 class="font-display text-3xl tracking-tight text-slate-900 dark:text-white">{{ $title }}</h1>
                </header>

                <div id="book" class="prose max-w-none prose-slate dark:text-slate-400 dark:prose-invert prose-headings:scroll-mt-28 prose-headings:font-display prose-headings:font-normal lg:prose-headings:scroll-mt-34 prose-lead:text-slate-500 dark:prose-lead:text-slate-400 prose-a:font-semibold dark:prose-a:text-sky-400 dark:[--tw-prose-background:var(--color-slate-900)] prose-a:no-underline prose-a:shadow-[inset_0_-2px_0_0_var(--tw-prose-background,#fff),inset_0_calc(-1*(var(--tw-prose-underline-size,4px)+2px))_0_0_var(--tw-prose-underline,var(--color-sky-300))] prose-a:hover:[--tw-prose-underline-size:6px] dark:prose-a:shadow-[inset_0_calc(-1*var(--tw-prose-underline-size,2px))_0_0_var(--tw-prose-underline,var(--color-sky-800))] dark:prose-a:hover:[--tw-prose-underline-size:6px] prose-pre:rounded-xl prose-pre:bg-slate-900 prose-pre:shadow-lg dark:prose-pre:bg-slate-800/60 dark:prose-pre:shadow-none dark:prose-pre:ring-1 dark:prose-pre:ring-slate-300/10 dark:prose-hr:border-slate-800">
                    {!! $content !!}
                </div>

            </article>

        </div>

        <div class="hidden xl:sticky xl:top-19 xl:-mr-6 xl:block xl:flex-none xl:overflow-y-auto xl:py-16 xl:pr-6">

            <nav class="w-48">
                <h2 id="on-this-page-title" class="font-display text-sm font-medium text-slate-900 dark:text-white">Inhalt</h2>
                {!! $toc ?? '' !!}
            </nav>

        </div>

    </div>

@endsection

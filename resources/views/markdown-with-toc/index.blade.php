@extends('layouts.app')

@section('title', $title)

@section('content')
    <header class="border-b border-slate-200 bg-stone-50 dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 sm:py-24">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-400">
                {{ request()->routeIs('answer.*') ? 'Meine aktuelle Antwort' : 'Das Spiel des guten Lebens' }}
            </p>
            <h1 class="mt-5 max-w-4xl text-4xl font-semibold tracking-[-0.035em] text-slate-900 sm:text-6xl dark:text-white">{{ $title }}</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                Ein lebendes Dokument. Kein endgültiges Regelwerk, sondern der beste aktuelle Stand meines Verständnisses.
            </p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900/30">
        <div class="relative mx-auto flex max-w-7xl px-5 sm:px-8">
            <article class="min-w-0 flex-1 py-16 lg:pr-16 lg:py-24">
                <div id="book" class="prose prose-lg max-w-3xl prose-slate prose-headings:scroll-mt-28 prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-sky-700 prose-a:no-underline hover:prose-a:underline prose-hr:border-slate-200 dark:prose-invert dark:prose-a:text-sky-400 dark:prose-hr:border-slate-800">
                    {!! $content !!}
                </div>
            </article>

            <aside class="hidden w-64 flex-none border-l border-slate-200 py-24 pl-10 xl:block dark:border-slate-800">
                <nav class="sticky top-24 max-h-[calc(100vh-8rem)] overflow-y-auto" aria-labelledby="on-this-page-title">
                    <h2 id="on-this-page-title" class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-900 dark:text-white">Inhalt</h2>
                    {!! $toc ?? '' !!}
                </nav>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = Array.from(document.querySelectorAll('.table-of-contents a[href^="#"]'))
            const sections = links
                .map(link => document.querySelector(link.getAttribute('href')))
                .filter(Boolean)

            if (! links.length || ! sections.length) return

            const updateActiveLink = () => {
                let activeIndex = 0

                sections.forEach((section, index) => {
                    if (section.getBoundingClientRect().top <= 140) activeIndex = index
                })

                links.forEach((link, index) => {
                    link.classList.toggle('!text-sky-600', index === activeIndex)
                    link.classList.toggle('dark:!text-sky-400', index === activeIndex)
                })
            }

            window.addEventListener('scroll', updateActiveLink, { passive: true })
            updateActiveLink()
        })
    </script>
@endsection

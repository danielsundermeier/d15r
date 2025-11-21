@extends('layouts.app')

@section('title', $post->title)
@section('canonical', route('posts.show', ['post' => $post->slug]))
@section('description', $post->description)

@section('content')

<div class="max-w-8xl mx-auto"><div class="flex px-4 pt-8 pb-10 lg:px-8"><a class="group flex font-semibold text-sm leading-6 text-slate-700 hover:text-slate-900" href="{{ route('posts.index') }}"><svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-slate-400 w-auto h-6 group-hover:text-slate-600"><path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>Übersicht</a></div></div>

<div id="post" class="pb-16 bg-white overflow-hidden">
    <div class="relative px-4 sm:px-6 lg:px-8">
        <div class="text-lg py-16 max-w-prose mx-auto text-center">
            <h1>
                <span class="mt-2 block text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $post->title }}</span>
            </h1>
            <div class="text-sm leading-6">{{ $post->published_at->format('d.m.Y') }} - {{ $post->reading_time }} min</div>
        </div>
        <div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">

            {!! $post->content !!}

            <div class="flex text-sm mb-4">
                <a class="group flex items-center leading-6" href="{{ $post->github_edit_url }}" target="_blank">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-1">Edit on Github</div>
                </a>
            </div>

            <nav class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0">
                @isset($previous_post)
                    <div class="-mt-px w-0 flex-1 flex">
                        <a href="{{ route('posts.show', ['post' => $previous_post->slug]) }}" class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            <!-- Heroicon name: solid/arrow-narrow-left -->
                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ $previous_post->title }}
                        </a>
                    </div>
                @endisset
                @isset($next_post)
                    <div class="-mt-px w-0 flex-1 flex justify-end">
                        <a href="{{ route('posts.show', ['post' => $next_post->slug]) }}" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            {{ $next_post->title }}
                            <!-- Heroicon name: solid/arrow-narrow-right -->
                            <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endisset
            </nav>

        </div>
    </div>

</div>

@endsection
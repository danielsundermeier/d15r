@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('canonical', route('posts.show', ['post' => $post->slug]))

@section('content')

    <div id="post" class="relative py-16 bg-white overflow-hidden">
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

                <a href="{{ route('posts.index')}}">Übersicht</a>

                {!! $post->body !!}

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
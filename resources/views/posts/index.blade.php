@extends('layouts.app')

@section('title', 'Blog')

@section('content')

    <div class="py-8 bg-white">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto text-center">
                <h1>
                    <span class="mt-2 block text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Blog</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto pb-8 px-4 sm:px-6 lg:py-24 lg:px-8">

            @foreach ($posts as $post)

                @if ($last_year != $post->published_at->year)
                    <?php $last_year = $post->published_at->year; ?>
                    <h2 class="text-2xl font-bold mb-3">{{ $post->published_at->year }}</h2>
                @endif

                @if ($last_month != $post->published_at->month)
                    <?php $last_month = $post->published_at->month; ?>
                    <h3 class="text-xl font-bold my-3">{{ $post->published_at->monthName }}</h2>
                @endif

                <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="block underline hover:text-indigo-600">{{ $post->published_at->format('d.m.Y') }} {{ $post->title }}</a>

            @endforeach

        </div
    </div>

@endsection
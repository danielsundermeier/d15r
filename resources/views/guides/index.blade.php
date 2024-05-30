@extends('layouts.app')

@section('title', 'Guides')

@section('content')

    <div class="py-8 bg-white">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto text-center">
                <h1>
                    <span class="mt-2 block text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Guides</span>
                </h1>
            </div>
        </div>
    </div>

    @foreach ($categories as $category_slug => $category_name)
        <div class="bg-white">
            <div class="max-w-7xl mx-auto pb-8 px-4 sm:px-6 lg:py-24 lg:px-8">
                <h3 class="text-xl mb-6 font-bold tracking-tight text-gray-900 sm:text-2xl">{{ $category_name }}</h3>
                <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($guides[$category_slug] as $guide)
                        <li class="relative">
                            <a href="{{ route('guides.show', ['guide' => $guide->slug]) }}" class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-sky-500 overflow-hidden">
                                <button type="button" class="absolute inset-0 focus:outline-none">
                                    <div class="">{{ $guide->title }}</div>
                                </button>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach

@endsection

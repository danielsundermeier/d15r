@extends('layouts.app')

@section('content')

<div class="pt-16 pb-8 bg-white">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="text-lg max-w-prose mx-auto text-center">
            <h1>
                <span class="mt-2 block text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $title }}</span>
            </h1>
        </div>
    </div>
</div>

<div id="post" class="relative py-4 bg-white overflow-hidden">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">

            {!! $content !!}

        </div>
    </div>
</div>

@endsection

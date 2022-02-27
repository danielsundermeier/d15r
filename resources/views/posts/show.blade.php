@extends('layouts.app')

@section('content')

    <div id="post" class="relative py-16 bg-white overflow-hidden">
        <div class="relative px-4 sm:px-6 lg:px-8">
            <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">

                <a href="{{ route('posts.index')}}">Übersicht</a>

                {!! $post->body !!}
            </div>
        </div>
    </div>

@endsection
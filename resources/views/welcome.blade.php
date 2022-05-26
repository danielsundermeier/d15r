@extends('layouts.app')

@section('content')

<div id="post" class="relative pb-16 bg-white overflow-hidden">
	<div class="relative px-4 sm:px-6 lg:px-8">
		<div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
    		@foreach ($posts as $post)

				<a class="text-4xl font-weight-bold" href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
				<div class="text-base">{{ $post->published_at->format('d.m.Y') }}</div>

				{!! $post->excerpt !!}

				<div class="">
					<a href="{{ route('posts.show', ['post' => $post->slug]) }}">weiterlesen</a>
				</div>

				<hr class="my-6 border-b-2 border-gray-200">

			@endforeach
			<div class="text-center">
				<a href="{{ route('posts.index')}}">Alle Beiträge</a>
			</div>
		</div>
	</div>
</div>


@endsection
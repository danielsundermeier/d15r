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

<div id="post" class="relative py-16 bg-white overflow-hidden">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">

            {!! $content !!}

        </div>
    </div>
</div>

<div id="post" class="relative py-16 bg-white overflow-hidden">
	<div class="relative px-4 sm:px-6 lg:px-8">
		<div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">
			@foreach ($posts as $post)
				<article class="relative group">
					<div class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl group-hover:bg-slate-50/70"></div>
					<svg viewBox="0 0 9 9" class="hidden absolute right-full mr-6 top-2 text-slate-200 md:mr-12 w-[calc(0.5rem+1px)] h-[calc(0.5rem+1px)] overflow-visible sm:block"><circle cx="4.5" cy="4.5" r="4.5" stroke="currentColor" class="fill-white" stroke-width="2"></circle></svg>
					<div class="relative">
						<h3 class="text-base font-bold tracking-tight text-slate-900 pt-8 lg:pt-0">{{ $post->title }}</h3>
						<div class="mt-2 mb-4 prose prose-slate prose-a:relative prose-a:z-10 line-clamp-2">
							{!! $post->excerpt !!}
						</div>
						<dl class="absolute left-0 top-0 lg:left-auto lg:right-full lg:mr-[calc(6.5rem+1px)]">
							<dt class="sr-only">Datum</dt>
							<dd class="whitespace-nowrap text-sm leading-6">
								<time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d.m.Y') }}</time>
							</dd>
						</dl>
					</div>
					<a class="flex items-center text-sm text-sky-500 font-medium" href="{{ route('posts.show', ['post' => $post->slug]) }}"><span class="absolute -inset-y-2.5 -inset-x-4 md:-inset-y-4 md:-inset-x-6 sm:rounded-2xl"></span><span class="relative">weiterlesen<span class="sr-only"></span></span><svg class="relative mt-px overflow-visible ml-2.5 text-sky-300" width="3" height="6" viewBox="0 0 3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M0 0L3 3L0 6"></path></svg></a>
				</article>
			@endforeach

			<div class="mt-8 text-center">
				<a class="text-sky-500" href="{{ route('posts.index')}}">Alle Beiträge</a>
			</div>
		</div>
	</div>
</div>


@endsection

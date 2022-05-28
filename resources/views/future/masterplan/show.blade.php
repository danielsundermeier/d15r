@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')

<div class="max-w-8xl mx-auto"><div class="flex px-4 pt-8 pb-10 lg:px-8"><a class="group flex font-semibold text-sm leading-6 text-slate-700 hover:text-slate-900" href="{{ route('future.masterplan.show') }}"><svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-slate-400 w-auto h-6 group-hover:text-slate-600"><path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>Übersicht</a></div></div>

<div id="post" class="pb-16 bg-white overflow-hidden">
    <div class="relative px-4 sm:px-6 lg:px-8">
        <div class="text-lg py-16 max-w-prose mx-auto text-center">
            <h1>
                <span class="mt-2 block text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $title }}</span>
            </h1>
        </div>
        <div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">

            {!! $content !!}

            <nav class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0">
                @isset($previous)
                    <div class="-mt-px w-0 flex-1 flex">
                        <a href="{{ $previous['url'] }}" class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            <!-- Heroicon name: solid/arrow-narrow-left -->
                            <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ $previous['title'] }}
                        </a>
                    </div>
                @endisset
                @isset($next)
                    <div class="-mt-px w-0 flex-1 flex justify-end">
                        <a href="{{ $next['url'] }}" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            {{ $next['title'] }}
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
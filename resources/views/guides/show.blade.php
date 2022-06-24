@extends('layouts.app')

@section('title', 'Guides > ' . $guide->title)

@section('content')

<div id="post" class="pb-16 bg-white overflow-hidden">
    <div class="relative px-4 sm:px-6 lg:px-8">
        <div class="text-lg py-16 max-w-prose mx-auto text-center">
            <h1>
                <span class="mt-2 block text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $guide->title }}</span>
            </h1>
        </div>

        <div class="flex justify-center">
            <div class="sm:hidden">
                <select id="tabs" name="tabs" class="block w-full focus:ring-sky-500 focus:border-sky-500 border-gray-300 rounded-md" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    @foreach ($guide->available_files as $slug => $name)
                        <option value="{{ route('guides.show', ['guide' => $guide, 'file' => $slug]) }}" @if($slug == $file) selected="selected" @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="hidden sm:block">
                <nav class="flex space-x-4" aria-label="Tabs">
                    @foreach ($guide->available_files as $slug => $name)
                        <a href="{{ route('guides.show', ['guide' => $guide, 'file' => $slug]) }}" class="@if($slug == $file) bg-sky-100 text-sky-700 @else text-gray-500 hover:text-gray-700 @endif px-3 py-2 font-medium text-sm rounded-md">{{ $name }}</a>
                    @endforeach

                    <a target="_blank" href="{{ $guide->notes_url }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">Notizen</a>
                </nav>
            </div>
        </div>

        <div class="mt-6 prose prose-sky prose-lg text-gray-500 mx-auto">

            {!! $content !!}

            <div class="flex text-sm mb-4">
                <a class="group flex items-center leading-6" href="{{ $guide->github_edit_url . '/' . $file . '.md' }}" target="_blank">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                    </svg>
                    <div class="ml-1">Edit on Github</div>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
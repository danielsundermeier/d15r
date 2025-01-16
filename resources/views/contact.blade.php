@extends('layouts.app')

@section('title', 'Kontakt')

@section('content')

    <div class="pt-16 pb-8 bg-white">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="text-lg max-w-prose mx-auto text-center">
                <h1>
                    <span class="mt-2 block text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Kontakt</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto pb-8 px-4 sm:px-6 lg:py-24 lg:px-8">
        <form action="{{ route('contact.store')}}" method="POST" class="grid grid-cols-1 gap-y-6" id="contact_form">
            @csrf

            <div>
                <label for="name" class="sr-only">Name</label>
                <input type="text" name="name" id="name" autocomplete="name" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-sky-500 focus:border-sky-500 border-gray-300 rounded-md" placeholder="Name">
                @error('name')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="mail" class="sr-only">E-Mail</label>
                <input id="mail" name="mail" type="email" autocomplete="email" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-sky-500 focus:border-sky-500 border-gray-300 rounded-md" placeholder="E-Mail">
                @error('mail')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="message" class="sr-only">Nachricht</label>
                <textarea id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-sky-500 focus:border-sky-500 border-gray-300 rounded-md" placeholder="Nachricht"></textarea>
                @error('message')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button class="g-recaptcha inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                    data-sitekey="6Lc39ZQUAAAAAIFyGNka3wZ_ALnNsUOze4PBiDwA"
                    data-callback='onSubmit'
                    data-action='submit'
                >
                    Abschicken
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js"></script>

<script>
   function onSubmit(token) {
     document.getElementById('contact_form').submit();
   }
 </script>

@endsection

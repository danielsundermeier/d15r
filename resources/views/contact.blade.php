@extends('layouts.app')

@section('title', 'Kontakt')

@section('content')
    <section class="bg-stone-50 dark:bg-slate-900">
        <div class="mx-auto grid max-w-7xl gap-14 px-5 py-20 sm:px-8 sm:py-28 lg:grid-cols-[0.8fr_1.2fr] lg:gap-24">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400">Zusammen denken</p>
                <h1 class="mt-5 text-5xl font-semibold tracking-[-0.04em] text-slate-900 sm:text-6xl dark:text-white">Kontakt</h1>
                <p class="mt-7 max-w-md text-lg leading-8 text-slate-600 dark:text-slate-300">
                    Wenn dich ähnliche Fragen beschäftigen oder du ein System besser verstehen und gestalten möchtest, freue ich mich auf deine Nachricht.
                </p>
            </div>

            <form action="{{ route('contact.store') }}" method="POST" class="grid gap-6 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 dark:border-slate-800 dark:bg-slate-900" id="contact_form">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                    <input type="text" name="name" id="name" autocomplete="name" value="{{ old('name') }}" class="block w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Wie heißt du?">
                    @error('name')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="mail" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">E-Mail</label>
                    <input id="mail" name="mail" type="email" autocomplete="email" value="{{ old('mail') }}" class="block w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="deine@email.de">
                    @error('mail')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Nachricht</label>
                    <textarea id="message" name="message" rows="6" class="block w-full rounded-xl border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Was beschäftigt dich?">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <button class="inline-flex rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200 dark:focus:ring-offset-slate-900">
                        Nachricht senden
                    </button>
                    @error('g-recaptcha-response')<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                </div>
            </form>
        </div>
    </section>

    <script src="https://www.google.com/recaptcha/enterprise.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        document.getElementById('contact_form').addEventListener('submit', function (event) {
            event.preventDefault()

            grecaptcha.enterprise.ready(async () => {
                const token = await grecaptcha.enterprise.execute(
                    @js(config('services.recaptcha.site_key')),
                    { action: 'submit' },
                )
                const input = document.createElement('input')
                input.type = 'hidden'
                input.name = 'g-recaptcha-response'
                input.value = token
                this.appendChild(input)
                this.submit()
            })
        })
    </script>
@endsection

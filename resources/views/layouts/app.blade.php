<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico">

    <title>@hasSection('title')@yield('title') · @endif D15r</title>
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @endif
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @endif

    <script>
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark')
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link type="text/css" href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="min-h-screen bg-stone-50 font-sans text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-900 dark:text-slate-100"
      x-data="{
          menuOpen: false,
          dark: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.dark = ! this.dark
              document.documentElement.classList.toggle('dark', this.dark)
              localStorage.theme = this.dark ? 'dark' : 'light'
          }
      }"
      @keydown.escape.window="menuOpen = false">

    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-stone-50/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-3" aria-label="D15r Startseite">
                <span class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">D15r</span>
                <span class="hidden text-xs uppercase tracking-[0.22em] text-slate-400 transition group-hover:text-slate-600 sm:inline dark:text-slate-500 dark:group-hover:text-slate-300">lebendes Experiment</span>
            </a>

            <nav class="hidden items-center gap-8 md:flex" aria-label="Hauptnavigation">
                <a href="{{ route('philosophy.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Philosophie</a>
                <a href="{{ route('eudaimonica.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Eudaimonica</a>
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Journal</a>
                <a href="{{ route('why-ai.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Experiment</a>
                <a href="{{ route('eudaimonia-architect.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Zusammenarbeit</a>
            </nav>

            <div class="flex items-center gap-2">
                <button type="button"
                        @click="toggleTheme()"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-lg text-slate-500 transition hover:bg-white hover:text-slate-900 hover:shadow-sm dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-white"
                        :aria-label="dark ? 'Hellen Modus aktivieren' : 'Dunklen Modus aktivieren'">
                    <span x-show="! dark" aria-hidden="true">☾</span>
                    <span x-show="dark" x-cloak aria-hidden="true">☀</span>
                </button>

                <button type="button"
                        @click="menuOpen = ! menuOpen"
                        class="inline-flex h-10 items-center justify-center rounded-full px-3 text-sm font-medium text-slate-600 transition hover:bg-white hover:text-slate-900 hover:shadow-sm md:hidden dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-white"
                        :aria-expanded="menuOpen"
                        aria-controls="mobile-navigation">
                    Menü
                </button>
            </div>
        </div>

        <nav id="mobile-navigation"
             x-show="menuOpen"
             x-cloak
             @click.outside="menuOpen = false"
             class="border-t border-slate-200 bg-stone-50 px-5 py-5 md:hidden dark:border-slate-800 dark:bg-slate-900"
             aria-label="Mobile Navigation">
            <div class="mx-auto grid max-w-7xl gap-1">
                <a href="{{ route('philosophy.index') }}" class="rounded-lg px-3 py-3 text-base font-medium hover:bg-white dark:hover:bg-slate-900">Philosophie</a>
                <a href="{{ route('eudaimonica.index') }}" class="rounded-lg px-3 py-3 text-base font-medium hover:bg-white dark:hover:bg-slate-900">Eudaimonica</a>
                <a href="{{ route('posts.index') }}" class="rounded-lg px-3 py-3 text-base font-medium hover:bg-white dark:hover:bg-slate-900">Journal</a>
                <a href="{{ route('why-ai.index') }}" class="rounded-lg px-3 py-3 text-base font-medium hover:bg-white dark:hover:bg-slate-900">Über das Experiment</a>
                <a href="{{ route('eudaimonia-architect.index') }}" class="rounded-lg px-3 py-3 text-base font-medium hover:bg-white dark:hover:bg-slate-900">Zusammenarbeit</a>
            </div>
        </nav>
    </header>

    <main class="min-h-[70vh]">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl px-5 py-12 sm:px-8">
            <div class="grid gap-10 md:grid-cols-[1fr_auto] md:items-end">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400">D15r</p>
                    <p class="mt-4 text-xl font-medium tracking-tight text-slate-900 dark:text-white">Ein lebendes Experiment darüber, wie ich besser darin werde, zu leben.</p>
                </div>

                <nav class="flex flex-wrap gap-x-6 gap-y-3 text-sm text-slate-500 dark:text-slate-400" aria-label="Footer">
                    <a href="{{ route('about.index') }}" class="transition hover:text-slate-900 dark:hover:text-white">Über mich</a>
                    <a href="{{ route('why-ai.index') }}" class="transition hover:text-slate-900 dark:hover:text-white">Warum KI?</a>
                    <a href="{{ route('contact.index') }}" class="transition hover:text-slate-900 dark:hover:text-white">Kontakt</a>
                    <a href="https://notes.d15r.de" class="transition hover:text-slate-900 dark:hover:text-white">Wissen</a>
                    <a href="/impressum" class="transition hover:text-slate-900 dark:hover:text-white">Impressum</a>
                </nav>
            </div>

            <div class="mt-10 border-t border-slate-200 pt-6 text-xs text-slate-400 dark:border-slate-800 dark:text-slate-600">
                <p>Kein fertiges System. Ein aktueller Spielstand.</p>
            </div>
        </div>
    </footer>

    @if (Session::has('status'))
        <div class="fixed bottom-6 right-6 z-50 max-w-sm rounded-2xl bg-white p-5 text-sm text-slate-700 shadow-xl ring-1 ring-slate-900/10 dark:bg-slate-900 dark:text-slate-200 dark:ring-white/10">
            Nachricht verschickt. Vielen Dank, ich melde mich.
        </div>
    @endif
</body>
</html>

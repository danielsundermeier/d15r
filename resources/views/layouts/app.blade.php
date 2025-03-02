<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Favicon -->
	<link rel="icon" href="/favicon.ico">

	<title>D15r @if(View::hasSection('title'))@yield('title')@endif</title>
	@if(View::hasSection('description'))
	<meta name="description" content="@yield('description')" />
	@endif

	@if(View::hasSection('title'))
	<link rel=”canonical” href=”@yield('canonical')” />
	@endif

	<!-- Scripts -->
	<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
	<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

	<!-- Styles -->
	<link type="text/css" href="{{ mix('css/app.css') }}" rel="stylesheet">
	<style>
		[x-cloak] {
			display: none;
		}
	</style>
</head>

<body class="relative" x-data="{'shouldShow': $persist(0), 'isModalOpen': false, 'pageCount': $persist(0)}" x-on:keydown.escape="isModalOpen=false" x-init="$nextTick(() => { pageCount++; isModalOpen=((pageCount % 3 == 0) && (shouldShow == 0 || Date.now() > shouldShow + (1000*60*60*24*30))); if (isModalOpen) { pageCount = 0; shouldShow=Date.now();  } });">

	<div class="bg-gray-50" x-data="{ open: false }">
		<div class="py-4">
			<div class="max-w-7xl mx-auto px-4 sm:px-6">
				<nav class="relative flex items-center justify-end sm:h-10 md:justify-end" aria-label="Global">
					<div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
						<div class="flex items-center justify-between w-full md:w-auto">
							<a href="/">
								<span class="text-3xl font-bold text-sky-600">D15r</span>
							</a>
							<div class="-mr-2 flex items-center md:hidden">
								<button @click="open = true" type="button" class="bg-gray-50 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-sky-500" id="main-menu" aria-haspopup="true">
									<span class="sr-only">Open main menu</span>
									<!-- Heroicon name: menu -->
									<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
									</svg>
								</button>
							</div>
						</div>
					</div>
					<div class="hidden md:flex md:space-x-10">
						<a href="{{ route('automation.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Automatisieren</a>
						<a href="{{ route('flourishing.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Aufblühen</a>
						<a href="{{ route('integration.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Integration</a>
						<a href="{{ route('posts.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Blog</a>
						<a href="{{ route('contact.index') }}" class="font-medium text-gray-500 hover:text-gray-900">Kontakt</a>
					</div>
				</nav>
			</div>

			<div x-show="open" x-cloak @click.away="open = false" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
				<div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5">
					<div class="px-5 pt-4 flex items-center justify-between">
						<div>
							<a href="/">
								<span class="text-3xl font-bold text-sky-600">D15r</span>
							</a>
						</div>
						<div class="-mr-2">
							<button @click="open = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-sky-500">
								<span class="sr-only">Close menu</span>
								<!-- Heroicon name: x -->
								<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
								</svg>
							</button>
						</div>
					</div>
					<div role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
						<div class="px-2 pt-2 pb-3" role="none">
							<a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Home</a>
							<a href="{{ route('automation.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Automatisieren</a>
							<a href="{{ route('flourishing.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Aufblühen</a>
							<a href="{{ route('integration.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Integration</a>
							<a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Blog</a>
							<a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Kontakt</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main class="min-h-screen">
		@yield('content')
	</main>

	<div class="bg-gray-50">
		<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
			<h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
				<span class="block">Was ist dein Traum?</span>
				<span class="block text-sky-600">Wie kann ich helfen?</span>
			</h2>
			<div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
				<div class="inline-flex rounded-md shadow">
					<a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700"> Kontakt </a>
				</div>
			</div>
		</div>
	</div>


	<footer class="bg-gray-800">
		<div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
			<nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">

				<div class="px-5 py-2">
					<a href="https://notes.d15r.de" target="_blank" class="text-base text-gray-300 hover:text-white"> Wissenssammlung </a>
				</div>

				<div class="px-5 py-2">
					<a href="https://github.com/danielsundermeier" target="_blank" class="text-base text-gray-300 hover:text-white"> Github </a>
				</div>

				<div class="px-5 py-2">
					<a href="/impressum" class="text-base text-gray-300 hover:text-white"> Impressum </a>
				</div>
			</nav>
		</div>
	</footer>

	@if (Session::has('status'))
	<div id="notification" class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
		<div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
			<div class="p-4">
				<div class="flex items-start">
					<div class="flex-shrink-0">
						<!-- Heroicon name: check-circle -->
						<svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<div class="ml-3 w-0 flex-1 pt-0.5">
						<p class="text-sm font-medium text-gray-900">
							Nachricht verschickt!
						</p>
						<p class="mt-1 text-sm text-gray-500">
							Vielen Dank, ich melde mich.
						</p>
					</div>
					<div class="ml-4 flex-shrink-0 flex">
						<button onclick="document.getElementById('notification').remove();" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
							<span class="sr-only">Close</span>
							<!-- Heroicon name: x -->
							<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	<div class="relative z-10" role="dialog" aria-modal="true" x-show="isModalOpen" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
		<div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"></div>

		<div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
			<div x-on:click.away="isModalOpen = false" class="mx-auto max-w-4xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

				<div class="relative bg-white">
					<div class="h-56 bg-sky-600 sm:h-72 lg:absolute lg:left-0 lg:h-full lg:w-1/2">
						<img class="w-full h-full object-cover" src="{{ Storage::disk('public')->url('daniel.jpg') }}" alt="Daniel auf einem Sofa">
					</div>
					<div class="relative max-w-7xl mx-auto px-4 py-8 sm:py-12 sm:px-6 lg:py-16">
						<div class="max-w-2xl mx-auto lg:max-w-none lg:mr-0 lg:ml-auto lg:w-1/2 lg:pl-10">
							<h2 class="mt-6 text-3xl font-extrabold text-gray-900 sm:text-4xl">Dem Glück auf die Sprünge helfen</h2>
							<p class="mt-6 text-lg text-gray-500">Hi, ich bin Daniel und würde mich gerne mit dir über deine Weltsicht und Lebensphilosophie unterhalten.</p>
							<p class="mt-6 text-lg text-gray-500">Hast Du Lust auf ein 30-minütiges Gespräch indem wir uns kennenlernen?</p>
							<div class="mt-8 overflow-hidden">
								<a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-sky-600 hover:bg-sky-700"> Kontakt </a>
								<button @click="isModalOpen = false" class="ml-3 inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-400 bg-white hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:border-blue-300 active:bg-gray-50 active:text-gray-400 transition ease-in-out duration-150"> Schließen </button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</body>
</script>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WanWeb | Professional Web Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/svg+xml" href="{{ asset('logowanweb.svg') }}">

</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex space-x-4">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('wellcome') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>
            <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">WAN<span class="text-gray-900 dark:text-white">WEB</span></div>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
             @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-bold text-gray-600 dark:text-gray-300 hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full font-bold hover:bg-indigo-700 transition">Get Started</a>
                @endauth
            @endif
            <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About Us') }}
            </x-nav-link>
            <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-nav-link>
            <x-nav-link :href="route('terms')" :active="request()->routeIs('terms')">
                {{ __('Terms of Service') }}
            </x-nav-link>
        </div>
    </nav>

    <header class="relative py-32 px-6 text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('hero-bg.jpg') }}"
                alt="Background"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900/70 dark:bg-gray-950/80 transition-colors"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                Premium Web Solutions for <span class="text-indigo-400">Your Business.</span>
            </h1>
            <p class="text-lg text-gray-300 mb-10 leading-relaxed max-w-2xl mx-auto">
                From custom portfolio designs to full-scale e-commerce systems. Choose a template or request a custom build today.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#services" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-indigo-900/20 hover:scale-105 hover:bg-indigo-500 transition-all">View Services</a>
                <a href="{{ route('register') }}" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition">Join Now</a>
            </div>
        </div>
    </header>

    <section id="services" class="py-20 bg-white dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Our Services</h2>
                    <p class="text-gray-500">Transparent pricing for every project.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $landingTemplates = \App\Models\Template::latest()->take(6)->get();
                @endphp

                @foreach($landingTemplates as $template)
                <div class="group p-8 rounded-3xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl">
                    <div class="flex justify-between items-start mb-6">
                        <span class="uppercase text-[10px] font-black tracking-widest text-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">
                            {{ $template->type }}
                        </span>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($template->price, 0) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $template->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 line-clamp-3">
                        {{ $template->description }}
                    </p>
                    <a href="{{ route('register') }}" class="w-full block text-center py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-bold group-hover:bg-indigo-600 group-hover:text-white transition">
                        Order Now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="py-12 border-t dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} WANWEB Digital Agency. All rights reserved.
        </div>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WanWeb | Professional Web Services') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="icon" type="image/svg+xml" href="{{ asset('logowanweb.svg') }}">
    </head>
    <body class="font-sans antialiased dark:bg-gray-900">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 mt-20">
            <div class="max-w-7xl mx-auto py-12 px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-2">
                        <x-application-logo class="w-32 h-auto mb-4" />
                        <p class="text-gray-500 text-sm max-w-xs">Building premium digital experiences for modern brands. Trusted by creators worldwide.</p>
                    </div>
                    <div>
                        <h4 class="font-bold dark:text-white mb-4">Quick Links</h4>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li><a href="{{ route('about') }}" class="hover:text-indigo-600 transition">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition">Contact</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-indigo-600 transition">Join Today</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold dark:text-white mb-4">Legal</h4>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li><a href="{{ route('terms') }}" class="hover:text-indigo-600 transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-indigo-600 transition">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t dark:border-gray-800 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} WANWEB Digital Agency. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>

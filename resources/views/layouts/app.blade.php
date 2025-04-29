<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-auto [&::-webkit-scrollbar]:hidden scrollbar-hide">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        @vite(['resources/css/app.css'])

        
    </head>
    <body class="font-sans antialiased">
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="session('error')" />
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
            @if (request()->route() && \Illuminate\Support\Str::startsWith(request()->route()->getName() ?? '', 'admin'))
            @include('layouts.adminnavigation')
            @endif
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            

        </div>
    </body>
</html>

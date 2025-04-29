
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $news->title }}</title>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])

</head>

<body class="bg-white  sm:rounded-xl  mx-auto">
    <nav class=" bg-white shadow-sm text-black p-7  w-full   ">
        <div class="flex justify-between items-center">
        <div class="shrink-0 flex items-center">
                <div class="item">
                    <img src="/favicon.ico" height="28px" width="28px"/>
                </div>
                <div class="item">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="ml-2  text-black text-lg font-bold">{{ env('APP_NAME') }}</span> <!-- Nom de l'application -->
                    </a>
                    </div>
                </div>
            <div>
                @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                    <a href="{{ url('/dashboard') }}" class=" text-black hover:text-gray-400">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class=" text-black hover:text-gray-400">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class=" text-black hover:text-gray-400">Register</a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </nav>
    <div class="py-12 ">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        <div class="flex flex-col items-center justify-center ">
            <div class="bg-white shadow-md rounded-xl w-full p-6">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" width="500">
            <h1 class="text-3xl font-bold text-gray-900">{{ $news->title }}</h1>
                <p class="text-gray-600 text-lg">{!! $news->description !!}</p>
                <div class="flex justify-between items-center mt-4">
                    <div class="flex items-center space-x-2">
                        <i class="ri-user-line text-gray-400"></i>
                        <span class="text-gray-600 text-lg">KantumHost</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="ri-time-line text-gray-400"></i>
                            <span class="text-gray-600 text-lg">{{ $news->created_at }}</span>
                            </div>
                            </div>
                            </div>
                            </div>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    @vite(['resources/css/app.css'])

</head>

<body class="bg-white dark:bg-gray-900  sm:rounded-lg max-w-7xl mx-auto">
    <nav class="dark:bg-gray-800 bg-white shadow-sm dark:text-white text-black p-7 fixed w-full top-0 left-0 z-10">
        <div class="flex justify-between items-center">
            <div class="text-lg font-bold">{{ env('APP_NAME') }}</div>
            <div>
                @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="dark:text-white text-black hover:text-gray-400">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="dark:text-white text-black hover:text-gray-400">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="dark:text-white text-black hover:text-gray-400">Register</a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </nav>

    <div class="flex justify-center mt-6 w-full">
        <div class="dark:text-white text-black mt-16 text-center">
            <h2 class="font-semibold text-3xl">Bienvenue sur <span id="app-name-footer">{{ env('APP_NAME') }}</span></h2>
            <p class="text-lg mt-2">Que souhaitez-vous faire ?</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-4 mt-8">
        <div class="bg-blue-500 p-6 text-white text-center rounded-lg hover:bg-blue-600 transition-all" onclick="window.location.href='{{ route('tickets.index') }}'">
            <i class="ri-mail-line text-3xl mb-3"></i>
            <h3>Nous contacter</h3>
        </div>
        <div class="bg-blue-500 p-6 text-white text-center rounded-lg hover:bg-blue-600 transition-all" onclick="window.location.href='{{ route('client.servers.orders') }}'">
            <i class="ri-server-line text-3xl mb-3"></i>
            <h3>Commander un serveur</h3>
        </div>
        <div class="bg-blue-500 p-6 text-white text-center rounded-lg hover:bg-blue-600 transition-all" onclick="window.location.href='{{ route('client.servers.index') }}'">
            <i class="ri-settings-2-line text-3xl mb-3"></i>
            <h3>Gérer vos serveurs</h3>
        </div>
        <div class="bg-blue-500 p-6 text-white text-center rounded-lg hover:bg-blue-600 transition-all" onclick="window.location.href='{{ $url }}'">
            <i class="ri-dashboard-line text-3xl mb-3"></i>
            <h3>Accéder au panel</h3>
        </div>
    </div>
    <div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Actualités</h1>
    <div class="grid grid-cols-2 gap-4">
        @foreach ($news as $item)
        <div class="bg-white shadow-md p-6 flex items-center rounded-lg">
            <div class="flex-shrink-0 mr-4 rounded-lg">
                @if ($item->image && Storage::exists(public_path($item->image)))
                <img src="{{ asset($item->image) }}" alt="Image" class="w-32 h-auto object-cover">
                @else
                <i class="ri-image-line text-4xl text-gray-400 mt-4"></i>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-semibold">{{ $item->title }}</h2>
                <p class="mt-2">{{ $item->description }}</p>
            </div>
        </div>
        
        @endforeach
    </div>
</div>

</body>

<footer class="absolute bottom-0 left-0 w-full bg-white dark:bg-gray-800 shadow">
    <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <ul class="flex space-x-8">
            <p class="text-gray-700 dark:text-white"> &copy; Copyright {{ now()->year }} <span id="app-name-footer"></span>. All rights reserved.</p>
            <li><a href="{{ route('terms') }}" class="text-gray-800 dark:text-white hover:text-blue-500">Terms and Conditions</a></li>
            <li><a href="{{ route('privacy') }}" class="text-gray-800 dark:text-white hover:text-blue-500">Privacy Policy</a></li>
            <li><a href="{{ route('legal') }}" class="text-gray-800 dark:text-white hover:text-blue-500">Legal Notice</a></li>
        </ul>

    </div>

</footer>



</html>
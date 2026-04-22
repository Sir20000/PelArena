<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-auto [&::-webkit-scrollbar]:hidden scrollbar-hide">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{settings('seo')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/js/app.js'])

    @vite(['resources/css/app.css'])

</head>

<body>
    <nav class="bg-white shadow-sm  text-black p-7 fixed w-full top-0 left-0 z-10">
        <div class="flex justify-between items-center">
            <div class="shrink-0 flex items-center">
                <div class="item">
                    <img src="/favicon.ico" alt='favicon' height="28px" width="28px" />
                </div>
                <div class="item">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="ml-2  bg-gradient-to-r bg-blue-400   bg-clip-text text-transparent text-lg font-bold">{{ env('APP_NAME') }}</span> <!-- Nom de l'application -->
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
    <div class="max-w-7xl   sm:rounded-xl  mx-auto">
        <div class="flex justify-center mt-6 w-full">
            <div class=" bg-gradient-to-r from-blue-400 to-sky-600   bg-clip-text text-transparent mt-16 text-center">
                <h2 class="font-semibold text-3xl mt-4">Welcome to <span id="app-name-footer">{{ env('APP_NAME') }}</span></h2>
                <p class="text-lg mt-2">What would you like to do?</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-4 mt-8 ">
            <div class="hover:translate-y-1 border-2 active:translate-y-1.5 border-blue-100 text-black hover:bg-blue-100 active:bg-blue-200 p-6 shadow-md text-center rounded-xl transition-all delay-100 duration-300" onclick="window.location.href='{{ route('tickets.index') }}'">
                <i class="ri-mail-line text-3xl mb-3"></i>
                <h3>Contact us</h3>
            </div>
            <div class="hover:translate-y-1 border-2 active:translate-y-1.5 border-blue-100 text-black hover:bg-blue-100 active:bg-blue-200 p-6 shadow-md text-center rounded-xl transition-all delay-100 duration-300" onclick="window.location.href='{{ route('client.servers.orders') }}'">
                <i class="ri-server-line text-3xl mb-3"></i>
                <h3>Order a server</h3>
            </div>
            <div class="hover:translate-y-1 border-2 active:translate-y-1.5 border-blue-100 text-black hover:bg-blue-100 active:bg-blue-200 p-6 shadow-md text-center rounded-xl transition-all delay-100 duration-300" onclick="window.location.href='{{ route('client.servers.index') }}'">
                <i class="ri-settings-2-line text-3xl mb-3"></i>
                <h3>Manage your servers</h3>
            </div>
            <div class="hover:translate-y-1 border-2 active:translate-y-1.5 border-blue-100 text-black hover:bg-blue-100 active:bg-blue-200 p-6 shadow-md text-center rounded-xl transition-all delay-100 duration-300" onclick="window.location.href='{{ $url }}'">
                <i class="ri-dashboard-line text-3xl mb-3"></i>
                <h3>Access the panel game</h3>
            </div>
        </div>
    </div>
    @if(!empty($categories))
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Offers</h1>
        <div class="grid xl:grid-cols-4 grid-cols-1 gap-4">
            @foreach($categories as $categorie)

            <div>
                <div class="border-2 flex p-6 shadow-md text-black text-center rounded-xl transition-colors delay-100 flex-col items-center">
                    <img class="mb-2 h-8 w-8" alt="{{ $categorie->name }} IMAGE" src="{{ $categorie->image }}" />
                    <div class="h-24 mb-4">
                        <h2 class="text-lg font-bold mb-2">{{ $categorie->name }}</h2>
                        <p class="text-sm text-black">
                            {!! Str::limit(strip_tags($categorie->description), 110, '...') !!}
                        </p>
                    </div>

                <a href="{{ route('client.servers.orders.categorie',$categorie->name) }}" class="hover:translate-y-1 active:translate-y-1.5 hover:bg-blue-100 active:bg-blue-200 text-black font-bold py-2 px-4 rounded-lg w-full border-2 border-blue-100 transition"><i class="ri-shopping-bag-2-line"></i> Commander</a>
    <p class="text-lg font-bold text-indigo-600">
                À partir de <span class="text-2xl">{{ number_format($categorie->min_price ?? 0, 2, ',', ' ') }}€</span> / mois
            </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="container mx-auto p-6 sm:mb-24 mb-36">
        <h1 class="text-3xl font-bold mb-4">News</h1>
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-4">
            @foreach ($news as $item)
            <div class="hover:translate-y-1 active:translate-y-1.5 border-2 shadow-md p-6 flex items-center rounded-xl hover:bg-blue-100 transition-all " onclick="window.location.href='{{ route('news.show',$item->id)}}'">
                <div class="flex-shrink-0 mr-4 rounded-xl">
                    @if ($item->image && Storage::exists(public_path($item->image)))
                    <img src="{{ asset($item->image) }}" alt="Image" class="w-32 h-auto object-cover">
                    @else
                    <i class="ri-image-line text-4xl text-gray-400 mt-4"></i>
                    @endif
                </div>
               @php
    $description = strip_tags($item->description, '<p><br>'); // tu peux garder certains tags sûrs
    $description = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $description); // supprime les balises script
@endphp

<div class="overflow-hidden text-ellipsis">
    <h2 class="text-2xl font-semibold truncate">{{ $item->title }}</h2>
    <p class="mt-2 break-words">{!! Str::limit($description, 150, '...') !!}</p>
</div>
            </div>

            @endforeach
        </div>
    </div>

</body>

<footer class="fixed bottom-0 left-0 w-full border-2 bg-gray-100 ">
    <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex space-x-8">
            <p class="text-gray-700 "> &copy; Copyright {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.</p>
            <p><a href="{{ route('terms') }}" class="text-black hover:text-blue-500 transition-all">Terms and Conditions</a></p>
            <p><a href="{{ route('privacy') }}" class="text-black hover:text-blue-500 transition-all">Privacy Policy</a></p>
            <p><a href="{{ route('legal') }}" class="text-black hover:text-blue-500 transition-all">Legal Notice</a></p>
        </div>
        <div class="flex items-center space-x-4">
        <!--configurable--->
            <a href="https://uptime.kantumhost.cloud" target="_blank" class="text-gray-800 dark:text-white hover:text-green-500" title="Uptime">
                <i class="ri-time-line text-xl"></i>
            </a>
            <a href="https://discord.gg/RnHeDp3TQ2" target="_blank" class="text-gray-800 dark:text-white hover:text-indigo-500" title="Discord">
                <i class="ri-discord-line text-xl"></i>
            </a>
        </div>
    </div>

</footer>



</html>
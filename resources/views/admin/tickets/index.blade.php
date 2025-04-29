<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">

            {{ __('Tickets') }}


        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl ">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">

                        <div class="item1">
                            <h3 class="font-bold text-lg">Tickets</h3>
                        </div>
                        <div class="item2"> <button onclick="window.location.href='{{ route('tickets.create') }}'"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">
                                Create a ticket</button></div>

                    </div>
                    <div class="space-y-4 mt-6 ">
                        @if (session('success'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded-xl mt-2">
                            <i class="ri-information-line"></i> {{ session('success') }}
                        </div>
                        @endif
                         @if (session('error'))

                        <div class="bg-red-500 text-white px-4 py-2 rounded-xl mt-2">
                            <i class="ri-information-line"></i> {{ session('error') }}
                        </div>
                        
                        @endif

                        @foreach ($tickets as $ticket)

                        <div class="bg-white dark:bg-gray-700 p-4 rounded-xl shadow-md flex relative items-center justify-between">
                            <div class="@if($ticket->status === 'open') bg-green-500  @else bg-red-500 @endif w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                            <div class="flex-1 pl-2">
                                <h3 class="text-lg font-medium dark:text-white text-black">Titre : {{ $ticket->title }}</h3>
                                <p class="dark:text-gray-300 text-gray-600">Description : {{ $ticket->description }}</p>
                                <p class="dark:text-gray-300 text-gray-600">Category : {{ $ticket->category->name }}</p>

                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.show'))

                                <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">
                                    See</a>
                                @endif

                                @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.close'))
                                @if ($ticket->status == 'open')
                                <form action="{{ route('admin.tickets.close', $ticket->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Close</button>
                                </form>
                                @endif

                                @endif
                            </div>


                        </div>
                        @endforeach
                    </div>

                </div>

</x-app-layout>
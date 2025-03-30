<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
            {{ __('Servers') }}

        </h2>
    </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                            <div class="item1">
                                <form action="{{ route('client.servers.index') }}" method="GET" class="">
                                    <div class="input-group px-2 py-2 flex items-center">
                                        <input type="text" name="search" class="dark:bg-gray-700 dark:text-white rounded-lg w-96 h-11" placeholder="Rechercher un serveur" value="{{ request('search') }}">
                                        <button type="submit" class=" bg-gray-400 dark:bg-gray-700 dark:text-white w-10 h-11 rounded-lg ml-2"><i class="ri-search-2-line "></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="item2">


                                <button
                                    onclick="window.location.href='{{ route('client.servers.orders') }}'"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">
                                    Commander un serveur
                                </button>
                            </div>
                        </div>
                        <div class="space-y-4 mt-6">
                            @if (session('success'))
                            <div class="bg-green-500  text-white px-4 py-2 rounded-lg mt-2">
                                <i class="ri-information-line"></i> {{ session('success') }}
                            </div>
                            @endif
                            @if (session('error'))
                            <div class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2">
                                <i class="ri-information-line"></i> {{ session('error') }}
                            </div>
                            @endif

                            @forelse($orders as $order)

                            <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-lg shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                                <div class="@if($order->status === 'pending') bg-yellow-500 @elseif($order->status === 'cancelled') bg-red-500 @else bg-green-500 @endif w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                                <div class="flex-1 pl-2">
                                    <h3 class="text-lg font-medium dark:text-white text-black">Name : {{ $order->server_name }}</h3>
                                    <p class="dark:text-gray-300 text-gray-600">Product : {{ $order->categorie }}</p>
                                    <p class="dark:text-gray-300 text-gray-600">Prix : {{ number_format($order->cost, 2) }}€/Month</p>
                                </div>
                                <div class="flex-2 text-right ">
                                    @if($order->status === 'pending')
                                    <p class="text-gray-300">
                                        Renew : Now

                                    </p>
                                    <a href="{{ route('paypal.pay', $order->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                        Start paying
                                    </a>
                                    @elseif($order->status === 'cancelled')
                                    <p class='text-red-600 '>Cancelled</p>
                                    @else
                                    <p class="text-gray-300">
                                        Renew : {{ $order->renouvelle ? $order->renouvelle->format('d/m/Y') : 'No date available' }}
                                    </p>
                                    <a href="{{ route('client.servers.manage', $order->id) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                        Manage
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-300">
                                    No services found.
                                </td>
                            </tr>
                            @endforelse
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    
    
  
</x-app-layout>
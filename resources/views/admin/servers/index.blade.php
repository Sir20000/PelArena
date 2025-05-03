<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
            {{ __('Servers') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">
                            <form action="{{ route('client.servers.index') }}" method="GET" class="">
                                <div class="input-group px-4 py-2">
                                    <input type="text" name="search" class=" rounded-xl w-96" placeholder="Rechercher un serveur" value="{{ request('search') }}">
                                    <button type="submit" class=" bg-gray-400 w-10 h-10 rounded-xl "><i class="ri-search-2-line "></i></button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="space-y-4 mt-6">


                        @forelse($server as $order)

                        <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-xl shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                            <div class="@if($order->status === 'pending') bg-yellow-500 @elseif($order->status === 'cancelled') bg-red-500 @else bg-green-500 @endif w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                            <div class="flex-1 pl-2">
                                <h3 class="text-lg font-medium dark:text-white text-black">Name : {{ $order->server_name }}</h3>
                                <p class="dark:text-gray-300 text-gray-600">Product : {{ $order->categorie }}</p>
                                <p class="dark:text-gray-300 text-gray-600">Prix : {{ $order->cost }}€/Month</p>
                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.servers.edit'))

                                <a href="{{ route('admin.servers.edit', $order) }}" class="btn btn-warning">Modifier</a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasAccess('admin.servers.destroy'))

                                <form action="{{ route('admin.servers.destroy', $order) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
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
                        {{ $server->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
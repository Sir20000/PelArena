<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard admin') }}<br>

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    <p class="mt-4 text-lg font-semibold">
                        Revenu total pour ce mois : {{ number_format($currentMonthRevenue, 2, ',', ' ') }} €
                    </p>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Revenu par année</h3>
                        <ul>
                            @foreach ($revenuesByYear as $revenue)
                            <li> {{ $revenue->year }} : {{ number_format($revenue->total_revenue, 2, ',', ' ') }} €</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.revenue.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                                <input type="text" name="search" class=" rounded-lg w-96" placeholder="Rechercher un serveur" value="{{ request('search') }}">
                                <button type="submit" class=" bg-gray-400 w-10 h-10 rounded-lg "><i class="ri-search-2-line "></i></button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="flex flex-wrap justify-start">
                
            @foreach ($transaction as $transactiona)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-16 min-h-56 min-w-80 mb-4 mr-11 ml-10">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <div class="mt-2">
                        <h3 class="text-lg font-semibold mb-6">Transaction</h3>
                        <ul>
                            <li>Montant : {{ number_format($transactiona->cost, 2, ',', '
                    ') }} €</li>
                            <li>Client : {{ $transactiona->user->name }}</li>
                            <li>Produit : {{ $transactiona->product }}</li>
                            @if ($transactiona->server_order_id)

                            <li><a href="{{ route('admin.servers.edit' , $transactiona->server_order_id) }}"> Server : {{ $transactiona->server_order_id }}</a></li>
                            @endif
                            <li>realise le : {{ $transactiona->created_at }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $transaction->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
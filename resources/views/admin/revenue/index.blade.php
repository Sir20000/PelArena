<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent">
            {{ __('Dashboard admin') }}
        </h2>
    </x-slot>

    <x-admin.sidebar />

    <div class="py-10">
        <div class="dark:text-white text-black max-w-7xl mx-auto space-y-6 sm:px-6 lg:px-8">

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                    <p class="text-sm text-gray-500">Revenu du mois</p>
                    <p class="text-2xl font-bold mt-2">
                        {{ number_format($currentMonthRevenue, 2, ',', ' ') }} €
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                    <p class="text-sm text-gray-500 mb-3">Revenu par année</p>
                    <ul class="space-y-1 text-sm">
                        @foreach ($revenuesByYear as $revenue)
                            <li class="flex justify-between">
                                <span>{{ $revenue->year }}</span>
                                <span class="font-semibold">
                                    {{ number_format($revenue->total_revenue, 2, ',', ' ') }} €
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- SEARCH --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow">
                <form action="{{ route('admin.revenue.index') }}" method="GET" class="flex items-center gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                        placeholder="Rechercher une transaction..."
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl">
                        <i class="ri-search-2-line "></i>
                    </button>
                </form>
            </div>

            {{-- TRANSACTIONS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($transaction as $transactiona)
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow hover:shadow-lg transition">

                        <h3 class="text-lg font-semibold mb-4">Transaction</h3>

                        <div class="space-y-2 text-sm">
                            <p><span class="text-gray-500">Montant :</span> 
                                <span class="font-semibold">
                                    {{ number_format($transactiona->cost, 2, ',', ' ') }} €
                                </span>
                            </p>

                            <p><span class="text-gray-500">Client :</span> {{ $transactiona->user->name }}</p>

                            <p><span class="text-gray-500">Produit :</span> {{ $transactiona->product }}</p>

                            @if ($transactiona->server_order_id)
                                <p>
                                    <span class="text-gray-500">Serveur :</span>
                                    <a href="{{ route('admin.servers.edit', $transactiona->server_order_id) }}" 
                                       class="text-blue-500 hover:underline">
                                        #{{ $transactiona->server_order_id }}
                                    </a>
                                </p>
                            @endif

                            <p class="text-xs text-gray-400 mt-3">
                                {{ $transactiona->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="pt-4">
                {{ $transaction->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
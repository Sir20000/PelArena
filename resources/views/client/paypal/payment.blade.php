<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Server renewal : {{ $order->server_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg ">
                <div class="p-6 bg-white dark:bg-gray-800 dark:text-white">

                    <!-- Colonne gauche -->


                    <!-- Détails de la facture -->
                    <h1 class="font-semibold text-2xl dark:text-white text-black mb-8">Invoice details</h1>
                    <ul class="space-y-2 grid grid-cols-2 grid-rows-5 items-center">
                        <li class="col-start-1 col-end-1"><i class="ri-server-line"></i><span class="font-semibold"> Name of server :</span> {{ $order->server_name }}</li>
                        <li class="col-start-1 col-end-1"><i class="ri-ram-line"></i><span class="font-semibold"> Ram :</span> {{ $order->ram }} Go</li>
                        <li class="col-start-1 col-end-1"><i class="ri-cpu-line"></i><span class="font-semibold"> Core :</span> {{ $order->cpu }} Vcore</li>
                        <li class="col-start-1 col-end-1"><i class="ri-hard-drive-2-line"></i><span class="font-semibold"> Storage :</span> {{ $order->storage }} Go</li>
                        <li class="col-start-1 col-end-1"><i class="ri-money-dollar-circle-line"></i><span class="font-semibold"> Total cost (including tax) :</span> {{ $order->cost }}€</li>

                        <li class="col-start-2 col-end-2 row-start-2"><i class="ri-database-2-line"></i><span class="font-semibold"> Database :</span> {{ $order->db }}</li>
                        <li class="col-start-2 col-end-2 row-start-3"><i class="ri-box-3-line"></i><span class="font-semibold"> Allocations :</span> {{ $order->allocations }}</li>
                        <li class="col-start-2 col-end-2 row-start-4"><i class="ri-archive-line"></i><span class="font-semibold"> Backups :</span> {{ $order->backups }}</li>
                    </ul>
                    @if (session('success'))
                    <div class="mt-4 p-4 max-w-96 bg-green-500 text-white rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="mt-4 p-4 max-w-3xl bg-red-500 text-white rounded-lg">
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Formulaire pour le code promo -->

                    <!-- Boutons de paiement -->
                    <div class=" space-x-1 items-center mt-8 grid grid-cols-2 grid-rows-1 ">
                        <div class="flex ">
                        <a href="{{ route('paypal.pay.buy', $order->id) }}" class="px-4 max-h-10 mr-4 py-2 bg-blue-500 text-center text-white font-semibold rounded-lg hover:bg-blue-400"><i class="ri-paypal-line"></i> Pay with PayPal</a>
                        @if ($creditornot != 0)
                        <a href="{{ route('credit.buy', $order->id) }}" class="px-4 py-2 max-h-10 bg-blue-500 text-center text-white font-semibold rounded-lg hover:bg-blue-400"><i class="ri-refund-2-line"></i> Pay with Credits</a>
                        @endif
                        </div>
                        <form action="{{ route('paypal.coupon', ['order' => $order->id]) }}" method="POST" class="mb-4 mt-4  flex ">
                            @csrf
                            <div class="flex max-w-96  ">
                                <input type="text" name="coupon" placeholder="Promo code" class=" max-h-10  dark:bg-gray-700 bg-white dark:text-gray-200 text-black max-w-96 mr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="px-6  bg-gray-500 text-white rounded-lg  max-h-10 min-h-10 hover:bg-gray-700">Apply</button>
                            </div>
                        </form>
                    </div>

                </div>



            </div>
        </div>
    </div>
</x-app-layout>
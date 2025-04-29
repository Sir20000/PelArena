<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent  leading-tight">
            Server renewal : {{ $order->server_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-xl ">
                <div class="p-6 bg-white dark:bg-gray-800 dark:text-white">

                    <!-- Colonne gauche -->


                    <!-- Détails de la facture -->
                    <h1 class="font-semibold text-2xl dark:text-white text-black mb-8">Invoice details</h1>
                    <ul class="space-y-2 grid md:grid-cols-2 grid-cols-1 grid-rows-5 items-center">
                        <li class="col-start-1 md:col-end-1"><i class="ri-server-line"></i><span class="font-semibold"> Name of server :</span> {{ $order->server_name }}</li>
                        <li class="md:col-start-2 md:col-end-2 md:row-start-1 col-start-1"><i class="ri-money-dollar-circle-line"></i><span class="font-semibold"> Total cost (including tax) :</span> {{ $order->cost }}€</li>

                        <li class="col-start-1 md:col-end-1"><i class="ri-ram-line"></i><span class="font-semibold"> Ram :</span> {{ $order->ram }} Go</li>
                        <li class="col-start-1 md:col-end-1"><i class="ri-cpu-line"></i><span class="font-semibold"> Core :</span> {{ $order->cpu }} Vcore</li>
                        <li class="col-start-1 md:col-end-1"><i class="ri-hard-drive-2-line"></i><span class="font-semibold"> Storage :</span> {{ $order->storage }} Go</li>

                        <li class="md:col-start-2 md:col-end-2 md:row-start-2 col-start-1"><i class="ri-database-2-line"></i><span class="font-semibold"> Database :</span> {{ $order->db }}</li>
                        <li class="md:col-start-2 md:col-end-2 md:row-start-3 col-start-1"><i class="ri-box-3-line"></i><span class="font-semibold"> Allocations :</span> {{ $order->allocations }}</li>
                        <li class="md:col-start-2 md:col-end-2 md:row-start-4 col-start-1"><i class="ri-archive-line"></i><span class="font-semibold"> Backups :</span> {{ $order->backups }}</li>
                    </ul>
           

                    <!-- Formulaire pour le code promo -->

                    <!-- Boutons de paiement -->
                    <div class=" space-x-1 items-center mt-8 grid md:grid-cols-2 grid-cols-1 md:grid-rows-1 grid-rows-4 ">
                        <div class="flex ml-1 md:ml-0">
                        <a href="{{ route('paypal.pay.buy', $order->id) }}" class="px-4 max-h-10 mr-4 py-2 bg-blue-500 text-center text-white  not-italic font-semibold rounded-xl hover:bg-blue-400"><i class="ri-paypal-line"></i> <i class="hidden md:inline">Pay with</i> PayPal</a>
                        @if ($creditornot != 0)
                        <a href="{{ route('credit.buy', $order->id) }}" class="px-4 py-2 max-h-10 bg-blue-500 text-center text-white font-semibold not-italic rounded-xl hover:bg-blue-400"><i class="ri-refund-2-line"></i> <i class="hidden md:inline">Pay with</i> Credits</a>
                        @endif
                        </div>
                        <form action="{{ route('paypal.coupon', ['order' => $order->id]) }}" method="POST" class="h-full flex mt-2 md:mt-0">
                            @csrf
                            <div class="flex max-w-96  ">
                                <input type="text" name="coupon" placeholder="Promo code" class=" max-h-10  dark:bg-gray-700 bg-white dark:text-gray-200 text-black max-w-96 mr-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="px-6  bg-gray-500 text-white rounded-xl  max-h-10 min-h-10 hover:bg-gray-700">Apply</button>
                            </div>
                        </form>
                    </div>

                </div>



            </div>
        </div>
    </div>
</x-app-layout>
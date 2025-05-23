<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">

            Créer un Coupon
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-white">

                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        @if(isset($coupon))
                        @method('POST')
                        @endif

                        <div class="form-group mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300">Nom</label>
                            <div class="input-group flex">
                                <input type="text" id="name" name="name" class="form-control rounded-xl mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <button type="button" class="inline-flex mt-1 ml-2 items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button" onclick="generateRandomString()">Générer</button>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="reduction" class="block text-sm font-medium text-gray-300">Réduction</label>
                            <input type="number" id="reduction" name="reduction" class="form-control rounded-xl mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" step="0.01">
                        </div>
                        <div class="form-group mb-4">
                            <label for="expire_time" class="block text-sm font-medium text-gray-300">Date d'expiration</label>
                            <input type="datetime-local" id="expire_time" name="expire_time" value="{{ old('expire_time') }}" class="form-control rounded-xl mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div class="form-group mb-4">
                            <label for="one_for_user" class="block text-sm font-medium text-gray-300">
                                Utilisable une fois pour chaque utilisateur
                            </label>
                            <input type="hidden" name="one_for_user" value="0">
                            <input
                                type="checkbox"
                                id="one_for_user"
                                name="one_for_user"
                                value="1"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-500">
                        </div>
                        <div class="form-group mb-4">
                            <label for="max_usage" class="block text-sm font-medium text-gray-300">
                                Utilisable combien de fois au total
                            </label>
                            <input type="hidden" name="max_usage" value="-1">
                            <input
                                type="number"
                                id="max_usage"
                                name="max_usage"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-500">
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">{{ isset($coupon) ? 'Mettre à jour' : 'Créer' }} Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
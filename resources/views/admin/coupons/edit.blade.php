<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">

            Modifier un Coupon
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-white">

                    <form action="{{ route('admin.coupons.update' , $coupon->id)  }} " method="POST" class="text-black">
                        @csrf
                        @if(isset($coupon))
                        @method('POST')
                        @endif

                        <div class="form-group mb-4">
                            <label for="name" class="block text-sm font-medium dark:text-gray-300">Nom</label>
                            <div class="input-group flex">
                                <input type="text" id="name" name="name" value="{{ old('name', $coupon->name ?? '') }}" class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:ring dark:focus:ring-blue-500 focus:ring-opacity-50">
                                <button type="button" class="inline-flex mt-1 ml-2 items-center px-4 py-2 dark:bg-gray-800 bg-gray-200 border border-transparent rounded-md font-semibold text-xs dark:text-white text-gray-800 uppercase tracking-widest dark:hover:bg-gray-700 hover:bg-white dark:focus:bg-gray-700 focus:bg-white dark:active:bg-gray-900 active:bg-gray-300 focus:outline-none focus:ring-2 dark:focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button" onclick="generateRandomString()">Générer</button>
                            </div>


                        </div>

                        <div class="form-group mb-4">
                            <label for="reduction" class="block text-sm font-medium dark:text-gray-300">Réduction</label>
                            <input type="number" id="reduction" name="reduction" value="{{ old('reduction', $coupon->reduction ?? '') }}" class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:ring dark:focus:ring-blue-500 focus:ring-opacity-50" step="0.01">
                        </div>
                        <div class="form-group mb-4">
                            <label for="expire_time" class="block text-sm font-medium dark:text-gray-300">Date d'expiration</label>
                            <input type="datetime-local" id="expire_time" name="expire_time" value="{{ old('expire_time', optional($coupon->expire_time)->format('Y-m-d\TH:i')) }}" class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:ring dark:focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div class="form-group mb-4">
                            <label for="one_for_user" class="block text-sm font-medium dark:text-gray-300">
                                Utilisable une fois pour chaque utilisateur
                            </label>
                            <input type="hidden" name="one_for_user" value="0">
                            <input type="checkbox" id="one_for_user" name="one_for_user" value="1" 
                                class="rounded dark:border-gray-300 dark:text-blue-600 shadow-sm focus:ring dark:focus:ring-blue-500" 
                                {{ old('one_for_user', $coupon->one_for_user ?? 0) == 1 ? 'checked' : '' }}>
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.categorie.update'))

                        <button type="submit" class="inline-flex items-center px-4 py-2 dark:bg-gray-800 bg-gray-200 border border-transparent rounded-md font-semibold text-xs dark:text-white text-gray-800 uppercase tracking-widest dark:hover:bg-gray-700 hover:bg-white dark:focus:bg-gray-700 focus:bg-white dark:active:bg-gray-900 active:bg-gray-300 focus:outline-none focus:ring-2 dark:focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">{{ isset($coupon) ? 'Mettre à jour' : 'Créer' }} Coupon</button>
                    
                        @endif
</form>
                </div>
            </div>
        </div>
    </div>

    </form>

    
</x-app-layout>
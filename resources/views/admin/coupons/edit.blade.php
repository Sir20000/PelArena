<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un Coupon
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">

                    <form action="{{ route('admin.coupons.update' , $coupon->id)  }}" method="POST">
                        @csrf
                        @if(isset($coupon))
                        @method('POST')
                        @endif

                        <div class="form-group mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300">Nom</label>
                            <div class="input-group flex">
                                <input type="text" id="name" name="name" value="{{ old('name', $coupon->name ?? '') }}" class="form-control rounded-lg mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <button type="button" class="inline-flex mt-1 ml-2 items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button" onclick="generateRandomString()">Générer</button>
                            </div>


                        </div>

                        <div class="form-group mb-4">
                            <label for="reduction" class="block text-sm font-medium text-gray-300">Réduction</label>
                            <input type="number" id="reduction" name="reduction" value="{{ old('reduction', $coupon->reduction ?? '') }}" class="form-control rounded-lg mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" step="0.01">
                        </div>
                        <div class="form-group mb-4">
                            <label for="expire_time" class="block text-sm font-medium text-gray-300">Date d'expiration</label>
                            <input type="datetime-local" id="expire_time" name="expire_time" value="{{ old('expire_time', optional($coupon->expire_time)->format('Y-m-d\TH:i')) }}" class="form-control rounded-lg mt-1 w-full bg-gray-800 text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div class="form-group mb-4">
                            <label for="one_for_user" class="block text-sm font-medium text-gray-300">
                                Utilisable une fois pour chaque utilisateur
                            </label>
                            <input type="hidden" name="one_for_user" value="0">
                            <input type="checkbox" id="one_for_user" name="one_for_user" value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-500" 
                                {{ old('one_for_user', $coupon->one_for_user ?? 0) == 1 ? 'checked' : '' }}>
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.categorie.update'))

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">{{ isset($coupon) ? 'Mettre à jour' : 'Créer' }} Coupon</button>
                    
                        @endif
</form>
                </div>
            </div>
        </div>
    </div>

    </form>

    <script>
        function generateRandomString() {
            var randomString = Math.random().toString(36).substring(2, 32);
            document.getElementById('name').value = randomString;
        }
    </script>
</x-app-layout>
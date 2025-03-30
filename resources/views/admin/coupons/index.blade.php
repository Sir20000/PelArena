<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">

                            <h3 class="font-bold text-lg">Liste des coupons</h3>
                        </div>
                        <div class="item2">
                            @if(auth()->user() && auth()->user()->hasAccess('admin.coupons.create'))

                            <button onclick="window.location.href='{{ route('admin.coupons.create') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">Ajouter un Coupon</button>
                            @endif

                        </div>
                    </div>
                    <div class="space-y-4 mt-6 ">
                        @foreach($coupons as $coupon)
                        <div class="bg-gray-700 dark:bg-gray-800 p-4 rounded-lg shadow-md flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-white">ID : {{ $coupon->id }}</h3>
                                <p class="text-gray-300">Nom : {{ $coupon->name }}</p>
                                <p class="text-gray-300">Réduction : {{ $coupon->reduction }}%</p>
                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.coupons.edit'))

                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-warning">Modifier</a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasAccess('admin.coupons.destroy'))

                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Servers') }}
        </h2>
    </x-slot>

    <div class="py-12">
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
        @if (session('success'))
                        <div class="bg-green-500  text-white px-4 py-2 rounded-lg mt-2">
                        <i class="ri-information-line"></i> {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2 mb-2">
                        <i class="ri-information-line"></i> {{ session('error') }}
                        </div>
                        @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
           
                @forelse ($categories as $categorie)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex flex-col">
                    <!-- Catégorie Nom -->
                    <div class="flex items-center mb-3">
                        <img src="{{ $categorie->image ?? '/path/to/default-image.jpg' }}" alt="Category Image" class="w-8 h-8 object-contain rounded-md mr-3">
                        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 p-2">
                            {{ $categorie->name }}
                        </h1>
                    </div>
                    <!-- Description -->
                    <p class="text-gray-600 dark:text-gray-400 mb-3">
                        {{ $categorie->description ?? 'No description' }}
                    </p>




                    <!-- Bouton Commande -->
                     @if ($categorie->stock == 0)
                     <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                     {{ __('Sold out') }}
                     </button>
                     @else
                    <button
                        onclick="window.location.href='{{ route('client.servers.orders.categorie', $categorie->name) }}'"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">
                        Commander
                    </button>
                    @endif
                </div>
                @empty
                <div class="col-span-3 text-center text-lg text-gray-800 dark:text-gray-300">
                    No services found.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
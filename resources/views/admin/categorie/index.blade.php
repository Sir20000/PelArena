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
                @if(auth()->user() && auth()->user()->hasAccess('admin.categorie.create'))

                <button onclick="window.location.href='{{ route('admin.categorie.create') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">Crée une nouvelle categorie</button>
                    @endif
                    @if (session('success'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    
                    <h3 class="font-bold text-lg mt-8">Liste des catégories</h3>
                    
                    <div class="space-y-4 mt-6 ">
            @foreach($categories as $category)
                <div class="bg-gray-700 dark:bg-gray-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div class="flex items-center">
                                        <img src="{{ $category->image }}" alt="Image de {{ $category->name }}" class="w-16 mr-4 h-16 object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-white">ID : {{ $category->id }}</h3>
                        <p class="text-gray-300">Nom : {{ $category->name }}</p>
                        <p class="text-gray-300">Description : {{ $category->description }}</p>
                    </div>
                    <div class="flex items-center space-x-2 ">
                    @if(auth()->user() && auth()->user()->hasAccess('admin.categorie.edit'))

                        <a href="{{ route('admin.categorie.edit', $category->id) }}" class="btn btn-warning">Modifier</a>
@endif
@if(auth()->user() && auth()->user()->hasAccess('admin.categorie.destroy'))

                        <form action="{{ route('admin.categorie.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

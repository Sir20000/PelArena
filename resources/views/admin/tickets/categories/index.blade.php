<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg">Ticket category</h3>
                            </div>

                        @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.create'))
                        <div class="flex-2">

                            <div>
                                <button onclick="window.location.href='{{ route('admin.tickets.categorie.create') }}'" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-black dark:text-white uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-800 dark:focus:bg-gray-700 focus:bg-white dark:active:bg-gray-900 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">Add Category</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="space-y-4 mt-6 ">
                        @foreach($categories as $p)
                        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow-md flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium dark:text-white text-black">Name : {{ $p->name }}</h3>
                                <p class="text-gray-300">Priority : {{ $p->priority }}</p>
                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.edit'))

                                <a href="{{ route('admin.tickets.categorie.edit', $p) }}" class="btn btn-warning">Modifier</a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.destroy'))

                                <form action="{{ route('admin.tickets.categorie.destroy', $p) }}" method="GET" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
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
            </div>
        </div>
</x-app-layout>
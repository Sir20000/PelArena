<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">
                            <form action="{{ route('admin.users.index') }}" method="GET" class="">
                                <div class="input-group px-4 py-2">
                                    <input type="text" name="search" class=" rounded-lg w-96" placeholder="Rechercher un user" value="{{ request('search') }}">
                                    <button type="submit" class=" bg-gray-400 w-10 h-10 rounded-lg "><i class="ri-search-2-line "></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="space-y-4 mt-6">
                        @if (session('success'))
                        <div class="bg-green-500  text-white px-4 py-2 rounded-lg mt-2">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2">
                            {{ session('error') }}
                        </div>
                        @endif





                        @foreach($users as $p)
                        <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-lg shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                            <div class="@if($p->enable) bg-green-500 @else bg-red-500 @endif w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                            <div class="flex-1">
                                <h3 class="text-lg font-medium dark:text-white  px-2 ">Name : {{ $p->name }}</h3>
                                <p class="text-gray-300 rounded-lg inline-block px-2 py-1">Email : {{ $p->email }}</p>

                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.users.edit'))

                                <a href="{{ route('admin.users.edit', $p) }}" class="btn btn-warning">Modifier</a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasAccess('admin.users.destroy'))

                                <form action="{{ route('admin.users.destroy', $p) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
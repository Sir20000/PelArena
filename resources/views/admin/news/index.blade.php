<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">
                            <h1 class="font-bold text-lg">Gérer les News</h1>

                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.news.create'))

                        <div class="item2">
                            <button onclick="window.location.href='{{ route('admin.news.create') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">Ajouter un role</button>

                        </div>
                    </div>
                    @endif

                    <div class="space-y-4 mt-6">

                        @if(session('success'))
                        <div class="bg-green-500  text-white px-4 py-2 rounded-lg mt-2">
                            <i class="ri-information-line"></i> {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2">
                            <i class="ri-information-line"></i> {{ session('error') }}
                        </div>
                        @endif
                        @forelse($news as $newsItem)
                        <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-lg shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                            <div class="flex-1">
                                
                                <img src="{{ asset('storage/' . $newsItem->image) }}" width="50" height="50" alt="Image">
                                <h3 class="text-lg font-medium dark:text-white">{{ $newsItem->title  }}</h3>
                                <p class="text-gray-300">{{ Str::limit($newsItem->description, 50) }}</p>

                            </div>

                            <div class="flex-2 text-right">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.users.edit'))

                                <a href="{{ route('admin.news.edit', $newsItem) }}" class="btn btn-warning">Modifier</a>
                                @endif
                                @if(auth()->user() && auth()->user()->hasAccess('admin.users.destroy'))

                                <form action="{{ route('admin.news.destroy', $newsItem) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-300">
                                No news found.
                            </td>
                        </tr>
                        @endforelse





                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
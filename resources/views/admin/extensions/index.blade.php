<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
            {{ __('Extentions') }}

        </h2>
    </x-slot>
  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">
                        <h1 class="font-bold text-lg">Manage Extentions</h1>

                        </div>

                    </div>
                    <div class="space-y-4 mt-6">


                        @forelse($extensions as $key => $meta)

                        <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-xl shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                            <div class="bg-stone-500 w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                            <div class="flex-1 pl-2">
                                <h3 class="text-lg font-medium dark:text-white text-black">{{ $meta['name'] }}</h3>
                                <p class="dark:text-gray-300 text-gray-600">v{{ $meta['version'] }}</p>
                                <p class="dark:text-gray-300 text-gray-600">{{ $meta['description'] }}</p>
                            </div>
                            <div class="flex items-center space-x-2 ">
                                @if(auth()->user() && auth()->user()->hasAccess('admin.extensions.config'))

                                <a href="{{ route('admin.extensions.config', strtolower($meta['name'])) }}" class="btn btn-warning">Configure</a>
                                @endif
                                
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-300">
                                No services found.
                            </td>
                        </tr>
                        @endforelse
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
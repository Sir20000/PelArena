
<x-app-layout>
@if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.store'))

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }} :
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold ">Create Category</h3>
                    <form action="{{ route('admin.tickets.categorie.store') }}" method="POST">
                        @csrf
                        <div class="my-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-4">Name</label>
                            <input type="text" name="name" placeholder="Category Name" class="form-control w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white"  required>
                        </div>
                        <div class="my-6">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-4">Priority</label>

                            <select name="priority">

                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.store'))

                        <button type="submit" class=" px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Save</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>
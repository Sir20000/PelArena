<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }} : {{$category->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold ">Edit Category</h3>
                    <form action="{{ route('admin.tickets.categorie.update' , $category->id) }}" method="POST">
                        @csrf
                        <div class="my-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-4">Name</label>
                            <input type="text" name="name" placeholder="Category Name" class="form-control w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white" value="{{$category->name}}" required>
                        </div>
                        <div class="my-6">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-4">Priority</label>

                            <select name="priority">

                                <option value="low" {{ $category->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $category->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $category->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.categorie.update'))

                        <button type="submit" class=" px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Save</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
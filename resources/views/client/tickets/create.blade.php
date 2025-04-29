<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent  leading-tight">
            {{ __('Create Ticket') }}

        </h2>
    </x-slot>
    <div class=py-12>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6 ">
            <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-800 rounded-xl bg-white">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Create Ticket') }}
                    </h2>
                    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6 ">
                        @csrf
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Title') }}
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                placeholder="Enter the title"
                                required
                                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-200">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Description') }}
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                placeholder="Describe the issue"
                                required
                                rows="4"
                                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-200"></textarea>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Category') }}
                            </label>
                            <select
                                name="category_id"
                                id="category_id"
                                required
                                class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-200">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
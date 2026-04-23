<x-app-layout>

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
            {{ __('Config extention') }}: {{ ucfirst($extension) }}

        </h2>
    </x-slot>
  

  <x-admin.sidebar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
                        <div class="item1">
                        <h1 class="font-bold text-lg">Edit Extention</h1>

                        </div>

                    </div>
                    <div class="space-y-4 mt-6">


<form method="POST" action="{{ route('admin.extensions.config.save', $extension) }}">
    @csrf

    @foreach($fields as $field)
        <div class="flex flex-col">
            <label>{{ $field['label'] }}</label>
            <input
                type="{{ $field['type'] }}"
                name="{{ $field['key'] }}"
                value="{{ old($field['key'], $values[$field['key']] ?? '') }}"
                class="text-black dark:text-white dark:bg-gray-800 rounded-lg bg-gray-100 "

            >
        </div>
    @endforeach

                            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 dark:bg-gray-700 bg-gray-200 border border-transparent rounded-md font-semibold text-xs dark:text-white text-gray-800 uppercase tracking-widest dark:hover:bg-gray-700 hover:bg-white dark:focus:bg-gray-700 focus:bg-white dark:active:bg-gray-900 active:bg-gray-300 focus:outline-none focus:ring-2 dark:focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150" class="btn btn-success custom-success-button">Save</button>

</form></x-app-layout>
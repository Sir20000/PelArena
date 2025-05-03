<x-app-layout>

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between items-center">
            {{ __('Config extention') }}: {{ ucfirst($extension) }}

        </h2>
    </x-slot>
  

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
        <div>
            <label>{{ $field['label'] }}</label>
            <input
                type="{{ $field['type'] }}"
                name="{{ $field['key'] }}"
                value="{{ old($field['key'], $values[$field['key']] ?? '') }}"
            >
        </div>
    @endforeach

    <button type="submit">Enregistrer</button>
</form></x-app-layout>
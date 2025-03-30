<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verify 2FA') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-7xl mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                <div class="bg-green-500 text-white  rounded-lg m-4">
                    <i class="ri-information-line"></i> {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="bg-red-500 text-white p-2 rounded-lg m-4">
                    <i class="ri-information-line"></i> {{ session('error') }}
                </div>
                @endif
                <div class="p-4">
                    <h2 class='text-lg '>Vérification 2FA</h2>
                    <form method="POST" action="{{ route('2fa.verify') }}">
                        @csrf
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code de vérification</label>
                        <input type="text" name="code" class="mt-1 block w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-200" required min="6" max="6">
                        <button type="submit" class="w-full mt-4 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">Vérifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Create an API Key') }}<br>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.api.store') }}">
                        @csrf

                        <!-- Champ Nom -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium">Memo</label>
                            <input type="text" name="memo" class="form-control w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white" required>
                        </div>

                        @php
                            $corePermissions = [];

                            foreach ($routes as $route) {
                                $nameParts = explode('.', $route->getName());
                                $core = $nameParts[1] ?? 'Unknown';
                                $action = strtolower($nameParts[2] ?? 'action');

                                if (isset($nameParts[3])) {
                                    $action = strtolower($nameParts[3]);
                                    $core = $nameParts[2] . ' ' . $nameParts[1];
                                }

                                // Initialiser le core s'il n'existe pas
                                if (!isset($corePermissions[$core])) {
                                    $corePermissions[$core] = 'none'; // valeur par défaut
                                }

                                // Déterminer la permission à appliquer
                                if (in_array($action, ['index', 'view', 'show', 'list'])) {
                                    // Lecture seule
                                    if ($corePermissions[$core] !== 'read/write') {
                                        $corePermissions[$core] = 'read';
                                    }
                                } elseif (in_array($action, ['create', 'store', 'update', 'edit', 'delete', 'destroy'])) {
                                    // Écriture : passer en read/write directement
                                    $corePermissions[$core] = 'read/write';
                                }
                            }
                        @endphp

<!-- Affichage des boîtes par core -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($corePermissions as $core => $defaultPermission)
        <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
                {{ $core }}
            </h3>

            <div class="flex flex-wrap gap-2">
                @php
                    $options = ['none' => 'None', 'read' => 'Read', 'read/write' => 'Read/Write'];
                @endphp

                @foreach ($options as $value => $label)
                    <label>
                        <input
                            type="radio"
                            name="permissions[{{ $core }}]"
                            value="{{ $value }}"
                            class="hidden peer"
                            {{ $defaultPermission === $value ? 'checked' : '' }}
                        >
                        <div class="px-4 py-2 rounded-lg border border-gray-400 dark:border-gray-600 cursor-pointer
                            peer-checked:bg-blue-500 peer-checked:text-white
                            dark:peer-checked:bg-blue-600
                            hover:bg-blue-100 dark:hover:bg-gray-700
                            transition">
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>


                        <button type="submit" class="rounded-xl bg-blue-300 p-2 mt-4"><i class="ri-add-line"></i> Create</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

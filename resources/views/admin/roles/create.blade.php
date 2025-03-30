<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf

                    <!-- Champ Nom -->
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium">Name</label>
                        <input type="text" name="name" class="form-control w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white" required>
                    </div>

                    @php
                        $groupedPermissions = [];
                        $actionLabels = [
                            'index' => 'View List',
                            'create' => 'Create View',
                            'show' => 'View',
                            'edit' => 'View Edit',
                            'destroy' => 'Delete',
                            'update' => 'Update',
                            'store' => 'Create',
                        ];
                    @endphp

                    <!-- Regroupement des permissions par "core" -->
                    @foreach ($routes as $route)
                        @php 
                            $nameParts = explode('.', $route->getName());
                            $core = $nameParts[1] ?? 'Unknown';
                            $action = strtolower($nameParts[2] ?? 'Action');

                            if (isset($nameParts[3])) {
                                $action = strtolower($nameParts[3]);
                                $core = $nameParts[2] . ' ' . $nameParts[1];
                            }

                            // Vérifier si l'action a une correspondance
                            $actionLabel = $actionLabels[$action] ?? strtoupper($action);
                            
                            $groupedPermissions[$core][] = [
                                'name' => $route->getName(),
                                'action' => $actionLabel,
                            ];
                        @endphp
                    @endforeach

                    <!-- Affichage des boîtes par core -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($groupedPermissions as $core => $permissions)
                            <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
                                    {{ $core }}
                                </h3>

                                @foreach ($permissions as $permission)
                                    <div class="flex items-center space-x-2 mb-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission['name'] }}" class="form-check-input">
                                        <label class="form-check-label text-gray-700 dark:text-gray-300">
                                            {{ $permission['action'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="mt-6 px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Créer
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

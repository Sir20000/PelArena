<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Server') }} #{{ $server->id }} : {{ $server->server_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6">Modifier le server</h1>

                    <form action="{{ route('admin.servers.update', $server) }}" method="POST" class="space-y-6">
                        @csrf

                        @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Erreur(s) :</strong>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div>
                            <label for="name" class="block text-sm font-medium">Nom</label>
                            <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->server_name }}" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium">categorie</label>
                            <input type="text" name="categorie" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->categorie }}" required readonly>
                        </div>



                        <div>
                            <label for="created_at" class="block text-sm font-medium">Créé le</label>
                            <input type="date" name="created_at" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 rounded-md border-gray-300 shadow-sm" value="{{ $server->created_at->format('Y-m-d') }}" readonly>
                        </div>

                        <div>
                            <label for="updated_at" class="block text-sm font-medium">Modifié le</label>
                            <input type="date" name="updated_at" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 rounded-md border-gray-300 shadow-sm" value="{{ $server->updated_at->format('Y-m-d') }}" readonly>
                        </div>

                        <div>
                            <label for="server_id" class="block text-sm font-medium">ID Pterodactyl</label>
                            <input type="number" name="server_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->server_id }}" min="0" step="1">
                        </div>

                        <div>
                            <label for="cost" class="block text-sm font-medium">Crédit</label>
                            <input type="number" name="cost" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->cost }}" min="0" step="1" readonly>
                        </div>




                        <div class="flex items-center">

                            <label for="status">Status du server :</label>

                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" {{ $server->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ $server->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspendu" {{ $server->status == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="cancelled" {{ $server->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                        </div>
                        <div class="items-center">

                            <label>Stats du server :</label>

                            <li>RAM : {{$server->ram}}</li>
                            <li>CPU : {{$server->cpu}}</li>
                            <li>Storage : {{$server->storage}}</li>
                            <li>Allocations : {{$server->allocations}}</li>
                            <li>Backups : {{$server->backups}}</li>
                            <li>DB : {{$server->db}}</li>

                        </div>
                </div>
                @if(auth()->user() && auth()->user()->hasAccess('admin.servers.update'))

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition">
                    Modifier
                </button>
                @endif
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
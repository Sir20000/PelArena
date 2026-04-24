<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent  leading-tight">
            Create a {{ $categorie }} server
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex  items-center">
                                <img src="{{ $product->image }}" alt="Catégorie" class="h-10 w-10 rounded-xl mr-4">
                                {{ $product->name }}


                            </h3>
                        </div>

                    </div>
                    <form action="{{ route('client.servers.order.create', ['product' => $product->id]) }}" method="POST" class="">
                        @csrf


                        <div class="mb-4 text-center items-center flex flex-col w-full">
                            <label for="server_name" class="block text-sm font-medium text-black dark:text-white">Nom du Serveur</label>
                            <div class="input-group flex md:w-96 w-80">
                                <input type="text" name="server_name" id="server_name" required class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" />
                            </div>

                        </div>

                        <!-- Champs dynamiques pour les ressources -->

                        @foreach ($fields as $field => $data)

                        @if ($data['type'] === 'select') <!-- Vérifie si le type est 'select' -->
                        <div class="mb-4 text-center items-center flex flex-col w-full">
                        <label for="{{ $field }}" class="block text-sm font-medium text-black dark:text-white">{{ $data['name'] }}</label>

                            <div class="input-group flex md:w-96 w-80">
                                <select
                                    name="value[{{ $field }}]"
                                    id="{{ $field }}"
                                    required
                                    class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    @foreach($data['options'] as $option)
                                    <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                        @elseif ($data['type'] === 'text')

    <div class="mb-4 text-center items-center flex flex-col w-full">
        <label for="{{ $field }}" class="block text-sm font-medium text-black dark:text-white">
            {{ $data['name'] }}
        </label>

        <div class="input-group flex md:w-96 w-80">
            <input
                type="text"
                name="value[{{ $field }}]"
                id="{{ $field }}"
                required
                class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
            />
        </div>
    </div>
                        @else
                        <div class="mb-4 text-center items-center flex flex-col w-full">
                            <label for="{{ $field }}" class="block text-sm font-medium text-black dark:text-white">
                                {{ $data['name'] }}
                            </label>
                            <div class="input-group flex md:w-96 w-80">
                                <input
                                    type="{{ $data['type'] }}"
                                    name="value[{{ $field }}]"
                                    id="{{ $field }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    value="{{ $maxValues[$field]  }}"
                                    class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" 
                                    readonly
                                    />

                               
                            </div>
                            
                        </div>
                        @endif

                        @endforeach
                        <!-- Bouton de commande -->
                        <div class="text-center">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 mt-4 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Commander TTC <span id="totalprix" class="ml-2">{{$prix}}€</span>
                            </button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Script pour calcul des prix -->
   
</x-app-layout>
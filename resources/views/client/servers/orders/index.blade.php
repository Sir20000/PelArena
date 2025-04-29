<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent  leading-tight">
            Create a {{ $categorie->name }} server
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex  items-center">
                                <img src="{{ $categorie->image }}" alt="Catégorie" class="h-10 w-10 rounded-xl mr-4">
                                {{ $categorie->name }}


                            </h3>
                        </div>

                    </div>
                    <form action="{{ route('client.servers.order.create', ['categorie' => $categorie->id]) }}" method="POST" class="">
                        @csrf

                        <div class="mb-4   text-center items-center flex flex-col">
                            <label for="server_name" class="block text-sm font-medium text-black dark:text-white">Nom du Serveur</label>
                            <div class="input-group flex md:w-96 w-80">
                                <input type="text" name="server_name" id="server_name" required class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 max-w-[404px]" />
                            </div>

                        </div>

                        <!-- Champs dynamiques pour les ressources -->
                        @php
                        $maxValues = [
                        'ram' => $categorie->maxram,
                        'cpu' => $categorie->maxcpu,
                        'disk' => $categorie->maxstorage,
                        'db' => $categorie->maxdb,
                        'allocations' => $categorie->maxallocations,
                        'backups' => $categorie->maxbackups,
                        ];
                        @endphp

                        @foreach (['ram' => 'RAM GiB', 'cpu' => 'CPU Core', 'disk' => 'Disque Gib', 'db' => 'DataBase Mariadb', 'allocations' => 'Allocation', 'backups' => 'Backups'] as $field => $label)
                        <div class="mb-4 text-center items-center flex flex-col  w-full">
                            <label for="{{ $field }}" class="block text-sm font-medium text-black dark:text-white">{{ $label }}</label>
                            <div class="input-group flex   md:w-96 w-80">
                                <input type="number" name="{{ $field }}" id="{{ $field }}" required min="0" step="0.01" max="{{ $maxValues[$field] }}" class="form-control rounded-xl mt-1 w-full dark:bg-gray-800 bg-gray-200 text-black dark:text-white border-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 " />
                                <p id="{{ $field }}prix" class="inline-flex  w-full mt-1 ml-2 items-center px-4 py-2 bg-gray-200 dark:bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-black dark:text-white uppercase tracking-widest transition ease-in-out duration-150 max-w-[72px]">0.00€</p>
                            </div>
                        </div>
                        @endforeach

                        <!-- Bouton de commande -->
                        <div class="text-center">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 mt-4 border border-transparent rounded-md font-semibold text-xs text-dark dark:text-white uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Commander TTC <span id="totalprix" class="ml-2">0.00€</span>
                            </button>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    

        <!-- Script pour calcul des prix -->
        <script>
            // Prix unitaires transmis depuis PHP
            const prixUnitaire = {
                ram: {
                    {
                        $prix - > ram
                    }
                },
                cpu: {
                    {
                        $prix - > cpu
                    }
                },
                disk: {
                    {
                        $prix - > storage
                    }
                },
                db: {
                    {
                        $prix - > db
                    }
                },
                allocations: {
                    {
                        $prix - > allocations
                    }
                },
                backups: {
                    {
                        $prix - > backups
                    }
                }
            };

            // Initialiser les éléments des inputs et prix
            const fields = ['ram', 'cpu', 'disk', 'db', 'allocations', 'backups'];
            const totalPrixElement = document.getElementById('totalprix');
            let totalPrix = 0;

            fields.forEach(field => {
                const inputElement = document.getElementById(field);
                const prixElement = document.getElementById(`${field}prix`);

                inputElement.addEventListener('input', function() {
                    const value = parseFloat(inputElement.value) || 0;
                    const prix = value * prixUnitaire[field];
                    prixElement.textContent = `${prix.toFixed(2)}€`;

                    // Recalculer le total
                    updateTotal();
                });
            });

            // Mettre à jour le total des prix
            function updateTotal() {
                const tva = parseFloat({
                    {
                        $tva
                    }
                }); // Pourcentage de TVA
                totalPrix = fields.reduce((sum, field) => {
                    const value = parseFloat(document.getElementById(field).value) || 0;
                    return sum + (value * prixUnitaire[field]);
                }, 0);

                const totalAvecTva = totalPrix * (1 + tva / 100);
                totalPrixElement.textContent = `${totalAvecTva.toFixed(2)} €`;
            }
        </script>

</x-app-layout>
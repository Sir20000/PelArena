<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Server') }} #{{ $server->id }} : {{ $server->server_name }}
        </h2>
    </x-slot>

  <x-admin.sidebar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl">
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
                            <input type="text" name="name" class="bg-gray-100 dark:bg-gray-700 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->server_name }}" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium">categorie</label>
                            <input type="text" name="categorie" class=" bg-gray-100 dark:bg-gray-700 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->categorie }}" required readonly>
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
                            <label for="cost" class="block text-sm font-medium">Crédit</label>
                            <input type="number" name="cost" class="bg-gray-100 dark:bg-gray-700 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $server->cost }}" min="0" step="1" readonly>
                        </div>




                        <div>

                            <label for="status">Status du server :</label>

                            <select id="status" name="status" class="bg-gray-100 dark:bg-gray-700 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" {{ $server->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ $server->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspendu" {{ $server->status == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="cancelled" {{ $server->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                        </div>
                        <div class="items-center">

                            <label>Stats du server :</label>
<!-- GET INFO FROM EXTENTION -->
                       
                            <li>Apartient a: <a href="{{ route('admin.users.edit', $server->user->id)}}">{{$server->user->email}}</a></li>

                        </div>
                </div>
                @if(auth()->user() && auth()->user()->hasAccess('admin.servers.update'))

                <button type="submit" class=" mb-6 mx-4  bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition">
                    Sauvegarder
                </button>
                @endif
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

{{--<x-app-layout>
    @if($server->status != 'cancelled')
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent  leading-tight">
            Server Management : {{ $server->server_name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex  items-center">
                                <img src="{{ $categorie->image }}" alt="Catégorie" class="h-10 w-10 rounded-xl mr-4">
                                {{ $categorie->name }}


                            </h3>
                        </div>

                    </div>
                    <div class="grid grid-cols-2 gap-4">


                        <!-- Ressources -->
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Ressources Allouées</h4>
                            <ul class=" text-gray-600 dark:text-gray-400">
                                <li><i class="ri-ram-line"></i> RAM : {{ $server->ram }} Go</li>
                                <li><i class="ri-cpu-line"></i> CPU : {{ $server->cpu }} Core(s)</li>
                                <li><i class="ri-hard-drive-2-line"></i> Stockage : {{ $server->storage }} Go</li>

                            </ul>
                        </div>
                        <div>
                            <ul class=" text-gray-600 dark:text-gray-400 ">
                                <br>
                                <li class="mt-4"><i class="ri-door-closed-line"></i> Allocations : {{ $server->allocations }}</li>
                                <li><i class="ri-archive-line"></i> Backups : {{ $server->backups }}</li>
                                <li><i class="ri-database-2-line"></i> Data Base : {{ $server->db }}</li>
                        </div>
                        </ul>

                    </div>

                    <!-- Lien vers le panneau -->
                    <div class="flex">
                        <div class="mt-6 mr-2 ">
                            <a href="{{ $url }}" target="_blank"
                                class="inline-flex items-center px-2 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white dark:text-gray-100 uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-700 transition ease-in-out duration-150">
                                <i class="fa-solid fa-link mr-2"></i> Access the Panel
                            </a>
                        </div>
                        <div class="mt-6 mr-2 ">
                            <a href='{{ route("client.servers.manage.renouvel", $server->id) }}' target="_blank"
                                class="inline-flex items-center px-2 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white dark:text-gray-100 uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 active:bg-gray-700 transition ease-in-out duration-150">
                                <i class="fa-solid fa-link mr-2"></i>Renew for one month
                            </a>
                        </div>
                        <div class="mt-6 mr-2 ">
                            <a href='{{ route("client.servers.manage.cancel", $server->id) }}' target="_blank"
                                class="inline-flex items-center px-2 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-white dark:text-gray-100 uppercase tracking-widest hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300 active:bg-red-700 transition ease-in-out duration-150">
                                <i class="fa-solid fa-link mr-2"></i>Cancel server
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($server->backups)
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between pb-3">
                        <div>
                            <h3 class="text-gray-800 mt-1.5 dark:text-gray-200 text-lg">List of Backups {{$nbr}} / {{$server->backups}} </h3>
                        </div>
                        <div>
                            <button id="createBackup" class="bg-gray-400 text-white rounded-xl p-2">Create a Backup</button>
                        </div>
                    </div>
                    @if ($backups)
                    @foreach($backups as $backup)
                    <div class="grid grid-cols-12 gap-4 rounded-xl bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-xl p-1" id='RANDOMIDLOL' style='display: flex;justify-content: space-between;'>
                        <div class="item1 text-gray-800 dark:text-gray-200    items-center" style="margin:5px;border-radius:5px;">

                            <p class="mt-2"> {{ $backup['attributes']['name'] }} </p>
                        </div>
                        <div class="item" style="margin:5px;border-radius:5px;">
                            <button onclick="downloadBackup('{{ $backup['attributes']['uuid'] }}')" class="bg-gray-400 text-white rounded-xl p-2">Télécharger</button>
                            <button onclick="restoreBackup('{{ $backup['attributes']['uuid'] }}')" class="bg-red-400 text-white rounded-xl p-2">Restaurer</button>
                            <button onclick="deleteBackup('{{ $backup['attributes']['uuid'] }}')" class="bg-red-400 text-white rounded-xl p-2">Supprimer</button>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p> No backups available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>@endif
    </div>



    </div>
    <script>
        function pelican_control(action) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("client.servers.manage.power", $server->id) }}');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data.status == 'success') {} else {
                
                alert(data.message);
            }
        } else {
            alert('An error occurred while trying to perform this action.');
        }
    };
    xhr.onerror = function() {
        alert('An error occurred while trying to perform this action.');
    };
    xhr.send('_token={{ csrf_token() }}&status=' + action);
}
document.getElementById('createBackup').addEventListener('click', function() {
    fetch('{{ route("extensions.pterodactyl.backups.create", $server->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
        .then(data => {
            
            if (data.status == 'success') {
                
                location.reload();
            }else{
                customAlert('error','An error occurred while create the backup.');

            }
        });
});

function downloadBackup(backupId) {
    const url = `{{ route('extensions.pterodactyl.backups.download', ['product' => $server->id, 'backupId' => '__backupId__']) }}`.replace('__backupId__', backupId);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.download_url;
            } else {
                customAlert('error',data.message || 'An error occurred while downloading the backup.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            customAlert('error','An error occurred while downloading the backup.');
        });
}



function restoreBackup(backupId) {
    fetch(`{{ route('extensions.pterodactyl.backups.restore', ['product' => $server->id, 'backupId' => '__backupId__']) }}`.replace('__backupId__', backupId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                truncate: true
            })

        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                customAlert('error','Backup restauré avec succès.');
            } else {
                customAlert('error','Erreur lors de la restauration du backup :', data.message);
            }
        })
        .catch(error => {
           customAlert('error','Erreur lors de la requête :', error);
        });
}

function deleteBackup(backupId) {
    fetch(`{{ route('extensions.pterodactyl.backups.delete', ['product' => $server->id, 'backupId' => '__backupId__']) }}`.replace('__backupId__', backupId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
        .then(data => {
            customAlert('succes',data.message);
            if (data.status === 'success') {
                location.reload();
            }
        });
}
</script>
    @else   
    canceled
    @endif
</x-app-layout>--}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Utilisateur') }} #{{ $user->id }} : {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6">Modifier l'utilisateur</h1>
                    <nav class="flex border-b dark:border-gray-700 mt-4 bg-white ">
                        <button class="tab-link mr-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="general"> <i class="ri-settings-4-line"></i> General Information</button>
                        <button class="tab-link mr-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="server"><i class="ri-server-line"></i> Serveurs</button>

                    </nav>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="tab-content space-y-6" id="general">

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
                                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $user->name }}" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium">E-Mail</label>
                                <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $user->email }}" required>
                            </div>

                            <div>
                                <label for="email_verified_at" class="block text-sm font-medium">E-Mail vérifié le</label>
                                <input name="date" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 rounded-md border-gray-300 shadow-sm" value="{{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d') : 'Non vérifié' }}" readonly>
                            </div>

                            <div>
                                <label for="created_at" class="block text-sm font-medium">Créé le</label>
                                <input type="date" name="created_at" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 rounded-md border-gray-300 shadow-sm" value="{{ $user->created_at->format('Y-m-d') }}" readonly>
                            </div>

                            <div>
                                <label for="updated_at" class="block text-sm font-medium">Modifié le</label>
                                <input type="date" name="updated_at" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 rounded-md border-gray-300 shadow-sm" value="{{ $user->updated_at->format('Y-m-d') }}" readonly>
                            </div>

                            <div>
                                <label for="pterodactyl_user_id" class="block text-sm font-medium">ID Pterodactyl</label>
                                <input type="number" name="pterodactyl_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $user->pterodactyl_user_id }}" min="0" step="1">
                            </div>

                            <div>
                                <label for="credit" class="block text-sm font-medium">Crédit</label>
                                <input type="number" name="credit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $user->credit }}" min="0" step="1">
                            </div>

                            <div>
                                <label for="affiliate_code" class="block text-sm font-medium">Code d'affiliation</label>
                                <input type="text" name="affiliate_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $user->affiliate_code }}">
                            </div>

                            <div>
                                <label for="referred_by" class="block text-sm font-medium">Référé par</label>
                                @if ($user->referred_by)
                                <a href="{{ route('admin.users.edit', $user->referred_by) }}" class="text-blue-500 underline">{{ $user->referred_by }}</a>
                                @else
                                <span class="text-gray-500">Aucun</span>
                                @endif
                            </div>

                            <div>
                                <label for="role_id" class="block text-sm font-medium">Rôle</label>
                                <select name="role_id" id="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role->id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="enable" class="text-sm font-medium mr-2">Activé</label>
                                <input type="checkbox" name="enable" value="1" {{ $user->enable ? 'checked' : '' }}>
                            </div>
                            <div class="flex items-center">
                                <label for="two_factor_enabled" class="text-sm font-medium mr-2">2FA</label>
                                <input type="hidden" name="two_factor_enabled" value="0">
                                <input type="checkbox" name="two_factor_enabled" value="1" {{ $user->two_factor_enabled ? 'checked' : '' }}>
                            </div>
                            <div class="">
                                <label for="password" class="block text-sm font-medium">Password</label>
                                <input type="password" name="password" class=" mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="tab-content space-y-6" id="server">
                            @forelse($server as $order)

                            <div class="bg-white dark:bg-gray-700 p-4 mx-auto rounded-xl shadow-md flex items-center justify-between dark:text-white text-black relative" style="max-width: 1180px;">
                                <div class="@if($order->status === 'pending') bg-yellow-500 @elseif($order->status === 'cancelled') bg-red-500 @else bg-green-500 @endif w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                                <div class="flex-1 pl-2">
                                    <h3 class="text-lg font-medium dark:text-white text-black">Name : {{ $order->server_name }}</h3>
                                    <p class="dark:text-gray-300 text-gray-600">Product : {{ $order->categorie }}</p>
                                    <p class="dark:text-gray-300 text-gray-600">Prix : {{ $order->cost }}€/Month</p>
                                </div>
                                <div class="flex items-center space-x-2 ">
                                    @if(auth()->user() && auth()->user()->hasAccess('admin.servers.edit'))

                                    <a href="{{ route('admin.servers.edit', $order) }}" class="btn btn-warning">Modifier</a>
                                    @endif
                                    @if(auth()->user() && auth()->user()->hasAccess('admin.servers.destroy'))

                                    <form action="{{ route('admin.servers.destroy', $order) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce coupon ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-800 dark:text-gray-300">
                                    No services found.
                                </td>
                            </tr>
                            @endforelse
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.users.update'))

                        <button type="submit" class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md transition">
                            Modifier
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
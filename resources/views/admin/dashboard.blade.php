<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">

            {{ __('Dashboard admin') }}<br>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>Bienvenue, {{ auth()->user()->name }} !</p>
                    <p>Ceci est le tableau de bord administratif où vous pouvez mettre à jour les paramètres de l'application.</p>
                    @if(auth()->user() && auth()->user()->hasAccess('admin.dashboard.update'))
                </div>
            </div>
            @if (session('success'))
                        <div class="bg-green-500  text-white px-4 py-2 rounded-xl mt-2">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-xl mt-2">
                            {{ session('error') }}
                        </div>
                        @endif
            <nav class="flex border-b dark:border-gray-700 mt-4 bg-white rounded-xl">
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="general"> <i class="ri-settings-4-line"></i> Général</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="pterodactyl"> <i class="ri-links-line"></i> Pilcan</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="legal"><i class="ri-information-line"></i> Legal</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="paypal"><i class="ri-paypal-line"></i> PayPal</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="mail"><i class="ri-mail-line"></i> Mail</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="alert"><i class="ri-notification-3-line"></i> Alert</button>
                <button class="tab-link px-4 py-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="Tickets"><i class="ri-coupon-line"></i> Tickets</button>


            </nav>
            <form action="{{ route('admin.dashboard.update') }}" method="POST" class="space-y-4">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl  tab-content" id="general">

                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4 ">
                        <!-- TVA Field -->


                        <!-- APP_NAME Field -->
                        <div class="form-group">
                            <label for="APP_NAME" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom de l'application</label>
                            <input type="text" name="APP_NAME" id="APP_NAME" value="{{$settings['APP_NAME']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Le nom de votre application, tel qu'il s'affiche sur l'interface.</p>
                        </div>

                        <!-- APP_URL Field -->
                        <div class="form-group">
                            <label for="APP_URL" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL de l'application</label>
                            <input type="text" name="APP_URL" id="APP_URL" value="{{$settings['APP_URL']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">L'URL de votre application. Exemple : https://votre-application.com</p>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="affiliationget" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Affiliation obtenue</label>
                                <input type="number" name="affiliationget" id="affiliationget" value="{{$settings['affiliationget']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Le montant d'affiliation que vous obtenez pour chaque inscription.</p>
                            </div>

                            <div class="form-group">
                                <label for="affiliationrecived" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Affiliation reçue</label>
                                <input type="number" name="affiliationrecived" id="affiliationrecived" value="{{$settings['affiliationrecived']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Le montant d'affiliation que vous recevez pour chaque inscription effectuée.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deleteafterpending" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL de l'application</label>
                            <input type="number" name="deleteafterpending" id="deleteafterpending" value="{{$settings['deleteafterpending']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Apres combien de jour les serveur sont supprimer apres avoir ete en pending</p>
                        </div>
                        <div class="form-group">
                            <label for="tva" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Taux de TVA (%)</label>
                            <input type="number" name="tva" id="tva" value="{{$settings['tva']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Entrez le pourcentage de TVA appliqué à vos transactions.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl tab-content " id="pterodactyl">

                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                        <!-- PTERODACTYL_API_URL Field -->
                        <div class="form-group">
                            <label for="PTERODACTYL_API_URL" class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL de l'API Pelican</label>
                            <input type="text" name="PTERODACTYL_API_URL" id="PTERODACTYL_API_URL" value="{{$settings['PTERODACTYL_API_URL']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">L'URL de votre serveur Pterodactyl API pour la gestion des serveurs.</p>
                        </div>

                        <!-- PTERODACTYL_API_KEY Field -->
                        <div class="form-group">
                            <label for="PTERODACTYL_API_KEY" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Clé API Pelican</label>
                            <input type="password" name="PTERODACTYL_API_KEY" id="PTERODACTYL_API_KEY" value="{{$settings['PTERODACTYL_API_KEY']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PTERODACTYL_API_KEY_CLIENT" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Clé API Pelican</label>
                            <input type="password" name="PTERODACTYL_API_KEY_CLIENT" id="PTERODACTYL_API_KEY_CLIENT" value="{{$settings['PTERODACTYL_API_KEY_CLIENT']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                    </div>
                </div>


                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl tab-content" id="legal">

                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4 ">

                        <div class="form-group">
                            <label for="tos" class="block text-sm font-medium text-gray-700 dark:text-gray-300">TOS</label>
                            <textarea name="tos" id="tos" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>{{$settings['tos']}}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Vos term de service.</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="privacypolitique" class="block text-sm font-medium text-gray-700 dark:text-gray-300">TOS</label>
                            <textarea name="privacypolitique" id="privacypolitique" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>{{$settings['privacypolitique']}}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre politique de confidentialité.</p>
                        </div>
                        <div class="form-group">
                            <label for="legal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">TOS</label>
                            <textarea name="legal" id="legal" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>{{$settings['legal']}}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre Legal Notice.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl tab-content" id="paypal">

                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4 ">

                        <div class="form-group">
                            <label for="PAYPAL_MODE" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PayPal mode </label>
                            <input type="text" name="PAYPAL_MODE" id="PAYPAL_MODE" value="{{$settings['PAYPAL_MODE']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si il ya une erreur le mode live sera automatiquement selectionnée.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_SANDBOX_CLIENT_ID" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Paypal sandbox client id</label>
                            <input type="password" name="PAYPAL_SANDBOX_CLIENT_ID" id="PAYPAL_SANDBOX_CLIENT_ID" value="{{$settings['PAYPAL_SANDBOX_CLIENT_ID']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_SANDBOX_CLIENT_SECRET" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PayPal sandbox Client Secret
                            </label>
                            <input type="password" name="PAYPAL_SANDBOX_CLIENT_SECRET" id="PAYPAL_SANDBOX_CLIENT_SECRET" value="{{$settings['PAYPAL_SANDBOX_CLIENT_SECRET']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_SANDBOX_APP_ID" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_SANDBOX_APP_ID</label>
                            <input type="password" name="PAYPAL_SANDBOX_APP_ID" id="PAYPAL_SANDBOX_APP_ID" value="{{$settings['PAYPAL_SANDBOX_APP_ID']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_LIVE_CLIENT_ID" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_LIVE_CLIENT_ID</label>
                            <input type="password" name="PAYPAL_LIVE_CLIENT_ID" id="PAYPAL_LIVE_CLIENT_ID" value="{{$settings['PAYPAL_LIVE_CLIENT_ID']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_LIVE_CLIENT_SECRET" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_LIVE_CLIENT_SECRET</label>
                            <input type="password" name="PAYPAL_LIVE_CLIENT_SECRET" id="PAYPAL_LIVE_CLIENT_SECRET" value="{{$settings['PAYPAL_LIVE_CLIENT_SECRET']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_LIVE_APP_ID" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_LIVE_APP_ID</label>
                            <input type="password" name="PAYPAL_LIVE_APP_ID" id="PAYPAL_LIVE_APP_ID" value="{{$settings['PAYPAL_LIVE_APP_ID']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_LOCALE" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_LOCALE</label>
                            <input type="text" name="PAYPAL_LOCALE" id="PAYPAL_LOCALE" value="{{$settings['PAYPAL_LOCALE']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                        <div class="form-group">
                            <label for="PAYPAL_CURRENCY" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PAYPAL_CURRENCY</label>
                            <input type="text" name="PAYPAL_CURRENCY" id="PAYPAL_CURRENCY" value="{{$settings['PAYPAL_CURRENCY']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Votre clé API Pterodactyl Client pour l'authentification des requêtes API.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl  tab-content" id="alert">

                    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                        <div class="form-group">
                            <label for="alert_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status </label>
                            <input type="hidden" name="alert_status" value="0">

                            <input type="checkbox" name="alert_status" id="alert_status"  value="1" class="mt-1 block  px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" {{ $settings['alert_status'] ? 'checked' : '' }}  >
                            
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si activé un alert aparait sur le dashboard.</p>
                        </div>
                        <div class="form-group">
                            <label for="alert_color_bg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Back Ground</label>
                            <input type="box" name="alert_color_bg" id="alert_color_bg" value="{{$settings['alert_color_bg']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si activé un alert aparait sur le dashboard.</p>
                        </div>
                        <div class="form-group">
                            <label for="alert_color_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Text</label>
                            <input type="box" name="alert_color_text" id="alert_color_text" value="{{$settings['alert_color_text']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si activé un alert aparait sur le dashboard.</p>
                        </div>
                        <div class="form-group">
                            <label for="alert_color_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenue</label>
                            <input type="box" name="alert_color_data" id="alert_color_data" value="{{$settings['alert_color_data']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si activé un alert aparait sur le dashboard.</p>
                        </div>
                        <div class="form-group">
                            <label for="alert_color_icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon</label>
                            
                            <input type="box" name="alert_color_icon" id="alert_color_icon" value="{{$settings['alert_color_icon']}}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-indigo-500" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si activé un alert aparait sur le dashboard.</p>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-800">
                        Mettre à jour
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
    </div>
    </div>

</x-app-layout>
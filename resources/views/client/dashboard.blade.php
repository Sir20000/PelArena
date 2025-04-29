<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(settings("alert_status"))
    <div class="pt-12 max-w-7xl mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="bg-{{settings('alert_color_bg')}} text-{{settings('alert_color_text')}} h-16  text-lg">
                    <div class="p-4">
                        <i class="{{settings('alert_color_icon')}}"></i> {{settings('alert_color_data')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="py-12 max-w-7xl mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl py-4 xl:py-0">
                <div class="lg:p-6 text-gray-900 dark:text-gray-100  flex xl:flex-row flex-col gap-4">
                    <div class="flex  items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full  shadow-md">
                        <i class="ri-server-line text-xl mr-3"></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Total Servers</div>
                            <div class="text-lg font-semibold">{{ $serverCount }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full  shadow-md">
                        <i class="ri-money-euro-circle-line text-xl mr-3"></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Cost</div>
                            <div class="text-lg font-semibold">{{ number_format($totalCost, 2) }}€/Month</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full shadow-md">
                        <i class="ri-coupon-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Tickets</div>
                            <div class="text-lg font-semibold">{{ $ticket }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full shadow-md">
                        <i class="ri-refresh-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Servers to renew</div>
                            <div class="text-lg font-semibold">{{ $serverCountPending }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full shadow-md">
                        <i class="ri-refund-2-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Credit</div>
                            <div class="text-lg font-semibold">{{ $credit }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-xl p-4 xl:w-48 w-full shadow-md">
                        <i class="ri-user-2-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Affiliated people</div>
                            <div class="text-lg font-semibold capitalize">{{ $affiliate }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 max-w-7xl mx-auto sm:px-8 lg:px-6">
        <!-- Credit Purchase Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('credit.paypal') }}" method="POST" class="">
                    <div class=" space-y-4">
                        <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-shopping-bag-4-line"></i> Buy Credits</h2>
                        <p class="text-sm bg-gradient-to-r from-slate-600  to-slate-500  bg-clip-text text-transparent">
                            Buy credits to automatically renew your servers every month.
                        </p>
                        <input type="number" name="credit" class="form-control rounded-xl w-full dark:bg-gray-800 text-black dark:text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Amount of credits" required>
                        <button type="submit" class="w-full px-4 py-2 dark:bg-gray-700 bg-gray-200 text-black border border-transparent rounded-md font-semibold dark:text-white  uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-100 transition ease-in-out duration-150">
                            <p class="bg-gradient-to-r from-blue-600 via-blue-400 to-blue-500 bg-clip-text text-transparent"><i class="ri-paypal-line"></i> Buy with PayPal</p> <!-- Imagine with credit -->
                        </button>
                        @csrf

                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="space-y-4">
                    <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-link"></i> Affiliate</h2>
                    <p class="text-sm bg-gradient-to-r from-slate-600  to-slate-500 bg-clip-text text-transparent ">
                        Share your affiliate link to earn rewards every time a user registers through your link.
                    </p>
                    <input type="text" class="form-control rounded-xl w-full dark:bg-gray-800 dark:text-white  border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ route('register', ['affiliate_code' => Auth::user()->affiliate_code]) }}" readonly>
                    <button type="button" onclick="copyAffiliateLink()" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <p class="bg-gradient-to-r from-blue-600 via-blue-400 to-blue-500 bg-clip-text text-transparent"><i class="ri-file-copy-line"></i> Copy Affiliate Link</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="space-y-4">
                    <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-links-line"></i> Shortcut</h2>
                    <button type="button" onclick="window.location.href='{{ route('client.servers.orders') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <p class="bg-gradient-to-r from-blue-600 via-blue-400 to-blue-500 bg-clip-text text-transparent"><i class="ri-add-line"></i> Create a server </p></button>
                    <button type="button" onclick="window.location.href='{{ route('tickets.create') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <p class="bg-gradient-to-r from-blue-600 via-blue-400 to-blue-500 bg-clip-text text-transparent"><i class="ri-add-line"></i> Create a ticket </p></button>
                    <button type="button" onclick="window.location.href='{{ route('profile.edit') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <p class="bg-gradient-to-r from-blue-600 via-blue-400 to-blue-500 bg-clip-text text-transparent"><i class="ri-profile-line"></i> Profile</p></button>
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed bottom-0 left-0 w-full  bg-gray-100 ">
    <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <ul class="flex space-x-8">
            <p class="text-gray-700 "> &copy; Copyright {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.</p>
            <li><a href="{{ route('terms') }}" class="text-black hover:text-blue-500 transition-all">Terms and Conditions</a></li>
            <li><a href="{{ route('privacy') }}" class="text-black hover:text-blue-500 transition-all">Privacy Policy</a></li>
            <li><a href="{{ route('legal') }}" class="text-black hover:text-blue-500 transition-all">Legal Notice</a></li>
        </ul>
        <div class="flex items-center space-x-4">
            <a href="https://uptime.kantumhost.fr" target="_blank" class="text-gray-800 dark:text-white hover:text-green-500" title="Uptime">
                <i class="ri-time-line text-xl"></i>
            </a>
            <a href="https://discord.gg/RnHeDp3TQ2" target="_blank" class="text-gray-800 dark:text-white hover:text-indigo-500" title="Discord">
                <i class="ri-discord-line text-xl"></i>
            </a>
        </div>
    </div>

</footer>

    <script>
        function copyAffiliateLink() {
            const affiliateLink = "{{ route('register', ['affiliate_code' => Auth::user()->affiliate_code]) }}";
            navigator.clipboard.writeText(affiliateLink)
                .then(() => {
                    customAlert('success', 'Lien copié dans le presse-papiers !');
                })
                .catch(err => {
                    console.error('Erreur lors de la copie : ', err);
                    customAlert('error', 'Impossible de copier le lien.');
                });
        };
    </script>
</x-app-layout>
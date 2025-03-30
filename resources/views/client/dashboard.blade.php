<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(settings("alert_status"))
    <div class="pt-12 max-w-7xl mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-{{settings('alert_color_bg')}} text-{{settings('alert_color_text')}} h-16  text-lg">
                    <div class="p-4">
                        <i class="{{settings('alert_color_icon')}}"></i> {{settings('alert_color_data')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (session('success'))
                        <div class="bg-green-500 text-white px-4 py-2 rounded-lg mt-2">
                        <i class="ri-information-line"></i> {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-lg mt-2">
                        <i class="ri-information-line"></i> {{ session('error') }}
                        </div>
                        @endif

    <div class="py-12 max-w-7xl mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="lg:p-6 text-gray-900 dark:text-gray-100  flex gap-4">
                    <div class="flex  items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48  shadow-md">
                        <i class="ri-server-line text-xl mr-3"></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Total Servers</div>
                            <div class="text-lg font-semibold">{{ $serverCount }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48 shadow-md">
                        <i class="ri-money-euro-circle-line text-xl mr-3"></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Cost</div>
                            <div class="text-lg font-semibold">{{ number_format($totalCost, 2) }}€/Month</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48 shadow-md">
                        <i class="ri-coupon-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Tickets</div>
                            <div class="text-lg font-semibold">{{ $ticket }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48 shadow-md">
                        <i class="ri-refresh-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Servers to renew</div>
                            <div class="text-lg font-semibold">{{ $serverCountPending }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48 shadow-md">
                        <i class="ri-refund-2-line text-xl mr-3 "></i>
                        <div class="text-clip">
                            <div class="text-sm font-medium">Credit</div>
                            <div class="text-lg font-semibold">{{ $credit }}</div>
                        </div>
                    </div>
                    <div class="flex items-center dark:bg-gray-700 dark:text-white rounded-lg p-4 w-48 shadow-md">
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-7xl mx-auto sm:px-8 lg:px-6">
        <!-- Credit Purchase Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <form action="{{ route('credit.paypal') }}" method="POST" class="">
                    <div class=" space-y-4">
                        <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-shopping-bag-4-line"></i> Buy Credits</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Buy credits to automatically renew your servers every month.
                        </p>
                        <input type="number" name="credit" class="form-control rounded-lg w-full dark:bg-gray-800 text-black dark:text-white border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Amount of credits" required>
                        <button type="submit" class="w-full px-4 py-2 dark:bg-gray-700 bg-gray-200 text-black border border-transparent rounded-md font-semibold dark:text-white  uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-100 transition ease-in-out duration-150">
                            <i class="ri-paypal-line"></i> Buy with PayPal <!-- Imagine with credit -->
                        </button>
                        @csrf

                    </div>
                </form>
            </div>
        </div>

        <!-- Affiliate Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="space-y-4">
                    <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-link"></i> Affiliate</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Share your affiliate link to earn rewards every time a user registers through your link.
                    </p>
                    <input type="text" class="form-control rounded-lg w-full dark:bg-gray-800 dark:text-white  border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ route('register', ['affiliate_code' => Auth::user()->affiliate_code]) }}" readonly>
                    <button type="button" onclick="copyAffiliateLink()" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        <i class="ri-file-copy-line"></i> Copy Affiliate Link
                    </button>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="space-y-4">
                    <h2 class="font-semibold text-xl text-dark dark:text-white leading-tight"><i class="ri-links-line"></i> Shortcut</h2>
                    <button type="button" onclick="window.location.href='{{ route('client.servers.orders') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        <i class="ri-add-line"></i> Create a server </button>
                    <button type="button" onclick="window.location.href='{{ route('tickets.create') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        <i class="ri-add-line"></i> Create a ticket </button>
                    <button type="button" onclick="window.location.href='{{ route('profile.edit') }}'" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold dark:text-white uppercase tracking-widest hover:bg-gray-300  dark:hover:bg-gray-600 focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        <i class="ri-profile-line"></i> Profile</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="absolute bottom-0 left-0 w-full bg-white dark:bg-gray-800 shadow">
        <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <ul class="flex space-x-8" class="text-gray-800 dark:text-white">
                <p class="text-gray-800 dark:text-white"> &copy; Copyright {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.</p>

                <li><a href="{{ route('terms') }}" class="text-gray-800 dark:text-white">Terms and Conditions</a></li>
                <li><a href="{{ route('privacy') }}" class="text-gray-800 dark:text-white">Privacy Policy</a></li>
                <li><a href="{{ route('legal') }}" class="text-gray-800 dark:text-white">Legal Notice</a></li>
            </ul>
            <!-- Add extra elements here if needed, like social media icons -->
        </div>
    </footer>
    
</x-app-layout>
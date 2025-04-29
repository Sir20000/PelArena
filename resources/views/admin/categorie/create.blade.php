<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">

            {{ __('Dashboard admin - Create category') }}<br>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class=" text-gray-900 dark:text-gray-100">
                    <nav class="flex border-b dark:border-gray-700 mt-4 bg-white rounded-xl">
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="general"> <i class="ri-settings-4-line"></i> General Information</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="max"><i class="ri-bar-chart-2-line"></i> Max Resource</button>
                        <button class="tab-link px-4 pb-2 text-gray-600 dark:text-gray-300 focus:outline-none" data-tab="prix"><i class="ri-money-dollar-circle-line"></i> Prix Resource</button>

                    </nav>
                    <form action="{{route('admin.categorie.store') }}" method="POST" class=" px-8 py-4">
                        @csrf

                        <div class="tab-content" id="general">
                            <div class="grid col-span-2 row-span-3">
                                <div class="form-group m-4 flex flex-col col-start-1">
                                    <label for="ram"><i class="ri-text"></i> Name</label>
                                    <input type="text" name="name" class="form-control rounded-xl" >
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="cpu"><i class="ri-quote-text"></i> Description</label>
                                    <input type="text" name="description" class="form-control rounded-xl" >
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="storage"><i class="ri-image-line"></i> Image</label>
                                    <input type="text" name="image" class="form-control rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col col-start-2">
                                    <label for="db"><i class="ri-forbid-line"></i>Egg id</label>
                                    <input type="number" name="egg_id" class="form-control rounded-xl" >
                                </div>
                                <div class="form-group hidden">
                                    <input type="number" name="nests" class="form-control" value="0">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="maxbyuser"><i class="ri-user-2-line"></i> Max by user</label>
                                    <input type="number" name="maxbyuser" class="form-control rounded-xl">
                                </div>
                                <div class=" m-4 flex flex-col">
                                    <label for="stock"><i class="ri-instance-line"></i> Stock</label>
                                    <input type="number" name="stock" class="form-control rounded-xl"  min="-1" step="1">
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="max">
                            <div class="grid col-span-2 row-span-3">
                                <div class="form-group m-4 flex flex-col col-start-1">
                                    <label for="maxram"><i class="ri-ram-line"></i> Ram</label>
                                    <input type="number" name="maxram" class="form-control  rounded-xl"  min="0" step="0.01">
                                </div>
                                <div class="form-group m-4 flex flex-col ">
                                    <label for="maxcpu"><i class="ri-cpu-line"></i> CPU</label>
                                    <input type="number" name="maxcpu" class="form-control rounded-xl"  min="0" step="0.01">
                                </div>
                                <div class="form-group m-4 flex flex-col ">
                                    <label for="maxstorage"><i class="ri-hard-drive-2-line"></i> Storage</label>
                                    <input type="number" name="maxstorage" class="form-control rounded-xl"  min="0" step="0.01">
                                </div>
                                <div class="form-group m-4 flex flex-col col-start-2">
                                    <label for="maxdb"><i class="ri-database-2-line"></i> DB</label>
                                    <input type="number" name="maxdb" class="form-control rounded-xl"  min="0" step="0.01">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="maxbackups"><i class="ri-archive-line"></i> Backups</label>
                                    <input type="number" name="maxbackups" class="form-control rounded-xl" min="0" step="0.01">
                                </div>
                                <div class="form-group m-4 flex flex-col ">
                                    <label for="maxallocations"><i class="ri-door-closed-line"></i> Allocations</label>
                                    <input type="number" name="maxallocations" class="form-control rounded-xl"  min="0" step="0.01">
                                </div>

                            </div>
                        </div>
                        <div class="tab-content" id="prix">
                        <div class="grid col-span-2 row-span-3">

                            <div class="form-group m-4 flex flex-col col-start-1">
                                <label for="ram"><i class="ri-ram-line"></i> RAM (Gib)</label>
                                <input type="number" name="ram" class="form-control rounded-xl"  min="0" step="0.01">
                            </div>
                            <div class="form-group m-4 flex flex-col">
                                <label for="cpu"><i class="ri-cpu-line"></i> CPU (Cores)</label>
                                <input type="number" name="cpu" class="form-control rounded-xl"  min="0" step="0.01">
                            </div>
                            <div class="form-group m-4 flex flex-col ">
                                <label for="storage"><i class="ri-hard-drive-2-line"></i> Stockage (Gib)</label>
                                <input type="number" name="storage" class="form-control rounded-xl" min="0" step="0.01">
                            </div>
                            <div class="form-group m-4 flex flex-col col-start-2">
                                <label for="db"><i class="ri-database-2-line"></i> DB</label>
                                <input type="number" name="db" class="form-control rounded-xl"  min="0" step="0.01">
                            </div>
                            <div class="form-group m-4 flex flex-col">
                                <label for="backups"><i class="ri-archive-line"></i> Backups</label>
                                <input type="number" name="backups" class="form-control rounded-xl"  min="0" step="0.01">
                            </div>
                            <div class="form-group m-4 flex flex-col">
                                <label for="allocations"><i class="ri-door-closed-line"></i> Allocations</label>
                                <input type="number" name="allocations" class="form-control rounded-xl"  min=0 step="0.01">
                            </div>
                        </div>
                        </div>
                        <button type="submit" class="rounded-xl bg-blue-300 p-2 mt-4"><i class="ri-add-line"></i> Add</button>

                    </form>
                </div>
            </div>
        </div>
       
    </div>

</x-app-layout>
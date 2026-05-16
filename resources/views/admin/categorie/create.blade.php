<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Dashboard admin - Create category') }}<br>
        </h2>
    </x-slot>

  <x-admin.sidebar />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
           
                    <form action="{{ route('admin.categorie.store') }}" method="POST" class="px-8 py-4">
                        @csrf

                        <div class="tab-content" id="general">
                            <div class="grid col-span-2 row-span-3">
                                <div class="form-group m-4 flex flex-col col-start-1">
                                    <label for="ram"><i class="ri-text"></i> Name</label>
                                    <input type="text" name="name" class="form-control bg-white dark:bg-gray-800 rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="cpu"><i class="ri-quote-text"></i> Description</label>
                                    <input type="text" name="description" class="form-control bg-white dark:bg-gray-800 rounded-xl">
                                </div>
                                <div class="form-group m-4 flex flex-col">
                                    <label for="storage"><i class="ri-image-line"></i> Image</label>
                                    <input type="text" name="image" class="form-control bg-white dark:bg-gray-800 rounded-xl">
                                </div>
                                <!-- col start 2 -->
                            </div>
                        </div>

                        <!-- Max Resource Section -->
                        <div class="tab-content" id="max">
                            <div class="grid col-span-2 row-span-3" id="max-resource-fields">
                                <!-- Dynamic fields for Max Resources will be loaded here -->
                            </div>
                        </div>

                        <!-- Prix Resource Section -->
                        <div class="tab-content" id="prix">
                            <div class="grid col-span-2 row-span-3" id="prix-resource-fields">
                                <!-- Dynamic fields for Prix Resources will be loaded here -->
                            </div>
                        </div>
                        <div class="tab-content" id="information">
                            <div class="grid col-span-2 row-span-3" id="information-fields">
                                <!-- Dynamic fields for Prix Resources will be loaded here -->
                            </div>
                        </div>
                        <button type="submit" class="rounded-xl bg-blue-300 p-2 mt-4"><i class="ri-add-line"></i> Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    


</x-app-layout>
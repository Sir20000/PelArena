<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
            {{ __('Manage') }} {{$server->server_name}}
        </h2>
    </x-slot>
   

    <div class="py-12 max-w-7xl mx-auto ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white dark:bg-gray-800 border-2 dark:border-gray-800 overflow-hidden shadow-sm sm:rounded-xl ">
                <div class="lg:p-6 text-gray-900 dark:text-gray-100  flex xl:flex-row flex-col gap-4">
                   
                    <button class="bg-white dark:bg-gray-600 border-2 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-xl  p-4" onclick="window.location.href='{{$url}}'"> Go to the panel</button>
               ON BUILD
                </div>
            </div>
        </div>

    </div>

  

      
  
</x-app-layout>
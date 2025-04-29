@props(['type' => 'info', 'message'])

@php
$bgColor = match ($type) {
    'success' => 'green-500',
    'error' => 'red-500',
    'warning' => 'yellow-500',
    default => 'blue-500',
};
@endphp

@if ($message)
<div  x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transitionclass class="fixed top-4 right-4 z-50  text-white px-4 py-2 rounded-xl shadow-lg mt-4flex items-center justify-between w-72 flex" >
                                <div class=" bg-{{ $bgColor }}  w-2  absolute left-0 top-0 bottom-0 rounded-l-lg"></div>

                                <div class="flex-1 pl-2 w-28">
                                    <h3 class="text-lg font-medium dark:text-white text-black"></h3>
                                    <p class="dark:text-gray-300 text-gray-600">{{ $message }}</p>
                                </div>
                                <div class="flex-2 text-right w-6">
                                    <button @click="show = false" class="text-sm text-gray-600 dark:text
                                    hover:text-gray-900 bottom-1"><i class="ri-close-line"></i></button>
                                    </div>
                                                                      
                            </div>
    
@endif

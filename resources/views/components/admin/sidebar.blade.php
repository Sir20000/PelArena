<div x-data="{ open: window.innerWidth >= 1024 }"
    x-init="window.addEventListener('resize', () => { open = window.innerWidth >= 1024 })"
    class="z-50 max-w-7xl mx-auto sm:px-6 lg:px-8  mt-4 rounded-lg">

    <!-- Mobile toggle -->
    <div class="lg:hidden flex justify-end p-4">
        <button @click="open = !open" class="text-gray-600 dark:text-gray-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Menu -->
    <nav x-show="open" x-transition
        class="flex flex-col lg:flex-row items-start lg:items-start w-full rounded-lg bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700 space-y-4 lg:space-y-0 lg:space-x-6 px-4 py-3 overflow-x-auto">

        @foreach ($categories as $category => $links)
        <div class="flex flex-col  items-start lg:items-center space-y-2 lg:space-y-0 lg:space-x-2">
            <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                {{ $category }}
            </h3>

            @foreach ($links as $route => $link)
            @if ($link['permission'])
            @php
            $isActive = request()->routeIs($route);
            @endphp
            <div class="relative">
                <a href="{{ Route::has($route) ? route($route) : '#' }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition
                  text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                    <i class="{{ $link['icon'] }} mr-2 text-base"></i>
                    <span>{{ $link['label'] }}</span>
                </a>
                @if ($isActive)
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-blue-500 rounded-none"></div>
                @endif
            </div>

            @endif
            @endforeach
        </div>
        @endforeach
    </nav>
</div>
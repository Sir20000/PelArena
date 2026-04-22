@php
    use App\Extensions\ExtensionManager;

    $user = auth()->user();
    $categories = [
        'Dashboard' => [
            'admin.dashboard.index' => ['icon' => 'ri-home-2-line', 'label' => 'Home', 'permission' => $user && $user->hasAccess('admin.dashboard.index')],
        ],
        'Utilisateurs' => [
            'admin.users.index' => ['icon' => 'ri-user-line', 'label' => 'Users', 'permission' => $user && $user->hasAccess('admin.users.index')],
            'admin.roles.index' => ['icon' => 'ri-user-line', 'label' => 'Roles', 'permission' => $user && $user->hasAccess('admin.roles.index')],
        ],
        'Serveurs' => [
            'admin.servers.index' => ['icon' => 'ri-server-line', 'label' => 'Servers', 'permission' => $user && $user->hasAccess('admin.servers.index')],
        ],
        'Contenus' => [
            'admin.products.index' => ['icon' => 'ri-article-line', 'label' => 'Products', 'permission' => $user && $user->hasAccess('admin.products.index')],
            'admin.news.index' => ['icon' => 'ri-article-line', 'label' => 'Article', 'permission' => $user && $user->hasAccess('admin.news.index')],
            'admin.categorie.index' => ['icon' => 'ri-folder-3-line', 'label' => 'Categorie', 'permission' => $user && $user->hasAccess('admin.categorie.index')],
        ],
        'Finances' => [
            'admin.revenue.index' => ['icon' => 'ri-money-dollar-circle-line', 'label' => 'Revenue', 'permission' => $user && $user->hasAccess('admin.revenue.index')],
            'admin.coupons.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Coupon', 'permission' => $user && $user->hasAccess('admin.coupons.index')],
        ],
        'Support' => [
            'admin.tickets.categorie.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Ticket Categorie', 'permission' => $user && $user->hasAccess('admin.tickets.categorie.index')],
            'admin.tickets.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Tickets', 'permission' => $user && $user->hasAccess('admin.tickets.index')],
        ],
        'Analyse' => [
            'admin.statistique.index' => ['icon' => 'ri-line-chart-line', 'label' => 'Analyse', 'permission' => $user && $user->hasAccess('admin.statistique.index')],
        ],
        'Développeurs' => [
            'admin.api.index' => ['icon' => 'ri-code-line', 'label' => 'Api', 'permission' => $user && $user->hasAccess('admin.api.index')],
            'admin.extensions.index' => ['icon' => 'ri-puzzle-line', 'label' => 'Extension', 'permission' => $user && $user->hasAccess('admin.api.index')],
        ],
    ];

    // Ajout des extensions du menu
    foreach (ExtensionManager::getAdminMenuExtensions() as $menu) {
        foreach ($menu as $subMenu) {
            if (isset($subMenu['route'])) {
                $categories[$subMenu['categorie']][$subMenu['route']] = [
                    'icon' => $subMenu['icon'],
                    'label' => $subMenu['label'],
                    'permission' => $user && $user->hasAccess($subMenu['route']),
                ];
            } else {
                Log::warning("Menu item missing 'route' key", ['menu' => $subMenu]);
            }
        }
    }
@endphp

<div x-data="{ open: window.innerWidth >= 1024 }"
     x-init="window.addEventListener('resize', () => { open = window.innerWidth >= 1024 })">

    <!-- Mobile menu toggle -->
    <button @click="open = !open" class="lg:hidden text-gray-600 dark:text-gray-300 px-4 py-2">
        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    @foreach (['desktop' => 'hidden lg:flex fixed left-6 top-1/2 transform -translate-y-1/2 w-[250px]', 'mobile' => 'flex lg:hidden w-full mt-4 max-h-[80vh] overflow-y-auto'] as $device => $classes)

        <nav x-show="open" x-transition
             class="{{ $classes }} bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md rounded-xl p-4 space-y-4 overflow-y-auto">
            @foreach ($categories as $category => $links)
                <div class="space-y-1 {{ $device === 'mobile' ? 'text-center' : '' }}">
                    <h3 class="text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400 px-2">
                        {{ $category }}
                    </h3>
                    @foreach ($links as $route => $link)
                        @if ($link['permission'])
                            @php
                                $isActive = request()->routeIs($route);
                            @endphp
                            <a href="{{ Route::has($route) ? route($route) : '#' }}"
                               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition
                               {{ $isActive ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="{{ $link['icon'] }} mr-3 text-lg {{ $isActive ? 'text-white' : '' }}"></i>
                                <span>{{ $link['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </nav>

    @endforeach
</div>

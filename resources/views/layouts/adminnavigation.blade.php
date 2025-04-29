@php
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
            'admin.api.index' => ['icon' => 'ri-line-chart-line', 'label' => 'Api', 'permission' => $user && $user->hasAccess('admin.api.index')],
            'admin.extensions.index' => ['icon' => 'ri-line-chart-line', 'label' => 'Extention', 'permission' => $user && $user->hasAccess('admin.api.index')],

        ],
    ];
@endphp

@foreach (['desktop' => 'hidden sm:flex fixed left-10 mt-10 top-1/2 transform -translate-y-1/2 w-[250px]', 'mobile' => 'flex  sm:hidden w-full items-center justify-center mt-4'] as $device => $classes)
<nav 
        x-data="{ open: false }"
        class="{{ $classes }} bg-white absolute dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 rounded-lg flex-col p-4 "
    >
        @foreach ($categories as $category => $links)
            <div class="mt-4 w-full {{ $device === 'mobile' ? 'text-center' : '' }}">
                <h3 class="text-xs font-semibold uppercase tracking-wide bg-gradient-to-r from-blue-600 via-green-400 to-purple-500 bg-clip-text text-transparent mb-2">
                    {{ $category }}
                </h3>
                @foreach ($links as $route => $link)
                    @if ($link['permission'])
                        <div class="flex-initial {{ $device === 'mobile' ? 'flex justify-center' : '' }}">
                            <a href="{{ $route === '#' ? '#' : (Route::has($route) ? route($route) : '#') }}" class="text-black dark:text-white hover:text-gray-700 dark:hover:text-gray-300 mr-2.5 px-1 block {{ $device === 'mobile' ? 'text-center' : '' }}">
                                <i class="{{ $link['icon'] }} mr-2"></i> {{ $link['label'] }}
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </nav>
    @endforeach


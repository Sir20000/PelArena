<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 mt-12 rounded-lg flex p-2 mx-auto" style="max-width: 1216px;">
    @php
        $user = auth()->user();
        $links = [
            'admin.dashboard.index' => ['icon' => 'ri-home-2-line', 'label' => 'Home', 'permission' => $user && $user->hasAccess('admin.dashboard.index')],
            'admin.users.index' => ['icon' => 'ri-user-line', 'label' => 'Users', 'permission' => $user && $user->hasAccess('admin.users.index')],
            'admin.roles.index' => ['icon' => 'ri-user-line', 'label' => 'Roles', 'permission' => $user && $user->hasAccess('admin.roles.index')],
            'admin.servers.index' => ['icon' => 'ri-server-line', 'label' => 'Servers', 'permission' => $user && $user->hasAccess('admin.servers.index')],
            'admin.news.index' => ['icon' => 'ri-article-line', 'label' => 'Article BE REWORKED NEED', 'permission' => $user && $user->hasAccess('admin.news.index')],
            'admin.revenue.index' => ['icon' => 'ri-money-dollar-circle-line', 'label' => 'Revenue' , 'permission' => $user && $user->hasAccess('admin.revenue.index')],
            'admin.categorie.index' => ['icon' => 'ri-folder-3-line', 'label' => 'Categorie BE REWORKED NEED', 'permission' => $user && $user->hasAccess('admin.categorie.index')],
            'admin.coupons.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Coupon BE REWORKED NEED', 'permission' => $user && $user->hasAccess('admin.coupons.index')],
            'admin.tickets.categorie.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Ticket Categorie', 'permission' => $user && $user->hasAccess('admin.tickets.categorie.index')],
            'admin.tickets.index' => ['icon' => 'ri-coupon-3-line', 'label' => 'Tickets' , 'permission' => $user && $user->hasAccess('admin.tickets.index')],
            'admin.statistique.index' => ['icon' => 'ri-line-chart-line', 'label' => 'Analyse', 'permission' => $user && $user->hasAccess('admin.statistique.index')],
        ];
    @endphp

    @foreach ($links as $route => $link)
        @if ($link['permission'])
            <div class="flex-initial">
                <a href="{{ $route === '#' ? '#' : (Route::has($route) ? route($route) : '#') }}" class="text-black dark:text-white hover:text-gray-700 dark:hover:text-gray-300 mr-2.5 px-1">
                    <i class="{{ $link['icon'] }}"></i> {{ $link['label'] }}
                </a>
            </div>
        @endif
    @endforeach
</nav>

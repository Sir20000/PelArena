<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Extensions\ExtensionManager;

class Sidebar extends Component
{
    public array $categories;

    public function __construct()
    {
        $user = Auth::user();

        $this->categories = [
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

        foreach (ExtensionManager::getAdminMenuExtensions() as $menu) {
            foreach ($menu as $subMenu) {
                if (isset($subMenu['route'])) {
                    $this->categories[$subMenu['categorie']][$subMenu['route']] = [
                        'icon' => $subMenu['icon'],
                        'label' => $subMenu['label'],
                        'permission' => $user && $user->hasAccess($subMenu['route']),
                    ];
                }
            }
        }
    }

    public function render()
    {
        return view('components.admin.sidebar');
    }
}

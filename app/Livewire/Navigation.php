<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fundraising;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Navigation extends Component
{
    public function render()
    {
        $user = Auth::user();
        $fundraisingQuery = Fundraising::query();
        if ($user->hasRole('fundraiser')) {
            $fundraisingQuery->whereHas('fundraiser', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        $fundraisings_count = $fundraisingQuery->count() ?? 0;
        $menus = [
            [
                'name' => 'Dashboard',
                'routeName' => 'dashboard',
                'prefixName' => 'dashboard',
                'icon' => 'fa-solid fa-chart-line',
                'info' => null,
                'children' => []
            ],
            [
                'name' => 'Role Permissions',
                'routeName' => '#',
                'prefixName' => 'role_permissions',
                'icon' => 'fa-solid fa-layer-group',
                'info' => null,
                'children' => [
                    [
                        'name' => 'Roles',
                        'routeName' => 'admin.roles.index',
                        'prefixName' => 'roles',
                        'icon' => '',
                        'info' => null,
                        'children' => []
                    ],
                    [
                        'name' => 'Permissions',
                        'routeName' => 'admin.permissions.index',
                        'prefixName' => 'permissions',
                        'icon' => '',
                        'info' => null,
                        'children' => []
                    ],
                    [
                        'name' => 'Users',
                        'routeName' => 'admin.users.index',
                        'prefixName' => 'users',
                        'icon' => '',
                        'info' => null,
                        'children' => []
                    ],
                ]
            ],
            [
                'name' => 'Categories',
                'routeName' => 'admin.categories.index',
                'prefixName' => 'categories',
                'icon' => 'fa-solid fa-list',
                'info' => null,
                'children' => []
            ],
            [
                'name' => 'Fundraisings',
                'routeName' => 'admin.fundraisings.index',
                'prefixName' => 'fundraisings',
                'icon' => 'fa-solid fa-hand-holding-dollar',
                'info' => $fundraisings_count ?? 0,
                'children' => []
            ],
            [
                'name' => 'Donaturs',
                'routeName' => 'admin.donaturs.index',
                'prefixName' => 'donaturs',
                'icon' => 'fa-solid fa-circle-dollar-to-slot',
                'info' => null,
                'children' => []
            ],
            [
                'name' => 'Fundraising Withdrawals',
                'routeName' => 'admin.fundraising_withdrawals.index',
                'prefixName' => 'fundraising_withdrawals',
                'icon' => 'fa-solid fa-money-bill-transfer',
                'info' => null,
                'children' => []
            ],
            [
                'name' => 'Fundraisers',
                'routeName' => 'admin.fundraisers.index',
                'prefixName' => 'fundraisers',
                'icon' => 'fa-solid fa-handshake-angle',
                'info' => null,
                'children' => []
            ],
        ];

        $routeNow = explode('.', Request::route()->getName());
        $prefixRouteNow = ($routeNow[0] == 'admin') ? $routeNow[1] : $routeNow[0];
        return view('livewire.navigation', compact('fundraisings_count', 'prefixRouteNow', 'menus'));
    }
}

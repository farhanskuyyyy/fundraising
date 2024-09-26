<?php

namespace Database\Seeders;

use App\Models\Fundraiser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminRole = Role::updateOrCreate([
            'name' => 'superadmin'
        ]);
        $allPermissions = Permission::get()->pluck('name');
        $superadminRole->syncPermissions($allPermissions);

        $fundraiserRole = Role::updateOrCreate([
            'name' => 'fundraiser'
        ]);
        $fundraiserRole->syncPermissions([
            'view dashboard',

            'view fundraising_withdrawals',
            'create fundraising_withdrawals',
            'edit fundraising_withdrawals',
            'show fundraising_withdrawals',

            'view fundraising_phases',
            'create fundraising_phases',
            'edit fundraising_phases',
            'show fundraising_phases',

            'view fundraisings',
            'create fundraisings',
            'edit fundraisings',
            'show fundraisings',

            'view fundraisers',
            'create fundraisers',
            'edit fundraisers',
            'show fundraisers',
        ]);

        $userRole = Role::updateOrCreate([
            'name' => 'user'
        ]);
        $userRole->syncPermissions([
            'view dashboard',

            'view fundraisers',
            'create fundraisers',
            'edit fundraisers',
            'delete fundraisers',
            'show fundraisers',
        ]);

        $superadmin = User::updateOrCreate([
            'email' => 'superadmin@fundraising.com',
        ], [
            'name' => 'superadmin',
            'avatar' => 'images/default-images.png',
            'email' => 'superadmin@fundraising.com',
            'password' => Hash::make('password')
        ]);
        $superadmin->assignRole($superadminRole);

        $fundraiser = User::updateOrCreate([
            'email' => 'hambaallah@fundraising.com',
        ], [
            'name' => 'hambaallah',
            'avatar' => 'images/default-images.png',
            'email' => 'hambaallah@fundraising.com',
            'password' => Hash::make('password')
        ]);

        $fundraiserCreate = Fundraiser::updateOrCreate([
            'user_id' => $fundraiser->id,
        ], [
            'user_id' => $fundraiser->id,
            'is_active' => true
        ]);
        $fundraiser->assignRole($fundraiserRole);

        $user = User::updateOrCreate([
            'email' => 'farhan@fundraising.com',
        ], [
            'name' => 'farhan',
            'avatar' => 'images/default-images.png',
            'email' => 'farhan@fundraising.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole($userRole);
    }
}

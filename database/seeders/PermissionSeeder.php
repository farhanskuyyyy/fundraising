<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view dashboard',

            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'show categories',

            'view donaturs',
            'create donaturs',
            'edit donaturs',
            'delete donaturs',
            'show donaturs',

            'view fundraising_withdrawals',
            'create fundraising_withdrawals',
            'edit fundraising_withdrawals',
            'delete fundraising_withdrawals',
            'show fundraising_withdrawals',

            'view fundraising_phases',
            'create fundraising_phases',
            'edit fundraising_phases',
            'delete fundraising_phases',
            'show fundraising_phases',

            'view fundraisings',
            'create fundraisings',
            'edit fundraisings',
            'delete fundraisings',
            'show fundraisings',
            'approve fundraisings',

            'view fundraisers',
            'create fundraisers',
            'edit fundraisers',
            'delete fundraisers',
            'show fundraisers',

            'view my_withdrawals',
            'create my_withdrawals',
            'edit my_withdrawals',
            'delete my_withdrawals',
            'show my_withdrawals',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'show roles',

            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'show permissions',

            'view users',
            'create users',
            'edit users',
            'delete users',
            'show users',
        ];

        foreach ($permissions as $value) {
            Permission::updateOrCreate(
                ['name' => $value],
            );
        }
    }
}

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

            'view donaturs',
            'create donaturs',
            'edit donaturs',
            'delete donaturs',

            'view fundraising_withdrawals',
            'create fundraising_withdrawals',
            'edit fundraising_withdrawals',
            'delete fundraising_withdrawals',

            'view fundraisings',
            'create fundraisings',
            'edit fundraisings',
            'delete fundraisings',

            'view fundraisers',
            'create fundraisers',
            'edit fundraisers',
            'delete fundraisers',

            'view my_withdrawals',
            'create my_withdrawals',
            'edit my_withdrawals',
            'delete my_withdrawals',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $value) {
            Permission::updateOrCreate(
                ['name' => $value],
            );
        }
    }
}

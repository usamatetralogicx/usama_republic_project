<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-view',
            'role-create',
            'role-edit',
            'role-delete',

            'product-view',
            'product-create',
            'product-edit',
            'product-delete',

            'user-view',
            'user-create',
            'user-edit',
            'user-delete',

//            'supplier-view',
//            'supplier-create',
//            'supplier-edit',
//            'supplier-delete',
//
//            'retailer-view',
//            'retailer-create',
//            'retailer-edit',
//            'retailer-delete',


            'fetch-from-shopify',

        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

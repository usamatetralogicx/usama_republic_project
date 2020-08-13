<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Hamza Farrukh',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);

        $supplier = User::create([
            'name' => 'Supplier',
            'email' => 'supplier@supplier.com',
            'password' => bcrypt('123456')
        ]);

        $retailer = User::create([
            'name' => 'Retailer',
            'email' => 'retailer@retailer.com',
            'password' => bcrypt('123456')
        ]);


        $permissions = Permission::pluck('id','id')->all();

        $role = Role::findByName('admin');
        $role->givePermissionTo($permissions);

        $roleSupplier = Role::findByName('supplier');
        $roleSupplier->givePermissionTo($permissions);

        $roleRetailer = Role::findByName('retailer');
        $roleRetailer->givePermissionTo($permissions);

        $admin->assignRole('admin');
        $supplier->assignRole('supplier');
        $retailer->assignRole('retailer');

    }
}

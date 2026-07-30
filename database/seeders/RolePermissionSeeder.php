<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ✅ إنشاء الصلاحيات
        $modules = ['category', 'subcategory', 'product', 'order', 'user', 'role', 'report'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // ✅ Super Admin - كل الصلاحيات
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // ✅ Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        // ✅ Manager
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'product.view', 'product.create', 'product.edit',
            'order.view', 'order.edit',
            'category.view'
        ]);

        // ✅ Customer (user) - لا صلاحيات للأدمن
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // ✅ مستخدم الأدمن
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );
        $adminUser->assignRole('super-admin');

        // ✅ مستخدم عميل تجريبي
        $customer = User::firstOrCreate(
            ['email' => 'customer@customer.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );
        $customer->assignRole('user');

        \App\Models\Customer::firstOrCreate(
            ['email' => 'customer@customer.com'],
            [
                'user_id' => $customer->id,
                'first_name' => 'Test',
                'last_name' => 'Customer',
                'phone' => '+966500000000',
            ]
        );
    }
}

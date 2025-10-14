<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $kasir = Role::firstOrCreate(['name' => 'kasir', 'guard_name' => 'web']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Product management
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Category management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Sales/Penjualan
            'view sales',
            'create sales',

            // Cash flow
            'view cashflow',
            'create cashflow',
            'edit cashflow',
            'delete cashflow',

            // Reports
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        // Admin has all permissions
        $admin->givePermissionTo(Permission::all());

        // Kasir (Cashier) has limited permissions
        $kasir->givePermissionTo([
            'view products',
            'view categories',
            'view sales',
            'create sales',
        ]);

        // Supervisor has more permissions than kasir
        $supervisor->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view categories',
            'create categories',
            'edit categories',
            'view sales',
            'create sales',
            'view cashflow',
            'view reports',
        ]);
    }
}

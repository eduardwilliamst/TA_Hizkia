<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        $superadmin->assignRole('admin');

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create kasir user
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@mail.com'],
            [
                'name' => 'Kasir',
                'password' => bcrypt('password'),
            ]
        );
        $kasir->assignRole('kasir');
    }
}

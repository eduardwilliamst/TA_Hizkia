<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['Super Admin', 'Admin', 'Manager', 'Teacher', 'Finance', 'Office Staff', 'Student'];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,

            ]);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'),
        ]);

        $user->assignRole('Super Admin');

    }
}

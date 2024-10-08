<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Student', 'Instructor', 'Admin'
        ];
    
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                // 'guard_name' => 'api',
            ]);
        }
    }
}

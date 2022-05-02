<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'user', 'permissions' => '{}'],
            ['id' => 2, 'name' => 'employee', 'permissions' => '{}'],
            ['id' => 3, 'name' => 'admin', 'permissions' => '{}'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}

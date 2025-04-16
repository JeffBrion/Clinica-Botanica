<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Users\Module;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'Administrador',
        ]);

        $modules = [
            [
                'name' => 'Usuarios',
                'internal_name' => 'users',
                'access_route_name' => 'users.index',
                'icon' => 'bx bx-group nav_icon',
            ],
            [
                'name' => 'Productos',
                'internal_name' => 'items',
                'access_route_name' => 'items.index',
                'icon' => 'bx bx-box nav_icon',
            ],
            [
                'name' => 'Proveedores',
                'internal_name' => 'providers',
                'access_route_name' => 'providers.index',
                'icon' => 'bx bx-store nav_icon',
            ],
        ];

        foreach ($modules as $module) {
            Module::create([
                'name' => $module['name'],
                'internal_name' => $module['internal_name'],
                'access_route_name' => $module['access_route_name'],
                'icon' => $module['icon'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'gestor@example.com'],
            [
                'name' => 'Gestor',
                'role' => 'gestor',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente',
                'role' => 'cliente',
                'password' => Hash::make('password'),
            ]
        );
    }
}

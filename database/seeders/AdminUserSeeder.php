<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['clave_institucional' => 'admin'],
            [
                'name' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('#admin#'),
                'rol' => 'administrador',
            ]
        );
    }
}

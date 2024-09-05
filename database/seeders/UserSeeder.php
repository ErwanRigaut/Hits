<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de usar el modelo User

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'ErwanR',
            'email' => 'ErwanR@example.com',
            'password' => Hash::make('1234'), // Asegúrate de usar una contraseña segura
        ]);
    }
}
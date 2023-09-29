<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Portaria::factory(10)->create();

        \App\Models\User::factory()->create([
            'matriculaSiape' => 01234567,
            'name' => 'superadmin',
            'email' => 'superadmin@admin.com',
            'email_verified_at' => now(),
            'password' => '12345678', // password
            'cargo' => 'superAdmin',
            'isAdmin' => 1,
            'isSuperAdmin' => 1,
            'remember_token' => Str::random(10),
        ]);
    }
}

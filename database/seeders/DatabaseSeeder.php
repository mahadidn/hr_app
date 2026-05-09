<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'HR Admin',
            'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            'email_verified_at' => now(),
        ]);
    }
}

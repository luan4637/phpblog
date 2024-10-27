<?php

namespace Database\Seeders;

use App\Core\User\UserModel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $password = Hash::make('admin');

        try {
            UserModel::factory()->create([
                'name' => 'Admin',
                'email' => 'luan4637@gmail.com',
                'password' => $password,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        } catch(\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

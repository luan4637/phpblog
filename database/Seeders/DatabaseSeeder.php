<?php

namespace Database\Seeders;

use App\Core\User\Roles;
use App\Core\User\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        try {
            UserModel::factory()->create([
                'name' => 'guest',
                'email' => 'guest@mail.com',
                'password' => Hash::make('guest'),
                'email_verified_at' => now(),
                'roles' => [Roles::ROLE_GUEST]
            ]);
        } catch(\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        try {
            UserModel::factory()->create([
                'name' => 'Admin',
                'email' => 'luan4637@gmail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_USER]
            ]);
        } catch(\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        try {
            UserModel::factory()->create([
                'name' => 'User',
                'email' => 'user@mail.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'roles' => [Roles::ROLE_USER]
            ]);
        } catch(\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        // import data sample
        $scriptPath = app_path() . '/../database/data_sample.sql';
        if (file_exists($scriptPath)) {
            $dataSample = file_get_contents($scriptPath);
            DB::unprepared($dataSample);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserModel::firstOrCreate(
            ['name' => 'Wallas Maciel'],
            [
                'name' => 'Wallas Maciel',
                'username' => 'wallas',
                'password' => Hash::make('123456'),
            ]
        );
    }
}

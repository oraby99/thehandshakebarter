<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                'phone' => '+1234567890',
                'country' => 'Egypt',
                'city_id' => 1, // Cairo
                'address' => '123 Main St',
                'status' => 'active',
                'average_rating' => 4.5,
                'completed_trades_count' => 10,
            ],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'country' => 'Egypt',
                'city_id' => 2, // Alexandria
                'address' => '456 Oak Ave',
                'status' => 'active',
                'average_rating' => 4.8,
                'completed_trades_count' => 25,
            ],
            [
                'name' => 'Mike Johnson',
                'username' => 'mikej',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'country' => 'Egypt',
                'city_id' => 3, // Giza
                'address' => '789 Elm St',
                'status' => 'active',
                'average_rating' => 4.2,
                'completed_trades_count' => 5,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}

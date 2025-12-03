<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            CategorySeeder::class,
            SubscriptionSeeder::class,
            UserSeeder::class,
            ColorSeeder::class,
            conditionSeeder::class,
            itemStatusSeeder::class,
            ItemSeeder::class,
            BarterSeeder::class,
            PageSeeder::class,
            brandSeeder::class,
            sizeSeeder::class,

        ]);
    }
}

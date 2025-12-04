<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Nike'],
            ['name' => 'Adidas'],
            ['name' => 'Puma'],
            ['name' => 'Under Armour'],
            ['name' => 'Reebok'],
            ['name' => 'New Balance'],
            ['name' => 'Converse'],
            ['name' => 'Vans'],
            ['name' => 'IKEA'],
            ['name' => 'Ashley'],
            ['name' => 'La-Z-Boy'],
            ['name' => 'Apple'],
            ['name' => 'Samsung'],
            ['name' => 'Sony'],
            ['name' => 'LG'],
            ['name' => 'Dell'],
            ['name' => 'HP'],
            ['name' => 'Lenovo'],
            ['name' => 'Other'],
        ];
        foreach ($brands as $brandData) {
            \App\Models\Brand::create([
                'name' => $brandData['name'],
            ]);
        }
    }
}

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
        $brands = ['Apple', 'Samsung', 'Nike', 'Adidas', 'Sony', 'Zara', 'H&M', 'Other'];
        foreach ($brands as $brand) {
            \App\Models\Brand::create([
                'name' => $brand,
                'slug' => \Illuminate\Support\Str::slug($brand),
            ]);
        }
    }
}

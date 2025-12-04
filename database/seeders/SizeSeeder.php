<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'];
        foreach ($sizes as $size) {
            \App\Models\Size::create([
                'name' => $size,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Green', 'hex_code' => '#00FF00'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
            ['name' => 'Pink', 'hex_code' => '#FFC0CB'],
            ['name' => 'Brown', 'hex_code' => '#A52A2A'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
            ['name' => 'Beige', 'hex_code' => '#F5F5DC'],
            ['name' => 'Navy', 'hex_code' => '#000080'],
            ['name' => 'Maroon', 'hex_code' => '#800000'],
            ['name' => 'Teal', 'hex_code' => '#008080'],
            ['name' => 'Olive', 'hex_code' => '#808000'],
            ['name' => 'Silver', 'hex_code' => '#C0C0C0'],
            ['name' => 'Gold', 'hex_code' => '#FFD700'],
        ];

        foreach ($colors as $color) {
            Color::create([
                'name' => $color['name'],
                'hex_code' => $color['hex_code'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Cairo',
            'Alexandria',
            'Giza',
            'Port Said',
            'Suez',
            'Luxor',
            'Aswan',
            'Mansoura',
            'Tanta',
            'Asyut',
            'Ismailia',
            'Faiyum',
            'Zagazig',
            'Damietta',
            'Ashmoun',
            'Qena',
            'Sohag',
            'Hurghada',
            'Sharm El Sheikh',
            '6th of October City',
            'New Cairo',
            'Sheikh Zayed',
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city,
            ]);
        }
    }
}

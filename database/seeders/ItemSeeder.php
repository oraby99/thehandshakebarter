<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item;
use App\Models\Category;
use App\Models\SubCategory;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $phones = SubCategory::where('name', 'Phones')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $sofas = SubCategory::where('name', 'Sofas')->first();

        $items = [
            [
                'user_id' => 1,
                'category_id' => $electronics->id,
                'sub_category_id' => $phones->id,
                'title' => 'iPhone 12 Pro',
                'description' => 'Excellent condition iPhone 12 Pro, 128GB. Includes original box and charger.',
                'condition_id' => 1,
                'city_id' => 1,
                'color_id' => 1, // Black
                'item_status_id' => 1,
            ],
            [
                'user_id' => 2,
                'category_id' => $furniture->id,
                'sub_category_id' => $sofas->id,
                'title' => 'Modern Gray Sofa',
                'description' => 'Comfortable 3-seater sofa in great condition. Perfect for living room.',
                'condition_id' => 2,
                'city_id' => 1,
                'color_id' => 11, // Gray
                'item_status_id' => 1,
            ],
            [
                'user_id' => 1,
                'category_id' => $electronics->id,
                'sub_category_id' => $phones->id,
                'title' => 'Samsung Galaxy S21',
                'description' => 'Mint condition Samsung Galaxy S21. Barely used, comes with case.',
                'condition_id' => 2,
                'city_id' => 1,
                'color_id' => 2, // White
                'item_status_id' => 1,
            ],
            [
                'user_id' => 3,
                'category_id' => $furniture->id,
                'sub_category_id' => $sofas->id,
                'title' => 'Vintage Leather Armchair',
                'description' => 'Classic vintage leather armchair. Some wear but very comfortable.',
                'condition_id' => 1,
                'city_id' => 1,
                'color_id' => 10, // Brown
                'item_status_id' => 1,
            ],
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}

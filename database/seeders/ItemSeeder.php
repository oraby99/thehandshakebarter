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
        $electronics = Category::where('slug', 'electronics')->first();
        $phones = SubCategory::where('slug', 'phones')->first();
        $furniture = Category::where('slug', 'furniture')->first();
        $sofas = SubCategory::where('slug', 'sofas')->first();

        $items = [
            [
                'user_id' => 1,
                'category_id' => $electronics->id,
                'sub_category_id' => $phones->id,
                'title' => 'iPhone 12 Pro',
                'description' => 'Excellent condition iPhone 12 Pro, 128GB. Includes original box and charger.',
                'condition' => 'used',
                'estimated_value' => 600.00,
                'location_city' => 'New York',
                'location_area' => 'Manhattan',
                'status' => 'active',
                'is_featured' => true,
                'is_visible' => true,
            ],
            [
                'user_id' => 2,
                'category_id' => $furniture->id,
                'sub_category_id' => $sofas->id,
                'title' => 'Modern Gray Sofa',
                'description' => 'Comfortable 3-seater sofa in great condition. Perfect for living room.',
                'condition' => 'like_new',
                'estimated_value' => 450.00,
                'location_city' => 'Los Angeles',
                'location_area' => 'Downtown',
                'status' => 'active',
                'is_featured' => false,
                'is_visible' => true,
            ],
            [
                'user_id' => 1,
                'category_id' => $electronics->id,
                'sub_category_id' => $phones->id,
                'title' => 'Samsung Galaxy S21',
                'description' => 'Mint condition Samsung Galaxy S21. Barely used, comes with case.',
                'condition' => 'like_new',
                'estimated_value' => 500.00,
                'location_city' => 'New York',
                'location_area' => 'Brooklyn',
                'status' => 'active',
                'is_featured' => false,
                'is_visible' => true,
            ],
            [
                'user_id' => 3,
                'category_id' => $furniture->id,
                'sub_category_id' => $sofas->id,
                'title' => 'Vintage Leather Armchair',
                'description' => 'Classic vintage leather armchair. Some wear but very comfortable.',
                'condition' => 'used',
                'estimated_value' => 200.00,
                'location_city' => 'Chicago',
                'location_area' => 'North Side',
                'status' => 'active',
                'is_featured' => false,
                'is_visible' => true,
            ],
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}

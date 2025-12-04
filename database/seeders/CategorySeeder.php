<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'subcategories' => ['Phones', 'Laptops', 'Tablets', 'Cameras', 'Gaming Consoles']
            ],
            [
                'name' => 'Furniture',
                'subcategories' => ['Sofas', 'Tables', 'Chairs', 'Beds', 'Storage']
            ],
            [
                'name' => 'Fashion',
                'subcategories' => ['Clothing', 'Shoes', 'Bags', 'Accessories', 'Jewelry']
            ],
            [
                'name' => 'Books & Media',
                'subcategories' => ['Books', 'DVDs', 'Music', 'Magazines', 'Comics']
            ],
            [
                'name' => 'Sports & Outdoors',
                'subcategories' => ['Gym Equipment', 'Bikes', 'Camping Gear', 'Sports Gear', 'Outdoor Furniture']
            ],
            [
                'name' => 'Home & Garden',
                'subcategories' => ['Appliances', 'Tools', 'Decor', 'Kitchen', 'Garden Equipment']
            ],
            [
                'name' => 'Toys & Games',
                'subcategories' => ['Action Figures', 'Board Games', 'Puzzles', 'Educational Toys', 'Remote Control']
            ],
            [
                'name' => 'Collectibles & Art',
                'subcategories' => ['Artwork', 'Antiques', 'Coins', 'Stamps', 'Trading Cards']
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'image' => null, // Can be updated later with actual images
            ]);

            foreach ($categoryData['subcategories'] as $subName) {
                $category->subCategories()->create([
                    'name' => $subName,
                    'image' => null, // Can be updated later with actual images
                ]);
            }
        }
    }
}

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
                'slug' => Str::slug($categoryData['name']),
                'sort_order' => 0,
                'is_active' => true,
            ]);

            foreach ($categoryData['subcategories'] as $index => $subName) {
                $category->subCategories()->create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }
    }
}

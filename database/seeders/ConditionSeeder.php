<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = ['New', 'Like New', 'Used', 'Refurbished'];
        foreach ($conditions as $condition) {
            \App\Models\Condition::create([
                'name' => $condition,
                'slug' => \Illuminate\Support\Str::slug($condition),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Active', 'Pending', 'Sold', 'Inactive'];
        foreach ($statuses as $status) {
            \App\Models\ItemStatus::create([
                'name' => $status,
            ]);
        }
    }
}

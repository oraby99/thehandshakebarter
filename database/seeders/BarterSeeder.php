<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barter;
use App\Models\Item;
use App\Models\User;

class BarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have enough data
        $user1 = User::find(1);
        $user2 = User::find(2);

        if (!$user1 || !$user2) {
            return;
        }

        $item1 = Item::where('user_id', 1)->first();
        $item2 = Item::where('user_id', 2)->first();

        if (!$item1 || !$item2) {
            return;
        }

        // Create a pending barter
        $pendingBarter = Barter::create([
            'requester_id' => $user1->id,
            'receiver_id' => $user2->id,
            'requester_item_id' => $item1->id,
            'receiver_item_id' => $item2->id,
            'status' => 'pending',
        ]);

        // Create conversation for pending barter
        \App\Models\Conversation::create([
            'barter_id' => $pendingBarter->id,
        ]);

        // Create an accepted barter
        $acceptedBarter = Barter::create([
            'requester_id' => $user2->id,
            'receiver_id' => $user1->id,
            'requester_item_id' => $item2->id,
            'receiver_item_id' => $item1->id,
            'status' => 'accepted',
        ]);

        // Create conversation for accepted barter
        \App\Models\Conversation::create([
            'barter_id' => $acceptedBarter->id,
        ]);
    }
}

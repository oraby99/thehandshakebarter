<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'description' => 'Perfect for casual traders. Get started with limited trades per month.',
                'duration_days' => 30,
                'price' => 9.99,
                'currency' => 'USD',
                'benefits' => json_encode([
                    '5 free trades per month',
                    'Basic support',
                    'Standard listing visibility'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'description' => 'For active traders. More trades and better visibility.',
                'duration_days' => 30,
                'price' => 19.99,
                'currency' => 'USD',
                'benefits' => json_encode([
                    '20 free trades per month',
                    'Priority support',
                    'Featured listings',
                    'Advanced search filters'
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'description' => 'Unlimited trading for power users.',
                'duration_days' => 365,
                'price' => 99.99,
                'currency' => 'USD',
                'benefits' => json_encode([
                    'Unlimited trades',
                    '24/7 Premium support',
                    'Top featured listings',
                    'Advanced analytics',
                    'Early access to new features'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Subscription::create($plan);
        }
    }
}

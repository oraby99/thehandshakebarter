<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Subscription::where('is_active', true)->get();

        return response()->json([
            'data' => SubscriptionResource::collection($plans)
        ]);
    }

    public function current()
    {
        $subscription = Auth::user()->activeSubscription;

        if (!$subscription) {
            return response()->json([
                'data' => null,
                'message' => 'No active subscription'
            ]);
        }

        return response()->json([
            'data' => new SubscriptionResource($subscription->plan),
            'details' => $subscription
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscriptions,id',
            'payment_method' => 'required|string'
        ]);

        $plan = Subscription::findOrFail($request->plan_id);

        // Mock payment processing
        // In a real app, you would integrate Stripe/PayPal here

        $userSubscription = UserSubscription::create([
            'user_id' => Auth::id(),
            'subscription_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration_days),
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'Subscribed successfully',
            'data' => $userSubscription
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Auth::user()->payments()->latest()->paginate(20);

        return response()->json([
            'data' => PaymentResource::collection($payments)
        ]);
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.50',
            'currency' => 'required|string|size:3',
            'payment_method' => 'required|string',
            'barter_id' => 'nullable|exists:barters,id',
            'subscription_plan_id' => 'nullable|exists:subscriptions,id',
        ]);

        // Mock payment initiation
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'barter_id' => $request->barter_id,
            'subscription_plan_id' => $request->subscription_plan_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'status' => 'completed', // Auto-complete for demo
            'provider_reference' => 'PAY-' . uniqid(),
            'metadata' => ['demo' => true],
        ]);

        return response()->json([
            'message' => 'Payment processed successfully',
            'data' => new PaymentResource($payment)
        ]);
    }
}

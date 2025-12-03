<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Barter;
use App\Models\Item;
use App\Http\Resources\BarterResource;
use Illuminate\Support\Facades\Auth;

class BarterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $barters = Barter::with(['requester', 'receiver', 'requesterItem', 'receiverItem'])
            ->where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->latest()
            ->paginate(20);

        return BarterResource::collection($barters);
    }

    public function show(Barter $barter)
    {
        $this->authorizeBarter($barter);
        $barter->load(['requester', 'receiver', 'requesterItem', 'receiverItem']);
        return new BarterResource($barter);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'requester_item_id' => 'required|exists:items,id',
            'receiver_item_id' => 'required|exists:items,id',
        ]);

        // Validate items ownership
        $requesterItem = Item::findOrFail($validated['requester_item_id']);
        if ($requesterItem->user_id !== Auth::id()) {
            return response()->json(['message' => 'You do not own this item'], 403);
        }

        $receiverItem = Item::findOrFail($validated['receiver_item_id']);
        if ($receiverItem->user_id !== $validated['receiver_id']) {
            return response()->json(['message' => 'Receiver does not own this item'], 403);
        }

        $barter = Barter::create([
            'requester_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'requester_item_id' => $validated['requester_item_id'],
            'receiver_item_id' => $validated['receiver_item_id'],
            'status' => 'pending',
        ]);

        return new BarterResource($barter);
    }

    public function accept(Barter $barter)
    {
        // Only the receiver can accept
        if ($barter->receiver_id !== Auth::id()) {
            return response()->json([
                'message' => 'Only the receiver can accept this barter'
            ], 403);
        }

        $barter->update(['status' => 'accepted']);
        return new BarterResource($barter);
    }

    public function reject(Barter $barter)
    {
        // Either party can reject
        if ($barter->receiver_id !== Auth::id() && $barter->requester_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to reject this barter'
            ], 403);
        }

        $barter->update(['status' => 'rejected']);
        return new BarterResource($barter);
    }

    public function cancel(Barter $barter)
    {
        if ($barter->requester_id !== Auth::id()) {
            abort(403);
        }
        $barter->update(['status' => 'cancelled']);
        return new BarterResource($barter);
    }

    public function confirmReceived(Barter $barter)
    {
        $this->authorizeBarter($barter);
        // Logic to track who received. Need extra fields or status flow.
        $barter->update(['status' => 'completed']);
        return new BarterResource($barter);
    }

    public function reportNotReceived(Barter $barter, Request $request)
    {
        $this->authorizeBarter($barter);
        $barter->update(['status' => 'disputed']);
        return new BarterResource($barter);
    }

    public function rate(Barter $barter, Request $request)
    {
        $this->authorizeBarter($barter);

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Determine who is being rated
        $toUserId = ($barter->requester_id === Auth::id()) ? $barter->receiver_id : $barter->requester_id;

        // Check if already rated
        $existingRating = \App\Models\Rating::where('barter_id', $barter->id)
            ->where('from_user_id', Auth::id())
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'You have already rated this barter'], 400);
        }

        \App\Models\Rating::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $toUserId,
            'barter_id' => $barter->id,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Rating submitted successfully']);
    }

    private function authorizeBarter(Barter $barter)
    {
        if ($barter->requester_id !== Auth::id() && $barter->receiver_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to perform this action.',
                'debug' => [
                    'your_user_id' => Auth::id(),
                    'allowed_users' => [$barter->requester_id, $barter->receiver_id],
                    'barter_id' => $barter->id
                ]
            ], 403)->throwResponse();
        }
    }
}

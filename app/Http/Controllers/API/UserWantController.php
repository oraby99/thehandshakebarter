<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserWant;
use Illuminate\Support\Facades\Auth;

class UserWantController extends Controller
{
    public function index()
    {
        $wants = UserWant::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return response()->json($wants);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
            'size_id' => 'nullable|exists:sizes,id',
            'brand_id' => 'nullable|exists:brands,id',
            'color_id' => 'nullable|exists:colors,id',
            'images' => 'nullable|array',
            'keywords' => 'nullable|string',
        ]);

        $want = UserWant::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        // Find matching items
        $matchingItems = \App\Models\Item::query()
            ->where('category_id', $want->category_id)
            ->where('user_id', '!=', Auth::id())
            ->whereHas('itemStatus', function ($query) {
                $query->where('name', 'Active');
            })
            ->when($want->sub_category_id, function ($query) use ($want) {
                $query->where('sub_category_id', $want->sub_category_id);
            })
            ->when($want->condition_id, function ($query) use ($want) {
                $query->where('condition_id', $want->condition_id);
            })
            ->when($want->size_id, function ($query) use ($want) {
                $query->where('size_id', $want->size_id);
            })
            ->when($want->brand_id, function ($query) use ($want) {
                $query->where('brand_id', $want->brand_id);
            })
            ->when($want->color_id, function ($query) use ($want) {
                $query->where('color_id', $want->color_id);
            })
            ->with(['user', 'condition', 'size', 'brand', 'itemStatus', 'primaryImage'])
            ->latest()
            ->get();

        return response()->json([
            'want' => $want->load(['category', 'subCategory', 'condition', 'size', 'brand']),
            'matching_items' => $matchingItems
        ], 201);
    }

    public function show(UserWant $userWant)
    {
        return response()->json($userWant->load(['user', 'category', 'subCategory', 'condition', 'size', 'brand', 'color']));
    }

    public function update(Request $request, UserWant $userWant)
    {
        if ($userWant->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
            'size_id' => 'nullable|exists:sizes,id',
            'brand_id' => 'nullable|exists:brands,id',
            'color_id' => 'nullable|exists:colors,id',
            'images' => 'nullable|array',
            'keywords' => 'nullable|string',
        ]);

        $userWant->update($validated);

        return response()->json($userWant->load(['category', 'subCategory', 'condition', 'size', 'brand']));
    }

    public function destroy(UserWant $userWant)
    {
        if ($userWant->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $userWant->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

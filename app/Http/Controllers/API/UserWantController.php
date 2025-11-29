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
            'condition' => 'nullable|string',
            'size' => 'nullable|string',
            'brand' => 'nullable|string',
            'color' => 'nullable|string',
            'images' => 'nullable|array',
            'keywords' => 'nullable|string',
        ]);

        $want = UserWant::create([
            'user_id' => Auth::id(),
            ...$validated
        ]);

        return response()->json($want, 201);
    }

    public function show(UserWant $userWant)
    {
        return response()->json($userWant->load(['user', 'category', 'subCategory']));
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
            'condition' => 'nullable|string',
            'size' => 'nullable|string',
            'brand' => 'nullable|string',
            'color' => 'nullable|string',
            'images' => 'nullable|array',
            'keywords' => 'nullable|string',
        ]);

        $userWant->update($validated);

        return response()->json($userWant);
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

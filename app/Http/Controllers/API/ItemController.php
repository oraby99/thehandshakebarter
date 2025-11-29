<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['user', 'category', 'primaryImage'])
            ->where('status', 'active')
            ->where('is_visible', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('city')) {
            $query->where('location_city', $request->city);
        }

        $items = $query->latest()->paginate(20);

        return ItemResource::collection($items);
    }

    public function show(Item $item)
    {
        $item->load(['user', 'category', 'images', 'subcategory']);
        return new ItemResource($item);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'condition' => 'required|string',
            'size' => 'nullable|string',
            'brand' => 'nullable|string',
            'color' => 'nullable|string',
            'location_city' => 'nullable|string',
            'location_area' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $item = Auth::user()->items()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('items', 'public');
                $item->images()->create([
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return new ItemResource($item);
    }

    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'exists:categories,id',
            'title' => 'string|max:255',
            'description' => 'string',
            'condition' => 'string',
            'size' => 'nullable|string',
            'brand' => 'nullable|string',
            'color' => 'nullable|string',
            'status' => 'in:draft,active,archived',
        ]);

        $item->update($validated);

        return new ItemResource($item);
    }

    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }

    public function favorite(Item $item)
    {
        Auth::user()->favorites()->syncWithoutDetaching([$item->id]);
        return response()->json(['message' => 'Item favorited']);
    }

    public function unfavorite(Item $item)
    {
        Auth::user()->favorites()->detach($item->id);
        return response()->json(['message' => 'Item unfavorited']);
    }
}

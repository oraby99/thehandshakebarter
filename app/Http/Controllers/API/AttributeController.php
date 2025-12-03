<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\City;
use App\Models\ItemStatus;
use App\Models\Condition;
use App\Models\Size;

class AttributeController extends Controller
{
    public function brands()
    {
        return response()->json([
            'data' => Brand::select('id', 'name', 'slug')->get()
        ]);
    }

    public function colors()
    {
        return response()->json([
            'data' => Color::select('id', 'name', 'slug', 'hex_code')->get()
        ]);
    }

    public function cities()
    {
        return response()->json([
            'data' => City::select('id', 'name', 'slug')->get()
        ]);
    }

    public function itemStatuses()
    {
        return response()->json([
            'data' => ItemStatus::select('id', 'name', 'slug')->get()
        ]);
    }

    public function conditions()
    {
        return response()->json([
            'data' => Condition::select('id', 'name', 'slug')->get()
        ]);
    }

    public function sizes()
    {
        return response()->json([
            'data' => Size::select('id', 'name', 'slug')->get()
        ]);
    }
}

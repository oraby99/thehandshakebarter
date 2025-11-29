<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('is_published', true)->get();

        return response()->json([
            'data' => PageResource::collection($pages)
        ]);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return response()->json([
            'data' => new PageResource($page)
        ]);
    }
}

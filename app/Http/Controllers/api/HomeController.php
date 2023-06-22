<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {

         //  $category= DB::table('category')->get();

         $categories = Category::with('products')->get();
         $categories = HomeResource::collection($categories);

         return response()->json([
            'status' => 201,
            'data'   => $categories,
        ], 201);
    }
}

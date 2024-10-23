<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories retrieved successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        try {
            $category = Category::create($request->all());
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category created successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'Category retrieved successfully',
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);
        try {
            $category->update($request->all());
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}

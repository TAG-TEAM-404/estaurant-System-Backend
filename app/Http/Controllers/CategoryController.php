<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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


        public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create($request->validated());
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category created successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
            return response()->json([
                'data' => new CategoryResource($category),
                'message' => 'Category updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => new CategoryResource($category),
            'message' => 'Category retrieved successfully',
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}

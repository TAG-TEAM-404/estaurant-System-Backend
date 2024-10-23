<?php

namespace App\Http\Controllers;
    
    use App\Models\Menu;
    use Illuminate\Http\Request;
    use App\Http\Resources\MenuResource;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    class MenuController extends Controller
    {
        public function index()
        {
            $menus = Menu::with('category')->get();
            return response()->json([
                'data' => MenuResource::collection($menus),
                'message' => 'Menus retrieved successfully',
            ], 200);
        }
    
        public function store(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric',
                'status' => 'required|in:available,unavailable',
                'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048'
            ]);

            try {
                $data = $request->all();
                if ($request->hasFile('image')) {
                    $filePath = $request->file('image')->store('images', 'public');
                    $data['image'] = $filePath;
                }
    
                $menu = Menu::create($data);
                return response()->json([
                    'data' => new MenuResource($menu),
                    'message' => 'Menu created successfully',
                ], 201);
            } catch (\Exception $e) {
                Log::error('Menu creation failed: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to create menu: ' . $e->getMessage()], 500);
            }
        }
    
        public function show(Menu $menu)
        {
            return response()->json([
                'data' => new MenuResource($menu),
                'message' => 'Menu retrieved successfully',
            ], 200);
        }
    
        public function update(Request $request, Menu $menu)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric',
                'status' => 'required|in:available,unavailable',
                'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048'
            ]);
    
            try {
                $data = $request->all();
                if ($request->hasFile('image')) {
                    $filePath = $request->file('image')->store('images', 'public');
                    $data['image'] = $filePath;
                }
    
                $menu->update($data);
                return response()->json([
                    'data' => new MenuResource($menu),
                    'message' => 'Menu updated successfully',
                ], 200);
            } catch (\Exception $e) {
                Log::error('Menu update failed: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to update menu: ' . $e->getMessage()], 500);
            }
        }
    
        public function destroy(Menu $menu)
        {
            try {
                $menu->delete();
                return response()->json(['message' => 'Menu deleted successfully'], 200);
            } catch (\Exception $e) {
                Log::error('Menu deletion failed: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to delete menu: ' . $e->getMessage()], 500);
            }
        }

    }
    

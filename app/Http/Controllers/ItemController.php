<?php

namespace App\Http\Controllers;
    
    use App\Models\Item;
    use Illuminate\Http\Request;
    use App\Http\Resources\MenuResource;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    use App\Http\Requests\StoreItemRequest;
    use App\Http\Requests\UpdateItemRequest;
    class ItemController extends Controller
    {
        public function index()
        {
            $items = Item::with('category')->get();
            return response()->json([
                'data' => ItemResource::collection($items),
                'message' => 'Items retrieved successfully',
            ], 200);
        }
    

        public function store(StoreItemRequest $request)
        {
            try {
                $data = $request->validated();
                if ($request->hasFile('image')) {
                    $filePath = $request->file('image')->store('images', 'public');
                    $data['image'] = $filePath;
                }

                $item = Item::create($data);
                return response()->json([
                    'data' => new ItemResource($item),
                    'message' => 'Menu created successfully',
                ], 201);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to create item'], 500);
            }
        }

        public function update(UpdateMenuRequest $request, Item $item)
        {
            try {
                $data = $request->validated();
                if ($request->hasFile('image')) {
                    $filePath = $request->file('image')->store('images', 'public');
                    $data['image'] = $filePath;
                }

                $item->update($data);
                return response()->json([
                    'data' => new ItemResource($item),
                    'message' => 'Item updated successfully',
                ], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to update item'], 500);
            }
        }

        public function show(Item $item)
        {
            return response()->json([
                'data' => new ItemResource($item),
                'message' => 'Item retrieved successfully',
            ], 200);
        }
    
    
        public function destroy(Item $item)
        {
            try {
                $item->delete();
                return response()->json(['message' => 'Item deleted successfully'], 200);
            } catch (\Exception $e) {
                Log::error('Item deletion failed: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to delete item: ' . $e->getMessage()], 500);
            }
        }

    }
    

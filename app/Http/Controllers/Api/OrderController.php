<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        //dd($request);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'order_type' => 'required|in:dine-in,online,delivery',
        ]);

        // dd($request);
        DB::beginTransaction();

        try {
           
            $order = Order::create([
                'user_id' => $request->user_id,
                'table_id'=> $request->table_id,
                'order_date' => now(),
                'total_amount' => 0, 
                'type' => $request->type,
            ]);

            $totalAmount = 0;

            // dd($order);
           // dd($request->items);
            foreach ($request->items as $itemData) {
                // dd($itemData['item_id']);
                $item = Item::findOrFail($itemData['item_id']);
                $quantity = $itemData['quantity'];

                $totalAmount += $item->price * $quantity;

             
                DB::table('takes')->insert([
                    'count' => $item->price * $quantity,
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();
            // dd(new OrderResource($order));
            return response()->json([
                'success' => true,
                'data' => new OrderResource($order),
                'message' => 'Holiday created successfully',
            ], 201);
            
            

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order creation failed', 'message' => $e->getMessage()], 500);
        }
    }
}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function StoreOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'invoice_no' => 'INV-' . date('Ymd-His'),
                'total_items' => $request->total_items,
                'sub_total' => $request->total_price,
                'vat' => $request->total_price * 0.16, // 16% VAT
                'total' => $request->total_price * 1.16,
                'payment_method' => $request->payment_method,
                'pay' => $request->paying_amount,
                'change_return' => $request->change_return,
                'order_date' => now(),
                'order_status' => 'pending'
            ]);

            // Create order details
            foreach ($request->cart as $item) {
                $order->order_details()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_cost'],
                    'total' => $item['total']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order_id' => $order->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ShowOrder($id)
    {
        try {
            $order = Order::with(['customer', 'order_details.product'])
                ->findOrFail($id);

            $settings = Setting::first();

            return response()->json([
                'status' => 'success',
                'order' => $order,
                'settings' => $settings
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching order details: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching order details'
            ], 500);
        }
    }
} 
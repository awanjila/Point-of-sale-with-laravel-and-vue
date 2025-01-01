<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiOrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log incoming request
            Log::info('Incoming order request:', $request->all());

            // Validate the request
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'total_items' => 'required|numeric|min:1',
                'total_price' => 'required|numeric|min:0',
                'paying_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
                'change_return' => 'required|numeric',
                'cart' => 'required|array|min:1',
            ]);

            if ($validator->fails()) {
                Log::warning('Order validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'invoice_no' => 'INV-' . date('Ymd-His'),
                'total_items' => $request->total_items,
                'sub_total' => $request->total_price,
                'vat' => round($request->total_price * 0.16, 2),
                'total' => round($request->total_price * 1.16, 2),
                'payment_method' => $request->payment_method,
                'pay' => $request->paying_amount,
                'change_return' => $request->change_return,
                'order_date' => now(),
                'order_status' => 'completed'
            ]);

            // Log the created order
            Log::info('Order created:', $order->toArray());

            // Process cart items
            foreach ($request->cart as $item) {
                // Create order detail
                $orderDetail = $order->order_details()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_cost'],
                    'total' => $item['total']
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->update([
                        'quantity' => $product->quantity - $item['quantity']
                    ]);
                }
            }

            DB::commit();

            // Fetch the complete order with relationships
            $completeOrder = Order::with(['customer', 'order_details.product'])
                ->findOrFail($order->id);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'order' => $completeOrder
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => 'Error creating order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
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
            Log::error('Error fetching order: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching order details'
            ], 500);
        }
    }
} 
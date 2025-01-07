<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('backoffice.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'order_details.product'])
            ->findOrFail($id);
            
        return view('backoffice.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('order_details')->findOrFail($id);

            // Restore product quantities
            foreach ($order->order_details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->update([
                        'quantity' => $product->quantity + $detail->quantity
                    ]);
                }
            }

            // Delete order details and order
            $order->order_details()->delete();
            $order->delete();

            DB::commit();

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting order: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('order_details')->findOrFail($id);
            $oldStatus = $order->order_status;
            $newStatus = $request->order_status;

            // Update order status
            $order->update([
                'order_status' => $newStatus
            ]);

            // If status is changed to 'completed', update stock
            if ($oldStatus !== 'completed' && $newStatus === 'completed') {
                foreach ($order->order_details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        if ($product->quantity < $detail->quantity) {
                            DB::rollBack();
                            return redirect()
                                ->back()
                                ->with('error', "Insufficient stock for product: {$product->name}");
                        }

                        $product->update([
                            'quantity' => $product->quantity - $detail->quantity
                        ]);
                    }
                }
            }
            // If status is changed from 'completed' to something else, restore stock
            elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
                foreach ($order->order_details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        $product->update([
                            'quantity' => $product->quantity + $detail->quantity
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Order status updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function ShowOrder($id)
    {
        try {
            $order = Order::with([
                'customer', 
                'order_details.product'
            ])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'order' => $order,
                'currency' => 'KES'
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching order details: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }
    }

    public function StoreOrder(Request $request)
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
                'total_products' => $request->total_items,
                'sub_total' => $request->total_price,
                'vat' => round($request->total_price * 0.16, 2),
                'total' => round($request->total_price),
                'payment_method' => $request->payment_method,
                'pay' => $request->paying_amount,
                'due' => round($request->total_price * 1.16, 2) - $request->paying_amount,
                'order_date' => now(),
                'order_status' => 'pending' // Set initial status as pending
            ]);

            // Log the created order
            Log::info('Order created:', $order->toArray());

            // Process cart items
            foreach ($request->cart as $item) {
                // Create order detail
                $orderDetail = $order->order_details()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total' => $item['total']
                ]);
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
    }//endmethod

    public function GetOrders()
    {
        try {
            // Fetch orders with customer relationship, ordered by most recent first
            $orders = Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->get();

            // Get default currency from settings (or use a default)
            $currency = 'KES';

            return response()->json([
                'status' => 'success',
                'orders' => $orders,
                'currency' => $currency
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching orders: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }//endmethod

    public function ViewOrder($id)
    {
        try {
            $order = Order::with(['customer', 'order_details.product'])
                ->findOrFail($id);
                
            if (request()->expectsJson()) {
                return response()->json($order);
            }
            
            return view('backoffice.order.view_order', compact('id'));
        } catch (\Exception $e) {
            Log::error('Error in ViewOrder method: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            
            return redirect()->route('all.orders')
                ->with('error', 'Unable to find the specified order');
        }
    }//endmethod

    public function DeleteOrder($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('order_details')->findOrFail($id);

            // Restore product quantities
            foreach ($order->order_details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->update([
                        'quantity' => $product->quantity + $detail->quantity
                    ]);
                }
            }

            // Delete order details and order
            $order->order_details()->delete();
            $order->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting order: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function CompleteOrder($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('order_details')->findOrFail($id);

            // Check if order is already completed
            if ($order->order_status === 'completed') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order is already completed'
                ], 400);
            }

            // Track stock changes for reporting
            $stockDetails = [];

            // Update product quantities
            foreach ($order->order_details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    // Detailed product investigation
                    $productData = Product::where('id', $detail->product_id)->first();
                    
                    Log::error('Detailed Product Investigation', [
                        'product_id' => $detail->product_id,
                        'product_exists' => $product ? 'Yes' : 'No',
                        'product_data' => $productData ? $productData->toArray() : 'No data found',
                        'database_record' => DB::table('products')
                            ->where('id', $detail->product_id)
                            ->first()
                    ]);

                    // Use product_store if quantity is null
                    $currentStock = $product->quantity ?? $product->product_store ?? 0;

                    // Log detailed product information for debugging
                    Log::info('Product Stock Check', [
                        'product_id' => $detail->product_id,
                        'product_name' => $product->name ?? 'Unknown',
                        'current_quantity' => $product->quantity,
                        'current_product_store' => $product->product_store,
                        'calculated_stock' => $currentStock,
                        'order_quantity' => $detail->quantity
                    ]);

                    $originalStock = $currentStock;
                    
                    // Ensure sufficient stock
                    if ($currentStock < $detail->quantity) {
                        throw new \Exception(sprintf(
                            "Insufficient stock for product ID %d: %s (Available: %d, Required: %d)", 
                            $detail->product_id,
                            $product->name ?? 'Unknown Product', 
                            $currentStock, 
                            $detail->quantity
                        ));
                    }

                    // Calculate new stock
                    $newStock = $currentStock - $detail->quantity;

                    // Update product with both quantity and product_store
                    $updateData = [
                        'quantity' => $newStock,
                        'product_store' => $newStock
                    ];

                    // Attempt to update
                    $updateResult = $product->update($updateData);

                    // Log update attempt
                    Log::info('Stock Update Attempt', [
                        'product_id' => $detail->product_id,
                        'update_data' => $updateData,
                        'update_successful' => $updateResult
                    ]);

                    // Log stock changes
                    $stockDetails[] = [
                        'product_id' => $detail->product_id,
                        'product_name' => $product->product_name ?? 'Unknown',
                        'original_stock' => $originalStock,
                        'new_stock' => $newStock,
                        'reduced_by' => $detail->quantity
                    ];
                } else {
                    Log::error('Product not found', [
                        'product_id' => $detail->product_id,
                        'order_id' => $order->id
                    ]);
                }
            }

            // Update order status
            $order->update([
                'order_status' => 'completed'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order completed successfully',
                'stockDetails' => $stockDetails
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error completing order: ' . $e->getMessage());
            Log::error('Exception Trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }//endmethod

    public function AllOrders(){
        $orders = Order::latest()->get();
        return view('backoffice.order.all_orders',compact('orders'));
    }//endmethod


    public function SalesReport(){
        // pass
    return view('backoffice.sales.salesreport');
    }//endmethod
}

<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    // Common purchase statuses and their meanings
    public static $STATUSES = [
        'pending' => 'Order created but not yet received',
        'received' => 'Products have been received',
        'completed' => 'Purchase order fully processed and closed',
        'cancelled' => 'Purchase order was cancelled',
        'returned' => 'Products were returned to supplier'
    ];

    public function AllPurchase(){
        $purchases = Purchase::latest()->get();
        return view('backoffice.purchase.list_purchase',compact('purchases'));
    }

    public function AddPurchase(){
        return view('backoffice.purchase.add_purchase');
    }

    public function StorePurchase(Request $request)
    {
        // Validate the request
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'total_products' => 'required|integer|min:1',
            'payment_status' => 'required|in:paid,partial,pending',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Create Purchase
            $purchase = Purchase::create([
                'purchase_no' => $request->purchase_no,
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
                'total_products' => $request->total_products,
                'payment_status' => $request->payment_status,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Create Purchase Items and Update Product Stock
            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['total']
                ]);

                // Update Product Stock
                $product = Product::find($item['product_id']);
                $product->update([
                    'product_store' => $product->product_store + $item['quantity'],
                    'buying_price' => $item['unit_price'], // Update latest buying price
                    'updated_at' => Carbon::now()
                ]);
            }

            DB::commit();

            // For API requests
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Purchase created successfully',
                    'data' => $purchase->load('items')
                ], 201);
            }

            // For web requests
            return redirect()
                ->route('all.purchase')
                ->with('success', 'Purchase created successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            // For API requests
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error creating purchase: ' . $e->getMessage()
                ], 500);
            }

            // For web requests
            return redirect()
                ->back()
                ->with('error', 'Error creating purchase: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Helper method to generate purchase number
    private function generatePurchaseNo()
    {
        $latest = Purchase::latest()->first();
        
        if (!$latest) {
            return 'PUR-' . date('Ymd') . '001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->purchase_no);
        $number = sprintf('%03d', $string + 1);
        
        return 'PUR-' . date('Ymd') . $number;
    }

    public function GetPurchases()
    {
        try {
            // Get currency from the settings table using the new structure
            try {
                $settings = Setting::first();
                $currencySymbol = $settings ? $settings->currency : 'KES'; // Default to KES if no settings
            } catch (\Exception $e) {
                Log::error('Error fetching currency setting: ' . $e->getMessage());
                $currencySymbol = 'KES'; // Fallback currency
            }

            $purchases = Purchase::with('supplier')
                ->latest()
                ->get()
                ->map(function ($purchase) use ($currencySymbol) {
                    return [
                        'id' => $purchase->id,
                        'purchase_no' => $purchase->purchase_no,
                        'purchase_date' => $purchase->purchase_date,
                        'supplier' => [
                            'id' => $purchase->supplier->id ?? null,
                            'name' => $purchase->supplier->name ?? 'N/A'
                        ],
                        'total_products' => $purchase->total_products,
                        'total_amount' => $purchase->total_amount,
                        'currency' => $currencySymbol,
                        'payment_status' => $purchase->payment_status,
                        'paid_amount' => $purchase->paid_amount,
                        'due_amount' => $purchase->due_amount,
                        'status' => $purchase->status,
                    ];
                });

            return response()->json([
                'purchases' => $purchases,
                'currency' => $currencySymbol
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in GetPurchases: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching purchases: ' . $e->getMessage()
            ], 500);
        }
    }

    // You can add a method to update the status
    public function UpdatePurchaseStatus(Request $request, $id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:pending,received,completed,cancelled,returned'
            ]);

            $purchase->update([
                'status' => $request->status
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase status updated successfully',
                'purchase' => $purchase
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating purchase status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ShowPurchase($id)
    {
        try {
            $purchase = Purchase::with(['supplier', 'items.product'])
                ->findOrFail($id);

            $settings = Setting::first();
            $currency = $settings ? $settings->currency : 'KES';

            return response()->json([
                'purchase' => $purchase,
                'currency' => $currency
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching purchase details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function CompletePurchase($id)
    {
        try {
            DB::beginTransaction();

            $purchase = Purchase::with('items.product')->findOrFail($id);
            
            if ($purchase->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only pending purchases can be completed'
                ], 400);
            }

            // Update each product's stock
            foreach ($purchase->items as $item) {
                $product = $item->product;
                
                if (!$product) {
                    throw new \Exception("Product not found for purchase item");
                }

                // Add the purchased quantity to product_store
                $product->product_store += $item->quantity;
                $product->save();

                // Optionally, you might want to update the buying price
                // $product->buying_price = $item->unit_price;
                // $product->save();
            }
            

            // Mark purchase as completed
            $purchase->update(['status' => 'completed']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase completed and stock updated successfully',
                'purchase' => $purchase
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error completing purchase: ' . $e->getMessage()
            ], 500);
        }
    }

    public function DeletePurchase($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            
            // Don't allow deletion of completed purchases
            if ($purchase->status === 'completed') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Completed purchases cannot be deleted'
                ], 400);
            }

            $purchase->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Purchase deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting purchase: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ViewPurchase($id)
    {
        return view('backoffice.purchase.view_purchase', compact('id'));
    }
}

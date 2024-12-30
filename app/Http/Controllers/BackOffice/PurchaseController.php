<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
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
}

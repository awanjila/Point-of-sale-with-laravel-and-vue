<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::query();

            // Properly format and validate dates
            if ($request->has('start_date') && $request->start_date) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $query->whereDate('order_date', '>=', $startDate);
            }

            if ($request->has('end_date') && $request->end_date) {
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereDate('order_date', '<=', $endDate);
            }

            $orders = $query
                ->select([
                    DB::raw('DATE(order_date) as date'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(COALESCE(total_products, 0)) as total_items'),
                    DB::raw('SUM(COALESCE(vat, 0)) as total_tax'),
                    DB::raw('SUM(COALESCE(total, 0)) as total_amount')
                ])
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($order) {
                    return [
                        'order_date' => $order->date,
                        'order_count' => (int)$order->order_count,
                        'products_sold' => (int)$order->total_items,
                        'tax' => (float)$order->total_tax,
                        'total' => (float)$order->total_amount
                    ];
                });

            return response()->json($orders);
        } catch (\Exception $e) {
            \Log::error('Sales report error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to fetch sales data'], 500);
        }
    }

    public function PurchaseReport(){

        return view('backoffice.purchase.purchase_report');
    }//endmethod

    public function purchaseReportAPi(Request $request)
    {
        try {
            $query = Purchase::query();

            // Add date range filters if provided
            if ($request->has('start_date') && $request->start_date) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $query->whereDate('purchase_date', '>=', $startDate);
            }
            if ($request->has('end_date') && $request->end_date) {
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereDate('purchase_date', '<=', $endDate);
            }

            $purchases = $query
                ->select([
                    DB::raw('DATE(purchases.purchase_date) as date'),
                    DB::raw('COUNT(DISTINCT purchases.id) as purchase_count'),
                    DB::raw('SUM(purchase_items.quantity) as total_items'),
                    DB::raw('SUM(purchases.total_amount) as total_amount'),
                    DB::raw('SUM(purchases.paid_amount) as paid_amount'),
                    DB::raw('SUM(purchases.due_amount) as due_amount')
                ])
                ->leftJoin('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
                ->groupBy(DB::raw('DATE(purchases.purchase_date)'))
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($purchase) {
                    return [
                        'purchase_date' => $purchase->date,
                        'purchase_count' => (int)$purchase->purchase_count,
                        'products_purchased' => (int)$purchase->total_items,
                        'total_amount' => (float)$purchase->total_amount,
                        'paid_amount' => (float)$purchase->paid_amount,
                        'due_amount' => (float)$purchase->due_amount
                    ];
                });

            return response()->json($purchases);
        } catch (\Exception $e) {
            \Log::error('Purchase report error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Failed to fetch purchase data'], 500);
        }
    }



}
<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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



}
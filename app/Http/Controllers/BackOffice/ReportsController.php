<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->select([
                DB::raw('DATE(order_date) as date'), // Extract just the date part
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_products) as total_items'),
                DB::raw('SUM(vat) as total_tax'),
                DB::raw('SUM(total) as total_amount')
            ])
            ->groupBy(DB::raw('DATE(order_date)')) // Group by date only
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'order_date' => $order->date,
                    'order_count' => $order->order_count,
                    'products_sold' => $order->total_items,
                    'tax' => $order->total_tax,
                    'total' => $order->total_amount
                ];
            });

        return response()->json($orders);
    }//endmethod
}
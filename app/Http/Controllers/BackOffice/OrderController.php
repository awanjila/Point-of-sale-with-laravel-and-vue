<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function FinalInvoice(Request $request){

        $rtotal = $request->total;
        $rpay = $request->pay;


        $mtotal = $rtotal - $rpay;


  $data=array();
  $data['customer_id'] = $request->customer_id;
  $data['order_date'] = $request->order_date;
  $data['order_status'] = $request->order_status;
  $data['total_products'] = $request->total_products;
  $data['sub_total'] = $request->sub_total;
  $data['vat'] = $request->vat;
  $data['invoice_no'] = 'EPOS'.mt_rand(10000000,99999999);
  $data['total'] = $request->total;
  $data['payment_status'] = $request->payment_status;
  $data['pay'] = $request->pay;
  $data['due'] = $mtotal;
  $data['created_at'] = Carbon::now();




  $order_id=Order::insertGetId($data);
  $contents = Cart::content();

  $pdata=array();

  foreach($contents as $content){
      $pdata['order_id'] = $order_id;
      $pdata['product_id'] = $content->id;
      $pdata['quantity'] = $content->qty;
      $pdata['unit_cost'] = $content->price;
      $pdata['total'] = $content->total;
      $pdata['created_at'] = Carbon::now();

      $insert =OrderDetails::insert($pdata);
  }//endforeach


        $notification = array(
            'message' => 'Order Completed Successfully',
            'alert-type'=> 'success'
        );

  return redirect()->route('dashboard')->with($notification);

    } //endmethod


    public function PendingOrder(){

      $orders = Order::where('order_status', 'pending')->orderBy('id', 'DESC')->get();

      return view('backoffice.order.pending_orders', compact('orders'));
    } //end method

    public function OrderDetails($order_id){
    $order = Order::where('id',$order_id)->first();

    $order_item = OrderDetails::where('order_id', $order_id)->orderBy('id', 'DESC')->get();

    return view('backoffice.order.order_details', compact('order', 'order_item'));

    } //end method


    public function OrderStatusUpdate(Request $request)
    {
        $order_id = $request->id;
        $products = OrderDetails::where('order_id', $order_id)->get();

        foreach ($products as $item) {
            $quantitySold = $item->quantity;

            Product::where('id', $item->product_id)->update([
                'product_store' => DB::raw('product_store - ' . $quantitySold),
                'sales_count' => DB::raw('sales_count + ' . $quantitySold)
            ]);
        }

        Order::findOrFail($order_id)->update(['order_status' => 'complete']);

        $notification = [
            'message' => 'Order Done Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('complete.order')->with($notification);
    }


    public function CompleteOrder(){
        $orders = Order::where('order_status', 'complete')->orderBy('id', 'DESC')->get();

        return view('backoffice.order.complete_orders', compact('orders'));

    }//endmethod

    public function StockManage(){
      $product = Product::latest()->get();
      return view('backoffice.stock.all_stock', compact('product'));

    }//endmethod


    public function OrderInvoice($id){

        $order = Order::where('id',$id)->first();
        $orderItem = OrderDetails::where('order_id', $id)->orderBy('id', 'DESC')->get();
        $pdf = Pdf::loadView('backoffice.order.order_invoice', compact("order", 'orderItem'))
            ->setPaper('a5')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),

            ]);
        return $pdf->download('invoice.pdf');
//        return view('backoffice.order.order_details', compact('order', 'order_item'));
    }//endmethod



    ////// Due Methods//////
    public function PendingDue(){

        $all_due = Order::where('due', '>', '0')->orderBy('id', 'DESC')->get();

        return view('backoffice.order.pending_due', compact('all_due'));

    }//endmethod


    public function OrderDueAjax($id){

        $order = Order::findOrFail($id);


        return response()->json($order);
    }//endmethod



    public function UpdateDue(Request $request){

        $order_id = $request->id;
        $due_amount = $request->due;
        $pay_amount =$request->pay;

        $all_order = Order::findOrfail($order_id);

        $maindue =$all_order->due;
        $mainpay =$all_order->pay;


        $paid_due = $maindue - $due_amount;

        $paid_pay = $mainpay + $pay_amount;

        Order::findOrFail($order_id)->update([
            'due' => $paid_due,
            'pay' => $paid_pay,
        ]);


        $notification = array(
            'message' => 'Due Updated Successfully',
            'alert-type'=> 'success'
        );

        return redirect()->back()->with($notification);




    }//endmethod


    ///////////////////////////////////////////// Sales /////////////////////////
    public function TodaysSales(){
        $date =date('d-F-Y');

//        dd($date);
        $today_sales = Order::where('order_date', $date)->get();
        return view('backoffice.order.today_sales', compact('today_sales'));



    } //endmethod



    public function SalesReport(Request $request){

        $this->data['start_date'] = $request->get('from_date', date('Y-m-d'));
        $this->data['to_date'] = $request->get('to_date', date('Y-m-d'));

         $this->data['sales'] = OrderDetails::select('products.product_name', 'order_details.quantity', 'order_details.unit_cost', 'order_details.total', 'orders.invoice_no', 'orders.order_date')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
           ->whereBetween('orders.created_at', [$this->data['start_date'], $this->data['to_date']])
            ->get();

           return view('backoffice.pages.reports.sales', $this->data);

    } //endmethod
}

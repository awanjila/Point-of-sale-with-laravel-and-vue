<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class POSController extends Controller
{
    public function POS(){
        $todaydate = Carbon::now();
        $product= Product::where('expire_date', '>', $todaydate)->latest()->get();
        $customer= Customer::latest()->get();
return view('backoffice.pos.pos_page', compact('product', 'customer'));
    } //END METHOD


    public function AddCart(Request $request){

        Cart::add(['id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => 10,
            'options' => ['size' => 'large']
        ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pos')->with($notification);
    }// end method

    public function AllPosItem(){
    $product_item =Cart::content();

    dd($product_item);
    }// end method

    public function CartUpdate(Request $request, $rowId){
        $qty =$request->qty;
        $update = Cart::update($rowId, $qty);

        $notification = array(
            'message' => 'Cart  Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pos')->with($notification);
    }// end method


    public function CartRemove($rowId){

        $remove =Cart::remove($rowId);

        $notification = array(
            'message' => 'Cart  Removed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pos')->with($notification);
    }// end method


    public function CreateInvoice(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $contents = Cart::content();
        $customer_id = $request->customer_id;

        $customer = Customer::where('id', $customer_id)->first();





        return view('backoffice.invoice.product_invoice', compact('contents', 'customer'));

    }//end method


    /////////////////////////////// Restaurant ////////////////////

public function POSRestaraunt(){

    $todaydate = Carbon::now();
    $product= Product::where('expire_date', '>', $todaydate)->latest()->get();
    $customer= Customer::latest()->get();
    $category = Category::latest()->get();
    return view('backoffice.pos.pos_restaraunt', compact('product', 'customer', 'category'));

}//endmethod


    public function __invoke(Request $request){
return Product::all();

    }//endmethod
}

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

    public function getProducts(Request $request)
    {
        try {
            \Log::info('Products Request Received', [
                'all_params' => $request->all(),
                'category_id' => $request->input('category_id'),
                'category_id_type' => gettype($request->input('category_id'))
            ]);

            $query = Product::query();

            // If a category is specified, filter by category
            if ($request->has('category_id')) {
                $categoryId = $request->input('category_id');
                
                \Log::info('Filtering Products', [
                    'category_id' => $categoryId,
                    'category_id_type' => gettype($categoryId)
                ]);
                
                // Verify the category exists
                $category = Category::find($categoryId);
                
                if (!$category) {
                    \Log::error('Category not found', [
                        'requested_category_id' => $categoryId,
                        'existing_category_ids' => Category::pluck('id')->toArray()
                    ]);
                    
                    return response()->json([
                        'error' => 'Category not found',
                        'requested_category_id' => $categoryId,
                        'existing_categories' => Category::all()
                    ], 404);
                }

                // Filter products by category
                $query->where('category_id', $categoryId);
            }

            // Fetch products with additional details
            $products = $query->select([
                'id', 
                'product_name', 
                'category_id', 
                'product_image', 
                'product_store', 
                'selling_price'
            ])->get();
            
            \Log::info('Products Found', [
                'count' => $products->count(),
                'category_filter' => $request->input('category_id'),
                'products' => $products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->product_name,
                        'category_id' => $product->category_id,
                        'category_id_type' => gettype($product->category_id)
                    ];
                })
            ]);

            return response()->json($products);
        } catch (\Exception $e) {
            \Log::error('Error in getProducts', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

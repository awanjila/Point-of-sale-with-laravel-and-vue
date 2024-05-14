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


class CartController extends Controller
{
    public function CartItems()
    {
        $cartItems = Cart::content(); // Retrieve cart items from your data source
        $cartCount=Cart::count();
         $cartSubtotal=Cart::subtotal();
         $cartTax=Cart::tax();
         $cartTotal=Cart::total();


   return response()->json([
        'cartItems' => $cartItems,
        'cartCount' => $cartCount,
        'cartTax'=>$cartTax,
        'cartTotal'=>$cartTotal,
        'cartSubtotal'=>$cartSubtotal

    ]);
} //endmethod


public function addToCart(Request $request){
        
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $sellingPrice = $request->input('selling_price');

        // Add the product to the cart
        Cart::add([
            'id' => $productId,
            'name' => $productName,
            'price' => $sellingPrice,
            'qty' => 1,
            'weight' => 10,
            'options' => ['size' => 'large']
        ]);

        // Return a response indicating success
        return response()->json(['message' => 'Product added to cart.']);
    } //endmethod



    public function DeleteItems($rowId){
        $remove =Cart::remove($rowId);
        return response()->json(['message' => 'Item removed from cart.']);
    }//endmethod

    public function CartUpdate(Request $request, $rowId){
        $qty =$request->qty;
        $update = Cart::update($rowId, $qty);
        $cartSubtotal = Cart::subtotal();
    $cartTax = Cart::tax();
    $cartTotal = Cart::total();

        // $notification = array(
        //     'message' => 'Cart  Updated Successfully',
        //     'alert-type' => 'success'
        // );

        return response()->json([
        'cartSubtotal' => $cartSubtotal,
        'cartTax' => $cartTax,
        'cartTotal' => $cartTotal,
    ]);
    }// end method

    public function CartCount()
{
    $cartCount = Cart::count();
    return response()->json(['cartCount' => $cartCount]);
}//endmethod


public function updateQuantity(Request $request, $rowId)
{
    $quantity = $request->input('quantity');

    // Update the quantity for the cart item with the provided rowId
    // You can update the quantity in your data store or database

    // Fetch the updated cart information (subtotal, tax, total, etc.)
    $cartSubtotal = Cart::subtotal();
    $cartTax = Cart::tax();
    $cartTotal = Cart::total();

    // Return the updated cart information as a JSON response
    return response()->json([
        'cartSubtotal' => $cartSubtotal,
        'cartTax' => $cartTax,
        'cartTotal' => $cartTotal,
    ]);
}








}

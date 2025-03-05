<?php
namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function AllCustomer(){
        $customers= Customer::latest()->get();
        return view('backoffice.customer.all_customer',compact('customers'));
    }


    public function AddCustomer(){
        $customers= Customer::latest()->get();
        return view('backoffice.customer.add_customer',compact('customers'));
    }

    public function StoreCustomer(Request $request){

        $validateData = $request->validate([
            'name'=>'required | max:200',
//            'email'=>'unique:customers| max:200',
            'phone'=>'required | max:200',
            'address'=>'required | max:400',
        ]);

//        $image =$request->file('photo');
//        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
//        Image::make($image)->resize(300,300)->save('upload/customer/'.$name_gen);
//
//        $save_url='upload/customer/'.$name_gen;

        Customer::insert([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'photo'=> 'image',
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

public function EditCustomer($id){


    $customer=Customer::findOrfail($id);

    return view('backoffice.customer.edit_customer', compact('customer'));
}//End Method

    public function UpdateCustomer(Request $request){


        $customer_id=$request->id;

        if($request->file('photo')){

            $image =$request->file('photo');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/customer/'.$name_gen);

            $save_url='upload/customer/'.$name_gen;

            Customer::findOrfail($customer_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'photo'=> $save_url,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);

        } else{
            Customer::findOrfail($customer_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);


        } //endelse


    }//End Method

    public function DetailCustomer($id){

        $customer=Customer::findOrfail($id);

        return view('backoffice.customer.details_customer', compact('customer'));

    }//End Method

    public function DeleteCustomer($id){
        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'warning'
        );

        return redirect()->back()->with($notification);
    }//endmethod




    //cartController

    public function GetCustomers(){

      

        $customers = Customer::all();

        return response()->json($customers);

    }//endmethod


    public function __invoke(Request $request){
        return Customer::all();
        
            }//endmethod



            // Store new customer
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required|string|max:255',
                'address' => 'nullable|string',
                'location' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('upload/customers', $filename, 'public');
            }

            $customer = Customer::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
                'location' => $validated['location'] ?? null,
                'photo' => $photoPath ?? 'upload/customers/default.png' // Provide a default photo path
            ]);

            return response()->json([
                'message' => 'Customer created successfully',
                'customer' => $customer
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Delete uploaded file if customer creation fails
            if (isset($photoPath) && $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            
            return response()->json([
                'message' => 'Failed to create customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }//endmethod

    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            
            \Log::info('Customer search query:', ['query' => $query]); // Add logging
            
            $customers = Customer::where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->select('id', 'name', 'phone', 'email')
            ->orderBy('name')
            ->limit(10)
            ->get();

            \Log::info('Customer search results:', ['count' => $customers->count()]); // Add logging

            return response()->json([
                'status' => 'success',
                'data' => $customers
            ]);

        } catch (\Exception $e) {
            Log::error('Error searching customers: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error searching customers'
            ], 500);
        }
    }
}



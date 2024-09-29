<?php
namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
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
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        // Create a new customer in the database
        $customer = Customer::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'] ?? null,
            'location' => $validatedData['location'] ?? null,
            'photo'=> 'image',
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Customer added successfully',
            'customer' => $customer
        ], 201);
    }//endmethod
}



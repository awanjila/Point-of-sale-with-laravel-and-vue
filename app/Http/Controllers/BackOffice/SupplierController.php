<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    public function AllSupplier(){
        $suppliers= Supplier::latest()->get();
        return view('backoffice.supplier.all_supplier',compact('suppliers'));
    }


    public function AddSupplier(){
        $suppliers= Supplier::latest()->get();
        return view('backoffice.supplier.add_supplier',compact('suppliers'));
    }

    public function StoreSupplier(Request $request){




        $validateData = $request->validate([
            'name'=>'required | max:200',
            'email'=>'required |unique:suppliers| max:200',
            'phone'=>'required | max:200',
            'address'=>'required | max:400',
            'company'=>'required | max:200',
            'location'=>'required | max:400',
            'type'=>'required | max:200',
        ]);

//        $image =$request->file('photo');
//        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
//        Image::make($image)->resize(300,300)->save('upload/supplier/'.$name_gen);
//
//        $save_url='upload/supplier/'.$name_gen;

        Supplier::insert([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'company'=> $request->company,
            'location'=> $request->location,
            'type'=> $request->type,
            'photo'=> 'image_here',
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function EditSupplier($id){


        $supplier=Supplier::findOrfail($id);

        return view('backoffice.supplier.edit_supplier', compact('supplier'));
    }//End Method

    public function UpdateSupplier(Request $request){


        $supplier_id=$request->id;

        if($request->file('photo')){

            $image =$request->file('photo');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/supplier/'.$name_gen);

            $save_url='upload/supplier/'.$name_gen;

            Supplier::findOrfail($customer_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'photo'=> $save_url,
                'created_at'=>Carbon::now(),
                'company'=> $request->company,
                'location'=> $request->location,
                'type'=> $request->type,

            ]);

            $notification = array(
                'message' => 'Supplier Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('supplier.all')->with($notification);

        } else{
            Supplier::findOrfail($customer_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'created_at'=>Carbon::now(),
                'company'=> $request->company,
                'location'=> $request->location,
                'type'=> $request->type,

            ]);

            $notification = array(
                'message' => 'Supplier Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('supplier.all')->with($notification);


        } //endelse


    }//End Method

    public function DetailSupplier($id){

        $supplier=Supplier::findOrfail($id);

        return view('backoffice.supplier.details_supplier', compact('supplier'));

    }//End Method


    public function DeleteSupplier($id){
        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'warning'
        );

        return redirect()->back()->with($notification);
    }//endmethod

    public function index(){

        $suppliers = Supplier::all();

        return response()->json($suppliers);

    }//endmethod

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:suppliers,email',
                'phone' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'type' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'location' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
                $photoPath = $photo->storeAs('upload/suppliers', $filename, 'public');
            }

            $supplier = Supplier::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'],
                'type' => $validated['type'] ?? null,
                'address' => $validated['address'] ?? null,
                'location' => $validated['location'] ?? null,
                'photo' => $photoPath ?? 'upload/suppliers/default.png'
            ]);

            return response()->json([
                'message' => 'Supplier created successfully',
                'supplier' => $supplier
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            if (isset($photoPath) && $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            
            return response()->json([
                'message' => 'Failed to create supplier',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

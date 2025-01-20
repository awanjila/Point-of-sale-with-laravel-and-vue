<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function AllEmployee(){
        $employees= Employee::latest()->get();
        return view('backoffice.employee.all_employee', compact('employees'));
    } //Endmethod

    public function AddEmployee(){
        $employees= Employee::latest()->get();
        return view('backoffice.employee.add_employee', compact('employees'));
    } //Endmethod

    public function StoreEmployee(Request $request){
        $validateData = $request->validate([
            'name'=>'required | max:200',
            'email'=>'required |unique:employees| max:200',
            'phone'=>'required | max:200',
            'address'=>'required | max:400',
            'experience'=>'required | max:200',
            'location'=>'required | max:200',
            'vacation'=>'required | max:200',
            'salary'=>'required | max:200',
        ]);

        $image =$request->file('photo');
        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/employee/'.$name_gen);

        $save_url='upload/employee/'.$name_gen;

        Employee::insert([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'experience'=> $request->experience,
            'location'=> $request->location,
            'vacation'=> $request->vacation,
            'salary'=> $request->salary,
            'photo'=> $save_url,
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Employee Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.all')->with($notification);

    }//End Method

    public function EditEmployee($id){

        $employee=Employee::findOrfail($id);

        return view('backoffice.employee.edit_employee', compact('employee'));
    }//End Method


    public function UpdateEmployee(Request $request){
        $employee_id=$request->id;

        if($request->file('photo')){

            $image =$request->file('photo');
            $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/employee/'.$name_gen);

            $save_url='upload/employee/'.$name_gen;

            Employee::findOrfail($employee_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'experience'=> $request->experience,
                'location'=> $request->location,
                'vacation'=> $request->vacation,
                'salary'=> $request->salary,
                'photo'=> $save_url,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Employee Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('employee.all')->with($notification);

        } else{
            Employee::findOrfail($employee_id)->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'address'=> $request->address,
                'experience'=> $request->experience,
                'location'=> $request->location,
                'vacation'=> $request->vacation,
                'salary'=> $request->salary,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Employee Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('employee.all')->with($notification);


        } //endelse


    } //endmethod


    public function DeleteEmployee($id)
    {

        $employee_img=Employee::findOrfail($id);
        $img=$employee_img->photo;

        unlink($img);

        Employee::findOrfail($id)->delete();

        $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//endmethod

    /**
     * Get employees who can be delivery persons
     */
    public function getDeliveryPersons()
    {
        try {
            $deliveryPersons = Employee::select('id', 'name', 'phone', 'email')
                ->orderBy('name')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $deliveryPersons
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching delivery persons: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching delivery persons'
            ], 500);
        }
    }
}



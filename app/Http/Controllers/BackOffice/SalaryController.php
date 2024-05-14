<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PaySalary;
use Illuminate\Http\Request;
use App\Models\AdvancedSalary;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function AddSalary(){

        $employees=Employee::latest()->get();

        return view('backoffice.salary.add_advance_salary', compact('employees'));

    } //endmethod


    public function AllSalary(){

        $advanced_salaries = AdvancedSalary::latest()->get();
        return view('backoffice.salary.all_advance_salary', compact('advanced_salaries'));

    } //endmethod

    public function EditSalary($id){
        $employees= Employee::latest()->get();
        $advanced_salary = AdvancedSalary::findorFail($id);
        return view('backoffice.salary.edit_advance_salary', compact('advanced_salary', 'employees'));

    } //endmethod



    public function StoreSalary(Request $request){

        $validateData = $request->validate([
            'month'=>'required',
            'year'=>'required',

        ]);

        $month = $request->month;
        $employee_id =$request->employee_id;
        $advance_salary = AdvancedSalary::where('month', $month)->where('employee_id', $employee_id)->first();

        if($advance_salary === NULL){

            AdvancedSalary::insert([
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                 'year' => $request->year,
                'advance_salary' => $request->salary,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Advanced Salary Paid Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('advance_salary.all', compact('notification'));

        } else{

            $notification = array(
                'message' => 'Advanced Salary Has already been Paid ',
                'alert-type' => 'warning'
            );

            return redirect()->route('advance_salary.all', compact('notification'));

        }


    } //endmethod

    public function UpdateSalary(Request $request){
         $advance_salary_id =$request->id;
         AdvancedSalary::findOrFail($advance_salary_id)->update([
             'employee_id' => $request->employee_id,
             'month' => $request->month,
             'year' => $request->year,
             'advance_salary' => $request->salary,
             'created_at'=>Carbon::now(),
         ]);

        $notification = array(
            'message' => 'Advanced Salary has been Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('advance_salary.all', compact('notification'));

    }//endmethod



    ////////////////////////////////////////Pay Salary All Method////////////////////////////////////

    public  function PaySalary(){
        $employee = Employee::latest()->get();
        return view('backoffice.salary.pay_salary', compact('employee'));
    }//endmethod


    public function PayNowSalary($id){
        $paysalary = Employee::findOrFail($id);
        return view('backoffice.salary.paid_salary', compact('paysalary'));
    }//endmethod

    public function StorePaySalary(Request $request){
    //$employee_id =$request->id;


    PaySalary::insert([
        'employee_id' => $request->id,
        'salary_month' => $request->month,
        'paid_amount' =>  $request->paid_amount,
        'advance_salary' =>  $request->advance_salary,
        'due_salary' =>  $request->due,
        'created_at'=>Carbon::now(),

    ]);



        $notification = array(
            'message' => 'Employee Salary has been Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('pay.salary', compact('notification'));



    }//endmethod

        public function LastMonthSalary(){

            $paidsalary = PaySalary::latest()->get();

            return view('backoffice.salary.last_month_salary', compact('paidsalary'));


        }//endmethod

    public function DeleteSalary($id){
        AdvancedSalary::findOrFail($id)->delete();

        $notification = array(
            'message' => 'AdvanceSalary Deleted Successfully',
            'alert-type' => 'warning'
        );

        return redirect()->back()->with($notification);
    }


}

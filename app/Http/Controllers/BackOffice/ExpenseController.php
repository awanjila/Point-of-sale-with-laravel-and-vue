<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{

    public function AddExpense(){

        return view('backoffice.expense.add_expense');



    }//endmethod


    public function StoreExpense(Request $request){

        Expense::insert([

            'details' => $request->details,
            'date' => $request->date,
            'year' => $request->year,
            'month' => $request->month,
            'amount' => $request->amount,
            'created_at'=> Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Expense Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.expense')->with($notification);

    }//endmethod


    public function AllExpense(){
            $expenses= Expense::latest()->get();
            return view('backoffice.expense.all_expense',compact('expenses'));
        } //endmethod



    public function EditExpense($id){
        $expense=Expense::findOrfail($id);

        return view('backoffice.expense.edit_expense', compact('expense'));
    }//endmethod
public function UpdateExpense(Request $request){

    $expense_id=$request->id;
    Expense::findOrfail($expense_id)->update([

        'details' => $request->details,
        'date' => $request->date,
        'year' => $request->year,
        'month' => $request->month,
        'amount' => $request->amount,
        'updated_at'=> Carbon::now(),

    ]);

    $notification = array(
        'message' => 'Expense Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.expense')->with($notification);


}//endmethod


}

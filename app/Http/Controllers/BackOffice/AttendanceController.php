<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function EmployeeAttendanceList(){

        $allData = Attendance::select('date')->groupBy('date')->orderBy('id', 'desc')->get();
        return view('backoffice.attendance.employee_attendance_list', compact('allData'));


    } //EndMethod

    public function AddEmployeeAttendance(){

        $employees= Employee::all();

        return view('backoffice.attendance.add_employee_attendance', compact('employees'));
    }

        public function EmployeeAttendanceStore(Request $request){
        Attendance::where('date', date('Y-m-d', strtotime($request->date)))->delete();
        $countemployee = count($request->employee_id);

            for ($i=0; $i< $countemployee; $i++){
                $attend_status= 'attend_status'.$i;

                $attend = new Attendance();
                $attend->date = date('Y-m-d', strtotime($request->date));
                $attend->employee_id = $request->employee_id[$i];
                $attend->attend_status =$request->$attend_status;
                $attend->save();
            }


            $notification = array(
                'message' => 'Data Inserted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('employee.attendance.list', compact('notification'));

        }

        public function EditEmployeeAttendance($date){
        $employees = Employee::all();
        $editData = Attendance::where('date', $date)->get();

            return view('backoffice.attendance.edit_employee_attendance', compact('employees', 'editData'));

        }

    public function ViewEmployeeAttendance($date){
        $employees = Employee::all();
        $details = Attendance::where('date', $date)->get();

        return view('backoffice.attendance.view_employee_attendance', compact('employees', 'details'));

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    use HasRoles;
    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User has Logged Out Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.logout.page')->with($notification);
    }//Endmethod

    public function adminLogout()
    {
        $notification = array(
            'message' => 'User has Logged Out Successfully',
            'alert-type' => 'success'
        );
        return view('admin.admin_logout')->with($notification);
    }//Endmethod

    public function adminProfile()
    {
        $id= Auth::user()->id;
        $adminData= User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }//Endmethod


    public function adminProfileStore(Request $request)
    {
        $id= Auth::user()->id;
        $data= User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;


        if ($request->file('photo')) {
            $file = $request->file('photo');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image'),$filename);
            $data['photo'] = $filename;
        }


        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }//Endmethod

    public function adminChangePassword()
    {
        $id= Auth::user()->id;
        $adminData= User::find($id);

        return view('admin.admin_change_password', compact('adminData'));

    }//Endmethod

    public function adminUpdatePassword(Request $request)
    {

        $id= Auth::user()->id;
        $adminData= User::find($id);

        $request->validate([

            'old_password' => 'required',
            'new_password' => 'required|confirmed',

        ]);

        //Match the old password

        if(!Hash::check($request->old_password, $adminData->password)){

            $notification = array(
                'message' => 'Old Password Doesnt March!!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereId(auth()->user()->id)->update([
            'password' =>Hash::make($request->new_password)

        ]);

        $notification = array(
            'message' => 'Password Change Successfull',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }//Endmethod

//////////////////////////////// Admin User Settings ///////////////////
    public function AllAdminUser(){

        $all_user = User::latest()->get();

        return view('backoffice.admin.all_admin_user', compact('all_user'));

    }//End Method


    public function AddAdminUser(){

        $roles = Role::latest()->get();

        return view('backoffice.admin.add_admin_user', compact('roles'));


    }//end method

    public function StoreAdminUser(Request $request){
$user = new User();
$user->name = $request->name;
$user->email = $request->email;
$user->password = Hash::make($request->password);
$user->phone = $request->phone;
$user->save();

if($request->roles){
    $user->assignRole($request->roles);
}

        $notification = array(
            'message' => 'New Admin User Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);

    } //end Method


    public function EditAdminUser($id){

        $roles = Role::latest()->get();
        $adminUser = User::findOrFail($id);

        return view('backoffice.admin.edit_admin_user', compact('roles','adminUser'));

    } //endmethod


    public function UpdateAdminUser(Request $request){


        $admin_id=$request->id;

        $user = User::findOrFail($admin_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();

        $user->roles()->detach();

        if($request->roles){
            $user->assignRole($request->roles);
        }





            $notification = array(
                'message' => 'Admin User Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.admin')->with($notification);


    } //endmethod



    public function DeleteAdminUser($id){

        $user = User::findOrFail($id);
        if (!is_null($user)){
            $user->delete();
        }

        $notification = array(
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);



    }


    ///////////////////////////////Database Back Methods/////////////////////////////////

    public function DataBaseBkp(){
        return view('admin.db_backup')->with('files', File::allFiles(storage_path('/app/WabeGadgets/')));


    }//endmethod


    public function DataBaseBkpNow(){

        \Artisan::call('backup:run');

        $notification = array(
            'message' => 'Database Backup Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }


    // public function DownloadDataBase($getFileName){

    //     $path = storage_path('app\WabeGadgets/'.$getFileName);
    //     return response()->download($path);

    // }


    public function DeleteDataBase($getFileName){
    Storage::delete('WabeGadgets/'.$getFileName);
        $notification = array(
            'message' => 'Database Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function getLoggedInUser()
    {
        // Retrieve the authenticated user's information from the database
        $user = User::find(auth()->id());

        // Return the user's name
        return response()->json([
            'username' => $user->name,
        ]);
    }//endmethod




}

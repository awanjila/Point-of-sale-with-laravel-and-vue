<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function AllPermission(){

    $permissions =Permission::all();
    return view('backoffice.pages.permission.all_permission', compact('permissions'));
    }//endmethod

    public function AddPermission(){

        return view('backoffice.pages.permission.add_permission');



    }//endmethod


    public function StorePermission(Request $request){
$role = Permission::create([
    'name'=> $request->permission_name,
    'group_name' => $request->group_name,
]);
        $notification = array(
            'message' => 'Permission Added Successfully',
            'alert-type'=> 'success'
        );

        return redirect()->route('all.permission')->with($notification);
    }//endmethod


    public function EditPermission($id){


        $permission=Permission::findOrfail($id);

        return view('backoffice.pages.permission.edit_permission', compact('permission'));

    }//endmethod

    public function UpdatePermission(Request $request){


        $permission_id=$request->id;


            Permission::findOrfail($permission_id)->update([
                'name'=> $request->permission_name,
                'group_name'=> $request->group_name,
                'created_at'=>Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Permission Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.permission')->with($notification);

    }//End Method


    public function DeletePermission($id){
        Permission::findorFail($id)->delete();

        $notification = array(
            'message' => 'Permission Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }//endmethod


    //////////////////////////////////// ROLES ///////////////////////////////////////////

    public function AllRole(){

        $roles =Role::all();
        return view('backoffice.pages.role.all_role', compact('roles'));
    }//endmethod

    public function AddRole(){

        return view('backoffice.pages.role.add_role');



    }//endmethod


    public function StoreRole(Request $request){
        $role = Role::create([
            'name'=> $request->name,
        ]);
        $notification = array(
            'message' => 'Role Added Successfully',
            'alert-type'=> 'success'
        );

        return redirect()->route('all.role')->with($notification);
    }//endmethod


    public function EditRole($id){


        $role=Role::findOrfail($id);

        return view('backoffice.pages.role.edit_role', compact('role'));

    }//endmethod

    public function UpdateRole(Request $request){


        $role_id=$request->id;


        Role::findOrfail($role_id)->update([
            'name'=> $request->name,
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role')->with($notification);

    }//End Method


    public function DeleteRole($id){
        Role::findorFail($id)->delete();

        $notification = array(
            'message' => 'Role Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role')->with($notification);

    }//endmethod

//////////////////////////////////// Add ROLE Permissions ///////////////////////////////////////////

    public function AddRolePermissions(){

        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups =User::getPermissionGroups();
        return view('backoffice.pages.role.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));


    }//endmethod


    public function StoreRolePermissions(Request $request){

        $data = array();
        $permissions = $request->permission;
        foreach($permissions as $key=>$item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;


            DB::table('role_has_permissions')->insert($data);
        }

             $notification = array(
                 'message' => 'Role Permission Added Successfully',
                 'alert-type' => 'success'
             );

        return redirect()->route('all.roles.permissions')->with($notification);

    }// End Method

    public function AllRolePermissions(){
$roles = Role::all();

        return view('backoffice.pages.role.all_roles_permission', compact('roles'));

    }//End Method




    public function EditRolePermissions($id){

        $roles = Role::findorFail($id);
        $permissions = Permission::all();
        $permission_groups =User::getPermissionGroups();
        return view('backoffice.pages.role.edit_roles_permission', compact('roles', 'permissions', 'permission_groups'));


    }//endmethod


    public function UpdateRolePermissions(Request $request, $id){
   $role = Role::findOrFail($id);
   $permissions = $request->permission;

   if(!empty($permissions)){
       $role->syncPermissions($permissions);
   }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permissions')->with($notification);



    }//End method


    public function DeleteRolePermissions($id){

        $role = Role::findOrFail($id);
        if(!is_null($role)){
            $role->delete();
        }

        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permissions')->with($notification);


    } //endmethod




}

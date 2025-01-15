<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use carbon\Carbon;

class CategoryController extends Controller
{
    public function AllCategory(){

        $categories=Category::latest()->get();

        return view('backoffice.category.all_category', compact('categories'));
    } //endmethod


    public function AddCategory(Request $request){

        $categories=Category::latest()->get();

        return view('backoffice.category.add_category', compact('categories'));
    } //endmethod


    public function StoreCategory(Request $request){

        $validateData = $request->validate([
            'category_name'=>'required | max:200',

        ]);


        Category::insert([
            'category_name'=> $request->category_name,
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
    } // endMethod


    public function EditCategory($id){
        $category=Category::findOrfail($id);

        return view('backoffice.category.edit_category', compact('category'));

    } //EndMethod

    public function UpdateCategory(Request $request){
        $category_id = $request->id;

        Category::findOrFail($category_id)->update([
            'category_name'=> $request->category_name,
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    } //EndMethod

    public function DeleteCategory($id){

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'warning'
        );

        return redirect()->back()->with($notification);


    }  //EndMethod

    public function __invoke()
    {
        $categories = Category::all()->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->category_name,
            ];
        });
        
        return response()->json($categories);
    }
}

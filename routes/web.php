<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackOffice\EmployeeController;
use App\Http\Controllers\BackOffice\CustomerController;
use App\Http\Controllers\BackOffice\SupplierController;
use App\Http\Controllers\BackOffice\SalaryController;
use App\Http\Controllers\GeoLocationController;
use App\Http\Controllers\BackOffice\AttendanceController;
use App\Http\Controllers\BackOffice\CategoryController;
use App\Http\Controllers\BackOffice\ProductController;
use App\Http\Controllers\BackOffice\ExpenseController;
use App\Http\Controllers\BackOffice\POSController;
use App\Http\Controllers\BackOffice\OrderController;
use App\Http\Controllers\BackOffice\RoleController;
use App\Http\Controllers\BackOffice\PrinterController;
use App\Http\Controllers\BackOffice\CartController;
use App\Http\Controllers\BackOffice\SettingController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Settings Controller
Route::controller(SettingController::class)->group(function(){
    Route::get('settings', 'index')->name('get.settings');
    // Route::get('settings', 'store')->name('store.settings');

})->middleware(['auth', 'verified']);


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    else

        return view('admin.admin_dashboard');


});

Route::get('/dashboard', function () {
    return view('admin.admin_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard')->middleware('permission:dashboard.menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin.logout.page');


Route::middleware('auth')->group(function () {
    Route::get('admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    Route::get('admin/change/password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('admin/password/update', [AdminController::class, 'adminUpdatePassword'])->name('admin.update.password');
    Route::get('/get-logged-in-user', [AdminController::class, 'getLoggedInUser']);

});


//Employee Controller
Route::controller(EmployeeController::class)->group(function(){
    Route::get('all/employee', 'AllEmployee')->name('employee.all')->middleware('permission:employee.all');
    Route::get('add/employee', 'AddEmployee')->name('employee.add')->middleware('permission:employee.add');
    Route::post('employee/store', 'StoreEmployee')->name('employee.store');
    Route::get('edit/employee/{id}', 'EditEmployee')->name('edit.employee')->middleware('permission:employee.edit');
    Route::get('employee/details/{id}', 'DetailEmployee')->name('details.employee')->middleware('permission:employee.delete');
    Route::post('employee/update', 'UpdateEmployee')->name('employee.update');
    Route::get('employee/delete/{id}', 'DeleteEmployee')->name('delete.employee');

})->middleware(['auth', 'verified']);


//Customer Controller
Route::controller(CustomerController::class)->group(function(){
    Route::get('all/customer', 'AllCustomer')->name('customer.all')->middleware('permission:customer.all');
    Route::get('add/customer', 'AddCustomer')->name('customer.add')->middleware('permission:customer.add');
    Route::post('customer/store', 'StoreCustomer')->name('customer.store');
    Route::get('edit/customer/{id}', 'EditCustomer')->name('edit.customer')->middleware('permission:customer.edit');
    Route::get('customer/details/{id}', 'DetailCustomer')->name('details.customer');
    Route::post('customer/update', 'UpdateCustomer')->name('customer.update');
    Route::get('customer/delete/{id}', 'DeleteCustomer')->name('delete.customer')->middleware('permission:customer.delete');



    //CartComponent
     Route::get('/get-customers', 'GetCustomers')->name('customer.get');

    

})->middleware(['auth', 'verified']);


//Supplier Controller
Route::controller(SupplierController::class)->group(function(){
    Route::get('all/supplier', 'AllSupplier')->name('supplier.all')->middleware('permission:supplier.all');
    Route::get('add/supplier', 'AddSupplier')->name('supplier.add')->middleware('permission:supplier.add');
    Route::post('supplier/store', 'StoreSupplier')->name('supplier.store');
    Route::get('edit/supplier/{id}', 'EditSupplier')->name('edit.supplier')->middleware('permission:supplier.edit');
    Route::get('supplier/details/{id}', 'DetailSupplier')->name('details.supplier');
    Route::post('supplier/update', 'UpdateSupplier')->name('supplier.update');
    Route::get('supplier/delete/{id}', 'DeleteSupplier')->name('delete.supplier')->middleware('permission:supplier.delete');

})->middleware(['auth', 'verified']);


//Advance Salary Controller
Route::controller(SalaryController::class)->group(function(){
    Route::get('all/advance/salary', 'AllSalary')->name('advance_salary.all');
    Route::get('add/advance/salary', 'AddSalary')->name('advance_salary.add');
    Route::post('advance/salary/store', 'StoreSalary')->name('advance_salary.store');
    Route::get('edit/advance_salary/{id}', 'EditSalary')->name('edit.advance_salary');
    Route::get('advance/salary/details/{id}', 'DetailSalary')->name('details.advance_salary');
    Route::post('advance/salary/update', 'UpdateSalary')->name('advance_salary.update');
    Route::get('advance/salary/delete/{id}', 'DeleteSalary')->name('delete.advance_salary');

})->middleware(['auth', 'verified']);

//Geo Location Controller
Route::controller(GeoLocationController::class)->group(function(){
    Route::get('/location/{phoneNumber}', 'getLocationByPhoneNumber');

})->middleware(['auth', 'verified']);

//Pay Salary Route
Route::controller(SalaryController::class)->group(function(){
    Route::get('pay/salary', 'PaySalary')->name('pay.salary')->middleware('permission:pay.salary');
    Route::get('pay/now/salary{id}', 'PayNowSalary')->name('pay.now.salary')->middleware('pay.now.salary');
    Route::post('pay/salary/store', 'StorePaySalary')->name('pay.salary.store');
    Route::get('last/month/salary', 'LastMonthSalary')->name('last.month.salary')->middleware('last.month.salary');;


})->middleware(['auth', 'verified']);

//All  Attendance Route
Route::controller(AttendanceController::class)->group(function(){
    Route::get('employee/attendance/list', 'EmployeeAttendanceList')->name('employee.attendance.list');
    Route::post('employee/attendance/store', 'EmployeeAttendanceStore')->name('employee.attendance.store');
    Route::get('add/employee/attendance', 'AddEmployeeAttendance')->name('add.employee.attendance');
    Route::get('edit/employee/attendance/{date}', 'EditEmployeeAttendance')->name('employee.attend.edit');
    Route::get('view/employee/attendance/{date}', 'ViewEmployeeAttendance')->name('employee.attend.view');


})->middleware(['auth', 'verified']);

//All Category Route
Route::controller(CategoryController::class)->group(function(){
    Route::get('all/category', 'AllCategory')->name('all.category');
    Route::get('add/category', 'AddCategory')->name('category.add');
    Route::post('store/category', 'StoreCategory')->name('category.store');
    Route::post('update/category', 'UpdateCategory')->name('category.update');
    Route::get('edit/category/{id}', 'EditCategory')->name('edit.category');
    Route::get('delete/category/{id}', 'DeleteCategory')->name('delete.category');

})->middleware(['auth', 'verified']);

//All Product Route
Route::controller(ProductController::class)->group(function(){
    Route::get('all/product', 'AllProduct')->name('all.product')->middleware('permission:product.all');
    Route::get('add/product', 'AddProduct')->name('product.add')->middleware('permission:product.add');
    Route::post('store/product', 'StoreProduct')->name('product.store');
    Route::post('update/product', 'UpdateProduct')->name('product.update');
    Route::get('edit/product/{id}', 'EditProduct')->name('edit.product')->middleware('permission:product.edit');
    Route::get('delete/product/{id}', 'DeleteProduct')->name('delete.product')->middleware('permission:product.delete');
    Route::get('import/product', 'ImportProduct')->name('import.product');
    Route::get('barcode/product/{id}', 'BarCodeProduct')->name('barcode.product');
    Route::get('export/product', 'ExportProduct')->name('export.product');
    Route::get('out/of/stock', 'OutofStock')->name('out_of_stock');
    Route::get('expired/products', 'ExpiredProducts')->name('expired_products');
    Route::get('hot/products', 'GetHotProducts')->name('hot.products');
    Route::post('import', 'Import')->name('import');







})->middleware(['auth', 'verified']);

//All Expense Route
Route::controller(ExpenseController::class)->group(function(){
    Route::get('all/expense', 'AllExpense')->name('all.expense');
    Route::get('add/expense', 'AddExpense')->name('expense.add');
    Route::post('store/expense', 'StoreExpense')->name('expense.store');
    Route::post('update/expense', 'UpdateExpense')->name('expense.update');
    Route::get('edit/expense/{id}', 'EditExpense')->name('edit.expense');
    Route::get('delete/expense/{id}', 'DeleteExpense')->name('delete.expense');

})->middleware(['auth', 'verified']);


//All POS Route
Route::controller(POSController::class)->group(function(){
    Route::get('posv1', 'POS')->name('pos');
    Route::get('pos', 'POSRestaraunt')->name('pos.restaraunt');
    Route::post('/add-cart', 'AddCart')->name('add.to.cart');
    Route::get('/All-Pos-Item', 'AllPosItem')->name('all.pos.item');
    Route::post('update/pos', 'UpdatePOS')->name('pos.update');
    Route::post('/create/invoice', 'CreateInvoice')->name('create.invoice');
    Route::post('/final-invoice', 'FinalInvoice')->name('final.invoice');
    Route::get('delete/pos/{id}', 'DeletePOS')->name('delete.pos');
    Route::post('/cart-update/{rowid}', 'CartUpdate');
    Route::get('/cart-remove/{rowid}', 'CartRemove');

})->middleware(['auth', 'verified']);


//All POS Route
Route::controller(OrderController::class)->group(function(){

    Route::post('/final-invoice', 'FinalInvoice')->name('final.invoice');
    Route::get('/pending-order', 'PendingOrder')->name('pending.order');
    Route::get('/complete-order', 'CompleteOrder')->name('complete.order');
    Route::get('/order-details/{order_id}', 'OrderDetails')->name('order.details');
    Route::get('order/invoice/download/{id}', 'OrderInvoice')->name('invoice.download');
    Route::post('/order/status/update', 'OrderStatusUpdate')->name('order.status.update');
    Route::get('/stock', 'StockManage')->name('stock.manage');

    ////DUE Routes/////
    Route::get('/pending/due', 'PendingDue')->name('pending.due');
    Route::get('/order/due/{id}', 'OrderDueAjax')->name('order.due');
    Route::post('update/due', 'UpdateDue')->name('update.due');

    //////Reports/////
    Route::get('todays/sales', 'TodaysSales')->name('todays_sales_report');
    Route::get('sales/report', 'SalesReport')->name('sales.report');

})->middleware(['auth', 'verified']);

//All Role Route
Route::controller(RoleController::class)->group(function(){

    Route::get('/all-permission', 'AllPermission')->name('all.permission');
    Route::get('/add-permission', 'AddPermission')->name('permission.add');
    Route::post('/store-permission', 'StorePermission')->name('permission.store');
    Route::get('edit/permission/{id}', 'EditPermission')->name('edit.permission');
    Route::get('delete/permission/{id}', 'DeletePermission')->name('delete.permission');
    Route::post('permission/update', 'UpdatePermission')->name('permission.update');

//Roles
    Route::get('/all-role', 'AllRole')->name('all.role');
    Route::get('/add-role', 'AddRole')->name('role.add');
    Route::post('/store-role', 'StoreRole')->name('role.store');
    Route::get('edit/role/{id}', 'EditRole')->name('edit.role');
    Route::get('delete/role/{id}', 'DeleteRole')->name('delete.role');
    Route::post('role/update', 'UpdateRole')->name('role.update');


    //Roles in Permissions

    Route::get('add/roles/permissions', 'AddRolePermissions')->name('add.roles.permissions');
    Route::get('all/roles/permissions', 'AllRolePermissions')->name('all.roles.permissions');
    Route::get('edit/roles/permissions/{id}', 'EditRolePermissions')->name('admin.edit.roles');
    Route::post('role/permission/store', 'StoreRolePermissions')->name('role.permission.store');
    Route::post('role/permission/update/{id}', 'UpdateRolePermissions')->name('role.permission.update');
    Route::get('role/permission/delete/{id}', 'DeleteRolePermissions')->name('admin delete.roles');





})->middleware(['auth', 'verified']);


Route::controller(CartController::class)->group(function(){
    Route::post('pos/add-to-cart', 'addToCart')->name('cart.add');
    Route::get('cart-items', 'CartItems')->name('cart.items');
    Route::delete('/cart-items/{rowId}', 'DeleteItems');
    Route::post('/update-cart/{rowid}', 'CartUpdate');
    Route::get('/cart-count', 'CartCount');
    Route::post('/cart-items/{rowId}/update-quantity', 'updateQuantity');

})->middleware(['auth', 'verified']);


//Advance Salary Controller
Route::controller(AdminController::class)->group(function(){
    Route::get('all/admin/user/setting', 'AllAdminUser')->name('all.admin');
    Route::get('add/admin/user/setting', 'AddAdminUser')->name('add.admin');
    Route::get('edit/admin/user/setting/{id}', 'EditAdminUser')->name('edit.admin');
    Route::post('store/admin/user/setting', 'StoreAdminUser')->name('store.admin');
    Route::post('update/admin/user/setting', 'UpdateAdminUser')->name('update.admin');
    Route::get('delete/admin/user/setting/{id}', 'DeleteAdminUser')->name('delete.admin');


    ///////////////////////////////Database Back Routes/////////////////////////////////
    Route::get('database/backup', 'DataBaseBkp')->name('database.backup');
    Route::get('backup/now', 'DataBaseBkpNow');
    Route::get('{getFileName}', 'DownloadDataBase');
    Route::get('delete/database/{getFileName}', 'DeleteDataBase');

})->middleware(['auth', 'verified']);


Route::controller(PrinterController::class)->group(function(){
    Route::get('print/receipt', 'PrintReceipt')->name('print.receipt');

})->middleware(['auth', 'verified']);

Route::get('/settings', function () {
    return view('settings');
})->name('get.settings')->middleware(['auth', 'verified']);




























    <div class="left-side-menu">

        <div class="h-100" data-simplebar>

            <!-- User box -->
            <div class="user-box text-center">
                <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                     class="rounded-circle avatar-md">
                <div class="dropdown">
                    <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                       data-bs-toggle="dropdown">Geneva Kennedy</a>
                    <div class="dropdown-menu user-pro-dropdown">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user me-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings me-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-lock me-1"></i>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-log-out me-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </div>
                <p class="text-muted">Admin Head</p>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
{{--                        <a href="{{route('dashboard')}}">--}}
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


{{--    @if(Auth::user()->can('pos.menu'))--}}
                    <li>
                        <span class="badge bg-pink float-end">Hot</span>
                        <a href="{{route('pos')}}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> POS AutoSpare </span>
                        </a>
                    </li>
{{--                    @endif--}}

                    <li>
                        <span class="badge bg-pink float-end">BAR/RES</span>
                        <a href="{{route('pos.restaraunt')}}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> POS Restaraunt/Bar </span>
                        </a>
                    </li>




                    <li class="menu-title mt-2">Apps</li>

{{--                    @if(Auth::user()->can('pos.menu'))--}}

                    <li>
                        <a href="#sidebarEcommerce" data-bs-toggle="collapse">
                            <i class="mdi mdi-cart-outline"></i>
                            <span> Employee Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEcommerce">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('employee.all'))

                                <li>
                                    <a href="{{route('employee.all')}}">All Employee</a>
                                </li>

                                @endif
                                    @if(Auth::user()->can('employee.add'))
                                <li>
                                    <a href="{{route('employee.add')}}">Add Employee</a>
                                </li>

                                    @endif
                            </ul>
                        </div>
                    </li>

{{--                    @endif--}}
                    @if(Auth::user()->can('supplier.menu'))
                    <li>
                        <a href="#sidebarCrs" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span> Supplier Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrs">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('supplier.all'))

                                <li>
                                    <a href="{{route('supplier.all')}}">All Supplier</a>
                                </li>

                                @endif
                                    @if(Auth::user()->can('supplier.add'))

                                <li>
                                    <a href="{{route('supplier.add')}}">Add Supplier</a>
                                </li>

                                    @endif
                            </ul>
                        </div>
                    </li>

                    @endif

                    @if(Auth::user()->can('customer.menu'))
                    <li>
                        <a href="#sidebarCrm" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span> Customer Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="nav-second-level">
                                @if(Auth::user()->can('customer.all'))
                                <li>
                                    <a href="{{route('customer.all')}}">All Customer</a>
                                </li>
                                @endif
                                    @if(Auth::user()->can('customer.add'))
                                <li>
                                    <a href="{{route('customer.add')}}">Add Customer</a>
                                </li>
                                        @endif
                            </ul>
                        </div>
                    </li>

                    @endif

    @if(Auth::user()->can('salary.menu'))

    <li>
      <a href="#sidebarSalary" data-bs-toggle="collapse">
          <i class="mdi mdi-account-multiple-outline"></i>
          <span> Salary Management </span>
          <span class="menu-arrow"></span>
      </a>
      <div class="collapse" id="sidebarSalary">
          <ul class="nav-second-level">

              @if(Auth::user()->can('salary.all'))

              <li>
                  <a href="{{route('advance_salary.all')}}">All Advance Salary</a>
              </li>

              @endif
                  @if(Auth::user()->can('salary.add'))
              <li>
                  <a href="{{route('advance_salary.add')}}">Add Advance Salary</a>
              </li>

                  @endif
                  @if(Auth::user()->can('pay.salary'))
              <li>
                  <a href="{{route('pay.salary')}}">Pay Salary</a>

              </li>
                  @endif
                  @if(Auth::user()->can(' last.month.salary'))

              <li>
                  <a href="{{route('last.month.salary')}}">{{ date("F", strtotime('-1 month')) }} Salary</a>
              </li>
                      @endif
          </ul>
      </div>
    </li>

                    @endif


{{--                    @if(Auth::user()->can(' attendance.menu'))--}}
    <li>
      <a href="#attendance" data-bs-toggle="collapse">
          <i class="mdi mdi-account-multiple-outline"></i>
          <span> Employee Attendance </span>
          <span class="menu-arrow"></span>
      </a>
      <div class="collapse" id="attendance">
          <ul class="nav-second-level">

{{--    @if(Auth::user()->can(' attendance.menu'))--}}

    <li>
       <a href="{{route('employee.attendance.list')}}">Employee Attendance List</a>
    </li>
{{--        @endif--}}

    </ul>
    </div>
    </li>

{{--         @endif--}}

    <li>
    <a href="#category" data-bs-toggle="collapse">
    <i class="fa fa-briefcase "></i>
    <span> Category Management </span>
    <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="category">
         <ul class="nav-second-level">
            <li>
               <a href="{{route('all.category')}}">All Category</a>
            </li>
         </ul>
    </div>
    </li>

{{--    @if(Auth::user()->can(' product.menu'))--}}
        <li>
       <a href="#product" data-bs-toggle="collapse">
       <i class="fa fa-briefcase "></i>
       <span> Product Management </span>
       <span class="menu-arrow"></span>
       </a>
       <div class="collapse" id="product">
           <ul class="nav-second-level">

{{--               @if(Auth::user()->can(' product.all'))--}}

               <li>
                  <a href="{{route('all.product')}}">All Product</a>
               </li>

{{--               @endif--}}

               {{--               @if(Auth::user()->can(' product.all'))--}}

               <li>
                   <a href="{{route('product.add')}}">Add Product</a>
               </li>

               {{--               @endif--}}
{{--                   @if(Auth::user()->can(' import.product'))--}}
               <li>
                  <a href="{{route('import.product')}}">Import Product</a>
               </li>
{{--                       @endif--}}
           </ul>
   </div>
   </li>
{{--                    @endif--}}
        @if(Auth::user()->can('order.menu'))
            <li>
                <a href="#order" data-bs-toggle="collapse"><i class="fa fa-briefcase sm "></i><span> Order Management </span><span class="menu-arrow"></span></a>
            <div class="collapse" id="order">
        <ul class="nav-second-level">


            @if(Auth::user()->can('pending.order'))
               <li>
                  <a href="{{route('pending.order')}}">Pending Order</a>
               </li>
            @endif
                @if(Auth::user()->can('complete.order'))
               <li>
                  <a href="{{route('complete.order')}}">Complete Order</a>
               </li>
                @endif

                <li>
                    <a href="{{route('pending.due')}}">Pending Due</a>
                </li>
        </ul>
            </div>
         </li>
                    @endif
                    @if(Auth::user()->can('stock.menu'))
         <li>
            <a href="#stock" data-bs-toggle="collapse"><i class="fa fa-briefcase sm "></i>
            <span> Stock Management </span>
                <span class="menu-arrow"></span>
                                                 </a>
            <div class="collapse" id="stock">
                 <ul class="nav-second-level">

                   <li>
                      <a href="{{route('stock.manage')}}">Stock</a>
                   </li>

                </ul>
            </div>
                </li>
                    @endif
                    @if(Auth::user()->can('role.menu'))
                        <li>
                 <a href="#permission" data-bs-toggle="collapse"><i class="fa fa-briefcase sm "></i><span> Roles & Permission </span><span class="menu-arrow"></span></a>
   <div class="collapse" id="permission">
           <ul class="nav-second-level">
               @if(Auth::user()->can('all.permission'))
                   <li>
                      <a href="{{route('all.permission')}}">Permission</a>
                   </li>

               @endif
               @if(Auth::user()->can('role.all'))

                   <li>
                      <a href="{{route('all.role')}}">All Roles</a>
                   </li>

               @endif
                   @if(Auth::user()->can('add.roles.permissions'))
                   <li>
                      <a href="{{route('add.roles.permissions')}}">Add Roles in Permissions</a>
                   </li>
                   @endif
                   @if(Auth::user()->can('all.roles.permissions'))

                   <li>
                      <a href="{{route('all.roles.permissions')}}">All Roles in Permissions</a>
                   </li>

                       @endif

           </ul>
      </div>
   </li>

                    @endif
    @if(Auth::user()->can('admin.menu'))

            <li>
        <a href="#admin" data-bs-toggle="collapse"> <i class="fa fa-briefcase sm "></i>
        <span> Admin User Settings </span> <span class="menu-arrow"></span> </a>
        <div class="collapse" id="admin">
            <ul class="nav-second-level">
                @if(Auth::user()->can('add.admin'))
            <li>
            <a href="{{route('add.admin')}}">Add Admin</a>
            </li>
                @endif

                    @if(Auth::user()->can('all.admin'))

            <li>
            <a href="{{route('all.admin')}}">All Admin</a>
            </li>
                        @endif
            </ul>
        </div>
        </li>
                    @endif
                    @if(Auth::user()->can('expense.menu'))

    <li>
        <a href="#expense" data-bs-toggle="collapse"><i class="fa fa-briefcase "></i><span> Expense Management </span> <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="expense">
        <ul class="nav-second-level">
            @if(Auth::user()->can('expense.add'))

                <li>
                <a href="{{ route('expense.add') }}">Add Expense</a>
                </li>

            @endif
                <li>
                <a href="#">Today's Expense</a>
                </li>
                <li>
                <a href="#">Monthly Expense</a>
                </li>
                <li>
                <a href="#">Yearly Expense</a>
                </li>

        </ul>
        </div>
</li>



             <!--            <li>
                            <a href="#databasebkp" data-bs-toggle="collapse"><i class="fa fa-briefcase "></i><span> Database Backup </span> <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="databasebkp">
                                <ul class="nav-second-level">
                                    @if(Auth::user()->can('expense.add'))

                                        <li>
                                            <a href="{{ route('database.backup') }}">Data Base Backup</a>
                                        </li>

                                    @endif

                                </ul>
                            </div>
                        </li> -->





                    @endif


</ul>

</div>
<!-- End Sidebar -->

<div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>

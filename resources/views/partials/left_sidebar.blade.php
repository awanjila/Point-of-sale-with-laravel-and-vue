<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">
                <!-- Dashboard Section -->
                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fas fa-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- POS Button -->
                <li>
                    <form action="{{ route('pos.restaraunt') }}" method="get">
                        <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-between">
                            <i class="fas fa-cash-register"></i>
                            <span> Point Of Sale </span>
                            <span class="badge bg-pink">New</span>
                        </button>
                    </form>
                </li>

                <!-- Admin Section -->
                @if(Auth::user()->can('admin.menu'))
                <li class="menu-title mt-2">Administration</li>
                <li>
                    <a href="#adminMenu" data-bs-toggle="collapse">
                        <i class="fas fa-user-shield"></i>
                        <span> Admin Management </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="adminMenu">
                        <ul class="nav-second-level">
                            @if(Auth::user()->can('role.menu'))
                            <li>
                                <a href="#rolesMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-user-lock"></i> Roles & Permissions
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="rolesMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('all.role')}}">All Roles</a></li>
                                        <li><a href="{{route('role.add')}}">Add Role</a></li>
                                        <li><a href="{{route('all.roles.permissions')}}">All Permissions</a></li>
                                        <li><a href="{{route('add.roles.permissions')}}">Add Permission</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            
                            @if(Auth::user()->can('admin.all'))
                            <li><a href="{{route('all.admin')}}"><i class="fas fa-users-cog"></i> Admin Users</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Product Management -->
                @if(Auth::user()->can('product.menu'))
                <li class="menu-title mt-2">Inventory</li>
                <li>
                    <a href="#productMenu" data-bs-toggle="collapse">
                        <i class="fas fa-box"></i>
                        <span> Product Management </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="productMenu">
                        <ul class="nav-second-level">
                            <!-- Products -->
                            @if(Auth::user()->can('product.menu'))
                            <li>
                                <a href="#productsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-boxes"></i> Products
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="productsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('all.product')}}">All Products</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            <!-- Categories -->
                            @if(Auth::user()->can('category.menu'))
                            <li>
                                <a href="#categoryMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-tags"></i> Categories
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="categoryMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('all.category')}}">All Categories</a></li>
                                        <li><a href="{{route('add.category')}}">Add Category</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            <!-- Stock Management -->
                            @if(Auth::user()->can('stock.menu'))
                            <li>
                                <a href="#stockMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-warehouse"></i> Stock Management
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="stockMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('stock.manage')}}">Stock Manage</a></li>
                                        <li><a href="{{route('out_of_stock')}}">Out of Stock</a></li>
                                        <li><a href="{{route('expired_products')}}">Expired Products</a></li>
                                        <li><a href="{{route('hot.products')}}">Hot Products</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Purchase Management -->
               
                <li>
                    <a href="#purchaseMenu" data-bs-toggle="collapse">
                        <i class="fas fa-shopping-cart"></i>
                        <span> Purchase Management </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="purchaseMenu">
                        <ul class="nav-second-level">
                            <!-- Purchases -->
                            <li>
                                <a href="#purchasesMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-file-invoice-dollar"></i> Purchases
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="purchasesMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('all.purchase')}}"><i class="fas fa-list"></i> All Purchases</a></li>
                                        <li><a href="/add/purchase"><i class="fas fa-plus"></i> Add Purchase</a></li>
                                        <li><a href="/pending/purchase"><i class="fas fa-clock"></i> Pending Purchases</a></li>
                                        <li><a href="/approved/purchase"><i class="fas fa-check"></i> Approved Purchases</a></li>
                                        <li><a href="/daily/purchase/report"><i class="fas fa-calendar-day"></i> Daily Purchase</a></li>
                                        <li><a href="monthly/purchase/report"><i class="fas fa-calendar-alt"></i> Monthly Purchase</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Purchase Returns -->
                            <li>
                                <a href="#purchaseReturnsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-undo"></i> Purchase Returns
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="purchaseReturnsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="/all/purchase/return"><i class="fas fa-list"></i> All Returns</a></li>
                                        <li><a href="add/purchase/return"><i class="fas fa-plus"></i> Add Return</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Purchase Payments -->
                            <li>
                                <a href="#purchasePaymentsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-money-bill-wave"></i> Purchase Payments
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="purchasePaymentsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="purchase/payments"><i class="fas fa-list"></i> All Payments</a></li>
                                        <li><a href="add/purchase/payment"><i class="fas fa-plus"></i> Add Payment</a></li>
                                        <li><a href="pending/purchase/payments"><i class="fas fa-clock"></i> Pending Payments</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
               

                <!-- Orders Management -->
                @if(Auth::user()->can('order.menu'))
                <li>
                    <a href="#orderMenu" data-bs-toggle="collapse">
                        <i class="fas fa-shopping-bag"></i>
                        <span> Orders </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="orderMenu">
                        <ul class="nav-second-level">
                            <li><a href="/orders"><i class="fas fa-list"></i> All Orders</a></li>
                           
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Add this after the Orders Management section -->
                
                <li>
                    <a href="#salesMenu" data-bs-toggle="collapse">
                        <i class="fas fa-cash-register"></i>
                        <span> Sales Management </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="salesMenu">
                        <ul class="nav-second-level">
                            <!-- Sales -->
                            <li>
                                <a href="#salesListMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-receipt"></i> Sales
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="salesListMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="all/sales"><i class="fas fa-list"></i> All Sales</a></li>
                                        <li><a href="add/sales"><i class="fas fa-plus"></i> Add Sale</a></li>
                                        <li><a href="pending/sales"><i class="fas fa-clock"></i> Pending Sales</a></li>
                                        <li><a href="completed/sales"><i class="fas fa-check"></i> Completed Sales</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Sales Returns -->
                            <li>
                                <a href="#salesReturnsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-undo"></i> Sales Returns
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="salesReturnsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="all/sales/returns"><i class="fas fa-list"></i> All Returns</a></li>
                                        <li><a href="add/sales/return"><i class="fas fa-plus"></i> Add Return</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Sales Payments -->
                            <li>
                                <a href="#salesPaymentsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-money-bill-wave"></i> Sales Payments
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="salesPaymentsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="sales/payments"><i class="fas fa-list"></i> All Payments</a></li>
                                        <li><a href="add/sales/payment"><i class="fas fa-plus"></i> Add Payment</a></li>
                                        <li><a href="pending/sales/payments"><i class="fas fa-clock"></i> Pending Payments</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- Sales Reports -->
                            <li>
                                <a href="#salesReportsMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-chart-line"></i> Sales Reports
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="salesReportsMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="daily/sales"><i class="fas fa-calendar-day"></i> Daily Sales</a></li>
                                        <li><a href="monthly/sales"><i class="fas fa-calendar-alt"></i> Monthly Sales</a></li>
                                        <li><a href="yearly/sales"><i class="fas fa-calendar"></i> Yearly Sales</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
               

                <!-- Personnel Management -->
                @if(Auth::user()->can('employee.menu') || Auth::user()->can('supplier.menu') || Auth::user()->can('customer.menu'))
                <li class="menu-title mt-2">Personnel</li>
                <li>
                    <a href="#personnel" data-bs-toggle="collapse">
                        <i class="fas fa-users"></i>
                        <span> Personnel </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="personnel">
                        <ul class="nav-second-level">
                            @if(Auth::user()->can('employee.menu'))
                            <li>
                                <a href="#employeeMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-user-tie"></i> Employees
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="employeeMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('employee.all')}}">All Employees</a></li>
                                        <li><a href="{{route('employee.add')}}">Add Employee</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->can('supplier.menu'))
                            <li>
                                <a href="#supplierMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-truck"></i> Suppliers
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="supplierMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('supplier.all')}}">All Suppliers</a></li>
                                        <li><a href="{{route('supplier.add')}}">Add Supplier</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->can('customer.menu'))
                            <li>
                                <a href="#customerMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-user-friends"></i> Customers
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="customerMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('customer.all')}}">All Customers</a></li>
                                        <li><a href="{{route('customer.add')}}">Add Customer</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Finance Management -->
                @if(Auth::user()->can('salary.menu') || Auth::user()->can('expense.menu'))
                <li class="menu-title mt-2">Finance</li>
                <li>
                    <a href="#finance" data-bs-toggle="collapse">
                        <i class="fas fa-money-bill-wave"></i>
                        <span> Finance </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav-second-level">
                            @if(Auth::user()->can('salary.menu'))
                            <li>
                                <a href="#salaryMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-wallet"></i> Salary
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="salaryMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('advance_salary.all')}}">All Advance Salary</a></li>
                                        <li><a href="{{route('advance_salary.add')}}">Add Advance Salary</a></li>
                                        <li><a href="{{route('pay.salary')}}">Pay Salary</a></li>
                                        <li><a href="/salary/history">Salary History</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(Auth::user()->can('expense.menu'))
                            <li>
                                <a href="#expenseMenu" data-bs-toggle="collapse">
                                    <i class="fas fa-receipt"></i> Expenses
                                    <i class="fas fa-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="expenseMenu">
                                    <ul class="nav-third-level">
                                        <li><a href="{{route('expense.add')}}">Add Expense</a></li>
                                        <li><a href="{{route('all.expense')}}">Expenses</a></li>
                                        <li><a href="/#">Monthly Expense</a></li>
                                        <li><a href="/#">Yearly Expense</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Reports -->
              
                <li class="menu-title mt-2">Reports</li>
                <li>
                    <a href="#reportsMenu" data-bs-toggle="collapse">
                        <i class="fas fa-chart-bar"></i>
                        <span> Reports </span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="reportsMenu">
                        <ul class="nav-second-level">
                            <li><a href="{{route('sales.report')}}"><i class="fas fa-chart-line"></i> Sales Report</a></li>
                            <li><a href="{{route('purchase.report')}}"><i class="fas fa-chart-pie"></i> Purchase Report</a></li>
                            <li><a href="#"><i class="fas fa-boxes"></i> Stock Report</a></li>
                            <li><a href="expense/report"><i class="fas fa-file-invoice-dollar"></i> Expense Report</a></li>
                        </ul>
                    </div>
                </li>
               

                <!-- Settings -->
                <li class="menu-title mt-2">Settings</li>
                <li>
                    <a href="{{ route('get.settings') }}" class="side-nav-link">
                        <i class="fas fa-cog"></i>
                        <span> Company Settings </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.left-side-menu {
    background: #2c3e50;
    color: #ecf0f1;
}

#sidebar-menu {
    padding: 20px 0;
}

.menu-title {
    padding: 12px 20px;
    letter-spacing: .05em;
    pointer-events: none;
    cursor: default;
    font-size: 0.6875rem;
    text-transform: uppercase;
    color: #6c7293;
    font-weight: 600;
}

#side-menu li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #bdc3c7;
    transition: all 0.3s ease;
    font-size: 0.9375rem;
}

#side-menu li a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
}

#side-menu li a i {
    width: 20px;
    margin-right: 8px;
    font-size: 1.1rem;
}

.nav-second-level {
    padding-left: 20px;
}

.nav-third-level {
    padding-left: 20px;
}

.collapse {
    background: rgba(0, 0, 0, 0.1);
}

.fa-chevron-down {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

[aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}

.btn-primary {
    background: #3498db;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #2980b9;
}

.badge {
    padding: 0.4em 0.6em;
}
</style>

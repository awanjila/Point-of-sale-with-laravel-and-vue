@extends('layouts.admin_app')

@section('title')

    Home
@endsection

@section('content')

    @php
$date =date('d-F-Y');
$today_paid = App\Models\Order::where('order_date', $date)->sum('pay');
$todays_sales = App\Models\Order::where('order_date', $date);
$total_paid = App\Models\Order::sum('pay');
$total_order_details = App\Models\OrderDetails::sum('quantity');
$total_due = App\Models\Order::sum('due');
$complete_order = App\Models\Order::where('order_status', 'complete')->get();
$pending_order = App\Models\Order::where('order_status', 'pending')->get();
$orders = App\Models\Order::orderBy("id", "desc")->get();
$products = App\Models\Product::orderBy("id", "desc")->get();
$outofstock_products = App\Models\Product::where('product_store', '<=', 0)->count();
$expired_products = App\Models\Product::where('expire_date', '<=', \Carbon\Carbon::now()->format('Y-m-d'))->count();
$hotProducts = App\Models\Product::where('sales_count', '>', 0)
        ->orderBy('sales_count', 'desc')
        ->limit(10)
        ->get();

//$product->expire_date >=\Carbon\Carbon::now()->format('Y-m-d')




    @endphp
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex align-items-center mb-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control border-0" id="dash-daterange">
                                <span class="input-group-text bg-blue border-blue text-white">
                                                    <i class="mdi mdi-calendar-range"></i>
                                                </span>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                <i class="mdi mdi-autorenew"></i>
                            </a>
                            <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- <a href="{{ route('todays_sales_report') }}"> -->
              <!--   <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-primary border-primary border shadow">
                                        <i class="fe-heart font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"> <span data-plugin="counterup">{{$today_paid}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Today Paid</p>
                                    </div>
                                </div>
                        </div>
                    </div> 
                </div>

               

            </a> -->
      
<!-- 
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-success border-success border shadow">
                                    <i class="fe-shopping-cart font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup">{{$total_paid}} </span></h3>
                                    <p class="text-muted mb-1 text-truncate">Total Sales</p>
                                </div>
                            </div>
                        </div>  -->
                        <!-- end row-->
                  <!--   </div>
                </div>  -->
                <!-- end widget-rounded-circle-->
            <!-- </div> -->
             <!-- end col-->

            <div class="col-md-6 col-xl-6">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-info border-info border shadow">
                                    <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                                </div>
                            </div>

                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($complete_order)}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Complete Order</p>
                                    </div>
                                </div>

                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-6">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle bg-warning border-warning border shadow">
                                    <i class="fe-eye font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup">{{count($pending_order)}}</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Pending Order</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        <!-- end page title -->

        <div class="row">
            <a href="{{ route('out_of_stock') }}">
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card" style="background-color: green;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <i class="bi bi-box-arrow-in-down" style="color: white;
                                    font-weight: bold;
                                    font-size: 3em;"></i>

                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h2 class="text-white mt-1">{{$outofstock_products}}</h2>
                                        <p class="text-white mb-1 text-truncate"><strong>Out Of Stock</strong></p>
                                    </div>
                                </div>
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div>

                    <!-- end col-->

            </a>
        </div>

            <div class="col-md-6 col-xl-3">
                <a href="{{ route('expired_products') }}">
                <div class="widget-rounded-circle card" style="background-color: orange;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="col-6">
                                    <i class="bi bi-hourglass-bottom" style="color: white;
                                    font-weight: bold;
                                    font-size: 3.5em;"></i>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-white mt-1"> <span data-plugin="counterup">{{$expired_products}}</span></h3>
                                    <p class="text-white mb-1 text-truncate"><strong>Expired</strong></p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
                </a>
            </div> <!-- end col-->


            <div class="col-md-6 col-xl-3">
                <a href="{{route('hot.products')}}">
                <div class="widget-rounded-circle card" style="background-color: orangered;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="col-6">
                                    <i class="bi bi-bag-heart-fill" style="color: white;
                                    font-weight: bold;
                                    font-size: 3.5em;"></i>

                                </div>
                            </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-white mt-1"><span data-plugin="counterup"><strong>{{count($hotProducts)}}</strong></h3>
                                        <p class="text-white mb-1 text-truncate"><strong>Hot Products</strong></p>
                                    </div>
                                </div>

                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
                </a>
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <a href="{{route('sales.report')}}">
                    <div class="widget-rounded-circle card" style="background-color: navy;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="col-6">
                                        <i class="bi bi-file-earmark-bar-graph" style="color: white;
                                    font-weight: bold;
                                    font-size: 3.5em;"></i>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-white mt-1"><span data-plugin="counterup"><strong>{{$total_order_details}}</strong></span></h3>
                                        <p class="text-white mb-1 text-truncate"><strong>Sales Report</strong></p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </a>

            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>

                        <h4 class="header-title mb-3">Recent Products In stock</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                <thead class="table-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Expiry Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products->take(10) as $product)
                                    <tr>

                                        <td>
                                            <h5 class="m-0 fw-normal">{{$product->product_name}}</h5>
                                        </td>
                                        <td>
                                            <h5 class="m-0 fw-normal">{{$product->product_code}}</h5>
                                        </td>
                                        <td>
                                        <h5 class="m-0 fw-normal">{{$product->category->category_name ?? 'No Category'}}</h5>

                                        </td>
                                        <td>
                                            <h5 class="m-0 fw-normal">{{$product->supplier->name ?? 'No Supplier'}}</h5>
                                        </td>
                                        <td>
                                            <h5 class="m-0 fw-normal">{{$product->product_store}}</h5>
                                        </td>
                                        <td>
                                            <h5 class="m-0 fw-normal">Ksh {{$product->selling_price}}</h5>
                                        </td>
                                        <td>
                                            @if($product->expire_date >=\Carbon\Carbon::now()->format('Y-m-d'))
                                                <span class="badge badge-soft-success">Valid</span>
                                            @else
                                                <span class="badge badge-soft-danger">Expired</span>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div> <!-- end .table-responsive-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

        <div class="row">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>

                        <h4 class="header-title mb-3">Order History</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                <thead class="table-light">
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Invoice No.</th>
                                    <th>Order Date</th>
                                    <th>Total Items</th>
                                    <th>Total</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders->take(10) as $order)
                                <tr>

                                    <td>
                                        <h5 class="m-0 fw-normal">{{$order->customer->name}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 fw-normal">{{$order->invoice_no}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 fw-normal">{{$order->order_date}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 fw-normal">{{$order->total_products}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="m-0 fw-normal">Ksh {{$order->total}}</h5>
                                    </td>
                                    <td>
                                        @if($order->order_status == 'complete')
                                            <span class="badge badge-soft-success">Completed</span>
                                        @else

                                            <form method="POST" action="{{route('order.status.update')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{ $order->id }}" name="id">
                                                <input type="hidden" value="{{ $order->customer->name}}" name="name">
                                                <input type="hidden" value="{{$order->customer->email}}" name="email">
                                                <input type="hidden" value="{{$order->customer->address}}" name="address">
                                                <input type="hidden" value="{{$order->customer->phone}}" name="phone">
                                                <input type="hidden" value="{{$order->order_date}}" name="order_date">
                                                <input type="hidden" value="{{$order->payment_status}}" name="payment_status">
                                                <input type="hidden" value="{{$order->pay}}" name="pay">
                                                <input type="hidden" value="{{$order->due}}" name="due">
                                                <input type="hidden" value="{{$order->invoice_no}}" name="invoice_no">


{{--                                                <div class="col-md-12">--}}

{{--                                                    <img id="showImage" src="{{asset($order->customer->photo)}}" class="rounded-circle avatar-lg img-thumbnail"--}}
{{--                                                         alt="profile-image">--}}
{{--                                                </div> <!-- end col -->--}}

                                                    <button type="submit" class="badge badge-soft-warning">Complete This Order</button>
                                            </form>



{{--                                            <span class="badge badge-soft-danger">Complete This Order</span>--}}









                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fw-normal">{{$order->payment_status}}</h5>
                                    </td>

                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div> <!-- end .table-responsive-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

</div>
@endsection

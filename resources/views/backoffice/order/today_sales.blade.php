
@php
    $date =date('d-F-Y');
    $today_paid = App\Models\Order::where('order_date', $date)->sum('pay');
@endphp
@extends('layouts.admin_app')

@section('title')
    Today's total Sales are Ksh {{$today_paid}}.00
@endsection

@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">

                        </div>
                        <h4 class="page-title">Today's total Sales are Ksh {{$today_paid}}.00 </h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>

                                <tr>
                                    <th>s1</th>
{{--                                    <th>Photo</th>--}}
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Payment</th>
                                    <th>Invoice</th>
                                    <th>Pay</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $today_sales as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
{{--                                        <td><img src="{{ asset($item->customer->photo) }}" style="width: 50px; height: 40px;"></td>--}}
                                        <td>{{$item->customer->name}}</td>
                                        <td>{{$item->order_date}}</td>
                                        <td>{{$item->payment_status}}</td>
                                        <td>{{$item->invoice_no}}</td>
                                        <td>{{$item->pay}}</td>
                                        <td>
                                            @if($item->order_status == 'complete')
                                                <span class="badge badge-soft-success">Completed</span>
                                            @else
                                                <span class="badge badge-soft-danger">Pending</span>
                                            @endif
                                        </td>
{{--                                        <td>--}}

{{--                                            <a href="{{ url('order/invoice/download/'.$item->id) }}" class="btn btn-info rounded-pill waves-effect waves-light"title="Details">PDF Invoice</i></a>--}}

{{--                                        </td>--}}

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <!-- end row-->

        </div> <!-- container  fluid-->
    </div> <!-- container -->

    <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

@endsection


@extends('layouts.admin_app')

@section('title')
    Sales Report From {{$start_date}} to {{$to_date}} Total: {{$sales->sum('total')}}
@endsection

@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->

            <div class="row clearfix page_header">
                <div class="col-md-4">
                    <h2> Sales Report</h2>
                </div>
                <div class="card-header bg-light-alpha">
                    <form action="" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <div class="form-group">

                                    <input value="{{ $start_date }}" type="date" name="from_date" class="form-control" placeholder="Start Date">
                                    <label for="">Start Date</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group">

                                    <input value="{{ $to_date }}" type="date" name="to_date" class="form-control">
                                    <label for="">End Date</label>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-group">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- end page title -->
            @php
                $date = date("d-m-Y");
                $expense =\App\Models\Expense::where('date', $date)->sum('amount');
            @endphp


            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-md-center"> Sales Report From <strong>{{$start_date}} to {{$to_date}} Total: {{$sales->sum('total')}}</strong></h3>
                        </div>


                        <div class="card-body">

                            @php
                                $grandtotal =0;
                                $totalitem =0;

                            @endphp
{{--                            <h4 class="header-title"> Today's Expense</h4>--}}
{{--                            <h4 style="font-size: 30px;" align="center"> Total : Ksh {{ $expense }}</h4>--}}
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>s1</th>
                                    <th>Date</th>
                                    <th>Products</th>
                                    <th>Unit Price</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Total</th>

                                </tr>
                                </thead>

                                <tbody>

                                @foreach( $sales as $key=> $item)

                                    @php
                                        $totalitem += $item->quantity;
                                        $grandtotal += $item->total;

                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->order_date}}</td>
                                        <td>
                                                {{$item->product_name}}
                                        </td>

                                        <td>{{$item->unit_cost}}</td>
                                        <td class="text-right">{{ $item->quantity}}</td>
                                        <td class="text-right">{{ $item->total}}</td>




                                    </tr>

                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right"><strong>Total Items: {{$sales->sum('quantity')}}</strong></th>
                                    <th class="text-right"><strong>Total: {{$sales->sum('total')}}</strong></th>
                                </tr>
                                </tfoot>
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

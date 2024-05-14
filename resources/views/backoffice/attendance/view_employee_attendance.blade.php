@extends('layouts.admin_app')

@section('title')
   All Employee Attendance
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
                        <h4 class="page-title">All Employee Attendance</h4>
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Attend Status</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach( $details as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><img src="{{ asset($item->employee->photo) }}" style="width: 50px; height: 40px;"></td>
                                        <td>{{$item->employee->name}}</td>


                                        <td>{{$item->date}}</td>
                                        <td>{{$item->attend_status}}</td>

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


@extends('layouts.admin_app')

@section('title')
     Employee Attendance List
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
                                <ol class="breadcrumb m-0">
                                    <a href="{{route('add.employee.attendance')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Add Employee Attendance</a>
                                </ol>
                            </div>
                            <h4 class="page-title">Employee Attendance List</h4>
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
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allData as $key=>$item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ date('Y-m-d', strtotime($item->date))}}</td>



                                            <td>
                                                <a href="{{ route('employee.attend.edit', $item->date)  }}" class="btn btn-blue rounded-pill waves-effect waves-light"><i class="fa fa-pencil-alt"></i></a>
                                                <a href="{{ route('employee.attend.view', $item->date)  }}" class="btn btn-info rounded-pill waves-effect waves-light" id="details" title="Details"><i class="fa fa-eye"></i></a>
                                            </td>


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

            </div> <!-- container -->

            <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />



    </div>
@endsection

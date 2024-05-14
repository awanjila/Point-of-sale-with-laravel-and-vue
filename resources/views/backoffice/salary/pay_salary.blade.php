@extends('layouts.admin_app')

@section('title')
    Pay Salary
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
                                    <a href="{{route('advance_salary.add')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Add Advance Salary</a>
                                </ol>
                            </div>
                            <h4 class="page-title">All Pay Salary</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">{{ date("F Y") }}</h4>
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>

                                    <tr>
                                        <th>s1</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Month</th>
                                        <th>Salary</th>
                                        <th>Advance</th>
                                        <th>Due</th>
                                        <th>Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employee as $key=>$item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td><img src="{{ asset($item->photo) }}" style="width: 50px; height: 40px;"></td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->phone}}</td>
                                            <td><span class="badge bg-info">{{ date("F", strtotime('-1 month')) }}</span></td>
                                            <td>{{$item->salary}}</td>
                                            <td>
                                                @if($item->advance->advance_salary == NULL)
                                                    <p>No Advance</p>
                                                @else

                                                    {{$item->advance->advance_salary}}

                                                @endif

                                            </td>
                                            <td>
                                                @php
                                                    $amount =$item->salary - $item->advance->advance_salary;
                                                @endphp

                                                <strong>{{ round($amount) }}</strong>
                                            </td>
                                            <td>

                                                <a href="{{route('pay.now.salary', $item->id)}}" class="btn btn-blue rounded-pill waves-effect waves-light">Pay
                                                    {{$item->name}}</a>

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

            </div> <!-- container fluid -->
        </div> <!-- container-->

            <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

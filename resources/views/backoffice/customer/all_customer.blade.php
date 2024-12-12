@extends('layouts.admin_app')

@section('title')
   Customers
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
                                        <a href="{{route('customer.add')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Add Customer</a>
                                    </ol>
                                </div>
                                <h4 class="page-title">Customers</h4>
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
                                            <th>Photo</th>
                                            <th>Name</th>
{{--                                            <th>Email</th>--}}
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $customers as $key=> $customer)
                                        <tr>
                                            <td>{{$key+1}}</>
                                            <td><img src="{{ asset($customer->photo) }}" style="width: 50px; height: 40px;"></td>
                                            <td>{{$customer->name}}</td>
{{--                                            <td>{{$customer->email}}</td>--}}
                                            <td>{{$customer->phone}}</td>
                                            <td>

                                                <a href="{{route('edit.customer', $customer->id)}}" class="btn btn-blue rounded-pill waves-effect waves-light"title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                                <a href="{{route('delete.customer', $customer->id)}}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"title="Delete"><i class="fa fa-trash-alt"></i></a>
                                                <a href="{{route('details.customer', $customer->id)}}" class="btn btn-info rounded-pill waves-effect waves-light" id="details" title="Details"><i class="fa fa-eye"></i></a>
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

                </div> <!-- container  fluid-->
            </div> <!-- container -->

                <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

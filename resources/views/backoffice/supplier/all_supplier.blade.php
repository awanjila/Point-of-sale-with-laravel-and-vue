@extends('layouts.admin_app')

@section('title')
   Suppliers
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
                                        <a href="{{route('supplier.add')}}" class="btn btn-primary rounded-pill waves-effect waves-light"> Add Supplier</a>
                                    </ol>
                                </div>
                                <h4 class="page-title">suppliers</h4>
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
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $suppliers as $key=> $supplier)
                                        <tr>
                                            <td>{{$key+1}}</>
                                            <td><img src="{{ asset($supplier->photo) }}" style="width: 50px; height: 40px;"></td>
                                            <td>{{$supplier->name}}</td>
                                            <td>{{$supplier->email}}</td>
                                            <td>{{$supplier->phone}}</td>
                                            <td>{{$supplier->type}}</td>
                                            <td>

                                                <a href="{{route('edit.supplier', $supplier->id)}}" class="btn btn-blue rounded-pill waves-effect waves-light" title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                                <a href="{{route('delete.supplier', $supplier->id)}}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete" title="Delete"><i class="fa fa-trash"></i></a>
                                                <a href="{{route('details.supplier', $supplier->id)}}" class="btn btn-info rounded-pill waves-effect waves-light" id="details" title="Details"><i class="fa fa-eye"></i></a>
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
            </div> <!-- container-fluid -->

                <link href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{asset('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{asset('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

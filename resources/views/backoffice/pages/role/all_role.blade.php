@extends('layouts.admin_app')

@section('title')
    Roles
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
                                <a href="{{route('role.add')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Add Role</a>
                            </ol>
                        </div>
                        <h4 class="page-title">Roles</h4>
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
                                    <th>Role Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $roles as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->name}}</td>

                                        <td>

                                            <a href="{{route('edit.role', $item->id)}}" class="btn btn-blue rounded-pill waves-effect waves-light"title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                            <a href="{{route('delete.role', $item->id)}}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"title="Delete"><i class="fa fa-trash-alt"></i></a>
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

@extends('layouts.admin_app')

@section('title')
   Users
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
                                <a href="{{route('add.admin')}}" class="btn btn-primary rounded-pill waves-effect waves-light">Add Admin</a>
                            </ol>
                        </div>

                        <h4 class="page-title">All Admin <span class="btn btn-danger">{{ count($all_user) }}</span></h4>
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
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $all_user as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><img src="{{(!empty($item->photo))? url('upload/admin_image/'.$item->photo) : url('upload/no_image.jpg')}}" style="width: 50px; height: 40px;"></td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->phone}}</td>
                                        <td>
                                            @foreach($item->roles as $role)

                                                @if($role->name == 'SuperAdmin')
<span class="badge badge bg-danger">{{$role->name}}</span>

                                                @else

                                                    <span class="badge badge bg-success">{{$role->name}}</span>


                                                @endif



                                        @endforeach

                                        </td>
                                        <td>

                                            <a href="{{route('edit.admin', $item->id)}}" class="btn btn-blue rounded-pill waves-effect waves-light"title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                            <a href="{{route('delete.admin', $item->id)}}" class="btn btn-danger rounded-pill waves-effect waves-light" id="delete"title="Delete"><i class="fa fa-trash-alt"></i></a>

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

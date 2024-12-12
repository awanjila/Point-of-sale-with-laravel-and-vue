
@extends('layouts.admin_app')

@section('title')
    Add Admin
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="{{route('store.admin')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Admin</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label"> Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" >

                                @error('name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div><div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" >

                                @error('email')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" >

                                @error('phone')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" >

                                @error('password')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Assign Roles </label>
                                <select name="roles" class="form-select form-group @error('role_id') is-invalid @enderror" id="example-select">
                                    <option selected="disabled">Select Role</option>
                                    @foreach($roles as $role)
                                        <option  value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->


    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    name: {
                        required : true,
                    },
                    roles: {
                        required : true,
                    },
                    email: {
                        required : true,
                    },
                    phone: {
                        required : true,
                    },

                    photo: {
                        required : true,
                    },
                    password: {
                        required : true,
                    },
                },
                messages :{
                    name: {
                        required : 'Please Enter Product Name',
                    },
                    roles: {
                        required : 'Please Select Category',
                    },

                    email: {
                        required : 'Please Enter Product Store',
                    },

                    phone: {
                        required : 'Please Enter a Phone Number',
                    },

                    password: {
                        required : 'Please Enter a Password',
                    },

                    photo: {
                        required : 'Please Add A Photo',
                    },

                },
                errorElement : 'span',
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

@endsection


@extends('layouts.admin_app')

@section('title')
    Edit Role
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="{{route('role.update')}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $role->id }}">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Role</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control @error('role_name') is-invalid @enderror" id="name"  value="{{$role->name}}">

                                @error('role_name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>


                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->


    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    role_name: {
                        required : true,
                    },


                },
                messages :{
                    role_name: {
                        required : 'Please Enter Role Name',
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

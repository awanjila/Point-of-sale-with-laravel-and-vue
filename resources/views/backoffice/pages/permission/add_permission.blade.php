
@extends('layouts.admin_app')

@section('title')
    Add Permission
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="{{route('permission.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Permission</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Permission Name</label>
                                <input type="text" name="permission_name" class="form-control @error('permission_name') is-invalid @enderror" id="name" >

                                @error('permission_name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Group  Name</label>
                                <select type="text" name="group_name" class="form-control @error('group_name') is-invalid @enderror" id="example-select">
                                    <option value="">Select Group </option>
                                    <option value="pos">Pos</option>
                                    <option value="employee">Employee</option>
                                    <option value="customer">Customer</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="salary">Salary</option>
                                    <option value="attendance">Attendance</option>
                                    <option value="product">Product</option>
                                    <option value="expense">Expense</option>
                                    <option value="orders">Orders</option>
                                    <option value="stock">Stock</option>
                                    <option value="roles">Roles</option>
                                    <option value="admin">Admin</option>



                                </select>

                                @error('group_name')
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
                    permission_name: {
                        required : true,
                    },
                    group_name: {
                        required : true,
                    },

                },
                messages :{
                    permission_name: {
                        required : 'Please Enter Permission Name',
                    },
                    group_name: {
                        required : 'Please Select A Group Name',
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

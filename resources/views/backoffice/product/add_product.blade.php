
@extends('layouts.admin_app')

@section('title')
   Add Product
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Product Info</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" id="name" >

                                @error('product_name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                            </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Category </label>
                                <select name="category_id" class="form-select form-group @error('category_id') is-invalid @enderror" id="example-select">
                                    <option disabled selected >Select Category</option>
                                    @foreach($categories as $category)
                                        <option  value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="supplier" class="form-label">Supplier </label>
                                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" id="example-select">
                                    <option disabled selected>Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option  value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group mb-3">--}}
{{--                                <label for="phone" class="form-label">Product Code</label>--}}
{{--                                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" id="product_code" value="EJM10">--}}

{{--                                @error('product_code')--}}
{{--                                <span class="text-danger"> {{$message}}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div> <!-- end col -->--}}

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Buying Price</label>
                                <input type="text" name="buying_price" class="form-control @error('buying_price') is-invalid @enderror" id="buying_price">

                                @error('buying_price')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Selling Price</label>
                                <input type="text" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price">

                                @error('selling_price')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Product Quantity</label>
                                <input type="number" name="product_store" class="form-control @error('product_store') is-invalid @enderror" id="product_store">

                                @error('product_store')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group mb-3">--}}
{{--                                <label for="phone" class="form-label">Selling Price</label>--}}
{{--                                <input type="text" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price">--}}

{{--                                @error('selling_price')--}}
{{--                                <span class="text-danger"> {{$message}}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div> <!-- end col -->--}}

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="buying_date" class="form-label">Buying Date</label>
                                <input type="date" name="buying_date" class="form-control @error('buying_date') is-invalid @enderror" id="buying_date">

                                @error('buying_date')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Expire Date</label>
                                <input type="date" name="expire_date" class="form-control @error('expire_date') is-invalid @enderror" id="expire_date">

                                @error('expire_date')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="example-fileinput" class="form-label">Product Image</label>
                                <input type="file" name="product_image" class="form-control" id="image">

                            </div>

                            <img id="showImage" src="{{(!empty($product->product_image))? url('upload/product/'.$product->product_image) : url('upload/no_image.jpg')}}" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
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
                    product_name: {
                        required : true,
                    },
                    category_id: {
                        required : true,
                    },
                    supplier_id: {
                        required : true,
                    },
                    product_store: {
                        required : true,
                    },
                    buying_date: {
                        required : true,
                    },
                    expire_date: {
                        required : true,
                    },
                    buying_price: {
                        required : true,
                    },
                    selling_price: {
                        required : true,
                    },

                },
                messages :{
                    product_name: {
                        required : 'Please Enter Product Name',
                    },
                    category_id: {
                        required : 'Please Select Category',
                    },
                    supplier_id: {
                        required : 'Please Select Supplier',
                    },
                    product_store: {
                        required : 'Please Enter Product Quantity',
                    },
                    buying_date: {
                        required : 'Please Select Buying Date',
                    },
                    expire_date: {
                        required : 'Please Select Expire Date',
                    },
                    buying_price: {
                        required : 'Please Enter Buying Price',
                    },
                    selling_price: {
                        required : 'Please Enter Selling Price',
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



    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e){
                var reader = new FileReader();
                reader.onload = function (e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

        });
    </script>
@endsection

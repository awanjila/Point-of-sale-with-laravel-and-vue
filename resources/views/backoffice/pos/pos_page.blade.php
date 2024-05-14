    @extends('layouts.admin_app')

    @section('title')
        POS
    @endsection

    @section('content')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <!-- Start Content-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">POS</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">POS</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6 col-xl-6" style="height: 700px; overflow: auto;">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered border-primary mb-0">
                                    <thead>
                                        <tr>
                                         <th>Name</th>
                                         <th>QTY</th>
                                         <th>Price</th>
                                         <th>Sub Total</th>
                                         <th>Action</th>
                                        </tr>
                                     </thead>
                            @php
                            $allcart = Cart::content();
                            @endphp
                                    <tbody>
                                    @foreach($allcart as $cart)
                                        <tr>
                                            <td>{{$cart->name}}</td>
                                             <td>
                                                 <form method="post" action="{{ url('/cart-update/' .$cart->rowId) }}">
                                                     @csrf

                                                <input type="number" name="qty" value="{{$cart->qty}}" style="width:40px;" min="1">
                                                 <button type="submit" class="btn btn-sm btn-success" style="margin-top: -2px;"><i class="fas fa-check"></i> </button>
                                                 </form>
                                             </td>
                                              <td>{{$cart->price}}</td>
                                              <td>{{$cart->price * $cart->qty }}</td>
                                              <td><a href="{{ url('/cart-remove/' .$cart->rowId) }}"><i class="fas fa-trash"></i></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                            </table>
            </div>
                <div class="bg-primary">
                    <br>
                    <p style="font-size: 18px; color: #fff;">Quantity: {{Cart::count()}} items</p>
                    <p style="font-size: 18px;  color: #fff;">Subtotal: Ksh {{Cart::subtotal()}}</p>
                    <p style="font-size: 18px;  color: #fff;">Vat: {{Cart::tax()}}</p>
                    <p><h2 class="text-white">Total</h2> <h1 class="text-white">Kes {{ cart::total()  }}</h1>
                    </br>

                </div>
    <br>

        <form id="myForm" method="post"  action="{{ route('create.invoice') }}">
            @csrf
                                <div class="form-group mb-3">
                                    <label for="firstname" class="form-label">All Customer </label>
                                    <a href="{{route('customer.add')}}" class="btn btn-primary rounded-pill waves-effect waves-light mb-2">Add Customer</a>
                                    <select name="customer_id" class="form-select"  id="example-select">
                                        <option disabled selected value="">Select Customer</option>
                                        @foreach($customer as $cust)
                                            <option  value="{{$cust->id}}">{{$cust->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('customer_id')
                                    <span class="text-danger"> {{$message}}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-blue waves-effect"> Create Invoice</button>
        </form>

    </br>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col-->

                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                    <tr>
                                        <th>s1</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $product as $key=> $item)
                                        <tr>
                                            <form method="post" action="{{ route('add.to.cart') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$item->id}}">
                                                <input type="hidden" name="name" value="{{$item->product_name}}">
                                                <input type="hidden" name="price" value="{{$item->selling_price}}">
                                                <input type="hidden" name="qty" value="1">

                                            <td>{{$key+1}}</td>
{{--                                            <td><img src="{{ asset($item->product_image) }}" style="width: 50px; height: 40px;"></td>--}}
                                            <td>{{$item->product_name}}</td>
                                                <td>{{$item->selling_price}}</td>

                                            <td><button type="submit" style="font-size: 20px; color: #000;"><i class="fas fa-plus-square"></i></button> </td>

                                            </form>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>

            <!-- end row-->

        </div> <!-- container -->



    @endsection

    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    customer_id: {
                        required : true,
                    },

                },
                messages :{
                    customer_id: {
                        required : 'Please Select a customer',
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


@extends('layouts.admin_app')

@section('title')
    Order Details
@endsection

@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Order Details</h5>
                    <div class="row">

                        <form method="POST" action="{{route('order.status.update')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $order->id }}" name="id">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Customer Name</label>
                                <p class="text-danger">{{ $order->customer->name}}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Customer Email </label>
                                <p class="text-danger">{{$order->customer->email}}</p>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Customer Address</label>
                                <p class="text-danger">{{$order->customer->address}}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Customer Phone</label>
                                <p class="text-danger">{{$order->customer->phone}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Order date</label>
                                <p class="text-danger">{{$order->order_date}}</p>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Payment Status</label>
                                <p class="text-danger">{{$order->payment_status}}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Paid Amount</label>
                                <p class="text-danger">{{$order->pay}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Balance</label>
                                <p class="text-danger">{{$order->due}}</p>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Invoice Number</label>
                                <p class="text-danger">{{$order->invoice_no}}</p>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <img id="showImage" src="{{asset($order->customer->photo)}}" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
                        </div> <!-- end col -->


                <div class="text-end">
                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Complete Order</button>
                </div>
            </form>
                    </div> <!-- end row -->

            </div>
        </div>
    </div>

    <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped dt-responsive nowrap w-100">
                            <thead>

                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Qty</th>
                                <th>Selling Price</th>

                                <th>Total(+vat)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $order_item as $key=> $item)
                                <tr>
                                    <td><img src="{{ asset($item->product->product_image) }}" style="width: 50px; height: 40px;"></td>
                                    <td>{{$item->product->product_name}}</td>
                                    <td>{{$item->product->product_code}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->unit_cost}}</td>
                                    <td>{{$item->total}}</td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->


            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->

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

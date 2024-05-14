
@extends('layouts.admin_app')

@section('title')
    Add Supplier
@endsection

@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('supplier.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$supplier->id}}">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                    <div class="row">


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Supplier Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{$supplier->name}}">

                                @error('name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Supplier Email </label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{$supplier->email}}">
                                @error('email')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Supplier Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{$supplier->address}}">

                                @error('address')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Supplier Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{$supplier->phone}}">

                                @error('phone')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Supplier Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" value="{{$supplier->location}}">

                                @error('location')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Supplier Company</label>
                                <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" id="phone" value="{{$supplier->company}}">

                                @error('company')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Supplier Type</label>
                                <select  name="type" class="form-select @error('type') is-invalid @enderror" id="phone">

                                    <option selected disabled> Select Type</option>
                                    <option value="Distributor"> Distributor</option>
                                    <option value="Whole Seller"> Whole Seller</option>

                                </select>

                                @error('type')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Supplier Image</label>
                                <input type="file" name="photo" class="form-control" id="image">

                            </div>

                            <img id="showImage" src="{{(!empty($supplier->photo))? url('upload/supplier/'.$supplier->photo) : url('upload/no_image.jpg')}}" class="rounded-circle avatar-lg img-thumbnail"
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

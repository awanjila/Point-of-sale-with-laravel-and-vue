@extends('layouts.admin_app')

@section('title')
  Change Password
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Wabe Creative</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Change Password</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card text-center">
                    <div class="card-body">
                        <img id="showImage" src="{{(!empty($adminData->photo))? url('upload/admin_image/'.$adminData->photo) : url('upload/no_image.jpg')}}" class="rounded-circle avatar-lg img-thumbnail"
                             alt="profile-image">

                        <h4 class="mb-0">{{$adminData->name}}</h4>


                        <div class="text-start mt-3">

                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">{{$adminData->name}}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">{{$adminData->phone}}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2">{{$adminData->email}}</span></p>
                        </div>

                        <ul class="social-list list-inline mt-3 mb-0">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div> <!-- end card -->



            </div> <!-- end col-->

            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                                <form method="POST" action="{{route('admin.update.password')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Old Password</label>
                                                <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="current_password">
                                            </div>
                                            @error('old_password')
                                            <span class="text-danger"> {{$message}}</span>
                                            @enderror
                                        </div><!-- end col -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">New Password</label>
                                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="current_password">
                                            </div>
                                            @error('new_password')
                                            <span class="text-danger"> {{$message}}</span>
                                            @enderror
                                        </div><!-- end col -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Confirm New Password</label>
                                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                                            </div>
                                        </div><!-- end col -->
                                    </div> <!-- end row -->
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Update</button>
                                    </div>
                                </form>



                    </div>
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->


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

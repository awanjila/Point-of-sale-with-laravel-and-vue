
@extends('layouts.admin_app')

@section('title')
   Add Employee
@endsection

@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('employee.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="Wanjila Muchika">

                                @error('name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                            </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="email@yourcompany.com">
                                @error('email')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                    </div>  <!-- end row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Salary</label>
                                <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary">

                                @error('salary')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">


                            <div class="mb-3">
                                <label for="useremail" class="form-label">Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="city" value="Nairobi">
                                @error('location')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                    </div>  <!-- end row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="Umoja Area">

                                @error('address')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Vacation</label>
                                <input type="text" name="vacation" class="form-control @error('vacation') is-invalid @enderror" id="vacation">
                                @error('vacation')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                    </div>  <!-- end row -->
                    <div class="row">


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Employee Experience</label>

                                <select name="experience" class="form-select @error('experience') is-invalid @enderror" id="example-select">
                                    <option selected="disabled">How Many Years have you Worked?</option>
                                    <option  value="1 year">1 Year</option>
                                    <option value="2 year">2 Years</option>
                                    <option value="3 year">3 Years</option>
                                    <option value="4 year">4 Years</option>
                                </select>
                                @error('experience')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('email') is-invalid @enderror" id="phone" value="0781312070">

                                @error('phone')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Employee Image</label>
                                <input type="file" name="photo" class="form-control" id="image">\

                            </div>

                            <img id="showImage" src="{{(!empty($employee->photo))? url('upload/employee/'.$employee->photo) : url('upload/no_image.jpg')}}" class="rounded-circle avatar-lg img-thumbnail"
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

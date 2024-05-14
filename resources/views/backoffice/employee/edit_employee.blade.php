

@extends('layouts.admin_app')

@section('title')
    Edit Employee Details
@endsection

@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('employee.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$employee->id}}">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{$employee->name}}">

                                @error('name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{$employee->email}}">
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
                                <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{$employee->salary}}">

                                @error('salary')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">


                            <div class="mb-3">
                                <label for="useremail" class="form-label">City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="city" value="{{$employee->city}}">
                                @error('city')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                    </div>  <!-- end row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{$employee->address}}">

                                @error('address')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Vacation</label>
                                <input type="text" name="vacation" class="form-control @error('vacation') is-invalid @enderror" value="{{$employee->vacation}}">
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
                                    <option  value="1 year {{ $employee->experience =='1 year' ? 'selected' : ''}}">1 Year</option>
                                    <option value="2 years {{ $employee->experience =='2 years' ? 'selected' :''}}">2 Years</option>
                                    <option value="3 years {{ $employee->experience =='3 years' ? 'selected' :''}}">3 Years</option>
                                    <option value="4 years {{ $employee->experience =='4 years' ? 'selected' :''}}">4 Years</option>
                                </select>
                                @error('experience')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="email" value="{{$employee->phone}}">

                                @error('phone')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Employee Image</label>
                                <input type="file" name="photo" class="form-control" id="image">

                            </div>

                            <img id="showImage" src="{{asset($employee->photo)}}" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
                        </div> <!-- end col -->
                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
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

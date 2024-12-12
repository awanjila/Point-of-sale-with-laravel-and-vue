
@extends('layouts.admin_app')

@section('title')
    Add Advance Salary
@endsection

@section('content')

    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('advance_salary.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Advance Salary</h5>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" id="example-select">
                                    <option selected="disabled">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option  value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>

                                @error('employee_id')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Advance Salary</label>
                                <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" id="salary">

                                @error('salary')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div><!-- end col -->

                    </div>  <!-- end row -->
                    <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Salary Month" class="form-label">Salary Month</label>

                                    <select name="month" class="form-select @error('month') is-invalid @enderror" id="example-select">
                                        <option selected="disabled">Salary Month</option>
                                        <option  value="January">January</option>
                                        <option value=February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option  value="May">May</option>
                                        <option value=June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option  value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="Novemebr">November</option>
                                        <option value="December">December</option>

                                    </select>
                                    @error('month')
                                    <span class="text-danger"> {{$message}}</span>
                                    @enderror
                                </div>
                            </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Salary Year" class="form-label">Salary Year</label>

                                <select name="year" class="form-select @error('year') is-invalid @enderror" id="example-select">
                                    <option selected="disabled">Salary Year</option>
                                    <option  value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                </select>
                                @error('year')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->

{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}

{{--                                <textarea type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" placeholder="Remarks"></textarea>--}}

{{--                            </div>--}}
{{--                        </div>--}}


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->

@endsection

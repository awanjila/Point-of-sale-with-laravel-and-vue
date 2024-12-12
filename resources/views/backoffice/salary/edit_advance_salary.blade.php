
@extends('layouts.admin_app')

@section('title')
    Edit Advance Salary
@endsection

@section('content')

    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('advance_salary.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$advanced_salary->id}}">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit Advance Salary</h5>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" id="example-select">
                                    <option selected="disabled">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option  value="{{$employee->id}}" {{$employee->id == $advanced_salary->employee_id ? 'selected' : ''}}>{{$employee->name}}</option>
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
                                <input type="text" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{$advanced_salary->advance_salary}}" >

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
                                        <option  value="January" {{$advanced_salary->month == 'January' ? 'selected' : ''}}>January</option>
                                        <option value=February" {{$advanced_salary->month == 'February' ? 'selected' : ''}}>February</option>
                                        <option value="March" {{$advanced_salary->month == 'March' ? 'selected' : ''}}>March</option>
                                        <option value="April" {{$advanced_salary->month == 'April' ? 'selected' : ''}}>April</option>
                                        <option  value="May" {{$advanced_salary->month == 'May' ? 'selected' : ''}}>May</option>
                                        <option value=June" {{$advanced_salary->month == 'June' ? 'selected' : ''}}>June</option>
                                        <option value="July" {{$advanced_salary->month == 'July' ? 'selected' : ''}}>July</option>
                                        <option value="August" {{$advanced_salary->month == 'August' ? 'selected' : ''}}>August</option>
                                        <option  value="September" {{$advanced_salary->month == 'September' ? 'selected' : ''}}>September</option>
                                        <option value="October" {{$advanced_salary->month == 'October' ? 'selected' : ''}}>October</option>
                                        <option value="November" {{$advanced_salary->month == 'November' ? 'selected' : ''}}>November</option>
                                        <option value="December" {{$advanced_salary->month == 'December' ? 'selected' : ''}}>December</option>

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
                                    <option  value="2023" {{$advanced_salary->year == '2023' ? 'selected' : ''}}>2023</option>
                                    <option value="2022" {{$advanced_salary->year == '2022' ? 'selected' : ''}}>2022</option>
                                    <option value="2021" {{$advanced_salary->year == '2021' ? 'selected' : ''}}>2021</option>
                                    <option value="2020" {{$advanced_salary->year == '2020' ? 'selected' : ''}}>2020</option>
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
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->

@endsection

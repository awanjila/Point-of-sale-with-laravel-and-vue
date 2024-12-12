
@extends('layouts.admin_app')

@section('title')
    Paid Salary
@endsection

@section('content')

    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('pay.salary.store')}}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{$paysalary->id}}">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Paid Salary</h5>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <strong>{{$paysalary->name}}</strong>
                                <input type="hidden" name="name" value="{{$paysalary->name}}">
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Due Salary</label>
                                @php
                                    $amount =$paysalary->salary - $paysalary->advance->advance_salary;
                                @endphp

                                <strong>

                                    @if($paysalary->advance->advance_salary== NULL)

                                        <span> No advance Salary</span>

                                    @else
                                        {{ round($amount) }}
                                    @endif

                                </strong>

                                <input type="hidden" name="due" value="{{$amount}}">
                            </div>
                        </div><!-- end col -->

                    </div>  <!-- end row -->

                    <div class="row">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Employee Salary</label>
                                <strong>{{$paysalary->salary}}</strong>
                                <input type="hidden" name="paid_amount" value="{{$paysalary->salary}}">
                            </div>
                        </div> <!-- end col -->



                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Advance Salary</label>
                                <strong>{{$paysalary->advance->advance_salary}}</strong>
                            </div>
                            <input type="hidden" name="advance_salary" value="{{$paysalary->advance->advance_salary}}">
                        </div><!-- end col -->




                    </div>  <!-- end row -->



                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Salary Month" class="form-label">Salary Month</label>

                                <strong>{{ date("F", strtotime('-1 month')) }}</strong>
                            </div>
                            <input type="hidden" name="month" value="{{ date("F", strtotime('-1 month')) }}">
                        </div> <!-- end col -->





                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Salary Year" class="form-label">Salary Year</label>

                                <strong>{{$paysalary->advance->year}}</strong>
                            </div>
                            <input type="hidden" name="year" value="{{$paysalary->year}}">
                        </div> <!-- end col -->


                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Paid Salary</button>
                            <a href="{{route('advance_salary.add')}}" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i>Add Advance </a>
                        </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->

@endsection

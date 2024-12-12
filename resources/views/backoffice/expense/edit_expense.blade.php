

@extends('layouts.admin_app')

@section('title')
    Add Expense
@endsection

@section('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


    <div class="col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('expense.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$expense->id}}">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Edit  expense</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Expense Details</label>
                                <textarea class="form-control" rows="3" name="details"> {{$expense->details}}</textarea>

                                @error('details')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Amount</label>
                                <input type="text" name="amount" class="form-control @error('name') is-invalid @enderror" value="{{$expense->amount}}">

                                @error('amount')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="hidden" name="date" class="form-control"  value="{{date('d-m-Y')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="hidden" name="month" class="form-control"  value="{{date('F')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="hidden" name="year" class="form-control"  value="{{date('Y')}}">
                            </div>
                        </div>

                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->




@endsection


@extends('layouts.admin_app')

@section('title')
    Add Role in Permission
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="col-lg-8 col-xl-8">
        <div class="card">
            <div class="card-body">
                <form id="myForm" method="POST" action="{{route('role.permission.store')}}" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Add Role In Permission</h5>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">All Roles</label>
                                <select type="text" name="role_id" class="form-control @error('role_name') is-invalid @enderror" id="example-select">
                                    <option value="">Select Role </option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}} </option>

                                    @endforeach
                                </select>

                                @error('role_name')
                                <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                        </div> <!-- end col -->


                        <div class="form-check mb-2 form-check-primary">

                            <input class="form-check-input" type="checkbox" value="" id="customcheck1" >
                            <label class="form-check-label" for="customcheck1">Select All</label>
                        </div>  <!-- end form check -->
                            <hr>

                        @foreach($permission_groups as $group)
                            <div class="row">
                                <br>
                                <div class="col-3">

                                    <div class="form-check mb-2 form-check-primary">

                                        <input class="form-check-input" type="checkbox" value="" id="customcheck2">
                                        <label class="form-check-label" for="customcheck2">{{$group->group_name}}</label>
                                    </div>  <!-- end form check -->
                                </div>
                                <br>
                                <div class="col-9">

                                    @php
                                    $permissions = App\Models\User::getPermissionGroupName($group->group_name);
                                    @endphp
                                   @foreach($permissions as $permission)

                                    <div class="form-check mb-2 form-check-primary">
                                        <input class="form-check-input" type="checkbox" value="{{$permission->id}}" id="customcheck{{$permission->id}}" name="permission[]">
                                        <label class="form-check-label" for="customcheck3">{{$permission->name}}</label>
                                    </div>  <!-- end form check -->
                                    @endforeach
                                </div>

                            </div> <!-- end row -->

                        @endforeach






                    </div> <!-- end row -->


                    <div class="text-end">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                    </div>
                </form>



            </div>
        </div> <!-- end card-->

    </div> <!-- end col -->

    <script type="text/javascript">
        $('#customcheck1').click(function(){
            if($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }

        });

    </script>



@endsection



        $(document).on('change', '.role', function(e) {
            currTrigger = $(this).find(':selected').text().trim();
            if (currTrigger == 'Guard') {
                $("#businsessField").hide();
                $("#businsessField").hide();
            } else {
                $("#businsessField").show();
            }

        });@extends('layouts.master')

@section('title')
User edit
@endsection

@section('content')
<div class="main-container container-fluid">
    <style>
        #user_photo_selected {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
    <!-- PAGE-HEADER Breadcrumbs-->
    <div style="margin-top:20px">
        Hello {{Auth::user()->first_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
    </div>
    <div class="page-header">
        <h1 class="page-title">User Edit</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/building/user/list')}}">User list</a></li>
                <li class="breadcrumb-item active" aria-current="page">User edit</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="update_user">
                        @csrf
                        <input type="hidden" id="{{$user->id}}" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname" class="form-label mb-0">First name: <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="exampleInputname" name="first_name" required value="{{$user->first_name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname1" class="form-label mb-0">Last name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="exampleInputname1" required name="last_name" value="{{$user->last_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label mb-0">Email address: <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputnumber" class="mb-0 form-label">Phone number: </label>
                                    <input type="text" class="form-control telephone_number cursor-left" name="phone" id="exampleInputnumber" value="{{$user->phone}}" placeholder="+13020..">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <?php
                            $tenant = \Spatie\Permission\Models\Role::where('name', 'Tenant')->first();
                            $guard = \Spatie\Permission\Models\Role::where('name', 'Guard')->first();
                            ?>
                            <div class="col-lg-6" id="" style="display:">
                                <div class="form-group">
                                    <label class="form-label mb-0">Role:</label>

                                    <select class="form-control form-select " id="role" name="role" required>
                                        <option value="{{$tenant->id}}" {{$user->hasRole($tenant) ? 'selected':''}}>{{$tenant->name}}</option>
                                        <option value="{{$guard->id}}" {{$user->hasRole($guard) ? 'selected':''}}>{{$guard->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="businsessField">
                                <div class="form-group">
                                    <label for="exampleInputnumber" class="mb-0 form-label">Buisness Name: </label>
                                    <input type="text" class="form-control" name="buisness_name" id="buisness_name" value="{{$user->buisness_name}}" placeholder="John123..">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label mb-0">Status:</label>
                                    <select class="form-control form-select" name="status">
                                        <option selected disabled>choose status</option>
                                        <option value="active" {{$user->status == 'active' ? 'selected' :''}}>Active</option>
                                        <option value="inactive" {{$user->status == 'blocked' ? 'selected' :''}}>Blocked </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-form-label">
                                <div class="col-12 text-center">
                                    @if(isset($user->image) && $user->image != " ")
                                    <img id="user_photo_selected" src="{{asset('/uploads/files/'.$user->image)}}" alt="" class="img-fluid rounded-circle mx-auto">
                                    @else
                                    <img id="user_photo_selected" src="{{asset('assets/images/users/avatar-121.png')}}" alt="" class="img-fluid rounded-circle mx-auto">
                                    @endif

                                </div>
                                <div id="photo-error" class="text-muted small mt-1 text-center">
                                    Allowed JPG, GIF or PNG. Max size of 2MB
                                </div>

                                <div class="col-12">
                                    <label class="col-form-label" for="">Image</label>
                                    <input type="file" class="form-control imageChange" accept="image/*" id="imageChange" name="photo">

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit"> <i class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ROW -->

    <!-- ROW END -->

</div>
@endsection

@section('bottom-script')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $('.telephone_number').mask('+1999-999-9999');
    $(document).ready(function(e) {
        $(document).on('change', '.imageChange', function(e) {
            photoError = 0;
            if (e.target.files && e.target.files[0]) {
                // console.log(e.target.files[0].name.strtolower())
                if (e.target.files[0].name.match(/\.(jpg|jpeg|JPG|png|gif|PNG)$/)) {
                    $("#photo-error").empty();
                    photoError = 0;
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#user_photo_selected').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);

                } else {
                    photoError = 1;
                    $("#photo-error").empty();
                    $(".btnSubmit").prop('disabled', true);

                    $("#photo-error").append(
                        '<p class="text-danger">Please upload only jpg, png format!</p>');
                }
            } else {
                $('#user_photo_selected').attr('src', '');
            }

            if (photoError == 0) {
                $(".btn-change-photo").prop('disabled', false);
                $("#btnSubmit").attr('disabled', false);
            } else {
                $(".btn-change-photo").prop('disabled', true);
            }
        });


        // update user
        $("#update_user").on('submit', (function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/api/building/user/update',
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function() {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function(response) {
                    console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        // $("#update_user")[0].reset();
                    }
                },
                error: function(error) {
                    // console.log(error);
                }
            });
        }));

        $(document).on('change', '#role', function(e) {
            currTrigger = $(this).find(':selected').text().trim();
            if (currTrigger == 'Guard') {
                $("#businsessField").hide();
                $("#businsessField").hide();
            } else {
                $("#businsessField").show();
            }

        });
    });
</script>
@endsection
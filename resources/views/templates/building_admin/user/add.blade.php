@extends('layouts.master')

@section('title')
User add
@endsection

@section('content')
<style>
    .hide {
        display: none;
    }
</style>
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div style="margin-top:20px">
        Hello {{Auth::user()->first_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
    </div>
    @if(Auth::user()->hasRole('Admin'))
    <div class="page-header">
        <h1 class="page-title">User Add</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">User add</li>
            </ol>
        </div>
    </div>
    @elseif(Auth::user()->hasRole('Integrator'))
    <div class="page-header">
        <h1 class="page-title">Building Admin Add</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">Building Admins</a></li>
                <li class="breadcrumb-item active" aria-current="page">Building Admin add</li>
            </ol>
        </div>
    </div>
    @else
    <div class="page-header">
        <h1 class="page-title">User Add</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">User list</a></li>
                <li class="breadcrumb-item active" aria-current="page">User add</li>
            </ol>
        </div>
    </div>
    @endif
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="add_user">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname" class="form-label mb-0">First name: <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="First name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname1" class="form-label mb-0">Last name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" required name="last_name" placeholder="Enter last name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $tenant = \Spatie\Permission\Models\Role::where('name', 'Tenant')->first();
                            $guard = \Spatie\Permission\Models\Role::where('name', 'Guard')->first();
                            ?>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label mb-0">Role: <span class="text-danger">*</span></label>
                                    <select class="form-control form-select {{Auth::user()->hasRole('Admin')  ? '' : 'role'}}" id="roleId" name="role" required>
                                        <option value="">choose role</option>
                                        <option value="{{$tenant->id}}">{{$tenant->name}}</option>
                                        <option value="{{$guard->id}}">{{$guard->name}}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6" id="divSiteId" style="display:none">
                                <div class="form-group">
                                    <label for="exampleInputname1" class="form-label mb-0">Buisness name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="buisness_name" name="buisness_name" placeholder="Enter business name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label mb-0">Email address: <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required id="email" placeholder="Email address">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="fw-bold mb-1">Phone Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control telephone_number cursor-left" name="phone" id="phone" placeholder="+13020.." onfocus="CursorPosition()">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary btnSubmit" id="btnSubmit"> <i class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save</button>
                            <!-- <input type="button" class="btn btn-danger my-1" value="Cancel"> -->
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ROW END -->
</div>


@endsection

@section('bottom-script')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $('.telephone_number').mask('+1999-999-9999', {
        autoclear: false
    });
    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // initialise plugin
    var iti = window.intlTelInput(input, {
        utilsScript: "../../build/js/utils.js?1638200991544"
    });

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

    //on focus phone input
    function CursorPosition() {
        const input = document.getElementById('#phone');
        input.focus();
        input.setSelectionRange(0, 0);
    }

    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
</script>
<script>
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

        // add user
        $("#add_user").on('submit', (function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var phone = $("#phone").val();
            formData.append('phone', phone);
            $.ajax({
                url: '/api/building/user/add',
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
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#add_user")[0].reset();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }));

        $("#roleId").on('change', function(e) {
            if ($(this).val() == 2) {
                $("#divSiteId").css('display', 'block');
            } else {
                $("#divSiteId").css('display', 'none');
            }
        });

    });
</script>

@endsection
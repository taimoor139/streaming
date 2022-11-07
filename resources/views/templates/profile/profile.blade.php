@extends('layouts.master')

@section('title')
Profile
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">
    <style>
        #user_photo_selected {
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- PAGE-HEADER Breadcrumbs-->
      <div style="margin-top:20px">
        Hello {{Auth::user()->first_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
    </div>
    <div class="page-header">
        <h1 class="page-title">Profile</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-xl-12">
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="text-center chat-image mb-5">
                                <div class="avatar avatar-xxl chat-profile mb-3 brround">
                                    @if(Auth::user()->image==NULL)
                                    <img id="user_photo_selected" alt="avatar"
                                        src="{{asset('assets/images/users/avatar-121.png')}}" class="brround"></a>

                                    @else
                                    <img id="user_photo_selected" src="{{asset('/uploads/files/'.Auth::user()->image)}}"
                                        alt="" class="img-fluid rounded-circle mx-auto">
                                    @endif
                                </div>

                                <div class="main-chat-msg-name">
                                    <h5 class="mb-1 text-dark fw-semibold">{{ucwords(Auth::user()->first_name) }}
                                        {{ ucwords(Auth::user()->last_name)  }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Name :</label>
                                        <input type="text" class="form-control" id="exampleInputname"
                                            value="{{ucwords(Auth::user()->first_name) }} {{ucwords(Auth::user()->last_name) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Phone number :</label>
                                        <input type="number" class="form-control" id="exampleInputnumber"
                                            value="{{ucwords(Auth::user()->ph_number) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Email :</label>
                                        <input class="form-control" type="email"
                                            value="{{ucwords(Auth::user()->email) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end pt-2 px-3">
                        <a role="button" class="btn btn-dealer" href="{{url('/profile/edit')}}">
                            <span class="fe fe-edit fs-14"></span> Edit profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        $("#ach").on('click', function (e) {
            $("#achshow").css('display', 'flex');
            $("#cridtshow").hide();


        })

        $("#credit").on('click', function (e) {
            $("#creditshow").css('display', 'flex');
            $("#achshow").hide();


        })

        $("#mailIn").on('click', function (e) {
            $("#creditshow").hide();

            $("#achshow").hide();


        })
    })

</script>

@endsection

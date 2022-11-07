@extends('layouts.master')

@section('title')
User detail
@endsection

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div style="margin-top:20px">
        Hello {{Auth::user()->buisness_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
    </div>
    <div class="page-header">
        <h1 class="page-title">User detail</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">User list</a></li>
                <li class="breadcrumb-item active" aria-current="page">User detail</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row" id="user-profile">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0 mb-0">
                    <div class="wideget-user mb-2">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row my-5">
                                    <div class="col-12 text-center">

                                        @if(isset($user->image) && $user->image != " ")
                                        <img class="img-fluid rounded-circle mt-2" src="{{asset('/uploads/files/'.$user->image)}}" style="width:220px;height:220px;object-fit:cover;" alt="user image">
                                        @else
                                        <img id="user_photo_selected" class="img-fluid rounded-circle mx-auto" src="{{asset('assets/images/users/avatar-121.png')}}" style="width:220px;height:220px;object-fit:cover; " alt="user image">
                                        @endif

                                    </div>
                                    <div class="profile-img-content text-dark text-center mt-5">
                                        <div class="text-dark">
                                            <h3 class="h3 mb-2">{{ucwords($user->first_name)}} {{ucwords($user->last_name)}}</h3>
                                            <h5 class="text-muted">{{ucwords($user->city)}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">About
                                            <!-- <a href="{{url('/profile/edit')}}">
                                                <i class="fe fe-edit-3 text-primary ms-2"></i>

                                            </a> -->
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        @if($user->address == NULL)

                                        @else
                                        <div class="d-flex align-items-center mb-3 mt-3">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-location fs-20"></i></span>
                                            </div>
                                            <div>
                                                <strong>{{ucwords($user->address)}}, {{ucwords($user->zip)}} </strong>
                                            </div>
                                        </div>
                                        @endif

                                        @if($user->country == NULL)

                                        @else
                                        <div class="d-flex align-items-center mb-3 mt-3">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-map-pin fs-20"></i></span>
                                            </div>
                                            <div>
                                                <strong>{{ucwords($user->state)}}, {{ucwords($user->country)}}</strong>
                                            </div>
                                        </div>
                                        @endif

                                        @if($user->ph_number == NULL)

                                        @else
                                        <div class="d-flex align-items-center mb-3 mt-3">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-phone fs-20"></i></span>
                                            </div>
                                            <div>
                                                <strong>{{$user->ph_number}} </strong>
                                            </div>
                                        </div>
                                        @endif

                                        @if($user->email == NULL)

                                        @else
                                        <div class="d-flex align-items-center mb-3 mt-3">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-mail fs-20"></i></span>
                                            </div>
                                            <div>
                                                <strong>{{$user->email}} </strong>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL-END -->
    </div>
    <!-- ROW END -->
</div>
@endsection
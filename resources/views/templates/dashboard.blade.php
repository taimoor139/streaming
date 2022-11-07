@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content')

@php
use \App\Http\Controllers\PickupController;
@endphp
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">

       
        @if(Auth::user()->hasRole('Tenant'))
        <div class="col-12 mb-3">
            Hello {{Auth::user()->buisness_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
        </div>
        @else
        <div class="col-12 mb-3">
            Hello {{Auth::user()->first_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
        </div>
        @endif
        @if(Auth::user()->hasRole('Guard'))
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Recent Clients Appointments</h4>
                            <h6 class="mb-0 mt-3 text-muted">List of recent appointments for different clients.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Visitor Name</th>
                                            <th>Visitor Email</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Today's Walkin Visitors</h4>
                            <h6 class="mb-0 mt-3 text-muted">List of today's walkin visitors appointments.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0" id="dataTable">

                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Visitor Name</th>
                                            <th>Visitor Phone</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tBody">


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
        @if(Auth::user()->hasRole('Admin'))
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Sites List</h4>
                            <h6 class="mb-0 mt-3 text-muted">List of sites with number of visitors .</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">

                        <?php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                       
                        ?>

                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Site Name</th>
                                            <th>Registered visitors</th>
                                            <th>Walkin visitors</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sitelist">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Integrators List</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="integrator">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Recent Clients Appointments</h4>
                            <h6 class="mb-0 mt-3 text-muted">List of recent appointments for different clients.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">

                        <?php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                        $apps = App\Models\Appointment::whereDate('created_at', $today)->orderBy('id', 'DESC')->get();
                        ?>

                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                    <tbody>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Visitor Name</th>
                                            <th>Visitor Email</th>
                                            <th>Status</th>
                                        </tr>
                                        @if(sizeof($apps) > 0)
                                        @foreach($apps as $key => $app)
                                        <?php
                                        if ($app->status == "pending") {
                                            $status = '<span class="badge bg-warning text-white p-1" style="border-radius:10px">' . ucwords($app->status) . '</span>';
                                        } elseif ($app->status == "check_in") {
                                            $status = '<span class="badge bg-primary text-white p-1" style="border-radius:10px">Checked In</span>';
                                        } elseif ($app->status == "decline") {
                                            $status = '<span class="badge bg-danger text-white p-1" style="border-radius:10px">' . ucwords($app->status) . '</span>';
                                        }
                                        ?>
                                        <tr>
                                            <td><b>{{ucwords($app->user->first_name)}} {{$app->user->last_name}}</b></td>
                                            <td><b>{{$app->user->email}}</b></td>
                                            <td><b>{{$app->name}}</b></td>
                                            <td><b>{{$app->email}}</b></td>
                                            <td>
                                                <div class="mt-sm-1 d-block text-center">
                                                    {!!$status!!}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Today's Walkin Visitors</h4>
                            <h6 class="mb-0 mt-3 text-muted">List of today's walkin visitors appointments.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <?php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                        $walks = App\Models\WalkinAppointment::whereDate('created_at', $today)->get();
                        ?>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Visitor Name</th>
                                            <th>Appointment Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        @if(sizeof($walks) > 0)
                                        @foreach($walks as $key => $app)
                                        <?php
                                        if ($app->status == "pending") {
                                            $status = '<span class="badge badge bg-warning text-white p-1" style="border-radius:10px">' . ucwords($app->status) . '</span>';
                                        } elseif ($app->status == "approve") {
                                            $status = '<span class="badge bg-primary text-white p-1" style="border-radius:10px">Approve</span>';
                                        } elseif ($app->status == "decline") {
                                            $status = '<span class="badge bg-danger text-white p-1" style="border-radius:10px">' . ucwords($app->status) . '</span>';
                                        }
                                        ?>
                                        <tr>
                                            <td><b>{{ucwords($app->user->first_name)}} {{$app->user->last_name}}</b></td>
                                            <td><b>{{ucwords($app->user->email)}}</b></td>
                                            <td><b>{{ucwords($app->name)}}</b></td>
                                            <td><b>{{date('M d,Y', strtotime($app->date))}}</b></td>
                                            <td>
                                                <div class="mt-sm-1 d-block text-center">
                                                    {!!$status!!}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        
                @if(Auth::user()->hasRole('Integrator'))
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Site Add</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Site Add</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card">
                <div class="card-body px-3 py-2 pt-3">
                    <form id="add_form">
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 mb-1">
                                <label for="" class="fw-bold mb-1">Site name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Site name.." required>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6 mb-1">
                                <label for="" class="fw-bold mb-1">Site Address: <span class="text-danger">*</span></label>
                                                                                        <input type="text" class="form-control" id="address" name="address" placeholder="Address.." required>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 mb-1">
                                <label for="" class="fw-bold mb-1">Status: <span class="text-danger">*</span></label>
                                 <select class="form-control form-select" name="status" required>
                                <option value="">Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">In Active</option>
                            </select>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-4 col-sm-6 mb-1 ">
                                <label for="" class="mb-1"></label>
                                <button id="btnSubmit" type="submit" class="btn btn-primary btn-block"><i class="fa fa-spinner fa-pulse" style="display: none;"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Site List</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Site List</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card">
                <div class="card-body px-3 py-2 pt-3">
                    <div class="form-row align-items-center">
                        <div class="col-12 col-lg-6 mb-1">
                            <label for="" class="fw-bold mb-1">Search site :</label>
                            <input type="text" id="search" class="form-control" placeholder="Building A..">
                        </div>
                        <div class="col-6 col-lg-2 mb-1">
                            <label for="" class="fw-bold mb-1">Search by status:</label>
                            <select class="form-control form-select" name="filterStatus" id="filterStatus">
                                <option value="all">Show All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-2 mb-1 ">
                            <label for="" class="mb-1"></label>

                            <button id="btnFilter" type="button" class="btn btn-dealer btn-block">Filter</button>
                        </div>
                        <div class="col-12 col-lg-2 mb-1 ">
                            <label for="" class="mb-1"></label>

                            <button id="btnReset" type="button" class="btn btn-outline-info btn-block">Reset</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header  mx-1">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="mb-0 mt-1 text-muted">Sites list</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            <div class="grid-margin">
                                <div class="">
                                    <div class="panel panel-primary">
                                        <div class="panel-body tabs-menu-body border-0 pt-0">
                                            <div class="table-responsive">
                                                <table id="data-table" class="table table-bordered text-nowrap mb-0">
                                                    <thead class="border-top">
                                                        <tr>
                                                            <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                                Site Name / Address</th>


                                                            <th class="bg-transparent border-bottom-0">
                                                                Status</th>
                                                            <th class="bg-transparent border-bottom-0">
                                                                Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tBody">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="divLoader" class="text-center pt-5" style="height:300px;">
                                                <span>
                                                    <i class="fe fe-spinner fa-spin"></i> Sites are being loading.. It
                                                    might take few
                                                    seconds.
                                                </span>
                                            </div>
                                            <div class="row text-center" id="divNotFound" style="display:none">
                                                <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i>
                                                    {{__('No Site Found')}} !
                                                </h6>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div id="divPagination" class="text-center">
                                                    <ul id="content-pagination" class="pagination-sm justify-content-end" style="display:none;"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        
        @if(Auth::user()->hasRole('BuildingAdmin'))
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Tenants List</h4>
                            <h6 class="mb-0 mt-3 text-muted">Detail list of  all tanents...</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4" style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tenantdetails">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Appointment List</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">Appointment List</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="card">
                <div class="card-body px-3 py-2 pt-3">
                    <div class="form-row align-items-center">
                        <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 mb-1">
                            <label for="" class="fw-bold mb-1">Search by name :</label>
                            <input type="text" id="search" class="form-control" placeholder="John Doe..">
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-4 col-sm-6 mb-1">
                            <label for="" class="fw-bold mb-1">Serach by phone no.</label>
                            <input type="number" id="filterPhone" name="filterPhone" class="form-control" placeholder="+9234...">
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-4 col-sm-6 mb-1">
                            <label for="" class="fw-bold mb-1">Search by status:</label>
                            <select class="form-control form-select" name="filterStatus" id="filterStatus">
                                <option value="all" selected>Show All</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 mb-1 ">
                            <label for="" class="mb-1"></label>

                            <button id="btnFilter" type="button" class="btn btn-dealer btn-block">Filter</button>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-4 col-sm-6 mb-1 ">
                            <label for="" class="mb-1"></label>

                            <button id="btnReset" type="button" class="btn btn-outline-info btn-block">Reset</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 ">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header  mx-1">
                            <div class="media">
                                <div class="media-body">
                                    <h6 class="mb-0 mt-1 text-muted">Appointment list</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            <div class="grid-margin">
                                <div class="">
                                    <div class="panel panel-primary">
                                        <div class="panel-body tabs-menu-body border-0 pt-0">
                                            <div class="table-responsive">
                                                <table id="data-table" class="table table-bordered text-nowrap mb-0">
                                                    <thead class="border-top">
                                                        <tr>
                                                            <th class="bg-transparent border-bottom-0" style="width: 25%;">
                                                                Client</th>
                                                            <th class="bg-transparent border-bottom-0" style="width: 20%;">
                                                                Visitor Name</th>
                                                            <th class="bg-transparent border-bottom-0" style="width: 20%;">
                                                                Email</th>
                                                            <th class="bg-transparent border-bottom-0" style="width: 15%;">
                                                                Phone</th>
                                                            <th class="bg-transparent border-bottom-0" style="width: 25%;">
                                                                Appointment Date&Time</th>


                                                            <th class="bg-transparent border-bottom-0" style="width: 10%;">
                                                                Status</th>

                                                            <th class="bg-transparent border-bottom-0" style="width: 10%;">
                                                                Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tBody">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="divLoader" class="text-center pt-5" style="height:300px;">
                                                <span>
                                                    <i class="fe fe-spinner fa-spin"></i> Appointments are being loading.. It
                                                    might take few
                                                    seconds.
                                                </span>
                                            </div>
                                            <div class="row text-center" id="divNotFound" style="display:none">
                                                <h6 class="mt-lg-5"><i class="bx bx-window-close"></i>
                                                    {{__('No Appointment Found')}} !
                                                </h6>
                                            </div>
                                            <div class="col-lg-12 mt-3">
                                                <div id="divPagination" class="text-center">
                                                    <ul id="content-pagination" class="pagination-sm justify-content-end" style="display:none;"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif




    </div>
    <!-- ROW-1 END -->

</div>
<!-- CONTAINER END -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script>
    $(document).ready(function() {
    integratorList();
    recentApps();
        $("#dataTable").DataTable();

        function datatable(rows) {
            $("#dataTable tbody").empty();
            $("#dataTable").DataTable().clear();
            $("#dataTable").DataTable().destroy();
            $("#tBody tr").remove();
            $("#dataTable tbody").empty();
            $("#tBody").append(rows);
            $("#dataTable").DataTable();
            // table.page(pageInfo.page).draw(false)
        }
        $(function() {
            setInterval(adTypes, 5000);
            setInterval(recentApps, 5000);
            setInterval(sitesList, 5000);
            setInterval(integratorList, 5000);
            setInterval(tenantList, 5000);
        });

        function adTypes() {
            $.ajax({
                url: 'api/walkin/appointments/list',
                type: "get",
                dataType: "JSON",
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    // console.log(response)
                    if (response["status"] == "success") {

                        datatable(response["data"]);

                    } else if (response["status"] == "fail") {
                        $("#tBody").html('');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function recentApps() {
            $.ajax({
                url: 'api/guard/recent/appointments',
                type: "get",
                dataType: "JSON",
                cache: false,
                beforeSend: function() {
                },
                complete: function() {},
                success: function(response) {
                    // console.log(response)
                    if (response["status"] == "success") {
                        $("#data").html(response['data']);
                    } else if (response["status"] == "fail") {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        function sitesList() {
            $.ajax({
                url: 'api/admin/site/visitors/list',
                type: "get",
                dataType: "JSON",
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    // console.log(response)
                    if (response["status"] == "success") {
                        $("#sitelist").html(response['data']);
                    } else if (response["status"] == "fail") {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        
        function integratorList() {
            $.ajax({
                url: 'api/admin/site/integrator/list',
                type: "get",
                dataType: "JSON",
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    console.log(response)
                    if (response["status"] == "success") {
                        $("#integrator").html(response['data']);
                    } else if (response["status"] == "fail") {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
            // delete admin site integrator list
        $(document).on('click', '.btnDelete', function(e) {
            var id = $(this).attr('id')
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this intgrator!",
                    type: "warning",
                    buttons: true,
                    confirmButtonColor: "#ff5e5e",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    dangerMode: true,
                    showCancelButton: true
                })
                .then((deleteThis) => {
                    if (deleteThis.isConfirmed) {
                        $.ajax({
                            url: '/api/admin/integrator/delete/' + id,
                            type: "delete",
                            dataType: "JSON",
                            success: function(response) {
                                console.log(response)
                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete integrator.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "Integrator has been deleted.",
                                        "success");
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            },
                            async: false
                        });
                    } else {
                        Swal.close();
                    }
                });
        });
        
        
        //building admin tenants list
        function tenantList() {
            $.ajax({
                url: 'api/building/admin/tenant/list',
                type: "get",
                dataType: "JSON",
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    console.log(response)
                    if (response["status"] == "success") {
                        $("#tenantdetails").html(response['data']);
                    } else if (response["status"] == "fail") {

                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        
        
        //integrator dashboard site add
        $("#add_form").on('submit', (function(e) {
            e.preventDefault();

                $.ajax({
                    url: "{{url('/api/integrator/site/add')}}",
                    type: "POST",
                    data: new FormData(this),
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
                        // console.log(response);
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            toastr.success('Success', response["msg"])
                            $("#add_form")[0].reset();
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });

        }));
    });
</script>

<script type="text/javascript">
    $(document).ready(function(e) {
        var filterLength = 1;
        var total = 0;
        var filterSearch = $("#search").val();
        var contentPagination = $("#content-pagination");
        var contentNotFound = $("#divNotFound");
        var contentFound = $("#divData");
        var filterStatus = $("#filterStatus").val();
        var filterPhone = $("#filterPhone").val();

        function setFilters() {
            filterSearch = $("#search").val()
            filterStatus = $("#filterStatus").val();
            filterPhone = $("#filterPhone").val();

            filterLength = 10;
        }
        lockerCount()

        // setInterval(function (data) {


        //     lockerCount()
        // }, 1000);
        function lockerCount() {
            $("#tBody").html('');
            setFilters()
            contentPagination.twbsPagination('destroy');

            $.ajax({
                url: '/api/building/appointment/count',
                type: "get",
                data: {
                    filterSearch: filterSearch,
                    filterLength: filterLength,
                    filterStatus: filterStatus,
                    filterPhone: filterPhone,
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    console.log(response);
                    if (response["status"] == "success") {
                        total = response["data"];
                        initPagination(Math.ceil(total / filterLength));
                        $("#tBody").html('');
                    } else if (response["status"] == "fail") {
                        $("#tBody").html('');
                        toastr.error('Failed', response["msg"])
                        $("#divNotFound").css('display', 'block')
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function lockers(offset) {
            setFilters()
            $("#content-pagination").css('display', 'none')

            $("#tBody").html('');
            $("#divLoader").css('display', 'block')
            $("#divData").css('display', 'none')
            $("#divNotFound").css('display', 'none')
            $.ajax({
                url: '/api/building/appointment/list',
                type: "get",
                data: {
                    filterSearch: filterSearch,
                    filterLength: filterLength,
                    filterStatus: filterStatus,
                    filterPhone: filterPhone,
                    offset: offset
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(response) {
                    console.log(response);
                    if (response["status"] == "fail") {
                        $("#tBody").html('');

                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                        $("#content-pagination").css('display', 'none')
                        $("#divNotFound").css('display', 'block')
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        $("#divNotFound").css('display', 'none')
                        $("#divLoader").css('display', 'none')
                        $("#tBody").append(response["rows"]);
                        $("#divData").css('display', 'block');
                        $("#content-pagination").css('display', 'flex')
                        // statuses();
                        setInterval(statuses, 10000);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function initPagination(totalPages) {
            if (totalPages > 0) {
                contentPagination.show();
                contentPagination.twbsPagination({
                    totalPages: totalPages,
                    visiblePages: 4,
                    onPageClick: function(event, page) {
                        lockers((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
                    }
                });
            } else {
                contentPagination.hide();
                contentFound.hide();
                contentNotFound.show();
            }
        }

        function statuses() {

            $('table > tbody  > tr').each(function() {

                var id = $(this).attr('data-id');


                $.ajax({
                    url: '/api/appointment/status',
                    type: "get",
                    data: {

                        id: id,

                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(response) {

                        if (response["status"] == "fail") {

                        } else if (response["status"] == "success") {

                            $("#td_" + id).html(response["html"])
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });
        }

        $(document).on('keyup', '#search', function() {
            $("#tBody").html('');
            setFilters()
            lockerCount()
        });

        $(document).on('click', '#btnFilter', function(e) {
            setFilters()
            lockerCount()
        })

        $(document).on('click', '#btnReset', function(e) {
            $("#search").val('')
            $("#filterStatus").val('all')
            setFilters()
            lockerCount()
        })

        $(document).on('click', '.btnDelete', function(e) {
            var id = $(this).attr('id')
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Appointment!",
                    type: "warning",
                    buttons: true,
                    confirmButtonColor: "#ff5e5e",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    dangerMode: true,
                    showCancelButton: true
                })
                .then((deleteThis) => {
                    if (deleteThis.isConfirmed) {
                        $.ajax({
                            url: '/api/appointment/delete/' + id,
                            type: "delete",
                            dataType: "JSON",
                            success: function(response) {
                                console.log(response)
                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete appointment.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "appointment has been deleted.",
                                        "success");
                                    lockerCount()
                                }
                            },
                            error: function(error) {
                                // console.log(error);
                            },
                            async: false
                        });
                    } else {
                        Swal.close();
                    }
                });
        });

    });
</script>
@endsection
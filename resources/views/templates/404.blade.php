@extends('layouts.master')

@section('title')
404 not found
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">404 not found</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">404 not found</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">404 not found</h3>
            </div>
            <div class="card-body">
                <div id="divSuccess" class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 text-center">
                        <i class="fe fe-cloud-off text-danger" style="font-size:4rem"></i>
                        <br>
                        The resouce you are looking for is either removed or does not exists!
                        <br>
                        <a href="{{url('/dashboard')}}">Back to dashboard</a>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
    });

</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection

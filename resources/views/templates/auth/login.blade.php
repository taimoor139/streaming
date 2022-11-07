<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{env('APP_DESC')}}">
    <meta name="author" content="{{env('APP_AUTHOR')}}">
    <meta name="keywords" content="{{env('APP_KEYWORDS')}}">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(env('APP_ICON'))}}" />


    <!-- TITLE -->
    <title>Login – {{env('APP_NAME')}}</title>


    <!-- STYLE CSS -->
    @include('includes.style')
    <style>
        .page {
            background: rgb(16 14 38 / 60%) !important;
        }
    </style>

</head>

<body class="app sidebar-mini ltr">

    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="{{asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    <div class="text-center">
                        <img src="{{asset(env('APP_LOGO_WHITE'))}}" class="header-brand-img" alt="" style="height:auto !important; width:137px !important;">
                    </div>
                </div>

                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id="login_form">
                            @csrf
                            <span class="login100-form-title pb-5">
                                Login
                            </span>
                            <div class="panel panel-primary">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->


                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body p-0 pt-5">
                                    <div class="">
                                        <div class="tab-pane active" id="tab5">
                                            @if(isset($res) && $res["msg"]=="yes")
                                            <div class="alert alert-info">
                                                You already register with {{$res["email"]}}. please login with this email for further information
                                            </div>
                                            @endif
                                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" name="email" required type="email" placeholder="Email">
                                            </div>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                </a>
                                                <input class="input100 border-start-0 form-control ms-0" name="password" required type="password" placeholder="Password">
                                            </div>

                                            <div class="text-end pt-4">
                                                <p class="mb-0"><a href="{{url('/forgot/password')}}" class="text-primary ms-1">Forgot Password?</a></p>
                                            </div>

                                            <div class="container-login100-form-btn">

                                                <button type="submit" class="login100-form-btn btn-primary" id="btnSubmit">
                                                    <i class="fa fa-spinner fa-pulse mx-1" style="display: none;"></i>
                                                    Sign in</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    @include('includes.script')

    <script>
        $("#login_form").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "/api/login",
                type: "post",
                data: new FormData(this),
                dataType: "JSON",
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
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
                        $("#login_form")[0].reset();
                        if (response.role == 'tenant') {
                            if (response["password_status"] == "1") {
                                window.location.href = "{{url('appointment/list')}}";
                            } else {
                                window.location.href = "{{url('change/password')}}";
                            }
                        } else if (response.role == 'Integrator') {
                            if (response["password_status"] == "1") {
                                window.location.href = "{{url('integrator/user/list')}}";
                            } else {
                                window.location.href = "{{url('change/password')}}";
                            }
                        } else {
                            if (response["password_status"] == "1") {
                                window.location.href = "/dashboard";
                            } else {
                                window.location.href = "{{url('change/password')}}";
                            }
                        }

                    }

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }));

        function disableAlert(alr) {
            $("#" + alr).css("display", "none");
        }
    </script>

</body>

</html>
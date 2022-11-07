<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Dealer Reg – Dealer Reg">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(env('APP_ICON'))}}" />



    <!-- TITLE -->
    <title>Appointment detail – {{env('APP_NAME')}} </title>

    @include('includes.style')
    <style>
        .design {
            display: none;
        }
    </style>

</head>

<body class="app sidebar-mini ltr light-mode">

    <div class="container">
        <div class="row mt-5">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7 col-sm-12 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Visitor Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div>
                                                <div class="d-flex mt-2">
                                                    <div>
                                                        <span>
                                                            <i class="fe fe-user fs-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="mx-2">
                                                            <strong>{{ucwords($app->name)}}</strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-2">
                                                    <div>
                                                        <span>
                                                            <i class="fe fe-mail fs-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="mx-2">
                                                            {{$app->email}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-2">
                                                    <div>
                                                        <span>
                                                            <i class="fe fe-phone fs-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="mx-2">
                                                            {{$app->phone}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="" style="margin-right:10px">
                                            <img src="{{asset($app->qr_code)}}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12 col-md-6 ">
                                <div class="text-center chat-image mb-5">
                                    <div class=" chat-profile mb-3 brround">
                                        @if($client->image==NULL)
                                        <img id="" alt="avatar" src="{{asset('assets/images/users/avatar-121.png')}}" class="brround" style="width:200px !important"></a>

                                        @else
                                        <img id="" src="{{asset('uploads/files/'.$client->image)}}" alt="" class="img-fluid rounded-circle mx-auto">
                                        @endif
                                    </div>

                                    <div class="main-chat-msg-name">
                                        <h3 class="mb-1 text-dark fw-semibold">
                                            {{ucwords($client->first_name)}} {{ucwords($client->last_name)}}
                                        </h3>
                                    </div>
                                    <div class=" text-center">

                                        <span class="mx-2">
                                            <i class="fe fe-mail fs-20"></i> {{ucwords($client->email)}}
                                        </span>

                                    </div>
                                    <div class="mt-2">

                                        <span class="mx-2">
                                            <i class="fa fa-map-marker fs-20"></i><strong> {{ucwords($client ->site->name)}}</strong>
                                        </span><br>
                                        <span>
                                            {{ucwords($client->site->address )}}
                                        </span>

                                    </div><br><br>
                                    <div class="text-center">
                                            <a href="{{url('qr-scan')}}" id="btnElm" class="btn btn-success rounded-circle design" style="font-size:60px;font-weight:600;">
                                                GO
                                            </a>
                                            <p id="counter-sec" style="margin-top:10px;color:red;display:none">
                                                You'll be automatically redirected in <span id="count">5</span> seconds...</p>
                                        </div>
                                </div>
                            </div>

                            <input type="hidden" id="checkValue" value="{{$value}}">
                            <input type="hidden" id="app_id" value="{{$app->id}}">

                            <div class="col-4"></div>
                            <div class="col-4 text-center">

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 END -->

    </div>



    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    @include('includes.script')
    <script>
        informClient();

        function informClient() {
            var value = $("#checkValue").val();
            var id = $("#app_id").val();
            console.log('callingggg')
            if (value == "portal") {
                $.ajax({
                    url: '/api/inform/client',
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function() {
                        $(".btnInform").attr('disabled', true);
                        $(".fa-spin").css('display', 'inline-block');
                    },
                    complete: function() {
                        $(".fa-spin").css('display', 'none');
                        $(".btnInform").removeClass('btn btn-primary');
                        $(".btnInform").addClass('btn btn-success');
                        $(".btnInform").text('Informed');
                    },
                    success: function(response) {
                        console.log(response)
                        if (response["status"] == "fail") {

                        } else if (response["status"] == "success") {

                            $("#btnElm").removeClass('design')
                            $("#counter-sec").css('display', 'block')
                            c();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {}
        }

        function c() {
            var n = 5;
            var c = n;
            $('#count').text(c);
            setInterval(function() {
                c--;
                if (c >= 0) {
                    $('#count').text(c);
                }
                if (c == 0) {
                    $('#count').text(n);
                    $("#btnElm").addClass('design');
                    $("#counter-sec").css('display', 'none');
                    window.location.href = "{{url('qr-scan')}}";
                }
            }, 1000);
        }
        $(document).on('click', '.btnInform', function(e) {
            var id = $(this).attr('id');
            e.preventDefault();

        })
    </script>
</body>

</html>
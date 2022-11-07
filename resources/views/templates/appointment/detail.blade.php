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

</head>

<body class="app sidebar-mini ltr light-mode">

    <div class="container">
        <div class="row mt-5">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
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
                                    <div class="d-flex text-center" style="margin-left:50px;">
                                        <div>
                                            <span>
                                                <i class="fe fe-mail fs-20"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="mx-2">
                                            {{ucwords($client->email)}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div>
                                            <span>
                                                <i class="fa fa-map-marker fs-20"></i>
                                            </span>
                                            <span class="mx-2">
                                                <strong>{{ucwords($client->site->name)}}</strong>
                                            </span><br>
                                            <span>
                                            {{ucwords($client->site->address)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Visitor Information</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div>
                                                    <h4 class="mx-2">
                                                        <strong>{{ucwords($app->name)}}</strong>
                                                    </h4>
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
                                                <div class="d-flex mt-2">
                                                    <div>
                                                        <span>
                                                            <i class="fa fa-map-marker fs-20"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="mx-2">
                                                            <strong>Gujarkhan Rawalpindi</strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="" style="margin-right:10px">
                                                <img src="{{asset($app->qr_code)}}">
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-6 text-end">
                                <a href="javascript:;" class="btn btn-primary btnInform" id="{{$app->id}}"><i class="fa fa-spinner fa-spin" style="display:none;"></i> Inform Client</a>
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
    $(document).on('click','.btnInform',function(e){
        var id = $(this).attr('id');
        e.preventDefault();
            $.ajax({
                url: '/api/inform/client',
                type: "POST",
                data: {id:id},
                dataType: "JSON",
                cache: false,
                beforeSend: function () {
                    $(".btnInform").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');
                },
                complete: function () {
                    $(".btnInform").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                },
                success: function (response) {
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"]) 
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
    })
    </script>
</body>

</html>
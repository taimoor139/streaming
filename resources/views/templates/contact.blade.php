@extends('layouts.master')

@section('title')
Contact
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Contact us</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <?php
        $gen_contact = \App\Models\Generalcontact::where('id','1')->first();   
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card pb-3">
                <div class="card-body">

                    <div class="row border-bottom pb-3">
                        <div class="col-10">
                            <h3 class="card-title">General contact</h3>

                        </div>
                        <div class="col-2 text-end">
                            <div class="ms-auto mt-1 file-dropdown">
                                <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i
                                        class="fe fe-more-vertical fs-18"></i></a>
                                <div class="dropdown-menu dropdown-menu-start">
                                    <!-- <a class="modal-effect dropdown-item" data-bs-effect="effect-scale"
                                        data-bs-toggle="modal" href="#general_contact"><i
                                            class="fe fe-plus me-2"></i>Add</a> -->
                                    <a class="modal-effect dropdown-item btnEdit" id="{{$gen_contact->id}}"
                                        data-bs-effect="effect-scale" data-bs-toggle="modal"
                                        href="#general_contact_edit"><i class="fe fe-edit me-2"></i>Edit</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <h4 class="fw-semibold">{{$gen_contact->email}}</h4>
                        <p class="mb-0"> <b>Phone number : </b>{{$gen_contact->ph_number}} </p>
                        <p class="mb-0"> <b>Fax number : </b>{{$gen_contact->fax_number}} </p>
                        <p class="mb-0"> <b>Website : </b>{{$gen_contact->website}} </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
        <?php
            $mailing_info = \App\Models\Mailingaddress::where('id','1')->first();   
        ?>
            <div class="card cart">
                <div class="card-body">
                    <div class="row border-bottom pb-3">
                        <div class="col-10">
                            <h3 class="card-title">Mailing information</h3>

                        </div>
                        <div class="col-2 text-end">
                            <div class="ms-auto mt-1 file-dropdown">
                                <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i
                                        class="fe fe-more-vertical fs-18"></i></a>
                                <div class="dropdown-menu dropdown-menu-start">
                                    <!-- <a class="modal-effect dropdown-item" data-bs-effect="effect-scale"
                                        data-bs-toggle="modal" href="#mailing_information"><i
                                            class="fe fe-edit me-2"></i>Add</a> -->
                                    <a class="modal-effect dropdown-item btnEdit_mailing" id="{{$mailing_info->id}}" data-bs-effect="effect-scale"
                                        data-bs-toggle="modal" href="#mailing_information_edit"><i
                                            class="fe fe-edit me-2"></i>Edit</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <p class="mb-0"> <b>Dealer reg address : </b>{{$mailing_info->dealer_reg_address}} </p>
                        <p class="mb-0"> <b>Suite number : </b>{{$mailing_info->suite_number}} </p>
                        <p class="mb-0"> <b>EIP code : </b>{{$mailing_info->eip_code}} </p>
                        <p class="mb-0"> <span class="text-red">*</span> Remider to send all transaction using a
                            traceable form of mail and includeing transaction form </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact form</h3>
                </div>
                <div class="card-body">
                    <form action="" id="contact-message">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">First Name <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required
                                        placeholder="First name">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Name <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" name="last_name" required
                                        placeholder="Last name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Email address <span class="text-red">*</span></label>
                                    <input type="email" class="form-control" name="email" requried placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" required id="" cols="30"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-start">
                                <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit"> <i
                                        class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                    Send</button>
                                <!-- <input type="button" class="btn btn-danger my-1" value="Cancel"> -->
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
        <div class="col-md-12 col-lg-5">
            <div class="card">
                <div class="main-content-app pt-0">
                    <div class="main-content-body main-content-body-chat h-100">
                        <div class="main-chat-header pt-3 d-block d-sm-flex">
                            <div class="main-chat-msg-name mt-2">
                                <h6>Conversation</h6>
                            </div>
                        </div>
                        <!-- main-chat-header -->
                        <div class="main-chat-body flex-2" id="ChatBody"
                            style="overflow-y: scroll;   scrollbar-width: none;">
                            <div class="content-inner">
                                <label class="main-chat-time"><span>2 days ago</span></label>
                                <div class="media flex-row-reverse chat-right">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/21.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Nulla consequat massa quis enim. Donec pede justo, fringilla vel...
                                        </div>
                                        <div class="main-msg-wrapper">
                                            rhoncus ut, imperdiet a, venenatis vitae, justo...
                                        </div>
                                        <div>
                                            <span>9:48 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="media chat-left">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/1.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
                                            ligula eget dolor.
                                        </div>
                                        <div>
                                            <span>9:32 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="media flex-row-reverse chat-right">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/21.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
                                            ligula eget dolor
                                        </div>
                                        <div class="main-msg-wrapper">
                                            <span class="text-dark"><span><i
                                                        class="fa fa-image fs-14 text-muted pe-2"></i></span><span
                                                    class="fs-14 mt-1"> Image_attachment.jpg </span>
                                                <i class="fe fe-download mt-3 text-muted ps-2"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span>11:22 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <label class="main-chat-time"><span>Yesterday</span></label>
                                <div class="media chat-left">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/1.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
                                            ligula eget dolor.
                                        </div>
                                        <div>
                                            <span>9:32 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="media flex-row-reverse chat-right">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/21.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla
                                            consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec. In
                                            enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                                        </div>
                                        <div class="main-msg-wrapper">
                                            Nullam dictum felis eu pede mollis pretium
                                        </div>
                                        <div>
                                            <span>9:48 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div><label class="main-chat-time"><span>Today</span></label>
                                <div class="media chat-left">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/1.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Maecenas tempus, tellus eget condimentum rhoncus
                                        </div>
                                        <div class="main-msg-wrapper">
                                            <img alt="avatar" class="w-10 h-10" src="../assets/images/media/3.jpg">
                                            <img alt="avatar" class="w-10 h-10" src="../assets/images/media/4.jpg">
                                            <img alt="avatar" class="w-10 h-10" src="../assets/images/media/5.jpg">
                                        </div>
                                        <div>
                                            <span>10:12 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="media flex-row-reverse chat-right">
                                    <div class="main-img-user online"><img alt="avatar"
                                            src="../assets/images/users/21.jpg"></div>
                                    <div class="media-body">
                                        <div class="main-msg-wrapper">
                                            Maecenas tempus, tellus eget condimentum rhoncus
                                        </div>
                                        <div class="main-msg-wrapper">
                                            Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas
                                            nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis
                                            faucibus.
                                        </div>
                                        <div>
                                            <span>09:40 am</span> <a href=""><i
                                                    class="icon ion-android-more-horizontal"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-chat-footer">
                            <input class="form-control" placeholder="Type your message here..." type="text">
                            <a class="nav-link" data-bs-toggle="tooltip" href="" title="Attach a File"><i
                                    class="fe fe-paperclip"></i></a>
                            <button type="button" class="btn btn-icon  btn-primary brround"><i
                                    class="fa fa-paper-plane-o"></i></button>
                            <nav class="nav">
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTAINER END -->

<!-- MODAL General contact -->
<!-- add -->
<div class="modal fade" id="general_contact">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">General contact add</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="add_general">
                    @csrf
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Email :</label>
                        <input type="email" class="form-control" id="" name="email" placeholder="example@gmail.com">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Phone number :</label>
                        <input type="number" class="form-control" id="" name="ph_number" placeholder="123567">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Fax number :</label>
                        <input type="number" class="form-control" id="" name="fax_number" placeholder="123">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Website :</label>
                        <input type="text" class="form-control" id="" name="website" placeholder="https://google.com">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i class="fa fa-spinner fa-pulse"
                                style="display: none;"></i>
                            Save</button>
                        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit -->
<div class="modal fade" id="general_contact_edit">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">General contact Edit</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="update_general">
                    @csrf
                    <input type="hidden" id='general_id' name="general_id">

                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Email :</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="example@gmail.com">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Phone number :</label>
                        <input type="number" class="form-control" id="ph_number" name="ph_number" placeholder="123567">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Fax number :</label>
                        <input type="number" class="form-control" id="fax_number" name="fax_number" placeholder="123">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Website :</label>
                        <input type="text" class="form-control" id="website" name="website"
                            placeholder="https://google.com">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i class="fa fa-spinner fa-pulse"
                                style="display: none;"></i>
                            Save</button>
                        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL Mailing Information -->
<!-- add -->
<div class="modal fade" id="mailing_information">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Mailing information add</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="add_mailing">
                    @csrf
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Dealer reg address :</label>
                        <textarea  id="" cols="30" rows="3" name="dealer_reg_address"
                            class="form-control"></textarea>

                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Suite number :</label>
                        <input type="number" class="form-control" id="" name="suite_number" placeholder="123567">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">EIP code :</label>
                        <input type="number" class="form-control" id="" name="eip_code" placeholder="123">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i class="fa fa-spinner fa-pulse"
                                style="display: none;"></i>
                            Save</button>
                        <button class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- edit -->
<div class="modal fade" id="mailing_information_edit">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Mailing information edit</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" id="update_mailing">
                    @csrf
                    <input type="hidden" id='mailing_id' name="mailing_id">

                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Dealer reg address :</label>
                        <textarea  cols="30" rows="3" id="dealer_reg_address" name="dealer_reg_address"
                            class="form-control dealer_reg_address" ></textarea>

                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">Suite number :</label>
                        <input type="number" class="form-control" id="suite_number" name="suite_number" placeholder="123567">
                    </div>
                    <div class="">
                        <label for="" class="form-label text-start fw-semibold">EIP code :</label>
                        <input type="number" class="form-control" id="eip_code" name="eip_code" placeholder="123">
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i class="fa fa-spinner fa-pulse"
                                style="display: none;"></i>
                            Save</button>    
                    <button class="btn btn-light"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        // contact message
        $("#contact-message").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/contact',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#contact_message")[0].reset();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));



    });

</script>


<!-- general contact -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function (e) {
        // add general contact
        $("#add_general").on('submit', (function (e) {

            e.preventDefault();
            $.ajax({
                url: '/api/add/general/contact',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#add_general")[0].reset();
                        // Using .reload() method.
                        location.reload();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        // edit general
        $(document).on('click', '.btnEdit', function (e) {
            var general = $(this).attr('id');
            // alert(general)
            $.ajax({
                url: '/api/edit/general/contact',
                type: "GET",
                dataType: "JSON",
                data: {
                    general: general

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        // toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        // toastr.success('Success', response["msg"])
                        $("#email").val(response["data"]["email"])
                        $("#ph_number").val(response["data"]["ph_number"])
                        $("#fax_number").val(response["data"]["fax_number"])
                        $("#website").val(response["data"]["website"])
                        $("#general_id").val(response["data"]["id"])
                    }
                },
                error: function (error) {
                    // console.log(error);
                },
                async: false
            });
        });

        // UpdateGeneral
        $("#update_general").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/update/general/contact',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] === "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] === "success") {
                        toastr.success('Success', response["msg"])
                        location.reload();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        // delete
        $(document).on('click', '.btnDelete', function (e) {
            var general = $(this).attr('id');
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this General Contact!",
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
                            url: '/api/delete/general/contact',
                            type: "GET",
                            dataType: "JSON",
                            data: {
                                // general come from controller request
                                general: general

                            },
                            success: function (response) {

                                if (response["status"] == "fail") {
                                    toastr.error('Failed', response["msg"])
                                } else if (response["status"] == "success") {
                                    toastr.success('Success', response["msg"])
                                    // Using .reload() method.
                                    location.reload();
                                }
                            },
                            error: function (error) {
                                // console.log(error);
                            },
                            async: false
                        });
                    } else {
                        Swal.close();
                    }
                });
        });

    })

</script>

<script>
    $(document).ready(function (e) {
        // add mailing information
        $("#add_mailing").on('submit', (function (e) {

            e.preventDefault();
            $.ajax({
                url: '/api/add/mailing/information',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#add_mailing")[0].reset();
                        // Using .reload() method.
                        location.reload();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        // edit mailing
        $(document).on('click', '.btnEdit_mailing', function (e) {
            var mailing = $(this).attr('id');
            // alert(mailing)
            $.ajax({
                url: '/api/edit/mailing/information',
                type: "GET",
                dataType: "JSON",
                data: {
                    mailing: mailing

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        // toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        // toastr.success('Success', response["msg"])
                        $(".dealer_reg_address").val(response["data"]["dealer_reg_address"])
                        $("#suite_number").val(response["data"]["suite_number"])
                        $("#eip_code").val(response["data"]["eip_code"])
                        $("#mailing_id").val(response["data"]["id"])
                    }
                },
                error: function (error) {
                    // console.log(error);
                },
                async: false
            });
        });

        // Update mailing
        $("#update_mailing").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/update/mailing/information',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] === "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] === "success") {
                        toastr.success('Success', response["msg"])
                        location.reload();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        // delete
        $(document).on('click', '.btnDelete', function (e) {
            var mailing = $(this).attr('id');
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Mailing information!",
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
                            url: '/api/delete/mailing/information',
                            type: "GET",
                            dataType: "JSON",
                            data: {
                                // general come from controller request
                                mailing: mailing

                            },
                            success: function (response) {

                                if (response["status"] == "fail") {
                                    toastr.error('Failed', response["msg"])
                                } else if (response["status"] == "success") {
                                    toastr.success('Success', response["msg"])
                                    // Using .reload() method.
                                    location.reload();
                                }
                            },
                            error: function (error) {
                                // console.log(error);
                            },
                            async: false
                        });
                    } else {
                        Swal.close();
                    }
                });
        });

    })

</script>
@endsection

@extends('layouts.min')

@section('title')
Scan Qrcode
@endsection

@section('content')
<!-- CONTAINER -->
<div class="container-fluid">
    <div class="page-header mb-2">
        <div>
            <h1 class="page-title">Scan QR</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Scan</li>
                <li class="breadcrumb-item active" aria-current="page">QR</li>
            </ol>
        </div>
    </div>

    <div class="row  d-flex justify-space-between">
        <div class="col-6">
            <h5>Scan Qr for Appointment Scheduling</h5>
            <div id="qr-reader" style="width:500px"></div>
            <div id="qr-reader-results"></div>
        </div>
        <h4><strong>Qr Code of " {{$site->name}} "</strong></h4>
        <div class="col-6" style="padding-left:90px;">
            <div class="" style="margin-right:10px">
                <img src="{{asset($site->qr_code)}}">
            </div><br>
        </div>
    </div>
    <div class="mt-3">
        <h4><strong>Instructions</strong></h4>
        <ol>
            <li>Scan provided Qr code and you recieved the self registration form.</li>
            <li>Fill the given form and select the Client whom you want to visit.</li>
            <li>Submit your form and your appointment request is sent to the specific client.</li>
            <li>If your client will approve that request then you will be able to visit him/her.</li>
        </ol>
    </div>
</div>
@endsection

@section('bottom-script')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" ||
            document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function() {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                window.location.href = decodedText;
                console.log(`Scan result ${decodedText}`, decodedResult);
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>
@endsection
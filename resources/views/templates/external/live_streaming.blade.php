@extends('layouts.min')

@section('title')
    Scan Qrcode
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container-fluid" >

        <div class="row  d-flex justify-space-between">
            <div class="col-6">
                <h5>Live Streaming</h5>
            </div>
{{--            <a href="javascript:;" class="btn btn-primary btn-streaming"--}}
{{--               streaming-link="rtsp://admin:troiano10!@68.195.234.210:3067/chID=4&streamType=main&linkType=tcp">Click to--}}
{{--                start streaming</a>--}}
        </div>
        <div class="mt-3" id="app">
            @if ($type === 'broadcaster')

                <broadcaster :auth_user_id="{{ $id }}" env="{{ env('APP_ENV') }}"
                             turn_url="{{ env('TURN_SERVER_URL') }}" turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                             turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}"/>

            @else
                <viewer stream_id="{{ $streamId }}" :auth_user_id="{{ $id }}"
                        turn_url="{{ env('TURN_SERVER_URL') }}" turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                        turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}"/>
            @endif
        </div>
    </div>
@endsection

@section('bottom-script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-streaming', function (e) {
                alert('Streaming feature will be implemented here')
            })
        })
    </script>
@endsection

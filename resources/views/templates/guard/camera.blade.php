@extends('layouts.master')

@section('title')
Add Appointment
@endsection

@section('content')
<!-- CONTAINER -->
<style>
#heading {
    font-size: 20px;
    text-align: center;
    color: #5353f1;
    font-weight: 500;
}

#cardBody {
    border: 1px solid #4c4cef;
    border-radius: 10px;
    height: 30px;
    background: #dfdfdf;
    margin-bottom: 20px;
    margin-top: 20px;
}

.btn:disabled {
    cursor: not-allowed;
    pointer-events: all !important;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<div class="main-container container-fluid">

<section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-four-fifths">
          <h1 class="title">
            JavaScript Camera
          </h1>
          <video autoplay id="video"></video>
          <button class="button is-hidden" id="btnPlay">
            <span class="icon is-small">
              <i class="fas fa-play"></i>
            </span>
          </button>
          <button class="button" id="btnPause">
            <span class="icon is-small">
              <i class="fas fa-pause"></i>
            </span>
          </button>
          <button class="button is-success" id="btnScreenshot">
            <span class="icon is-small">
              <i class="fas fa-camera"></i>
            </span>
          </button>
          <button class="button" id="btnChangeCamera">
            <span class="icon">
              <i class="fas fa-sync-alt"></i>
            </span>
            <span>Switch camera</span>
          </button>
        </div>
        <div class="column">
          <h2 class="title">Screenshots</h2>
          <div id="screenshots"></div>
        </div>
      </div>
    </div>
  </section>



  <canvas class="is-hidden" id="canvas"></canvas>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')

<script src="{{asset('assets/camera/script.js')}}"></script>


@endsection
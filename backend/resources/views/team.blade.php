@extends('layouts.app')

@section('content')
<div id="team" class="text-center" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
<div class="text-center">
  <h2>Development Team</h2>
  <div class="row" style="margin-top:20px;">
    <div class="col-sm-4 team-item" data-animate="animate__zoomIn animate__faster">
      <div class="thumbnail">
        <img src="/img/team/lance.png" alt="Lance">
        <div class="caption"><h4>Lance</h4></div>
      </div>
    </div>
    <div class="col-sm-4 team-item" data-animate="animate__zoomIn animate__faster">
      <div class="thumbnail">
        <img src="/img/team/mav.jpg" alt="Mav">
        <div class="caption"><h4>Mav</h4></div>
      </div>
    </div>
    <div class="col-sm-4 team-item" data-animate="animate__zoomIn animate__faster">
      <div class="thumbnail">
        <img src="/img/team/peig.jpg" alt="Peig">
        <div class="caption"><h4>Peig</h4></div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

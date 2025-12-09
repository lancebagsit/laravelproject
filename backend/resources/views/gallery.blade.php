@extends('layouts.app')

@section('content')
<div id="portfolio" class="text-center" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title">
      <h2>Gallery</h2>
      <p>Moments from our parish life</p>
    </div>
    <div class="row">
      @forelse($items as $item)
        <div class="col-sm-6 col-md-3 col-lg-3 gallery-item" data-animate="animate__fadeInUp">
          <div class="thumbnail">
            <img src="/image/square?src={{ $item->url }}&size=350" alt="{{ $item->title }}">
            <div class="caption"><h4>{{ $item->title }}</h4></div>
          </div>
        </div>
      @empty
        <div class="col-md-12">No images yet.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection

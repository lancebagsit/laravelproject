@extends('layouts.app')

@section('content')
<div id="priests" class="parish-info-container" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title text-center"><h2>Parish Priests</h2></div>
    <div class="row">
      @forelse($priests as $p)
        <div class="col-sm-6 col-md-4" data-animate="animate__fadeInUp">
          <div class="thumbnail priest-card">
            @if($p->image)
              <img src="{{ $p->image }}" class="img-responsive" alt="{{ $p->name }}">
            @else
              <img src="https://via.placeholder.com/300x200?text=No+Image" class="img-responsive" alt="{{ $p->name }}">
            @endif
            <div class="caption">
              <h4>{{ $p->name }}</h4>
              <p>{{ $p->description }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-md-12">No entries yet.</div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div id="announcements" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title text-center">
      <h2>Announcements</h2>
      <p>Stay updated with our latest news and events</p>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @forelse($announcements as $a)
          <div class="panel panel-default announcement-item" data-animate="animate__fadeInUp">
            <div class="panel-heading"><h4>{{ $a->title }}</h4></div>
            <div class="panel-body">{{ $a->content }}</div>
          </div>
        @empty
          <p class="text-center">No announcements yet.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

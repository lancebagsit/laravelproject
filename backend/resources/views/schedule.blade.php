@extends('layouts.app')

@section('content')
<div id="schedule" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title text-center"><h2>Mass Schedule</h2></div>
    <div class="table-wrapper">
      <table class="table table-striped schedule-table">
        <thead>
          <tr>
            <th>Time</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          @forelse($schedules as $s)
            <tr>
              <td>{{ $s->time }}</td>
              <td>{{ $s->language }}</td>
            </tr>
          @empty
            <tr><td colspan="2">No schedule posted.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

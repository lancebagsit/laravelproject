@extends('layouts.app')

@section('content')
<div class="container" id="admin-inquiries" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Inquiries</h2></div>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>Name</th><th>Email</th><th>Message</th></tr></thead>
          <tbody>
          @forelse($items as $q)
            <tr>
              <td>{{ $q->name }}</td>
              <td>{{ $q->email }}</td>
              <td>{{ $q->message }}</td>
            </tr>
          @empty
            <tr><td colspan="3">No inquiries yet.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection


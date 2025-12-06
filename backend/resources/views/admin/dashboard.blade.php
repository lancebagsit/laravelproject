@extends('layouts.app')

@section('content')
<div id="admin-dashboard" class="container" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Admin Dashboard</h2></div>
  <p>Welcome, {{ session('admin_name') }}.</p>
  <p><a href="/admin/logout" class="btn btn-danger">Logout</a></p>
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Announcements</div>
        <div class="panel-body"><a class="btn btn-primary" href="/api/announcements">View API</a></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Gallery</div>
        <div class="panel-body"><a class="btn btn-primary" href="/api/gallery">View API</a></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Priests & Schedule</div>
        <div class="panel-body"><a class="btn btn-primary" href="/api/priests">Priests</a> <a class="btn btn-primary" href="/api/schedules">Schedules</a></div>
      </div>
    </div>
  </div>
</div>
@endsection


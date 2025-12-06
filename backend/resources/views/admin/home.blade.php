@extends('layouts.app')

@section('content')
<div class="container" id="admin-dashboard" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Admin Dashboard</h2></div>
  <p class="text-center">Welcome, {{ session('admin_name') }}.</p>
  <div class="row" style="margin-top:20px;">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Announcements</div>
        <div class="panel-body text-center">
          <a class="btn btn-primary" href="/admin/announcements">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Priest</div>
        <div class="panel-body text-center">
          <a class="btn btn-primary" href="/admin/priest">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Gallery</div>
        <div class="panel-body text-center">
          <a class="btn btn-primary" href="/admin/gallery">Manage</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top:20px;">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Donations</div>
        <div class="panel-body text-center">
          <a class="btn btn-primary" href="/admin/donations">View</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Inquiries</div>
        <div class="panel-body text-center">
          <a class="btn btn-primary" href="/admin/inquiries">View</a>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center" style="margin-top:20px;">
    <form method="POST" action="/admin/logout">
      @csrf
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
  </div>
</div>
@endsection


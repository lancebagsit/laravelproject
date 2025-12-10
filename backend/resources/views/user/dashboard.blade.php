@extends('layouts.app')

@section('content')
<div class="container" id="user-dashboard" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>My Dashboard</h2></div>
  <p class="text-center">Welcome, {{ auth()->user()->name }}.</p>
  <div class="row" style="margin-top:16px;">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Donations</div>
        <div class="panel-body">
          <a class="btn btn-login-secondary" href="/donate">Make a Donation</a>
          <a class="btn btn-login-secondary" href="/user/donations" style="margin-left:8px;">My Donations</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Mass Schedule</div>
        <div class="panel-body">
          <a class="btn btn-login-secondary" href="/user/calendar">Mass Calendar</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Account</div>
        <div class="panel-body">
          <form method="POST" action="/logout" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

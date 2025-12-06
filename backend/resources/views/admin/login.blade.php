@extends('layouts.app')

@section('content')
<div class="container" id="admin-login" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>Admin Login</h3></div>
        <div class="panel-body">
          <form method="POST" action="/admin/login">
            @csrf
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" class="btn btn-custom btn-lg btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center" style="margin-top:10px;">
    <p>Default account: <code>admin@stjoseph.local</code> / <code>admin123</code></p>
  </div>
@endsection


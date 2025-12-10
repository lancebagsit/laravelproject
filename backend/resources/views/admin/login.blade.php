@extends('layouts.app')

@section('content')
<div class="container" id="admin-login" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>St. Joseph Shrine</h2>
          <p>Serve with excellence and care.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Welcome</h2>
          <p>Login with Email</p>
        </div>
        <form method="POST" action="/admin/login">
          @csrf
          <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required maxlength="50" />
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required maxlength="100" />
            </div>
          </div>
          <div class="text-right"><a href="/admin/forgot-password" class="btn-login-secondary">Forgot your password?</a></div>
          <button type="submit" class="btn btn-login-primary btn-block">Login</button>
          @if(session('admin_id'))
          <form method="POST" action="/admin/logout" style="margin-top: 12px;">
            @csrf
            <button type="submit" class="btn btn-danger btn-block">Logout</button>
          </form>
          @endif
          <div class="text-center login-register">
            <span>Don't have an account?</span> <a href="/admin/register" class="btn-login-secondary">Register now</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container" id="user-login" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6 col-lg-5">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>St. Joseph Shrine</h2>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-7">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Login</h2>
          @if(session('status'))<p>{{ session('status') }}</p>@endif
          @if($errors->any())<p class="text-danger">{{ $errors->first() }}</p>@endif
        </div>
        <form method="POST" action="/login">
          @csrf
          <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
            </div>
          </div>
          <div class="text-right"><a href="/forgot-password" class="btn-login-secondary">Forgot your password?</a></div>
          <button type="submit" class="btn btn-login-primary btn-block">Login</button>
          <div class="text-center login-register">
            <span>Don't have an account?</span> <a href="/register" class="btn-login-secondary">Register now</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

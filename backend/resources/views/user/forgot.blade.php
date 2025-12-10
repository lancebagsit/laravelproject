@extends('layouts.app')

@section('content')
<div class="container" id="user-forgot" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>Password Help</h2>
          <p>We’ll send an OTP to your email.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Forgot Password</h2>
          @if(session('status'))<p>{{ session('status') }}</p>@endif
          @if($errors->any())<p class="text-danger">{{ $errors->first() }}</p>@endif
        </div>
        <form method="POST" action="/forgot-password">
          @csrf
          <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
            </div>
          </div>
          <button type="submit" class="btn btn-login-primary btn-block">Send Reset Code</button>
          <div class="text-center login-register">
            <span>Remembered it?</span> <a href="/login" class="btn-login-secondary">Back to Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection


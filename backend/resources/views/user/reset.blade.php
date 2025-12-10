@extends('layouts.app')

@section('content')
<div class="container" id="user-reset" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>Reset Password</h2>
          <p>Enter the code and your new password.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Reset</h2>
          @if(session('status'))<p>{{ session('status') }}</p>@endif
          @if(session('dev_code'))<p><small>Dev code: <strong>{{ session('dev_code') }}</strong></small></p>@endif
          @if($errors->any())<p class="text-danger">{{ $errors->first() }}</p>@endif
        </div>
        <form method="POST" action="/reset-password">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}" />
          <div class="form-group">
            <label for="code" class="sr-only">Code</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-key"></i></span>
              <input type="text" class="form-control" id="code" name="code" placeholder="6-digit code" required />
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required />
            </div>
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" required />
            </div>
          </div>
          <button type="submit" class="btn btn-login-primary btn-block">Update Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

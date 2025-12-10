@extends('layouts.app')

@section('content')
<div class="container" id="admin-login" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>Join the Admins</h2>
          <p>Manage content with care.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Create Account</h2>
          <p>Register with Email</p>
        </div>
        <form method="POST" action="/admin/register">
          @csrf
          <div class="form-group">
            <label for="name" class="sr-only">Name</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required minlength="5" maxlength="100" />
            </div>
          </div>
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
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" title="At least 8 characters, include 1 uppercase, 1 lowercase, 1 number, and 1 special character." />
            </div>
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$" />
            </div>
          </div>
          <div class="text-right"><a href="/admin/forgot-password" class="btn-login-secondary">Forgot your password?</a></div>
          <button type="submit" class="btn btn-login-primary btn-block">Register</button>
          <div class="text-center login-register">
            <span>Already have an account?</span> <a href="/admin/login" class="btn-login-secondary">Login</a>
          </div>
          <div class="text-right" style="margin-top:12px;">
            <a href="/admin" class="btn btn-login-secondary">← Back to Dashboard</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="text-center" style="margin-top:12px;">
    <p>Use a valid email and strong password.</p>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function(){
    var p = document.getElementById('password');
    var pc = document.getElementById('password_confirmation');
    function check(){ if (p && pc) { pc.setCustomValidity(p.value === pc.value ? '' : 'Passwords do not match'); } }
    if (p && pc) { p.addEventListener('input', check); pc.addEventListener('input', check); }
  });
  </script>
@endsection

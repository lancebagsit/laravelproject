@extends('layouts.app')

@section('content')
<div class="container" id="user-register" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="row login-wrapper">
    <div class="col-md-6 col-lg-5">
      <div class="login-hero" data-animate="animate__fadeInLeft">
        <div class="login-hero-content">
          <h2>Create Account</h2>
          <p>Create your account to access the dashboard.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-7">
      <div class="login-card" data-animate="animate__zoomIn">
        <div class="login-header text-center">
          <h2>Register</h2>
          @if(session('status'))<p>{{ session('status') }}</p>@endif
          @if($errors->any())<p class="text-danger">{{ $errors->first() }}</p>@endif
        </div>
        <form method="POST" action="/register" id="registerForm">
          @csrf
          <div class="form-group">
            <label for="name" class="sr-only">Name</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required />
            </div>
          </div>
          <div class="form-group">
            <label for="email2" class="sr-only">Email</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              <input type="email" class="form-control" id="email2" name="email" placeholder="Email" required />
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
              <span class="input-group-addon toggle-password" data-target="#password"><i class="fa fa-eye"></i></span>
            </div>
            <ul class="password-criteria" id="pwdCriteria">
              <li data-crit="len">At least 8 characters</li>
              <li data-crit="num">Contains a number</li>
              <li data-crit="sym">Contains a symbol</li>
            </ul>
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="sr-only">Confirm Password</label>
            <div class="input-group login-input">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required />
              <span class="input-group-addon toggle-password" data-target="#password_confirmation"><i class="fa fa-eye"></i></span>
            </div>
            <div id="pwdMatchMsg" style="margin-top:6px; font-size:13px; display:none;"></div>
          </div>
          <button type="submit" class="btn btn-login-primary btn-block">Create Account</button>
          <div class="text-center login-register" style="margin-top:12px;">
            <span>Already have an account?</span> <a href="/login" class="btn-login-secondary">Login</a>
          </div>
        </form>
        <script>
        (function(){
          var form = document.getElementById('registerForm');
          if (!form) return;
          var emailInput = document.getElementById('email2');
          var pwd = document.getElementById('password');
          var pwdc = document.getElementById('password_confirmation');
          function meetsCriteria(v){
            var len = v.length >= 8;
            var num = /\d/.test(v);
            var sym = /[^A-Za-z0-9]/.test(v);
            return { len: len, num: num, sym: sym };
          }
          function renderCriteria(v){
            var r = meetsCriteria(v);
            ['len','num','sym'].forEach(function(k){
              var el = document.querySelector('#pwdCriteria [data-crit="'+k+'"]');
              if (el) el.classList.toggle('met', !!r[k]);
            });
            return r.len && r.num && r.sym;
          }
          if (pwd) { pwd.addEventListener('input', function(){ renderCriteria(pwd.value || ''); }); renderCriteria(pwd.value || ''); }
          function renderMatch(){
            var msg = document.getElementById('pwdMatchMsg');
            if (!msg) return;
            var a = pwd ? (pwd.value||'') : '';
            var b = pwdc ? (pwdc.value||'') : '';
            if (!b) { msg.style.display = 'none'; return; }
            var ok = a === b;
            msg.style.display = 'block';
            msg.textContent = ok ? 'Matches the password' : 'Does not match the password';
            msg.style.color = ok ? '#2e7d32' : '#d32f2f';
          }
          if (pwdc) { pwdc.addEventListener('input', renderMatch); }
          if (pwd) { pwd.addEventListener('input', renderMatch); }
          Array.prototype.slice.call(document.querySelectorAll('.toggle-password')).forEach(function(t){
            t.addEventListener('click', function(){ var target = document.querySelector(t.getAttribute('data-target')); if (!target) return; var isText = target.getAttribute('type') === 'text'; target.setAttribute('type', isText ? 'password' : 'text'); var i = t.querySelector('i'); if (i) { i.classList.remove(isText ? 'fa-eye-slash' : 'fa-eye'); i.classList.add(isText ? 'fa-eye' : 'fa-eye-slash'); } });
          });
          form.addEventListener('submit', function(e){
            e.preventDefault();
            var email = (emailInput && emailInput.value || '').trim();
            var ok = renderCriteria(pwd && pwd.value ? pwd.value : '');
            if (!ok) { Swal.fire({ icon:'error', title:'Weak password', text:'Use at least 8 characters, include a number and a symbol.' }); return; }
            if (pwd && pwdc && pwd.value !== pwdc.value) { Swal.fire({ icon:'error', title:'Password mismatch', text:'Confirm Password must match Password.' }); return; }
            if (!email) { Swal.fire({ icon:'error', title:'Missing email', text:'Please enter your email.' }); return; }
            form.submit();
          });
        })();
        </script>
      </div>
    </div>
  </div>
</div>
@endsection

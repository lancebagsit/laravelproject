@extends('layouts.app')

@section('content')
<div id="donate" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title text-center"><h2>Donate</h2></div>
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="row" style="margin-top:12px;">
      <div class="col-md-6">
        <div class="contact-form-box" data-animate="animate__fadeInUp">
          <h4 style="margin-top:0;">Scan to Donate</h4>
          @php($qrPath = file_exists(public_path('uploads/donation_qr.png')) ? '/uploads/donation_qr.png' : null)
          @if($qrPath)
            <div class="qr-click-view" id="qrContainer" style="max-width:100%;">
              <img src="{{ $qrPath }}" alt="Donation QR" class="img-responsive" style="max-height:360px; border-radius:12px;" />
              <div class="qr-hover-tip">Click this to see the full screen</div>
            </div>
            <div id="qrLightbox" class="qr-lightbox" role="dialog" aria-modal="true" aria-label="Donation QR">
              <button class="qr-back">← Back</button>
              <img src="{{ $qrPath }}" alt="Donation QR Fullscreen" />
            </div>
            <p style="margin-top:8px; color:#666;">Open your wallet app and scan the QR code.</p>
          @else
            <p>No QR set yet. Please upload one in the admin Donations page.</p>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="contact-form-box" data-animate="animate__fadeInUp">
          <form method="POST" action="/donate">
            @csrf
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="contact_number">Contact Number</label>
              <input type="text" class="form-control" id="contact_number" name="contact_number">
            </div>
            <div class="form-group">
              <label for="mode_of_payment">Mode of Payment</label>
              <input type="text" class="form-control" id="mode_of_payment" name="mode_of_payment">
            </div>
            <div class="form-group">
              <label for="reference_number">Reference Number</label>
              <input type="text" class="form-control" id="reference_number" name="reference_number">
            </div>
            <div class="form-group">
              <label for="donation_amount">Donation Amount</label>
              <input type="number" step="0.01" class="form-control" id="donation_amount" name="donation_amount">
            </div>
          <button type="submit" class="btn btn-custom btn-lg">Submit Donation</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var c = document.getElementById('qrContainer');
  var lb = document.getElementById('qrLightbox');
  if (c && lb) {
    try { if (lb.parentElement !== document.body) document.body.appendChild(lb); } catch(e) {}
    function open(){ lb.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function close(){ lb.classList.remove('show'); document.body.style.overflow = ''; }
    c.addEventListener('click', open);
    var backBtn = lb.querySelector('.qr-back');
    if (backBtn) backBtn.addEventListener('click', close);
    lb.addEventListener('click', function(e){ if (e.target === lb) close(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') close(); });
  }
});
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container" id="admin-donations" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/schedule" class="admin-nav-item"><i class="fa fa-calendar"></i><span>Parish Schedule</span></a>
        <a href="/admin/services" class="admin-nav-item"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/donations" class="admin-nav-item active"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Donations</div>
        <div class="admin-actions">
          <a href="/admin" class="btn btn-login-secondary">← Back to Dashboard</a>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="panel panel-default" style="margin-bottom:16px;">
        <div class="panel-heading">Donation QR</div>
        <div class="panel-body">
          <form method="POST" action="/admin/donations/qr" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Upload QR Image</label><input type="file" name="qr_image" class="form-control" accept="image/*" required /></div>
            <button type="submit" class="btn btn-primary">Save QR</button>
          </form>
          @if(!empty($qrPath))
            <div style="margin-top:12px;">
              <img src="{{ $qrPath }}" alt="Donation QR" class="img-responsive" style="max-height:260px;" />
            </div>
          @endif
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
          <thead><tr><th>Name</th><th>Amount</th><th>Reference</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
          @forelse($items as $d)
            <tr>
              <td>{{ $d->name }}</td>
              <td>{{ $d->donation_amount ?? '-' }}</td>
              <td>{{ $d->reference_number ?? '-' }}</td>
              <td>{{ $d->status ?? 'pending' }}</td>
              <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#donationModal{{ $d->id }}">View</button>
                @if(empty($d->archived_at))
                <form method="POST" action="/admin/donations/{{ $d->id }}/archive" style="display:inline-block; margin-left:6px;">
                  @csrf
                  <button type="submit" class="btn btn-warning">Archive</button>
                </form>
                @else
                <form method="POST" action="/admin/donations/{{ $d->id }}/unarchive" style="display:inline-block; margin-left:6px;">
                  @csrf
                  <button type="submit" class="btn btn-success">Unarchive</button>
                </form>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5">No donations yet.</td></tr>
          @endforelse
          </tbody>
        </table>
          </div>
        </div>
      </div>
      @foreach($items as $d)
        <div class="modal fade" id="donationModal{{ $d->id }}" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Donation Details</h4></div>
              <div class="modal-body">
                <p><strong>Name:</strong> {{ $d->name }}</p>
                <p><strong>Contact:</strong> {{ $d->contact_number ?? '-' }}</p>
                <p><strong>Mode of Payment:</strong> {{ $d->mode_of_payment ?? '-' }}</p>
                <p><strong>Reference Number:</strong> {{ $d->reference_number ?? '-' }}</p>
                <p><strong>Amount:</strong> {{ $d->donation_amount ?? '-' }}</p>
                <p><strong>Status:</strong> {{ $d->status ?? 'pending' }}</p>
                @if(!empty($d->proof_of_payment_base64))
                  <div><strong>Proof of Payment:</strong><br><img src="data:image/png;base64,{{ $d->proof_of_payment_base64 }}" class="img-responsive" style="max-height:240px;" /></div>
                @endif
              </div>
              <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
            </div>
          </div>
        </div>
      @endforeach
      <div class="text-right" style="margin-top:8px;"><a href="/admin/donations/archive" class="btn btn-login-secondary">View Archive →</a></div>
    </main>
  </div>
</div>
@endsection

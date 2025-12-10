@extends('layouts.app')

@section('content')
<div class="container" id="admin-inquiries" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/services" class="admin-nav-item"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item active"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Inquiries</div>
        <div class="admin-actions">
          <a href="/admin" class="btn btn-login-secondary">← Back to Dashboard</a>
          <a href="/admin/inquiries/archive" class="btn btn-login-secondary">View Archive</a>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="panel panel-default">
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Actions</th></tr></thead>
          <tbody>
          @forelse($items as $q)
            <tr>
              <td>{{ $q->name }}</td>
              <td>{{ $q->email }}</td>
              <td>{{ Str::limit($q->message, 60) }}</td>
              <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#inqModal{{ $q->id }}">View</button>
                <form method="POST" action="/admin/inquiries/{{ $q->id }}/archive" style="display:inline-block; margin-left:6px;">
                  @csrf
                  <button type="submit" class="btn btn-warning">Archive</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="3">No inquiries yet.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
      </div>
    </main>
  </div>
</div>
@foreach($items as $q)
  <div class="modal fade" id="inqModal{{ $q->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Inquiry</h4></div>
        <div class="modal-body">
          <p><strong>Name:</strong> {{ $q->name }}</p>
          <p><strong>Email:</strong> {{ $q->email }}</p>
          <p><strong>Message:</strong><br>{{ $q->message }}</p>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
      </div>
    </div>
  </div>
@endforeach
@endsection

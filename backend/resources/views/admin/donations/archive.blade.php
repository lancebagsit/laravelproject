@extends('layouts.app')

@section('content')
<div class="container" id="admin-donations-archive" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/donations" class="admin-nav-item active"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Donations Archive</div>
        <div class="admin-actions">
          <a href="/admin/donations" class="btn btn-login-secondary">← Back to Donations</a>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead><tr><th>Name</th><th>Reference</th><th>Archived At</th><th>Archived By</th><th>Actions</th></tr></thead>
              <tbody>
                @forelse($items as $d)
                  <tr>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->reference_number ?? '-' }}</td>
                    <td>{{ $d->archived_at }}</td>
                    <td>{{ $d->archived_by }}</td>
                    <td>
                      <form method="POST" action="/admin/donations/{{ $d->id }}/unarchive" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success">Unarchive</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="5">No archived donations.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection


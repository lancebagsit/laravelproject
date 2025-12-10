@extends('layouts.app')

@section('content')
<div class="container" id="admin-services-archive" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/services" class="admin-nav-item active"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/schedule" class="admin-nav-item"><i class="fa fa-calendar"></i><span>Parish Schedule</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Services Archive</div>
        <div class="admin-actions">
          <a href="/admin/services" class="btn btn-login-secondary">← Back to Services</a>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Archived Services</div>
        <div class="panel-body">
          @forelse($items as $item)
            <div class="panel panel-info">
              <div class="panel-heading"><strong>Service</strong></div>
              <div class="panel-body">
                <p>{{ $item->text }}</p>
                @if($item->image1)
                  <img src="{{ $item->image1 }}" alt="Service" class="img-responsive" style="max-height:150px;" />
                @endif
                <form method="POST" action="/admin/services/{{ $item->id }}/unarchive" style="display:inline-block;">
                  @csrf
                  <button type="submit" class="btn btn-login-secondary">Unarchive</button>
                </form>
              </div>
            </div>
          @empty
            <p>No archived services.</p>
          @endforelse
        </div>
      </div>
    </main>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container" id="admin-search" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item active"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/schedule" class="admin-nav-item"><i class="fa fa-calendar"></i><span>Parish Schedule</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Search</div>
        <div class="admin-actions">
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="panel panel-default"><div class="panel-heading">Announcements</div><div class="panel-body">
        @forelse($announcements as $a)
          <div><strong>{{ $a->title }}</strong><br><small>{{ Str::limit($a->content, 120) }}</small></div>
        @empty
          <p>No matches.</p>
        @endforelse
      </div></div>

      <div class="panel panel-default"><div class="panel-heading">Priests</div><div class="panel-body">
        @forelse($priests as $p)
          <div><strong>{{ $p->name }}</strong><br><small>{{ Str::limit($p->description, 120) }}</small></div>
        @empty
          <p>No matches.</p>
        @endforelse
      </div></div>

      <div class="panel panel-default"><div class="panel-heading">Gallery</div><div class="panel-body">
        @forelse($gallery as $g)
          <div><strong>{{ $g->title }}</strong></div>
        @empty
          <p>No matches.</p>
        @endforelse
      </div></div>

      <div class="panel panel-default"><div class="panel-heading">Donations</div><div class="panel-body">
        @forelse($donations as $d)
          <div><strong>{{ $d->name }}</strong> — Ref: {{ $d->reference_number ?? '-' }}</div>
        @empty
          <p>No matches.</p>
        @endforelse
      </div></div>

      <div class="panel panel-default"><div class="panel-heading">Inquiries</div><div class="panel-body">
        @forelse($inquiries as $i)
          <div><strong>{{ $i->name }}</strong> — {{ $i->email }}<br><small>{{ Str::limit($i->message, 120) }}</small></div>
        @empty
          <p>No matches.</p>
        @endforelse
      </div></div>
    </main>
  </div>
</div>
@endsection

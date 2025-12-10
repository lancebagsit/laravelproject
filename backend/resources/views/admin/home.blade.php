@extends('layouts.app')

@section('content')
<div class="container" id="admin-dashboard" data-animate="animate__fadeInUp animate__delay-05s">
  @php($annCount = \App\Models\Announcement::count())
  @php($priCount = \App\Models\Priest::count())
  @php($galCount = \App\Models\GalleryItem::count())
  @php($donCount = \App\Models\Donation::count())
  @php($inqCount = \App\Models\ContactSubmission::count())

  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item active"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/services" class="admin-nav-item"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Home</div>
        <div class="admin-actions">
          <form class="admin-search" action="/admin/search" method="GET" style="display:inline-block; width:300px;">
            <input type="text" name="q" class="form-control" placeholder="Search anything" />
          </form>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="admin-stats">
        <div class="stat-card" data-animate="animate__zoomIn">
          <div class="stat-label">Announcements</div>
          <div class="stat-value">{{ $annCount }}</div>
        </div>
        <div class="stat-card" data-animate="animate__zoomIn">
          <div class="stat-label">Priests</div>
          <div class="stat-value">{{ $priCount }}</div>
        </div>
        <div class="stat-card" data-animate="animate__zoomIn">
          <div class="stat-label">Gallery Items</div>
          <div class="stat-value">{{ $galCount }}</div>
        </div>
        <div class="stat-card" data-animate="animate__zoomIn">
          <div class="stat-label">Donations</div>
          <div class="stat-value">{{ $donCount }}</div>
        </div>
        <div class="stat-card" data-animate="animate__zoomIn">
          <div class="stat-label">Inquiries</div>
          <div class="stat-value">{{ $inqCount }}</div>
        </div>
      </div>

      <div class="admin-grid">
        <div class="admin-card" data-animate="animate__fadeInUp">
          <div class="admin-card-header">
            <h4>Announcements</h4>
            <a href="/admin/announcements" class="btn btn-login-secondary">Manage</a>
          </div>
          <p>Post and update parish announcements.</p>
        </div>
        <div class="admin-card" data-animate="animate__fadeInUp">
          <div class="admin-card-header">
            <h4>Priests</h4>
            <a href="/admin/priest" class="btn btn-login-secondary">Manage</a>
          </div>
          <p>Maintain priest profiles and roles.</p>
        </div>
        <div class="admin-card" data-animate="animate__fadeInUp">
          <div class="admin-card-header">
            <h4>Gallery</h4>
            <a href="/admin/gallery" class="btn btn-login-secondary">Manage</a>
          </div>
          <p>Upload and curate parish images.</p>
        </div>
        <div class="admin-card" data-animate="animate__fadeInUp">
          <div class="admin-card-header">
            <h4>Donations</h4>
            <a href="/admin/donations" class="btn btn-login-secondary">View</a>
          </div>
          <p>Review recent donations and references.</p>
        </div>
        <div class="admin-card" data-animate="animate__fadeInUp">
          <div class="admin-card-header">
            <h4>Inquiries</h4>
            <a href="/admin/inquiries" class="btn btn-login-secondary">View</a>
            <a href="/admin/inquiries/archive" class="btn btn-login-secondary">View Archive</a>
          </div>
          <p>Read and reply to contact messages.</p>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection

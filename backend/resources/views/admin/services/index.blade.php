@extends('layouts.app')

@section('content')
<div class="container" id="admin-services" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
        <a href="/admin/services" class="admin-nav-item active"><i class="fa fa-cogs"></i><span>Services</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Services</div>
        <div class="admin-actions">
          <a href="/admin" class="btn btn-login-secondary">← Back to Dashboard</a>
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">Create / Edit</div>
            <div class="panel-body">
              <form method="POST" action="/admin/services" enctype="multipart/form-data">
                @csrf
                <div class="form-group"><label>Description</label><textarea name="text" class="form-control" rows="4" required minlength="5"></textarea></div>
                <div class="form-group"><label>Image</label><input type="file" name="image1" class="form-control" accept="image/*" required /></div>
                <button type="submit" class="btn btn-custom btn-lg">Save</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">Existing</div>
            <div class="panel-body">
              @forelse($items as $item)
                <div class="panel panel-info">
                  <div class="panel-heading"><strong>Service</strong></div>
                  <div class="panel-body">
                    <p>{{ $item->text }}</p>
                    @if($item->image1)
                      <img src="{{ $item->image1 }}" alt="Service" class="img-responsive" style="max-height:150px;" />
                    @endif
                    <form method="POST" action="/admin/services/{{ $item->id }}" style="margin-top:10px;" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group"><label>Description</label><textarea name="text" class="form-control" rows="3" required minlength="5">{{ $item->text }}</textarea></div>
                      <div class="form-group"><label>Replace Image</label><input type="file" name="image1" class="form-control" accept="image/*" /></div>
                      <button type="submit" class="btn btn-primary">Quick Update</button>
                    </form>
                    <form method="POST" action="/admin/services/{{ $item->id }}/delete" style="display:inline-block; margin-left:10px;">
                      @csrf
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              @empty
                <p>No services yet.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>
@endsection

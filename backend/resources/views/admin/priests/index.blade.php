@extends('layouts.app')

@section('content')
<div class="container" id="admin-priests" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item active"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/services" class="admin-nav-item"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Priests</div>
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
          <form method="POST" action="/admin/priest" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required minlength="5" /></div>
            <div class="form-group"><label>Image File</label><input type="file" name="image_file" class="form-control" accept="image/*" /></div>
            <div class="form-group"><label>Mass Time</label><input type="time" name="mass_time" class="form-control" required /></div>
            <div class="form-group"><label>Role</label>
              <select name="description" class="form-control" required>
                <option value="Parish Priest">Parish Priest</option>
                <option value="Assistant Priest">Assistant Priest</option>
              </select>
            </div>
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
              <div class="panel-heading"><strong>{{ $item->name }}</strong></div>
              <div class="panel-body">
                @if($item->image)
                  <img src="{{ $item->image }}" alt="{{ $item->name }}" class="img-responsive" style="max-height:150px;" />
                @endif
                <p>{{ $item->description }}</p>
                <form method="POST" action="/admin/priest/{{ $item->id }}" style="margin-top:10px;" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="name" value="{{ $item->name }}" />
                  <input type="hidden" name="image" value="{{ $item->image }}" />
                  <input type="hidden" name="description" value="{{ $item->description }}" />
                  <div class="form-group"><label>Replace Image (optional)</label><input type="file" name="image_file" class="form-control" accept="image/*" /></div>
                  <button type="submit" class="btn btn-primary">Quick Update</button>
                </form>
                <form method="POST" action="/admin/priest/{{ $item->id }}/delete" style="display:inline-block; margin-left:10px;">
                  @csrf
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          @empty
            <p>No entries yet.</p>
          @endforelse
        </div>
      </div>
    </div>
      </div>
    </main>
  </div>
</div>
@endsection

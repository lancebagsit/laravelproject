@extends('layouts.app')

@section('content')
<div class="container" id="admin-announcements" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="section-title text-center"><h2>Announcements</h2></div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Create / Edit</div>
        <div class="panel-body">
          <form method="POST" action="/admin/announcements">
            @csrf
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" required />
            </div>
            <div class="form-group">
              <label>Content</label>
              <textarea name="content" class="form-control" rows="5" required></textarea>
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
              <div class="panel-heading"><strong>{{ $item->title }}</strong></div>
              <div class="panel-body">
                <p>{{ $item->content }}</p>
                <form method="POST" action="/admin/announcements/{{ $item->id }}" style="margin-top:10px;">
                  @csrf
                  <input type="hidden" name="title" value="{{ $item->title }}" />
                  <input type="hidden" name="content" value="{{ $item->content }}" />
                  <button type="submit" class="btn btn-primary">Quick Update</button>
                </form>
                <form method="POST" action="/admin/announcements/{{ $item->id }}/delete" style="display:inline-block; margin-left:10px;">
                  @csrf
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </div>
          @empty
            <p>No announcements yet.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

